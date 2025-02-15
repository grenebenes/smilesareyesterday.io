<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Toocheke
 */

get_header();
?>

<div class="row">
               <!--START LEFT COL-->
               <div class="col-lg-8">
                  <div id="left-col">
                     <div id="left-content">
					 <?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			toocheke_post_nav();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		                        <!--END CONTENT-->
                              </div><!--./ left-content-->
                  </div><!--./ left-col-->
               </div><!--./ col-lg-8-->
               <!--END LEFT COL-->           
              
<?php
get_sidebar();
get_footer();