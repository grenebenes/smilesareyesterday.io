<?php
/**
 * Template part for gallery archive of comics
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */
$comics_paged = isset($_GET['comics_paged']) ? (int) $_GET['comics_paged'] : 1;
?>
<?php if (have_posts()): ?>
     <header class="page-header">
            <?php
the_archive_title('<h1 class="page-title">', '</h1>');

?>
      </header><!-- .page-header -->
      <hr/>
      <div  class="row">
<div class="col-lg-12">
      <div id="comic-grid">
			<?php
while (have_posts()): the_post();

    /*
     * Include the Post-Type-specific template for the content.
     * If you want to override this in a child theme, then include a file
     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
     */
    get_template_part('template-parts/content', 'comicarchivegalleryitem');

endwhile;
?>
            </div>

                 <!-- Start Pagination -->
       <?php
the_posts_navigation(
    array(
        'prev_text' => __('Older comics', 'toocheke'),
        'next_text' => __('Newer comics', 'toocheke'),
        'screen_reader_text' => __('Posts navigation', 'toocheke'),
    )
);

?>
                  </div>
            </div>
<?php

else:

    get_template_part('template-parts/content', 'none');

endif;
?>