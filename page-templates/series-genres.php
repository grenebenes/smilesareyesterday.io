<?php
/**
 * Template Name: Series Genres Template
 *
 * Template for displaying series genre thumbnails with links to all series series with that genre.
 *
 * @package toocheke
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
get_header();
$home_layout = get_theme_mod('home_layout_setting', 'default');
$col = 'alt-2' === $home_layout ? 'col-lg-12' : 'col-lg-8';
?>

<div class="row">
               <!--START LEFT COL-->
               <div class="<?php echo esc_attr($col)?>">
                  <div id="left-col">
                     <div id="left-content">

			<section>
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e('Genres', 'toocheke');?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
                <?php
/**
 * Get latest six genres of series. If there are no genres or genres with no series, don't display.
 */
//setup paging
//Get total number of active genres
$total_args = array(
    'taxonomy' => 'genres',
);
$all_active_genres_list = get_categories($total_args);
$total_active_genres = count($all_active_genres_list);
//start paging
$genre_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$genres_per_page = 60;
$total_number_of_pages = ceil($total_active_genres / $genres_per_page);
$paged_offset = ($genre_paged - 1) * $genres_per_page;

//setup paginate args
$paginate_args = array(
    'taxonomy' => 'genres',
    'style' => 'none',
    'orderby' => 'title',
    'order' => 'ASC',
    'show_count' => 0,
    'number' => $genres_per_page,
    'paged' => $genre_paged,
    'offset' => $paged_offset,
);

$paged_genres_list = get_categories($paginate_args);

if ($paged_genres_list) {
    ?>
	<div class="row">

		<?php

    foreach ($paged_genres_list as $genre) {
        $genre_page_link = get_term_link($genre->slug, 'genres');

        printf(wp_kses_data('%1$s'), '<div class="col-md-3 genre-thumbnail">');
        printf(wp_kses_data('%1$s'), '<a href="' . esc_url($genre_page_link) . '">');
        $term_id = absint($genre->term_id);
        $thumb_id = get_term_meta($term_id, 'genre-image-id', true);

        if (!empty($thumb_id)) {
            $term_img = wp_get_attachment_url($thumb_id);
            printf(wp_kses_data('%1$s'), '<img src="' . esc_url($term_img) . '" /><br/>');
        }
        else {
            ?>
                                            <img
                                                src="<?php echo esc_attr(get_stylesheet_directory_uri()) . '/dist/img/default-thumbnail-image.png'; ?>" />
                                            <?php
        }
        echo wp_kses_data($genre->name);
        echo '</a></div>';

    }
// Reset Post Data
    wp_reset_postdata();

    ?>



	</div>
	<div class="row">
	<div class="col-md-12">
	<hr/>

   <!-- Start Pagination -->
   <?php
// Set up paginated links.
    $big = 999999999; // need an unlikely integer
    $links = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $total_number_of_pages,
        'prev_text' => wp_kses(__('<i class=\'fas fa-chevron-left\'></i>', 'toocheke'), array('i' => array('class' => array()))),
        'next_text' => wp_kses(__('<i class=\'fas fa-chevron-right\'></i>', 'toocheke'), array('i' => array('class' => array()))),
    ));

    if ($links):

    ?>

<div class="paginate-links">

            <?php echo wp_kses($links, array(
        'a' => array(
            'href' => array(),
            'class' => array(),
        ),
        'i' => array(
            'class' => array(),
        ),
        'span' => array(
            'class' => array(),
        ),
    )); ?>

		</div><!--/ .navigation -->
    <?php
endif;
    ?>
 <!-- End Pagination -->
	</div>
	</div>
	<?php
} //end if
?>
				</div><!-- .page-content -->
			</section>

		                 <!--END CONTENT-->
						 </div><!--./ left-content-->
                  </div><!--./ left-col-->
               </div><!--./ col-lg-8-->
               <!--END LEFT COL-->

<?php
get_sidebar();
get_footer();
