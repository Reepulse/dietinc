<?php
/**
 * Recent Posts w/ Thumbnails
 *
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// Start widget class
if ( ! class_exists( 'WPEX_Mailchimp_Widget' ) ) {
	class WPEX_Mailchimp_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			parent::__construct(
				'wpex_mailchimp',
				$name = __( 'Chic - Mailchimp', 'chic' ),
				array(
					'description'   => __( 'Simple mailchimp widget.', 'chic' ),
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
			$title            = isset( $instance['title'] ) ? $instance['title'] : '';
			$title            = apply_filters( 'widget_title', $title );
			$heading          = isset( $instance['heading'] ) ? $instance['heading'] : '';
			$email_holder_txt = ! empty( $instance['placeholder_text'] ) ? $instance['placeholder_text'] : '';
			$email_holder_txt = $email_holder_txt ? $email_holder_txt : __( 'Your email address', 'chic' );
			$name_field       = ! empty( $instance['name_field'] ) ? true : false;
			$name_holder_txt  = ! empty( $instance['name_placeholder_text'] ) ? $instance['name_placeholder_text'] : '';
			$name_holder_txt  = $name_holder_txt ? $name_holder_txt : __( 'First name', 'chic' );
			$button_text      = ! empty( $instance['button_text'] ) ? $instance['button_text'] : __( 'Subscribe', 'chic' );
			$form_action      = isset( $instance['form_action'] ) ? $instance['form_action'] : '';
			$description      = isset( $instance['description'] ) ? $instance['description'] : '';

			// Before widget hook
			echo $before_widget; ?>

				<?php
				// Display widget title
				if ( $title ) {
					echo $before_title . $title . $after_title;
				} ?>

				<?php if ( $form_action ) { ?>

					<div class="wpex-newsletter-widget wpex-clr">

						<?php
						// Display the heading
						if ( $heading ) { ?>

							<h4 class="wpex-newsletter-widget-heading">
								<?php echo wpex_sanitize( $heading, 'html' ); ?>
							</h4>

						<?php } ?>

						<?php
						// Display the description
						if ( $description ) { ?>

							<div class="wpex-newsletter-widget-description">
								<?php echo wpex_sanitize( $description, 'html' ); ?>
							</div>

						<?php } ?>

							<form action="<?php echo $form_action; ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>

								<?php if ( $name_field ) : ?>
									<input type="text" value="<?php echo $name_holder_txt; ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" name="FNAME" id="mce-FNAME" autocomplete="off">
								<?php endif; ?>

								<input type="email" value="<?php echo $email_holder_txt; ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" name="EMAIL" id="mce-EMAIL" autocomplete="off">

								<?php echo apply_filters( 'wpex_mailchimp_widget_form_extras', null ); ?>

								<button type="submit" value="" name="subscribe">
									<?php echo $button_text; ?>
								</button>
							</form>

					</div><!-- .mailchimp-widget -->

				<?php } else { ?>

					<?php _e( 'Please enter your Mailchimp form action link.', 'chic' ); ?>

				<?php } ?>

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
			$instance = $old_instance;
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['heading'] = strip_tags( $new_instance['heading'] );
			$instance['description'] = wpex_sanitize( strip_tags( $new_instance['description'] ), 'html' );
			$instance['form_action'] = strip_tags( $new_instance['form_action'] );
			$instance['placeholder_text'] = strip_tags( $new_instance['placeholder_text'] );
			$instance['button_text'] = strip_tags( $new_instance['button_text'] );
			$instance['name_field'] = $new_instance['name_field'] ? 1 : 0;
			$instance['name_placeholder_text'] = strip_tags( $new_instance['name_placeholder_text'] );
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
				'title'                 => '',
				'heading'               => __( 'Newsletter','chic' ),
				'description'           => '',
				'form_action'           => '',
				'placeholder_text'      => __( 'Your email address', 'chic' ),
				'button_text'           => __( 'Subscribe', 'chic' ),
				'name_placeholder_text' => __( 'First name', 'chic' ),
				'name_field'            => 0

			) );
			$title                 = esc_attr( $instance['title'] );
			$heading               = esc_attr( $instance['heading'] );
			$description           = esc_attr( $instance['description'] );
			$form_action           = esc_attr( $instance['form_action'] );
			$placeholder_text      = esc_attr( $instance['placeholder_text'] ); 
			$button_text           = esc_attr( $instance['button_text'] );
			$name_placeholder_text = esc_attr( $instance['name_placeholder_text'] );
			$name_field            = $instance['name_field']; ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'chic' ); ?>:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title','chic' ); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'heading' ); ?>"><?php _e( 'Heading', 'chic' ); ?>:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'heading' ); ?>" name="<?php echo $this->get_field_name( 'heading','chic' ); ?>" type="text" value="<?php echo $heading; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'form_action' ); ?>"><?php _e( 'Form Action', 'chic' ); ?>:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'form_action' ); ?>" name="<?php echo $this->get_field_name( 'form_action' ); ?>" type="text" value="<?php echo $form_action; ?>" />
				<span style="display:block;padding:5px 0" class="description">
					<a href="http://docs.shopify.com/support/configuration/store-customization/where-do-i-get-my-mailchimp-form-action?ref=wpexplorer" target="_blank"><?php _e( 'Learn more', 'chic' ); ?>&rarr;</a>
				</span>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:','chic' ); ?></label>
				<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo $instance['description']; ?></textarea>
			</p>
			<p>
				<input id="<?php echo $this->get_field_id( 'name_field' ); ?>" name="<?php echo $this->get_field_name( 'name_field','chic' ); ?>" <?php checked( $name_field, 1, true ); ?> type="checkbox" />
				<label for="<?php echo $this->get_field_id( 'name_field' ); ?>"><?php _e( 'Display Name Field?', 'chic' ); ?></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'name_placeholder_text' ); ?>"><?php _e( 'Name Input Placeholder Text', 'chic' ); ?>:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'name_placeholder_text' ); ?>" name="<?php echo $this->get_field_name( 'name_placeholder_text','chic' ); ?>" type="text" value="<?php echo $name_placeholder_text; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'placeholder_text' ); ?>"><?php _e( 'Email Input Placeholder Text', 'chic' ); ?>:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'placeholder_text' ); ?>" name="<?php echo $this->get_field_name( 'placeholder_text','chic' ); ?>" type="text" value="<?php echo $placeholder_text; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Button Text', 'chic' ); ?>:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text','chic' ); ?>" type="text" value="<?php echo $button_text; ?>" />
			</p>
			<?php
		}
	}
}

// Register the WPEX_Tabs_Widget custom widget
if ( ! function_exists( 'wpex_register_mailchimp_widget' ) ) {
	function wpex_register_mailchimp_widget() {
		register_widget( 'WPEX_Mailchimp_Widget' );
	}
}
add_action( 'widgets_init', 'wpex_register_mailchimp_widget' );