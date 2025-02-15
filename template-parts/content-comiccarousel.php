<?php
/**
 * Template part for displaying comic
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */

?>
<?php
$series_id = null;
$series_id = isset($_GET['sid']) ? (int) $_GET['sid'] : null;
$current_post_id = get_the_ID();
$current_publish_date = get_the_date('Y-m-d H:i:s', $current_post_id);
$carousel_order = get_option('toocheke-comics-slider-order') ? get_option('toocheke-comics-slider-order') : 'DESC';
/* optimized carousel query */
$adjacent_limit = 25;
$overall_count = 0;
$adjacent_args = array(
    'post_parent' => $series_id,
    'post_type' => 'comic',
    'post_status' => 'publish',
    'posts_per_page' => $adjacent_limit,
    'orderby' => 'publish_date',

);
if ($collection_id > 0) {
    $adjacent_args['tax_query'] = array(
        array(
            'taxonomy' => 'collections',
            'field' => 'term_id',
            'terms' => $collection_id,
        ),
    );
}
$before_args = $after_args = $adjacent_args;
$before_args['order'] = 'DESC';
$after_args['order'] = 'ASC';
$before_args['date_query'] = array(
    array(
        'column' => 'publish_date',
        'before' => $current_publish_date,
        'inclusive' => true,
    ),
);
$after_args['date_query'] = array(
    array(
        'column' => 'publish_date',
        'after' => $current_publish_date,
        'inclusive' => false,
    ),
);
$before_query = new WP_Query($before_args);
$before_count = $before_query->post_count;
$after_query = new WP_Query($after_args);
$after_count = $after_query->post_count;
$after_query->posts = array_reverse($after_query->posts);
$overall_count = $before_count + $after_count;
$merged_query = new WP_Query();
$merged_query->posts = array_merge($after_query->posts, $before_query->posts );
$merged_query->post_count = $overall_count;
if ($carousel_order === 'DESC') {
    $merged_query->posts = array_reverse($merged_query->posts);
}
//echo $after_query->request;

?>
<!-- Carousel Comics -->

<div col="row">
<div id="comics-carousel" class="owl-carousel">
  <?php $counter = 0;?>
  <?php while ($merged_query->have_posts()): $merged_query->the_post();?>

		<div title="<?php esc_attr(the_title());?>" id="comic-<?php esc_attr(the_ID());?>" data-index="<?php echo wp_kses_data($counter) ?>" <?php echo (get_the_ID() == $current_post_id) ? 'class=current-comic' : ''; ?>>

	    <?php
    $comic_url = get_permalink($post);
    if ($collection_id > 0) {
        $comic_url = add_query_arg('col', $collection_id, $comic_url);
    }
    if ($series_id > 0) {
        $comic_url = add_query_arg('sid', $series_id, $comic_url);
    }
    ?>

		    <a href="<?php echo esc_url($comic_url); ?>">

												<?php
    if (has_post_thumbnail()) {
        the_post_thumbnail('thumbnail');
    } else {
        ?>
	       <img src="<?php echo esc_attr(get_stylesheet_directory_uri()) . '/dist/img/default-thumbnail-image.png'; ?>" />
	       <?php
    }
    ?>
		<span class="mask"></span>

		                              </a>

		                           </div>
		                           <?php $counter++;?>
		  <?php endwhile;?>
  <?php wp_reset_postdata();?>
</div>
</div>