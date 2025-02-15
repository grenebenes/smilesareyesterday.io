<?php
/**
 * Template Name: Comic Chapters Template
 *
 * Template for displaying comic chapter thumbnails with links to the first comic in the chapter.
 *
 * @package toocheke
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
get_header();
$home_layout = get_theme_mod('home_layout_setting', 'default');
$col = 'alt-2' === $home_layout ? 'col-lg-12' : 'col-lg-8';
$comic_order = get_option('toocheke-chapter-first-comic') ? get_option('toocheke-chapter-first-comic') : 'DESC';
$series_id = null;
$series_id = isset($_GET['sid']) ? (int) $_GET['sid'] : null;
$chapter_comic_order = get_option('toocheke-chapter-first-comic') ? get_option('toocheke-chapter-first-comic') : 'ASC';
?>

<div class="row">
               <!--START LEFT COL-->
               <div class="<?php echo esc_attr($col) ?>">
                  <div id="left-col">
                     <div id="left-content">

			<section>
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e('Chapters', 'toocheke');?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
                <?php
/**
 * Get latest six chapters of comics. If there are no chapters or chapters with no comics, don't display.
 */
//setup paging
//Get total number of chapters
$comic_ids = [];
$comics_args = array(
    'fields' => 'ids',
    'post_parent' => $series_id,
    'nopaging' => true,
    'post_type' => 'comic',

);
$comics_query = new WP_Query($comics_args);
if ($comics_query->have_posts()):
    while ($comics_query->have_posts()): $comics_query->the_post();
        $comic_ids[] = get_the_ID();
    endwhile;
    wp_reset_postdata();

endif;

$all_chapters_args = array(
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'chapter-order',
            'type' => 'NUMERIC',
        )),
);
$chapters = wp_get_object_terms($comic_ids, 'chapters', $all_chapters_args);
if (!empty($chapters)) {
    if (!is_wp_error($chapters)) {
        /*
        foreach( $chapters as $chapter ) {
        ?><pre><?php var_dump($chapter); ?></pre><?php
        }
         */
        $total_active_chapters = count($chapters);
    }
}

//start paging
$chapter_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$chapters_per_page = 60;
$total_number_of_pages = ceil($total_active_chapters / $chapters_per_page);
$paged_offset = ($chapter_paged - 1) * $chapters_per_page;
$chapters = array_slice($chapters, $paged_offset, $chapters_per_page);

if ($chapters) {
    ?>
	<div class="row">

		<?php

    foreach ($chapters as $chapter) {

        /**
         * Get latest post for this chapter
         */
        $link_to_first_comic = '';
        $args = array(
            'posts_per_page' => 1,
            'post_parent' => $series_id,
            'post_type' => 'comic',
            'orderby' => 'post_date',
            'order' => $comic_order,
            "tax_query" => array(
                array(
                    'taxonomy' => "chapters", // use the $tax you define at the top of your script
                    'field' => 'term_id',
                    'terms' => $chapter->term_id, // use the current term in your foreach loop
                ),
            ),
            'no_found_rows' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        );
        $first_comic_query = new WP_Query($args);
        // The Loop
        while ($first_comic_query->have_posts()): $first_comic_query->the_post();
            $link_to_first_comic = add_query_arg('sid', $series_id, get_post_permalink()); // Display the image of the first post in category
            wp_reset_postdata();
            printf(wp_kses_data('%1$s'), '<div class="col-md-3 chapter-thumbnail">');
            printf(wp_kses_data('%1$s'), '<a href="' . esc_url($link_to_first_comic) . '">');
            $term_id = absint($chapter->term_id);
            $thumb_id = get_term_meta($term_id, 'chapter-image-id', true);

            if (!empty($thumb_id)) {
                $term_img = wp_get_attachment_url($thumb_id);
                printf(wp_kses_data('%1$s'), '<img src="' . esc_url($term_img) . '" /><br/>');
            } else {
                ?>
	                                                <img
	                                                    src="<?php echo esc_attr(get_stylesheet_directory_uri()) . '/dist/img/default-thumbnail-image.png'; ?>" />
	                                                <?php
    }
            echo wp_kses_data($chapter->name);
            echo '</a></div>';
        endwhile;

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
