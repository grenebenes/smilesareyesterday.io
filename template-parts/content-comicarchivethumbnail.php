<?php
/**
 * Template part for thumbnail archive of comics
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */
?>
<?php if (have_posts()): ?>

      <header class="page-header">
            <?php
the_archive_title('<h1 class="page-title">', '</h1>');

?>
      </header><!-- .page-header -->
<ul id="comic-list">
      <?php

/* Start the Loop */
while (have_posts()): the_post();

    /*
     * Include the Post-Type-specific template for the content.
     * If you want to override this in a child theme, then include a file
     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
     */
    set_query_var('latest_collection_id', 0);
    if (!isset($series_id)) {
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
the_posts_navigation(
    array(
        'prev_text' => __('Older comics', 'toocheke'),
        'next_text' => __('Newer comics', 'toocheke'),
        'screen_reader_text' => __('Posts navigation', 'toocheke'),
    )
);

?>



<?php

else:

    get_template_part('template-parts/content', 'none');

endif;
?>