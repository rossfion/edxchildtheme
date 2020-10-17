<?php
/**
 * The template for displaying the 404 template in the Twenty Twenty theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */
get_header();
?>

<main id="site-content" role="main">

    <figure class="featured-media error404-media">
        <div class="featured-media-inner section-inner thin">
            <img src="<?php echo get_stylesheet_directory_uri(); // phpcs:ignore  ?>/img/404-error.png" />
        </div>
    </figure>

    <header class="section-inner error404-content">
        <h1 class="entry-title"><?php esc_html_e( 'Oops! Page Not Found', 'edxchildtheme' ); ?></h1>
    </header>

    <div class="section-inner thin error404-content">

        <div class="intro-text"><p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or do a search?', 'edxchildtheme' ); ?></p></div>

        <?php
        get_search_form(
                array(
                    'label' => __( '404 not found', 'twentytwenty' ),
                )
        );
        ?>

    </div><!-- .section-inner -->

    <div class="section-inner error404-widgets">
        <?php
        // Display Recent Posts Widget.
        the_widget( 'WP_Widget_Recent_Posts' );

        // Display Categories Widget if site has multiple categories.
        if (count(get_categories()) > 2) :
            ?>

            <div class="widget widget_categories">
                <h2 class="widgettitle"><?php esc_html_e( 'Most Used Categories', 'k2k' ); ?></h2>
                <ul>
                    <?php
                    wp_list_categories(
                            array(
                                'orderby' => 'count',
                                'order' => 'DESC',
                                'show_count' => 1,
                                'title_li' => '',
                                'number' => 10,
                            )
                    );
                    ?>
                </ul>
            </div>

            <?php
        endif;

        /* translators: %1$s: smiley */
        $archive_content = '<p>' . sprintf(esc_html__( 'Try looking in the monthly archives. %1$s', 'edxchildtheme' ), convert_smilies( ':)' ) ) . '</p>';

        // Display Archives Widget.
        the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

        // Display Tag Cloud Widget.
        the_widget( 'WP_Widget_Tag_Cloud' );
        ?>
    </div>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php
get_footer();
