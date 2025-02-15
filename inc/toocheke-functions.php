<?php
/**
 * Toocheke functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage toocheke
 */

//Load theme functions
//require_once trailingslashit( get_template_directory() ) . 'inc/template-functions.php';
/**
 * Note: Do not add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * http://codex.wordpress.org/Child_Themes
 */
if (!function_exists('toocheke_setup')):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function toocheke_setup()
{
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Toocheke, use a find and replace
         * to change 'toocheke' to the name of your theme in all the template files.
         */
        load_theme_textdomain('toocheke', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'toocheke'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('toocheke_custom_background_args', array(
            'default-color' => 'f5f5f5',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height' => 45,
            'width' => 45,
            'flex-width' => true,
            'flex-height' => false,
        ));

    }
endif;
add_action('after_setup_theme', 'toocheke_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
if (!function_exists('toocheke_content_width')):
    function toocheke_content_width()
{
        // This variable is intended to be overruled from themes.
        // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
        // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
        $GLOBALS['content_width'] = apply_filters('toocheke_content_width', 1140);
    }
endif;
add_action('after_setup_theme', 'toocheke_content_width', 0);
/**
 * Apply theme's stylesheet to the visual editor.
 *
 * @uses add_editor_style() Links a stylesheet to visual editor
 * @uses get_stylesheet_uri() Returns URI of theme stylesheet
 */
if (!function_exists('toocheke_add_editor_styles')):
    function toocheke_add_editor_styles()
{
        add_editor_style(get_stylesheet_uri());
    }
endif;
add_action('init', 'toocheke_add_editor_styles');
/**
 * Enqueue scripts and styles.
 */
if (!function_exists('toocheke_scripts')):
    function toocheke_scripts()
{
        wp_enqueue_style('bs-css', get_template_directory_uri() . '/dist/css/bootstrap.min.css');
        wp_enqueue_style('bs-smartmenus', get_template_directory_uri() . '/dist/css/jquery.smartmenus.bootstrap-4.css');

        wp_enqueue_style('toocheke-font-awesome', get_template_directory_uri() . '/fonts/font-awesome/css/all.min.css', array(), wp_get_theme()->get('Version'));

        wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/dist/css/owl.carousel.min.css');
        wp_enqueue_style('owl-theme-default', get_template_directory_uri() . '/dist/css/owl.theme.default.min.css');

        wp_register_style('google-font-hind', '//fonts.googleapis.com/css?family=Hind:regular,medium,bold,bolditalic,semibold', array(), null, 'all');
        wp_enqueue_style('google-font-hind');

        wp_enqueue_style('toocheke-style', get_stylesheet_uri());

        wp_enqueue_script('popper', get_template_directory_uri() . '/src/js/popper.min.js', array(), '20240427', true);

        wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/src/js/owl.carousel.min.js', array(), '20240427', true);

        wp_enqueue_script('tether', get_template_directory_uri() . '/src/js/tether.min.js', array(), '20240427', true);

        wp_enqueue_script('bootstrap', get_template_directory_uri() . '/src/js/bootstrap.min.js', array('jquery'), '20240427', true);

        wp_enqueue_script('skip-link-focus-fix', get_template_directory_uri() . '/src/js/skip-link-focus-fix.js', array(), '20240427', true);

        wp_enqueue_script('jquery-smartmenus', get_template_directory_uri() . '/src/js/jquery.smartmenus.min.js', array(), '20240427', true);

        wp_enqueue_script('jquery-smartmenus-bs4', get_template_directory_uri() . '/src/js/jquery.smartmenus.bootstrap-4.min.js', array(), '20240427', true);

        wp_enqueue_script('clipboard', get_template_directory_uri() . '/src/js/clipboard.min.js', array(), '20240427', true);

        wp_enqueue_script('toocheke-functions', get_template_directory_uri() . '/src/js/functions.js', array(), '20240427', true);

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
endif;
add_action('wp_enqueue_scripts', 'toocheke_scripts');
/*
 * Register required plugins
 */
// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'toocheke_register_required_plugins');
/*
 * Register the required plugins for this theme.
 */
if (!function_exists('toocheke_register_required_plugins')):
    function toocheke_register_required_plugins()
{
        /*
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */
        $plugins = array(

            // Include the Toocheke plugin bundled with a theme.
            array(
                'name' => 'Toocheke Companion',
                'slug' => 'toocheke-companion',
                //'source'             => 'https://downloads.wordpress.org/plugin/toocheke-companion.zip', // The plugin source.
                'required' => false, // If false, the plugin is only 'recommended' instead of required.
                'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
                'external_url' => '', // If set, overrides default API URL and points to an external URL.
                'is_callable' => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
            ),

        );

        /*
         * Array of configuration settings. Amend each line as needed.
         *
         */
        $config = array(
            'id' => 'toocheke', // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '', // Default absolute path to bundled plugins.
            'menu' => 'toocheke-install-plugins', // Menu slug.
            'has_notices' => true, // Show admin notices or not.
            'dismissable' => true, // If false, a user cannot dismiss the nag message.
            'dismiss_msg' => false, // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false, // Automatically activate plugins after installation or not.
            'message' => '', // Message to output right before the plugins table.

        );

        tgmpa($plugins, $config);
    }
endif;

//Comic Carousel Starts here
/**
 * Comic Carousel
 */
if (!function_exists('toocheke_load_comic_carousel')):
    function toocheke_load_comic_carousel($collection_id)
{
        set_query_var('collection_id', $collection_id);
        get_template_part('template-parts/content', 'comiccarousel');

    }
endif;
//Comic Carousel Ends here

/* ========================================================================================================================

Comments

======================================================================================================================== */

/**
 * Post Publish Date.
 */
function toocheke_get_day_name($timestamp)
{

    $date = date('M d, Y', $timestamp);

    if ($date == date('M d, Y')) {
        $date = 'Today';
    } else if ($date == date('M d, Y', strtotime("-1 days"))) {
        $date = 'Yesterday';
    }
    return $date;
}
/**
 * Home Layout
 */

// Update CSS within in Admin
function toocheke_render_home_layout_styles()
{
    wp_register_style('toocheke-home-custom-style', false);
    wp_enqueue_style('toocheke-home-custom-style');
    $home_layout = get_theme_mod('home_layout_setting', 'default');
    switch ($home_layout) {
        case 'default':
        case 'alt-5':
            return;
        case 'alt-1':
            $hide_object_selector = '#comic-archive-list, .jumbotron, #chapter-wrapper, #collection-wrapper, #series-wrapper, #blog-section';
            $show_object_selector = '#latest-comic';
            break;
        case 'alt-2':
            $hide_object_selector = '.jumbotron, #main-content-row, .post, #content .col-lg-4';
            $show_object_selector = '#latest-comic';
            break;
        case 'alt-3':
            $hide_object_selector = '#comic-archive-list, .jumbotron, #chapter-wrapper, #collection-wrapper, #series-wrapper, #blog-section';
            $show_object_selector = '#collections-owl-carousel-wrapper';
            break;
        case 'alt-4':
            $hide_object_selector = '#comic-archive-list, #chapter-wrapper, #collection-wrapper, #series-wrapper, #blog-section';
            $show_object_selector = '#latest-comic';
            break;
        default:
            $hide_object_selector = '#latest-comic';
            $show_object_selector = '#comic-archive-list, .jumbotron, #chapter-wrapper, #collection-wrapper, #series-wrapper, #blog-section';
    }

    $home_custom_css = "
		@media (min-width: 992px){
			#content{
				margin-top: 60px !important;
			}
	}
	@media (max-width: 991px){
		main {
			margin-top: 0px;
		}
		#content{
			margin-top: 35px !important;
		}
}

		{$hide_object_selector} {
			display: none !important;
				}
				{$show_object_selector} {
					display: block !important;
						}
				";
    wp_add_inline_style('toocheke-home-custom-style', $home_custom_css);
}
add_action('wp_enqueue_scripts', 'toocheke_render_home_layout_styles');
/**
 * Comic Layout
 */

// Update CSS within in Admin

function toocheke_render_comic_layout_styles()
{
    wp_register_style('toocheke-custom-style', false);
    wp_enqueue_style('toocheke-custom-style');
    $image_width = '100';
    $display = 'block';
    $layout = get_theme_mod('comic_layout_setting', 'default');
    if ('default' === $layout) {
        return;
    }
    switch ($layout) {
        case 'two':
            $image_width = '49';
            $display = 'inline-block';

            break;
        case 'three':
            $image_width = '32';
            $display = 'inline-block';
            break;
        case 'four':
            $image_width = '25';
            $display = 'inline-block';
            break;
        default:
            $image_width = '100';
            $display = 'block';
    }

    $custom_css = "
		@media (min-width: 990px){
		#comic img {
			max-width: {$image_width}% !important;
			width: {$image_width}% !important;
            height: auto !important;
            display:  {$display} !important;
                }
                #comics-carousel img {
                    max-width: 100% !important;
                    width: 100% !important;
                }
            }";
    wp_add_inline_style('toocheke-custom-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'toocheke_render_comic_layout_styles');
/**
 * Render series background image and color
 */
function toocheke_render_series_background_styles()
{
    $series_id = 0;
    $custom_css = '';
    if (is_singular('series')) {
        $series_id = get_the_ID();
    }
    if (is_singular('comic')) {
        $series_id = isset($_GET['sid']) ? (int) $_GET['sid'] : 0;
    }
    if ($series_id > 0) {
        if (is_singular('series') || is_singular('comic')) {
            wp_register_style('toocheke-series-custom-style', false);
            wp_enqueue_style('toocheke-series-custom-style');
            if (get_post_meta($series_id, 'series_hero_image_id', true)) {
                $series_hero_id = get_post_meta($series_id, 'series_bg_image_id', true);
                $series_bg_url = wp_get_attachment_image_url($series_hero_id, 'full', false);
                $custom_css .= '
                body{
                    background-image: url("' . $series_bg_url . '") !important;
                    background-position: left top;
                    background-size: auto;
                    background-repeat: repeat;
                    background-attachment: scroll;
                }
                ';
            }
            if (get_post_meta($series_id, 'series_bg_color', true)) {
                $bg_color = get_post_meta($series_id, 'series_bg_color');
                $custom_css .= '
                body{
                    background-color: ' . $bg_color[0] . ' !important;
                }
                ';
            }
        }
    }
    if (strlen($custom_css) > 0) {
        wp_add_inline_style('toocheke-series-custom-style', $custom_css);
    }

}
add_action('wp_enqueue_scripts', 'toocheke_render_series_background_styles');
/**
 * Get Series Link
 */
if (!function_exists('toocheke_get_series_link')):
    function toocheke_get_series_link($id)
{
        //global $post;
        $permalink = esc_url(get_permalink($id));
        $series = get_post($id);
        if ($series == null) {
            return;
        }

        $title = esc_attr($series->post_title);
        $series_link_html = '<a id="footer-series-link" href="' . $permalink . '" title="' . $title . '" >' . $title . '</a>';
        return $series_link_html;
    }
endif;
/**
 * Get Comic Link
 */
if (!function_exists('toocheke_get_comic_link')):
    function toocheke_get_comic_link($order, $font, $collection_id, $display_default_button = null, $image_button = null, $series_id = null)
{
        //global $post;
        $current_permalink = esc_url(get_permalink());
        $placeholder = $GLOBALS['post'];
        $image_button_url = null !== $image_button && strlen($image_button) > 0 ? get_option('toocheke-' . $image_button . '-button') : "";
        $button = $display_default_button ? '<i class="fas fa-lg fa-step-' . $font . '"></i>' : '<img class="comic-image-nav" src="' . esc_attr($image_button_url) . '" />';
        $args = array(
            'post_parent' => $series_id,
            'post_type' => 'comic',
            'numberposts' => 1,
            'offset' => 0,
            'orderby' => 'post_date',
            'order' => $order,
            'post_status' => 'publish');
        if ($collection_id > 0) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'collections',
                    'field' => 'term_id',
                    'terms' => $collection_id,
                ),
            );
        }

        $sorted_posts = get_posts($args);
        $permalink = esc_url(get_permalink($sorted_posts[0]->ID));
        if ($permalink == $current_permalink) {
            return;
        }

        $permalink = esc_url($collection_id > 0 ? add_query_arg('col', $collection_id, get_permalink($sorted_posts[0]->ID)) : get_permalink($sorted_posts[0]->ID));
        //add series id parameter
        $permalink = add_query_arg('sid', $series_id, $permalink);
        if (get_option('toocheke-scroll-past-header') && 1 == get_option('toocheke-scroll-past-header')) {
            $permalink = $permalink . '#main';
        }
        $title = esc_attr($sorted_posts[0]->post_title);
        $post = $placeholder;
        $font = esc_attr($font);
        $latest_link_html = '<a href="' . $permalink . '" title="' . $title . '" >' . $button . '</a>';
        return $latest_link_html;
    }
