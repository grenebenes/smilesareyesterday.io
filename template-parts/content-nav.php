<?php
/**

 * Template part for displaying nav

 *

 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/

 *

 * @package Toocheke

 */

$fix_nav = get_query_var('fix_nav');

$display_bookmark_button = get_option('toocheke-comic-bookmark') && 1 == get_option('toocheke-comic-bookmark');

?>

<header id="masthead" class="site-header <?php echo $fix_nav ? "" : "header-below-jumbotron" ?>">



    <nav id="site-navigation" role="navigation"

        class="navbar navbar-expand-md  navbar-light bg-white <?php echo $fix_nav ? "fixed-top" : "" ?>"

        aria-label="<?php esc_attr_e('Primary Menu', 'toocheke');?>">

        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#bs4Navbar"

            aria-controls="bs4Navbar" aria-expanded="false" aria-label="Toggle navigation">

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

        </button>

        <?php if (function_exists('the_custom_logo')): ?>

        <?php

the_custom_logo();

endif;

?>



        <?php

$menu_alignment = get_theme_mod("menu_alignment_control") ? get_theme_mod("menu_alignment_control") : 'right';

$menu_class = 'ml-auto';

switch ($menu_alignment) {

    case "right":

        $menu_class = "ml-auto";

        break;

    case "left":

        $menu_class = "mr-auto";

        break;

    case "center":

        $menu_class = "mx-auto";

        break;

}

wp_nav_menu(array(

    'theme_location' => 'primary',

    'container' => 'div',

    'container_id' => 'bs4Navbar',

    'container_class' => 'collapse navbar-collapse',

    'menu_id' => 'main-menu',

    'menu_class' => 'navbar-nav ' . $menu_class,

    'depth' => '2',

    'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',

    'walker' => new WP_Bootstrap_Navwalker(),

));

?>

    </nav>





</header><!-- #masthead -->