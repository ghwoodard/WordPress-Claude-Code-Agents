<?php
/**
 * Pin specific posts to the top of a Query Loop block.
 *
 * Targets the Query Loop block whose "Loop ID" (block `namespace` attribute)
 * is "shdur-news-grid" and forces post IDs 2972 and 3066 to appear as the
 * first two items, in that order, on every render of that loop on the front end.
 *
 * Add this snippet to your theme's `functions.php`.
 *
 * Note: The Query Loop block's "Loop ID" is stored as the `namespace`
 * block attribute (used by custom Query Loop variations). If your loop
 * identifies itself via the block's anchor/HTML ID instead, change the
 * comparison below to read from `$attrs['anchor']`.
 *
 * @package SHDUR
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register filters that pin posts 2972 and 3066 to the "shdur-news-grid" loop.
 */
add_action(
	'init',
	static function (): void {

		$loop_id    = 'shdur-news-grid';
		$pinned_ids = array( 2972, 3066 );
		$is_target  = false;

		/**
		 * Modify the WP_Query vars for the targeted Query Loop block.
		 *
		 * - Excludes the pinned IDs so they don't appear twice.
		 * - Reduces `posts_per_page` to make room for the pinned posts.
		 * - Flags the query so `the_posts` knows to prepend the pinned posts.
		 *
		 * @param array     $query The query vars to be passed to WP_Query.
		 * @param \WP_Block $block The parsed block instance being rendered.
		 * @return array Modified query vars.
		 */
		add_filter(
			'query_loop_block_query_vars',
			static function ( array $query, $block ) use ( $loop_id, $pinned_ids, &$is_target ): array {

				$attrs = isset( $block->parsed_block['attrs'] ) && is_array( $block->parsed_block['attrs'] )
					? $block->parsed_block['attrs']
					: array();

				if ( empty( $attrs['namespace'] ) || $loop_id !== $attrs['namespace'] ) {
					return $query;
				}

				$existing_exclude       = isset( $query['post__not_in'] ) ? (array) $query['post__not_in'] : array();
				$query['post__not_in']  = array_values( array_unique( array_map( 'absint', array_merge( $existing_exclude, $pinned_ids ) ) ) );

				if ( ! empty( $query['posts_per_page'] ) && (int) $query['posts_per_page'] > 0 ) {
					$query['posts_per_page'] = max( 1, (int) $query['posts_per_page'] - count( $pinned_ids ) );
				}

				$is_target = true;

				return $query;
			},
			10,
			2
		);

		/**
		 * Prepend the pinned posts to the targeted Query Loop's results.
		 *
		 * Runs on every query but only alters posts when the flag set by
		 * `query_loop_block_query_vars` is active, then immediately clears it.
		 *
		 * @param \WP_Post[] $posts Array of post objects returned by the query.
		 * @return \WP_Post[] Modified post array with pinned posts at the top.
		 */
		add_filter(
			'the_posts',
			static function ( $posts ) use ( $pinned_ids, &$is_target ) {

				if ( ! $is_target ) {
					return $posts;
				}

				$is_target = false;

				$pinned = array();

				foreach ( $pinned_ids as $pinned_id ) {
					$pinned_post = get_post( $pinned_id );

					if ( $pinned_post instanceof WP_Post && 'publish' === $pinned_post->post_status ) {
						$pinned[] = $pinned_post;
					}
				}

				return array_merge( $pinned, is_array( $posts ) ? $posts : array() );
			},
			10,
			1
		);
	}
);
