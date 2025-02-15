<?php
/**
 * Template part for top 10 comics page(thumbnail list) 
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */
$args = array(
    'post_type' => 'comic',
    'post_status' => 'publish',
    'posts_per_page' => 10,
    'meta_key' => 'post_views_count',
    'meta_query' => array(
        array(
            'key' => 'post_views_count',
            'value' => 0,
            'compare' => '>'
        )
    ),
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
);
$popular_comics = new WP_Query($args);
?>
<?php if ($popular_comics->have_posts()): ?>

      <header class="page-header">
      <h1 class="page-title">Top Ten Comics</h1>
      </header><!-- .page-header -->
<ul id="comic-list">
      <?php

/* Start the Loop */
$rank = 1;
while ( $popular_comics->have_posts() ) : $popular_comics->the_post();
set_query_var('latest_collection_id', 0);
set_query_var('series_id', null);
    set_query_var('rank', $rank);
    get_template_part('template-parts/content', 'comiclistitem');
    $rank++;
endwhile;
// Reset Post Data
wp_reset_postdata();
?>
</ul>    



<?php

else:

    get_template_part('template-parts/content', 'none');

endif;
?>