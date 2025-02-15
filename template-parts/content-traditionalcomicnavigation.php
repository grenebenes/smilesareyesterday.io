<?php
$randomNumber = rand();
$comic_order = get_option('toocheke-comics-order') ? get_option('toocheke-comics-order') : 'DESC';
$display_default = toocheke_display_default_buttons();
$display_random_button = get_option('toocheke-random-navigation') && 1 == get_option('toocheke-random-navigation');
$display_comic_archive_button = get_option('toocheke-comic-archive-navigation') && 1 == get_option('toocheke-comic-archive-navigation');
$display_bookmark_button = get_option('toocheke-comic-bookmark') && 1 == get_option('toocheke-comic-bookmark');
$display_likes = get_option('toocheke-comic-likes') && 1 == get_option('toocheke-comic-likes');
$display_no_views = get_option('toocheke-comic-no-of-views') && 1 == get_option('toocheke-comic-no-of-views');
$display_no_of_comments = get_option('toocheke-comic-no-of-comments') && 1 == get_option('toocheke-comic-no-of-comments');
$display_chapters_dropdown = get_option('toocheke-chapter-dropdown') && 1 == get_option('toocheke-chapter-dropdown');
$display_chapters_navigation = get_option('toocheke-chapter-navigation-buttons') && 1 == get_option('toocheke-chapter-navigation-buttons');
$latest_collection_id = null !== get_query_var('latest_collection_id') ? (int) get_query_var('latest_collection_id') : 0;
$below_comic = null !== get_query_var('below_comic') ? (int) get_query_var('below_comic') : 0;
$series_id = null;
$allow_home_comments = get_option('toocheke-comic-discussion');
$home_layout = get_theme_mod('home_layout_setting', 'default');
if ('alt-1' === $home_layout || 'alt-2' === $home_layout || 'alt-4' === $home_layout) {
    toocheke_set_post_views(get_the_ID());
}

if (get_query_var('series_id')) {
    $series_id = (int) get_query_var('series_id');
}
if (is_singular('series') && !$series_id) {
    $series_id = get_the_ID();
}

?>
<div class="single-comic-navigation">
			                <?php

$allowed_tags = array(
    'a' => array(
        'class' => array(),
        'title' => array(),
        'href' => array(),
    ),
    'i' => array(
        'class' => array(),
    ),
    'img' => array(
        'class' => array(),
        'src' => array(),
    ),
);
//$random_url = home_url() . '/?random&amp;nocache=1&amp;post_type=comic&amp;r=' . $randomNumber;
$random_url = home_url() . '/random?r=' . $randomNumber;
$comic_archive_url = home_url() . '/comic';
$image_button_url = get_option('toocheke-random-button');
$archive_image_button_url = get_option('toocheke-comic-archive-button');
$button = $display_default ? '<i class="fas fa-lg fa-random"></i>' : '<img class="comic-image-nav" src="' . esc_attr($image_button_url) . '" />';
$archive_button = $display_default ? '<i class="fas fa-lg fa-list"></i>' : '<img class="comic-image-nav" src="' . esc_attr($archive_image_button_url) . '" />';
?>
			                <?php
if ('DESC' === $comic_order) {
    echo wp_kses(toocheke_get_comic_link('ASC', 'backward', $latest_collection_id, $display_default, 'first', $series_id), $allowed_tags);
    echo wp_kses(toocheke_adjacent_comic_link(get_the_ID(), get_post_datetime(), $latest_collection_id, 'previous', $display_default, $series_id), $allowed_tags);
}
?>

			                <a style="<?php echo esc_attr(null == $series_id && $display_random_button ? "" : "display:none") ?>"
			                    href="<?php echo esc_url($random_url); ?>"
			                    title="Random Comic"><?php echo wp_kses($button, $allowed_tags) ?></i></a>
                            <a style="<?php echo esc_attr($display_comic_archive_button ? "" : "display:none") ?>"
			                    href="<?php echo esc_url($comic_archive_url); ?>"
			                    title="Archive"><?php echo wp_kses($archive_button, $allowed_tags) ?></i></a>
			                <?php
if ('ASC' === $comic_order) {
    echo wp_kses(toocheke_adjacent_comic_link(get_the_ID(), get_post_datetime(), $latest_collection_id, 'next', $display_default, $series_id), $allowed_tags);
    echo wp_kses(toocheke_get_comic_link('DESC', 'forward', $latest_collection_id, $display_default, 'latest', $series_id), $allowed_tags);

}
set_query_var('comic_id', get_the_ID());
?>
<?php if($display_chapters_dropdown || $display_chapters_navigation):?>
<div id="chapter-navigation">

<?php
set_query_var('show_chapter_header', 1);
global $post;
$comic_post = $post;
get_template_part('template-parts/content', 'chaptersdropdown');
get_template_part('template-parts/content', 'chaptersnavigation');
$post = $comic_post;
?>
</div>
<?php endif;?>
<?php

$social_content = false;
$support_content = false;
if (post_type_exists('comic')):
    ob_start();
    do_action('toocheke_get_sharing_buttons');
    $social_content = ob_get_contents();
    ob_end_clean();
    ob_start();
    do_action('toocheke_get_support_buttons');
    $support_content = ob_get_contents();
    ob_end_clean();
endif;
?>
			                 <?php
//check if plugin/post type has been activated
if ($social_content):
?>
    <div id="comic-social">
        <?php
echo wp_kses($social_content, toocheke_allowed_html());
?>
      </div>
      <?php
endif;
?>



                 
                  <?php
//check if plugin/post type has been activated
if ($support_content):
    ?>
     <div id="comic-support">
    <?php
    echo wp_kses($support_content, toocheke_allowed_html());
    ?>
     </div>
    <?php
endif;
?>
		                    <div id="comic-analytics" class="<?php echo ($display_no_of_comments || $display_no_views || $display_likes || $display_bookmark_button) ? esc_attr('') : esc_attr('d-none'); ?>">
	                        <?php
if ($display_no_of_comments) {
    ?>
		<span class="single-comic-total-comments">
		               <i class="far fa-lg fa-comment-dots" aria-hidden="true"></i><?php comments_number('0', '1', '%');?>
		</span>
		<?php
}
?>
     <?php
if ($display_no_views) {
    ?>
<span class="single-comic-total-views">
               <i class="far fa-lg fa-eye" aria-hidden="true"></i><?php echo wp_kses_data(toocheke_get_post_views(get_the_ID())); ?>
</span>
<?php
}
?>
		                  <?php
if ($display_likes):
?>
		            <span class="single-comic-total-likes">
		               <?php echo do_shortcode("[toocheke-like-button]"); ?>
		</span>
		<?php
endif;
?>
           <?php
if ($display_bookmark_button) {
    ?>
<a id="comic-bookmark" class="single-comic-bookmark" href="javascript:;">
<i class="far fa-lg fa-bookmark"></i>
</a>
<?php
}
?>

	                  </div>
		            </div>
                    <?php
if (($allow_home_comments === '1' && is_home() && $below_comic) || ($allow_home_comments === '1' && is_singular('series'))) {
    ?>
    <div id="comments-wrapper" class="row">
	        <div class="col-lg-12">
	        								<?php
global $withcomments;
    // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
    $withcomments = "1";
    comments_template();
    ?>
       </div>
		            </div>
    <?php
}

?>
