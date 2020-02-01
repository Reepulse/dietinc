<?php
/**
 * Template Name: Authors
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

get_header(); ?>

	<div class="wpex-content-area wpex-clr">

		<main class="wpex-site-main wpex-clr">

			<div class="wpex-entry wpex-page-content wpex-boxed-container wpex-page-article wpex-clr">

				<?php get_template_part( 'partials/page/thumbnail' ); ?>

				<?php get_template_part( 'partials/page/header' ); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php the_content(); ?>

				<?php endwhile; ?>

			</div><!-- .wpex-entry -->

			<?php
			// Get a list of users
			$administrators = get_users(
				array(
					'orderby' => 'post_count',
					'role'    => 'administrator',
					'order'   => 'DESC',
				)
			);
			$contributors = get_users(
				array(
					'orderby' => 'post_count',
					'role'    => 'contributor',
					'order'   => 'DESC',
				)
			);
			$users = array_merge( $administrators, $contributors ); ?>

			<div class="wpex-authors-listing wpex-clr">

				<?php foreach( $users as $wpex_author ) : ?>

					<?php get_template_part( 'partials/archives/author-entry' ); ?>

				<?php endforeach; ?>

			</div><!-- .wpex-authors-listing -->

			<?php comments_template(); ?>

		</main><!-- .wpex-main -->

	</div><!-- .wpex-content-area -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>