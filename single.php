<?php
/**
 * The Template for displaying all single posts.
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<div class="wpex-content-area wpex-clr">

			<?php
			// Ad region
			wpex_ad_region( 'single-top' ); ?>

			<main class="wpex-site-main wpex-clr">

				<div class="site-main-inner wpex-clr">

					<?php get_template_part( 'partials/layout-post' ); ?>

				</div><!-- .site-main-inner -->

			</main><!-- .wpex-main -->

			<?php
			// Ad region
			wpex_ad_region( 'single-bottom' ); ?>

		</div><!-- .wpex-content-area -->

	<?php endwhile; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>