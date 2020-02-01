<?php
/**
 * WooCommerce header
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

// Only used for archives and search results
if ( ! is_archive() && ! is_search() ) {
	return;
} ?>

<header class="wpex-archive-header wpex-clr">

	<h1 class="wpex-archive-title">

		<span class="wpex-accent-bg">
		
			<?php if ( $custom_archive_title = apply_filters( 'wpex_archive_title', null ) ) : ?>

				<?php echo $custom_archive_title; ?>

			<?php elseif ( is_shop() ) : ?>

				<?php
				// Get and display shop title
				$shop_title = get_the_title( wc_get_page_id( 'shop' ) );
				$shop_title = $shop_title ? $shop_title : __( 'Shop', 'chic' );
				echo $shop_title; ?>

			<?php elseif ( is_search() ) : ?>

				<?php _e( 'Search Results ', 'chic' ); ?>

			<?php elseif ( is_tax() || is_category() || is_tag() ) : ?>

				<?php single_term_title(); ?>

			<?php else : ?>

				<?php the_archive_title(); ?>

			<?php endif; ?>

		</span>

	</h1>

	<?php
	// Display orderby
	if ( ! is_search() ) : ?>

		<?php woocommerce_catalog_ordering(); ?>

	<?php endif; ?>

</header><!-- .wpex-archive-header -->