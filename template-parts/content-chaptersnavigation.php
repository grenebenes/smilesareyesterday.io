<?php
/**
 * Template part for chapters navigation
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */
$display_default = get_option('toocheke-comics-navigation') && 1 == get_option('toocheke-comics-navigation');
$show_chapter_header = get_query_var('show_chapter_header'); //show header only for traditional layout and not on webtoon layout
$display_chapters_navigation = get_option('toocheke-chapter-navigation-buttons') && 1 == get_option('toocheke-chapter-navigation-buttons');
$comic_order = get_option('toocheke-chapter-first-comic') ? get_option('toocheke-chapter-first-comic') : 'DESC';
$series_id = null;
$comic_id = null;
$series_id = isset($_GET['sid']) ? (int) $_GET['sid'] : null;
if (get_query_var('series_id')) {
    $series_id = (int) get_query_var('series_id');
}
if (is_singular('series') && !$series_id) {
    $series_id = get_the_ID();
}
if (is_singular('comic') ) {
    $comic_id = get_the_ID();
}
if (get_query_var('comic_id') && !$comic_id) {
    $comic_id = (int) get_query_var('comic_id');
}
$previous_chapter = toocheke_get_previous_chapter($series_id, $comic_id);
$next_chapter = toocheke_get_next_chapter($series_id, $comic_id);
$display_navigation = $previous_chapter || $next_chapter;
?>

<?php
if ($display_chapters_navigation && $display_navigation):

?>
<div class="<?php echo esc_attr($show_chapter_header ? 'chapter-inline-nav' : 'chapter-footer-nav') ?>">
    <a href="<?php echo esc_url($previous_chapter) ?>"
        class="float-left <?php echo empty($previous_chapter) ? 'd-none' : ''; ?>">
        <?php if ($display_default || !$show_chapter_header ): ?>
        <i class="fa fa-chevron-circle-left fa-lg"></i>
        <?php else: ?>
        <img class="comic-image-nav" src="<?php echo esc_attr(get_option('toocheke-previous-chapter-button')) ?>" />
        <?php endif;?>
    </a>
    <span class="chapters-nav-label float-left <?php echo $display_default ? '' : 'd-none'; ?>">CHAPTERS</span>
    <a href="<?php echo esc_url($next_chapter) ?>"
        class="float-left <?php echo empty($next_chapter) ? 'd-none' : ''; ?>">
        <?php if ($display_default || !$show_chapter_header ): ?>
        <i class="fa fa-chevron-circle-right fa-lg"></i>
        <?php else: ?>
        <img class="comic-image-nav" src="<?php echo esc_attr(get_option('toocheke-next-chapter-button')) ?>" />
        <?php endif;?>
    </a>
</div>
<?php

endif;
?>