<?php

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function toocheke_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Right Sidebar', 'toocheke'),
        'id' => 'right-sidebar',
        'description' => esc_html__('Add widgets here that will be displayed in the right sidebar.', 'toocheke'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Home Top Content Area', 'toocheke'),
        'id' => 'home-left-top',
        'description' => esc_html__('Add widgets here that will be displayed in the main content area on the left of the home page(above "Latest Comics, "Latest Posts", "Latest Chapters", and "Latest Collections")', 'toocheke'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Home Bottom Content Area ', 'toocheke'),
        'id' => 'home-left-bottom',
        'description' => esc_html__('Add widgets here that will be displayed in the main content area on the left of the home page(below "Latest Comics, "Latest Posts", "Latest Chapters", and "Latest Collections")', 'toocheke'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Above Comic Series', 'toocheke'),
        'id' => 'home-above-series',
        'description' => esc_html__('Add widgets here that will be displayed in the main content area on the left of the home page(above "Comic Series")', 'toocheke'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Below Comic Series', 'toocheke'),
        'id' => 'home-below-series',
        'description' => esc_html__('Add widgets here that will be displayed in the main content area on the left of the home page(below "Comic Series")', 'toocheke'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Above Comic', 'toocheke'),
        'id' => 'above-comic',
        'description' => esc_html__('Add widgets here that will be displayed above the comic', 'toocheke'),
        'before_widget' => '<section id="%1$s" class="above-comic-widget widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Below Comic', 'toocheke'),
        'id' => 'below-comic',
        'description' => esc_html__('Add widgets here that will be displayed below the comic', 'toocheke'),
        'before_widget' => '<section id="%1$s" class="below-comic-widget widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    register_sidebar(
        array(
            'name' => esc_html__('Below Header', 'toocheke'),
            'description' => esc_html__('Displayed on every page below the header section.', 'toocheke'),
            'id' => 'below-header',
            'before_widget' => '',
            'after_widget' => '',

        )
    );
    register_sidebar(
        array(
            'name' => esc_html__('Above Footer', 'toocheke'),
            'description' => esc_html__('Displayed on every page abover the footer.', 'toocheke'),
            'id' => 'above-footer',
            'before_widget' => '',
            'after_widget' => '',

        )
    );

}
add_action('widgets_init', 'toocheke_widgets_init');

/*
 * About Widget
 */
if (!function_exists('toocheke_load_about_widget')):
    function toocheke_load_about_widget()
{
        register_widget('toocheke_about_widget');
    }
endif;
add_action('widgets_init', 'toocheke_load_about_widget');

if (!class_exists('toocheke_about_widget')):
    class toocheke_about_widget extends WP_Widget
{

        public function __construct()
    {
            $widget_details = array(
                'classname' => 'toocheke_about_widget',
                'description' => esc_html__('Creates an about section consisting of a title, image/avatar, and a description. Ideal for the right sidebar on the Toocheke WP theme.', 'toocheke'),
            );

            parent::__construct('toocheke_about_widget', 'Toocheke: About Us', $widget_details);

            add_action('admin_enqueue_scripts', array($this, 'toocheke_about_us_widget_assets'));
        }

        public function toocheke_about_us_widget_assets()
    {
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_enqueue_script('toocheke-bootstrap', get_template_directory_uri() . '/dist/js/toocheke-media-upload.js', array('jquery'), '20190508', true);
            wp_enqueue_style('thickbox');
        }

        public function widget($args, $instance)
    {
            $allowed_tags = array(
                'section' => array(
                    'id' => array(),
                    'class' => array(),
                ),
                'h4' => array(
                    'class' => array(),
                ),
            );
            echo wp_kses($args['before_widget'], $allowed_tags);
            if (!empty($instance['title'])) {
                $title = !empty($instance['title']) ? $instance['title'] : '';
                $title = apply_filters('widget_title', $title, $instance, $this->id_base);
                echo wp_kses($args['before_title'], $allowed_tags) . wp_kses($title, $allowed_tags) . wp_kses($args['after_title'], $allowed_tags);
            }

            ?>
										<img src='<?php echo esc_attr($instance['image']) ?>' class='about-avatar'>

										<?php echo wp_kses_data(wpautop(esc_html($instance['description']))) ?>




										<?php

            echo wp_kses($args['after_widget'], $allowed_tags);
        }

        public function update($new_instance, $old_instance)
    {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
            $instance['description'] = (!empty($new_instance['description'])) ? sanitize_textarea_field($new_instance['description']) : '';
            $instance['image'] = (!empty($new_instance['image'])) ? sanitize_text_field($new_instance['image']) : '';
            return $instance;
        }

        public function form($instance)
    {

            $title = '';
            if (!empty($instance['title'])) {
                $title = $instance['title'];
            }

            $description = '';
            if (!empty($instance['description'])) {
                $description = $instance['description'];
            }

            $image = '';
            if (isset($instance['image'])) {
                $image = $instance['image'];
            }
            ?>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('title')); ?>"><?php esc_html_e('Title:', 'toocheke');?></label>
										    <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
										        value="<?php echo esc_attr($title); ?>" />
										</p>

										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php esc_html_e('Description:', 'toocheke');?></label>
										    <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('description')); ?>"
										        type="text"><?php echo esc_html($description); ?></textarea>
										</p>


										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('image')); ?>"><?php esc_html_e('Image:', 'toocheke');?></label>
										    <input name="<?php echo esc_attr($this->get_field_name('image')); ?>"
										        id="<?php echo esc_attr($this->get_field_id('image')); ?>" class="widefat" type="text" size="36"
										        value="<?php echo esc_url($image); ?>" />
										    <input class="upload_image_button" type="button" value="Upload Image" />
										</p>
										<?php
    }
    }
endif;
//About Us Widget ends here

/*
 * Social Media Widget
 */

if (!function_exists('toocheke_load_social_media')):
    function toocheke_load_social_media()
{
        register_widget('toocheke_social_media');
    }
endif;
add_action('widgets_init', 'toocheke_load_social_media');

if (!class_exists('toocheke_social_media')):
    class toocheke_social_media extends WP_Widget
{

        public function __construct()
    {
            $widget_details = array(
                'classname' => 'toocheke_social_media social-links',
                'description' => esc_html__('Add links to your social media profiles. Ideally for the right sidebar on the Toocheke WP theme. ', 'toocheke'),
            );

            parent::__construct('toocheke_social_media', 'Toocheke: Social', $widget_details);

        }

