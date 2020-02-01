<?php
/**
 * Single bottom advertisement region
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

// Get ad
$ad = '<img src="'. get_template_directory_uri() .'/images/750x90.jpg" alt="'. __( 'Banner', 'chic' ) .'" />';
$ad = get_theme_mod( 'ad_single_bottom', $ad );

if ( $ad ) : ?>

	<div class="wpex-ad-region wpex-single-bottom">
		<?php echo do_shortcode( $ad ); ?>
	</div><!-- .wpex-ad-region -->

<?php endif; ?>