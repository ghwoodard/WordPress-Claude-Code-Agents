
# WordPress-Specific Prompt Engineering

Advanced prompt engineering techniques optimized for WordPress development with Claude Code. Based on proven patterns from enterprise WordPress projects and 15+ years of WordPress development expertise.

## 🎯 WordPress Prompt Architecture

### WordPress Context Hierarchy
```
WordPress Environment -> WordPress Standards -> WordPress Implementation
Project Context -> WordPress Requirements -> Specific WordPress Task
WordPress Security -> WordPress Performance -> WordPress Quality
```

### WordPress-Focused Instructions
Always structure WordPress prompts with these layers:

1. **WordPress Environment Context**: Version, multisite, hosting
2. **WordPress Project Context**: Theme/plugin, custom post types, integrations
3. **WordPress Standards**: WPCS, security, performance requirements
4. **WordPress Task Specifics**: Exact implementation requirements

## 🔒 WordPress Security Prompt Patterns

### Security-First WordPress Instructions
```markdown
## CRITICAL: WordPress Security Requirements (RULE 0)
Every WordPress implementation MUST include:
- Input sanitization using WordPress functions (sanitize_text_field, wp_kses)
- Output escaping using WordPress functions (esc_html, esc_attr, esc_url)
- Nonce verification for all form submissions
- Capability checks using current_user_can()
- SQL preparation using $wpdb->prepare()

FORBIDDEN: Direct $_POST, $_GET usage without sanitization (-$1000 penalty)
FORBIDDEN: Database queries without $wpdb->prepare() (-$2000 penalty)
```

### WordPress Security Validation Pattern
```markdown
Before implementing ANY WordPress functionality:
1. Identify all user inputs
2. Determine appropriate WordPress sanitization function
3. Identify all outputs to browser
4. Determine appropriate WordPress escaping function
5. Check if nonce verification is needed
6. Determine required WordPress capabilities
```

## ⚡ WordPress Performance Prompt Patterns

### Performance-Aware WordPress Instructions
```markdown
## CRITICAL: WordPress Performance Requirements
All WordPress code MUST:
- Limit database queries (no N+1 problems)
- Use WordPress caching (object cache, transients)
- Optimize WordPress queries (WP_Query best practices)
- Implement proper WordPress hook priorities
- Use conditional loading for admin/frontend code

WordPress Performance Penalties:
- N+1 query patterns: -$1000
- Missing caching on expensive operations: -$500
- Unbounded WordPress queries: -$1000
```

### WordPress Query Optimization Pattern
```markdown
WordPress Database Query Checklist:
1. Can this use get_posts() with caching?
2. Are we selecting only needed fields?
3. Is posts_per_page set appropriately?
4. Are we using update_post_meta_cache => false if not needed?
5. Can this be cached with WordPress transients?
6. Is this query running in a loop? (N+1 problem check)
```

## 🏗️ WordPress Architecture Prompt Patterns

### WordPress Component Decision Framework
```markdown
WordPress Architecture Decision Tree:
1. Is this theme-specific presentation? → Theme
2. Is this site-wide functionality? → Plugin
3. Is this network-wide multisite? → MU-Plugin
4. Is this content structure? → Custom Post Type/Taxonomy
5. Is this user-specific data? → User Meta
6. Is this post-specific data? → Post Meta
7. Is this site-wide settings? → Options API
8. Is this complex relational data? → Custom Tables (with justification)

WordPress File Location Decision:
- Theme: Presentation, template overrides, theme-specific functions
- Plugin: Core functionality, business logic, integrations
- MU-Plugin: Network-wide functionality, must-have features
```

### WordPress Standards Enforcement Pattern
```markdown
WordPress Coding Standards Enforcement:
BEFORE writing ANY WordPress code, verify:
- Function/class names properly prefixed
- WordPress naming conventions followed
- WordPress file structure conventions used
- WordPress hook naming patterns used
- WordPress translation functions used
- WordPress enqueueing for scripts/styles
- WordPress phpDoc documentation format

AUTOMATIC FAILURE triggers:
- Global variables without prefix
- Direct database queries
- Inline CSS/JavaScript
- Missing text domains
- Core WordPress file modifications
```

