<?php
/**
 * Top header navigation
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

// Location ID
$location = 'main';

// Nav position
$full_nav = wpex_has_full_nav();

// Check to make sure menu isn't empty
if ( has_nav_menu( $location ) ) : ?>

	<nav class="wpex-site-nav wpex-clr">

		<?php
		// Add container if needed
		if ( $full_nav ) { ?>

			<div class="wpex-site-nav-container wpex-container wpex-clr">

		<?php } ?>

			<?php
			// Display nav
			wp_nav_menu( array(
				'theme_location'  => $location,
				'fallback_cb'     => false,
				'container_class' => null,
				'menu_class'      => 'wpex-dropdown-menu',
				'walker'          => new WPEX_Dropdown_Walker_Nav_Menu,
			) ); ?>

			<?php
			// Add header search
			get_template_part( 'partials/header/search' ); ?>

		<?php
		// Close container if needed
		if ( $full_nav ) { ?>

			<?php get_template_part( 'partials/header/nav-aside' ); ?>

			<?php
			// Add WooCommerce cart widget
			if ( WPEX_WOOCOMMERCE_ACTIVE ) : ?>

				<?php get_template_part( 'partials/woocommerce/cart' ); ?>
				
			<?php endif; ?>

			</div><!-- .wpex-container -->

		<?php } ?>

	</nav><!-- .wpex-site-nav -->

	<div class="wpex-sidr-close-toggle display-none">
		<div class="wpex-sidr-close-toggle">
			<span class="fa fa-times"></span>
		</div>
	</div>

<?php endif; ?>