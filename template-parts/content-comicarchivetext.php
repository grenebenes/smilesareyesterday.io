<?php
/**
 * Template part for text list archive of comics
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
      <hr/>
<?php
while (have_posts()): the_post();
    ?>
			  <div class="comic-archive-item">
	<span class="comic-archive-date"><?php echo get_the_date(); ?></span>
	<span class="comic-archive-title"><a href="<?php the_permalink();?>" title="<?php echo esc_attr(get_the_title()) ?>"><?php echo wp_kses_data(get_the_title()) ?></a></span>
	</div>

	          <?php
endwhile;
?>
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