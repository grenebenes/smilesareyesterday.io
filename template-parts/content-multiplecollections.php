<?php
/**
 * Template part for displaying single comic collection
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */

$comic_order = get_option('toocheke-comics-order') ? get_option('toocheke-comics-order') : 'DESC';
$series_order = get_option('toocheke-series-order') ? get_option('toocheke-series-order') : 'DESC';
$chapter_comic_order = get_option('toocheke-chapter-first-comic') ? get_option('toocheke-chapter-first-comic') : 'DESC';
$collection_comic_order = get_option('toocheke-collection-first-comic') ? get_option('toocheke-collection-first-comic') : 'DESC';
$hide_comics_section = get_theme_mod( 'hide_comics_setting', false );
$hide_chapters_section = get_theme_mod( 'hide_chapters_setting', false );
$hide_collection_section = get_theme_mod( 'hide_collections_setting', false );
$hide_series_section = get_theme_mod( 'hide_series_setting', false );


$series_id = null;
$comic_ids = [];
if (is_singular('series')) {
    $series_id = get_the_ID();

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
}
if(!$series_id){
    $series_id = get_option('toocheke-traditional-home-series') ? get_option('toocheke-traditional-home-series') : null;
}

//ALL collections carousel
get_template_part('template-parts/content', 'collectionscarousel');
// Get latest collection
// Get the array of objects
$collection_args = array(
    'taxonomy' => 'collections',
    'parent' => 0,
    'orderby' => 'meta_value_num',
    'order' => $comic_order,
    'meta_query' => array(
        array(
            'key' => 'collection-order',
            'type' => 'NUMERIC',
        )),
    'show_count' => 0,
    'number' => 1,
);


// Define terms array
$collections_list = get_categories($collection_args);
foreach($collections_list as $value){
    $latest_collection_id = $value->term_id ;
}
?>

<!-- START LATEST COMIC-->
<div id="latest-comic">
    <div id="single-comic-row" class="row">
        <div id="single-comic-col" class="col-lg-12">
            <?php
$single_comics_args = array(
    'post_parent' => $series_id,
    'post_type' => 'comic',
    'post_status' => 'publish',
    'posts_per_page' => 1,
    'orderby' => 'post_date',
    'order' => $comic_order,
 
);
$single_comic_query = new WP_Query($single_comics_args);
/* Start the Loop */
while ($single_comic_query->have_posts()): $single_comic_query->the_post();
set_query_var('latest_collection_id', 0);
if (!$series_id) {
    set_query_var('series_id', null);
} else {
    set_query_var('series_id', $series_id);
}
    get_template_part('template-parts/content', 'singlecomic');
endwhile;

wp_reset_postdata();
?>
        </div>
    </div>
</div>
<!-- END LATEST COMIC-->
<div id="comics-section">&nbsp;</div>
<div id="main-content-row" class="row">
    <!--START LEFT COL-->
    <div class="col-lg-8">
        <div id="left-col">
            <div id="left-content">
                <!--HOME TOP WIDGET START-->
                <?php dynamic_sidebar('home-left-top');?>
                <!--HOME TOP WIDGET END-->
                <!-- START COMIC ARCHIVE-->
                <div id="comic-archive-list">
                    <?php

if (post_type_exists('comic') && !$hide_comics_section):


    /**
     * Setup query to show the ‘comic’ post type for the latest collection with ‘10’ posts.
     * Output is comic thumbnail with comic title.
     */
    $comics_args = array(
        'post_parent' => $series_id,
        'post_type' => 'comic',
        'post_status' => 'publish',
        'posts_per_page' => 10,
        'paged' => $comics_paged,
        'orderby' => 'post_date',
        'order' => $comic_order,
      
    );

    $comics_query = new WP_Query($comics_args);

    ?>
                    <?php
    if ($comics_query->have_posts()):
    ?>
                    <h2 id="latest-comics-header" class="left-title">
                        <?php echo (esc_html(get_theme_mod('latest_comic_setting')) != "") ? esc_html(get_theme_mod('latest_comic_setting')) : esc_html_e('Latest Comics', 'toocheke') ?>
                    </h2>
                    <ul id="comic-list">
                        <?php

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
            $parent_id = !empty(get_post_meta(get_the_ID(), 'post_parent', true)) ? (int) get_post_meta(get_the_ID(), 'post_parent', true) : null;
            set_query_var('series_id', $parent_id);
        } else {
            set_query_var('show_comic_number', false);
            set_query_var('series_id', $series_id);
        }
        get_template_part('template-parts/content', 'comiclistitem');

    endwhile;

    ?>
                    </ul>
                    <?php
