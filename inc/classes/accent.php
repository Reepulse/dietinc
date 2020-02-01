<?php
/**
 * Adds custom CSS to the site to tweak the main accent colors
 *
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Accent_Class' ) ) {
	
	class WPEX_Accent_Class {

		/**
		 * Main constructor
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function __construct() {
			$this->default_accent = apply_filters( 'wpex_default_accent', null );
			add_action( 'wp_head', array( $this, 'generate' ), 10 );
		}

		/**
		 * Generates arrays of elements to target
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function arrays( $return ) {

			// Define arrays
			$texts       = apply_filters( 'wpex_accent_texts', array() );
			$backgrounds = apply_filters( 'wpex_accent_backgrounds', array() );
			$borders     = apply_filters( 'wpex_accent_borders', array() );

			// Return array
			if ( 'texts' == $return ) {
				return $texts;
			} elseif ( 'backgrounds' == $return ) {
				return $backgrounds;
			} elseif ( 'borders' == $return ) {
				return $borders;
			}

		}

		/**
		 * Generates the CSS output
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function generate() {

			// Get custom accent
			$accent        = get_theme_mod( 'accent_color' );
			$custom_accent = get_theme_mod( 'custom_accent_color' );
			$accent        = $custom_accent ? $custom_accent : $accent;
			$get           = ( ! empty( $_GET['theme_accent'] ) ) ? $_GET['theme_accent'] : null;

			// Check browser for accent
			if ( $get && 'default' != $get ) {
				$accent = $get;
			}

			// Return if there isn't any accent
			if ( ! $accent || 'default' == $accent || $this->default_accent == $accent ) {
				return;
			}

			// Sanitize
			$accent = str_replace( '#', '', $accent );
			$accent = '#'. $accent;

			// Define css var
			$css = '';

			// Get arrays
			$texts       = $this->arrays( 'texts' );
			$backgrounds = $this->arrays( 'backgrounds' );
			$borders     = $this->arrays( 'borders' );

			// Texts
			if ( ! empty( $texts ) ) {
				$css .= implode( ',', $texts ) .'{color:'. $accent .';}';
			}

			// Backgrounds
			if ( ! empty( $backgrounds ) ) {
				$css .= implode( ',', $backgrounds ) .'{background-color:'. $accent .';}';
			}

			// Borders
			if ( ! empty( $borders ) ) {
				foreach ( $borders as $key => $val ) {
					if ( is_array( $val ) ) {
						$css .= $key .'{';
						foreach ( $val as $key => $val ) {
							$css .= 'border-'. $val .'-color:'. $accent .';';
						}
						$css .= '}'; 
					} else {
						$css .= $val .'{border-color:'. $accent .';}';
					}
				}
			}
			
			// Return CSS
			if ( ! empty( $css ) ) {
				$css = '<style type="text/css">/*ACCENT COLOR*/'. $this->minify_css( $css ) .'</style>';
			}

			// Return output css
			echo $css;

		}

		/**
		 * Minify css
		 *
		 * @access public
		 * @since  1.0.0
		 */
		function minify_css( $css ) {

			if ( $css ) {

				// Normalize whitespace
				$css = preg_replace( '/\s+/', ' ', $css );

				// Remove ; before }
				$css = preg_replace( '/;(?=\s*})/', '', $css );

				// Remove space after , : ; { } */ >
				$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

				// Remove space before , ; { }
				$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

				// Strips leading 0 on decimal values (converts 0.5px into .5px)
				$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

				// Strips units if value is 0 (converts 0px to 0)
				$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

				// Trim
				$css = trim( $css );

				// Return minified CSS
				return $css;

			}
			
		}

	}

}
$wpex_accent_class = new WPEX_Accent_Class();