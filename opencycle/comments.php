<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to twentytwelve_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;

global $url, $css_dir, $permalink;
wp_enqueue_script( 'comment-reply' );

function oc_paginate_comments_links($args = array()) {
	global $wp_rewrite;

	$page = get_query_var('cpage');
	if ( !$page )
			$page = 1;
	$max_page = get_comment_pages_count();
	$defaults = array(
			'base' => add_query_arg( 'cpage', '%#%' ),
			'format' => '',
			'total' => $max_page,
			'current' => $page,
			'echo' => true,
			'add_fragment' => '#comments'
	);
	if ( $wp_rewrite->using_permalinks() )
			$defaults['base'] = user_trailingslashit(trailingslashit(get_permalink()) . 'comment-page-%#%', 'commentpaged');

	$args = wp_parse_args( $args, $defaults );
	$page_links = paginate_links( $args );

	if ( $args['echo'] )
			echo $page_links;
	else
			return $page_links;
}


function display_single_comment($comment, $args, $depth) {
		global $user_ID, $url;
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}

		get_currentuserinfo();
		if (($comment->comment_approved == '0') && ($comment->user_id != $user_ID) && !current_user_can('moderate_comments')) {
			return;
		}

		echo '<'.$tag; ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>">
		<?php endif; ?>
		<div class="comment-author">
		<?php /*if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); */?>
		<?php echo '<div class="author-name">'.get_comment_author_link().'</div>'; ?>
		</div>
        <div class=comment-content>
<?php if ($comment->comment_approved == '0') : ?>
		<em class="comment-awaiting-moderation"><?php echo 'Ваш комментарий ожидает подтверждения модератором.'; ?></em>
		<br />
<?php endif; ?>
		<?php comment_text() ?>
		</div>
		<div class="comment-date">
			<?php
				/* translators: 1: date, 2: time */
				echo get_comment_date('d.m.Y');
				echo ' <b>'.get_comment_date('H:i').'</b>'; ?><?php 
			?>
		</div>

		<div class="comment-reply">
		<?php
			 comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'])));
			 edit_comment_link('Редактировать','  ','' ); 
		?>
<?php if ( current_user_can('edit_post', $comment->comment_post_ID) || current_user_can('moderate_comments')) {
	$url = esc_url(wp_nonce_url( get_bloginfo('wpurl')."/wp-admin/comment.php?action=trashcomment&p=$comment->comment_post_ID&c=$comment->comment_ID", "delete-comment_$comment->comment_ID" ));
	echo "<a href='$url' class='delete:the-comment-list:comment-$comment->comment_ID comment-delete-link'>Удалить</a> ";
} ?>
		</div> <div style="clear:both"></div>
        
        
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; 
		echo "</$tag>";
}

function end_single_comment(){
}
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				echo 'Комментарии ('.get_comments_number().')';
			?>
		</h2>

		<ol class="commentlist">
			<?php wp_list_comments(array('style' => 'div', 'callback' => 'display_single_comment', 'end-callback' => 'end_single_comment', 'reply_text' => 'Ответить')); ?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<?php oc_paginate_comments_links(); ?>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'twentytwelve' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form(array('comment_notes_before' => '', 'comment_notes_after' => '', 'logged_in_as' => '', 'title_reply' => 'Оставить комментарий', 'title_reply_to' => 'Ответить', 'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" aria-required="true"></textarea></p>', 'cancel_reply_link' => "(Отмена)", 'label_submit' => 'Оставить комментарий')); 
; ?>

</div><!-- #comments .comments-area -->