endif;
?>


                    <!-- Start Pagination -->
                    <?php
// Set up paginated links.
$comic_links = paginate_links(array(
    'format' => '?comics_paged=%#%#comics-section',
    'current' => $comics_paged,
    'total' => $comics_query->max_num_pages,
    'prev_text' => wp_kses(__('<i class=\'fas fa-chevron-left\'></i>', 'toocheke'), array('i' => array('class' => array()))),
    'next_text' => wp_kses(__('<i class=\'fas fa-chevron-right\'></i>', 'toocheke'), array('i' => array('class' => array()))),
    'add_args' => array('blog_paged' => $blog_paged),
));

if ($comic_links):

?>

                    <nav class="pagination">

                        <?php echo wp_kses($comic_links, array(
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

                    </nav>
                    <!--/ .navigation -->
                    <?php
endif;
?>
                    <!-- End Pagination -->
                    <?php
$comics_query = null;
wp_reset_postdata();

endif;
?>
                </div>
                <!-- END COMIC ARCHIVE-->
<!--START SERIES LIST-->

                <?php
if (post_type_exists('series') && !$hide_series_section):
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
    <div id="series-wrapper">
    <h2 id="comic-series-header" class="left-title"><?php echo ( esc_html(get_theme_mod( 'comic_series_setting')) != "" ) ? esc_html(get_theme_mod( 'comic_series_setting')) : esc_html_e('Comic Series', 'toocheke')?></h2>
                <div id="series-grid">
                    <?php
    while ($series_query->have_posts()): $series_query->the_post();
        ?>
                    <span class="series-thumbnail-wrapper">
                        <a class="series-thumbnail" href="<?php echo esc_url(get_permalink($post)); ?>">
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
                </div>
                <!--.series-grid-->
                </div>
                <!--.series-wrapper-->
                <?php
endif;
?>
                <?php
endif;
?>
<!--END SERIES LIST-->
                <?php
/**
 * Get latest six chapters of comics. If there are no chapters or chapters with no comics, don't display.
 */

$chapter_args = array(
    'taxonomy' => 'chapters',
    'style' => 'none',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'chapter-order',
            'type' => 'NUMERIC',
        )),
    'show_count' => 0,
    'number' => 6,
);

if($comic_ids){
    $chapters_list = wp_get_object_terms($comic_ids, 'chapters', $chapter_args);
}
else{
    $chapters_list = get_categories($chapter_args);
}

