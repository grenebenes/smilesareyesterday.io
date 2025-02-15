<?php
/**
 * Template part for displaying blog posts for home page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */
$hide_blog = get_option('toocheke-hide-blog');
if (!$hide_blog):
?>
<!-- START BLOG POSTS-->
<?php
if (have_posts()):
    if ($home_layout != 'alt-1' && $home_layout != 'alt-4') {
        ?>
<hr />
<p id="blog-section">&nbsp;</p>
<h2 id="latest-posts-header" class="left-title">
    <?php echo (esc_html(get_theme_mod('latest_post_setting')) != "") ? esc_html(get_theme_mod('latest_post_setting')) : esc_html_e('Latest Posts', 'toocheke') ?>
</h2>
<?php
    }
    if (is_home() && !is_front_page()):
    ?>
<h3 class="page-title screen-reader-text"><?php single_post_title();?></h3>
<?php
endif;
$blog_args = array(
    'paged' => $blog_paged,
    //'posts_per_page' => 5,
);
$blog_query = new WP_Query($blog_args);
/* Start the Loop */
while ($blog_query->have_posts()): $blog_query->the_post();

    /*
     * Include the Post-Type-specific template for the content.
     * If you want to override this in a child theme, then include a file
     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
     */
    get_template_part('template-parts/content', get_post_type());

endwhile;

?>
<!-- Start Pagination -->
<?php
// Set up paginated links.
$blog_links = paginate_links(array(
    'format' => '?blog_paged=%#%#blog-section',
    'current' => $blog_paged,
    'total' => $blog_query->max_num_pages,
    'prev_text' => wp_kses(__('<i class=\'fas fa-chevron-left\'></i>', 'toocheke'), array('i' => array('class' => array()))),
    'next_text' => wp_kses(__('<i class=\'fas fa-chevron-right\'></i>', 'toocheke'), array('i' => array('class' => array()))),
    'add_args' => array('comics_paged' => $comics_paged),
));

if ($blog_links):

?>

<nav id="blog-pagination" class="pagination" aria-label="Posts navigation">

    <?php echo wp_kses($blog_links, array(
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
wp_reset_postdata();

endif;
endif;
?>
<!-- END BLOG POSTS-->