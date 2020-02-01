<?php
/**
 * Tweaks for WooCommerce
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

/**
 * Configures WooCommerce for this theme
 *
 * @since 1.0.0
 */
if ( ! class_exists( 'WPEX_WooCommerce_Setup' ) ) {

	class WPEX_WooCommerce_Setup {

		/**
		 * Start things up
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Add support
			add_theme_support( 'woocommerce' );

			// Filters
			add_filter( 'wpex_post_layout', array( $this, 'post_layouts' ), 20 );
			add_filter( 'loop_shop_per_page', array( $this, 'loop_shop_per_page' ), 20 );
			add_filter( 'woocommerce_pagination_args', array( $this, 'pagination_args' ) );
			add_filter( 'loop_shop_columns', array( $this, 'loop_shop_columns' ), 1, 10 );
			add_filter( 'woocommerce_cross_sells_columns', array( $this, 'loop_shop_columns' ) );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
			add_filter( 'woocommerce_show_page_title', array( $this, 'woocommerce_show_page_title' ) );
			add_filter( 'woocommerce_sale_flash', array( $this, 'custom_sale_flash' ), 10, 3 );
			add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'product_thumbnails_columns' ) );
			add_filter( 'post_class', array( $this, 'add_product_entry_classes' ) );
			add_filter( 'post_class', array( $this, 'add_product_entry_classes' ) );
			add_filter( 'product_cat_class', array( $this, 'product_cat_class' ), 10, 3 );

			// Remove actions
			remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

			// Add actions
			add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'remove_scripts' ), 99 );
			add_action( 'woocommerce_before_single_product_summary', array( $this, 'single_product_boxed_container_open' ), 5 );
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'single_product_boxed_container_close' ), 11 );
			add_action( 'wpex_page_after_boxed_container', array( $this, 'woocommerce_cross_sell_display' ) );
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'upsell_display' ), 15 );

		}

		/**
		 * Adds scripts
		 *
		 * @since 1.0.0
		 */
		public function add_scripts() {

			// Define css dir
			$css_dir_uri = get_template_directory_uri() .'/css/';

			// Main CSS
			wp_enqueue_style( 'wpex-woocommerce', $css_dir_uri .'wpex-woocommerce.css' );

			// Responsive CSS
			if ( wpex_is_responsive() ) {
				wp_enqueue_style( 'wpex-woocommerce-responsive', $css_dir_uri .'wpex-woocommerce-responsive.css' );
			}

			// Match Height JS
			if ( is_shop() || is_product() || is_cart() ) {
				wp_enqueue_script( 'match-height' );
			}

		}

		/**
		 * Remove scripts
		 *
		 * @since 1.0.0
		 */
		public function remove_scripts( $layout ) {
		 
			// Styles
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			 
			// Scripts
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_script( 'fancybox' );
			wp_dequeue_script( 'enable-lightbox' );

		}

		/**
		 * Alters woo layouts
		 *
		 * @since 1.0.0
		 */
		public function post_layouts( $layout ) {

			// Left sidebar for shop
			if ( function_exists( 'is_shop' ) && is_shop() ) {
				$layout = get_theme_mod( 'woo_shop_layout', 'right-sidebar' );
			}

			// Product
			elseif ( is_singular( 'product') ) {
				$layout = get_theme_mod( 'woo_product_layout', 'right-sidebar' );
			}

			// Product categories
			elseif ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) {
				$layout = get_theme_mod( 'woo_shop_layout', 'right-sidebar' );
			}

			// Full-width for WooCommerce cart
			elseif ( function_exists( 'is_cart' ) && is_cart() ) {
				$layout = 'full-width';
			}

			// Full-width for WooCommerc checkout
			elseif ( function_exists( 'is_checkout' ) && is_checkout() ) {
				$layout = 'full-width';
			}

			// Return layout
			return $layout;
		}

		/**
		 * Alters the number of products per page for the shop
		 *
		 * @since 1.0.0
		 */
		public function loop_shop_per_page() {
			$count = get_theme_mod( 'woo_shop_count', '12' );
			$count = $count ? $count : 12;
			return $count;
		}

		/**
		 * Alters the columns for the shop page
		 *
		 * @since 1.0.0
		 */
		public function loop_shop_columns() {
			if ( ! empty( $_GET['theme_shop_columns'] ) ) {
				return $_GET['theme_shop_columns'];
			}
			if ( is_cart() || is_checkout() ) {
				$cols = get_theme_mod( 'woo_cart_checkout_upsells_coluns', 4 );
			} else {
				$cols = get_theme_mod( 'woo_shop_columns', 3 );
			}
			$cols = apply_filters( 'wpex_woocommerce_product_columns', $cols );
			return $cols;
		}

		/**
		 * Alters the related items count and columns
		 *
		 * @since 1.0.0
		 */
		public function related_products_args( $args ) {
			$args['posts_per_page'] = wpex_get_theme_mod( 'woo_related_count', 3 );
			$args['columns'] = wpex_get_theme_mod( 'woo_related_columns', 3 );
			return $args;
		}

		/**
		 * Remove the shop page title
		 *
		 * @since 1.0.0
		 */
		public function woocommerce_show_page_title() {
			return get_theme_mod( 'woo_shop_title', false );
		}

		/**
		 * Change sale text
		 *
		 * @since 1.0.0
		 */
		public function custom_sale_flash( $text, $post, $_product ) {
		  return '<span class="onsale"> '. get_theme_mod( 'woo_sale_text', __( 'On Sale', 'chic' ) ) .' </span>';  
		}

		/**
		 * Change number of thumbnails columns on product page
		 *
		 * @since 1.0.0
		 */
		public function product_thumbnails_columns( $number ){
			return 4;
		}

		/**
		 * Open Div before product summary
		 *
		 * @since 1.0.0
		 */
		public function single_product_boxed_container_open(){
			echo '<div class="product-wrapper wpex-boxed-container wpex-clr">';
		}

		/**
		 * Close div after product summary
		 *
		 * @since 1.0.0
		 */
		public function single_product_boxed_container_close(){
			echo '</div>';
		}

		/**
		 * Add classes to WooCommerce product entries.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @link   http://codex.wordpress.org/Function_Reference/post_class
		 */
		public function add_product_entry_classes( $classes ) {
			global $product, $woocommerce_loop;
			if ( $product && $woocommerce_loop ) {
				$classes[] = 'wpex-col';
				$classes[] = 'wpex-col-'. $woocommerce_loop['columns'];
			}
			return $classes;
		}

		/**
		 * Add classes to WooCommerce product entries.
		 *
		 * @since  1.1.5
		 * @access public
		 */
		public function product_cat_class( $classes, $class, $category ) {
			global $woocommerce_loop;
			$columns = isset( $woocommerce_loop['columns'] ) ? $woocommerce_loop['columns'] : 3;
			$classes[] = 'wpex-col';
			$classes[] = 'wpex-col-'. $woocommerce_loop['columns'];
			return $classes;
		}

		/**
		 * Tweaks pagination arguments
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function pagination_args( $args ) {
			$args['prev_text'] = '<i class="fa fa-angle-left"></i>';
			$args['next_text'] = '<i class="fa fa-angle-right"></i>';
			return $args;
		}

		/**
		 * Change products per row for upsells.
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function upsell_display() {
			woocommerce_upsell_display(
				wpex_get_theme_mod( 'woo_upsells_count', 3 ),
				wpex_get_theme_mod( 'woo_upsells_columns', 3 )
			);
		}

		/**
		 * Displays cross-sells in the correct location
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function woocommerce_cross_sell_display() {
			if ( function_exists( 'is_cart' ) && is_cart() ) { ?>
				<div class="woocommerce wpex-clr">
					<?php woocommerce_cross_sell_display(); ?>
				</div>
			<?php }
		}

		/**
		 * Change products per row for crossells.
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function cross_sell_display() {
			woocommerce_cross_sell_display(
				wpex_get_theme_mod( 'woo_cross_sells_count', 4 ),
				wpex_get_theme_mod( 'woo_cross_sells_columns', 4 )
			);
		}

		/**
		 * Add cart fragments
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function cart_fragments( $fragments ) {
			$fragments['.wpex-menu-woocart-link'] = wpex_menu_woocart_link();
			return $fragments;
		}

	}
}
$wpex_woocommerce_setup = new WPEX_WooCommerce_Setup;

// Add to cart menu link
if ( ! function_exists( 'wpex_menu_woocart_link' ) ) {
	function wpex_menu_woocart_link() {
		if ( 'link_to_cart' == get_theme_mod( 'menu_shop_type', 'cart_dropdown' ) ) {
			$url = get_permalink( wc_get_page_id( 'cart' ) );
		} elseif( get_permalink( wc_get_page_id( 'shop' ) ) ) {
			$url = get_permalink( wc_get_page_id( 'shop' ) );
		} else {
			$url = '#';
		}
		$output = '';
		$count  = WC()->cart->cart_contents_count;
		$output .= '<a href="'. $url .'" title="'. __( 'Shopping Cart', 'chic' ) .'" class="wpex-menu-woocart-link">
			<span class="fa fa-shopping-cart"></span>';
			if ( $count > 0 ) {
				$output .= '<span class="wpex-shop-icon-count">'. $count .'</span>';
			}
		$output .= '</a>';
		return $output;
	}
}