<?php
/**
 * The header for comic page
 *
 * This is the template that displays all of the <head> section and everything up until <main class="container">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Toocheke
 */
$is_bilingual = get_option('toocheke-bilingual-display') && 1 == get_option('toocheke-bilingual-display');
// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
$series_class = isset($_GET['sid']) ? 'series-id-' . wp_unslash($_GET['sid']) : '';

?>
<!doctype html>
<html <?php language_attributes();?>>

<head>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head();?>
</head>

<body <?php body_class(esc_attr($series_class));?>>
    <?php wp_body_open();?>
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'toocheke');?></a>

    <!-- START NAVBAR -->
    <header id="header-comic">
        <div id="comic-nav-top">
            <div class="row">
                <div class="col-7">
                    <span class="home comic-navigation">
                        <a href="<?php print esc_url(home_url());?>" title="Home">
                            <i class="fas fa-lg fa-home"></i>
                        </a>
                    </span>
                    <div id="comic-nav-name-wrapper">
                        <div id="comic-nav-name">
                            <span class="default-lang">
                                <?php the_title();?>
                            </span>
                            <span class="alt-lang">
                                <?php
if ($is_bilingual) {
    $alt_title = get_post_meta($post->ID, 'comic-title-2nd-language-display', true);
    echo esc_html($alt_title);
}
?>
                            </span>
                        </div>
                    </div>
                </div>
                <div id="comic-nav-share" class="col-5 comic-navigation">
                    &nbsp;
                    <?php
//check if plugin/post type has been activated
if (post_type_exists('comic')):
    do_action('toocheke_get_sharing_buttons');
endif;
?>
                </div>
            </div>
        </div>
    </header>
    <!-- END NAVBAR -->
    <main role="main">