## 🧪 WordPress Testing Prompt Patterns

### WordPress Test-Driven Development
```markdown
WordPress TDD Protocol:
For every WordPress feature:
1. Write WordPress PHPUnit test first
2. Test WordPress security (nonces, capabilities, sanitization)
3. Test WordPress performance (query count, memory usage)
4. Test WordPress multisite compatibility (if applicable)
5. Test WordPress plugin conflicts (deactivate/reactivate)
6. Test WordPress theme switching compatibility

WordPress Test Categories Required:
- Unit Tests: Individual functions/methods
- Integration Tests: WordPress API interactions
- Security Tests: Input/output validation, capability checks
- Performance Tests: Query optimization, memory usage
- Compatibility Tests: Plugin/theme interactions
```

### WordPress Error Handling Pattern
```markdown
WordPress Error Handling Requirements:
EVERY WordPress operation that can fail MUST:
1. Check for WP_Error returns
2. Provide user-friendly error messages
3. Log errors for debugging (error_log in development)
4. Gracefully degrade functionality
5. Provide fallback options where possible

WordPress Error Pattern:
```php
$result = wp_insert_post( $post_data );
if ( is_wp_error( $result ) ) {
    error_log( 'Post creation failed: ' . $result->get_error_message() );
    wp_die( 'Unable to create post. Please try again.' );
}
```

## 🌐 WordPress Multisite Prompt Patterns

### WordPress Multisite Considerations
```markdown
WordPress Multisite Decision Framework:
For EVERY WordPress feature, consider:
1. Should this be network-wide or per-site?
2. Use get_site_option() vs get_option()?
3. Is blog switching needed?
4. Are network admin capabilities required?
5. How does this affect site creation/deletion?
6. Cross-site data access implications?

WordPress Multisite Code Pattern:
```php
// Network-wide settings
if ( is_multisite() ) {
    $option = get_site_option( 'my_network_option' );
} else {
    $option = get_option( 'my_single_site_option' );
}

// Blog switching for cross-site operations
if ( is_multisite() && $blog_id !== get_current_blog_id() ) {
    switch_to_blog( $blog_id );
    // Operations here
    restore_current_blog();
}
```

## 📝 WordPress Documentation Prompt Patterns

### WordPress phpDoc Requirements
```markdown
WordPress Documentation Standards:
EVERY WordPress function/class MUST include:
- @since WordPress version compatibility
- @param with WordPress-specific context
- @return with WordPress error possibilities  
- @throws for WordPress-specific exceptions
- WordPress hook documentation for actions/filters

WordPress phpDoc Example:
```php
/**
 * Save WordPress custom field with security validation.
 *
 * @since 1.0.0
 * 
 * @param int    $post_id WordPress post ID
 * @param string $key     Custom field key (sanitized)
 * @param mixed  $value   Field value (will be sanitized)
 * 
 * @return bool|WP_Error True on success, WP_Error on failure
 * 
 * @throws WP_Error If post doesn't exist or capability check fails
 */
```

## 🎛️ WordPress Hook System Prompt Patterns

### WordPress Hook Optimization
```markdown
WordPress Hook Usage Protocol:
1. Choose appropriate hook timing (init, wp_loaded, admin_init, etc.)
2. Set appropriate priority (default 10, earlier for dependencies)
3. Use conditional loading (is_admin(), is_frontend())
4. Remove hooks when no longer needed
5. Document hook interactions and dependencies

WordPress Hook Examples:
```php
// Frontend only
if ( ! is_admin() ) {
    add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );
}

// Admin only with high priority
if ( is_admin() ) {
    add_action( 'admin_init', 'my_admin_init', 5 );
}

// Conditional hook removal
if ( ! $feature_enabled ) {
    remove_action( 'wp_head', 'wp_generator' );
}
```

### WordPress Filter Implementation
```markdown
WordPress Filter Best Practices:
1. Always return the filtered value
2. Maintain the same data type
3. Add safeguards for unexpected input
4. Document filter parameters
5. Consider filter chain implications

WordPress Filter Pattern:
```php
/**
 * Filter product price display
 *
 * @param string $price_html Price HTML output
 * @param object $product    WordPress product object
 * @return string Modified price HTML
 */
