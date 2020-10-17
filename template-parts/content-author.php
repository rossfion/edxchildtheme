<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */
?>

<li <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php
        get_template_part( 'template-parts/entry-header' );

            if (!is_search()) {
                get_template_part( 'template-parts/featured-image' );
        }
    ?>

    <div class="section-inner">
        <?php edit_post_link(); ?>	
    </div>


</li><!-- #post -->
