<?php
/**
 * Shop Carousel
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

// Return if not neededd
if ( is_page_template( 'templates/login-register.php' ) ) {
	return;
}

// Args
$args = array(
	'post_type'      => 'product',
	'posts_per_page' => get_theme_mod( 'woo_carousel_count', 10 ),
	'no_found_rows'  => true,
);

// Apply filters for child theming
$args = apply_filters( 'wpex_shop_carousel_args', $args );

// Query posts
$wpex_query = new WP_Query( $args );

// Display posts
if ( $wpex_query->posts ) :

	// Set columns
	$columns = get_theme_mod( 'woo_carousel_columns' );
	$columns = $columns ? $columns : 5;

	// Set margin
	$margin = get_theme_mod( 'woo_carousel_margin' );
	$margin = $margin ? $margin : 30;

	// Enable carousel only when more then column #
	$has_carousel = true;

	// Enqueue/define scripts
	if ( $has_carousel ) {

		if ( wpex_has_minified_js() ) {
			$script = 'wpex-theme-min';
		} else {
			$script = 'lightslider';
			wp_enqueue_script( 'lightslider' );
		}

		// Localize script
		wp_localize_script( $script, 'wpexShopCarousel', array(
			'columns' => $columns,
			'margin'  => $margin,
		) );

	} ?>


	<div class="wpex-shop-carousel-wrap wpex-clr">

		<div class="wpex-container wpex-clr">

			<h2 class="wpex-shop-carousel-heading theme-heading"><?php _e( 'Latest Products', 'chic' ); ?></h2>

			<div class="wpex-shop-carousel-outer">

				<div class="wpex-shop-carousel">

					<?php
					// Loop through posts
					foreach ( $wpex_query->posts as $post ) : setup_postdata( $post );

						// New product class
						$product = new WC_Product( get_the_ID() );

						// Get product data
						$price = $product->get_price_html(); ?>

						<div class="wpex-shop-carousel-entry wpex-clr">

							<div class="shop-entry-thumbnail wpex-clr">

								<a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>"><?php the_post_thumbnail( 'shop_catalog' ); ?></a>

							</div><!-- .shop-entry-thumbnail -->

							<div class="wpex-shop-carousel-title wpex-heading-font-family">
								<a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>"><?php the_title(); ?></a>
							</div>

							<?php
							// Display product price
							if ( $price ) : ?>

								<div class="wpex-shop-carousel-price"><?php echo $price; ?></div>
								
							<?php endif; ?>

						</div><!-- .wpex-shop-carousel-entry -->

					<?php endforeach; ?>

				</div><!-- .wpex-shop-carousel -->

			</div><!-- .wpex-shop-carousel-outer -->

		</div><!-- .wpex-container -->

	</div><!-- .wpex-shop-carousel-wrap -->

<?php endif; ?>

<?php wp_reset_postdata(); ?>