<?php
/**
 * Toocheke Theme Customizer
 *
 * @package Toocheke
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if (class_exists('WP_Customize_Control')) {
    class Toocheke_Customize_TinyMCE_Control extends WP_Customize_Control
    {
        /**
         * The type of control being rendered
         */
        public $type = 'tinymce_editor';

        /**
         * Pass our TinyMCE toolbar config to JavaScript
         */
        public function to_json()
        {
            parent::to_json();

            $this->json['tinymce_toolbar1'] = isset($this->input_attrs['toolbar1']) ? esc_attr($this->input_attrs['toolbar1']) : 'bold italic bullist numlist alignleft aligncenter alignright link';
            $this->json['tinymce_toolbar2'] = isset($this->input_attrs['toolbar2']) ? esc_attr($this->input_attrs['toolbar2']) : '';
            $this->json['tinymce_media_buttons'] = isset($this->input_attrs['mediaButtons']) && ($this->input_attrs['mediaButtons'] === true) ? true : false;
            $this->json['tinymce_height'] = isset($this->input_attrs['height']) ? esc_attr($this->input_attrs['height']) : 200;
        }

        /**
         * Render the control in the customizer
         */
        public function render_content()
        {

            ?>
			<div class="tinymce-control">
				<span class="customize-control-title">
					<?php echo esc_html($this->label); ?>
				</span>

				<?php if (!empty($this->description)): ?>
					<span class="customize-control-description">
						<?php echo esc_html($this->description); ?>
					</span>
				<?php endif;?>

				<textarea id="<?php echo esc_attr($this->id); ?>" class="customize-control-tinymce-editor" <?php $this->link();?>><?php echo esc_html($this->value()); ?></textarea>
				<script>
					jQuery( document ).ready( function ( $ ) {
						function tinyMCE_setup() {
							var tinyMCEToolbar1 = _wpCustomizeSettings.controls[$( this ).attr( 'id' )].tinymce_toolbar1;
							var tinyMCEToolbar2 = _wpCustomizeSettings.controls[$( this ).attr( 'id' )].tinymce_toolbar2;
							var tinyMCEMediaButtons = _wpCustomizeSettings.controls[$( this ).attr( 'id' )].tinymce_media_buttons;
							var tinyMCEheight = _wpCustomizeSettings.controls[$( this ).attr( 'id' )].tinymce_height;

							wp.editor.initialize( $( this ).attr( 'id' ), {
								tinymce: {
									wpautop: true,
									toolbar1: tinyMCEToolbar1,
									toolbar2: tinyMCEToolbar2,
									height: tinyMCEheight
								},
								quicktags: true,
								mediaButtons: tinyMCEMediaButtons
							} );
						}

						function initialize_tinyMCE( event, editor ) {
							editor.on( 'change', function () {
								tinyMCE.triggerSave();
								$( "#".concat( editor.id ) ).trigger( 'change' );
							} );
						}

						$( document ).on( 'tinymce-editor-init', initialize_tinyMCE );
						$( '.customize-control-tinymce-editor' ).each( tinyMCE_setup );
					} );
				</script>
			</div>
			<?php
}
    }
}
function toocheke_customize_register($wp_customize)
{
/**
 * Mobile Header
 */
    $wp_customize->add_section('toocheke_mobile_header', array(
        'title' => 'Mobile Header Image',
        'description' => 'Upload an image that will be displayed in the header section on mobile devices. At least 1000px wide.',
        'priority' => 60,
    ));

    $wp_customize->add_setting('mobile_header_image', array(
        'default' => '',
        'sanitize_callback' => 'toocheke_sanitize_file',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mobile_header_image', array(
        'label' => 'Current header image',
        'section' => 'toocheke_mobile_header',
        'settings' => 'mobile_header_image',
    )));
/**
 * Header URL
 */
    $wp_customize->add_section('header_link_section', array(
        'title' => __('Header Link', 'toocheke'),
        'description' => 'Enter the URL you want your header image to link to.',
        'priority' => 65,
    ));

// Add setting
    $wp_customize->add_setting(
        'header_link_setting',
        array(
            'default' => '',
            'sanitize_callback' => 'toocheke_sanitize_url',
            'transport' => 'postMessage',
        )
    );

// Add control
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'header_link_control',
        array(
            'label' => __('URL', 'toocheke'),
            'section' => 'header_link_section',
            'settings' => 'header_link_setting',
            'type' => 'url',
        )
    )
    );
/**
 * Image Radio Control
 */

    // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
    require_once get_template_directory() . '/inc/image-radio-control.php';
    // Register the radio image control class as a JS control type.
    $wp_customize->register_control_type('toocheke_image_radio_control');

    // Create sections
    //Home layout section
    $wp_customize->add_section('home_layout_section', array(
        'title' => __('Home Page Layout', 'toocheke'),
        'priority' => 45,
    ));
    /* Add a home layout section. */
    $wp_customize->add_setting('home_layout_setting', array(
        'default' => 'default',
        'sanitize_callback' => 'sanitize_key',
    ));

    /* Add the home layout control. */
    $wp_customize->add_control(
        new toocheke_image_radio_control(
            $wp_customize,
            'home_layout_control',
            array(
                'label' => esc_html__('Home Layout', 'toocheke'),
                'description' => __('Choose a layout for the home page.', 'toocheke'),
                'section' => 'home_layout_section',
                'settings' => 'home_layout_setting',
                'choices' => array(
                    'default' => array(
                        'label' => esc_html__('Webtoon layout. Comic listing, chapters, collections, blog posts and sidebar.', 'toocheke'),
                        'url' => '%shome-layout-comic-list.png',
                    ),
                    'alt-1' => array(
                        'label' => esc_html__('Traditional layout. Show latest comic with latest blog posts and sidebar.', 'toocheke'),
                        'url' => '%shome-layout-single-comic.png',
                    ),
                    'alt-2' => array(
                        'label' => esc_html__('Minimalist layout. Only show the comic on home page. Nothing else.', 'toocheke'),
                        'url' => '%shome-layout-single-comic-no-blog.png',
                    ),
                    'alt-3' => array(
                        'label' => esc_html__('Collections layout. All collections in hero section, latest blog posts and sidebar.', 'toocheke'),
                        'url' => '%shome-layout-comic-collections.png',
                    )
                    ,
                    'alt-4' => array(
                        'label' => esc_html__('Hero layout. Hero section at the top of the page, menubar below it, latest comic, with latest blog posts and sidebar.', 'toocheke'),
                        'url' => '%shome-layout-hero-single-comic.png',
                    )
                    ,
                    'alt-5' => array(
                        'label' => esc_html__('Hero layout. Hero section at the top of the page, menubar below it, Comic listing, chapters, collections, blog posts and sidebar.', 'toocheke'),
                        'url' => '%shome-layout-hero-with-comic-list.png',
                    ),

                ),
                'priority' => 10,
            )
        )
    );
    /*Home Sections Section */
// Add section.
    // Add a home sections section.
    $wp_customize->add_section('home_component_section', array(
        'title' => __('Home Sections', 'toocheke'),
        'priority' => 50, // After home layout.
    ));

// Add setting
    $wp_customize->add_setting(
        'latest_comic_setting',
        array(
            'default' => __('Latest Comics', 'toocheke'),
            'sanitize_callback' => 'toocheke_sanitize_text',
            'transport' => 'postMessage',
        )
    );

// Add control
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'latest_comic_text_control',
        array(
            'label' => __('Comics Header Text', 'toocheke'),
            'section' => 'home_component_section',
            'settings' => 'latest_comic_setting',
            'type' => 'text',
        )
    )
    );

    // Add setting
    $wp_customize->add_setting(
        'latest_post_setting',
        array(
            'default' => __('Latest Posts', 'toocheke'),
            'sanitize_callback' => 'toocheke_sanitize_text',
            'transport' => 'postMessage',
        )
    );

