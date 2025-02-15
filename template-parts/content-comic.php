<?php
/**
 * Template part for displaying list of comics
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */

?>

<?php
$series_id = null;
$series_id = isset($_GET['sid']) ? (int) $_GET['sid'] : null;

$comic_layout = get_option('toocheke-comic-layout-devices');
$wrapper_id = $comic_layout === '1' ? 'two-comic-options' : 'one-comic-option';
$is_responsive = $comic_layout === '1' ? true : false;
$click_to_next_comic = get_option('toocheke-click-comic-next') && 1 == get_option('toocheke-click-comic-next');
$next_link = toocheke_get_next_comic_link($post->ID, 0, $series_id);
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
        'title' => array(),
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
    'h1' => array(
        'class' => array(),
        'title' => array(),
        'style' => array(),
    ),
    'h2' => array(
        'class' => array(),
        'title' => array(),
        'style' => array(),
    ),
    'h3' => array(
        'class' => array(),
        'title' => array(),
        'style' => array(),
    ),
    'h4' => array(
        'class' => array(),
        'title' => array(),
        'style' => array(),
    ),
    'h5' => array(
        'class' => array(),
        'title' => array(),
        'style' => array(),
    ),
    'h6' => array(
        'class' => array(),
        'title' => array(),
        'style' => array(),
    ),
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
dynamic_sidebar('above-comic');
echo '<div id="' . esc_attr($wrapper_id) . '">';
echo '<div id="spliced-comic">';
echo '<span class="default-lang">';
echo (strlen($next_link[0]) > 0 && $click_to_next_comic) ? '<a href="' . esc_attr($next_link[0]) . '" title="' . esc_attr($next_link[1]) . '">' : '';
//show default/mobile content
the_content();
echo (strlen($next_link[0]) > 0 && $click_to_next_comic) ? '</a>' : '';
echo '</span>';
echo '<span class="alt-lang">';
echo (strlen($next_link[0]) > 0 && $click_to_next_comic) ? '<a href="' . esc_attr($next_link[0]) . '" title="' . esc_attr($next_link[1]) . '">' : '';
//show 2nd language default/mobile content
echo wp_kses(get_post_meta($post->ID, 'mobile_comic_2nd_language_editor', true), $allowed_tags);
echo (strlen($next_link[0]) > 0 && $click_to_next_comic) ? '</a>' : '';
echo '</span>';
echo '</div>';
echo '<div id="unspliced-comic">';
echo '<span class="default-lang">';
echo (strlen($next_link[0]) > 0 && $click_to_next_comic) ? '<a href="' . esc_attr($next_link[0]) . '" title="' . esc_attr($next_link[1]) . '">' : '';
//show content for desktop view
echo wp_kses(get_post_meta($post->ID, 'desktop_comic_editor', true), $allowed_tags);
echo (strlen($next_link[0]) > 0 && $click_to_next_comic) ? '</a>' : '';
echo '</span>';
echo '<span class="alt-lang">';
echo (strlen($next_link[0]) > 0 && $click_to_next_comic) ? '<a href="' . esc_attr($next_link[0]) . '" title="' . esc_attr($next_link[1]) . '">' : '';
//show 2nd language content for desktop view
echo wp_kses(get_post_meta($post->ID, 'desktop_comic_2nd_language_editor', true), $allowed_tags);
echo (strlen($next_link[0]) > 0 && $click_to_next_comic) ? '</a>' : '';
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
//widget below comic
dynamic_sidebar('below-comic');
?>

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
