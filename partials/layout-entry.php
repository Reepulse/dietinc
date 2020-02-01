<?php
/**
 * The default template for displaying post entries.
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

// Base classes for entry
$classes = array( 'wpex-loop-entry', 'wpex-col', 'wpex-clr' );

// Add column class
if ( $columns = wpex_get_loop_columns() ) {
	$classes[] = 'wpex-col-'. $columns;
}

// Counter
global $wpex_count;
$wpex_count++;
if ( $wpex_count ) {
	$classes[] = 'wpex-count-'. $wpex_count;
}

// No featured image class
if ( ! has_post_thumbnail() ) {
    $classes[] = 'no-thumbnail';
} ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>

	<div class="wpex-boxed-container wpex-clr">

		<?php if ( wpex_has_post_video() ) : ?>

			<?php get_template_part( 'partials/entry/video' ); ?>

		<?php elseif ( wpex_get_theme_mod( 'entry_thumbnail', true ) ) : ?>

			<?php if ( wpex_get_gallery_ids() ) : ?>

				<?php get_template_part( 'partials/entry/slider' ); ?>

			<?php elseif ( has_post_thumbnail() ) : ?>

				<?php get_template_part( 'partials/entry/thumbnail' ); ?>

			<?php endif; ?>

		<?php endif; ?>

		<div class="wpex-loop-entry-content wpex-clr">

			<?php
			// Display category tab
			if ( wpex_get_theme_mod( 'entry_category', true ) ) : ?>

				<?php get_template_part( 'partials/entry/category' ); ?>

			<?php endif; ?>

			<?php
			// Display title
			get_template_part( 'partials/entry/title' ); ?>

			<?php
			// Display entry meta
			if ( wpex_get_theme_mod( 'entry_meta', true ) ) : ?>
				<?php get_template_part( 'partials/entry/meta' ); ?>
			<?php endif; ?>

			<?php
			// Display entry excerpt/content
			get_template_part( 'partials/entry/content' ); ?>

			<?php if ( wpex_get_theme_mod( 'entry_readmore', true ) ) : ?>
				
				<div class="wpex-loop-entry-footer wpex-clr">

					<?php
					// Display entry readmore
					if ( wpex_get_theme_mod( 'entry_readmore', true ) ) : ?>
					 	<?php get_template_part( 'partials/entry/readmore' ); ?>
					 <?php endif; ?>

					<?php //get_template_part( 'partials/entry/share' ); ?>

				</div><!-- .wpex-loop-entry-footer -->

			<?php endif; ?>

		</div><!-- .wpex-loop-entry-content -->

	</div><!-- .wpex-boxed-container -->

</article><!-- .wpex-loop-entry -->

<?php
// Reset counter
if ( $wpex_count == wpex_get_loop_columns() ) {
	$wpex_count = 0;
} ?>