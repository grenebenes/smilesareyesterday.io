<?php
/**
 * Template Name: Comic Collections Template
 *
 * Template for displaying comic collection thumbnails with links to the first comic in the collection.
 *
 * @package toocheke
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
get_header();
$home_layout = get_theme_mod('home_layout_setting', 'default');
$col = 'alt-2' === $home_layout ? 'col-lg-12' : 'col-lg-8';
$comic_order = get_option('toocheke-comics-order') ? get_option('toocheke-comics-order') : 'DESC';
$collection_id = isset($_GET['col']) ? (int) $_GET['col'] : 0;
$page_title = $collection_id > 0 ? 'Chapters' : 'Collections';
$collection_comic_order = get_option('toocheke-collection-first-comic') ? get_option('toocheke-collection-first-comic') : 'ASC';
?>

<div class="row">
               <!--START LEFT COL-->
               <div class="<?php echo esc_attr($col)?>">
                  <div id="left-col">
                     <div id="left-content">

			<section>
				<header class="page-header">
					<h1 class="page-title"><?php echo wp_kses_data( $page_title); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
                <?php
				 /**
 * Get latest six collections of comics. If there are no collections or collections with no comics, don't display.
 */
//setup paging
//Get total number of active collections
$total_args = array(
	'taxonomy' => 'collections'
);
$all_active_collection_list = get_categories( $total_args );
$total_active_collections =  count( $all_active_collection_list); 

//start paging
$collection_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;


$collection_per_page = 60;
$total_number_of_pages =  ceil($total_active_collections/$collection_per_page);  
$paged_offset = ($collection_paged - 1) * $collection_per_page;

//setup paginate args
$paginate_args = array(
	'parent' => $collection_id,
	'taxonomy' => 'collections',
	'style'              => 'none',
	'orderby' => 'meta_value_num',
	'order'              => $collection_comic_order,
	'meta_query' => array(
		array(
		'key' => 'collection-order',
		'type' => 'NUMERIC',
		)),
	'show_count' => 0,
	'number'            => $collection_per_page,
	'paged'             => $collection_paged,
	'offset'            => $paged_offset
);  

$paged_collections_list  = get_categories($paginate_args);
 
if ( $paged_collections_list ) {
	?>
	<div class="row">
	
		<?php

	foreach ( $paged_collections_list as $collection ) {

					 /**
 * Get latest post for this collection
 */
		$link_to_first_comic = '';
		$args = array(
			'posts_per_page' => 1,
			'post_type' => 'comic',
			'orderby' => 'post_date',
			'order' => $collection_comic_order,
			"tax_query" => array(
				array (
				  'taxonomy' => "collections", // use the $tax you define at the top of your script
				  'field' => 'term_id',
				  'terms' => $collection->term_id, // use the current term in your foreach loop
				),
			),
			'no_found_rows' => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false
		);
		$first_comic_query = new WP_Query( $args );
		// The Loop
	while ( $first_comic_query->have_posts() ) : $first_comic_query->the_post();
	$link_to_first_comic = add_query_arg ('col', $collection->term_id, get_post_permalink()); // Display the image of the first post in category
endwhile;
		printf( wp_kses_data( '%1$s'), '<div class="col-md-3 collection-thumbnail">' );
		printf( wp_kses_data( '%1$s'), '<a href="' . esc_url($link_to_first_comic) . '">' );
		$term_id = absint( $collection->term_id );
    $thumb_id = get_term_meta( $term_id, 'collection-image-id', true );

    if( !empty( $thumb_id ) ){
				$term_img = wp_get_attachment_url(  $thumb_id );
		printf( wp_kses_data( '%1$s'), '<img src="' . esc_url($term_img) . '" /><br/>' );
    }
	echo  wp_kses_data($collection->name) ;
	echo '</a></div>';

	}
// Reset Post Data
wp_reset_postdata();

	?>



	</div>
	<div class="row">
	<div class="col-md-12">
	<hr/>
	
   <!-- Start Pagination -->
   <?php
			 // Set up paginated links.
			 $big = 999999999; // need an unlikely integer
    $links = paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
  		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $total_number_of_pages,
        'prev_text' =>  wp_kses(__('<i class=\'fas fa-chevron-left\'></i>', 'toocheke' ), array('i' => array('class' => array()))),
        'next_text' => wp_kses(__( '<i class=\'fas fa-chevron-right\'></i>', 'toocheke' ), array('i' => array('class' => array())))
    ) );
 
    if ( $links ) :
 
    ?>

<div class="paginate-links">

            <?php echo wp_kses($links, array(
                'a' => array(
                    'href' => array(),
                    'class' => array()
                ),
                'i' => array(
                    'class' => array()
                ),
                'span' => array(
                    'class' => array()
                )
            )); ?>

		</div><!--/ .navigation -->
    <?php
    endif;
?>
 <!-- End Pagination -->
	</div>
	</div>
	<?php
}//end if
				 ?>
				</div><!-- .page-content -->
			</section>

		                 <!--END CONTENT-->
						 </div><!--./ left-content-->
                  </div><!--./ left-col-->
               </div><!--./ col-lg-8-->
               <!--END LEFT COL-->           
              
<?php
get_sidebar();
get_footer();
