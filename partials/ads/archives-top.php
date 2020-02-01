<?php
/**
 * Archives top advertisement region
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
if ( is_home() || is_front_page() || is_page_template( 'templates/home-categories.php' ) ) {
	$ad = '<img src="'. get_template_directory_uri() .'/images/750x90.jpg" alt="'. __( 'Banner', 'chic' ) .'" />';
	$ad = get_theme_mod( 'ad_homepage_top', $ad );
} else {
	$ad = get_theme_mod( 'ad_archives_top', null );
}

if ( $ad ) : ?>

	<div class="wpex-ad-region wpex-archives-top">
		<?php echo do_shortcode( $ad ); ?>
	</div><!-- .wpex-ad-region wpex-archives-top -->

<?php endif; ?>