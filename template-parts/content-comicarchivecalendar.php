<?php
/**
 * Template part for calendar archive of comics
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */
if (is_day() ):
    get_template_part('template-parts/content', 'comicarchivethumbnail');
    ?>
    <a href="/comic">Back to Calendar</a>
    <?php

else:
    ?>
    <?php if (have_posts()): ?>
     <header class="page-header">
            <?php
the_archive_title('<h1 class="page-title">', '</h1>');

?>
      </header><!-- .page-header -->
      <hr/>
      <div id="archive-page-calendar-wrapper">
      <?php the_widget('toocheke_calendar');?>
      </div>

      <?php

else:

    get_template_part('template-parts/content', 'none');

endif;
?>
    <?php
endif;
?>

