<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */

get_header();
$comics_paged = isset($_GET['comics_paged']) ? (int) $_GET['comics_paged'] : 1;
$archive_layout_options = get_option('toocheke-comics-archive');
$comic_archive_option = isset($archive_layout_options['layout_type']) ? $archive_layout_options['layout_type'] : 'thumbnail-list';

?>

<div class="row">
               <!--START LEFT COL-->
               <div class="col-lg-8">
                  <div id="left-col">
                     <div id="left-content">
      <?php
switch ($comic_archive_option) {
    case 'thumbnail-list':
        get_template_part('template-parts/content', 'comicarchivethumbnail');
        break;
    case 'plain-text-list':
        get_template_part('template-parts/content', 'comicarchivetext');
        break;
    case 'calendar':
        get_template_part('template-parts/content', 'comicarchivecalendar');
        break;
    case 'gallery':
        get_template_part('template-parts/content', 'comicarchivegallery');
        break;
    case 'chapters-plain-text-list':
        get_template_part('template-parts/content', 'comicarchivechapterstext');
        break;
    case 'chapters-gallery':
        get_template_part('template-parts/content', 'comicarchivechaptersgallery');
        break;
    case 'series-plain-text-list':
        get_template_part('template-parts/content', 'comicarchiveseriestext');
        break;
    case 'series-gallery':
        get_template_part('template-parts/content', 'comicarchiveseriesgallery');
        break;
    case 'yearly-plain-text-list':
        get_template_part('template-parts/content', 'comicarchiveyearlytext');
        break;
    case 'yearly-gallery':
        get_template_part('template-parts/content', 'comicarchiveyearlygallery');
        break;
}

?>

		                         <!--END CONTENT-->
								 </div><!--./ left-content-->
                  </div><!--./ left-col-->
               </div><!--./ col-lg-8-->
               <!--END LEFT COL-->

<?php
get_sidebar();
get_footer();
