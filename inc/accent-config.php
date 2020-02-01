<?php
/**
 * Defines all settings for the customizer class
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

// Start Class
if ( ! class_exists( 'WPEX_Accent_Config' ) ) {
	
	class WPEX_Accent_Config {

		/**
		 * Main constructor
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function __construct() {
			add_filter( 'wpex_default_accent', array( $this, 'default_accent' ) );
			add_filter( 'wpex_accent_texts', array( $this, 'texts' ) );
			add_filter( 'wpex_accent_backgrounds', array( $this, 'backgrounds' ) );
			//add_filter( 'wpex_accent_borders', array( $this, 'borders' ) );
		}

		/**
		 * Define default accent
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function default_accent() {
			return '#f27684';
		}

		/**
		 * Create array of texts with accent color
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function texts( $array ) {
			$new = array(
				'a',
				'.wpex-site-nav .wpex-dropdown-menu a:hover',
				'.wpex-site-nav .wpex-dropdown-menu li.current-menu-item > a',
				'.wpex-site-nav .wpex-dropdown-menu li.parent-menu-item > a',
				'.wpex-site-nav .wpex-dropdown-menu >li.current-menu-ancestor > a',
				'.wpex-site-logo a:hover',
				'.centered-logo-full-nav .wpex-site-nav .wpex-dropdown-menu a:hover',
				'.wpex-footer-widgets a:hover',
			);
			$array = array_merge( $array, $new );
			return $array;
		}

		/**
		 * Create array of backgrounds with accent color
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function backgrounds( $array ) {
			$new = array(
				'button',
				'.wpex-theme-button',
				'.theme-button',
				'input[type="button"]',
				'input[type="submit"]',
				'.wpex-sidebar .widget_tag_cloud a',
				'a.site-scroll-top.show:hover',
				'.wpex-accent-bg',
				'.wpex-social-profiles-widget ul a',
				'.page-numbers a:hover',
				'.page-numbers span.current',
				'.page-links span, .page-links a span:hover',
				'.shop-carousel-wrap .lSSlideOuter .lSPager.lSpg > li:hover a',
				'.shop-carousel-wrap .lSSlideOuter .lSPager.lSpg > li.active a',
				'.footer-social-seperator',
				'a#cancel-comment-reply-link:hover',
				'.comment-footer a:hover',
				'a.wpex-site-scroll-top:hover',
				'.wpex-shop-carousel-wrap .lSSlideOuter .lSPager.lSpg > li.active a',
				'.wpex-footer-social-seperator',
				'.woocommerce nav.woocommerce-pagination .page-numbers a:hover',
				'.woocommerce nav.woocommerce-pagination .page-numbers span.current',
				'.woocommerce div.product form.cart .button',
				'.wpex-sidebar .widget_product_categories a',
				'.woocommerce #content input.button, .woocommerce #respond input#submit',
				'.woocommerce a.button, .woocommerce button.button',
				'.woocommerce input.button, .woocommerce-page #content input.button',
				'.woocommerce-page #respond input#submit, .woocommerce-page a.button',
				'.woocommerce-page button.button, .woocommerce-page input.button',
				'.woocommerce #respond input#submit.alt',
				'.woocommerce a.button.alt',
				'.woocommerce button.button.alt',
				'.woocommerce input.button.alt',
				'.wpex-page-links span',
				'.wpex-page-links a:hover',
				'.wpex-page-links a:hover span',
				'.wpex-page-links span:hover',
			);
			$array = array_merge( $array, $new );
			return $array;
		}

		/**
		 * Create array of borders with accent color
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function borders( $array ) {
			// None yet
		}

	}

}
$wpex_accent_config = new WPEX_Accent_Config();