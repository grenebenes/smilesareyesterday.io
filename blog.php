<?php
/* Template Name: Blog Landing Page */

get_header();
$home_layout = get_theme_mod('home_layout_setting', 'default');
set_query_var('home_layout', $home_layout);
$col = 'alt-2' === $home_layout ? 'col-lg-12' : 'col-lg-8';
$blog_paged = isset($_GET['blog_paged']) ? (int) $_GET['blog_paged'] : 1;
$blog_args = array(
    'paged' => $blog_paged,
    'post_type'   => 'post',
	'post_status' => 'publish'
);
$blog_query = new WP_Query($blog_args);

?>

<div class="row">
               <!--START LEFT COL-->
               <div class="<?php echo esc_attr($col) ?>">
                  <div id="left-col">
                     <div id="left-content">
		     <!--START CONTENT-->

             <?php if ( $blog_query->have_posts() ) :  ?>

<?php /* Start the Loop */ ?>

<?php while ( $blog_query->have_posts() ) : $blog_query->the_post() ; ?>
    <?php

    /*
     * Include the Post-Format-specific template for the content.
     * If you want to override this in a child theme, then include a file
     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
     */
    /*the_excerpt();*/
    get_template_part('template-parts/content', get_post_type());
    ?>
<hr/>
<?php endwhile; ?>

<?php else : ?>

<?php get_template_part( 'template-parts/content', 'none' ); ?>

<?php endif; ?>
<!-- Start Pagination -->
<?php
// Set up paginated links.
$blog_links = paginate_links(array(
    'format' => '?blog_paged=%#%',
    'current' => $blog_paged,
    'total' => $blog_query->max_num_pages,
    'prev_text' => wp_kses(__('<i class=\'fas fa-chevron-left\'></i>', 'toocheke'), array('i' => array('class' => array()))),
    'next_text' => wp_kses(__('<i class=\'fas fa-chevron-right\'></i>', 'toocheke'), array('i' => array('class' => array()))),
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
?>

		                        <!--END CONTENT-->
                              </div><!--./ left-content-->
                  </div><!--./ left-col-->
               </div><!--./ col-lg-8-->
               <!--END LEFT COL-->

<?php
get_sidebar();
get_footer();
