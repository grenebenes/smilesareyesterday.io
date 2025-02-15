<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */

get_header();
$series_order = get_option('toocheke-series-order') ? get_option('toocheke-series-order') : 'DESC';

?>

<div class="row">
               <!--START LEFT COL-->
               <div class="col-lg-8">
                  <div id="left-col">
                     <div id="left-content">
                     <header class="page-header">
            <?php
the_archive_title('<h1 class="page-title">', '</h1>');

?>
      </header><!-- .page-header -->
<?php
if (post_type_exists('series')):
    /**
     * Setup query to show ALL ‘series’ posts
     * Output is thumbnail
     */
    $series_args = array(
        'post_type' => 'series',
        'post_status' => 'publish',
        'nopaging' => true,
        'orderby' => 'title',
        'order' => $series_order,
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
				                            <img
				                                src="<?php echo esc_attr(get_stylesheet_directory_uri()) . '/dist/img/default-thumbnail-image.png'; ?>" />
				                            <?php
        }
        ?>
				                        </a>
				                        <div class="series-rollover">
				                            <a class="series-link" href='<?php echo esc_url(get_permalink($post)); ?>'>
				                                <?php esc_html(the_title('<h3>', '</h3>'));?>
				                                <?php echo esc_html(get_the_excerpt()); ?>
				                            </a>


				                        </div>
				                    </span>
				                    <?php
    endwhile;
    $series_query = null;
    wp_reset_postdata();
    ?>
		                </div>
		                <!--.series-grid-->
		                <?php
endif;
?>
                <?php
endif;
?>

		                         <!--END CONTENT-->
								 </div><!--./ left-content-->
                  </div><!--./ left-col-->
               </div><!--./ col-lg-8-->
               <!--END LEFT COL-->

<?php
get_sidebar();
get_footer();
