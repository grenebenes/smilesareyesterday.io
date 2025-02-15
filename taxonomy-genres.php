<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */

get_header();
$home_layout = get_theme_mod('home_layout_setting', 'default');
$col = 'alt-2' === $home_layout ? 'col-lg-12' : 'col-lg-8';
$genre = null !== get_query_var('genres') ? get_query_var('genres') : '';
?>
<div class="row">
               <!--START LEFT COL-->
               <div class="<?php echo esc_attr($col)?>">
                  <div id="left-col">
                     <div id="left-content">
                     <!--start content-->
                     <?php if (have_posts()): ?>
                        <header class="page-header">
				<?php
the_archive_title('<h1 class="page-title">', '</h1>');
the_archive_description('<div class="archive-description">', '</div>');
?>
			</header><!-- .page-header -->
            <hr class="toocheke-hr"/>
            <?php
if (post_type_exists('series')):
    /**
     * Setup query to show ALL ‘series’ posts
     * Output is thumbnail
     */
    $series_args = array(
        'post_type' => 'series',
        'tax_query' => array(
            array(
                'taxonomy' => 'genres',
                'field' => 'slug',
                'terms' => $genre,
            ),
        ),
        'post_status' => 'publish',
        'nopaging' => true,
        'orderby' => 'title',
    );
    $series_query = new WP_Query($series_args);
    if ($series_query->have_posts()):
    ?>
				                    <div id="series-grid">
				                    <?php
    while ($series_query->have_posts()): $series_query->the_post();
        ?>
								                        <span class="series-thumbnail-wrapper">
								                            <a class="series-thumbnail">
								                            <?php
        if (has_post_thumbnail()) {
            the_post_thumbnail('medium');
        } else {
            ?>
								                            <img src="<?php echo esc_attr(get_stylesheet_directory_uri()) . '/dist/img/default-thumbnail-image.png'; ?>" />
								                            <?php
        }
        ?>
								                            </a>
								                            <div class="series-rollover">
								                                <a class="series-link" href="<?php echo esc_url(get_permalink($post)); ?>">
								                                <?php the_title('<h3>', '</h3>');?>
								                                <?php the_excerpt();?>
								            </a>


												</div>
								                        </span>
								                     <?php
    endwhile;
    $series_query = null;
    wp_reset_postdata();
    ?>
				                    </div><!--.series-grid-->
				                    <?php
endif;
?>
                <?php
endif;
?>

<?php

else:

    get_template_part('template-parts/content', 'none');

endif;
?>
                     <!--end content-->
                     </div><!--./ left-content-->
                  </div><!--./ left-col-->
               </div><!--./ col-lg-8-->
               <!--END LEFT COL-->
                     <?php
get_sidebar();
get_footer();