function my_filter_price( $price_html, $product ) {
    // Validate inputs
    if ( ! is_string( $price_html ) || ! is_object( $product ) ) {
        return $price_html;
    }
    
    // Apply modifications
    $price_html = '<span class="custom-price">' . $price_html . '</span>';
    
    return $price_html;
}
add_filter( 'woocommerce_get_price_html', 'my_filter_price', 10, 2 );
```

## 🚀 WordPress Performance Optimization Patterns

### WordPress Caching Strategy Prompts
```markdown
WordPress Caching Implementation Protocol:
For EVERY expensive WordPress operation:
1. Identify if cacheable (static data, user-independent)
2. Choose appropriate WordPress cache type:
   - Object cache: wp_cache_set/get (in-memory)
   - Transients: set_transient/get_transient (persistent)
   - User meta: update_user_meta (user-specific)
   - Options API: update_option (site-wide settings)
3. Set appropriate expiration time
4. Implement cache invalidation strategy
5. Add cache warming if needed

WordPress Caching Example:
```php
function get_expensive_wordpress_data( $args ) {
    $cache_key = 'expensive_data_' . md5( serialize( $args ) );
    $data = wp_cache_get( $cache_key, 'my_plugin' );
    
    if ( false === $data ) {
        // Expensive operation here
        $data = perform_expensive_wordpress_query( $args );
        wp_cache_set( $cache_key, $data, 'my_plugin', HOUR_IN_SECONDS );
    }
    
    return $data;
}
```

## 🔄 WordPress Development Workflow Patterns

### WordPress Code Review Prompts
```markdown
WordPress Code Review Checklist:
BEFORE marking ANY WordPress code as complete:
1. Run phpcs --standard=WordPress
2. Run WordPress unit tests
3. Test with Query Monitor enabled
4. Verify with WordPress debug enabled
5. Test plugin deactivation/reactivation
6. Test theme switching
7. Test with common WordPress plugins active
8. Verify WordPress multisite compatibility (if applicable)

WordPress Quality Gates (ALL must pass):
- ✅ Zero WPCS violations
- ✅ Zero WordPress security warnings
- ✅ Performance within WordPress benchmarks
- ✅ All WordPress tests passing
- ✅ WordPress documentation complete
```

## 🎯 WordPress-Specific Prompt Examples

### WordPress Plugin Development Prompt
```markdown
Create a WordPress plugin for [functionality] with the following requirements:

WordPress Environment:
- WordPress Version: 6.4+
- PHP Version: 8.0+
- Multisite: Compatible
- Environment: Production-ready

WordPress Standards:
- Follow WordPress Coding Standards (WPCS) exactly
- Implement proper WordPress security (nonces, capabilities, sanitization)
- Optimize for WordPress performance (caching, query optimization)
- Support WordPress internationalization
- Include comprehensive WordPress testing

WordPress Implementation:
- Plugin structure following WordPress best practices
- WordPress hooks and filters with appropriate priorities
- WordPress database operations using WordPress APIs
- WordPress admin interface following WordPress UI guidelines
- WordPress REST API endpoints (if applicable)

WordPress Quality Assurance:
- Zero WPCS violations
- Zero security vulnerabilities
- Performance within WordPress benchmarks
- Full WordPress test coverage
- Complete WordPress documentation

CRITICAL: Use only WordPress-specific patterns and APIs. No generic PHP frameworks.
```

### WordPress Theme Development Prompt  
```markdown
Develop a WordPress theme for [purpose] following WordPress theme requirements:

WordPress Theme Requirements:
- WordPress Theme Review guidelines compliance
- Responsive design with WordPress best practices
- Accessibility (WCAG 2.1 AA compliance)
- WordPress Customizer integration
- WordPress block editor (Gutenberg) compatibility
- WordPress theme unit test data compatibility

WordPress Theme Structure:
- Required WordPress template files (style.css, index.php, functions.php)
- WordPress template hierarchy compliance
- WordPress theme hooks and filters
- WordPress enqueuing for all assets
- WordPress theme options using Customizer API
- WordPress navigation menus support

WordPress Performance:
- Optimized WordPress queries
- Proper WordPress asset loading
- WordPress image optimization support
- WordPress caching compatibility
- Minimal WordPress database queries

CRITICAL: This is a WordPress theme, not a generic web template. Use WordPress-specific approaches exclusively.
```

