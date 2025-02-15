<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Toocheke
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses toocheke_header_style()
 */
if (!function_exists('toocheke_custom_header_setup')):
    function toocheke_custom_header_setup()
{
        add_theme_support('custom-header', apply_filters('toocheke_custom_header_args', array(
            'default-image' => '',
            'default-text-color' => 'ffffff',
            'width' => 1920,
            'height' => 320,
            'flex-height' => true,
            'flex-width' => true,
            'wp-head-callback' => 'toocheke_header_style',
        )));
    }
endif;
add_action('after_setup_theme', 'toocheke_custom_header_setup');

/**
 * Convert HEX to RGB.
 *
 * @since Toocheke 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function toocheke_hex2rgb($color)
{
    $color = trim($color, '#');

    if (strlen($color) == 3) {
        $r = hexdec(substr($color, 0, 1) . substr($color, 0, 1));
        $g = hexdec(substr($color, 1, 1) . substr($color, 1, 1));
        $b = hexdec(substr($color, 2, 1) . substr($color, 2, 1));
    } elseif (strlen($color) == 6) {
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));
    } else {
        return array();
    }

    return array(
        'red' => $r,
        'green' => $g,
        'blue' => $b,
    );
}

if (!function_exists('toocheke_header_style')):
    /**
     * Styles the header image and text displayed on the blog.
     *
     * @since Toocheke 1.0
     *
     * @see toocheke_custom_header_setup()
     */
    function toocheke_header_style()
{
        $header_image = get_header_image();

        // If no custom options for text are set, let's bail.
        if (empty($header_image) && display_header_text()) {
            return;
        }

        // If we get this far, we have custom styles. Let's do this.
        ?>
			<style type="text/css" id="toocheke-header-css">
			<?php
    // Short header for when there is no Custom Header and Header Text is hidden.
        if (empty($header_image) && !display_header_text()):
        ?>
			.site-header {
				padding-top: 14px;
				padding-bottom: 14px;
			}

			.site-branding {
				min-height: 42px;
			}

			@media screen and (min-width: 46.25em) {
				.site-header {
					padding-top: 21px;
					padding-bottom: 21px;
				}
				.site-branding {
					min-height: 56px;
				}
			}
			@media screen and (min-width: 55em) {
				.site-header {
					padding-top: 25px;
					padding-bottom: 25px;
				}
				.site-branding {
					min-height: 62px;
				}
			}
			@media screen and (min-width: 59.6875em) {
				.site-header {
					padding-top: 0;
					padding-bottom: 0;
				}
				.site-branding {
					min-height: 0;
				}
			}
				<?php
endif;

    // Has a Custom Header been added?
    if (!empty($header_image)):
    ?>
		.site-header {

			/*
			 * No shorthand so the Customizer can override individual properties.
			 * @see https://core.trac.wordpress.org/ticket/31460
			 */
			background-image: url(<?php header_image();?>);
			background-repeat: no-repeat;
			background-position: 50% 50%;
			-webkit-background-size: cover;
			-moz-background-size:    cover;
			-o-background-size:      cover;
			background-size:         cover;
		}

		@media screen and (min-width: 59.6875em) {
			body:before {

				/*
				 * No shorthand so the Customizer can override individual properties.
				 * @see https://core.trac.wordpress.org/ticket/31460
				 */
				background-image: url(<?php header_image();?>);
				background-repeat: no-repeat;
				background-position: 100% 50%;
				-webkit-background-size: cover;
				-moz-background-size:    cover;
				-o-background-size:      cover;
				background-size:         cover;
				border-right: 0;
			}

			.site-header {
				background: transparent;
			}
		}
			<?php
endif;

    // Has the text been hidden?
    if (!display_header_text()):
    ?>
		.site-title,
		.site-description {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
	<?php endif;?>
	</style>
		<?php
}
endif; // toocheke_header_style

/**
 * Enqueues front-end CSS for the header background color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_header_background_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[1];
    $header_background_color = get_theme_mod('header_background_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($header_background_color === $default_color) {
        return;
    }

    $css = '
		/* Custom Header Background Color */
		body:before,
		.site-header, .jumbotron, #side-bar {
			background-color: %1$s;
		}


	';

    wp_add_inline_style('toocheke-style', sprintf($css, $header_background_color));
}
add_action('wp_enqueue_scripts', 'toocheke_header_background_color_css', 11);

/**
 * Enqueues front-end CSS for the sidebar text color.
 *
 * @since Toocheke 1.0
 */
function toocheke_sidebar_text_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[4];
    $sidebar_link_color = get_theme_mod('sidebar_textcolor', $default_color);

    // Don't do anything if the current color is the default.
    if ($sidebar_link_color === $default_color) {
        return;
    }

    // If we get this far, we have custom styles. Let's do this.
    $sidebar_link_color_rgb = toocheke_hex2rgb($sidebar_link_color);
    $sidebar_text_color = vsprintf('rgba( %1$s, %2$s, %3$s, 0.7)', $sidebar_link_color_rgb);
    $sidebar_border_color = vsprintf('rgba( %1$s, %2$s, %3$s, 0.1)', $sidebar_link_color_rgb);
    $sidebar_border_focus_color = vsprintf('rgba( %1$s, %2$s, %3$s, 0.3)', $sidebar_link_color_rgb);

    $css = '

		}
	';

    wp_add_inline_style('toocheke-style', sprintf($css, $sidebar_link_color, $sidebar_text_color, $sidebar_border_color, $sidebar_border_focus_color));
}
add_action('wp_enqueue_scripts', 'toocheke_sidebar_text_color_css', 11);
