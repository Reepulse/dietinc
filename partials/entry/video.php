<?php
/**
 * Displays the entry video
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

// Display thumbnail
if ( get_theme_mod( 'entry_thumbnail', true ) && has_post_thumbnail() ) : ?>

	<div class="wpex-loop-entry-thumbnail wpex-loop-entry-media wpex-clr">

		<a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>">
			<?php the_post_thumbnail( 'entry' ); ?>
			<span class="wpex-loop-entry-video-tag fa fa-video-camera"></span>
		</a>

	</div><!-- .wpex-loop-entry-thumbnail -->

<?php endif; ?>

<?php
/*** Display Video Instead of Thumbnail */
return;

// Get video
$video = get_post_meta( get_the_ID(), 'wpex_post_video', true );

// Check what type of video it is
$type = wpex_check_meta_type( $video );

// Sanitize Return output
if ( 'iframe' == $type || 'embed' == $type ) {
    $video = wpex_sanitize( $video, 'video' ); // Sanitize video, see @ inc/core-functions.php
} else {
    $video = wp_oembed_get( $video );
} ?>

<?php if ( $video ) : ?>

    <div class="wpex-loop-entry-video wpex-loop-entry-media wpex-responsive-embed wpex-clr">
        <?php echo $video; ?>
    </div><!-- .wpex-loop-entry-video -->
    
<?php endif; ?>