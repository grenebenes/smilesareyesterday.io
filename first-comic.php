<?php 
/**
 * Template Name: First Comic Page
 *  
 * This is a page template you can use for the latest comic page
 *
 * @package Toocheke
 */

$args = array(
    'posts_per_page' => '1',
    'post_type' => 'comic',
    'order'  => 'ASC',

);
$comic_posts = get_posts($args);
if($comic_posts){
    $url =  get_permalink ($comic_posts[0]->ID);    
    wp_redirect( $url, 301 ); 
    exit;
}