// Add control
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'latest_post_text_control',
        array(
            'label' => __('Blog Posts Header Text', 'toocheke'),
            'section' => 'home_component_section',
            'settings' => 'latest_post_setting',
            'type' => 'text',
        )
    )
    );
    // Add setting
    $wp_customize->add_setting(
        'latest_chapter_setting',
        array(
            'default' => __('Latest Chapters', 'toocheke'),
            'sanitize_callback' => 'toocheke_sanitize_text',
            'transport' => 'postMessage',
        )
    );

    // Add control
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'latest_chapter_text_control',
        array(
            'label' => __('Chapters Header Text', 'toocheke'),
            'section' => 'home_component_section',
            'settings' => 'latest_chapter_setting',
            'type' => 'text',
        )
    )
    );
    // Add setting
    $wp_customize->add_setting(
        'latest_collection_setting',
        array(
            'default' => __('Latest Collections', 'toocheke'),
            'sanitize_callback' => 'toocheke_sanitize_text',
            'transport' => 'postMessage',
        )
    );

    // Add control
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'latest_collection_text_control',
        array(
            'label' => __('Collections Header Text', 'toocheke'),
            'section' => 'home_component_section',
            'settings' => 'latest_collection_setting',
            'type' => 'text',
        )
    )
    );

    // Add setting
    $wp_customize->add_setting(
        'comic_series_setting',
        array(
            'default' => __('Comic Series', 'toocheke'),
            'sanitize_callback' => 'toocheke_sanitize_text',
            'transport' => 'postMessage',
        )
    );

// Add control
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'comic_series_text_control',
        array(
            'label' => __('Series Header Text', 'toocheke'),
            'section' => 'home_component_section',
            'settings' => 'comic_series_setting',
            'type' => 'text',
        )
    )
    );
    // Add setting
    $wp_customize->add_setting(
        'hide_comics_setting',
        array(
            'default' => false,
            'sanitize_callback' => 'toocheke_sanitize_checkbox',
            'transport' => 'postMessage',
        )
    );

// Add control
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'hide_comics_checkbox_control',
        array(
            'label' => __('Hide comics section?', 'toocheke'),
            'section' => 'home_component_section',
            'settings' => 'hide_comics_setting',
            'type' => 'checkbox',
        )
    )
    );
    // Add setting
    $wp_customize->add_setting(
        'hide_chapters_setting',
        array(
            'default' => false,
            'sanitize_callback' => 'toocheke_sanitize_checkbox',
            'transport' => 'postMessage',
        )
    );

// Add control
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'hide_chapters_checkbox_control',
        array(
            'label' => __('Hide chapters section?', 'toocheke'),
            'section' => 'home_component_section',
            'settings' => 'hide_chapters_setting',
            'type' => 'checkbox',
        )
    )
    );

    // Add setting
    $wp_customize->add_setting(
        'hide_collections_setting',
        array(
            'default' => false,
            'sanitize_callback' => 'toocheke_sanitize_checkbox',
            'transport' => 'postMessage',
        )
    );

// Add control
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'hide_collections_checkbox_control',
        array(
            'label' => __('Hide collections section?', 'toocheke'),
            'section' => 'home_component_section',
            'settings' => 'hide_collections_setting',
            'type' => 'checkbox',
        )
    )
    );
    // Add setting
    $wp_customize->add_setting(
        'hide_series_setting',
        array(
            'default' => false,
            'sanitize_callback' => 'toocheke_sanitize_checkbox',
            'transport' => 'postMessage',
        )
    );

// Add control
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'hide_series_checkbox_control',
        array(
            'label' => __('Hide series section?', 'toocheke'),
            'section' => 'home_component_section',
            'settings' => 'hide_series_setting',
            'type' => 'checkbox',
        )
    )
    );
//Menu alignment section
    $wp_customize->add_section('menu_alignment_section', array(
        'title' => __('Main menu alignment', 'toocheke'),
        'priority' => 55,
    ));
