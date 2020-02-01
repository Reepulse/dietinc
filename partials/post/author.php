<?php
/**
 * The template for displaying Author bios.
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Author description required
$description = get_the_author_meta( 'description' );

if ( $description ) : ?>

	<section class="wpex-author-info wpex-boxed-container wpex-clr">

		<div class="wpex-author-info-inner wpex-clr">

			<div class="wpex-author-info-avatar">

				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php esc_attr( _e( 'Visit Author Page', 'chic' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'wpex_author_bio_avatar_size', 70 ) ); ?></a>

			</div><!-- .wpex-author-info-avatar -->

			<div class="wpex-author-info-content wpex-clr">

				<div class="wpex-author-info-author wpex-heading-font-family"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php esc_attr( _e( 'Visit Author Page', 'chic' ) ); ?>"><?php _e( 'Article written by', 'chic' ); ?>: <span><?php echo get_the_author(); ?></a></span></div>
				
				<?php if ( get_the_author_meta( 'url', $post->post_author ) ) { ?>

					<div class="wpex-author-info-url">

						<?php if ( get_the_author_meta( 'wpex_website', $post->post_author ) ) { ?>

							<span><?php _e( 'Website', 'chic' ); ?>:</span> <a href="<?php echo get_the_author_meta( 'url', $post->post_author ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>" target="_blank"><?php echo get_the_author_meta( 'wpex_website', $post->post_author ); ?></a>

						<?php } else { ?>

						<a href="<?php echo get_the_author_meta( 'url', $post->post_author ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>"><?php echo get_the_author_meta( 'url', $post->post_author ); ?></a>

						<?php } ?>

					</div>
				
				<?php } ?>

				<p><?php echo $description; ?></p>

			</div><!-- .wpex-author-info-content -->

			<div class="wpex-author-info-social wpex-social-color-buttons wpex-clr">

				<?php
				// Display twitter url
				if ( get_the_author_meta( 'wpex_twitter', $post->post_author ) ) { ?>

					<a href="<?php echo get_the_author_meta( 'wpex_twitter', $post->post_author ); ?>" title="Twitter" class="wpex-twitter" target="_blank"><span class="fa fa-twitter"></span></a>

				<?php }

				// Display facebook url
				if ( get_the_author_meta( 'wpex_facebook', $post->post_author ) ) { ?>

					<a href="<?php echo get_the_author_meta( 'wpex_facebook', $post->post_author ); ?>" title="Facebook" class="wpex-facebook" target="_blank"><span class="fa fa-facebook"></span></a>

				<?php }

				// Display google plus url
				if ( get_the_author_meta( 'wpex_googleplus', $post->post_author ) ) { ?>

					<a href="<?php echo get_the_author_meta( 'wpex_googleplus', $post->post_author ); ?>" title="Google Plus" class="wpex-google-plus" target="_blank"><span class="fa fa-google-plus"></span></a>

				<?php }

				// Display Linkedin url
				if ( get_the_author_meta( 'wpex_linkedin', $post->post_author ) ) { ?>

					<a href="<?php echo get_the_author_meta( 'wpex_linkedin', $post->post_author ); ?>" title="LinkedIn" class="wpex-linkedin" target="_blank"><span class="fa fa-linkedin"></span></a>

				<?php }

				// Display pinterest plus url
				if ( get_the_author_meta( 'wpex_pinterest', $post->post_author ) ) { ?>

					<a href="<?php echo get_the_author_meta( 'wpex_pinterest', $post->post_author ); ?>" title="Pinterest" class="wpex-pinterest" target="_blank"><span class="fa fa-pinterest"></span></a>

				<?php }

				// Display instagram plus url
				if ( get_the_author_meta( 'wpex_instagram', $post->post_author ) ) { ?>

					<a href="<?php echo get_the_author_meta( 'wpex_instagram', $post->post_author ); ?>" title="Instagram" class="wpex-instagram" target="_blank"><span class="fa fa-instagram"></span></a>

				<?php } ?>

			</div><!-- .wpex-author-info-social -->

		</div><!-- .wpex-author-info-inner -->

	</section><!-- .wpex-author-info -->

<?php endif; ?>