endif;
if (!function_exists('toocheke_adjacent_comic_link')):
    function toocheke_adjacent_comic_link($current_post_id, $current_publish_date, $collection_id, $direction, $display_default_button = null, $series_id = null)
{

        $nextID = $next_title = $next_link = $prevID = $prev_title = $prev_link = null;

        $current_formatted_publish_date = $current_publish_date->format('Y-m-d H:i:s');
        $siblings = toocheke_get_comic_siblings(1, $current_formatted_publish_date, $series_id, $direction, $collection_id);
        switch ($direction) {
            case 'next':
                if (!empty($siblings)) {
                    $nextID = $siblings[0]->ID;
                    $next_title = $siblings[0]->post_title;
                    $next_link = get_permalink($nextID);
                }

                break;
            case 'previous':
                if (!empty($siblings)) {
                    $prevID = $siblings[0]->ID;
                    $prev_title = $siblings[0]->post_title;
                    $prev_link = get_permalink($prevID);
                }
                break;
            default:
        }

        $image_button_url = null !== $direction && strlen($direction) > 0 ? get_option('toocheke-' . $direction . '-button') : "";

        // Return information
        if ($direction == 'next' and !empty($nextID)):
            $button = $display_default_button ? '<i class="fas fa-lg fa-chevron-right" aria-hidden="true"></i>' : '<img class="comic-image-nav" src="' . esc_attr($image_button_url) . '" />';
            $permalink = esc_url($collection_id > 0 ? add_query_arg('col', $collection_id, get_permalink($nextID)) : get_permalink($nextID));
            //add series id parameter
            $permalink = add_query_arg('sid', $series_id, $permalink);
            if (get_option('toocheke-scroll-past-header') && 1 == get_option('toocheke-scroll-past-header')) {
                $permalink = $permalink . '#main';
            }
            $link_html = '<a class="' . $direction . '-comic" href="' . $permalink . '" title="' . $next_title . '" >' . $button . '</a>';

        elseif ($direction == 'previous' and !empty($prevID)):
            $button = $display_default_button ? '<i class="fas fa-lg fa-chevron-left" aria-hidden="true"></i>' : '<img class="comic-image-nav" src="' . esc_attr($image_button_url) . '" />';
            $permalink = esc_url($collection_id > 0 ? add_query_arg('col', $collection_id, get_permalink($prevID)) : get_permalink($prevID));
            //add series id parameter
            $permalink = add_query_arg('sid', $series_id, $permalink);
            if (get_option('toocheke-scroll-past-header') && 1 == get_option('toocheke-scroll-past-header')) {
                $permalink = $permalink . '#main';
            }
            $link_html = '<a class="' . $direction . '-comic" href="' . $permalink . '" title="' . $prev_title . '" >' . $button . '</a>';

        else:
            return false;
        endif;
        return $link_html;
    }