if ($chapters_list && !$hide_chapters_section) {
    ?>
                <!-- START COMIC CHAPTER LIST-->
                <div id="chapter-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 id="latest-chapters-header" class="left-title">
                                <?php echo (esc_html(get_theme_mod('latest_chapter_setting')) != "") ? esc_html(get_theme_mod('latest_chapter_setting')) : esc_html_e('Latest Chapters', 'toocheke') ?>
                            </h2>
                        </div>
                        <?php

    foreach ($chapters_list as $chapter) {
        /**
         * Get latest post for this chapter
         */
        $link_to_first_comic = '';
        $args = array(
            'posts_per_page' => 1,
            'post_type' => 'comic',
            'order' => $chapter_comic_order,
            'post_parent' => $series_id,
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
            printf(wp_kses_data('%1$s'), '<div class="col-md-4 chapter-thumbnail">');
            printf(wp_kses_data('%1$s'), '<a href="' . esc_url($link_to_first_comic) . '">');
            $term_id = absint($chapter->term_id);
            $thumb_id = get_term_meta($term_id, 'chapter-image-id', true);

            if (!empty($thumb_id)) {
                $term_img = wp_get_attachment_url($thumb_id);
                printf(wp_kses_data('%1$s'), '<img src="' . esc_attr($term_img) . '" /><br/>');
            }
            else {
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
                    <!--end chapters row-->
                    <div class="col-md-12 more-chapters-wrapper">
                        <a class="btn btn-danger btn-xs"
                            href="<?php echo esc_url(add_query_arg('col', $latest_collection_id, get_permalink(get_page_by_path('collections')))) ?>"
                            role="button"><?php esc_html_e('More Chapters', 'toocheke');?></a>
                    </div>
                    <!--end more wrapper-->
                </div>
                <!--end chapters wrapper-->
                <!-- END COMIC CHAPTER LIST-->

                <?php
}
/**
 * Get latest six collections of comics. If there are no collections or collections with no comics, don't display.
 */

$collection_args= array(
    'taxonomy' => 'collections',
    'style' => 'none',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'collection-order',
            'type' => 'NUMERIC',
        )),
    'show_count' => 0,
    'number' => 6,
);

if($comic_ids){
    $collections_list = wp_get_object_terms($comic_ids, 'collections', $collection_args);
}
else{
    $collections_list = get_categories($collection_args);
}

if ($collections_list && !$hide_collection_section) {
    ?>
                <!-- START COMIC COLLECTION LIST-->
                <div id="collection-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 id="latest-collections-header" class="left-title">
                                <?php echo (esc_html(get_theme_mod('latest_collection_setting')) != "") ? esc_html(get_theme_mod('latest_collection_setting')) : esc_html_e('Latest Collections', 'toocheke') ?>
                            </h2>
                        </div>
                        <?php

    foreach ($collections_list as $collection) {
        /**
         * Get latest post for this collection
         */
        $link_to_first_comic = '';
        $args = array(
            'post_parent' => $series_id,
            'posts_per_page' => 1,
            'post_type' => 'comic',
            'order' => $collection_comic_order,
            "tax_query" => array(
                array(
                    'taxonomy' => "collections", // use the $tax you define at the top of your script
                    'field' => 'term_id',
                    'terms' => $collection->term_id, // use the current term in your foreach loop
                ),
            ),
            'no_found_rows' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        );
        $first_comic_query = new WP_Query($args);
        // The Loop
        while ($first_comic_query->have_posts()): $first_comic_query->the_post();
            $link_to_first_comic = add_query_arg( array('sid' => $series_id, 'col' => $collection->term_id), get_post_permalink() ); // Display the image of the first post in category
            wp_reset_postdata();
            printf(wp_kses_data('%1$s'), '<div class="col-md-4 collection-thumbnail">');
            printf(wp_kses_data('%1$s'), '<a href="' . esc_url($link_to_first_comic) . '">');
            $term_id = absint($collection->term_id);
            $thumb_id = get_term_meta($term_id, 'collection-image-id', true);

            if (!empty($thumb_id)) {
                $term_img = wp_get_attachment_url($thumb_id);
                printf(wp_kses_data('%1$s'), '<img src="' . esc_attr($term_img) . '" /><br/>');
            }
            else {
                ?>
                                                <img
                                                    src="<?php echo esc_attr(get_stylesheet_directory_uri()) . '/dist/img/default-thumbnail-image.png'; ?>" />
                                                <?php
            }

            echo wp_kses_data($collection->name);
            echo '</a></div>';
        endwhile;
    }
// Reset Post Data
    wp_reset_postdata();

    ?>
                    </div>
                    <!--end collections row-->
                    <div class="col-md-12 more-chapters-wrapper">
                        <a class="btn btn-danger btn-xs"
                            href="<?php echo esc_url(add_query_arg('col', 0, get_permalink(get_page_by_path('collections')))) ?>"
                            role="button"><?php esc_html_e('More Collections', 'toocheke');?></a>
                    </div>
                    <!--end more wrapper-->
                </div>
                <!--end collections wrapper-->
                <!-- END COMIC COLLECTION LIST-->
                <?php
}