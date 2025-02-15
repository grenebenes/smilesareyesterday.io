<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Toocheke
 */

get_header();
$display_multiple_series = get_option('toocheke-display-multiple-series') && get_option('toocheke-display-multiple-series') === '1';
$display_infinite_scroll = get_option('toocheke-infinite-scroll') && 1 == get_option('toocheke-infinite-scroll');
if($display_infinite_scroll){
    get_template_part('template-parts/content', 'indexinfinitescroll');
}
else{
    if ($display_multiple_series) {
        get_template_part('template-parts/content', 'indexmultipleseries');
    } else {
        get_template_part('template-parts/content', 'indexsingleseries');
        
    
    }
}


get_sidebar();
get_footer();
