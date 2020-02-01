<?php
/**
 * Adds meta options for categories
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.1.3
 */

// Only needed for the admin side
if ( ! is_admin() ) {
	return;
}

global $wpex_category_meta;

// Start Class
if ( ! class_exists( 'WPEX_Category_Meta' ) ) {
	
	class WPEX_Category_Meta {
		private $settings;

		/**
		 * Main constructor
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function __construct() {

			// Define settings array
			$this->settings = array(
				'wpex_post_layout' => array(
					'name' => esc_html__( 'Layout', 'chic' ),
					'type' => 'dropdown',
					'choices' => array(
						''              => __( 'Default', 'chic' ),
						'right-sidebar' => __( 'Right Sidebar', 'chic' ),
						'left-sidebar'  => __( 'Left Sidebar', 'chic' ),
						'full-width'    => __( 'No Sidebar', 'chic' ),
					),
				),
				'wpex_loop_columns' => array(
					'name'    => esc_html__( 'Columns', 'chic' ),
					'type'    => 'dropdown',
					'choices' => array(
						'' => __( 'Default', 'chic' ),
						1  => 1,
						2  => 2,
						3  => 3,
						4  => 4,
					),
				),
				'wpex_excerpt_length' => array(
					'name' => esc_html__( 'Excerpt Length', 'chic' ),
					'type' => 'textfield',
				),
			);

			// Add/save meta options
			add_action( 'init', array( $this, 'register_meta' ) );
			add_action ( 'edit_category_form_fields', array( $this, 'edit_category_form_fields' ) );
			add_action ( 'edited_category', array( $this, 'edited_category' ) );

		}

		/**
		 * Adds new category meta data
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function register_meta() {
			$settings = $this->settings;
			foreach ( $settings as $key => $val ) {
				register_meta( 'term', $key, array( $this, 'sanitize_meta' ) );
			}
		}

		/**
		 * Sanitize meta input
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public static function sanitize_meta( $data ) {
			return esc_html( $data );
		}

		/**
		 * Adds new category fields
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function edit_category_form_fields( $tag ) {

			// Nonce security check
			wp_nonce_field( 'wpex_category_meta_nonce', 'wpex_category_meta_nonce' );

			// Get term id
			$term_id = $tag->term_id;

			// Get settings
			$settings = $this->settings;

			// Loop through settings
			foreach ( $settings as $key => $val ) {

				// Get setting data
				$name = $val['name'];
				$type = isset( $val['type'] ) ? $val['type'] : 'textfield';
				$meta = get_term_meta( $term_id, $key, true );

				// Text field
				if ( 'textfield' == $type ) { ?>

					<tr class="form-field">
						<th scope="row" valign="top"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_attr( $name ); ?></label></th>
						<td><input type="text" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $meta ); ?>"></td>
					</tr>

				<?php }

				// Dropdown
				elseif ( 'dropdown' == $type ) {

					// Get choices
					$choices = isset( $val['choices'] ) ? $val['choices'] : '';

					// Display dropdown
					if ( $choices ) { ?>

						<tr class="form-field">
							<th scope="row" valign="top"><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_attr( $name ); ?></label></th>
							<td>
								<select name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>">
									<?php foreach( $choices as $ckey => $cval ) { ?>
										<option value="<?php echo esc_attr( $ckey ); ?>" <?php selected( $meta, $ckey ); ?>><?php echo esc_attr( $cval ); ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>

					<?php }

				}

			}
			
		}

		/**
		 * Saves new category fields
		 *
		 * @access public
		 * @since  1.0.0
		 */
		public function edited_category( $term_id ) {

			// Make sure everything is secure
			if ( ! wp_verify_nonce( $_POST['wpex_category_meta_nonce'], 'wpex_category_meta_nonce' ) ) {
				return;
			}

			// Get settings
			$settings = $this->settings;

			// Loop through settings and save values
			foreach ( $settings as $key => $val ) {

				// Get setting value
				$value = isset( $_POST[$key] ) ? esc_html( $_POST[$key] ) : '';

				// Save setting
				if ( $value ) {
					update_term_meta( $term_id, $key, $value );
				}

				// Delete setting
				else {
					delete_term_meta( $term_id, $key );
				}

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
				$color = wpex_get_category_color( $id );

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
$wpex_category_meta = new WPEX_Category_Meta();