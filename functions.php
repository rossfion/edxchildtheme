<?php
/**
 * EdxChildTheme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage EdxChildTheme
 * @since 1.0
 */

/**
 * Register and Enqueue Styles.
 */
//add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function edxchildtheme_enqueue_styles() {

    $parenthandle = 'twentytwenty-style'; // This is 'twentytwenty-style' for the Twenty Twenty theme.
    //$theme = wp_get_theme();

    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', '20201003', 'all' );
    wp_enqueue_style(
            'edxchildtheme-style',
            get_stylesheet_directory_uri() . '/style.css',
            array( $parenthandle ), // if the parent theme code has a dependency, copy it to here
            //$theme->parent()->get( 'Version' )
            filemtime( get_stylesheet_directory() . '/style.css' )
    );
    /*    wp_enqueue_style( 'edxchildtheme-style', get_stylesheet_uri(),
      array( $parenthandle ),
      $theme->get( 'Version' ) // this only works if you have Version in the style header
      );
     */
    // Serif font
    wp_enqueue_style(
            'edxchildtheme-serif-font', 'https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap',
            array(),
            '20200927',
            'all'
    );
    // FontAwesome
    wp_enqueue_style(
            'edxchildtheme-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css',
            array(),
            '20200927',
            'all'
    );

    // Add Custom JavaScript for top-menu
    wp_enqueue_script(
            'edxchildtheme-top-menu',
            get_stylesheet_directory_uri() . '/js/top-menu.js',
            array(),
            '20200927',
            true
    );
}

add_action( 'wp_enqueue_scripts', 'edxchildtheme_enqueue_styles' );

/**
 * Logo & Description
 */

/**
 * Displays the site logo, either text or image.
 *
 * @param array   $args Arguments for displaying the site logo either as an image or text.
 * @param boolean $echo Echo or return the HTML.
 * @return string Compiled HTML based on our arguments.
 */
