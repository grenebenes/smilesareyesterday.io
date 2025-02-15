<?php
/**
 * Template part for displaying single series home page as well as the series page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */
$home_layout = get_theme_mod('home_layout_setting', 'default');
set_query_var('home_layout', $home_layout);
$blog_paged = isset($_GET['blog_paged']) ? (int) $_GET['blog_paged'] : 1;
$comics_paged = isset($_GET['comics_paged']) ? (int) $_GET['comics_paged'] : 1;
$show_blog_posts = get_option('toocheke-series-landing-blog') && 1 == get_option('toocheke-series-landing-blog');
set_query_var('comics_paged', $comics_paged);
set_query_var('blog_paged', $blog_paged);
$home_layout = get_theme_mod('home_layout_setting', 'default');
$series_id = null;
if (is_singular('series')) {
    $series_id = get_the_ID();
}

//check if at least one collection has posts
$has_collections = false;
$terms = get_terms('collections');
if (is_array($terms) && !empty($terms)) {
    foreach ($terms as $terms) {
        $has_collections = $terms->count > 0;
        if ($terms->count > 0) {
            break; /* You could also write 'break 1;' here. */
        }

    }
}

?>
				 <?php
if ($has_collections):
?>
<!--DISPLAY MULTIPLE COMIC COLLECTION-->
<?php
get_template_part('template-parts/content', 'multiplecollections');
?>
<!--./DISPLAY MULTIPLE COMIC COLLECTION-->
<?php
else:
?>
<!--DISPLAY SINGLE COMIC COLLECTION-->
<?php
get_template_part('template-parts/content', 'singlecollection');
?>
<!--./DISPLAY SINGLE COMIC COLLECTION-->
<?php
endif;
?>
<?php

if ($home_layout == 'alt-1' || $home_layout == 'alt-4') {
    get_template_part('template-parts/content', 'latestcomicblog');
}

?>
                 <?php

if (!is_singular('series') || $show_blog_posts) {
    get_template_part('template-parts/content', 'indexblogs');
}
?>
                        <!--END CONTENT-->
                          <!--HOME BOTTOM WIDGET START-->
                <?php dynamic_sidebar('home-left-bottom');?>
                <!--HOME BOTTOM WIDGET END-->
                     </div><!--./ left-content-->
                  </div><!--./ left-col-->
               </div><!--./ col-lg-8-->
               <!--END LEFT COL-->