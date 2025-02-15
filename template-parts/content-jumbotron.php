<?php
/**
 * Template part for displaying jumbotron
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */
$fix_nav = get_query_var('fix_nav');
$series_id = 0;
$series_id = isset($_GET['sid']) ? (int) $_GET['sid'] : 0;
$headerUrl = null;
$mobileHeaderUrl = null;
$header_link = get_theme_mod('header_link_setting') ? get_theme_mod('header_link_setting') : null;

if (is_singular('series') && !is_archive()) {
    $series_id = get_the_ID();
}

?>
<!-- START JUMBOTRON -->
<?php
if(has_header_image()){
	$headerUrl = get_header_image();
}
if(!isset($headerUrl)){
	if(get_theme_support('custom-header', 'default-image')){
		$headerUrl = get_theme_support('custom-header', 'default-image');
	}

}
$mobileHeaderUrl = get_theme_mod( 'mobile_header_image') != "" ? get_theme_mod('mobile_header_image') : $headerUrl;

if ($series_id > 0 && get_post_meta($series_id, 'series_hero_image_id', true)) {
    $series_hero_id = get_post_meta($series_id, 'series_hero_image_id', true);
    $mobileHeaderUrl = $headerUrl = wp_get_attachment_image_url($series_hero_id, 'full', false);
	
}
if ($series_id > 0 && get_post_meta($series_id, 'series_mobile_hero_image_id', true)) {
	$series_mobile_hero_id = get_post_meta($series_id, 'series_mobile_hero_image_id', true);
	$mobileHeaderUrl =  wp_get_attachment_image_url($series_mobile_hero_id, 'full', false);
}
?>
<!-- START DESKTOP JUMBOTRON -->

         <div class="jumbotron-header jumbotron jumbotron-fluid d-none d-lg-flex <?php echo $fix_nav ? "" : "jumbotron-top" ?>" <?php echo (isset($headerUrl) && !empty($headerUrl)) ? "style='background-image: url(" . esc_url($headerUrl) . ")'": "style='min-height: 320px'"; ?>>
		 <?php echo $header_link && isset($headerUrl) ? '<a href="' . esc_url($header_link) . '">' : '' ?>
		 <?php echo (isset($headerUrl)) ? "<img class='jumbotron-img' src='" . esc_url($headerUrl) . "' />": ""; ?>
		 <?php echo $header_link && isset($headerUrl)  ? '</a>' : '' ?>
		 <?php
if (display_header_text() == true):
?>

               <div class="comic-info col-md-12">
			   <?php
if (is_front_page() && is_home()):
?>
				<h1 class="site-title" ><?php esc_html(bloginfo('name'));?></h1>
				<?php
else:
?>
				<p class="site-title"><?php esc_html(bloginfo('name'));?></p>
				<?php
endif;
$toocheke_description = get_bloginfo('description', 'display');
if ($toocheke_description || is_customize_preview()):
?>
				<p class="site-description">
				<?php echo wp_kses_data($toocheke_description); ?>
				</p>
			<?php endif;?>

               </div>

			<?php endif;?>
         </div>
		 <!-- END DESKTOP JUMBOTRON -->
		 <!-- START MOBILE JUMBOTRON -->

         <div class="jumbotron-header jumbotron jumbotron-fluid d-flex d-lg-none <?php echo $fix_nav ? "" : "jumbotron-top" ?>" <?php echo (isset($mobileHeaderUrl) && !empty($mobileHeaderUrl)) ? "style='background-image: url(" . esc_url($mobileHeaderUrl) . ")'": "style='min-height: 320px'"; ?>>
		 <?php echo $header_link && isset($mobileHeaderUrl) ? '<a href="' . esc_url($header_link) . '">' : '' ?>
		 <?php echo (isset($mobileHeaderUrl)) ? "<img class='jumbotron-img' src='" . esc_url($mobileHeaderUrl) . "' />": ""; ?>
		 <?php echo $header_link && isset($mobileHeaderUrl)  ? '</a>' : '' ?>
		 <?php
if (display_header_text() == true):
?>

               <div class="comic-info col-md-12">
			   <?php
if (is_front_page() && is_home()):
?>
				<h1 class="site-title" ><?php esc_html(bloginfo('name'));?></h1>
				<?php
else:
?>
				<p class="site-title"><?php esc_html(bloginfo('name'));?></p>
				<?php
endif;
$toocheke_description = get_bloginfo('description', 'display');
if ($toocheke_description || is_customize_preview()):
?>
				<p class="site-description">
				<?php echo wp_kses_data($toocheke_description); ?>
				</p>
			<?php endif;?>

               </div>

			<?php endif;?>
         </div>
		 <!-- END MOBILE JUMBOTRON -->
         <!-- END JUMBOTRON -->