endif;
if (!function_exists('toocheke_get_comic_siblings')):
    function toocheke_get_comic_siblings($limit = 1, $date = '', $series_id = null, $direction = null, $collection_id = 0)
{
        global $wpdb;

        $limit = absint($limit);
        if (!$limit) {
            return;
        }

        switch ($direction) {
            case 'next':
                $query = "
																											            SELECT
																											            p.post_title,
																											            p.post_date,
																											            p.ID
																											        FROM
																											            $wpdb->posts p
																										            LEFT JOIN  $wpdb->term_relationships  as t
																										            ON p.ID = t.object_id
																											        WHERE
																											            %1s = %s AND
																										                %1s = %s AND
																											            p.post_date > '%s' AND
																											            p.post_type = 'comic' AND
																											            p.post_status = 'publish'
																											        ORDER by
																											            p.post_date ASC
																											        LIMIT
																											            %d
																											            ";
                break;
            case 'previous':
                $query = "
																											            SELECT
																											            p.post_title,
																											            p.post_date,
																											            p.ID
																											        FROM
																											            $wpdb->posts p
																										            LEFT JOIN  $wpdb->term_relationships  as t
																										            ON p.ID = t.object_id
																											        WHERE
																											            %1s = %s AND
																										                %1s = %s AND
																											            p.post_date < '%s' AND
																											            p.post_type = 'comic' AND
																											            p.post_status = 'publish'
																											        ORDER by
																											            p.post_date DESC
																											        LIMIT
																											            %d
																											            ";

                break;
            default:
        }
        // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        $sql = $wpdb->prepare($query, 1, 1, 1, 1, $date, $limit);
        if ($series_id && $collection_id == 0) {
            if ($series_id) {
                // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                $sql = $wpdb->prepare($query, 'p.post_parent', $series_id, 1, 1, $date, $limit);
            } else {
                // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                $sql = $wpdb->prepare($query, 1, 1, 1, 1, $date, $limit);
            }
        }
        if (!$series_id && $collection_id > 0) {
            if ($collection_id > 0) {
                // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                $sql = $wpdb->prepare($query, 1, 1, 't.term_taxonomy_id', $collection_id, $date, $limit);
            } else {
                // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                $sql = $wpdb->prepare($query, 1, 1, 1, 1, $date, $limit);
            }
        }

// phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        $p = $wpdb->get_results($sql);
// Print last SQL query string
        //echo $wpdb->last_query;

// Print last SQL query result
        //echo $wpdb->last_result;

// Print last SQL query Error
        //echo $wpdb->last_error;
        //var_dump( $p ) ;

        return $p;
    }

