<?php
/**
 * Footer social
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

// Display footer social
if ( $social_options = wpex_footer_social_options_array() ) : ?>

	<div class="wpex-footer-social wpex-clr">

		<?php
		// Loop through social options
		foreach( $social_options as $key => $val ) :

			// Set defaults
			$default = null;
			if ( 'twitter' == $key ) {
				$default = 'http://twitter.com/';
			} elseif ( 'facebook' == $key ) {
				$default = 'http://facebook.com/';
			} elseif ( 'instagram' == $key ) {
				$default = 'http://instagram.com/';
			} elseif ( 'youtube' == $key ) {
				$default = 'http://youtube.com/';
			} elseif ( 'rss' == $key ) {
				$default = home_url() .'/rss/';
			}

			// Get url
			$url = get_theme_mod( 'footer_social_'. $key, $default );

			// Sanitize URL
			$url = esc_url( $url );

			// Display social link if url is defined
			if ( $url ) : ?>

				<a href="<?php echo $url; ?>" class="social-option <?php echo $key; ?>" title="<?php echo esc_attr( $val['label'] ); ?>" target="_blank"><span class="<?php echo $val['icon_class']; ?>"></span> <?php echo esc_attr( $val['label'] ); ?></a>

			<?php endif; ?>

		<?php endforeach; ?>

	</div><!-- .footer-social -->

	<span class="wpex-footer-social-seperator"></span>

<?php endif; ?>