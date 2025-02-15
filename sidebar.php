<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Toocheke
 */

if (!is_active_sidebar('right-sidebar')) {
    return;
}
?>
    <!--START SIDEBAR-->
 <div class="col-lg-4">
                  <div id="side-bar" class="secondary">
	<?php
if (is_singular('series') && get_post_meta(get_the_ID(), 'series_sidebar_content', true)) {
    echo '<section>';
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo get_post_meta(get_the_ID(), 'series_sidebar_content', true);
    echo '</section>';
} else {
    dynamic_sidebar('right-sidebar');
}

?>
    </div>
               </div>
               <!--END SIDEBAR-->