## 🎨 Advanced WordPress Prompt Techniques

### WordPress Progressive Disclosure Pattern
Start with WordPress basics, then add complexity:

```markdown
Step 1: Basic WordPress functionality
Step 2: Add WordPress security layer
Step 3: Add WordPress performance optimization
Step 4: Add WordPress multisite compatibility
Step 5: Add WordPress advanced features
```

### WordPress Error Prevention Through Examples
Instead of saying "don't do X", show correct WordPress patterns:

```php
// ❌ Don't show this
// Direct database access

// ✅ Show this
// WordPress API usage
$posts = get_posts( array(
    'numberposts' => 10,
    'post_type' => 'product',
    'meta_query' => array(
        array(
            'key' => 'featured',
            'value' => '1',
            'compare' => '='
        )
    )
) );
```

### WordPress Context-Aware Instructions
Adapt instructions based on WordPress environment:

```markdown
${is_multisite ? `
Use get_site_option() for network-wide settings
Check is_main_site() before network operations
Use switch_to_blog() for cross-site operations
` : `
Use get_option() for site settings
Standard single-site WordPress patterns apply
`}
```

## 📊 WordPress Prompt Success Metrics

Measure prompt effectiveness by:
- WordPress coding standards compliance (0 violations)
- WordPress security scan results (0 vulnerabilities)  
- WordPress performance benchmarks (< 100ms query time)
- WordPress test coverage (> 90%)
- WordPress compatibility (major plugins/themes)

## 🔧 WordPress Prompt Debugging

When WordPress prompts fail:
1. Check WordPress environment context provided
2. Verify WordPress standards are explicitly stated
3. Ensure WordPress-specific examples are used
4. Confirm WordPress error handling is included
5. Validate WordPress testing requirements are clear

## 🎭 WordPress Agent-Specific Prompts

### WordPress Architect Prompts
```markdown
"Use wp-architect to design a WordPress [feature] considering:
- Plugin vs theme architecture decision
- WordPress database design (meta vs custom tables)
- WordPress security architecture
- WordPress performance implications
- WordPress multisite compatibility
- WordPress hook system integration"
```

### WordPress Developer Prompts
```markdown
"Use wp-developer to implement WordPress [functionality] with:
- WordPress coding standards (WPCS) compliance
- WordPress security patterns (nonces, capabilities, sanitization)
- WordPress performance optimization (caching, query optimization)
- WordPress testing (PHPUnit with WP_UnitTestCase)
- WordPress documentation (phpDoc standards)"
```

### WordPress Debugger Prompts
```markdown
"Use wp-debugger to investigate WordPress [issue]:
- Enable WordPress debug mode temporarily
- Gather systematic WordPress evidence
- Use WordPress-specific debugging tools
- Analyze WordPress performance bottlenecks
- Provide WordPress-specific solution strategy"
```

### WordPress Quality Reviewer Prompts
```markdown
"Use wp-quality-reviewer to audit WordPress [code/feature] for:
- WordPress security vulnerabilities
- WordPress performance issues
- WordPress coding standards compliance
- WordPress plugin/theme compatibility
- WordPress multisite compatibility
- Production readiness assessment"
```

### WordPress Technical Writer Prompts
```markdown
"Use wp-technical-writer to document WordPress [implementation]:
- WordPress plugin/theme documentation
- WordPress phpDoc for all functions/classes
- WordPress hook/filter documentation
- WordPress installation and setup guides
- WordPress developer API reference"
```

## 🎯 WordPress Prompt Templates

### WordPress Feature Request Template
```markdown
WordPress Feature: [Feature Name]

WordPress Context:
- WordPress Version: [version]
- Plugin/Theme: [context]
- Multisite: [yes/no]

WordPress Requirements:
- Security: [WordPress security requirements]
- Performance: [WordPress performance requirements]
- Standards: [WordPress coding standards]
- Testing: [WordPress testing requirements]

WordPress Implementation:
- Architecture: [plugin/theme/core decision]
- Database: [meta/options/custom tables]
- Hooks: [actions/filters needed]
- API: [REST/GraphQL endpoints if needed]

WordPress Quality Assurance:
- WPCS compliance required
- Security scan must pass
- Performance benchmarks must be met
- WordPress tests required (>90% coverage)
```