endif;
if (!function_exists('toocheke_get_next_comic_link')):
    function toocheke_get_next_comic_link($current_post_id, $collection_id, $series_id = null)
{
        $permalink = '';
        $next_title = '';
        // Info
        $postIDs = array();

        $args = array(
            'post_parent' => $series_id,
            'post_type' => 'comic',
            'nopaging' => true,
            'offset' => 0,
            'orderby' => 'post_date',
            'order' => 'ASC',
            'post_status' => 'publish');

        if ($collection_id > 0) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'collections',
                    'field' => 'term_id',
                    'terms' => $collection_id,
                ),
            );
        }

        $comic_posts = get_posts($args);

        // Get post IDs
        foreach ($comic_posts as $thepost):
            $postIDs[] = $thepost->ID;
        endforeach;

        // Get prev and next post ID
        $currentIndex = array_search($current_post_id, $postIDs);

        if ($currentIndex < count($comic_posts) - 1) {
            $nextID = $postIDs[$currentIndex + 1];
            $next_title = esc_attr($comic_posts[$currentIndex + 1]->post_title);
        }

        // Return information
        if (!empty($nextID)):
            $permalink = esc_url($collection_id > 0 ? add_query_arg('col', $collection_id, get_permalink($nextID)) : get_permalink($nextID));
            //add series id parameter
            $permalink = add_query_arg('sid', $series_id, $permalink);

        endif;
        return array($permalink, $next_title);
    }
endif;
/**
 * Get Comic Number
 */
function toocheke_get_comic_number()
{
    global $post;
    $comic_number = "#" . get_post_meta($post->ID, 'incr_number', true);
    return wp_kses_data($comic_number);
}

/**
 * Generate Comic Link
 */
function toocheke_get_random_comic()
{

    $random_args = array('post_type' => 'comic', 'posts_per_page' => 1, 'orderby' => 'rand');
    $random_comics_query = new WP_Query($random_args);
    while ($random_comics_query->have_posts()): $random_comics_query->the_post();
        $link = '<a href="' . esc_url(get_the_permalink()) . '" title="' . esc_attr(get_the_title()) . '" ><i class="fas fa-lg fa-random"></i></a>';
    endwhile;
    wp_reset_postdata();
    return $link;
}
/**
 * Get Random Comic Link
 */
function toocheke_random_comic_url($title = 'Random Post')
{
    // Get the URL of a random post and format it as a clickable link
    $posts = get_posts('post_type=comic&orderby=rand&numberposts=1');
    foreach ($posts as $post) {
        $link = esc_url(get_permalink($post));
    }
    // Return the link to wherever this function is called
    return $link;
}
/**
 * Redirect to Random Comic
 */

function toocheke_redirect_random_comic()
{

    $rand_args = array(
        'posts_per_page' => 1,
        'post_type' => 'comic',
        'orderby' => 'rand',
        'post_status' => 'publish',
    );

    $random_comic = get_posts($rand_args);
    if (is_array($random_comic)) {
        $random_comic = reset($random_comic);
        wp_redirect(esc_url(get_permalink($random_comic->ID)));
    }

    exit;
}

if (isset($_GET['random'])) {
    add_action('template_redirect', 'toocheke_redirect_random_comic');
}

/**
 * Custom post type specific rewrite rules
 * @return wp_rewrite Rewrite rules handled by WordPress
 */
function toocheke_rewrite_rules($wp_rewrite)
{
    // Here we're hardcoding the CPT in, article in this case
    $rules = toocheke_generate_date_archives('comic', $wp_rewrite);
    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
    return $wp_rewrite;
}
add_action('generate_rewrite_rules', 'toocheke_rewrite_rules');

/**
 * Generate date archive rewrite rules for comic
 * @param  string $cpt slug of the custom post type
 * @return rules       returns a set of rewrite rules for WordPress to handle
 */
function toocheke_generate_date_archives($cpt, $wp_rewrite)
{
    $rules = array();
    $slug_archive = false;

    $post_type = get_post_type_object($cpt);
    if (!empty($post_type)) {
        $slug_archive = $post_type->has_archive;
    }
    if ($slug_archive === false) {
        return $rules;
    }
    if ($slug_archive === true) {
        // Here's my edit to the original function, let's pick up
        // custom slug from the post type object if user has
        // specified one.
        $slug_archive = $post_type->rewrite['slug'];
    }

    $dates = array(
        array(
            'rule' => "([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})",
            'vars' => array('year', 'monthnum', 'day'),
        ),
        array(
            'rule' => "([0-9]{4})/([0-9]{1,2})",
            'vars' => array('year', 'monthnum'),
        ),
        array(
            'rule' => "([0-9]{4})",
            'vars' => array('year'),
        ),
    );

    foreach ($dates as $data) {
        $query = 'index.php?post_type=' . $cpt;
        $rule = $slug_archive . '/' . $data['rule'];

        $i = 1;
        foreach ($data['vars'] as $var) {
            $query .= '&' . $var . '=' . $wp_rewrite->preg_index($i);
            $i++;
        }

        $rules[$rule . "/?$"] = $query;
        $rules[$rule . "/feed/(feed|rdf|rss|rss2|atom)/?$"] = $query . "&feed=" . $wp_rewrite->preg_index($i);
        $rules[$rule . "/(feed|rdf|rss|rss2|atom)/?$"] = $query . "&feed=" . $wp_rewrite->preg_index($i);
        $rules[$rule . "/page/([0-9]{1,})/?$"] = $query . "&paged=" . $wp_rewrite->preg_index($i);
    }
    return $rules;
}
/**
 * Generate allowed html tags for wp_kses()
 */
