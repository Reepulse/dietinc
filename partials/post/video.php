<?php
/**
 * Displays the post video
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

// Get video
$video = get_post_meta( get_the_ID(), 'wpex_post_video', true );

// Check what type of video it is
$type = wpex_check_meta_type( $video );

// Return output
if ( 'iframe' == $type || 'embed' == $type ) {
	$video = wpex_sanitize( $video, 'video' ); // Sanitize video, see @ inc/core-functions.php
} else {
	$video = wp_oembed_get( $video );
} ?>

<?php if ( $video ) : ?>

	<div class="wpex-post-video wpex-responsive-embed wpex-clr">
		<?php echo $video; ?>
	</div><!-- .wpex-post-video -->
	
<?php endif; ?>