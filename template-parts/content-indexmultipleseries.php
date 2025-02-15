<?php
/**
 * Template part for displaying single series home page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */
$home_layout = get_theme_mod('home_layout_setting', 'default');
set_query_var('home_layout', $home_layout);
$col = 'alt-2' === $home_layout ? 'col-lg-12' : 'col-lg-8';
$blog_paged = isset($_GET['blog_paged']) ? (int) $_GET['blog_paged'] : 1;
$comics_paged = isset($_GET['comics_paged']) ? (int) $_GET['comics_paged'] : 1;
set_query_var('comics_paged', $comics_paged);
set_query_var('blog_paged', $blog_paged);
$series_order = get_option('toocheke-series-order') ? get_option('toocheke-series-order') : 'DESC';
?>
<div id="multiple-series-container" class="row">
    <!--START LEFT COL-->
    <div class="<?php echo esc_attr($col) ?>">
        <div id="left-col">
            <div id="left-content">
                <!--HOME TOP WIDGET START-->
                <?php dynamic_sidebar('home-above-series');?>
                <!--HOME TOP WIDGET END-->
                <!--BEGIN CONTENT-->
                <h2 id="comic-series-header" class="left-title"><?php echo ( esc_html(get_theme_mod( 'comic_series_setting')) != "" ) ? esc_html(get_theme_mod( 'comic_series_setting')) : esc_html_e('Comic Series', 'toocheke')?></h2>
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
                <?php
endif;
?>
                <?php
endif;
?>

                <?php
$display_all_latest_comics_for_multiple_series = get_option('toocheke-display-latest-comics-of-all-multiple-series') && get_option('toocheke-display-latest-comics-of-all-multiple-series') === '1';
if ($display_all_latest_comics_for_multiple_series) {
    $comic_order = get_option('toocheke-comics-order') ? get_option('toocheke-comics-order') : 'DESC';
    ?>
                <!--DISPLAY LATEST COMICS FOR ALL SERIES-->
                <div id="comic-archive-list">
                    <?php

    if (post_type_exists('comic')):

/**
 * Setup query to show the ‘comic’ post type with ‘10’ posts.
 * Output is thumbnail with comic title
 */
        $comics_args = array(
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
                    <h2 id="latest-comics-header" class="left-title"><?php echo ( esc_html(get_theme_mod( 'latest_comic_setting')) != "" ) ? esc_html(get_theme_mod( 'latest_comic_setting')) : esc_html_e('Latest Comics', 'toocheke')?></h2>
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
            set_query_var('show_comic_number', true);
            set_query_var('series_id', null);
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

                <!--./DISPLAY LATEST COMICS FOR ALL SERIES-->
                <?php
}
?>
                <?php
get_template_part('template-parts/content', 'indexblogs');
?>
                <!--END CONTENT-->
                <!--HOME BOTTOM WIDGET START-->
                <?php dynamic_sidebar('home-below-series');?>
                <!--HOME BOTTOM WIDGET END-->
            </div>
            <!--./ left-content-->
        </div>
        <!--./ left-col-->
    </div>
    <!--./ col-lg-8-->
    <!--END LEFT COL-->