<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

	<?php if (have_comments()) : ?>
        <h3 class="comments-title"><?php comments_number(esc_html__('0 Comments', 'urna'), esc_html__('1 Comment', 'urna'), esc_html__('% Comments', 'urna')); ?></h3>
		<?php urna_tbay_comment_nav(); ?>
		<ul class="comment-list">
			<?php wp_list_comments('callback=urna_tbay_list_comment'); ?>
		</ul><!-- .comment-list -->

		<?php urna_tbay_comment_nav(); ?>

	<?php endif; // have_comments()?>

	<?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (! comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
    ?>
		<p class="no-comments"><?php esc_html_e('Comments are closed.', 'urna'); ?></p>
	<?php endif; ?>

	<?php
        $comment_args = array(
        'title_reply'=> esc_html__('Leave a Reply', 'urna'),
        'comment_field' => '<p class="comment-form-comment form-group"><label class="control-label">' . esc_html__('Comment:', 'urna') .'</label><textarea id="comment" class="form-control" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
        'fields' => apply_filters(
            'comment_form_default_fields',
            array(
                    'author' => '<p class="comment-form-author form-group col-sm-6 col-md-4">
								<label class="control-label">' . esc_html__('Name:', 'urna') .'</label>
					            <input id="author" class="form-control" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" aria-required="true" /></p>',
                    'email' => '<p class="comment-form-email form-group col-sm-6 col-md-4">
								<label class="control-label">' . esc_html__('Email:', 'urna') .'</label>
					            <input id="email" class="form-control" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" aria-required="true" /></p>',
                )
        ),
            'label_submit' => esc_html__('submit', 'urna'),
            'comment_notes_before' => '<div class="form-group h-info">'.esc_html__('Your email address will not be published. Required fields are makes.', 'urna').'</div>',
            'comment_notes_after' => '',
        );
    ?>

	<?php urna_tbay_comment_form($comment_args); ?>
</div><!-- .comments-area -->
