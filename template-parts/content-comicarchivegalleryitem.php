<?php
/**
 * Template part for displaying list of comics
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package snbtoocheke
 */

?>

<?php
echo '<span class="comic-thumbnail-wrapper">';
if ( get_the_post_thumbnail(get_the_ID()) != '' ) {

    echo '<a href="'; the_permalink(); echo '">';
    the_post_thumbnail('thumbnail');
    echo '</a>';
  
  } else {
    
   echo '<a href="'; the_permalink(); echo '" >';
   echo '<img src="';
   echo esc_attr(toocheke_catch_that_image());
   echo '" alt="" />';
   echo '</a>';
 
  
  }
  echo '<br/>';
  toocheke_posted_on();
  echo '</span>';