function edxchildtheme_site_logo( $args = array(), $echo = true ) {
    $logo = get_custom_logo();
    $site_title = get_bloginfo( 'name' );
    $contents = '';
    $classname = '';

    $defaults = array(
        'logo' => '%1$s<h1 class="site-title">%2$s</h1>',
        'logo_class' => 'site-logo',
        'title' => '<a href="%1$s">%2$s</a>',
        'title_class' => 'site-title',
        'home_wrap' => '<h1 class="%1$s">%2$s</h1>',
        'single_wrap' => '<div class="%1$s faux-heading">%2$s</div>',
        'condition' => ( is_front_page() || is_home() ) && !is_page(),
    );

    $args = wp_parse_args( $args, $defaults );

    /**
     * Filters the arguments for `twentytwenty_site_logo()`.
     *
     * @param array  $args     Parsed arguments.
     * @param array  $defaults Function's default arguments.
     */
    $args = apply_filters( 'twentytwenty_site_logo_args', $args, $defaults );

    if (has_custom_logo()) {
        $contents = sprintf( $args['logo'], $logo, esc_html( $site_title ) );
        $classname = $args['logo_class'];
    } else {
        $contents = sprintf( $args['title'], esc_url( get_home_url( null, '/' ) ), esc_html( $site_title ) );
        $classname = $args['title_class'];
    }

    // $wrap = $args['condition'] ? 'home_wrap' : 'single_wrap';
    $wrap = 'home_wrap';

    $html = sprintf( $args[$wrap], $classname, $contents );

    /**
     * Filters the arguments for `twentytwenty_site_logo()`.
     *
     * @param string $html      Compiled HTML based on our arguments.
     * @param array  $args      Parsed arguments.
     * @param string $classname Class name based on current view, home or single.
     * @param string $contents  HTML for site title or logo.
     */
    $html = apply_filters( 'twentytwenty_site_logo', $html, $args, $classname, $contents );

    if ( !$echo ) {
        return $html;
    }

    echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * WordPress Filter example (Title).
 *
 * @param string $title The title of the post.
 * @param int....$id The post id
 */
function edxchildtheme_filter_the_title( $title, $id = null ) {
    if ( in_category( 'block', $id ) ) {
        return '<i class="post-title-icon fas fa-dice-d6" title="Block Editor Post"></i> ' . $title;
    }

    if (in_category('classic', $id)) {
        return '<i class="post-title-icon fas fa-file-alt" title="Classic Editor Post"></i> ' . $title;
    }
    return $title;
}

add_filter( 'the_title', 'edxchildtheme_filter_the_title', 10, 2 );
add_filter( 'single_cat_title', 'edxchildtheme_filter_the_title' );

/**
 * WordPress Filter for Excerpt Length.
 *
 * @param int $length The length of the excerpt.
 */
function edxchildtheme_filter_excerpt_length( $length ) {
    return 20;
}

add_filter( 'excerpt_length', 'edxchildtheme_filter_excerpt_length', 999 );

/**
 * WordPress Filter for Read More Link.
 *
 */
function edxchildtheme_filter_excerpt_more( $more ) {
    return '&hellip; <a href="' . get_the_permalink() . '">[read more]</a>';
}

add_filter( 'excerpt_more', 'edxchildtheme_filter_excerpt_more' );

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function edxchild_register_sidebar_widgets() {

    // Arguments used in all register_sidebar() calls.
    $shared_args = array(
        'before_title' => '<h2 class="widget-title subheading heading-size-3">',
        'after_title' => '</h2>',
        'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
        'after_widget' => '</div></div>',
    );

    // Sidebar widgets.
    register_sidebar(
            array_merge(
                    $shared_args,
                    array(
                        'name' => __( 'Sidebar', 'edxchildtheme' ),
                        'id' => 'sidebar-edxchildtheme',
                        'description' => __( 'Widgets in this area will be displayed in the expanded / mobile menu.', 'edxchildtheme' ),
                    )
            )
    );
}

add_action( 'widgets_init', 'edxchild_register_sidebar_widgets' );

/**
 * Register a new Colophon menu.
 */
function edxchildtheme_register_colophon_menu() {
    register_nav_menu( 'colophon', __( 'Colophon Menu', 'edxchildtheme' ) );
}

add_action( 'after_setup_theme', 'edxchildtheme_register_colophon_menu' );

/**
 * Funtion to calculate reading time.
 */
function edxchildtheme_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $count = str_word_count( wp_strip_all_tags( $content ) );
    $time = $count / 250; // Approx 250 words per min reading time.
    $min = floor( $time % 60 ); // left of decimal $time.
    $sec = $time - ( int ) $time; // right of decimal $time.
    $sec = round( $sec * 60 );  // Convert decimal min (0.296) to seconds.
    $sec = $sec < 10 ? ( '0' . $sec ) : $sec; // 4:9 -> 4:09.

    return $min . ':' . $sec;
}

/**
 * Add reading time to post meta.
 */
function edxchildtheme_add_reading_time() {

    static $meta_location = 'single-top';

    if ( 'single-top' === $meta_location ) {
        ?>

        <li class="post-reading-time meta-wrapper">
            <span class="meta-icon">
                <span class="screen-reader-text"><?php esc_html_e( 'Reading Time', 'edxchildtheme' ); ?></span>
                <i class="far fa-clock"></i>
            </span>
            <span class="meta-text">
        <?php printf( __( '%s Reading time', 'edxchildtheme' ), edxchildtheme_reading_time() ); // phpcs:ignore  ?>
            </span>
        </li>

        <?php
        $meta_location = 'single-bottom';
    } else {
        $meta_location = 'single-top';
    }
}

add_action( 'twentytwenty_start_of_post_meta_list', 'edxchildtheme_add_reading_time', 10, 1 );

/**
 * Filter to remove author from top post meta.
 */
function edxchildtheme_remove_author_post_meta() {
    // Remove 'author' from the post_meta array.
    return array(
        'post-date',
        'comments',
        'sticky',
    );
}

add_filter( 'twentytwenty_post_meta_location_single_top', 'edxchildtheme_remove_author_post_meta' );

/**
 * Filter to add categories to bottom post meta.
 *
 * @param array $post_meta The $post_meta array.
 */
function edxchildtheme_add_bottom_post_meta( $post_meta ) {
    $add_meta = array(
        'categories',
    );
    return array_merge( $post_meta, $add_meta );
}

add_filter( 'twentytwenty_post_meta_location_single_bottom', 'edxchildtheme_add_bottom_post_meta' );
