<?php
/**
 * Homepage category entry
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

// Get columns
$columns = wpex_get_theme_mod( 'home_cats_columns' );
$columns = $columns ? $columns : 2;

// Get counter
global $wpex_count; ?>

<div class="wpex-home-cat-entry wpex-col wpex-col-<?php echo $columns; ?> wpex-clr">

	<div class="wpex-boxed-container wpex-clr">

		<div class="wpex-home-cat-entry-media wpex-clr">
			<a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>"><?php the_post_thumbnail( 'entry' ); ?></a>
		</div><!-- .wpex-home-cat-entry-media -->

		<div class="wpex-home-cat-entry-details wpex-clr">

			<div class="wpex-match-height wpex-clr">

				<h3 class="wpex-home-cat-entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php wpex_esc_title(); ?>">
						<?php the_title(); ?>
					</a>
				</h3><!-- .wpex-home-cat-entry-title -->

				<?php
				// Display meta
				if ( wpex_get_theme_mod( 'post_meta', true ) ) : ?>

					<?php get_template_part( 'partials/post/meta' ); ?>

				<?php endif; ?>

				<?php
				// Display entry excerpt/content
				get_template_part( 'partials/entry/content' ); ?>

			</div><!-- .wpex-match-height -->

			<?php if ( wpex_get_theme_mod( 'entry_readmore', true ) ) : ?>
				
				<div class="wpex-loop-entry-footer wpex-clr">

					<?php
					// Display entry readmore
					if ( wpex_get_theme_mod( 'entry_readmore', true ) ) : ?>

					 	<?php get_template_part( 'partials/entry/readmore' ); ?>

					 <?php endif; ?>

				</div><!-- .wpex-loop-entry-footer -->

			<?php endif; ?>

		</div><!-- .wpex-home-cat-entry-details -->


	</div><!-- .wpex-boxed-container -->

</div><!-- .wpex-home-cat-entry -->

<?php
// Reset counter
if ( $columns == $wpex_count ) {
	$wpex_count = 0;
}