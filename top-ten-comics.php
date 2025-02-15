<?php
/**
 * Template Name: Top Ten Comics Page
 *
 * This is a page template you can use for displaying top ten comics
 *
 * @package Toocheke
 */

get_header();

$page_layout_options = get_option('toocheke-top-10-comics-layout');
$page_layout = isset($page_layout_options['layout_type']) ? $page_layout_options['layout_type'] : 'thumbnail-list';

?>

<div class="row">
               <!--START LEFT COL-->
               <div class="col-lg-8">
                  <div id="left-col">
                     <div id="left-content">
                     <?php
              
switch ($page_layout) {
    case 'thumbnail-list':
        get_template_part('template-parts/content', 'top10comicsthumbnail');
        break;
    case 'gallery':
        get_template_part('template-parts/content', 'top10comicsgallery');
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