function toocheke_allowed_html()
{

    $allowed_tags = array(
        'a' => array(
            'id' => array(),
            'class' => array(),
            'href' => array(),
            'rel' => array(),
            'title' => array(),
        ),
        'abbr' => array(
            'title' => array(),
        ),
        'b' => array(),
        'blockquote' => array(
            'cite' => array(),
        ),
        'cite' => array(
            'title' => array(),
        ),
        'code' => array(),
        'del' => array(
            'datetime' => array(),
            'title' => array(),
        ),
        'dd' => array(),
        'div' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'dl' => array(),
        'dt' => array(),
        'em' => array(),
        'h1' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'h2' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'h3' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'h4' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'h5' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'h6' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'i' => array(
            'class' => array(),
        ),
        'iframe' => array(
            'scrolling' => array(),
            'seamless' => array(),
            'height' => array(),
            'frameborder' => array(),
            'width' => array(),
        ),
        'img' => array(
            'alt' => array(),
            'class' => array(),
            'height' => array(),
            'src' => array(),
            'width' => array(),
        ),
        'li' => array(
            'class' => array(),
        ),
        'ol' => array(
            'class' => array(),
        ),
        'p' => array(
            'class' => array(),
        ),
        'q' => array(
            'cite' => array(),
            'title' => array(),
        ),
        'span' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'strike' => array(),
        'strong' => array(),
        'ul' => array(
            'class' => array(),
        ),
        'style' => array(

        ),
        'svg' => array(
            'fill' => array(),
            'viewbox' => array(),
            'role' => array(),
            'xmlns' => array(),
        ),
        'path' => array(
            'd' => array(),
            'fill' => array(),
            'role' => array(),
            'xmlns' => array(),
        ),
    );

    return $allowed_tags;
}
/* Get Comic Image */
function toocheke_catch_that_image()
{
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+?src=[\'"]([^\'"]+)[\'"].*?>/i', $post->post_content, $matches);
    if ($output) {
        $first_img = $matches[1][0];
    }

    if (empty($first_img)) {
        $first_img = esc_attr(get_stylesheet_directory_uri() . '/dist/img/default-thumbnail-image.png');
    }
    return $first_img;
}
function toocheke_catch_that_image_alt($comic)
{
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+?src=[\'"]([^\'"]+)[\'"].*?>/i', $comic->post_content, $matches);
    if ($output) {
        $first_img = $matches[1][0];
    }

    if (empty($first_img)) {
        $first_img = esc_attr(get_stylesheet_directory_uri() . '/dist/img/default-thumbnail-image.png');
    }
    return $first_img;
}

