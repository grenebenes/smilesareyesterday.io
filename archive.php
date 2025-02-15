<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */

get_header();
// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$tax = $wp_query->get_queried_object();
$current_tax = $tax->taxonomy;
global $query_string;
?>

<div class="row">
               <!--START LEFT COL-->
               <div class="col-lg-8">
                  <div id="left-col">
                     <div id="left-content">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
					
			</header><!-- .page-header -->
		
			<?php 
			if (!empty($current_tax) && $current_tax == "chapters") {
				$chapter_comic_order = get_option('toocheke-chapter-first-comic') ? get_option('toocheke-chapter-first-comic') : 'DESC';
				//query_posts(array('order'=> $chapter_comic_order ));
				query_posts( $query_string . '&orderby=post_date&order=' . $chapter_comic_order  );
			}
			
			?>
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
		<?php 
			if (!empty($current_tax) && $current_tax == "chapters") {
				wp_reset_query();
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
