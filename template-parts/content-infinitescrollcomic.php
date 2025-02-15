<?php
/**
 * Template part for displaying infinite scroll comic item
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */

?>

<?php
$comic_layout = get_option('toocheke-comic-layout-devices');
$wrapper_id = $comic_layout === '1' ? 'two-comic-options' : 'one-comic-option';
$is_responsive = $comic_layout === '1' ? true : false;
$display_likes = get_option('toocheke-comic-likes') && 1 == get_option('toocheke-comic-likes');
$display_no_views = get_option('toocheke-comic-no-of-views') && 1 == get_option('toocheke-comic-no-of-views');
$display_no_of_comments = get_option('toocheke-comic-no-of-comments') && 1 == get_option('toocheke-comic-no-of-comments');
$allowed_tags = array(
    'a' => array(
        'class' => array(),
        'href' => array(),
        'rel' => array(),
        'title' => array(),
    ),
    'picture' => array(

    ),
    'figure' => array(
        'id' => array(),
        'class' => array(),
        'aria-describedby' => array(),
        'style' => array(),
    ),
    'figcaption' => array(
        'id' => array(),
        'class' => array(),
    ),
    'img' => array(
        'src' => array(),
        'alt' => array(),
        'width' => array(),
        'height' => array(),
        'class' => array(),
    ),
    'audio' => array(
        'controls' => array(),
        'autoplay' => array(),
        'loop' => array(),
        'muted' => array(),
        'preload' => array(),
    ),
    'source' => array(
        'src' => array(),
        'srcset' => array(),
        'type' => array(),
        'media' => array(),
        'sizes' => array(),
    ),
    'video' => array(
        'autoplay' => array(),
        'controls' => array(),
        'height' => array(),
        'loop' => array(),
        'muted' => array(),
        'poster' => array(),
        'preload' => array(),
        'src' => array(),
        'width' => array(),
    ),
    'track' => array(
        'src' => array(),
        'kind' => array(),
        'srclang' => array(),
        'label' => array(),
    ),
    'abbr' => array(
        'title' => array(),
    ),
    'b' => array(),
    'blockquote' => array(
        'cite' => array(),
    ),
    'br' => array(),
    'cite' => array(
        'title' => array(),
    ),
    'code' => array(),
    'del' => array(
        'datetime' => array(),
        'title' => array(),
    ),
    'dd' => array(),
    'div' => array(
        'class' => array(),
        'title' => array(),
        'style' => array(),
    ),
    'dl' => array(),
    'dt' => array(),
    'em' => array(),
    'h1' => array(),
    'h2' => array(),
    'h3' => array(),
    'h4' => array(),
    'h5' => array(),
    'h6' => array(),
    'i' => array(),
    'li' => array(
        'class' => array(),
    ),
    'ol' => array(
        'class' => array(),
    ),
    'p' => array(
        'class' => array(),
    ),
    'q' => array(
        'cite' => array(),
        'title' => array(),
    ),
    'span' => array(
        'class' => array(),
        'title' => array(),
        'style' => array(),
    ),
    'strike' => array(),
    'strong' => array(),
    'ul' => array(
        'class' => array(),
    ),
    'style' => array(

    ),
);
//widget above comic

echo '<div id="' . esc_attr($wrapper_id) . '">';
echo '<div id="spliced-comic">';
echo '<span class="default-lang">';
//show default/mobile content
the_content();

echo '</span>';
echo '<span class="alt-lang">';
//show 2nd language default/mobile content
echo wp_kses(get_post_meta($post->ID, 'mobile_comic_2nd_language_editor', true), $allowed_tags);

echo '</span>';
echo '</div>';
echo '<div id="unspliced-comic">';
echo '<span class="default-lang">';
//show content for desktop view
echo wp_kses(get_post_meta($post->ID, 'desktop_comic_editor', true), $allowed_tags);
echo '</span>';
echo '<span class="alt-lang">';
//show 2nd language content for desktop view
echo wp_kses(get_post_meta($post->ID, 'desktop_comic_2nd_language_editor', true), $allowed_tags);
echo '</span>';
echo '</div>';
echo '</div>';
global $chama_hide_content;
if (!empty(get_post_meta($post->ID, 'transcript', true)) && !$chama_hide_content):
    echo '<div id="transcript-wrapper" class="panel-group">';
    echo '<div class="panel">';
    echo '<div class="panel-heading"><h3 class="panel-title"><a data-toggle="collapse" href="#collapse-transcript">Transcript</a></h3> </div>';
    echo '<div id="collapse-transcript" class="panel-collapse collapse">';
    echo '<div id="transcript" tabindex="-1" class="panel-body">';
    echo '<hr/>';
    echo wp_kses(nl2br(get_post_meta($post->ID, 'transcript', true)), $allowed_tags);
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
endif;
// social and analytics
?>
    <div class="comic-title"><?php echo esc_html(get_the_title()); ?></div>
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
               <a href="<?php echo esc_url(get_permalink() . '#comments'); ?>" title="View comments"><i class="far fa-lg fa-comment-dots" aria-hidden="true"></i><?php comments_number('0', '1', '%');?></a>
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


	                  </div>
<footer class="entry-footer">

        <?php
//comic tags
$comic_tags = get_the_terms(get_the_ID(), 'comic_tags');
$tags_array = array();
if (is_array($comic_tags)) {
    foreach ($comic_tags as $comic_tag) {
        $url = get_term_link($comic_tag->slug, 'comic_tags');
        if ($series_id) {
            $url = add_query_arg('sid', $series_id, $url);
        }
        $tags_array[] = "<a href='{$url}'>{$comic_tag->name}</a>";

    }
}

if (!empty($tags_array)) {
    $tags_list = implode(', ', $tags_array);
    print_r('<b>Tags</b>: ' . $tags_list);
    echo '<br/>';
}
//comic characters
$comic_characters = get_the_terms(get_the_ID(), 'comic_characters');
$characters_array = array();
if (is_array($comic_characters)) {
    foreach ($comic_characters as $comic_character) {
        $url = get_term_link($comic_character->slug, 'comic_characters');
        if ($series_id) {
            $url = add_query_arg('sid', $series_id, $url);
        }
        $characters_array[] = "<a href='{$url}'>{$comic_character->name}</a>";

    }
}
if (!empty($characters_array)) {
    $characters_list = implode(', ', $characters_array);
    print_r('<b>Characters</b>: ' . $characters_list);
    echo '<br/>';
}

//comic locations
$comic_locations = get_the_terms(get_the_ID(), 'comic_locations');
$locations_array = array();
if (is_array($comic_locations)) {
    foreach ($comic_locations as $comic_location) {
        $url = get_term_link($comic_location->slug, 'comic_locations');
        if ($series_id) {
            $url = add_query_arg('sid', $series_id, $url);
        }
        $locations_array[] = "<a href='{$url}'>{$comic_location->name}</a>";

    }
}

if (!empty($locations_array)) {
    $locations_list = implode(', ', $locations_array);
    print_r('<b>Locations</b>: ' . $locations_list);
    echo '<br/>';
}

?>
</footer>
<hr />
