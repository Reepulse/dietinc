<?php
/**
 * Instagram Slider Widget
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
if ( ! class_exists( 'WPEX_Instagram_Slider_Widget' ) ) {
	class WPEX_Instagram_Slider_Widget extends WP_Widget {
		
		/**
		 * Register widget with WordPress.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			parent::__construct(
				'wpex_insagram_slider',
				$name = __( 'Chic - Instagram Slider', 'chic' ),
				array(
					'description'   => __( 'Displays recent instagram photos in a slider.', 'chic' ),
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
			$title    = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
			$username = empty( $instance['username'] ) ? '' : $instance['username'];
			$number   = empty( $instance['number'] ) ? 9 : $instance['number'];
			$target   = empty( $instance['target'] ) ? ' target="_blank"' : $instance['target'];

			// Exclude current post
			if ( is_singular() ) {
				$exclude = array( get_the_ID() );
			} else {
				$exclude = NULL;
			}

			// Before widget hook
			echo $before_widget;

			// Display widget title
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}

			// Display notice for username not added
			if ( ! $username ) {

				echo '<p>'. __( 'Please enter an instagram username for your widget.', 'chic' ) .'</p>';

			} else {

				// Get instagram images
				$media_array = $this->scrape_instagram( $username, $number );

				// Display error message
				if ( is_wp_error( $media_array ) ) {

					echo $media_array->get_error_message();

				}

				// Display instagram slider
				else { ?>

					<?php
					// Enqueue script
					wp_enqueue_script( 'lightslider' ); ?>

					<div class="wpex-instagram-slider-widget">

						<ul class="wpex-instagram-slider-widget-slider wpex-clr">

						<?php foreach ( $media_array as $item ) {
							echo '<li class="wpex-instagram-slider-widget-slide">
									<a href="'. esc_url( $item['link'] ) .'" title="'. esc_attr( $item['description'] ) .'"'. $target .'>
										<img src="'. esc_url( $item['thumbnail'] ) .'"  alt="'. esc_attr( $item['description'] ) .'" />
									</a>
								</li>';
						} ?>

						</ul><!-- .wpex-instagram-slider-widget-slider -->
						
					</div><!-- .wpex-instagram-slider-widget -->

			<?php }

			}

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

			// Get instance
			$instance             = $old_instance;
			$instance['title']    = strip_tags( $new_instance['title'] );
			$instance['username'] = trim( strip_tags( $new_instance['username'] ) );
			$instance['number']   = ! absint( $new_instance['number'] ) ? 9 : $new_instance['number'];
			$instance['target']   = $new_instance['target'] == 'blank' ? $new_instance['target'] : '';

			// Delete transient
			if ( $instance['username'] ) {
				delete_transient( 'wpex-instagram-widget-new-'. sanitize_title_with_dashes( $instance['username'] ) );
			}

			// Return instance
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
				'title'    => __( 'Instagram', 'chic' ),
				'username' => '',
				'number'   => 4,
				'target'   => '_self'
			) );
			$title    = esc_attr( $instance['title'] );
			$username = esc_attr( $instance['username'] );
			$number   = absint( $instance['number'] );
			$target   = esc_attr( $instance['target'] ); ?>
			
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'chic' ); ?>: <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

			<p><label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Username', 'chic' ); ?>: <input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo $username; ?>" /></label></p>

			<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of photos', 'chic' ); ?>: <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" /></label></p>

			<p><label for="<?php echo $this->get_field_id( 'target' ); ?>"><?php _e( 'Open links in', 'chic' ); ?>:</label>
				<select id="<?php echo $this->get_field_id( 'target' ); ?>" name="<?php echo $this->get_field_name( 'target' ); ?>" class="widefat">
					<option value="_self" <?php selected( '_self', $target ) ?>><?php _e( 'Current window', 'chic' ); ?></option>
					<option value="_blank" <?php selected( '_blank', $target ) ?>><?php _e( 'New window', 'chic' ); ?></option>
				</select>
			</p>

			<p>
				<strong><?php _e( 'Cache Notice', 'chic' ); ?></strong>:<?php _e( 'The instagram feed is refreshed every 2 hours. However, you can click the save button below to clear the transient and refresh it instantly.', 'chic' ); ?>
			</p>

			<?php
		}

		/**
		 * Get instagram items
		 *
		 * @since 1.0.0
		 * @link  https://gist.github.com/cosmocatalano/4544576
		 */
		function scrape_instagram( $username, $slice = 4 ) {

			$username           = strtolower( $username );
			$sanitized_username = sanitize_title_with_dashes( $username );
			$transient_name     = 'wpex-instagram-widget-new-'. $sanitized_username;
			$instagram          = get_transient( $transient_name );

			if ( ! empty( $_GET['theme_clear_transients'] ) ) {
				$instagram = delete_transient( $transient_name );
			}

			if ( ! $instagram ) {

				$remote = wp_remote_get( 'http://instagram.com/'. trim( $username ) );

				if ( is_wp_error( $remote ) ) {
					return new WP_Error( 'site_down', __( 'Unable to communicate with Instagram.', 'chic' ) );
				}

				if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
					return new WP_Error( 'invalid_response', __( 'Instagram did not return a 200.', 'chic' ) );
				}

				$shards      = explode( 'window._sharedData = ', $remote['body'] );
				$insta_json  = explode( ';</script>', $shards[1] );
				$insta_array = json_decode( $insta_json[0], TRUE );

				if ( ! $insta_array ) {
					return new WP_Error( 'bad_json', __( 'Instagram has returned invalid data.', 'chic' ) );
				}

				// Old style
				if ( isset( $insta_array['entry_data']['UserProfile'][0]['userMedia'] ) ) {
					$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];
					$type = 'old';

				}

				// New style
				elseif ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
					$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
					$type = 'new';
				}

				// Invalid json data
				else {
					return new WP_Error( 'bad_json_2', __( 'Instagram has returned invalid data.', 'chic' ) );
				}

				// Invalid data
				if ( ! is_array( $images ) ) {
					return new WP_Error( 'bad_array', __( 'Instagram has returned invalid data.', 'chic' ) );
				}

				$instagram = array();

				switch ( $type ) {

					case 'old':

						foreach ( $images as $image ) {
							if ( $image['user']['username'] == $username ) {
								$image['link']						    = preg_replace( "/^http:/i", "", $image['link'] );
								$image['images']['thumbnail']		    = preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
								$image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );
								$image['images']['low_resolution']	    = preg_replace( "/^http:/i", "", $image['images']['low_resolution'] );
								$instagram[] = array(
									'description' => $image['caption']['text'],
									'link'		  => $image['link'],
									'time'		  => $image['created_time'],
									'comments'	  => $image['comments']['count'],
									'likes'		  => $image['likes']['count'],
									'thumbnail'	  => $image['images']['thumbnail'],
									'large'		  => $image['images']['standard_resolution'],
									'small'		  => $image['images']['low_resolution'],
									'type'		  => $image['type']
								);
							}
						}

					break;

					default:

						foreach ( $images as $image ) {

							$image['display_src'] = preg_replace( "/^http:/i", "", $image['display_src'] );

							if ( $image['is_video']  == true ) {
								$type = 'video';
							} else {
								$type = 'image';
							}

							$instagram[] = array(
								'description' => __( 'Instagram Image', 'chic' ),
								'link'		  => '//instagram.com/p/' . $image['code'],
								'time'		  => $image['date'],
								'comments'	  => $image['comments']['count'],
								'likes'		  => $image['likes']['count'],
								'thumbnail'	  => $image['display_src'],
								'type'		  => $type
							);

						}

					break;

				}

				// Set transient if not empty
				if ( ! empty( $instagram ) ) {
					$instagram = base64_encode( serialize( $instagram ) );
					set_transient(
						$transient_name,
						$instagram,
						apply_filters( 'wpex_instagram_widget_cache_time', HOUR_IN_SECONDS*2 )
					);
				}

			}

			// Return array
			if ( ! empty( $instagram ) ) {
				$instagram = unserialize( base64_decode( $instagram ) );
				return array_slice( $instagram, 0, $slice );
			}

			// No images returned
			else {

				return new WP_Error( 'no_images', __( 'Instagram did not return any images.', 'chic' ) );

			}

		}


	}
}

// Register the WPEX_Tabs_Widget custom widget
if ( ! function_exists( 'wpex_register_wpex_instagram_slider_widget' ) ) {
	function wpex_register_wpex_instagram_slider_widget() {
		register_widget( 'WPEX_Instagram_Slider_Widget' );
	}
}
add_action( 'widgets_init', 'wpex_register_wpex_instagram_slider_widget' );