/* Register Post Views */
function toocheke_get_post_views($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}
function toocheke_set_post_views($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
/**
 * Handline infinite scroll for comic archive on home page
 */
/**
 * Javascript for Load More
 *
 */
function toocheke_load_more_js()
{

    if (!is_home()) {
        return;
    }

    $args = array(
        'url' => admin_url('admin-ajax.php'),
    );

    wp_enqueue_script('toocheke-load-more', get_template_directory_uri() . '/src/js/load-more.js', array('jquery'), '20240427', true);
    wp_localize_script('toocheke-load-more', 'toochekeloadmore', $args);

}
add_action('wp_enqueue_scripts', 'toocheke_load_more_js');

/**
 * AJAX Load More
 *
 */
function toocheke_ajax_load_more()
{
    $comic_order = get_option('toocheke-comics-order') ? get_option('toocheke-comics-order') : 'DESC';
    $args['order'] = $comic_order;
    $args['orderby'] = 'post_date';
    $args = isset($_POST['query']) ? array_map('esc_attr', sanitize_text_field(wp_unslash($_POST['query']))) : array();
    $args['post_type'] = isset($args['post_type']) ? esc_attr(sanitize_text_field(wp_unslash($args['post_type']))) : 'comic';
    $args['paged'] = isset($_POST['page']) ? esc_attr(sanitize_text_field(wp_unslash($_POST['page']))) : 2;
    $args['post_status'] = 'publish';

    ob_start();
    $loop = new WP_Query($args);
    if ($loop->have_posts()): while ($loop->have_posts()): $loop->the_post();
            get_template_part('template-parts/content', 'infinitescrollcomic');
        endwhile;endif;
    wp_reset_postdata();
    $data = ob_get_clean();
    wp_send_json_success($data);
    wp_die();
}
add_action('wp_ajax_toocheke_ajax_load_more', 'toocheke_ajax_load_more');
add_action('wp_ajax_nopriv_toocheke_ajax_load_more', 'toocheke_ajax_load_more');

/**
 * First Term
 * Helper Function
 */
function toocheke_helper_first_term($taxonomy, $field)
{
    $terms = get_the_terms(get_the_ID(), $taxonomy);

    if (empty($terms) || is_wp_error($terms)) {
        return false;
    }

    // If there's only one term, use that
    if (1 == count($terms)) {
        $term = array_shift($terms);
    } else {
        $term = array_shift($list);
    }

    // Output
    if ($field && isset($term->$field)) {
        return $term->$field;
    } else {
        return $term;
    }

}

/**
 * Check if default buttons should be displayed
 */
function toocheke_display_default_buttons()
{
    if (get_option('toocheke-comics-navigation') && 1 == get_option('toocheke-comics-navigation')) {
        return true;
    } else {
        if (get_option('toocheke-first-button') || get_option('toocheke-previous-button') || get_option('toocheke-next-button') || get_option('toocheke-latest-button') || get_option('toocheke-facebook-button') || get_option('toocheke-twitter-button') || get_option('toocheke-tumblr-button') || get_option('toocheke-reddit-button') || get_option('toocheke-copy-button')) {
            return false;
        } else {
            return true;
        }
    }
}
/**
 * Chapter navigation functions
 */
if (!function_exists('toocheke_get_previous_comic')):
    function toocheke_get_previous_comic($in_chapter = false)
{
        return toocheke_get_adjacent_comic(true, $in_chapter);
    }
endif;
if (!function_exists('toocheke_get_previous_comic_permalink')):
    function toocheke_get_previous_comic_permalink()
{
        $prev_comic = toocheke_get_previous_comic(false);
        if (is_object($prev_comic) && isset($prev_comic->ID)) {
            return get_permalink($prev_comic->ID);
        }
        return false;
    }
endif;
/*
if (!function_exists('toocheke_get_previous_comic_in_chapter_permalink')):
function toocheke_get_previous_comic_in_chapter_permalink()
{
$prev_comic = toocheke_get_previous_comic(true);
if (is_object($prev_comic) && isset($prev_comic->ID)) {
return get_permalink($prev_comic->ID);
}
//    Go to last comic of previous chapter if possible.

$chapter = toocheke_get_adjacent_chapter(true, $prev_comic->ID);
if (is_object($chapter)) {
$terminal = toocheke_get_chapter_comic_post($chapter->term_id, false);
return !empty($terminal) ? get_permalink($terminal->ID) : false;
}

return false;
}
endif;
 */
if (!function_exists('toocheke_get_next_comic')):
    function toocheke_get_next_comic($in_chapter = false)
{
        return toocheke_get_adjacent_comic(false, $in_chapter);
    }
endif;
if (!function_exists('toocheke_get_next_comic_permalink')):
    function toocheke_get_next_comic_permalink()
{
        $next_comic = toocheke_get_next_comic(false);
        if (is_object($next_comic) && isset($next_comic->ID)) {
            return get_permalink($next_comic->ID);
        }
        return false;
    }
endif;
/*
if (!function_exists('toocheke_get_next_comic_in_chapter_permalink')):
function toocheke_get_next_comic_in_chapter_permalink()
{
$next_comic = toocheke_get_next_comic(true);
if (is_object($next_comic) && isset($next_comic->ID)) {
return get_permalink($next_comic->ID);
}
// go to first comic of next chapter if possible

$chapter = toocheke_get_adjacent_chapter(false, $next_comic->ID);
if (is_object($chapter)) {
$terminal = toocheke_get_chapter_comic_post($chapter->term_id, true);
return !empty($terminal) ? get_permalink($terminal->ID) : false;
}

return false;
}
endif;
 */
// 0 means get the first of them all, no matter chapter, otherwise 0 = this chapter.
if (!function_exists('toocheke_get_chapter_comic_post')):
    function toocheke_get_chapter_comic_post($chapterID = 0, $first = true)
{

        $sortOrder = $first ? "asc" : "desc";

        if (!empty($chapterID)) {
            $chapter = get_term_by('id', $chapterID, 'chapters');
            $chapter_slug = $chapter->slug;
            $args = array(
                'chapters' => $chapter_slug,
                'order' => $sortOrder,
                'posts_per_page' => 1,
                'post_type' => 'comic',
            );
        } else {
            $args = array(
                'order' => $sortOrder,
                'posts_per_page' => 1,
                'post_type' => 'comic',
            );
        }

        $terminalComicQuery = new WP_Query($args);

        $terminalPost = false;
        if ($terminalComicQuery->have_posts()) {
            $terminalPost = reset($terminalComicQuery->posts);
        }
        return $terminalPost;
    }
endif;
/**
 * Retrieve adjacent post link.
 *
 */
if (!function_exists('toocheke_get_adjacent_comic')):
    function toocheke_get_adjacent_comic($previous = true, $in_same_chapter = false, $taxonomy = 'comic')
{
        global $post, $wpdb;
        if (empty($post)) {
            return null;
        }

        $current_post_date = $post->post_date;

        $join = '';

        if ($in_same_chapter) {
            $join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";

            if ($in_same_chapter) {
                $chapt_array = wp_get_object_terms($post->ID, 'chapters', array('fields' => 'ids'));
                if (!empty($chapt_array)) {
                    $join .= " AND tt.taxonomy = 'chapters' AND tt.term_id IN (" . implode(',', $chapt_array) . ")";
                }

            }
        }

        $adjacent = $previous ? 'previous' : 'next';
        $op = $previous ? '<' : '>';
        $order = $previous ? 'DESC' : 'ASC';

        $where = apply_filters("get_{$adjacent}_{$taxonomy}_where", $wpdb->prepare("WHERE p.post_date %s %s AND p.post_type = %s AND p.post_status = 'publish'", $op, $current_post_date, $post->post_type), $in_same_chapter);
        $sort = apply_filters("get_{$adjacent}_{$taxonomy}_sort", "ORDER BY p.post_date $order LIMIT 1");

        $query = "SELECT p.* FROM $wpdb->posts AS p $join $where $sort";
        $query_key = "adjacent_{$taxonomy}_{$post->ID}_{$previous}_{$in_same_chapter}"; // . md5($query);
        $result = wp_cache_get($query_key, 'counts');
        if (false !== $result) {
            return $result;
        }

        $result = $wpdb->get_row($wpdb->prepare("SELECT p.* FROM $wpdb->posts AS p %s %s %s", $join, $where, $sort));
        if (null === $result) {
            $result = '';
        }

        wp_cache_set($query_key, $result, 'counts');
        return $result;
    }
endif;
if (!function_exists('toocheke_get_adjacent_chapter')):
    function toocheke_get_adjacent_chapter($prev = false, $comic_id = null, $series_id = null)
{

        $current_chapter = get_the_terms($comic_id, 'chapters')[0];

        /* if (is_array($current_chapter)) {$current_chapter = reset($current_chapter);} else {return;}

        // cache the calculation of the desired chapter - workaround for bug with w3 total cache's object cache
        $current_chapter_order = wp_cache_get('toocheke_current_order_' . $current_chapter->slug);
        if (false === $current_chapter_order) {

        $current_chapter_order = (int) get_term_meta($current_chapter->term_id, 'chapter-order', true);
        //$current_chapter_order = $current_chapter->chapter-order;
        wp_cache_set('toocheke_current_order_' . $current_chapter->slug, $current_chapter_order);
        } */

        $current_chapter_id = $current_chapter->term_id;

        //create array for searching
        $all_chapters_args = array(
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'chapter-order',
                    'type' => 'NUMERIC',
                )),
            'hide_empty' => 1,
        );

        $all_chapters_array = get_terms('chapters', $all_chapters_args);
        $filtered_chapters_array = array();
        if ($all_chapters_array) {
            //handle chapters array creation in case there is a series
            foreach ($all_chapters_array as $chapter) {
                $chapter_comic_args = array(
                    'posts_per_page' => 1,
                    'post_parent' => $series_id,
                    'post_type' => 'comic',
                    'orderby' => 'post_date',
                    'order' => 'ASC',
                    "tax_query" => array(
                        array(
                            'taxonomy' => "chapters", // use the $tax you define at the top of your script
                            'field' => 'term_id',
                            'terms' => $chapter->term_id, // use the current term in your foreach loop
                        ),
                    ),
                    'no_found_rows' => true,
                    'update_post_meta_cache' => false,
                    'update_post_term_cache' => false,
                );
                $chapter_comic_query = new WP_Query($chapter_comic_args);
                if ($chapter_comic_query->have_posts()) {
                    $filtered_chapters_array[] = $chapter;
                }
            }

            if ($filtered_chapters_array) {
                // Lets get all the term id's from the array of term objects
                $chapter_ids = wp_list_pluck($filtered_chapters_array, 'term_id');
                //echo '<pre>'; print_r($chapter_ids); echo '</pre>';

                /**
                 * We now need to locate the position of the current chapter amongst the $chapters_ids array. \
                 * This way, we can now know which chapters are adjacent to the current one
                 */
                $current_chapter_index = array_search($current_chapter_id, $chapter_ids);

                // Set default variables to hold the next and previous chapters
                $previous_chapter = null;
                $next_chapter = null;

                $previous_chapter_index = $prev && $current_chapter_index >= 0 ? $current_chapter_index - 1 : null;
                $next_chapter_index = !$prev && $current_chapter_index < intval(count($chapter_ids) - 1) ? $current_chapter_index + 1 : null;

                // Get the previous chapter

                if ($previous_chapter_index > -1) {
                    $previous_chapter = $filtered_chapters_array[$previous_chapter_index];
                }

// Get the next chapter
                if ($next_chapter_index) {
                    $next_chapter = $filtered_chapters_array[$next_chapter_index];
                }

                //return the chapter
                if ($prev) {
                    return $previous_chapter ? $previous_chapter : false;
                } else {
                    return $next_chapter ? $next_chapter : false;
                }

                //echo  $current_chapter_index;
                //echo '<pre>'; print_r($term_ids); echo '</pre>';
            } else {
                return false;
            }
        }

    }
