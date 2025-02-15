<?php
/**
 * Template Name: Comics Landing Page
 *
 * This is a page template you can use if you do not want Toocheke's default comics page for your home page.
 *
 * @package Toocheke
 */

get_header();
$display_multiple_series = get_option('toocheke-display-multiple-series') && get_option('toocheke-display-multiple-series') === '1';
if ($display_multiple_series) {
    get_template_part('template-parts/content', 'indexmultipleseries');
} else {
    get_template_part('template-parts/content', 'indexsingleseries');


}

get_sidebar();
get_footer();
