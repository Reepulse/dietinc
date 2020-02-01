<?php
/**
 * Archives header
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

		<span class="wpex-accent-bg <?php if ( is_category() ) echo 'wpex-term-'. $cat; ?>">

			<?php if ( $custom_archive_title = apply_filters( 'wpex_archive_title', null ) ) : ?>

				<?php echo $custom_archive_title; ?>

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
	// Show search query
	if ( is_search() ) : ?>

		<div class="wpex-term-description wpex-clr">

			<?php printf( __( 'You searched for: %s', 'chic' ), '<span>'. get_search_query() .'</span>' ); ?>

		</div><!-- #wpex-term-description -->

	<?php
	// Display archive description
	elseif ( term_description() ) : ?>

		<div class="wpex-term-description wpex-clr">

			<?php echo term_description(); ?>
			
		</div><!-- #wpex-term-description -->

	<?php endif; ?>

</header><!-- .wpex-archive-header -->