<?php
/**
 * The main header layout
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

// Nav position
$nav_position = wpex_get_nav_position();

// Get header style
$style = wpex_get_header_style(); ?>

<?php if ( wpex_has_notice_bar() ) : ?>
	<?php get_template_part( 'partials/header/notice-bar' ); ?>
<?php endif; ?>

<div class="wpex-site-header-wrap wpex-clr <?php echo $style; ?>">

	<?php
	// Display nav outside wpex-container
	if ( 'top' == $nav_position ) : ?>

		<?php get_template_part( 'partials/header/nav-main' ); ?>

	<?php endif; ?>

	<header class="wpex-site-header wpex-container wpex-clr <?php echo $style; ?>">

		<div class="wpex-site-branding wpex-clr">

			<?php get_template_part( 'partials/header/logo' ); ?>
			
			<?php get_template_part( 'partials/header/blog-description' ); ?>

		</div><!-- .wpex-site-branding -->

		<?php
		// Display nav inside wpex-container
		if ( 'default' == $nav_position || ! $nav_position ) : ?>

			<?php get_template_part( 'partials/header/nav-main' ); ?>

		<?php endif; ?>

		<?php
		// Add WooCommerce cart widget
		if ( WPEX_WOOCOMMERCE_ACTIVE && ! wpex_has_full_nav() ) : ?>

			<?php get_template_part( 'partials/woocommerce/cart' ); ?>
			
		<?php endif; ?>

	</header><!-- .wpex-site-header -->

	<?php
	// Display nav outside wpex-container
	if ( 'bottom' == $nav_position ) : ?>

		<?php get_template_part( 'partials/header/nav-main' ); ?>

	<?php endif; ?>

</div><!-- .wpex-site-header-wrap -->