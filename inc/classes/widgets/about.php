<?php
/**
 * About widget
 *
 * @author      Alexander Clarke
 * @copyright   Copyright (c) 2015, WPExplorer.com
 * @link        http://www.wpexplorer.com
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// Start widget class
if ( ! class_exists( 'WPEX_About_Widget' ) ) {

	class WPEX_About_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			parent::__construct(
				'wpex_about',
				$name = __( 'Chic - About', 'chic' ),
				array(
					'description'   => __( 'Simple about widget.', 'chic' ),
				)
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 * @since 1.0.0
		 *
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {

			// Extract args
			extract( $args );

			// Args
			$title       = isset( $instance['title'] ) ? $instance['title'] : '';
			$title       = apply_filters( 'widget_title', $title );
			$image       = isset( $instance['image'] ) ? esc_url( $instance['image'] ) : '';
			$description = isset( $instance['description'] ) ? $instance['description'] : '';

			// Before widget hook
			echo $before_widget; ?>

				<?php
				// Display widget title
				if ( $title ) {
					echo $before_title . $title . $after_title;
				} ?>

				<div class="wpex-about-widget wpex-clr">

					<?php
					// Display the image
					if ( $image ) : ?>

						<div class="wpex-about-widget-image">
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
						</div><!-- .wpex-about-widget-description -->

					<?php endif; ?>

					<?php
					// Display the description
					if ( $description ) : ?>

						<div class="wpex-about-widget-description">
							<?php echo $description; ?>
						</div><!-- .wpex-about-widget-description -->

					<?php endif; ?>

				</div><!-- .mailchimp-widget -->

			<?php
			// After widget hook
			echo $after_widget;
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 * @since 1.0.0
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance                = $old_instance;
			$instance['title']       = strip_tags( $new_instance['title'] );
			$instance['image']       = strip_tags( $new_instance['image'] );
			$instance['description'] = wpex_sanitize( strip_tags( $new_instance['description'] ), 'html' );
			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 * @since 1.0.0
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			$instance = wp_parse_args( ( array ) $instance, array(
				'title'       => __( 'About Me', 'chic' ),
				'image'       => '',
				'description' => '',

			) );
			$title       = esc_attr( $instance['title'] );
			$image       = esc_attr( $instance['image'] );
			$description = esc_attr( $instance['description'] ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'chic' ); ?>:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title','chic' ); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Image URL', 'chic' ); ?>:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image','chic' ); ?>" type="text" value="<?php echo $image; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:','chic' ); ?></label>
				<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo $instance['description']; ?></textarea>
			</p>
			<?php
		}
	}
}

// Register the WPEX_Tabs_Widget custom widget
if ( ! function_exists( 'wpex_register_about_widget' ) ) {
	function wpex_register_about_widget() {
		register_widget( 'WPEX_About_Widget' );
	}
}
add_action( 'widgets_init', 'wpex_register_about_widget' );