endif;
if (!function_exists('toocheke_get_previous_chapter')):
    function toocheke_get_previous_chapter($series_id = null, $comic_id = null)
{

        $chapter = toocheke_get_adjacent_chapter(true, $comic_id, $series_id);

        if (is_object($chapter)) {

            $child_args = array(
                'post_parent' => $series_id,
                'numberposts' => 1,
                'post_type' => 'comic',
                'orderby' => 'post_date',
                'order' => 'ASC',
                'post_status' => 'publish',
                'chapters' => $chapter->slug,
            );
            $chapter_posts = get_posts($child_args);
            if (is_array($chapter_posts)) {
                $chapter_posts = reset($chapter_posts);
                $permalink = get_permalink($chapter_posts->ID);
                if ($series_id) {
                    $permalink = add_query_arg('sid', $series_id, $permalink);
                }
                return $permalink;
            }

        }

        return false;
    }
endif;
if (!function_exists('toocheke_get_next_chapter')):
    function toocheke_get_next_chapter($series_id = null, $comic_id = null)
{
        $chapter = toocheke_get_adjacent_chapter(false, $comic_id, $series_id);
        if (is_object($chapter)) {
            $child_args = array(
                'post_parent' => $series_id,
                'numberposts' => 1,
                'post_type' => 'comic',
                'orderby' => 'post_date',
                'order' => 'ASC',
                'post_status' => 'publish',
                'chapters' => $chapter->slug,
            );
            $chapter_posts = get_posts($child_args);
            if (is_array($chapter_posts)) {
                $chapter_posts = reset($chapter_posts);
                $permalink = get_permalink($chapter_posts->ID);
                if ($series_id) {
                    $permalink = add_query_arg('sid', $series_id, $permalink);
                }
                return $permalink;
            }
        }
        return false;
    }
endif;
/**
 * Replace comic images
 *
 */
if (!function_exists('toocheke_wrap_content_img')):
    function toocheke_wrap_content_img($content)
{
        // Don't run in admin interface
        if (is_admin()) {
            return $content;
        }

        if (get_post_type() == 'post') {
            return $content;
        }
        $home_layout = get_theme_mod('home_layout_setting', 'default');
        $is_comic_home = $home_layout == 'alt-1' || $home_layout == 'alt-4';
        $comic_layout = get_option('toocheke-comic-layout-devices');
        $is_responsive = $comic_layout === '1' ? true : false;
        $is_comic = 'comic' == get_post_type();
        if ((is_singular('comic') || ($is_comic_home && is_home() && $is_comic)) && $is_responsive) {
            // convert images
            $content = toocheke_picture_wrapper($content, false);
        }

        // return the processed content
        return $content;
    }
endif;

add_filter('the_content', 'toocheke_wrap_content_img');
if (!function_exists('toocheke_wrap_meta_content_img')):
    function toocheke_wrap_meta_content_img($metadata, $post_id, $meta_key, $single)
{
        // Don't run in admin interface
        if (is_admin()) {
            return $metadata;
        }

        if (get_post_type($post_id) == 'post') {
            return $metadata;
        }

        // Get list of filter
        global $wp_current_filter;
        $filter_key = count($wp_current_filter) - 2;
        // Check if this filter is inside itself
        if (isset($wp_current_filter[$filter_key]) && 'get_post_metadata' === $wp_current_filter[count($wp_current_filter) - 2]) {
            return $metadata;
        }

        $home_layout = get_theme_mod('home_layout_setting', 'default');
        $is_comic_home = $home_layout == 'alt-1' || $home_layout == 'alt-4';
        $comic_layout = get_option('toocheke-comic-layout-devices');
        $is_responsive = $comic_layout === '1' ? true : false;
        if ((is_singular('comic') || ($is_comic_home && is_home())) && $is_responsive) {
            // get meta content
            if (isset($meta_key) && ('desktop_comic_editor' == $meta_key || 'desktop_comic_2nd_language_editor' == $meta_key || 'mobile_comic_2nd_language_editor' == $meta_key)) {
                remove_filter('get_post_metadata', 'toocheke_wrap_meta_content_img', 10);
                $current_meta = get_post_meta($post_id, $meta_key, true);
                add_filter('get_post_metadata', 'toocheke_wrap_meta_content_img', 10, 4);
                // convert images
                $is_desktop = 'desktop_comic_editor' == $meta_key || 'desktop_comic_2nd_language_editor' == $meta_key;
                $current_meta = toocheke_picture_wrapper($current_meta, $is_desktop);
                //added do_shortcode to handle cases where shortcodes like captions may be present
                return do_shortcode($current_meta);
            }
        }

        // Return original if the check does not pass
        return $metadata;

    }