        public function widget($args, $instance)
    {
            $allowed_tags = array(
                'section' => array(
                    'id' => array(),
                    'class' => array(),
                ),
                'h4' => array(
                    'class' => array(),
                ),
            );
            echo wp_kses($args['before_widget'], $allowed_tags);
            if (!empty($instance['title'])) {
                $title = !empty($instance['title']) ? $instance['title'] : '';
                $title = apply_filters('widget_title', $title, $instance, $this->id_base);
                echo wp_kses($args['before_title'], $allowed_tags) . wp_kses($title, $allowed_tags) . wp_kses($args['after_title'], $allowed_tags);
            }
            ?>
										<ul>
										    <?php if (!empty($instance['patreon_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['patreon_url']) ?>' title="Patreon"><span class="fab fa-md fa-patreon"></span></a></li>
								             <?php }if (!empty($instance['kickstarter_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['kickstarter_url']) ?>' title="Kickstarter"><span
										                class="fab fa-md fa-kickstarter-k"></span></a></li>
										    <?php }if (!empty($instance['webtoon_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['webtoon_url']) ?>'
										            title="Line Webtoon"><span class="fab fa-md">
										                <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
										                    <title />
										                    <path
										                        d="M15.023 15.26c.695 0 1.014-.404 1.014-1.051 0-.551-.308-1.01-.984-1.01-.58 0-.912.404-.912 1.016 0 .543.32 1.045.882 1.045zM10.135 15.447c.764 0 1.113-.443 1.113-1.154 0-.604-.338-1.109-1.082-1.109-.637 0-1.002.445-1.002 1.115 0 .597.352 1.148.971 1.148zM24 10.201l-3.15.029.83-9.686L1.958 3.605l1.686 6.248H0l3.734 11.488 8.713-1.283v3.396l10.113-4.641L24 10.201zm-9.104-3.594c0-.049.039-.092.088-.094l1.879-.125.446-.029c.524-.035 1.634.063 1.634 1.236 0 .83-.619 1.184-.619 1.184s.75.189.707 1.092c0 1.602-1.943 1.389-1.943 1.389l-.225-.006-1.908-.053a.089.089 0 0 1-.086-.09l.027-4.504zm-3.675.243c0-.047.039-.09.088-.092l3.064-.203a.08.08 0 0 1 .087.08v.943c0 .049-.039.09-.087.092l-1.9.08a.094.094 0 0 0-.088.09l-.005.394a.083.083 0 0 0 .086.084l1.646-.066a.082.082 0 0 1 .086.084l-.02 1.012a.089.089 0 0 1-.089.086h-1.63a.089.089 0 0 0-.088.088v.416c0 .047.039.088.088.088l1.87.033a.09.09 0 0 1 .087.09v.951a.084.084 0 0 1-.087.084l-3.063-.123a.09.09 0 0 1-.087-.09l.042-4.121zm-6.01.312l.975-.064a.101.101 0 0 1 .105.08l.458 2.205c.01.047.027.047.039 0l.576-2.281a.132.132 0 0 1 .108-.09l.921-.061a.108.108 0 0 1 .109.078l.564 2.342c.012.047.029.047.041 0l.6-2.424a.131.131 0 0 1 .108-.092l.996-.064c.048-.004.077.031.065.078l-1.09 4.104a.113.113 0 0 1-.109.082l-1.121-.031a.12.12 0 0 1-.109-.086l-.535-1.965c-.012-.047-.033-.047-.045 0l-.522 1.934a.12.12 0 0 1-.11.082l-1.109-.031a.123.123 0 0 1-.108-.088l-.873-3.618c-.011-.047.019-.088.066-.09zm-.288 9.623v-3.561a.089.089 0 0 0-.087-.088l-1.252-.029a.095.095 0 0 1-.091-.09l-.046-1.125a.082.082 0 0 1 .083-.086l4.047.096c.048 0 .087.041.085.088l-.022 1.088a.093.093 0 0 1-.089.088l-1.139.004a.09.09 0 0 0-.087.088v3.447c0 .049-.039.09-.087.092l-1.227.07a.08.08 0 0 1-.088-.082zm2.834-2.379c0-1.918 1.321-2.482 2.416-2.482s2.339.73 2.339 2.316c0 1.9-1.383 2.482-2.416 2.482-1.033.001-2.339-.724-2.339-2.316zm5.139-.115c0-1.746 1.166-2.238 2.162-2.238s2.129.664 2.129 2.107c0 1.729-1.259 2.26-2.198 2.26s-2.093-.68-2.093-2.129zm7.259 1.711a.175.175 0 0 1-.139-.064l-1.187-1.631c-.029-.039-.053-.031-.053.018v1.67c0 .047-.039.09-.086.092l-1.052.061a.082.082 0 0 1-.087-.082l.039-3.842c0-.047.039-.086.088-.084l.881.02a.2.2 0 0 1 .137.074l1.293 1.902c.027.041.051.033.051-.014l.032-1.846a.087.087 0 0 1 .089-.086l.963.029c.047 0 .085.041.083.09l-.138 3.555a.097.097 0 0 1-.091.092l-.823.046zM16.258 8.23l.724-.014s.47.018.47-.434c0-.357-.411-.33-.411-.33l-.782.008a.09.09 0 0 0-.088.088v.598a.083.083 0 0 0 .087.084zM16.229 10.191h.99c.024 0 .35-.051.35-.404 0-.293-.229-.402-.441-.398l-.898.029a.089.089 0 0 0-.087.09v.596a.086.086 0 0 0 .086.087z" />
										                </svg>
										            </span></a></li>
										    <?php }if (!empty($instance['discord_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['discord_url']) ?>' title="Discord"><span
										                class="fab fa-md fa-discord"></span></a></li>
										    <?php }if (!empty($instance['instagram_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['instagram_url']) ?>'
										            title="Instagram"><span class="fab fa-md fa-instagram"></span></a></li>
										    <?php }if (!empty($instance['twitter_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['twitter_url']) ?>' title="Twitter"><span class="fab fa-md fa-x-twitter"></span></a></li>
				                                    <?php }if (!empty($instance['bluesky_url'])) {?>
																<li class="line"><a target="_blank" href='<?php echo esc_attr($instance['bluesky_url']) ?>' title="Blueksy"><span class="fab fa-md fa-bluesky"></span></a></li>
								             <?php }if (!empty($instance['mastodon_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['mastodon_url']) ?>' title="Mastodon"><span
										                class="fab fa-md fa-mastodon"></span></a></li>
				                                        <?php }if (!empty($instance['tiktok_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['tiktok_url']) ?>' title="Tiktok"><span
										                class="fab fa-md fa-tiktok"></span></a></li>
										    <?php }if (!empty($instance['facebook_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['facebook_url']) ?>' title="Facebook"><span
										                class="fab fa-md fa-facebook-f"></span></a></li>
										    <?php }if (!empty($instance['deviantart_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['deviantart_url']) ?>'
										            title="DeviantArt"><span class="fab fa-md fa-deviantart"></span></a></li>
										    <?php }if (!empty($instance['email_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['email_url']) ?>' title="Email"><span
										                class="fas fa-md fa-envelope"></span></a></li>
										    <?php }if (!empty($instance['reddit_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['reddit_url']) ?>' title="Reddit"><span
										                class="fab fa-md fa-reddit-alien"></span></a></li>
										    <?php }if (!empty($instance['linkedin_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['linkedin_url']) ?>' title="LinkedIn"><span
										                class="fab fa-md fa-linkedin-in"></span></a></li>
										    <?php }if (!empty($instance['tumblr_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['tumblr_url']) ?>' title="Tumblr"><span
										                class="fab fa-md fa-tumblr"></span></a></li>
										    <?php }if (!empty($instance['kofi_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['kofi_url']) ?>' title="Ko-fi"><span
										                class="fab fa-md">
										                <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
										                    <title>Ko-fi icon</title>
										                    <path
										                        d="M23.881 8.948c-.773-4.085-4.859-4.593-4.859-4.593H.723c-.604 0-.679.798-.679.798s-.082 7.324-.022 11.822c.164 2.424 2.586 2.672 2.586 2.672s8.267-.023 11.966-.049c2.438-.426 2.683-2.566 2.658-3.734 4.352.24 7.422-2.831 6.649-6.916zm-11.062 3.511c-1.246 1.453-4.011 3.976-4.011 3.976s-.121.119-.31.023c-.076-.057-.108-.09-.108-.09-.443-.441-3.368-3.049-4.034-3.954-.709-.965-1.041-2.7-.091-3.71.951-1.01 3.005-1.086 4.363.407 0 0 1.565-1.782 3.468-.963 1.904.82 1.832 3.011.723 4.311zm6.173.478c-.928.116-1.682.028-1.682.028V7.284h1.77s1.971.551 1.971 2.638c0 1.913-.985 2.667-2.059 3.015z">
										                    </path>
										                </svg>
										            </span></a></li>
										    <?php }if (!empty($instance['vimeo_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['vimeo_url']) ?>' title="Vimeo"><span
										                class="fab fa-md fa-vimeo-v"></span></a></li>
										    <?php }if (!empty($instance['youtube_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['youtube_url']) ?>' title="Youtube"><span
										                class="fab fa-md fa-youtube"></span></a></li>
										    <?php }if (!empty($instance['twitch_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['twitch_url']) ?>' title="Twitch"><span
										                class="fab fa-md fa-twitch"></span></a></li>
										    <?php }if (!empty($instance['rss_url'])) {?>
										    <li class="line"><a target="_blank" href='<?php echo esc_attr($instance['rss_url']) ?>' title="RSS"><span
										                class="fas fa-md fa-rss"></span></a></li>
										    <?php }?>
										</ul>







										<?php

            echo wp_kses($args['after_widget'], $allowed_tags);
        }

        public function update($new_instance, $old_instance)
    {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
            $instance['patreon_url'] = (!empty($new_instance['patreon_url'])) ? esc_url_raw($new_instance['patreon_url']) : '';
            $instance['kickstarter_url'] = (!empty($new_instance['kickstarter_url'])) ? esc_url_raw($new_instance['kickstarter_url']) : '';
            $instance['webtoon_url'] = (!empty($new_instance['webtoon_url'])) ? esc_url_raw($new_instance['webtoon_url']) : '';
            $instance['discord_url'] = (!empty($new_instance['discord_url'])) ? esc_url_raw($new_instance['discord_url']) : '';
            $instance['instagram_url'] = (!empty($new_instance['instagram_url'])) ? esc_url_raw($new_instance['instagram_url']) : '';
            $instance['twitter_url'] = (!empty($new_instance['twitter_url'])) ? esc_url_raw($new_instance['twitter_url']) : '';
            $instance['mastodon_url'] = (!empty($new_instance['mastodon_url'])) ? esc_url_raw($new_instance['mastodon_url']) : '';
            $instance['bluesky_url'] = (!empty($new_instance['bluesky_url'])) ? esc_url_raw($new_instance['bluesky_url']) : '';
            $instance['tiktok_url'] = (!empty($new_instance['tiktok_url'])) ? esc_url_raw($new_instance['tiktok_url']) : '';
            $instance['facebook_url'] = (!empty($new_instance['facebook_url'])) ? esc_url_raw($new_instance['facebook_url']) : '';
            $instance['deviantart_url'] = (!empty($new_instance['deviantart_url'])) ? esc_url_raw($new_instance['deviantart_url']) : '';
            $instance['email_url'] = (!empty($new_instance['email_url'])) ? esc_url_raw($new_instance['email_url']) : '';
            $instance['reddit_url'] = (!empty($new_instance['reddit_url'])) ? esc_url_raw($new_instance['reddit_url']) : '';
            $instance['linkedin_url'] = (!empty($new_instance['linkedin_url'])) ? esc_url_raw($new_instance['linkedin_url']) : '';
            $instance['tumblr_url'] = (!empty($new_instance['tumblr_url'])) ? esc_url_raw($new_instance['tumblr_url']) : '';
            $instance['kofi_url'] = (!empty($new_instance['kofi_url'])) ? esc_url_raw($new_instance['kofi_url']) : '';
            $instance['vimeo_url'] = (!empty($new_instance['vimeo_url'])) ? esc_url_raw($new_instance['vimeo_url']) : '';
            $instance['youtube_url'] = (!empty($new_instance['youtube_url'])) ? esc_url_raw($new_instance['youtube_url']) : '';
            $instance['twitch_url'] = (!empty($new_instance['twitch_url'])) ? esc_url_raw($new_instance['twitch_url']) : '';
            $instance['rss_url'] = (!empty($new_instance['rss_url'])) ? esc_url_raw($new_instance['rss_url']) : '';
            return $instance;
        }

        public function form($instance)
    {

            $title = '';
            if (!empty($instance['title'])) {
                $title = $instance['title'];
            }

            $patreon_url = '';
            if (!empty($instance['patreon_url'])) {
                $patreon_url = $instance['patreon_url'];
            }
            $kickstarter_url = '';
            if (!empty($instance['kickstarter_url'])) {
                $kickstarter_url = $instance['kickstarter_url'];
            }

            $webtoon_url = '';
            if (!empty($instance['webtoon_url'])) {
                $webtoon_url = $instance['webtoon_url'];
            }

            $discord_url = '';
            if (!empty($instance['discord_url'])) {
                $discord_url = $instance['discord_url'];
            }

            $instagram_url = '';
            if (!empty($instance['instagram_url'])) {
                $instagram_url = $instance['instagram_url'];
            }
            $twitter_url = '';
            if (!empty($instance['twitter_url'])) {
                $twitter_url = $instance['twitter_url'];
            }
            $mastodon_url = '';
            if (!empty($instance['mastodon_url'])) {
                $mastodon_url = $instance['mastodon_url'];
            }
            $tiktok_url = '';
            if (!empty($instance['tiktok_url'])) {
                $tiktok_url = $instance['tiktok_url'];
            }
            $bluesky_url = '';
            if (!empty($instance['bluesky_url'])) {
                $bluesky_url = $instance['bluesky_url'];
            }
            $facebook_url = '';
            if (!empty($instance['facebook_url'])) {
                $facebook_url = $instance['facebook_url'];
            }

            $deviantart_url = '';
            if (!empty($instance['deviantart_url'])) {
                $deviantart_url = $instance['deviantart_url'];
            }

            $email_url = '';
            if (!empty($instance['email_url'])) {
                $email_url = $instance['email_url'];
            }

            $reddit_url = '';
            if (!empty($instance['reddit_url'])) {
                $reddit_url = $instance['reddit_url'];
            }

            $linkedin_url = '';
            if (!empty($instance['linkedin_url'])) {
                $linkedin_url = $instance['linkedin_url'];
            }

            $tumblr_url = '';
            if (!empty($instance['tumblr_url'])) {
                $tumblr_url = $instance['tumblr_url'];
            }

            $kofi_url = '';
            if (!empty($instance['kofi_url'])) {
                $kofi_url = $instance['kofi_url'];
            }

            $vimeo_url = '';
            if (!empty($instance['vimeo_url'])) {
                $vimeo_url = $instance['vimeo_url'];
            }

            $youtube_url = '';
            if (!empty($instance['youtube_url'])) {
                $youtube_url = $instance['youtube_url'];
            }
            $twitch_url = '';
            if (!empty($instance['twitch_url'])) {
                $twitch_url = $instance['twitch_url'];
            }

            $rss_url = '';
            if (!empty($instance['rss_url'])) {
                $rss_url = $instance['rss_url'];
            }
            ?>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('title')); ?>"><?php esc_html_e('Title:', 'toocheke');?></label>
										    <input class="widefat" placeholder="Social Widget Title" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
										        value="<?php echo esc_attr($title); ?>" />
										</p>

										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('patreon_url')); ?>"><?php esc_html_e('Patreon URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('patreon_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('patreon_url')); ?>" type="text"
										        value="<?php echo esc_attr($patreon_url); ?>" />
										</p>
								        <p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('kickstarter_url')); ?>"><?php esc_html_e('Kickstarter URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('kickstarter_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('kickstarter_url')); ?>" type="text"
										        value="<?php echo esc_attr($kickstarter_url); ?>" />
										</p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('webtoon_url')); ?>"><?php esc_html_e('LINE Webtoon URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('webtoon_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('webtoon_url')); ?>" type="text"
										        value="<?php echo esc_attr($webtoon_url); ?>" />
										</p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('discord_url')); ?>"><?php esc_html_e('Discord URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('discord_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('discord_url')); ?>" type="text"
										        value="<?php echo esc_attr($discord_url); ?>" />
										</p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('instagram_url')); ?>"><?php esc_html_e('Intagram URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('instagram_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('instagram_url')); ?>" type="text"
										        value="<?php echo esc_attr($instagram_url); ?>" />
										</p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('twitter_url')); ?>"><?php esc_html_e('Twitter URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('twitter_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('twitter_url')); ?>" type="text"
										        value="<?php echo esc_attr($twitter_url); ?>" />
										</p>
								        <p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('mastodon_url')); ?>"><?php esc_html_e('Mastodon URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('mastodon_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('mastodon_url')); ?>" type="text"
										        value="<?php echo esc_attr($mastodon_url); ?>" />
										</p>
			                            <p>
						                                                <label
						                                                    for="<?php echo esc_attr($this->get_field_name('tiktok_url')); ?>"><?php esc_html_e('Tiktok URL:', 'toocheke');?></label>
						                                                <input class="widefat" placeholder="https://www.example.com"
						                                                    id="<?php echo esc_attr($this->get_field_id('tiktok_url')); ?>"
						                                                    name="<?php echo esc_attr($this->get_field_name('tiktok_url')); ?>" type="text"
						                                                    value="<?php echo esc_attr($tiktok_url); ?>" />
						                                            </p>
			                                                        <p>
						                                                <label
						                                                    for="<?php echo esc_attr($this->get_field_name('bluesky_url')); ?>"><?php esc_html_e('Bluesky URL:', 'toocheke');?></label>
						                                                <input class="widefat" placeholder="https://www.example.com"
						                                                    id="<?php echo esc_attr($this->get_field_id('bluesky_url')); ?>"
						                                                    name="<?php echo esc_attr($this->get_field_name('bluesky_url')); ?>" type="text"
						                                                    value="<?php echo esc_attr($bluesky_url); ?>" />
						                                            </p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('facebook_url')); ?>"><?php esc_html_e('Facebook URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('facebook_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('facebook_url')); ?>" type="text"
										        value="<?php echo esc_attr($facebook_url); ?>" />
										</p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('deviantart_url')); ?>"><?php esc_html_e('DeviantArt URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('deviantart_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('deviantart_url')); ?>" type="text"
										        value="<?php echo esc_attr($deviantart_url); ?>" />
										</p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('email_url')); ?>"><?php esc_html_e('Email URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('email_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('email_url')); ?>" type="text"
										        value="<?php echo esc_attr($email_url); ?>" />
										</p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('reddit_url')); ?>"><?php esc_html_e('Reddit URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('reddit_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('reddit_url')); ?>" type="text"
										        value="<?php echo esc_attr($reddit_url); ?>" />
										</p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('linkedin_url')); ?>"><?php esc_html_e('LinkedIn URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('linkedin_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('linkedin_url')); ?>" type="text"
										        value="<?php echo esc_attr($linkedin_url); ?>" />
										</p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('tumblr_url')); ?>"><?php esc_html_e('Tumblr URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('tumblr_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('tumblr_url')); ?>" type="text"
										        value="<?php echo esc_attr($tumblr_url); ?>" />
										</p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('kofi_url')); ?>"><?php esc_html_e('Ko-fi URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('kofi_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('kofi_url')); ?>" type="text"
										        value="<?php echo esc_attr($kofi_url); ?>" />
										</p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('vimeo_url')); ?>"><?php esc_html_e('Vimeo URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('vimeo_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('vimeo_url')); ?>" type="text"
										        value="<?php echo esc_attr($vimeo_url); ?>" />
										</p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('youtube_url')); ?>"><?php esc_html_e('Youtube URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('youtube_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('youtube_url')); ?>" type="text"
										        value="<?php echo esc_attr($youtube_url); ?>" />
										</p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('twitch_url')); ?>"><?php esc_html_e('Twitch URL:', 'toocheke');?></label>
										    <input class="widefat" placeholder="https://www.example.com"
										        id="<?php echo esc_attr($this->get_field_id('twitch_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('twitch_url')); ?>" type="text"
										        value="<?php echo esc_attr($twitch_url); ?>" />
										</p>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('rss_url')); ?>"><?php esc_html_e('Comics RSS URL(e.g. https://www.yourdomain.com/comic/feed):', 'toocheke');?></label>
										    <input class="widefat" placeholder="<?php echo esc_url(home_url()) . "/comic/feed" ?>"
										        id="<?php echo esc_attr($this->get_field_id('rss_url')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('rss_url')); ?>" type="text"
										        value="<?php echo esc_attr($rss_url); ?>" />
										</p>




										<?php
    }
    }
endif;
//Social Media Widget ends here
//Calendar Widget
if (!function_exists('toocheke_load_calendar')):
    function toocheke_load_calendar()
{
        register_widget('toocheke_calendar');
    }
endif;
add_action('widgets_init', 'toocheke_load_calendar');
if (!class_exists('toocheke_calendar')):
    class toocheke_calendar extends WP_Widget
{
        /**
         * Ensure that the ID attribute only appears in the markup once
         *
         * @since 4.4.0
         *
         * @static
         * @access private
         * @var int
         */
        private static $instance = 0;

        public function __construct()
    {
            $widget_ops = array('classname' => 'widget_calendar', 'description' => __('A calendar of your comics. Ideally for the right sidebar on the Toocheke WP theme.', 'toocheke'));
            parent::__construct('toocheke-calendar', __('Toocheke Calendar', 'toocheke'), $widget_ops);
        }

        public function widget($args, $instance)
    {
            $title = apply_filters('widget_title', empty($instance['title']) ? __('Calendar', 'toocheke') : $instance['title'], $instance, $this->id_base);
            $posttype = 'comic';

            add_filter('get_calendar', array($this, 'toocheke_get_comic_calendar'), 10, 3);
            add_filter('month_link', array($this, 'toocheke_get_month_link'), 10, 3);
            add_filter('day_link', array($this, 'toocheke_get_day_link'), 10, 4);

            $allowed_tags = array(
                'section' => array(
                    'id' => array(),
                    'class' => array(),
                ),
                'h4' => array(
                    'class' => array(),
                ),
            );
            echo wp_kses($args['before_widget'], $allowed_tags);
            if ($title) {
                echo wp_kses($args['before_title'], $allowed_tags) . wp_kses($title, $allowed_tags) . wp_kses($args['after_title'], $allowed_tags);
            }
            if (0 === self::$instance) {
                echo '<div id="calendar_wrap" class="calendar_wrap">';
            } else {
                echo '<div class="calendar_wrap">';
            }
            get_calendar();
            echo '</div>';
            echo wp_kses($args['after_widget'], $allowed_tags);

            remove_filter('get_calendar', array($this, 'toocheke_get_comic_calendar'));
            remove_filter('month_link', array($this, 'toocheke_get_month_link'));
            remove_filter('day_link', array($this, 'toocheke_get_day_link'));

            self::$instance++;
        }

        public function update($new_instance, $old_instance)
    {
            $instance = $old_instance;
            $instance['title'] = sanitize_text_field($new_instance['title']);
            return $instance;
        }

        public function form($instance)
    {
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = isset($instance['title']) ? sanitize_text_field($instance['title']) : '';
            $posttype = 'comic';
            ?>
										<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html('Title:', 'toocheke');?></label>
										    <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
										        value="<?php echo esc_attr($title); ?>" />
										</p>

										<?php

        }

        /**
         * function that extend the get_calendar
         * @see wp-includes/general-template.php
         *
         * @since 1.0.0
         *
         * @param string $calendar_output
         * @param boolean $initial
         * @param boolean $echo
         */
        public function toocheke_get_comic_calendar($calendar_output, $initial = true, $echo = true)
    {
            global $wpdb, $m, $monthnum, $year, $wp_locale, $posts;

            $options = get_option($this->option_name);
            $posttype = 'comic';

            // Quick check. If we have no posts at all, abort!
            if (!$posts) {
                // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                $gotsome = $wpdb->get_var("SELECT 1 as test FROM $wpdb->posts WHERE post_type = '$posttype' AND post_status = 'publish' LIMIT 1");
            }

            if (isset($_GET['w'])) {
                $w = (int) $_GET['w'];
            }

            // week_begins = 0 stands for Sunday
            $week_begins = (int) get_option('start_of_week');
            $ts = current_time('timestamp');

            // Let's figure out when we are
            if (!empty($monthnum) && !empty($year)) {
                $thismonth = zeroise(intval($monthnum), 2);
                $thisyear = (int) $year;
            } elseif (!empty($w)) {
            // We need to get the month from MySQL
            $thisyear = (int) substr($m, 0, 4);
            // it seems MySQL's weeks disagree with PHP's
            $d = (($w - 1) * 7) + 6;
            // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $thismonth = $wpdb->get_var("SELECT DATE_FORMAT((DATE_ADD('{$thisyear}0101', INTERVAL $d DAY) ), '%m')");
        } elseif (!empty($m)) {
            $thisyear = (int) substr($m, 0, 4);
            if (strlen($m) < 6) {
                $thismonth = '01';
            } else {
                $thismonth = zeroise((int) substr($m, 4, 2), 2);
            }
        } else {
            $thisyear = gmdate('Y', $ts);
            $thismonth = gmdate('m', $ts);
        }

        $unixmonth = mktime(0, 0, 0, $thismonth, 1, $thisyear);
        $last_day = date('t', $unixmonth);

        // Get the next and previous month and year with at least one post
        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $previous = $wpdb->get_row("SELECT MONTH(post_date) AS month, YEAR(post_date) AS year FROM $wpdb->posts WHERE post_date < '$thisyear-$thismonth-01' AND post_type = '$posttype' AND post_status = 'publish' ORDER BY post_date DESC LIMIT 1");
        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $next = $wpdb->get_row("SELECT MONTH(post_date) AS month, YEAR(post_date) AS year FROM $wpdb->posts WHERE post_date > '$thisyear-$thismonth-{$last_day} 23:59:59' AND post_type = '$posttype' AND post_status = 'publish' ORDER BY post_date ASC LIMIT 1");

        /* translators: Calendar caption: 1: month name, 2: 4-digit year */
        $calendar_caption = _x('%1$s %2$s', 'calendar caption', 'toocheke');
        $calendar_output = '<table id="wp-calendar">
		<caption>' . sprintf(
            $calendar_caption,
            $wp_locale->get_month($thismonth),
            date('Y', $unixmonth)
        ) . '</caption>
		<thead>
		<tr>';

        $myweek = array();

        for ($wdcount = 0; $wdcount <= 6; $wdcount++) {
            $myweek[] = $wp_locale->get_weekday(($wdcount + $week_begins) % 7);
        }

        foreach ($myweek as $wd) {
            $day_name = $initial ? $wp_locale->get_weekday_initial($wd) : $wp_locale->get_weekday_abbrev($wd);
            $wd = esc_attr($wd);
            $calendar_output .= "\n\t\t<th scope=\"col\" title=\"$wd\">$day_name</th>";
        }

        $calendar_output .= '
		</tr>
		</thead>

		<tfoot>
		<tr>';

        if ($previous) {
            $calendar_output .= "\n\t\t" . '<td colspan="3" id="prev"><a href="' . get_month_link($previous->year, $previous->month) . '">&laquo; ' .
            $wp_locale->get_month_abbrev($wp_locale->get_month($previous->month)) .
                '</a></td>';
        } else {
            $calendar_output .= "\n\t\t" . '<td colspan="3" id="prev" class="pad">&nbsp;</td>';
        }

        $calendar_output .= "\n\t\t" . '<td class="pad">&nbsp;</td>';

        if ($next) {
            $calendar_output .= "\n\t\t" . '<td colspan="3" id="next"><a href="' . get_month_link($next->year, $next->month) . '">' .
            $wp_locale->get_month_abbrev($wp_locale->get_month($next->month)) .
                ' &raquo;</a></td>';
        } else {
            $calendar_output .= "\n\t\t" . '<td colspan="3" id="next" class="pad">&nbsp;</td>';
        }

        $calendar_output .= '
		</tr>
		</tfoot>

		<tbody>
		<tr>';

        $daywithpost = array();

        // Get days with posts
        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $dayswithposts = $wpdb->get_results("SELECT DISTINCT DAYOFMONTH(post_date) FROM $wpdb->posts WHERE post_date >= '{$thisyear}-{$thismonth}-01 00:00:00' AND post_type = '$posttype' AND post_status = 'publish' AND post_date <= '{$thisyear}-{$thismonth}-{$last_day} 23:59:59'", ARRAY_N);
        if ($dayswithposts) {
            foreach ((array) $dayswithposts as $daywith) {
                $daywithpost[] = $daywith[0];
            }
        }

        // See how much we should pad in the beginning
        $pad = calendar_week_mod(date('w', $unixmonth) - $week_begins);
        if (0 != $pad) {
            $calendar_output .= "\n\t\t" . '<td colspan="' . esc_attr($pad) . '" class="pad">&nbsp;</td>';
        }

        $newrow = false;
        $daysinmonth = (int) date('t', $unixmonth);

        for ($day = 1; $day <= $daysinmonth; ++$day) {
            if (isset($newrow) && $newrow) {
                $calendar_output .= "\n\t</tr>\n\t<tr>\n\t\t";
            }
            $newrow = false;

            if ($day == gmdate('j', current_time('timestamp')) &&
                $thismonth == gmdate('m', current_time('timestamp')) &&
                $thisyear == gmdate('Y', current_time('timestamp'))) {
                $calendar_output .= '<td id="today">';
            } else {
                $calendar_output .= '<td>';
            }

            if (in_array($day, $daywithpost)) {
                // any posts today?
                // phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
                $date_format = date(_x('F j, Y', 'daily archives date format', 'toocheke'), strtotime("{$thisyear}-{$thismonth}-{$day}"));
                // phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
                $label = sprintf(__('Posts published on %s', 'toocheke'), $date_format);
                $calendar_output .= sprintf(
                    '<a href="%s" aria-label="%s">%s</a>',
                    get_day_link($thisyear, $thismonth, $day),
                    // $this->get_comic_day_link( $posttype, $thisyear, $thismonth, $day ),
                    esc_attr($label),
                    $day
                );
            } else {
                $calendar_output .= $day;
            }
            $calendar_output .= '</td>';

            if (6 == calendar_week_mod(date('w', mktime(0, 0, 0, $thismonth, $day, $thisyear)) - $week_begins)) {
                $newrow = true;
            }
        }

        $pad = 7 - calendar_week_mod(date('w', mktime(0, 0, 0, $thismonth, $day, $thisyear)) - $week_begins);
        if (0 != $pad && 7 != $pad) {
            $calendar_output .= "\n\t\t" . '<td class="pad" colspan="' . esc_attr($pad) . '">&nbsp;</td>';
        }

        $calendar_output .= "\n\t</tr>\n\t</tbody>\n\t</table>";

        if ($echo) {
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            echo $calendar_output;
        } else {
            return $calendar_output;
        }
    }

    public function toocheke_get_day_link($daylink, $year, $month, $day)
    {
        global $wp_rewrite;

        $options = get_option($this->option_name);
        $posttype = 'comic';

        if (!$year) {
            $year = gmdate('Y', current_time('timestamp'));
        }
        if (!$month) {
            $month = gmdate('m', current_time('timestamp'));
        }
        if (!$day) {
            $day = gmdate('j', current_time('timestamp'));
        }

        $daylink = $wp_rewrite->get_day_permastruct();

        if (!empty($daylink)) {
            $front = preg_replace('/\/$/', '', $wp_rewrite->front);

            $daylink = str_replace('%year%', $year, $daylink);
            $daylink = str_replace('%monthnum%', zeroise(intval($month), 2), $daylink);
            $daylink = str_replace('%day%', zeroise(intval($day), 2), $daylink);

            if ('post' == $posttype) {
                $daylink = home_url(user_trailingslashit($daylink, 'day'));
            } else {
                $type_obj = get_post_type_object($posttype);
                $archive_name = 'comic';
                if ($front) {
                    $new_front = $type_obj->rewrite['with_front'] ? $front : '';
                    $daylink = str_replace($front, $new_front . '/' . $archive_name, $daylink);
                    $daylink = home_url(user_trailingslashit($daylink, 'day'));
                } else {
                    $daylink = home_url(user_trailingslashit($archive_name . $daylink, 'day'));
                }
            }
        } else {
            $daylink = home_url('?post_type=' . $posttype . '&m=' . $year . zeroise($month, 2) . zeroise($day, 2));
        }

        return $daylink;
    }

    public function toocheke_get_month_link($monthlink, $year, $month)
    {
        global $wp_rewrite;

        $options = get_option($this->option_name);
        $posttype = 'comic';

        if (!$year) {
            $year = gmdate('Y', current_time('timestamp'));
        }
        if (!$month) {
            $month = gmdate('m', current_time('timestamp'));
        }

        $monthlink = $wp_rewrite->get_month_permastruct();

        if (!empty($monthlink)) {
            $front = preg_replace('/\/$/', '', $wp_rewrite->front);

            $monthlink = str_replace('%year%', $year, $monthlink);
            $monthlink = str_replace('%monthnum%', zeroise(intval($month), 2), $monthlink);

            if ('post' == $posttype) {
                $monthlink = home_url(user_trailingslashit($monthlink, 'month'));
            } else {
                $type_obj = get_post_type_object($posttype);
                $archive_name = !empty($type_obj->rewrite['slug']) ? $type_obj->rewrite['slug'] : $posttype;
                if ($front) {
                    $new_front = $type_obj->rewrite['with_front'] ? $front : '';
                    $monthlink = str_replace($front, $new_front . '/' . $archive_name, $monthlink);
                    $monthlink = home_url(user_trailingslashit($monthlink, 'month'));
                } else {
                    $monthlink = home_url(user_trailingslashit($archive_name . $monthlink, 'month'));
                }
            }
        } else {
            $monthlink = home_url('?post_type=' . $posttype . '&m=' . $year . zeroise($month, 2));
        }

        return $monthlink;
    }

}
endif;
//Calendar Widget ends here
/*
 * Top Ten Comics Widget
 */
if (!function_exists('toocheke_load_top_10_comics_widget')):
    function toocheke_load_top_10_comics_widget()
{
        register_widget('toocheke_top_10_comics_widget');
    }
endif;
add_action('widgets_init', 'toocheke_load_top_10_comics_widget');

if (!class_exists('toocheke_top_10_comics_widget')):
    class toocheke_top_10_comics_widget extends WP_Widget
{

        public function __construct()
    {
            $widget_details = array(
                'classname' => 'toocheke_top_10_comics_widget',
                'description' => esc_html__('Creates a top 10 comics section consisting of a title, and a list of the 10 comics. Ideal for the right sidebar on the Toocheke WP theme.', 'toocheke'),
            );

            parent::__construct('toocheke_top_10_comics_widget', 'Toocheke: Top 10 Comics', $widget_details);

        }

        public function widget($args, $instance)
    {
            $series_id = null;
            $series_id = isset($_GET['sid']) ? (int) $_GET['sid'] : null;
            if (is_singular('series')) {
                $series_id = get_the_ID();
            }
            $allowed_tags = array(
                'section' => array(
                    'id' => array(),
                    'class' => array(),
                ),
                'h4' => array(
                    'class' => array(),
                ),
            );
            echo wp_kses($args['before_widget'], $allowed_tags);
            if (!empty($instance['title'])) {
                $title = !empty($instance['title']) ? $instance['title'] : '';
                $title = apply_filters('widget_title', $title, $instance, $this->id_base);
                echo wp_kses($args['before_title'], $allowed_tags) . wp_kses($title, $allowed_tags) . wp_kses($args['after_title'], $allowed_tags);
            }

            $comic_args = array(
                'post_parent' => $series_id,
                'post_type' => 'comic',
                'post_status' => 'publish',
                'posts_per_page' => 10,
                'meta_key' => 'post_views_count',
                'meta_query' => array(
                    array(
                        'key' => 'post_views_count',
                        'value' => 0,
                        'compare' => '>',
                    ),
                ),
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
            );
            $popular_comics = new WP_Query($comic_args);
            ?>
										<?php if ($popular_comics->have_posts()): ?>

										<ul id="comic-list">
										<?php

/* Start the Loop */
            $rank = 1;
            while ($popular_comics->have_posts()): $popular_comics->the_post();
                set_query_var('latest_collection_id', 0);
                //if not on series page, grab series id from post(if it has one)
                if (!$series_id) {
                    $parent_id = !empty(get_post_meta(get_the_ID(), 'post_parent', true)) ? (int) get_post_meta(get_the_ID(), 'post_parent', true) : null;
                    set_query_var('series_id', $parent_id);
                } else {
                    set_query_var('series_id', $series_id);
                }
                set_query_var('rank', $rank);
                get_template_part('template-parts/content', 'comiclistitem');
                $rank++;
            endwhile;
// Reset Post Data
            wp_reset_postdata();
            ?>
										</ul>

										<?php

        endif;
        ?>



<?php

        echo wp_kses($args['after_widget'], $allowed_tags);
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }

    public function form($instance)
    {

        $title = '';
        if (!empty($instance['title'])) {
            $title = $instance['title'];
        }

        ?>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_name('title')); ?>"><?php esc_html_e('Title:', 'toocheke');?></label>
    <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
        name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
        value="<?php echo esc_attr($title); ?>" />
</p>


<?php
}
}
endif;
//Top Ten Comics Widget ends here
/*
 * Scheduled Comics Widget
 */
if (!function_exists('toocheke_load_scheduled_comics_widget')):
    function toocheke_load_scheduled_comics_widget()
{
        register_widget('toocheke_scheduled_comics_widget');
    }
endif;
add_action('widgets_init', 'toocheke_load_scheduled_comics_widget');

if (!class_exists('toocheke_scheduled_comics_widget')):
    class toocheke_scheduled_comics_widget extends WP_Widget
{

        public function __construct()
    {
            $widget_details = array(
                'classname' => 'toocheke_scheduled_comics_widget',
                'description' => esc_html__('Creates a scheduled comics section consisting of a title, and a list of at most 10 upcoming comics. Ideal for the right sidebar on the Toocheke WP theme.', 'toocheke'),
            );

            parent::__construct('toocheke_scheduled_comics_widget', 'Toocheke: Scheduled Comics', $widget_details);

        }

        public function widget($args, $instance)
    {
            $series_id = null;
            $series_id = isset($_GET['sid']) ? (int) $_GET['sid'] : null;
            if (is_singular('series')) {
                $series_id = get_the_ID();
            }
            $allowed_tags = array(
                'section' => array(
                    'id' => array(),
                    'class' => array(),
                ),
                'h4' => array(
                    'class' => array(),
                ),
            );
            echo wp_kses($args['before_widget'], $allowed_tags);
            if (!empty($instance['title'])) {
                $title = !empty($instance['title']) ? $instance['title'] : '';
                $title = apply_filters('widget_title', $title, $instance, $this->id_base);
                echo wp_kses($args['before_title'], $allowed_tags) . wp_kses($title, $allowed_tags) . wp_kses($args['after_title'], $allowed_tags);
            }

            $comic_args = array(
                'post_parent' => $series_id,
                'post_type' => 'comic',
                'post_status' => 'future',
                'posts_per_page' => 10,
                'orderby' => 'post_date',
                'order' => 'ASC',
            );
            $scheduled_comics = new WP_Query($comic_args);
            ?>
										<?php if ($scheduled_comics->have_posts()): ?>

										<ul id="comic-list">
										<?php

/* Start the Loop */
            $rank = 0;
            while ($scheduled_comics->have_posts()): $scheduled_comics->the_post();
                set_query_var('latest_collection_id', 0);
                //if not on series page, grab series id from post(if it has one)
                if (!$series_id) {
                    $parent_id = !empty(get_post_meta(get_the_ID(), 'post_parent', true)) ? (int) get_post_meta(get_the_ID(), 'post_parent', true) : null;
                    set_query_var('series_id', $parent_id);
                } else {
                    set_query_var('series_id', $series_id);
                }
                set_query_var('rank', $rank);
                get_template_part('template-parts/content', 'comiclistitem');

            endwhile;
// Reset Post Data
            wp_reset_postdata();
            ?>
										</ul>

										<?php

        endif;
        ?>



<?php

        echo wp_kses($args['after_widget'], $allowed_tags);
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }

    public function form($instance)
    {

        $title = '';
        if (!empty($instance['title'])) {
            $title = $instance['title'];
        }

        ?>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_name('title')); ?>"><?php esc_html_e('Title:', 'toocheke');?></label>
    <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
        name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
        value="<?php echo esc_attr($title); ?>" />
</p>


<?php
}
}
endif;
//Scheduled Comics Widget ends here
/*
 * Latest Comics Widget
 */
if (!function_exists('toocheke_load_latest_10_comics_widget')):
    function toocheke_load_latest_10_comics_widget()
{
        register_widget('toocheke_latest_10_comics_widget');
    }
endif;
add_action('widgets_init', 'toocheke_load_latest_10_comics_widget');

if (!class_exists('toocheke_latest_10_comics_widget')):
    class toocheke_latest_10_comics_widget extends WP_Widget
{

        public function __construct()
    {
            $widget_details = array(
                'classname' => 'toocheke_latest_10_comics_widget',
                'description' => esc_html__('Creates a latest comics section consisting of a title, and a list of the latest 10 comics. Ideal for the right sidebar on the Toocheke WP theme.', 'toocheke'),
            );

            parent::__construct('toocheke_latest_10_comics_widget', 'Toocheke: Latest Comics', $widget_details);

        }

        public function widget($args, $instance)
    {
            $series_id = null;
            $series_id = isset($_GET['sid']) ? (int) $_GET['sid'] : null;
            if (is_singular('series')) {
                $series_id = get_the_ID();
            }
            $allowed_tags = array(
                'section' => array(
                    'id' => array(),
                    'class' => array(),
                ),
                'h4' => array(
                    'class' => array(),
                ),
            );
            echo wp_kses($args['before_widget'], $allowed_tags);
            if (!empty($instance['title'])) {
                $title = !empty($instance['title']) ? $instance['title'] : '';
                $title = apply_filters('widget_title', $title, $instance, $this->id_base);
                echo wp_kses($args['before_title'], $allowed_tags) . wp_kses($title, $allowed_tags) . wp_kses($args['after_title'], $allowed_tags);
            }

            $comic_args = array(
                'post_parent' => $series_id,
                'post_type' => 'comic',
                'post_status' => 'publish',
                'posts_per_page' => 10,
                'meta_key' => 'post_views_count',
                'orderby' => 'post_date',
                'order' => 'DESC',
            );
            $popular_comics = new WP_Query($comic_args);
            ?>
										<?php if ($popular_comics->have_posts()): ?>

										<ul id="comic-list">
										<?php

/* Start the Loop */
            $rank = 1;
            while ($popular_comics->have_posts()): $popular_comics->the_post();
                set_query_var('latest_collection_id', 0);
                if (!$series_id) {
                    $parent_id = !empty(get_post_meta(get_the_ID(), 'post_parent', true)) ? (int) get_post_meta(get_the_ID(), 'post_parent', true) : null;
                    set_query_var('series_id', $parent_id);
                } else {
                    set_query_var('series_id', $series_id);
                }
                set_query_var('rank', $rank);
                get_template_part('template-parts/content', 'comiclistitem');
                $rank++;
            endwhile;
// Reset Post Data
            wp_reset_postdata();
            ?>
										</ul>

										<?php

        endif;
        ?>



<?php

        echo wp_kses($args['after_widget'], $allowed_tags);
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }

    public function form($instance)
    {

        $title = '';
        if (!empty($instance['title'])) {
            $title = $instance['title'];
        }

        ?>
<p>
    <label
        for="<?php echo esc_attr($this->get_field_name('title')); ?>"><?php esc_html_e('Title:', 'toocheke');?></label>
    <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
        name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
        value="<?php echo esc_attr($title); ?>" />
</p>


<?php
}
}
endif;
//Latest Ten Comics Widget ends here
/*
 * Chapters Widget
 */
if (!function_exists('toocheke_load_chapters_widget')):
    function toocheke_load_chapters_widget()
{
        register_widget('toocheke_load_chapters_widget');
    }
endif;
add_action('widgets_init', 'toocheke_load_chapters_widget');

if (!class_exists('toocheke_load_chapters_widget')):
    class toocheke_load_chapters_widget extends WP_Widget
{

        public function __construct()
    {
            $widget_details = array(
                'classname' => 'toocheke_load_chapters_widget',
                'description' => esc_html__('Displays a dropdown list of all the comic chapters. Ideal for the right sidebar on the Toocheke WP theme.', 'toocheke'),
            );

            parent::__construct('toocheke_load_chapters_widget', 'Toocheke: Comic Chapters Dropdown', $widget_details);

        }

        public function widget($args, $instance)
    {

            $allowed_tags = array(
                'section' => array(
                    'id' => array(),
                    'class' => array(),
                ),
                'h4' => array(
                    'class' => array(),
                ),
            );
            echo wp_kses($args['before_widget'], $allowed_tags);
            if (!empty($instance['title'])) {
                $title = !empty($instance['title']) ? $instance['title'] : '';
                $title = apply_filters('widget_title', $title, $instance, $this->id_base);
                echo wp_kses($args['before_title'], $allowed_tags) . wp_kses($title, $allowed_tags) . wp_kses($args['after_title'], $allowed_tags);
            }
            $chapter_args = array(
                'taxonomy' => 'chapters',
                'style' => 'none',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_query' => array(
                    array(
                        'key' => 'chapter-order',
                        'type' => 'NUMERIC',
                    )),
                'show_count' => 0,

            );

            $chapters_list = get_categories($chapter_args);

            ?>

		<select id="chapters-drodpown" onchange="document.location.href=this.options[this.selectedIndex].value" class="input-sm">
		<option value="">Select Chapter</option>
		<?php

            foreach ($chapters_list as $chapter) {
                /**
                 * Get latest post for this chapter
                 */
                $link_to_first_comic = '';
                $comic_args = array(
                    'posts_per_page' => 1,
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
                $first_comic_query = new WP_Query($comic_args);
                // The Loop
                while ($first_comic_query->have_posts()): $first_comic_query->the_post();
                    $link_to_first_comic = add_query_arg('sid', $series_id, get_post_permalink()); // Display the image of the first post in category
                    wp_reset_postdata();
                    printf(wp_kses_data('%1$s'), '<option value="' . esc_url($link_to_first_comic) . '">');
                    echo wp_kses_data($chapter->name);
                    echo '</option>';
                endwhile;
            }
            ?>
		</select>




		<?php

            echo wp_kses($args['after_widget'], $allowed_tags);
        }

        public function update($new_instance, $old_instance)
    {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
            return $instance;
        }

        public function form($instance)
    {

            $title = '';
            if (!empty($instance['title'])) {
                $title = $instance['title'];
            }

            ?>
		<p>
		    <label
		        for="<?php echo esc_attr($this->get_field_name('title')); ?>"><?php esc_html_e('Title:', 'toocheke');?></label>
		    <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
		        name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
		        value="<?php echo esc_attr($title); ?>" />
		</p>


		<?php
    }
    }
endif;
//Chapters Widget ends here
/*
 * Comic Tag Cloud Widget
 */
if (!function_exists('toocheke_load_comic_tags_widget')):
    function toocheke_load_comic_tags_widget()
{
        register_widget('toocheke_comic_tags_widget');
    }
endif;
add_action('widgets_init', 'toocheke_load_comic_tags_widget');

if (!class_exists('toocheke_comic_tags_widget')):
    class toocheke_comic_tags_widget extends WP_Widget
{

        public function __construct()
    {
            $widget_details = array(
                'classname' => 'toocheke_comic_tags_widget',
                'description' => esc_html__('Creates comic tags cloud.', 'toocheke'),
            );

            parent::__construct('toocheke_comic_tags_widget', 'Toocheke: Comic Tags Cloud', $widget_details);

        }

        public function widget($args, $instance)
    {
            $allowed_tags = array(
                'section' => array(
                    'id' => array(),
                    'class' => array(),
                ),
                'h4' => array(
                    'class' => array(),
                ),
            );
            echo wp_kses($args['before_widget'], $allowed_tags);
            if (!empty($instance['title'])) {
                $title = !empty($instance['title']) ? $instance['title'] : '';
                $title = apply_filters('widget_title', $title, $instance, $this->id_base);
                echo wp_kses($args['before_title'], $allowed_tags) . wp_kses($title, $allowed_tags) . wp_kses($args['after_title'], $allowed_tags);
            }

            ?>
										<?php
    $cloud_args = array('taxonomy' => 'comic_tags');
            wp_tag_cloud($cloud_args);
            ?>




										<?php

            echo wp_kses($args['after_widget'], $allowed_tags);
        }

        public function update($new_instance, $old_instance)
    {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
            return $instance;
        }

        public function form($instance)
    {

            $title = '';
            if (!empty($instance['title'])) {
                $title = $instance['title'];
            }

            ?>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('title')); ?>"><?php esc_html_e('Title:', 'toocheke');?></label>
										    <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
										        value="<?php echo esc_attr($title); ?>" />
										</p>

										<?php
    }
    }
endif;
//Comic Tag Cloud Widget ends here
/*
 * Location Cloud Widget
 */
if (!function_exists('toocheke_load_comic_locations_widget')):
    function toocheke_load_comic_locations_widget()
{
        register_widget('toocheke_comic_locations_widget');
    }
endif;
add_action('widgets_init', 'toocheke_load_comic_locations_widget');

if (!class_exists('toocheke_comic_locations_widget')):
    class toocheke_comic_locations_widget extends WP_Widget
{

        public function __construct()
    {
            $widget_details = array(
                'classname' => 'toocheke_comic_locations_widget',
                'description' => esc_html__('Creates locations cloud.', 'toocheke'),
            );

            parent::__construct('toocheke_comic_locations_widget', 'Toocheke: Locations Cloud', $widget_details);

        }

        public function widget($args, $instance)
    {
            $allowed_tags = array(
                'section' => array(
                    'id' => array(),
                    'class' => array(),
                ),
                'h4' => array(
                    'class' => array(),
                ),
            );
            echo wp_kses($args['before_widget'], $allowed_tags);
            if (!empty($instance['title'])) {
                $title = !empty($instance['title']) ? $instance['title'] : '';
                $title = apply_filters('widget_title', $title, $instance, $this->id_base);
                echo wp_kses($args['before_title'], $allowed_tags) . wp_kses($title, $allowed_tags) . wp_kses($args['after_title'], $allowed_tags);
            }

            ?>
										<?php
    $cloud_args = array('taxonomy' => 'comic_locations');
            wp_tag_cloud($cloud_args);
            ?>




										<?php

            echo wp_kses($args['after_widget'], $allowed_tags);
        }

        public function update($new_instance, $old_instance)
    {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
            return $instance;
        }

        public function form($instance)
    {

            $title = '';
            if (!empty($instance['title'])) {
                $title = $instance['title'];
            }

            ?>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('title')); ?>"><?php esc_html_e('Title:', 'toocheke');?></label>
										    <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
										        value="<?php echo esc_attr($title); ?>" />
										</p>

										<?php
    }
    }
endif;
//Location Cloud Widget ends here
/*
 * Character Cloud Widget
 */
if (!function_exists('toocheke_load_comic_characters_widget')):
    function toocheke_load_comic_characters_widget()
{
        register_widget('toocheke_comic_characters_widget');
    }
endif;
add_action('widgets_init', 'toocheke_load_comic_characters_widget');

if (!class_exists('toocheke_comic_characters_widget')):
    class toocheke_comic_characters_widget extends WP_Widget
{

        public function __construct()
    {
            $widget_details = array(
                'classname' => 'toocheke_comic_characters_widget',
                'description' => esc_html__('Creates characters cloud.', 'toocheke'),
            );

            parent::__construct('toocheke_comic_characters_widget', 'Toocheke: Characters Cloud', $widget_details);

        }

        public function widget($args, $instance)
    {
            $allowed_tags = array(
                'section' => array(
                    'id' => array(),
                    'class' => array(),
                ),
                'h4' => array(
                    'class' => array(),
                ),
            );
            echo wp_kses($args['before_widget'], $allowed_tags);
            if (!empty($instance['title'])) {
                $title = !empty($instance['title']) ? $instance['title'] : '';
                $title = apply_filters('widget_title', $title, $instance, $this->id_base);
                echo wp_kses($args['before_title'], $allowed_tags) . wp_kses($title, $allowed_tags) . wp_kses($args['after_title'], $allowed_tags);
            }

            ?>
										<?php
    $cloud_args = array('taxonomy' => 'comic_characters');
            wp_tag_cloud($cloud_args);
            ?>




										<?php

            echo wp_kses($args['after_widget'], $allowed_tags);
        }

        public function update($new_instance, $old_instance)
    {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
            return $instance;
        }

        public function form($instance)
    {

            $title = '';
            if (!empty($instance['title'])) {
                $title = $instance['title'];
            }

            ?>
										<p>
										    <label
										        for="<?php echo esc_attr($this->get_field_name('title')); ?>"><?php esc_html_e('Title:', 'toocheke');?></label>
										    <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
										        name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
										        value="<?php echo esc_attr($title); ?>" />
										</p>

										<?php
    }
    }
endif;
//Character Cloud Widget ends here
