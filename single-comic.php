<?php
/**
 * The template for displaying all single comic posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Toocheke
 */
$home_layout = get_theme_mod('home_layout_setting', 'default');
$display_comic_nav_above_comic = get_option('toocheke-comic-nav-above-comic') && 1 == get_option('toocheke-comic-nav-above-comic');
$is_bilingual = get_option('toocheke-bilingual-display') && 1 == get_option('toocheke-bilingual-display');
$override_blog_display = get_option('toocheke-dspay-blog-on-webtoon') && 1 == get_option('toocheke-dspay-blog-on-webtoon');
$collection_id = isset($_GET['col']) ? (int) $_GET['col'] : 0;
$left_col_class = $home_layout == 'alt-1' || $home_layout == 'alt-4' ? 'col-lg-8' : 'col-lg-12';
$margin_below_comic = $home_layout == 'alt-1' || $home_layout == 'alt-4' ? 'add-margin' : '';
toocheke_set_post_views(get_the_ID());
set_query_var('collection_id', $collection_id);
'default' === $home_layout || 'alt-3' === $home_layout || 'alt-5' === $home_layout ? get_header('comics') : get_header();
?>
<?php if(get_post_meta($post->ID, 'desktop_comic_2nd_language_editor', true) || get_post_meta($post->ID, 'mobile_comic_2nd_language_editor', true)):?>
 <div id="language-switch-container" style="<?php echo esc_attr(($is_bilingual ? "" : "display: none")) ?>">
               <a id="switch-language" href="javascript:;" title="Switch Languages" class="SwitchLang">
               <i class="fas fa-3x fa-language"></i>
               </a>
  </div>
  <?php endif;?>
<?php
if ('default' === $home_layout || 'alt-3' === $home_layout || 'alt-5' === $home_layout):
?>

<div class="row">
            <div class="col-lg-12">
               <div id="comic">
                        <!--BELOW HEADER-->
		<?php if (is_active_sidebar('below-header')): ?>
		<div id="below-header" class="webtoon <?php echo( $add_padding_to_header_top ? esc_attr('below-header-padding-top') : '');?> <?php echo( $add_padding_to_header_bottom ? esc_attr('below-header-padding-bottom') : esc_attr(''));?>">
		<?php dynamic_sidebar('below-header');?>
		</div>
		<?php endif;?>
		<!--./BELOW HEADER-->
					 <?php
while (have_posts()):
    the_post();

    get_template_part('template-parts/content', get_post_type());
    ?>
															<b><?php esc_html_e('Published On:', 'toocheke');?></b>
															<?php
    the_date();

    toocheke_load_comic_carousel($collection_id);
//if display blog post if override function is turned on
    if ($override_blog_display) {
        ?>
	          <div class="blog-wrapper">
	          <header class="entry-header">
														<?php
    if (is_singular('comic')):
            echo '<span class="default-lang">';
            the_title('<h1 class="entry-title">', '</h1>');
            echo '</span>';
            echo '<span class="alt-lang"><h1>';
            echo esc_html(get_post_meta($post->ID, 'comic-title-2nd-language-display', true));
            echo '</h1></span>';
        else:
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;

        ?>


													</header><!-- .entry-header -->

											              <article class="post type-post ">

											                       <?php

        echo '<span class="default-lang">';
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo do_shortcode(get_post_meta($post->ID, 'comic_blog_post_editor', true));
        echo '</span>';
        echo '<span class="alt-lang">';
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo do_shortcode(get_post_meta($post->ID, 'comic_2nd_language_blog_post_editor', true));
        echo '</span>';
        ?>
											                     </article>
											              </div><!-- .blog-wrapper" -->
	    <?php
    }
    // If comments are open or we have at least one comment, load up the comment template.
    if (comments_open() || get_comments_number()):
        comments_template();
    endif;
endwhile; // End of the loop.
wp_reset_postdata();
?>
    <!--ABOVE FOOTER-->
    <?php if (is_active_sidebar('above-footer')): ?>
    <div id="above-footer" class="webtoon">
    <?php dynamic_sidebar('above-footer');?>
    </div>
    <?php endif;?>
    <!--./ABOVE FOOTER-->
</div>
            </div>
		 </div>
		 <?php
else:
?>
		 <div id="inner-content-row" class="row">
<div id="inner-content" class="col-lg-12">
               <div id="comic" class="single-comic-wrapper">

					 <?php
while (have_posts()):
    the_post();
    if ($display_comic_nav_above_comic) {
        set_query_var('below_comic', 0);
        get_template_part('template-parts/content', 'comicnavigation');
    }
    get_template_part('template-parts/content', get_post_type());
    set_query_var('below_comic', 1);
    get_template_part('template-parts/content', 'comicnavigation');
    ?>
	  </div><!-- .single-comic-wrapper" -->
	  </div><!-- .col-lg-12" -->
	  </div><!-- .row -->
	  <div id="traditional-single-comic" class="row <?php echo esc_attr($margin_below_comic) ?>">
	  <div class="<?php echo esc_attr($left_col_class) ?>">
	  <div id="left-col">
	  <div id="left-content">
	  <?php
    if ($home_layout == 'alt-1' || $home_layout == 'alt-4') {
        ?>
											              <div class="blog-wrapper">
											              <header class="entry-header">
														<?php
    if (is_singular('comic')):
            echo '<span class="default-lang">';
            the_title('<h1 class="entry-title">', '</h1>');
            echo '</span>';
            echo '<span class="alt-lang"><h1>';
            echo esc_html(get_post_meta($post->ID, 'comic-title-2nd-language-display', true));
            echo '</h1></span>';
        else:
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;

        ?>
															<div class="entry-meta">
																<?php
    toocheke_posted_on();
        toocheke_posted_by();
        ?>
															</div><!-- .entry-meta -->

													</header><!-- .entry-header -->
											              <article class="post type-post ">

											                       <?php

        echo '<span class="default-lang">';
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo do_shortcode(get_post_meta($post->ID, 'comic_blog_post_editor', true));
        echo '</span>';
        echo '<span class="alt-lang">';
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo do_shortcode(get_post_meta($post->ID, 'comic_2nd_language_blog_post_editor', true));
        echo '</span>';
        ?>
											                     </article>
											              </div><!-- .blog-wrapper" -->
											        <?php
    }
    ?>

															<?php

    // If comments are open or we have at least one comment, load up the comment template.
    if (comments_open() || get_comments_number()):
        comments_template();
    endif;

endwhile; // End of the loop.
wp_reset_postdata();
?>

</div><!-- #left-content -->
</div><!-- #left-col -->
</div><!-- $left_col_class -->


<?php
get_sidebar();
endif;
?>
<?php
'default' === $home_layout || 'alt-3' === $home_layout || 'alt-5' === $home_layout ? get_footer('comics') : get_footer();
