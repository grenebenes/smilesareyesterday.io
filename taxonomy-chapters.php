<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */
$series_id = null;
$series_id = isset($_GET['sid']) ? (int) $_GET['sid'] : null;
$comic_order = get_option('toocheke-comics-order') ? get_option('toocheke-comics-order') : 'DESC';
get_header();
$comics_paged = isset($_GET['comics_paged']) ? (int) $_GET['comics_paged'] : 1;
$chapter = null !== get_query_var('chapters') ? get_query_var('chapters') : '';
?>

<div class="row">
               <!--START LEFT COL-->
               <div class="col-lg-8">
                  <div id="left-col">
                     <div id="left-content">
		<?php if (have_posts()): ?>

			<header class="page-header">
				<?php
the_archive_title('<h1 class="page-title">', '</h1>');
?>
<div class="row">
    <div class="col-md-4">
    <?php
$term_id = get_queried_object()->term_id;
//$term_id = absint($character->term_id);
$thumb_id = get_term_meta($term_id, 'chapter-image-id', true);
if (!empty($thumb_id)) {
    $term_img = wp_get_attachment_url($thumb_id);
    printf(wp_kses_data('%1$s'), '<img class="img-fluid" src="' . esc_url($term_img) . '" />');
} else {
    ?>
                                        <img
                                            src="<?php echo esc_attr(get_stylesheet_directory_uri()) . '/dist/img/default-thumbnail-image.png'; ?>" />
                                        <?php
}
?>
    </div>
    <div class="col-md-8">
    <?php
the_archive_description('<div class="archive-description">', '</div>');
?>
        </div>
</div>
			</header><!-- .page-header -->
            <hr class="toocheke-hr"/>
            <ul id="comic-list">
			<?php
$comics_args = array(
    'post_parent' => $series_id,
    'post_type' => 'comic',
    'tax_query' => array(
        array(
            'taxonomy' => 'chapters',
            'field' => 'slug',
            'terms' => $chapter,
        ),
    ),
    'post_status' => 'publish',
    'posts_per_page' => 10,
    'paged' => $comics_paged,
    'orderby' => 'post_date',
    'order' => $comic_order,
);

$comics_query = new WP_Query($comics_args);
/* Start the Loop */
while ($comics_query->have_posts()): $comics_query->the_post();

    /*
     * Include the Post-Type-specific template for the content.
     * If you want to override this in a child theme, then include a file
     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
     */
    set_query_var('latest_collection_id', 0);
    if (!$series_id) {
        set_query_var('show_comic_number', true);
        set_query_var('series_id', null);
    } else {
        set_query_var('series_id', $series_id);
    }
    get_template_part('template-parts/content', 'comiclistitem');

endwhile;
?>
            </ul>

            <!-- Start Pagination -->
			 <?php
// Set up paginated links.
$links = paginate_links(array(
    'format' => '?comics_paged=%#%',
    'current' => $comics_paged,
    'total' => $comics_query->max_num_pages,
    'prev_text' => wp_kses(__('<i class=\'fas fa-chevron-left\'></i>', 'toocheke'), array('i' => array('class' => array()))),
    'next_text' => wp_kses(__('<i class=\'fas fa-chevron-right\'></i>', 'toocheke'), array('i' => array('class' => array()))),
));

if ($links):

?>

<nav class="pagination">

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

    </nav><!--/ .navigation -->
    <?php
endif;
?>
 <!-- End Pagination -->
<?php

else:

    get_template_part('template-parts/content', 'none');

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
