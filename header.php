<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Toocheke
 */
$home_layout = get_theme_mod('home_layout_setting', 'default');
$body_css = get_theme_mod('sidebar_setting') ? 'nosidebar' : '';
// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
$body_css = isset($_GET['sid']) ? $body_css . ' series-id-' . wp_unslash($_GET['sid']) : $body_css;
$add_padding_to_header_top = 'alt-1' === $home_layout || 'alt-2' === $home_layout || 'alt-3' === $home_layout;
$add_padding_to_header_bottom = 'alt-5' === $home_layout;
?>
<!doctype html>
<html <?php language_attributes();?>>
<head>
	<meta charset="<?php bloginfo('charset');?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head();?>
</head>

<body <?php body_class(esc_attr($body_css));?>>
<?php wp_body_open();?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'toocheke');?></a>


<?php

if ('alt-4' === $home_layout || 'alt-5' === $home_layout) {
	// set nav variable
	set_query_var('fix_nav', 0);
    get_template_part('template-parts/content', 'jumbotron');   
    get_template_part('template-parts/content', 'nav');


} else {
    set_query_var('fix_nav', 1);
    get_template_part('template-parts/content', 'nav');
    get_template_part('template-parts/content', 'jumbotron');
}
?>

	<main role="main" class="site-main" id="main">
		<!--BELOW HEADER-->
		<?php if (is_active_sidebar('below-header')): ?>
		<div id="below-header" class="<?php echo( $add_padding_to_header_top ? esc_attr('below-header-padding-top') : '');?> <?php echo( $add_padding_to_header_bottom ? esc_attr('below-header-padding-bottom') : esc_attr(''));?>">
		<?php dynamic_sidebar('below-header');?>
		</div>
		<?php endif;?>
		<!--./BELOW HEADER-->
         <!-- START MAIN CONTENT -->
         <div id="content" class="site-content">

