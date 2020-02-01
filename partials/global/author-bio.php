<?php
/**
 * Used to display post author info
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

// Not needed here
if ( is_attachment() ) {
	return;
}

// Return if disabled
if ( ! get_theme_mod( 'post_author_bio', true ) ) {
	return;
}

// Vars
$author				= get_the_author();
$author_description	= get_the_author_meta( 'description' );
$author_url			= esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
$author_avatar		= get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'wpex_author_bio_avatar_size', 75 ) );

// Only display if author has a description
if ( ! $author_description ) {
	return;
} ?>

<div class="author-info wpex-clr wpex-boxed-container">
	<h4 class="heading"><span><?php printf( __( 'Written by %s', 'chic' ), $author ); ?></span></h4>
	<div class="author-info-inner wpex-clr">
		<?php if ( $author_avatar ) { ?>
			<div class="author-avatar wpex-clr">
				<a href="<?php echo $author_url; ?>" rel="author">
					<?php echo $author_avatar; ?>
				</a>
			</div><!-- .author-avatar -->
		<?php } ?>
		<div class="author-description">
			<p><?php echo $author_description; ?></p>
		</div><!-- .author-description -->
		<?php if ( wpex_author_has_social() ) : ?>
			<div class="author-social wpex-clr">
				<?php
				// Display twitter url
				if ( get_the_author_meta( 'wpex_twitter', $post->post_author ) ) { ?>
					<a href="<?php echo get_the_author_meta( 'wpex_twitter', $post->post_author ); ?>" title="Twitter" class="twitter" target="_blank"><span class="fa fa-twitter"></span></a>
				<?php }
				// Display facebook url
				if ( get_the_author_meta( 'wpex_facebook', $post->post_author ) ) { ?>
					<a href="<?php echo get_the_author_meta( 'wpex_facebook', $post->post_author ); ?>" title="Facebook" class="facebook" target="_blank"><span class="fa fa-facebook"></span></a>
				<?php }
				// Display google plus url
				if ( get_the_author_meta( 'wpex_googleplus', $post->post_author ) ) { ?>
					<a href="<?php echo get_the_author_meta( 'wpex_googleplus', $post->post_author ); ?>" title="Google Plus" class="google-plus" target="_blank"><span class="fa fa-google-plus"></span></a>
				<?php }
				// Display Linkedin url
				if ( get_the_author_meta( 'wpex_linkedin', $post->post_author ) ) { ?>
					<a href="<?php echo get_the_author_meta( 'wpex_linkedin', $post->post_author ); ?>" title="LinkedIn" class="linkedin" target="_blank"><span class="fa fa-linkedin"></span></a>
				<?php }
				// Display pinterest plus url
				if ( get_the_author_meta( 'wpex_pinterest', $post->post_author ) ) { ?>
					<a href="<?php echo get_the_author_meta( 'wpex_pinterest', $post->post_author ); ?>" title="Pinterest" class="pinterest" target="_blank"><span class="fa fa-pinterest"></span></a>
				<?php }
				// Display instagram plus url
				if ( get_the_author_meta( 'wpex_instagram', $post->post_author ) ) { ?>
					<a href="<?php echo get_the_author_meta( 'wpex_instagram', $post->post_author ); ?>" title="Instagram" class="instagram" target="_blank"><span class="fa fa-instagram"></span></a>
				<?php } ?>
			</div><!-- .author-bio-social -->
		<?php endif; ?>
	</div><!-- .author-info-inner -->
</div><!-- .author-info -->