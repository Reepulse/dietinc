<?php
/**
 * Easily add colors to your categories
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.4
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Category_Colors' ) ) {
	
	class WPEX_Category_Colors {

		/**
		 * Main constructor
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			add_action( 'admin_footer', array( $this, 'color_picker_js' ) );
			add_action ( 'edit_category_form_fields', array( $this, 'edit_category_form_fields' ) );
			add_action ( 'edited_category', array( $this, 'edited_category' ) );
			add_action( 'wp_head', array( $this, 'output_css' ) );
			add_filter( 'manage_edit-category_columns', array( $this, 'admin_columns' ) );
			add_filter( 'manage_category_custom_column', array( $this, 'admin_column' ), 10, 3 );
		}

		/**
		 * Loads color picker scripts
		 *
		 * @access public
		 * @since  1.0.4
		 */
		public function admin_enqueue_scripts() {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
		}

		/**
		 * Color picker js
		 *
		 * @access public
		 * @since  1.0.4
		 */
		public function color_picker_js() {
  			echo '<script>jQuery(function($){$(".wpex-colorpicker").wpColorPicker();});</script>';
		}

		/**
		 * Adds new category fields
		 *
		 * @access public
		 * @since  1.0.4
		 */
		public function edit_category_form_fields( $tag ) {

			// Get term id
			$term_id = $tag->term_id;

			// Category Color
			$cat_colors = get_option( "wpex_category_colors" );
			$cat_color = isset( $cat_colors[$term_id] ) ? $cat_colors[$term_id] : ''; ?>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="wpex_term_style"><?php _e( 'Color', 'chic' ); ?></label></th>
				<td><input type="text" name="wpex_category_color" id="wpex_category_color" value="<?php echo $cat_color; ?>" class="wpex-colorpicker"></td>
			</tr>

		<?php  }

		/**
		 * Saves new category fields
		 *
		 * @access public
		 * @since  1.0.4
		 */
		public function edited_category( $term_id ) {
			if ( isset( $_POST['wpex_category_color'] ) ) {
				$cat_colors = get_option( 'wpex_category_colors' );
				$cat_colors[$term_id] = $_POST['wpex_category_color'];
				if ( $cat_colors ) {
					update_option( 'wpex_category_colors', $cat_colors );
				}
			}
		}

		/**
		 * Outputs custom CSS for the category colors
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function output_css() {

			// Get colors
			$colors = get_option( 'wpex_category_colors' );

			// Validate
			if ( empty( $colors ) || ! is_array( $colors ) ) {
				return;
			}

			// Declare vars
			$css            = '';
			$target_element = apply_filters( 'wpex_category_colors_target_element', '.wpex-accent-bg' );
			$target_style   = apply_filters( 'wpex_category_colors_target_style', 'background' );

			// Loop through colors
			foreach( $colors as $term_id => $color ) {
				$css .= '.wpex-term-'. $term_id . $target_element .'{';
					$css .= $target_style .':'. $color .';';
				$css .= '}';
			}
			
			// Return CSS
			if ( ! empty( $css ) ) {
				$css = '<style type="text/css">/*CATEGORY COLORS*/'. $this->minify_css( $css ) .'</style>';
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

		/**
		 * Thumbnail column added to category admin.
		 *
		 * @access public
		 * @since  2.1.0
		 */
		public function admin_columns( $columns ) {
			$columns['wpex-category-color-col'] = __( 'Color', 'chic' );
			return $columns;
		}

		/**
		 * Thumbnail column value added to category admin.
		 *
		 * @access public
		 * @since  2.1.0
		 */
		public function admin_column( $columns, $column, $id ) {

			if ( 'wpex-category-color-col' == $column ) {

				// Get colors
				$colors = get_option( 'wpex_category_colors' );
				$color = isset( $colors[$id] ) ? $colors[$id] : '';

				// Display color
				if ( $color ) {
					echo '<div style="background:'. $color .';height:20px;width:20px;"></div>';
				} else {
					echo '&ndash;';
				}

			}

			// Return columns
			return $columns;

		}

	}

}
$wpex_category_colors = new WPEX_Category_Colors();