/* Add a menu alignment section. */
    $wp_customize->add_setting('menu_alignment_control', array(
        'default' => 'right',
        'sanitize_callback' => 'toocheke_sanitize_select',
    ));

    /* Add the menu alignment  control. */
    $wp_customize->add_control('menu_alignment_control', array(
        'type' => 'select',
        'section' => 'menu_alignment_section', // Add a default or your own section
        'label' => __('Alignment', 'toocheke'),
        'description' => __('This sets the alignment of the menu in the main navigation bar.', 'toocheke'),
        'choices' => array(
            'left' => __('Left', 'toocheke'),
            'center' => __('Center', 'toocheke'),
            'right' => __('Right', 'toocheke'),
        ),
    ));
    // Comic layout section
    $wp_customize->add_section('comic_layout_section', array(
        'title' => __('Comic Page Layout', 'toocheke'),
        'priority' => 65,
    ));

    /* Add a comic layout section. */
    $wp_customize->add_setting('comic_layout_setting', array(
        'default' => 'default',
        'sanitize_callback' => 'sanitize_key',
    ));

    /* Add the comic layout control. */
    $wp_customize->add_control(
        new toocheke_image_radio_control(
            $wp_customize,
            'comic_layout_control',
            array(
                'label' => esc_html__('Comic Layout', 'toocheke'),
                'description' => __('Choose a layout for the comic page on desktops and large devices.', 'toocheke'),
                'section' => 'comic_layout_section',
                'settings' => 'comic_layout_setting',
                'choices' => array(
                    'default' => array(
                        'label' => esc_html__('One comic panel per row', 'toocheke'),
                        'url' => '%ssingle-panel-comic.png',
                    ),
                    'two' => array(
                        'label' => esc_html__('Two comic panels per row', 'toocheke'),
                        'url' => '%stwo-panel-comic.png',
                    ),
                    'three' => array(
                        'label' => esc_html__('Two comic panels per row', 'toocheke'),
                        'url' => '%sthree-panel-comic.png',
                    ),
                    'four' => array(
                        'label' => esc_html__('Four comic panels per row', 'toocheke'),
                        'url' => '%sfour-panel-comic.png',
                    ),
                ),
                'priority' => 10,
            )
        )
    );

    /* Color Schemes */
    $color_scheme = toocheke_get_color_scheme();

    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';

    // Remove the core header textcolor control, as it shares the sidebar text color.
    $wp_customize->remove_control('header_textcolor');

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector' => '.site-title',
                'container_inclusive' => false,
                'render_callback' => 'toocheke_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector' => '.site-description',
                'container_inclusive' => false,
                'render_callback' => 'toocheke_customize_partial_blogdescription',
            )
        );
    }

    // Add color scheme setting and control.
    $wp_customize->add_setting(
        'color_scheme',
        array(
            'default' => 'default',
            'sanitize_callback' => 'toocheke_sanitize_color_scheme',
            'transport' => 'postMessage',
        )
    );

    // Add custom navbar background color setting and control.
    $wp_customize->add_setting(
        'navbar_background_color',
        array(
            'default' => $color_scheme[1],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'navbar_background_color',
            array(
                'label' => __('Navbar Background Color', 'toocheke'),
                'description' => __('Applied to the navbar menu background.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    $wp_customize->add_control(
        'color_scheme',
        array(
            'label' => __('Base Color Scheme', 'toocheke'),
            'section' => 'colors',
            'type' => 'select',
            'choices' => toocheke_get_color_scheme_choices(),
            'priority' => 1,
        )
    );

    // Add custom header and sidebar background color setting and control.
    $wp_customize->add_setting(
        'jumbotron_and_sidebar_background_color',
        array(
            'default' => $color_scheme[2],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'jumbotron_and_sidebar_background_color',
            array(
                'label' => __('Header and Sidebar Background Color', 'toocheke'),
                'description' => __('Applied to the header and sidebar background.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    // Add custom header and sidebar background color setting and control.
    $wp_customize->add_setting(
        'jumbotron_and_sidebar_text_color',
        array(
            'default' => $color_scheme[3],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'jumbotron_and_sidebar_text_color',
            array(
                'label' => __('Header/Sidebar Text Color.', 'toocheke'),
                'description' => __('Applied to the header and sidebar text.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    // Add custom main content background color setting and control.
    $wp_customize->add_setting(
        'content_background_color',
        array(
            'default' => $color_scheme[4],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'content_background_color',
            array(
                'label' => __('Main Content Background Color', 'toocheke'),
                'description' => __('Applied to main content background.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    // Add custom box text color setting and control.
    $wp_customize->add_setting(
        'box_text_color',
        array(
            'default' => $color_scheme[5],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'box_text_color',
            array(
                'label' => __('Complementary Text Color', 'toocheke'),
                'description' => __('Applied to buttons, sidebar headers, pagination, labels and tag cloud.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    // Add custom dark text color setting and control.
    $wp_customize->add_setting(
        'dark_text_color',
        array(
            'default' => $color_scheme[6],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'dark_text_color',
            array(
                'label' => __('Main Content Text Color', 'toocheke'),
                'description' => __('Applied to the body.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    // Add custom complementary color setting and control.
    $wp_customize->add_setting(
        'complementary_color',
        array(
            'default' => $color_scheme[7],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'complementary_color',
            array(
                'label' => __('Complementary Color', 'toocheke'),
                'description' => __('Applied to the navbar, links, and input.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    // Add custom side bar link color and active pagination link background setting and control.
    $wp_customize->add_setting(
        'sidebar_links_active_page_link',
        array(
            'default' => $color_scheme[8],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sidebar_links_active_page_link',
            array(
                'label' => __('Sidebar Link & Active Pagination Background Color', 'toocheke'),
                'description' => __('Applied to the links in the sidebar and the background on an active pagination link.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    // Add custom active pagination link text color setting and control.
    $wp_customize->add_setting(
        'active_page_text_color',
        array(
            'default' => $color_scheme[9],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'active_page_text_color',
            array(
                'label' => __('Active Page Link Text Color', 'toocheke'),
                'description' => __('Applied to the active link in the pagination below the comic archive.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    // Add custom comic navbar text color setting and control.
    $wp_customize->add_setting(
        'comic_navbar_link_text_color',
        array(
            'default' => $color_scheme[10],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'comic_navbar_link_text_color',
            array(
                'label' => __('Comic Navbar Text Color', 'toocheke'),
                'description' => __('Applied to the comic post navbar links(both header and footer).', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    // Add custom header and sidebar background color setting and control.
    $wp_customize->add_setting(
        'main_content_link_color',
        array(
            'default' => $color_scheme[11],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'main_content_link_color',
            array(
                'label' => __('Main Content Link Color', 'toocheke'),
                'description' => __('Applied to the links in the main content area.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    // Add custom navbar link color setting and control.
    $wp_customize->add_setting(
        'navbar_link_color',
        array(
            'default' => $color_scheme[12],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'navbar_link_color',
            array(
                'label' => __('Navbar Link Color', 'toocheke'),
                'description' => __('Applied to the links in the navbar area.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    // Add custom navbar link hover color setting and control.
    $wp_customize->add_setting(
        'navbar_link_hover_color',
        array(
            'default' => $color_scheme[13],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'navbar_link_hover_color',
            array(
                'label' => __('Navbar Link Hover Color', 'toocheke'),
                'description' => __('Applied to the links, on hover, in the navbar area.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );
    // Add custom footer background color.
    $wp_customize->add_setting(
        'footer_background_color',
        array(
            'default' => $color_scheme[14],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_background_color',
            array(
                'label' => __('Footer Background Color', 'toocheke'),
                'description' => __('Applied to the background of the footer area.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    // Add custom footer text color setting and control.
    $wp_customize->add_setting(
        'footer_text_color',
        array(
            'default' => $color_scheme[15],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_text_color',
            array(
                'label' => __('Footer Text Color', 'toocheke'),
                'description' => __('Applied to the text in the footer area.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    // Add custom footer link color setting and control.
    $wp_customize->add_setting(
        'footer_link_color',
        array(
            'default' => $color_scheme[16],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_link_color',
            array(
                'label' => __('Footer Link Color', 'toocheke'),
                'description' => __('Applied to the links in the footer area.', 'toocheke'),
                'section' => 'colors',
            )
        )
    );

    /*Add custom footer text*/
// Add section.
    // Add a footer/copyright information section.
    $wp_customize->add_section('footer_section', array(
        'title' => __('Footer', 'toocheke'),
        'priority' => 115, // Before Widgets.
        'description' => '<b>NOTE:</b> Copyright year will be prepended to your custom footer text ',
    ));
/*
// Add setting
$wp_customize->add_setting(
'footer_setting',
array(
'default' => __('(c) Toocheke', 'toocheke'),
'sanitize_callback' => 'toocheke_sanitize_text',
'transport' => 'postMessage',
)
);

// Add control
$wp_customize->add_control(new WP_Customize_Control(
$wp_customize,
'footer_text_control',
array(
'label' => __('Footer Text', 'toocheke'),
'section' => 'footer_section',
'settings' => 'footer_setting',
'type' => 'text',
)
)
);
 */
    // Add setting
    $wp_customize->add_setting(
        'footer_setting',
        array(
            'default' => __('(c) Toocheke', 'toocheke'),
            'sanitize_callback' => 'wp_kses_post',
            'transport' => 'postMessage',
        )
    );
// Add control
    $wp_customize->add_control(new Toocheke_Customize_TinyMCE_Control($wp_customize, 'footer_setting', array(
        'label' => __('Footer Text Content', 'toocheke'),
        'section' => 'footer_section',
        'settings' => 'footer_setting',
        'type' => 'textarea',
        'input_attrs' => [
            'toolbar1' => 'formatselect bold italic link bullist',
            'height' => 200,
            'mediaButtons' => false,
        ],
    )));
    /*Add option to hide sidebar*/
// Add section.
    // Add a sidebar section.
    $wp_customize->add_section('sidebar_section', array(
        'title' => __('Sidebar', 'toocheke'),
        'priority' => 114, // After Footer.
    ));

// Add setting
    $wp_customize->add_setting(
        'sidebar_setting',
        array(
            'default' => false,
            'sanitize_callback' => 'toocheke_sanitize_checkbox',
            'transport' => 'postMessage',
        )
    );

// Add control
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'sidebar_checkbox_control',
        array(
            'label' => __('Do you want to hide the sidebar?', 'toocheke'),
            'section' => 'sidebar_section',
            'settings' => 'sidebar_setting',
            'type' => 'checkbox',
        )
    )
    );
    /*Add custom header/hero height*/
// Add setting
    $wp_customize->add_setting(
        'hero_setting',
        array(
            'default' => 320,
            'sanitize_callback' => 'toocheke_sanitize_number',
            'transport' => 'postMessage',
        )
    );

// Add control
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'hero_height_control',
        array(
            'label' => __('Height', 'toocheke'),
            'section' => 'header_image',
            'settings' => 'hero_setting',
            'type' => 'number',
        )
    )
    );
// Sanitize url
    function toocheke_sanitize_url($url)
    {
        return esc_url($url);
    }
// Sanitize text
    function toocheke_sanitize_text($text)
    {
        return sanitize_text_field($text);
    }
    // Sanitize number
    function toocheke_sanitize_number($number, $setting)
    {
        // Ensure $number is an absolute integer (whole number, zero or greater).
        $number = absint($number);

        // If the input is an absolute integer, return it; otherwise, return the default
        return ($number ? $number : $setting->default);
    }

    //Sanitize select
    function toocheke_sanitize_select($input, $setting)
    {

        // Ensure input is a slug.
        $input = sanitize_key($input);

        // Get list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control($setting->id)->choices;

        // If the input is a valid key, return it; otherwise, return the default.
        return (array_key_exists($input, $choices) ? $input : $setting->default);
    }
    //checkbox sanitization function
    function toocheke_sanitize_checkbox($input)
    {
        //returns true if checkbox is checked
        return (isset($input) && $input == true ? true : false);
    }
    //file input sanitization function
    function toocheke_sanitize_file($file, $setting)
    {

        //allowed file types
        $mimes = array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'gif' => 'image/gif',
            'png' => 'image/png',
        );

        //check file type from file name
        $file_ext = wp_check_filetype($file, $mimes);

        //if file has a valid mime type return it, otherwise return default
        return ($file_ext['ext'] ? $file : $setting->default);
    }

    // Add an additional description to the header image section.
    $wp_customize->get_section('header_image')->description = __('Applied to the header hero section of the page.', 'toocheke');
}
add_action('customize_register', 'toocheke_customize_register', 11);

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Toocheke 1.5
 * @see toocheke_customize_register()
 *
 * @return void
 */
function toocheke_customize_partial_blogname()
{
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Toocheke 1.5
 * @see toocheke_customize_register()
 *
 * @return void
 */
function toocheke_customize_partial_blogdescription()
{
    bloginfo('description');
}

/**
 * Register color schemes for Toocheke.
 *
 * Can be filtered with {@see 'toocheke_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 1. Main Background, Sidebar Color.
 * 2. Jumbotron & Sidebar Background Color.
 * 3. Jumbotron & Sidebar Text Color.
 * 4. Navbar and Main Content Area Background Color.
 * 5. Box Text Color.
 * 6. Main Content Text Color.
 * 7. Complementary Text and Background Color.
 * 8. Sidebar Links and Active Page.
 * 9. Active Page Text Color
 * 10. Comic Navbar Text Color
 * 11. Main Content Link Color
 *
 * @since Toocheke 1.0
 *
 * @return array An associative array of color scheme options.
 */
function toocheke_get_color_schemes()
{
    /**
     * Filter the color schemes registered for use with Toocheke.
     *
     * The default schemes include 'default', 'dark', 'yellow', 'pink', 'purple', and 'blue'.
     *
     * @since Toocheke 1.0
     *
     * @param array $schemes {
     *     Associative array of color schemes data.
     *
     *     @type array $slug {
     *         Associative array of information for setting up the color scheme.
     *
     *         @type string $label  Color scheme label.
     *         @type array  $colors HEX codes for default colors prepended with a hash symbol ('#').
     *         Colors are defined in the following order:
     *            0. Main background, sidebar
     *            1. Sidebar and Jumbotron background
     *            2. Sidebar and Jumbotron text color
     *            3. Nav, Main Content, Dropdown, Comic Area
     *         4. White text colors eg. buttons
     *         5. Dark text colors
     *         6. Complementary text and background colors
     *         7. Sidebar links and active page bg
     *         8. Active page text color
     *         9. Comic navbar text color
     *            10. Main content link color
     *            11. Navbar link color
     *            12. Navbar hover color
     *     }
     * }
     */
    return apply_filters(
        'toocheke_color_schemes',
        array(
            'default' => array(
                'label' => __('Default', 'toocheke'),
                'colors' => array(
                    '#f5f5f5',
                    '#ffffff',
                    '#10ae98',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#000000',
                    '#f15a5a',
                    '#f8d94a',
                    '#000000',
                    '#343a40',
                    '#10ae98',
                    '#10ae98',
                    '#f15a5a',
                    '#ffffff',
                    '#c5c5c5',
                    '#10ae98',
                ),
            ),
            'dark' => array(
                'label' => __('Dark', 'toocheke'),
                'colors' => array(
                    '#111111',
                    '#202020',
                    '#10ae98',
                    '#ffffff',
                    '#202020',
                    '#ffffff',
                    '#bebebe',
                    '#f15a5a',
                    '#f8d94a',
                    '#000000',
                    '#eeeeee',
                    '#10ae98',
                    '#10ae98',
                    '#f15a5a',
                    '#202020',
                    '#c5c5c5',
                    '#10ae98',
                ),
            ),
            'gray' => array(
                'label' => __('Gray', 'toocheke'),
                'colors' => array(
                    '#616a73',
                    '#4d545c',
                    '#10ae98',
                    '#ffffff',
                    '#4d545c',
                    '#ffffff',
                    '#f2f2f2',
                    '#f15a5a',
                    '#f8d94a',
                    '#000000',
                    '#eeeeee',
                    '#10ae98',
                    '#10ae98',
                    '#f15a5a',
                    '#4d545c',
                    '#c5c5c5',
                    '#10ae98',
                ),
            ),
            'orange' => array(
                'label' => __('Orange', 'toocheke'),
                'colors' => array(
                    '#f5f5f5',
                    '#ffffff',
                    '#ff691f',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#000000',
                    '#1fb8ff',
                    '#f8d94a',
                    '#000000',
                    '#343a40',
                    '#ff691f',
                    '#ff691f',
                    '#1fb8ff',
                    '#ffffff',
                    '#c5c5c5',
                    '#10ae98',
                ),
            ),
            'yellow' => array(
                'label' => __('Yellow', 'toocheke'),
                'colors' => array(
                    '#f5f5f5',
                    '#ffffff',
                    '#fab81e',
                    '#000000',
                    '#ffffff',
                    '#ffffff',
                    '#000000',
                    '#761efa',
                    '#761efa',
                    '#000000',
                    '#343a40',
                    '#fab81e',
                    '#fab81e',
                    '#761efa',
                    '#ffffff',
                    '#c5c5c5',
                    '#10ae98',
                ),
            ),
            'lightgreen' => array(
                'label' => __('Light Green', 'toocheke'),
                'colors' => array(
                    '#f5f5f5',
                    '#ffffff',
                    '#7fdbb6',
                    '#000000',
                    '#ffffff',
                    '#ffffff',
                    '#000000',
                    '#db8d7f',
                    '#8C0000',
                    '#000000',
                    '#343a40',
                    '#7fdbb6',
                    '#7fdbb6',
                    '#db8d7f',
                    '#ffffff',
                    '#c5c5c5',
                    '#10ae98',
                ),
            ),
            'green' => array(
                'label' => __('Green', 'toocheke'),
                'colors' => array(
                    '#f5f5f5',
                    '#ffffff',
                    '#19cf86',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#000000',
                    '#cf3419',
                    '#f8d94a',
                    '#000000',
                    '#343a40',
                    '#19cf86',
                    '#19cf86',
                    '#cf3419',
                    '#ffffff',
                    '#c5c5c5',
                    '#10ae98',
                ),
            ),
            'lightblue' => array(
                'label' => __('Light Blue', 'toocheke'),
                'colors' => array(
                    '#f5f5f5',
                    '#ffffff',
                    '#91d2fa',
                    '#000000',
                    '#ffffff',
                    '#000000',
                    '#000000',
                    '#fab691',
                    '#FF0000',
                    '#000000',
                    '#343a40',
                    '#91d2fa',
                    '#91d2fa',
                    '#fab691',
                    '#ffffff',
                    '#c5c5c5',
                    '#10ae98',
                ),
            ),
            'blue' => array(
                'label' => __('Blue', 'toocheke'),
                'colors' => array(
                    '#f5f5f5',
                    '#ffffff',
                    '#1b95e0',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#000000',
                    '#e0601b',
                    '#f8d94a',
                    '#000000',
                    '#343a40',
                    '#1b95e0',
                    '#1b95e0',
                    '#e0601b',
                    '#ffffff',
                    '#c5c5c5',
                    '#10ae98',
                ),
            ),
            'red' => array(
                'label' => __('Red', 'toocheke'),
                'colors' => array(
                    '#f5f5f5',
                    '#ffffff',
                    '#e81c4f',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#000000',
                    '#4fe81c',
                    '#f8d94a',
                    '#000000',
                    '#343a40',
                    '#e81c4f',
                    '#e81c4f',
                    '#4fe81c',
                    '#ffffff',
                    '#c5c5c5',
                    '#10ae98',
                ),
            ),
            'pink' => array(
                'label' => __('Pink', 'toocheke'),
                'colors' => array(
                    '#f5f5f5',
                    '#ffffff',
                    '#f58ea8',
                    '#000000',
                    '#ffffff',
                    '#5C070E',
                    '#000000',
                    '#a8f58e',
                    '#1A6600',
                    '#000000',
                    '#343a40',
                    '#f58ea8',
                    '#f58ea8',
                    '#a8f58e',
                    '#ffffff',
                    '#c5c5c5',
                    '#10ae98',
                ),
            ),
            'purple' => array(
                'label' => __('Purple', 'toocheke'),
                'colors' => array(
                    '#f5f5f5',
                    '#ffffff',
                    '#981ceb',
                    '#ffffff',
                    '#ffffff',
                    '#000000',
                    '#000000',
                    '#ebc21c',
                    '#f8d94a',
                    '#000000',
                    '#343a40',
                    '#981ceb',
                    '#981ceb',
                    '#ebc21c',
                    '#ffffff',
                    '#c5c5c5',
                    '#10ae98',
                ),
            ),
        )
    );
}

if (!function_exists('toocheke_get_color_scheme')):
    /**
     * Get the current Toocheke color scheme.
     *
     * @since Toocheke 1.0
     *
     * @return array An associative array of either the current or default color scheme hex values.
     */
    function toocheke_get_color_scheme()
{
        $color_scheme_option = get_theme_mod('color_scheme', 'default');
        $color_schemes = toocheke_get_color_schemes();

        if (array_key_exists($color_scheme_option, $color_schemes)) {
            return $color_schemes[$color_scheme_option]['colors'];
        }

        return $color_schemes['default']['colors'];
    }
endif; // toocheke_get_color_scheme

if (!function_exists('toocheke_get_color_scheme_choices')):
    /**
     * Returns an array of color scheme choices registered for Toocheke.
     *
     * @since Toocheke 1.0
     *
     * @return array Array of color schemes.
     */
    function toocheke_get_color_scheme_choices()
{
        $color_schemes = toocheke_get_color_schemes();
        $color_scheme_control_options = array();

        foreach ($color_schemes as $color_scheme => $value) {
            $color_scheme_control_options[$color_scheme] = $value['label'];
        }

        return $color_scheme_control_options;
    }
endif; // toocheke_get_color_scheme_choices

if (!function_exists('toocheke_sanitize_color_scheme')):
    /**
     * Sanitization callback for color schemes.
     *
     * @since Toocheke 1.0
     *
     * @param string $value Color scheme name value.
     * @return string Color scheme name.
     */
    function toocheke_sanitize_color_scheme($value)
{
        $color_schemes = toocheke_get_color_scheme_choices();

        if (!array_key_exists($value, $color_schemes)) {
            $value = 'default';
        }

        return $value;
    }
endif; // toocheke_sanitize_color_scheme

/**
 * Enqueues front-end CSS for color scheme.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_color_scheme_css()
{
    $color_scheme_option = get_theme_mod('color_scheme', 'default');

    // Don't do anything if the default color scheme is selected.
    if ('default' === $color_scheme_option) {
        return;
    }

    $color_scheme = toocheke_get_color_scheme();

    $default_background_color = $color_scheme[0];
    $default_navbar_background_color = $color_scheme[1];
    $default_jumbotron_and_sidebar_background_color = $color_scheme[2];
    $default_jumbotron_and_sidebar_text_color = $color_scheme[3];
    $default_content_background_color = $color_scheme[4];
    $default_box_text_color = $color_scheme[5];
    $default_dark_text_color = $color_scheme[6];
    $default_complementary_color = $color_scheme[7];
    $default_sidebar_links_active_page_link = $color_scheme[8];
    $default_active_page_text_color = $color_scheme[9];
    $default_comic_navbar_link_text_color = $color_scheme[10];
    $default_main_content_link_color = $color_scheme[11];
    $default_navbar_link_color = $color_scheme[12];
    $default_navbar_link_hover_color = $color_scheme[13];
    $default_footer_background_color = $color_scheme[14];
    $default_footer_text_color = $color_scheme[15];
    $default_footer_link_color = $color_scheme[16];

    // Convert main and sidebar text hex color to rgba.
    $colors = array(
        'background_color' => get_theme_mod('default_background_color', $default_background_color),
        'navbar_background_color' => get_theme_mod('navbar_background_color', $default_navbar_background_color),
        'jumbotron_and_sidebar_background_color' => get_theme_mod('jumbotron_and_sidebar_background_color', $default_jumbotron_and_sidebar_background_color),
        'jumbotron_and_sidebar_text_color' => get_theme_mod('jumbotron_and_sidebar_text_color', $default_jumbotron_and_sidebar_text_color),
        'content_background_color' => get_theme_mod('content_background_color', $default_content_background_color),
        'box_text_color' => get_theme_mod('box_text_color', $default_box_text_color),
        'dark_text_color' => get_theme_mod('dark_text_color', $default_dark_text_color),
        'complementary_color' => get_theme_mod('complementary_color', $default_complementary_color),
        'sidebar_links_active_page_link' => get_theme_mod('sidebar_links_active_page_link', $default_sidebar_links_active_page_link),
        'active_page_text_color' => get_theme_mod('active_page_text_color', $default_active_page_text_color),
        'comic_navbar_link_text_color' => get_theme_mod('comic_navbar_link_text_color', $default_comic_navbar_link_text_color),
        'main_content_link_color' => get_theme_mod('main_content_link_color', $default_main_content_link_color),
        'navbar_link_color' => get_theme_mod('navbar_link_color', $default_navbar_link_color),
        'navbar_link_hover_color' => get_theme_mod('navbar_link_hover_color', $default_navbar_link_hover_color),
        'footer_background_color' => get_theme_mod('footer_background_color', $default_footer_background_color),
        'footer_text_color' => get_theme_mod('footer_text_color', $default_footer_text_color),
        'footer_link_color' => get_theme_mod('footer_link_color', $default_footer_link_color),
    );

    $color_scheme_css = toocheke_get_color_scheme_css($colors);

    wp_add_inline_style('toocheke-style', $color_scheme_css);
}
add_action('wp_enqueue_scripts', 'toocheke_color_scheme_css');

/**
 * Binds JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 *
 * @since Toocheke 1.0
 */
function toocheke_customize_control_js()
{
    wp_enqueue_script('color-scheme-control', get_template_directory_uri() . '/dist/js/color-scheme-control.js', array('customize-controls', 'iris', 'underscore', 'wp-util'), '20190508', true);
    wp_localize_script('color-scheme-control', 'colorScheme', toocheke_get_color_schemes());
}
add_action('customize_controls_enqueue_scripts', 'toocheke_customize_control_js');

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Toocheke 1.0
 */
function toocheke_customizer()
{
    wp_enqueue_script('toocheke-customize-preview', get_template_directory_uri() . '/dist/js/customizer.js', array('customize-preview'), '20190508', true);
}
add_action('customize_preview_init', 'toocheke_customizer');

/**
 * Returns CSS for the color schemes.
 *
 * @since Toocheke 1.0
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function toocheke_get_color_scheme_css($colors)
{
    $colors = wp_parse_args(
        $colors,
        array(
            'background_color' => '',
            'navbar_background_color' => '',
            'jumbotron_and_sidebar_background_color' => '',
            'jumbotron_and_sidebar_text_color' => '',
            'content_background_color' => '',
            'box_text_color' => '',
            'dark_text_color' => '',
            'complementary_color' => '',
            'sidebar_links_active_page_link' => '',
            'active_page_text_color' => '',
            'comic_navbar_link_text_color' => '',
            'main_content_link_color' => '',
            'navbar_link_color' => '',
            'navbar_link_hover_color' => '',
            'footer_background_color' => '',
            'footer_text_color' => '',
            'footer_link_color' => '',
        )
    );

    $css = <<<CSS
	/* Color Scheme */

	/* Main Background Color */
	body, #comic-list>li:hover, .comment-respond{
		background-color: {$colors['background_color']} !important;
	}
    #side-bar #comic-list{
	border: 1px solid {$colors['background_color']} !important;
}
	#comic-list>li {
		border-bottom: 1px solid {$colors['background_color']} !important;
	}

	#comic-list>li:first-child {
		border-top: 1px solid {$colors['background_color']} !important;
	}

	/* Navbar and Nav DropdownArea */
	.navbar, .navbar-expand-md .navbar-nav .dropdown-menu
	{

	background-color: {$colors['navbar_background_color']} !important;

	}

	/* Content Area */
	#left-col,
	#left-content,
	#comic-nav-top,
	#comic-nav-bottom,
	#comic,
	#comments .card .card-header,
	.single-comic-navigation
	{

	background-color: {$colors['content_background_color']} !important;

	}

	/* Box Text Colors */
	input[type="submit"],
	input[type="button"],
	input[type="reset"],
	button,
	.dropdown-item:focus,
	.dropdown-item:hover,
	#side-bar a:visited,
	.social-links ul li a,
	.social-links ul li a span.fab,
	.social-links ul li a span.fas,
	#side-bar section#twitter ul li a,
	.page-numbers,
	.page-numbers:hover,
	.chip,
	#wp-calendar caption,
    #wp-calendar th,
    #archive-page-calendar-wrapper
#wp-calendar tbody td a
	{
		color: {$colors['box_text_color']} !important;
	}
	#wp-calendar thead th,
	#wp-calendar tbody td
	{
		border: 1px solid {$colors['jumbotron_and_sidebar_text_color']} !important;
	}
	#wp-calendar thead th,
	#wp-calendar tbody td{
		color: {$colors['jumbotron_and_sidebar_text_color']} !important;
	}





	/* Main Content Text Colors */
    body,
    #comic-list>li>a
     {
		color: {$colors['dark_text_color']};
    }
    #archive-page-calendar-wrapper
#wp-calendar tbody td,
#archive-page-calendar-wrapper
#wp-calendar tbody td:hover ,
#archive-page-calendar-wrapper
#wp-calendar th
     {
		color: {$colors['dark_text_color']} !important;
    }
    #archive-page-calendar-wrapper
#wp-calendar thead th ,
#archive-page-calendar-wrapper
#wp-calendar tbody td,
#transcript-wrapper .panel
{
    border: 1px solid {$colors['dark_text_color']} !important;

}
#transcript hr, .toocheke-hr {
  border-top: 1px solid {$colors['dark_text_color']} !important;
}

	/* Complementary Colors */
	a:hover,
	a:focus,
    a:active,
    a:visited,
    .swipe,
    #archive-page-calendar-wrapper
#wp-calendar tfoot a
	{
		color: {$colors['complementary_color']} ;
	}
	input[type="submit"],
	input[type="button"],
	input[type="reset"],
	button,
	input[type="submit"]:hover,
	input[type="button"]:hover,
	input[type="reset"]:hover,
	button:hover,
	.btn-danger,
	.btn-danger:hover
	{
		background-color: {$colors['complementary_color']} !important;
		border: 1px solid {$colors['complementary_color']} !important;
	}


	.social-links ul li a span.fab,
	.social-links ul li a span.fas,
	#wp-calendar tbody td:hover a,
	#wp-calendar caption,
	.page-numbers:hover,
	#home-scroll-container .ScrollTop,  #language-switch-container .SwitchLang,
	#side-bar .tagcloud a:hover,
    #side-bar .tagcloud a:focus,
    #archive-page-calendar-wrapper
#wp-calendar tbody td a
	{
		background-color: {$colors['complementary_color']} !important;
	}

	/* Sidebar Background, Links, Input Color */
	 #comic-list>li:hover a,  #comic-list>li:hover p, #side-bar #comic-list > li:hover a, #side-bar #comic-list > li:hover p, #comic-list>li>a:hover, .comic-navigation a:hover {
		color: {$colors['jumbotron_and_sidebar_background_color']} ;
	}

	input[type="text"]:focus,
	input[type="password"]:focus,
	input[type="email"]:focus,
	input[type="number"]:focus,
	input[type="tel"]:focus,
	input[type="url"]:focus,
	input[type="search"]:focus,
	textarea:focus,
	textarea.form-control:focus,
	select.form-control:focus {
		border: 1px solid {$colors['jumbotron_and_sidebar_background_color']} !important;
	}

	.jumbotron, #side-bar, .page-numbers, .chip, .left-title:after, .series-rollover{
		background-color: {$colors['jumbotron_and_sidebar_background_color']} !important;
	}

	.current-comic {
		border: 3px solid {$colors['jumbotron_and_sidebar_background_color']} !important;
	}
	/* Sidebar links and active page link */
	#wp-calendar tfoot a, #side-bar a, #side-bar .tagcloud a{
		color: {$colors['sidebar_links_active_page_link']};
	}


	/* Sidebar and Jumbotron text color */
	.jumbotron, #side-bar, #side-bar section .widget-title, .social-links ul li a, #side-bar section#twitter ul li a,
	#side-bar .tagcloud a:hover,
    #side-bar .tagcloud a:focus,
    .series-rollover,.series-link, .series-link:hover,
    #side-bar .comic-item .comic-title, #side-bar .comic-item .comic-list-item-details
	{
		color: {$colors['jumbotron_and_sidebar_text_color']};
	}
	#home-scroll-container .ScrollTop:hover, #language-switch-container .SwitchLang:hover
	{
		color: {$colors['jumbotron_and_sidebar_text_color']} !important;
		background-color: {$colors['jumbotron_and_sidebar_background_color']} !important;
	}




	.page-numbers.current {
		background-color: {$colors['sidebar_links_active_page_link']} !important;
	}
	#side-bar .tagcloud a {
		border: 1px solid {$colors['sidebar_links_active_page_link']};

	}

	/* Active Page Text Color */

	.page-numbers, .page-numbers:hover,
	.page-numbers.current
	{
		border: 1px solid {$colors['active_page_text_color']} !important;
	}
	.page-numbers.current {
		color: {$colors['active_page_text_color']} !important;
	}

   /* Comic Navbar Link Text Color*/
   #comic-nav-top,
#comic-nav-bottom ,
.comic-navigation,
.comic-navigation a{
	color: {$colors['comic_navbar_link_text_color']};
}

/* Main Content Link Color */
a,
a:visited
	{
		color: {$colors['main_content_link_color']} ;
	}

	/* Navbar Link Color */
	.navbar-light .navbar-nav .nav-link, a.dropdown-item, #archive-menu li a {
		color: {$colors['navbar_link_color']} ;
	}
	.navbar-light .navbar-toggler .icon-bar{
		background-color: {$colors['navbar_link_color']} !important;
	}

	/* Navbar Hover Link Color */
	.navbar-light .navbar-nav .nav-link:focus,
	.navbar-light .navbar-nav .nav-link:hover,
	.navbar-light .navbar-nav .active>.nav-link,
	.navbar-light .navbar-nav .nav-link.active,
	.navbar-light .navbar-nav .nav-link.show,
	.navbar-light .navbar-nav .show>.nav-link,
    #archive-menu li a:hover{
		color: {$colors['navbar_link_hover_color']} ;
	}

	.navbar-light .navbar-nav>.active>a,
	.navbar-light .navbar-nav>.active>a:hover,
	.navbar-light .navbar-nav>.active>a:focus {
		border-bottom: 3px solid {$colors['navbar_link_hover_color']} !important;
	}

	.navbar-light .navbar-toggler .icon-bar:hover,
	.navbar-nav>.menu-item:before,
	.dropdown-item:focus,
	.dropdown-item:hover,
    #archive-menu li:before
	{
		background-color: {$colors['navbar_link_hover_color']} !important;
	}

	/* Footer */
	.footer {
	background-color: {$colors['footer_background_color']} !important;
	color: {$colors['footer_text_color']} !important;
}
.footer a, .footer a:hover, .footer a:focus, .footer a:active {
	color: {$colors['footer_link_color']} !important;
}


CSS;

    return $css;
}

/**
 * Output an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the Customizer
 * preview.
 *
 * @since Toocheke 1.0
 */
function toocheke_color_scheme_css_template()
{
    $colors = array(
        'background_color' => '{{ data.background_color }}',
        'navbar_background_color' => '{{ data.navbar_background_color }}',
        'jumbotron_and_sidebar_background_color' => '{{ data.jumbotron_and_sidebar_background_color }}',
        'jumbotron_and_sidebar_text_color' => '{{ data.jumbotron_and_sidebar_text_color }}',
        'content_background_color' => '{{ data.content_background_color }}',
        'box_text_color' => '{{ data.box_text_color }}',
        'dark_text_color' => '{{ data.dark_text_color }}',
        'complementary_color' => '{{ data.complementary_color }}',
        'sidebar_links_active_page_link' => '{{ data.sidebar_links_active_page_link }}',
        'active_page_text_color' => '{{ data.active_page_text_color }}',
        'comic_navbar_link_text_color' => '{{ data.comic_navbar_link_text_color }}',
        'main_content_link_color' => '{{ data.main_content_link_color }}',
        'navbar_link_color' => '{{ data.navbar_link_color }}',
        'navbar_link_hover_color' => '{{ data.navbar_link_hover_color }}',
        'footer_background_color' => '{{ data.footer_background_color }}',
        'footer_text_color' => '{{ data.footer_text_color }}',
        'footer_link_color' => '{{ data.footer_link_color }}',
    );
    ?>
<script type="text/html" id="tmpl-toocheke-color-scheme">
<?php
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo toocheke_get_color_scheme_css($colors);
    ?>
</script>
<?php
}
add_action('customize_controls_print_footer_scripts', 'toocheke_color_scheme_css_template');

/**
 * Enqueues front-end CSS for the main background color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_background_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[0];
    $background_color = "#" . get_theme_mod('background_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($background_color === $default_color) {
        return;
    }

    $css = '
		/* Main Background Color */
			body, #comic-list>li:hover, .comment-respond{
				background-color: %1$s !important;
		}
	';

    wp_add_inline_style('toocheke-style', sprintf($css, $background_color));
}
add_action('wp_enqueue_scripts', 'toocheke_background_color_css', 11);

/**
 * Enqueues front-end CSS for the navbar background color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_navbar_background_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[1];
    $navbar_background_color = get_theme_mod('navbar_background_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($navbar_background_color === $default_color) {
        return;
    }

    $css = '
		/* Navbar and Nav DropdownArea */
		.navbar, .navbar-expand-md .navbar-nav .dropdown-menu
		{

		background-color: %1$s !important;

		}

	';

    wp_add_inline_style('toocheke-style', sprintf($css, $navbar_background_color));
}
add_action('wp_enqueue_scripts', 'toocheke_navbar_background_color_css', 11);

/**
 * Enqueues front-end CSS for the jumbotron, sidebar Background, Links, Input background color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_jumbotron_and_sidebar_background_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[2];
    $jumbotron_and_sidebar_background_color = get_theme_mod('jumbotron_and_sidebar_background_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($jumbotron_and_sidebar_background_color === $default_color) {
        return;
    }

    $css = '
		/* Sidebar Background, Links, Input Color */
			 #comic-list>li:hover a,  #comic-list>li:hover p, #side-bar #comic-list > li:hover a, #side-bar #comic-list > li:hover p, #comic-list>li>a:hover, .comic-navigation a:hover {
				color: %1$s ;
			}

			input[type="text"]:focus,
			input[type="password"]:focus,
			input[type="email"]:focus,
			input[type="number"]:focus,
			input[type="tel"]:focus,
			input[type="url"]:focus,
			input[type="search"]:focus,
			textarea:focus,
			textarea.form-control:focus,
			select.form-control:focus {
				border: 1px solid %1$s !important;
			}

			.jumbotron, #side-bar, .page-numbers, .chip, .left-title:after,.series-rollover {
				background-color: %1$s !important;
			}

			.current-comic {
				border: 3px solid %1$s !important;
		}
		#home-scroll-container .ScrollTop:hover, #language-switch-container .SwitchLang:hover
		{
			background-color: %1$s !important;
		}
	';

    wp_add_inline_style('toocheke-style', sprintf($css, $jumbotron_and_sidebar_background_color));
}
add_action('wp_enqueue_scripts', 'toocheke_jumbotron_and_sidebar_background_color_css', 11);

/**
 * Enqueues front-end CSS for the jumbotron, sidebar text color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_jumbotron_and_sidebar_text_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[3];
    $jumbotron_and_sidebar_text_color = get_theme_mod('jumbotron_and_sidebar_text_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($jumbotron_and_sidebar_text_color === $default_color) {
        return;
    }

    $css = '
		/* Sidebar and Jumbotron text color */
		 #wp-calendar thead th,
			#wp-calendar tbody td
			{
				border: 1px solid %1$s !important;
		}
			#wp-calendar thead th,
			#wp-calendar tbody td{
				color: %1$s !important;
			}
			.jumbotron, #side-bar, #side-bar section .widget-title, .social-links ul li a, #side-bar section#twitter ul li a,
				#side-bar .tagcloud a:hover,
                #side-bar .tagcloud a:focus,
                .series-rollover, .series-link, .series-link:hover,
                #side-bar .comic-item .comic-title, #side-bar .comic-item .comic-list-item-details
				{
					color: %1$s;
		}

		#home-scroll-container .ScrollTop:hover, #language-switch-container .SwitchLang:hover
			{
				color: %1$s !important;

	}

	';

    wp_add_inline_style('toocheke-style', sprintf($css, $jumbotron_and_sidebar_text_color));
}
add_action('wp_enqueue_scripts', 'toocheke_jumbotron_and_sidebar_text_color_css', 11);

/**
 * Enqueues front-end CSS for the content background color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_content_background_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[4];
    $content_background_color = get_theme_mod('content_background_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($content_background_color === $default_color) {
        return;
    }

    $css = '
		/* Content Area */
			#left-col,
			#left-content,
			#comic-nav-top,
			#comic-nav-bottom,
			#comic,
			#comments .card .card-header,
			.single-comic-navigation
			{

			background-color: %1$s !important;

	}

	';

    wp_add_inline_style('toocheke-style', sprintf($css, $content_background_color));
}
add_action('wp_enqueue_scripts', 'toocheke_content_background_color_css', 11);

/**
 * Enqueues front-end CSS for the box text color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_box_text_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[5];
    $box_text_color = get_theme_mod('box_text_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($box_text_color === $default_color) {
        return;
    }

    $css = '
		/* Box Text Colors */
	input[type="submit"],
	input[type="button"],
	input[type="reset"],
	button,
	.dropdown-item:focus,
	.dropdown-item:hover,
	#side-bar a:visited,
	.social-links ul li a,
	.social-links ul li a span.fab,
	.social-links ul li a span.fas,
	#side-bar section#twitter ul li a,
	.page-numbers,
	.page-numbers:hover,
	.chip,
	#wp-calendar caption,
    #wp-calendar th,
    #archive-page-calendar-wrapper
#wp-calendar tbody td a
	{
		color: %1$s !important;
	}



	';

    wp_add_inline_style('toocheke-style', sprintf($css, $box_text_color));
}
add_action('wp_enqueue_scripts', 'toocheke_box_text_color_css', 11);

/**
 * Enqueues front-end CSS for the main content text color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_dark_text_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[6];
    $dark_text_color = get_theme_mod('dark_text_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($dark_text_color === $default_color) {
        return;
    }

    $css = '
		/* Main Content Text Colors */
			body, #comic-list>li>a {
				color: %1$s;
    }
    #archive-page-calendar-wrapper
#wp-calendar tbody td,
#archive-page-calendar-wrapper
#wp-calendar tbody td:hover ,
#archive-page-calendar-wrapper
#wp-calendar th
     {
		color: %1$s !important;
    }
    #archive-page-calendar-wrapper
#wp-calendar thead th ,
#archive-page-calendar-wrapper
#wp-calendar tbody td,
#transcript-wrapper .panel
{
    border: 1px solid %1$s !important;

}
#transcript hr, .toocheke-hr {
  border-top: 1px solid %1$s !important;
}
	';

    wp_add_inline_style('toocheke-style', sprintf($css, $dark_text_color));
}
add_action('wp_enqueue_scripts', 'toocheke_dark_text_color_css', 11);

/**
 * Enqueues front-end CSS for the complementary color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_complementary_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[7];
    $complementary_color = get_theme_mod('complementary_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($complementary_color === $default_color) {
        return;
    }

    $css = '
		/* Complementary Colors */
            a:hover,
            a:focus,
            a:active,
            a:visited,
            .swipe,
            #archive-page-calendar-wrapper
            #wp-calendar tfoot a
            {
				color: %1$s ;
			}
			input[type="submit"],
			input[type="button"],
			input[type="reset"],
			button,
			input[type="submit"]:hover,
			input[type="button"]:hover,
			input[type="reset"]:hover,
			button:hover,
			.btn-danger,
			.btn-danger:hover
			{
				background-color: %1$s !important;
				border: 1px solid %1$s !important;
			}

			.social-links ul li a span.fab,
			.social-links ul li a span.fas,
			#wp-calendar tbody td:hover a,
			#wp-calendar caption,
			.page-numbers:hover,
			#home-scroll-container .ScrollTop, #language-switch-container .SwitchLang,
			#side-bar .tagcloud a:hover,
            #side-bar .tagcloud a:focus,
            #archive-page-calendar-wrapper
            #wp-calendar tbody td a
			{
				background-color: %1$s !important;
	}

	';

    wp_add_inline_style('toocheke-style', sprintf($css, $complementary_color));
}
add_action('wp_enqueue_scripts', 'toocheke_complementary_color_css', 11);

/**
 * Enqueues front-end CSS for the sidebar links and active page link color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_sidebar_links_active_page_link_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[8];
    $sidebar_links_active_page_link = get_theme_mod('sidebar_links_active_page_link', $default_color);

    // Don't do anything if the current color is the default.
    if ($sidebar_links_active_page_link === $default_color) {
        return;
    }

    $css = '
			/* Sidebar links and active page link */
			#wp-calendar tfoot a, #side-bar a, #side-bar .tagcloud a  {
				color: %1$s;
	}
		.page-numbers.current {
			background-color: %1$s !important;
		}
		#side-bar .tagcloud a {
			border: 1px solid %1$s;

	}

	';

    wp_add_inline_style('toocheke-style', sprintf($css, $sidebar_links_active_page_link));
}
add_action('wp_enqueue_scripts', 'toocheke_sidebar_links_active_page_link_css', 11);

/**
 * Enqueues front-end CSS for the active page text color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_active_page_text_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[9];
    $active_page_text_color = get_theme_mod('active_page_text_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($active_page_text_color === $default_color) {
        return;
    }

    $css = '
				/* Active Page Text Color */

				.page-numbers, .page-numbers:hover,
				.page-numbers.current
				{
					border: 1px solid %1$s !important;
				}
				.page-numbers.current {
					color: %1$s !important;
	}

	';

    wp_add_inline_style('toocheke-style', sprintf($css, $active_page_text_color));
}
add_action('wp_enqueue_scripts', 'toocheke_active_page_text_color_css', 11);

/**
 * Enqueues front-end CSS for the comic navbar text color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_comic_navbar_link_text_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[10];
    $comic_navbar_link_text_color = get_theme_mod('comic_navbar_link_text_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($comic_navbar_link_text_color === $default_color) {
        return;
    }

    $css = '
				 /* Comic Navbar Link Text Color*/
				   #comic-nav-top,
				#comic-nav-bottom ,
				.comic-navigation,
				.comic-navigation a{
					color: %1$s;
}

	';

    wp_add_inline_style('toocheke-style', sprintf($css, $comic_navbar_link_text_color));
}
add_action('wp_enqueue_scripts', 'toocheke_comic_navbar_link_text_color_css', 11);

/**
 * Enqueues front-end CSS for the main link color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_main_content_link_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[11];
    $main_content_link_color = get_theme_mod('main_content_link_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($main_content_link_color === $default_color) {
        return;
    }

    $css = '
				/* Main Content Link Color */
				a,
                a:visited
					{
						color: %1$s ;
	}

	';

    wp_add_inline_style('toocheke-style', sprintf($css, $main_content_link_color));
}
add_action('wp_enqueue_scripts', 'toocheke_main_content_link_color_css', 11);

/**
 * Enqueues front-end CSS for the navbar link color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_navbar_link_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[12];
    $navbar_link_color = get_theme_mod('navbar_link_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($navbar_link_color === $default_color) {
        return;
    }

    $css = '
				/* Navbar Link Color */
				.navbar-light .navbar-nav .nav-link, a.dropdown-item, #archive-menu li a {
									color: %1$s;
				}
				.navbar-light .navbar-toggler .icon-bar{
					background-color: %1$s;
				}

	';

    wp_add_inline_style('toocheke-style', sprintf($css, $navbar_link_color));
}
add_action('wp_enqueue_scripts', 'toocheke_navbar_link_color_css', 11);

/**
 * Enqueues front-end CSS for the navbar link hover color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_navbar_link_hover_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[13];
    $navbar_link_hover_color = get_theme_mod('navbar_link_hover_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($navbar_link_hover_color === $default_color) {
        return;
    }

    $css = '
		/* Navbar Link Hover Color */
		.navbar-light .navbar-nav .active>.nav-link, .navbar-light .navbar-nav .nav-link.active, .navbar-light .navbar-nav .nav-link.show, .navbar-light .navbar-nav .show>.nav-link {
		    color: %1$s;
		}

		.navbar-light .navbar-nav .nav-link:focus,
	.navbar-light .navbar-nav .nav-link:hover,
	.navbar-light .navbar-nav .active>.nav-link,
	.navbar-light .navbar-nav .nav-link.active,
	.navbar-light .navbar-nav .nav-link.show,
	.navbar-light .navbar-nav .show>.nav-link,
    #archive-menu li a:hover{
		color: %1$s;
	}

		.navbar-light .navbar-nav>.active>a,
	.navbar-light .navbar-nav>.active>a:hover,
	.navbar-light .navbar-nav>.active>a:focus {
		border-bottom: 3px solid %1$s !important;
	}

	.navbar-light .navbar-toggler .icon-bar:hover,
	.dropdown-item:focus,
	.dropdown-item:hover,
	.navbar-nav>.menu-item:before,
    #archive-menu li:before
	{
		background-color: %1$s !important;
	}
	';

    wp_add_inline_style('toocheke-style', sprintf($css, $navbar_link_hover_color));
}
add_action('wp_enqueue_scripts', 'toocheke_navbar_link_hover_color_css', 11);

/**
 * Enqueues front-end CSS for the footer background color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_footer_background_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[14];
    $footer_background_color = get_theme_mod('footer_background_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($footer_background_color === $default_color) {
        return;
    }

    $css = '
		/* Footer background Color */
		.footer {
	background-color: %1$s !important;
}
	';

    wp_add_inline_style('toocheke-style', sprintf($css, $footer_background_color));
}
add_action('wp_enqueue_scripts', 'toocheke_footer_background_color_css', 11);

/**
 * Enqueues front-end CSS for the footer text color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_footer_text_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[15];
    $footer_text_color = get_theme_mod('footer_text_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($footer_text_color === $default_color) {
        return;
    }

    $css = '
		/* Footer text Color */
		.footer {
	color: %1$s  !important;
}
	';

    wp_add_inline_style('toocheke-style', sprintf($css, $footer_text_color));
}
add_action('wp_enqueue_scripts', 'toocheke_footer_text_color_css', 11);

/**
 * Enqueues front-end CSS for the footer link color.
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 */
function toocheke_footer_link_color_css()
{
    $color_scheme = toocheke_get_color_scheme();
    $default_color = $color_scheme[16];
    $footer_link_color = get_theme_mod('footer_link_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($footer_link_color === $default_color) {
        return;
    }

    $css = '
		/* Footer Link Color */
		.footer a, .footer a:hover, .footer a:focus, .footer a:active {
	color: %1$s !important;
}
	';

    wp_add_inline_style('toocheke-style', sprintf($css, $footer_link_color));
}
add_action('wp_enqueue_scripts', 'toocheke_footer_link_color_css', 11);
/**
 * Enqueues front-end CSS for the header/hero height
 *
 * @since Toocheke 1.0
 *
 * @see wp_add_inline_style()
 *previous jumbotron style
 *     .jumbotron {
 *   height: %1$spx;
 *}
 */
function toocheke_jumbotron_height_css()
{
    $jumbotron_height = get_theme_mod('hero_setting');

    // Don't do anything if the current height is the default.
    if ($jumbotron_height === 320) {
        return;
    }

    $css = '
		/* Custom jumbotron height */
		.jumbotron {
    height: auto;
}
	';

    wp_add_inline_style('toocheke-style', sprintf($css, $jumbotron_height));
}
add_action('wp_enqueue_scripts', 'toocheke_jumbotron_height_css', 11);