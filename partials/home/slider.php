<?php
/**
 * Homepage Slider
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

// Get slider content
$count           = wpex_get_theme_mod( 'home_slider_count', 4 );
$content         = wpex_get_theme_mod( 'home_slider_content', 'recent_posts' );
$slider_location = wpex_get_theme_mod( 'home_slider_location', 'above' );

// Show custom code
if ( 'custom_code' == $content && $custom_code = get_theme_mod( 'home_slider_custom_code' ) ) {
	echo '<div class="wpex-home-custom-slider clr">'. do_shortcode( $custom_code ) .'</div>';
}

// Show homepage featured slider if theme panel category isn't blank
if ( $content && 'none' != $content && $count >= 1 ) :

	if ( 'recent_posts' != $content ) {

		$tax_query = array (
			array (
				'taxonomy' => 'category',
				'field'    => 'ID',
				'terms'    => (int) $content,
			),
		);

	} else {

		$tax_query = null;
		
	}
		
	// Get posts based on featured category
	$wpex_query = new WP_Query( array(
		'post_type'      =>'post',
		'posts_per_page' => $count,
		'no_found_rows'  => true,
		'tax_query'      => $tax_query,
	) );
	
	if ( $wpex_query->have_posts() ) : ?>

		<?php
		// Enqueue/define scripts
		if ( wpex_has_minified_js() ) {
			$script = 'wpex-theme-min';
		} else {
			$script = 'lightslider';
			wp_enqueue_script( 'lightslider' );
		}

		// Localize script
		$slideshow = get_theme_mod( 'home_slider_slideshow', true );
		$pause     = get_theme_mod( 'home_slider_pause', 5000 );
		$pause     = $pause ? $pause : 5000;
		if ( $pause <= 1000 ) {
			$pause = 1000;
		}
		wp_localize_script( $script, 'wpexHomeSliderVars', array(
			'slideShow' => $slideshow,
			'pause'     => $pause,
		) );

		// Wrap classes
		$wrap_classes = 'wpex-full-slider-wrap wpex-clr';
		$wrap_classes .= ' '. wpex_get_full_slider_style();
		$wrap_classes .= ' location-'. $slider_location;
		if ( 'above' == $slider_location ) {
			$wrap_classes .= ' wpex-container';
		} ?>

		<div class="<?php echo esc_html( $wrap_classes ); ?>">

			<div class="wpex-full-slider">

				<?php
				// Loop through each post
				while ( $wpex_query->have_posts() ) : $wpex_query->the_post();

					// Get thumbnail
					$thumbnail = get_the_post_thumbnail( get_the_ID(), 'homepage-slider', array(
						'alt'	=> wpex_get_esc_title(),
						'title'	=> wpex_get_esc_title(),
					) ); ?>

					<?php if ( $thumbnail ) : ?>

						<div class="wpex-full-slider-slide">

							<div class="wpex-full-slider-media">
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
									<?php echo $thumbnail; ?>
								</a>
							</div><!-- .wpex-full-slider-media -->

							<div class="wpex-full-slider-caption wpex-clr">
								<div class="wpex-full-slider-caption-title">
									<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" class="wpex-heading-font-family">
										<?php if ( wpex_has_post_video() ) : ?>
											<span class="fa fa-video-camera"></span>
										<?php endif; ?>
										<?php the_title(); ?>
									</a>
									<span class="date"><?php echo get_the_date(); ?> </span>
								</div>
							</div><!--.wpex-full-slider-caption -->

						</div><!-- .wpex-full-slider-slide -->

					<?php endif; ?>

				<?php endwhile; ?>

			</div><!--.wpex-full-slider -->

		</div><!-- .wpex-wpex-full-slider-wrap -->

	<?php endif; ?>

<?php endif; ?>

<?php wp_reset_postdata(); ?>