endif;

add_filter('get_post_metadata', 'toocheke_wrap_meta_content_img', 999, 4);
if (!function_exists('toocheke_picture_wrapper')):
    function toocheke_picture_wrapper($dom_content, $is_desktop = true)
{

        $dom_document = new DOMDocument();

        if (empty($dom_content)) {
            return $dom_content;
        }

        $dom_document->loadHTML($dom_content);
        $images = $dom_document->getElementsByTagName('img');
        if (0 === count($images)) {
            return $dom_content;
        }

        foreach ($images as $image) {
            $img_src = $image->getAttribute("src");
            $img_blank = get_stylesheet_directory_uri() . '/dist/img/blank.gif';
            $arr = pathinfo($img_src);
            $dirname = $arr['dirname'];
            $base = $arr['basename'];

            $picture = $dom_document->createElement('picture');
            $pict_clone = $picture->cloneNode();
            $image->parentNode->replaceChild($pict_clone, $image);
            $pict_clone->appendChild($image);
            if ($is_desktop) {
                $source = $dom_document->createElement('source');
                $source->setAttribute("media", "(min-width: 1200px)");
                $source->setAttribute("srcset", $img_src);
                $src_clone = $source->cloneNode();
                $image->parentNode->replaceChild($src_clone, $image);
                $src_clone->appendChild($image);

                $source = $dom_document->createElement('source');
                $source->setAttribute("media", "(max-width: 1199px)");
                $source->setAttribute("srcset", $img_blank);
                $src_clone = $source->cloneNode();
                $image->parentNode->replaceChild($src_clone, $image);
                $src_clone->appendChild($image);
            } else {
                $source = $dom_document->createElement('source');
                $source->setAttribute("media", "(max-width: 999px)");
                $source->setAttribute("srcset", $img_src);
                $src_clone = $source->cloneNode();
                $image->parentNode->replaceChild($src_clone, $image);
                $src_clone->appendChild($image);

                $source = $dom_document->createElement('source');
                $source->setAttribute("media", "(min-width: 1200px)");
                $source->setAttribute("srcset", $img_blank);
                $src_clone = $source->cloneNode();
                $image->parentNode->replaceChild($src_clone, $image);
                $src_clone->appendChild($image);
            }

        }
        $dom_content = $dom_document->saveHTML();
        return $dom_content;
    }
endif;
if (!function_exists('toocheke_post_nav')) {
    /**
     * Display navigation to next/previous post when applicable.
     *
     * @global WP_Post|null $post The current post.
     */
    function toocheke_post_nav()
    {
        global $post;
        if (!$post) {
            return;
        }

        // Don't print empty markup if there's nowhere to navigate.
        $previous = (is_attachment()) ? get_post($post->post_parent) : get_adjacent_post(false, '', true);
        $next = get_adjacent_post(false, '', false);
        if (!$next && !$previous) {
            return;
        }
        ?>
		<nav class="container navigation post-navigation">
			<h2 class="screen-reader-text"><?php esc_html_e('Post navigation', 'toocheke');?></h2>
			<div class="d-flex nav-links justify-content-between">
				<?php
if (get_previous_post_link()) {
            previous_post_link('<span class="nav-previous">%link</span>', _x('<i class="fa fa-angle-left"></i>&nbsp;%title', 'Previous post link', 'toocheke'));
        }
        if (get_next_post_link()) {
            next_post_link('<span class="nav-next">%link</span>', _x('%title&nbsp;<i class="fa fa-angle-right"></i>', 'Next post link', 'toocheke'));
        }
        ?>
			</div><!-- .nav-links -->
		</nav><!-- .post-navigation -->
		<?php
}
}
add_action('init', 'toocheke_random_add_rewrite');
if (!function_exists('toocheke_random_add_rewrite')) {
    function toocheke_random_add_rewrite()
    {
        global $wp;
        $wp->add_query_var('random');
        add_rewrite_rule('random/?$', 'index.php?random=1', 'top');
    }
}
add_action('template_redirect', 'toocheke_random_template');
if (!function_exists('toocheke_random_template')) {
    function toocheke_random_template()
    {
        if (get_query_var('random') == 1) {
            $posts = get_posts('post_type=comic&orderby=rand&numberposts=1');
            foreach ($posts as $post) {
                $link = get_permalink($post);
            }
            wp_redirect($link, 307);
            exit;
        }
    }
}
add_filter('the_content_more_link', 'toocheke_modify_read_more_link');
if (!function_exists('toocheke_modify_read_more_link')) {
    function toocheke_modify_read_more_link()
    {
        return '<a class="btn-more btn btn-danger btn-sm" href="' . get_permalink() . '">Read More</a>';
    }
}

/**
 * Implement the Custom Header feature.
 */
// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
require get_template_directory() . '/inc/template-tags.php';
/**
 * Customizer additions.
 */
// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
require get_template_directory() . '/inc/customizer.php';

/**
 * Widgets File.
 */
// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
require get_template_directory() . '/inc/widgets.php';

/**
 * Boostrap Navwalker File.
 */
// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
require_once get_template_directory() . '/inc/wp-bootstrap-navwalker.php';

/**
 * Boostrap Comment Walker File.
 */
// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
require get_template_directory() . '/inc/bootstrap-comment-walker.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
    require get_template_directory() . '/inc/jetpack.php';
}
/**
 * Guttenberg Support.
 */
