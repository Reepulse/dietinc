<?php
/**
 * Site Notice Bar
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

// Add class based on cookie
if ( isset( $_COOKIE['wpex-notice-bar'] ) && 'hide' == $_COOKIE['wpex-notice-bar'] && ! is_customize_preview() ) {
	$show = '';
} else {
	$show = ' show';
}

// Get content
$content = wpex_get_notice_bar_content();

// Display if there is notice content
if ( $content ) : ?>

	<div class="wpex-notice-bar wpex-clr<?php echo $show; ?>">
		<div class="wpex-container wpex-clr">
			<?php echo do_shortcode( $content ); ?>
		</div><!-- .container -->
		<span class="fa fa-times wpex-notice-bar-toggle hide-bar"></span>
	</div><!-- .wpex-notice-bar -->
	
<?php endif; ?>