<?php
/**
 * Footer Layout
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

// Show Woo Carousel
if ( wpex_has_woocommerce_carousel() ) :

	get_template_part( 'partials/woocommerce/carousel' );

endif; ?>

<footer class="wpex-site-footer">

	<?php if ( wpex_has_footer_widgets() ) : ?>

		<?php get_template_part( 'partials/footer/widgets' ); ?>

	<?php endif; ?>

	<div class="wpex-footer-bottom">
	
		<div class="wpex-container wpex-clr">

			<?php if ( get_theme_mod( 'footer_social', true  ) ) : ?>

				<?php get_template_part( 'partials/footer/social' ); ?>

			<?php endif; ?>

			<?php if ( get_theme_mod( 'footer_copyright', true  ) ) : ?>

				<?php get_template_part( 'partials/footer/copyright' ); ?>

			<?php endif; ?>

		</div><!-- .wpex-container -->

	</div><!-- .wpex-footer-bottom -->

</footer><!-- .wpex-site-footer -->

<?php get_template_part( 'partials/global/scrolltop' ); ?>