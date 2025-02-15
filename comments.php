<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package toocheke
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
$series_id = null;
$series_id = isset($_GET['sid']) ? (int) $_GET['sid'] : null;
?>

<div class="comments-area" id="comments">

	<?php // You can start editing here -- including this comment! ?>

	<?php if (have_comments()): ?>

		<h2 class="comments-title">

			<?php
$comments_number = get_comments_number();
if (1 === (int) $comments_number) {
    printf(
        /* translators: %s: post title */
        esc_html_x('One thought on &ldquo;%s&rdquo;', 'comments title', 'toocheke'),
        '<span>' . wp_kses_data(get_the_title()) . '</span>'
    );
} else {
    printf(
        /* translators: 1: number of comments, 2: post title */
        esc_html(_nx(
            '%1$s thought on &ldquo;%2$s&rdquo;',
            '%1$s thoughts on &ldquo;%2$s&rdquo;',
            $comments_number,
            'comments title',
            'toocheke'
        )),
        wp_kses_data(number_format_i18n($comments_number)),
        '<span>' . wp_kses_data(get_the_title()) . '</span>'
    );
}
?>

		</h2><!-- .comments-title -->

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')): // are there comments to navigate through. ?>

					<nav class="comment-navigation" id="comment-nav-above">

						<h1 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'toocheke');?></h1>

						<?php if (get_previous_comments_link()) {?>
							<div class="nav-previous">
								<?php previous_comments_link(__('&larr; Older Comments', 'toocheke'));?>
							</div>
						<?php }?>

						<?php	if (get_next_comments_link()) {?>
							<div class="nav-next">
								<?php next_comments_link(__('Newer Comments &rarr;', 'toocheke'));?>
							</div>
						<?php }?>

					</nav><!-- #comment-nav-above -->

				<?php endif; // check for comment navigation. ?>

		<ol class="medias py-md-5 my-md-5 px-sm-0 mx-sm-0">
<?php

wp_list_comments(array(
    'style' => 'ol',
    'max_depth' => 4,
    'short_ping' => true,
    'avatar_size' => '50',
    'walker' => new Bootstrap_Comment_Walker(),
));
?>
</ol><!-- .comment-list -->

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')): // are there comments to navigate through. ?>

					<nav class="comment-navigation" id="comment-nav-below">

						<h1 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'toocheke');?></h1>

						<?php if (get_previous_comments_link()) {?>
							<div class="nav-previous">
								<?php previous_comments_link(__('&larr; Older Comments', 'toocheke'));?>
							</div>
						<?php }?>

						<?php	if (get_next_comments_link()) {?>
							<div class="nav-next">
								<?php next_comments_link(__('Newer Comments &rarr;', 'toocheke'));?>
							</div>
						<?php }?>

					</nav><!-- #comment-nav-below -->

				<?php endif; // check for comment navigation. ?>

	<?php endif; // endif have_comments(). ?>

	<?php
// If comments are closed and there are comments, let's leave a little note, shall we?
if (!comments_open() && '0' != get_comments_number() && post_type_supports(get_post_type(), 'comments')):
?>

		<p class="no-comments"><?php esc_html_e('Comments are closed.', 'toocheke');?></p>

	<?php endif;?>

	<?php
/*
 * Adding bootstrap support to comment form,
 * and some form validation using javascript.
 */

ob_start();
$commenter = wp_get_current_commenter();
$req = true;
$req_name_email = true;
if (get_option('require_name_email') == 1) {

    $req_name_email = true;

} else {

    $req_name_email = false;

}
$aria_req = ($req ? " aria-required='true'" : '');
$aria_req_name_email = ($req_name_email ? " aria-required='true'" : '');

$comments_arg = array(
    'form' => array(
        'class' => 'form-horizontal',
    ),
    'fields' => apply_filters('comment_form_default_fields', array(
        'series_id' => '<input id="series_id" name="series_id" class="form-control" type="hidden" value="' . $series_id . '" />',
		'require_name_email' => '<input id="require_name_email" name="require_name_email" class="form-control" type="hidden" value="' . $req_name_email . '" />',
        'author' => '<div class="form-group">' . '<label for="author">' . __('Name', 'toocheke') . '</label> ' . ($req_name_email ? '<span>*</span>' : '') .
        '<input id="author" name="author" class="form-control" type="text" value="" size="30"' . $aria_req_name_email . ' />' .
        '<p id="d1" class="text-danger"></p>' . '</div>',
        'email' => '<div class="form-group">' . '<label for="' . ($req_name_email ? 'email' : 'noemail') . '">' . __('Email', 'toocheke') . '</label> ' . ($req_name_email ? '<span>*</span>' : '') .
        '<input id="email" name="email" class="form-control" type="text" value="" size="30"' . $aria_req_name_email . ' />' .
        '<p id="d2" class="text-danger"></p>' . '</div>',
        'url' => '')),
    'comment_field' => '<div class="form-group">' . '<label for="comment">' . __('Comment', 'toocheke') . '</label><span>*</span>' .
    '<textarea id="comment" class="form-control" name="comment" rows="3" aria-required="true"></textarea><p id="d3" class="text-danger"></p>' . '</div>',
    'comment_notes_after' => '',
    'class_submit' => 'btn btn-success btn-xs',
);?>
	<?php

comment_form($comments_arg);
// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo str_replace('class="comment-form"', 'class="comment-form" name="commentForm" onsubmit="return validateForm();"', ob_get_clean());

?>

		<script>
			/* basic javascript form validation */
			function validateForm() {
			var form 	=  document.forms["commentForm"];
				u 		=  form.require_name_email != undefined &&  form["require_name_email"].value === '1',
				v       =  form.author != undefined && form.email != undefined,
				x 		=  form.author != undefined ? form["author"].value : '',
				y 		= form.email != undefined ? form["email"].value : '',
				z 		= form["comment"].value,
				flag 	= true,
				d1 		= document.getElementById("d1"),
				d2 		= document.getElementById("d2"),
				d3 		= document.getElementById("d3");
			if (u && v && (x == null || x == "")) {
				d1.innerHTML = "<?php echo esc_html__('Name is required', 'toocheke'); ?>";
				z = false;
			} else {
				d1.innerHTML = "";
			}

			if (u && v && (y == null || y == "" || (y.indexOf('@') == '-1'))) {
				d2.innerHTML = "<?php echo esc_html__('Email is required', 'toocheke'); ?>";
				z = false;
			} else {
				d2.innerHTML = "";
			}

			if (z == null || z == "") {
				d3.innerHTML = "<?php echo esc_html__('Comment is required', 'toocheke'); ?>";
				z = false;
			} else {
				d3.innerHTML = "";
			}

			if (z == false) {
				return false;
			}

		}
	</script>

</div><!-- #comments -->

