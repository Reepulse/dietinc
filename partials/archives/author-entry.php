<?php
/**
 * Author bio
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

// Vars
global $wpex_author;
$user_id			= $wpex_author->ID;
$display_name		= $wpex_author->display_name;
$author_profile_url	= get_author_posts_url( $user_id ); ?>

<article class="wpex-author-entry wpex-boxed-container wpex-clr">

	<div class="wpex-author-entry-inner wpex-clr">

		<div class="wpex-author-entry-avatar">

			<a href="<?php echo esc_url( $author_profile_url ); ?>" title="<?php _e( 'Posts by', 'chic' ); ?> <?php echo $display_name; ?>">
				<?php echo get_avatar( $user_id , '80' ); ?>
			</a>

		</div><!-- .wpex-author-entry-avatar -->

		<div class="wpex-author-entry-desc">

			<h2 class="wpex-author-entry-title">
				<a href="<?php echo esc_url( $author_profile_url ); ?>" title="<?php _e( 'Posts by', 'chic' ); ?> <?php echo $display_name; ?>">
					<?php echo $display_name; ?>
				</a>
			</h2><!-- .wpex-author-entry-title -->

			<?php
			// Display author URl
			if ( get_the_author_meta( 'url', $user_id ) ) : ?>

				<div class="wpex-author-entry-url">

					<?php if ( get_the_author_meta( 'wpex_website', $user_id ) ) : ?>

						<span><?php _e( 'Website', 'chic' ); ?>:</span> <a href="<?php echo get_the_author_meta( 'url', $user_id ); ?>" title="<?php _e( 'Visit Website', 'chic' ); ?>"><?php echo get_the_author_meta( 'wpex_website', $user_id ); ?></a>

					<?php else : ?>

						<a href="<?php echo get_the_author_meta( 'url', $user_id ); ?>" title="<?php _e( 'View Author Posts', 'chic' ); ?>"><?php echo get_the_author_meta( 'url', $user_id ); ?></a>

					<?php endif; ?>

				</div><!-- .wpex-author-entry-url -->

			<?php endif; ?>

			<p><?php echo get_user_meta( $user_id, 'description', true ); ?></p>

			<?php
			// If any social option is defined display the social links
			if ( wpex_author_has_social( $user_id ) ) : ?>

				<div class="wpex-author-entry-social wpex-social-color-buttons wpex-clr">
				
					<?php
					// Display twitter url
					if ( $a_twitter = get_the_author_meta( 'wpex_twitter', $user_id ) ) { ?>
						<a href="<?php echo esc_url( $a_twitter ); ?>" title="Twitter" class="wpex-twitter"><span class="fa fa-twitter"></span></a>
					<?php }

					// Display facebook url
					if ( $a_facebook = get_the_author_meta( 'wpex_facebook', $user_id ) ) { ?>
						<a href="<?php echo esc_url( $a_facebook ); ?>" title="Facebook" class="wpex-facebook"><span class="fa fa-facebook"></span></a>
					<?php }

					// Display google plus url
					if ( $a_googleplus = get_the_author_meta( 'wpex_googleplus', $user_id ) ) { ?>
						<a href="<?php echo esc_url( $a_googleplus ); ?>" title="Google Plus" class="wpex-google-plus"><span class="fa fa-google-plus"></span></a>
					<?php }

					// Display Linkedin url
					if ( $a_linkedin = get_the_author_meta( 'wpex_linkedin', $user_id ) ) { ?>
						<a href="<?php echo esc_url( $a_linkedin ); ?>" title="Facebook" class="wpex-linkedin"><span class="fa fa-linkedin"></span></a>
					<?php }

					// Display pinterest plus url
					if ( $a_pinterest = get_the_author_meta( 'wpex_pinterest', $user_id ) ) { ?>
						<a href="<?php echo esc_url( $a_pinterest ); ?>" title="Pinterest" class="wpex-pinterest"><span class="fa fa-pinterest"></span></a>
					<?php }

					// Display instagram plus url
					if ( $a_instagram = get_the_author_meta( 'wpex_instagram', $user_id ) ) { ?>
						<a href="<?php echo esc_url( $a_instagram ); ?>" title="Instagram" class="wpex-instagram"><span class="fa fa-instagram"></span></a>
					<?php } ?>

				</div><!-- .author-bio-social -->
				
			<?php endif; ?>

		</div><!-- .wpex-author-entry-desc -->

	</div><!-- .wpex-author-entry-inner -->

</article><!-- .wpex-author-entry -->