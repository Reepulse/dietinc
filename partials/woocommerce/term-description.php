<?php
/**
 * WooCommerce term description
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

// Display term description
if ( term_description() ) : ?>

	<div class="wpex-term-description wpex-clr">
		<?php echo term_description(); ?>
	</div><!-- #wpex-term-description -->

<?php endif; ?>