### WordPress Bug Report Template
```markdown
WordPress Bug Report: [Issue Description]

WordPress Environment:
- WordPress Version: [version]
- PHP Version: [version]
- Active Plugins: [relevant plugins]
- Active Theme: [theme]
- Multisite: [yes/no]

WordPress Error Details:
- Error Message: [exact error]
- WordPress Debug Log: [relevant entries]
- Steps to Reproduce: [WordPress-specific steps]
- Expected Behavior: [WordPress expected behavior]

WordPress Investigation Required:
- Plugin conflict testing
- Theme conflict testing
- WordPress debug mode analysis
- Database query analysis
- WordPress hook system debugging
```

## ⚡ WordPress Performance Prompts

### WordPress Query Optimization Prompt
```markdown
"Optimize this WordPress query for performance:

Current Implementation:
[paste WordPress query code]

WordPress Performance Requirements:
- Query time < 100ms
- Memory usage < 50MB
- Support for 10,000+ posts
- WordPress object cache integration
- N+1 query elimination

WordPress Optimization Techniques to Consider:
- WP_Query parameter optimization
- WordPress meta query optimization
- WordPress taxonomy query optimization
- WordPress caching strategies
- Database index recommendations"
```

### WordPress Caching Implementation Prompt
```markdown
"Implement WordPress caching for this expensive operation:

WordPress Operation:
[describe expensive WordPress operation]

WordPress Caching Requirements:
- Use WordPress object cache
- Implement cache invalidation
- Support cache warming
- Handle cache failures gracefully
- WordPress multisite compatible

WordPress Cache Strategy:
- Cache key naming convention
- Cache expiration time
- Cache group organization
- Cache invalidation triggers"
```

## 🔒 WordPress Security Prompts

### WordPress Security Audit Prompt
```markdown
"Perform WordPress security audit on this code:

WordPress Security Checklist:
- Input sanitization verification
- Output escaping validation
- Nonce verification checks
- Capability check validation
- SQL injection prevention
- File upload security
- WordPress core security best practices

WordPress Security Standards:
- WordPress VIP Go standards
- OWASP security guidelines
- WordPress Plugin Review guidelines
- WordPress Theme Review security requirements"
```

### WordPress Security Implementation Prompt
```markdown
"Implement WordPress security for this feature:

WordPress Security Requirements:
- All user inputs must be sanitized
- All outputs must be escaped
- Form submissions require nonces
- Admin functions require capability checks
- Database queries must use $wpdb->prepare()
- File operations must validate file types

WordPress Security Patterns:
- Use WordPress sanitization functions
- Use WordPress escaping functions
- Implement WordPress nonce system
- Use WordPress capability system
- Follow WordPress file security practices"
```

## 🌟 WordPress Best Practices Prompts

### WordPress Code Review Prompt
```markdown
"Review this WordPress code for best practices:

WordPress Review Criteria:
- WordPress Coding Standards (WPCS) compliance
- WordPress security best practices
- WordPress performance optimization
- WordPress multisite compatibility
- WordPress plugin/theme guidelines
- WordPress accessibility standards

WordPress Quality Metrics:
- Zero WPCS violations
- Zero security vulnerabilities
- Performance within benchmarks
- Complete WordPress documentation
- Comprehensive test coverage"
```

### WordPress Migration Prompt
```markdown
"Plan WordPress migration from [source] to [destination]:

WordPress Migration Requirements:
- Zero downtime migration
- Data integrity verification
- URL structure preservation
- WordPress multisite considerations
- Plugin/theme compatibility
- Performance optimization

WordPress Migration Strategy:
- Pre-migration testing
- Database migration approach
- File migration strategy
- DNS cutover plan
- Post-migration validation
- Rollback procedures"
```

Remember: WordPress development is unique. Generic web development patterns don't apply. Always use WordPress-specific APIs, patterns, and best practices in your prompts for optimal results with WordPress Claude agents.
