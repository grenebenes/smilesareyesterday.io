<?php
/**
 * Template part for displaying infinite scroll of comic archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */
$comic_order = get_option('toocheke-comics-order') ? get_option('toocheke-comics-order') : 'DESC';
?>
<div id="comics-section">&nbsp;</div>
<div id="main-content-row" class="row">
    <!--START LEFT COL-->
    <div class="col-lg-8">
        <div id="left-col">
            <div id="left-content">
                <!--HOME TOP WIDGET START-->
                <?php dynamic_sidebar('home-left-top');?>
                <!--HOME TOP WIDGET END-->
                <!-- start #infinite-scroll-->
<div id="infinite-scroll">
<?php
if (post_type_exists('comic')):
    /**
     * Setup query to show the ‘comic’ post type with ‘10’ posts.
     * Output is thumbnail with comic title
     */
    $comics_args = array(
        'post_type' => 'comic',
        'post_status' => 'publish',
        'paged' => 1,
        'orderby' => 'post_date',
        'order' => $comic_order,
    );

    $comics_query = new WP_Query($comics_args);
    if ($comics_query->have_posts()):
        ?>
         <h2 id="latest-comics-header" class="left-title"><?php echo (esc_html(get_theme_mod('latest_comic_setting')) != "") ? esc_html(get_theme_mod('latest_comic_setting')) : esc_html_e('Latest Comics', 'toocheke') ?></h2>
         <?php
            /* Start the Loop */
    while ($comics_query->have_posts()): $comics_query->the_post();

    /*
     * Include the Post-Type-specific template for the content.
     * If you want to override this in a child theme, then include a file
     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
     */
    set_query_var('latest_collection_id', 0);
    set_query_var('show_comic_number', true);
    set_query_var('series_id', null);
    get_template_part('template-parts/content', 'infinitescrollcomic');

endwhile;
$comics_query = null;
wp_reset_postdata();
    endif;
endif;
?>
</div>
 <!--end ./#infinite-scroll-->
 </div> <!--end ./#left-content-->
 </div> <!--end ./#left-col-->
 </div> <!--end ./.col-lg-8-->