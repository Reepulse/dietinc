<?php
/**
 * Menu aside content
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
} ?>

<div class="wpex-nav-aside wpex-clr">

	<?php
	// Social icons
	$social_options = wpex_header_social_options_array();

	if ( $social_options ) {

		foreach( $social_options as $key => $val ) {

			$default = null;
			if ( 'twitter' == $key ) {
				$default = 'http://twitter.com/';
			} elseif ( 'facebook' == $key ) {
				$default = 'http://facebook.com/';
			} elseif ( 'instagram' == $key ) {
				$default = 'http://instagram.com/';
			}

			$url    = esc_url( get_theme_mod( 'header_social_'. $key, $default ) );
			$target = 'blank' == get_theme_mod( 'header_social_target', 'blank' ) ? ' target="_blank"' : null;

			if ( $url ) { ?>

				<div class="wpex-nav-aside-social-link <?php echo $key; ?>">
					<a href="<?php echo $url; ?>" title="<?php echo esc_attr( $val['label'] ); ?>"<?php echo $target; ?>><span class="<?php echo $val['icon_class']; ?>"></span></a>
				</div>

			<?php }
		}
		
	}

	// Login
	if ( $page = wpex_get_theme_mod( 'menu_login_icon_page' ) ) {

		$page = ( 'wp_login' == $page ) ? wp_login_url() : get_permalink( $page );

		if ( is_customize_preview() || ! is_user_logged_in() ) { ?>

			<div class="wpex-nav-aside-login">
				<a href="<?php echo esc_url( $page ); ?>" title="<?php echo __( 'Login', 'chic' ); ?>">
					<span class="fa fa-user"></span>
				</a>
			</div>

		<?php }

	}

	// Cart
	if ( WPEX_WOOCOMMERCE_ACTIVE && function_exists( 'wpex_menu_woocart_link' ) ) {

		$menu_shop_type = get_theme_mod( 'menu_shop_type', 'cart_dropdown' );

		if ( 'disabled' != $menu_shop_type ) {
			$classes = 'wpex-nav-aside-shop wpex-menu-cart-toggle';
			if ( is_cart() || is_checkout() || 'link_to_shop' == $menu_shop_type ) {
				$classes .= 'toggle-disabled';
			} ?>

			<div class="<?php echo $classes; ?>">
				<?php echo wpex_menu_woocart_link(); ?>
			</div>

		<?php }
	}

	// Search Icon
	if ( wpex_has_header_search() ) { ?>

		<div class="wpex-nav-aside-search wpex-menu-search-toggle">
			<a href="#" class="wpex-toggle-menu-search" title="<?php echo __( 'Search', 'chic' ); ?>"><span class="fa fa-search"></span></a>
		</div>

	<?php } ?>

</div><!--. wpex-nav-aside -->