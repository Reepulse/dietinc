<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

// Return if it is full-width
if ( 'full-width' == wpex_get_post_layout() ) {
	return;
}

// Display WooSidebar as needed
if ( wpex_is_woocommerce_active()
	&& is_active_sidebar( 'sidebar_woocommerce' )
	&& ( is_shop() || is_cart() || is_checkout() )
) :

	get_sidebar( 'woocommerce' );
	return;

// Display default sidebar
elseif ( is_active_sidebar( 'sidebar' ) ) : ?>

	<aside class="wpex-sidebar wpex-clr" role="complementary">

		<div class="wpex-widget-area">

			<?php dynamic_sidebar( 'sidebar' ); ?>

		</div><!-- .wpex-widget-area -->

	</aside><!-- .wpex-sidebar -->

<?php endif; ?>