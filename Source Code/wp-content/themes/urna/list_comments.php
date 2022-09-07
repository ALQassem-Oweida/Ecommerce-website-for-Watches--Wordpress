<?php

$GLOBALS['comment'] = $comment;
$add_below = '';

?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment_container">
		<div class="tbay-avatar">
			<div class="tbay-image">
				<?php echo get_avatar($comment, 66); ?>
			</div>
		</div>
		<div class="comment-text">
			
			<div class="meta">
				<div class="tbay-author"><?php  echo get_comment_author_link(); ?></div>
				<time datetime="<?php echo get_comment_date('c'); ?>"><?php echo get_comment_date(); ?></time>
			</div>
			<div class="change">
				<?php edit_comment_link(esc_html__('Edit', 'urna'), '', '') ?>
				<?php comment_reply_link(array_merge($args, array( 'reply_text' => esc_html__('Reply', 'urna'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>			
			<div class="description">
				<?php if ($comment->comment_approved == '0') : ?>
				<em><?php esc_html_e('Your comment is awaiting moderation.', 'urna') ?></em>
				<br />
				<?php endif; ?>
				<?php comment_text() ?>
			</div>
		</div>
	</div>