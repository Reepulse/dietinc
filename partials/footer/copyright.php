<?php
/**
 * Footer copyright
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

// Get copyright data
$copy = get_theme_mod( 'footer_copyright', '<a href="http://www.wordpress.org" title="WordPress" target="_blank">WordPress</a> Theme Designed &amp; Developed by <a href="http://www.wpexplorer.com/" target="_blank" title="WPExplorer">WPExplorer</a>' );
$copy = wpex_sanitize( $copy, 'html' ); // Sanitize output, see inc/core-functions.php

// Display copyright
if ( $copy ) : ?>

	<div class="footer-copyright wpex-clr">

		<?php echo do_shortcode( $copy ); ?>

	</div><!-- .footer-copyright -->

<?php endif; ?>