<?php
/**
 * Template Name: Archives
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

				<?php
				// Get Posts
				$wpex_query = new WP_Query( array(
					'post_type'      => 'post',
					'posts_per_page' => '10',
					'no_found_rows'  => true,
				) ); ?>

				<?php if ( $wpex_query->have_posts() ) : ?>

					<div class="archives-template-box">

						<h2><?php _e( 'Latest Posts', 'chic' ); ?></h2>
						
						<ul>
							<?php while ( $wpex_query->have_posts() ) : $wpex_query->the_post(); ?>
								<li>
									<a href="<?php the_permalink() ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
										<?php the_title(); ?>
									</a>
								</li>
							<?php endwhile; ?>
						</ul>

					</div><!-- .archives-template-box -->

				<?php endif; ?>

				<?php wp_reset_postdata(); ?>

				<?php
				// Get products
				$wpex_query = new WP_Query( array(
					'post_type'      => 'product',
					'posts_per_page' => '10',
					'no_found_rows'  => true,
				) ); ?>

				<?php if ( $wpex_query->have_posts() ) : ?>

					<div class="archives-template-box">

						<h2><?php _e( 'Latest Products', 'chic' ); ?></h2>
						
						<ul>
							<?php while ( $wpex_query->have_posts() ) : $wpex_query->the_post(); ?>
								<li>
									<a href="<?php the_permalink() ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
										<?php the_title(); ?>
									</a>
								</li>
							<?php endwhile; ?>
						</ul>

					</div><!-- .archives-template-box -->

				<?php endif; ?>
				<?php wp_reset_postdata(); ?>

				<div class="archives-template-box">

					<h2><?php _e( 'Archives by Month', 'chic' ); ?></h2>

					<ul><?php wp_get_archives('type=monthly'); ?></ul>

				</div><!-- .archives-template-box -->

				<div class="archives-template-box">

					<h2><?php _e( 'Archives by Category', 'chic' ); ?></h2>

					<ul><?php wp_list_categories( 'title_li=&hierarchical=0' ); ?></ul>

				</div><!-- .archives-template-box -->

				<?php if ( get_terms( 'post_tag' ) ) : ?>

					<div class="archives-template-box">

						<h2><?php _e( 'Archives by Tag', 'chic' ); ?></h2>

						<ul><?php wp_list_categories( 'title_li=&hierarchical=0&taxonomy=post_tag' ); ?></ul>

					</div><!-- .archives-template-box -->

				<?php endif; ?>


			<?php get_template_part( 'partials/global/edit' ); ?>

		</main><!-- .wpex-main -->

	</div><!-- .wpex-content-area -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>