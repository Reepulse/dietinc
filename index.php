<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

get_header(); ?>

	<?php
	// Archive thumbnail
	if ( is_category() ) {
		get_template_part( 'partials/archives/category-thumbnail' );
	} ?>

	<div class="wpex-content-area wpex-clr">

		<?php
		// Display page header
		get_template_part( 'partials/archives/header' ); ?>

		<?php
		// Ad region
		wpex_ad_region( 'archives-top' ); ?>

		<?php
		// Homepage slider inline
		if ( ( is_home() || is_front_page() ) && 'inline' == get_theme_mod( 'home_slider_location', 'above' ) ) {
			get_template_part( 'partials/home/slider' );
		} ?>

		<main class="wpex-site-main wpex-clr">

			<?php
			// Check if posts exist
			if ( have_posts() ) : ?>

				<div class="wpex-row wpex-entries wpex-clr">   

					<?php
					// Define counter var
					$wpex_count = 0;

					// Loop through posts
					while ( have_posts() ) : the_post();

						// Display post entry
						get_template_part( 'partials/layout-entry' );

					// End loop
					endwhile; ?>

				</div><!-- .wpex-entries -->

				<?php
				// Include pagination template part
				wpex_include_template( 'partials/global/pagination.php' ); ?>

			<?php
			// Display no posts found message
			else : ?>

				<?php get_template_part( 'partials/entry/none' ); ?>

			<?php endif; ?>

		</main><!-- .wpex-main -->

		<?php
		// Ad region
		wpex_ad_region( 'archives-bottom' ); ?>

	</div><!-- .wpex-content-area -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>