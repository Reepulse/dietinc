<?php
/**
 * Outputs the header navigation
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

if ( wpex_has_header_search() ) : ?>

	<div class="wpex-header-searchform wpex-invisible wpex-clr">
		<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
			<input type="search" name="s" placeholder="<?php _e( 'Search', 'chic' ); ?>&hellip;" onfocus="this.placeholder = ''" />
			<button type="submit" class="wpex-header-searchform-submit"><span class="fa fa-search"></span></button>
		</form>
	</div><!-- .wpex-header-searchform -->

<?php endif; ?>