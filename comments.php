 <?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments and the comment
 * form. The actual display of comments is handled by a callback to
 * wpex_comment() which is located at functions/comments-callback.php
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

// Return if not needed
if ( post_password_required() || ( ! comments_open() && get_comment_pages_count() == 0 ) ) {
	return;
}

// Return if comments disabled
if ( ! wpex_has_comments() ) {
	return;
} ?>

<div id="comments" class="comments-area wpex-clr wpex-boxed-container">

	<?php
	// Display facebook comments if enabled
	if ( wpex_has_fb_comments() ) : ?>

		<div class="fb-comments wpex-fb-comments" data-href="<?php echo wpex_fb_comments_url(); ?>" data-numposts="20" data-mobile="true"></div>

	<?php
	// Display standard comments
	else :

		// Display comments if we have some
		if ( have_comments() ) : ?>

			<h2 class="wpex-comments-title wpex-heading">
				<span>
					<?php
					// Display Comments Title
					$comments_number = number_format_i18n( get_comments_number() );
					if ( '1' == $comments_number ) {
						if ( is_page() ) {
							$comments_title = __( 'This page has 1 comment', 'chic' );
						} else {
							$comments_title = __( 'This article has 1 comment', 'chic' );
						}
					} else {
						if ( is_page() ) {
							$comments_title = sprintf( __( 'This page has %s comments', 'chic' ), $comments_number );
						} else {
							$comments_title = sprintf( __( 'This article has %s comments', 'chic' ), $comments_number );
						}
					}
					$comments_title = apply_filters( 'wpex_comments_title', $comments_title );
					echo $comments_title; ?>
				</span>
			</h2>

			<ol class="commentlist">

				<?php
				// Display comments
				wp_list_comments( array(
					'callback'	=> 'wpex_comment',
				) ); ?>

			</ol><!-- .commentlist -->

			<?php
			// Display comment pagination
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

				<nav class="navigation comment-navigation row wpex-clr" role="navigation">
					<h3 class="assistive-text wpex-heading">
						<span><?php _e( 'Comment navigation', 'chic' ); ?></span>
					</h3>
					<div class="wpex-clr">
						<div class="wpex-nav-previous">
							<?php previous_comments_link( __( '&larr; Older Comments', 'chic' ) ); ?>
						</div>
						<div class="wpex-nav-next">
							<?php next_comments_link( __( 'Newer Comments &rarr;', 'chic' ) ); ?>
						</div>
					</div><!-- .wpex-clr -->
				</nav>

			<?php endif; ?>

		<?php endif; // have_comments() ?>

		<?php
		// Display comments closed notice
		if ( ! comments_open() ) : ?>

			<div class="comments-closed-notice wpex-clr">

				<?php _e( 'Comments are now closed.', 'chic' ); ?>

			</div><!-- .comments-closed-notice -->

		<?php endif; ?>

		<?php
		// Display comment submission form
		$args = array();
		if ( get_theme_mod( 'disable_comment_form_notes' ) ) {
			$args['comment_notes_after'] = null;
		}
		comment_form( $args ); ?>

	<?php endif; ?>

</div><!-- #comments -->