<?php
/**
 * The sidebar containing the woocommerce widget area.
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

if ( is_active_sidebar( 'sidebar_woocommerce' ) && 'full-width' != wpex_get_post_layout() ) : ?>

	<aside class="wpex-sidebar wpex-clr" role="complementary">

		<div class="wpex-widget-area">

			<?php dynamic_sidebar( 'sidebar_woocommerce' ); ?>

		</div><!-- .wpex-widget-area -->

	</aside><!-- .wpex-sidebar -->

<?php endif; ?>