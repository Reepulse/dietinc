<?php
/**
 * Template Name: Category Homepage
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

get_header(); ?>

	<div class="wpex-content-area wpex-clr">

		<?php
		// Ad region
		wpex_ad_region( 'archives-top' ); ?>

		<?php
		// Homepage slider inline
		if ( 'inline' == get_theme_mod( 'home_slider_location', 'above' ) && ( is_home() || is_front_page() ) ) {
			get_template_part( 'partials/home/slider' );
		} ?>

		<main class="wpex-site-main wpex-clr">

			<?php
			// Start main loop
			while ( have_posts() ) : the_post();

				// Enqueue script
				wp_enqueue_script( 'match-height' );

				// Set defaults
				$cats = get_categories( array(
					'orderby' => 'name',
 					'parent'  => 0,
				) );
				$defaults = null;
				if ( $cats && is_array( $cats ) ) {
					foreach ( $cats as $cat ) {
						$defaults .= $cat->term_id .',';
					}
				}

				// Get categories
				$cats = wpex_get_theme_mod( 'home_cats', $defaults );

				// Turn into array
				if ( $cats ) {
					$cats = explode( ',', $cats );
				}

				// Display cats
				if ( $cats && is_array( $cats ) ) { ?>

					<div class="wpex-home-cats wpex-clr">

						<?php
						// Define counter var
						$wpex_count = '0';

						// Loop through categories
						foreach ( $cats as $cat ) :

							// Add to counter
							$wpex_count++;

							// Get term
							$term = get_term( wpex_translate_id( $cat, 'term' ), 'category' );

							// Make sure there aren't any error
							if ( is_wp_error( $term ) ) {
								continue;
							}

							// Define term ID
							$term_id = $term->term_id; ?>

							<div class="wpex-home-cat wpex-clr">

								<h2 class="wpex-home-cat-heading wpex-clr">
									<span class="wpex-accent-bg wpex-term-<?php echo $term_id; ?>"><a href="<?php echo get_category_link( $term_id ); ?>" title="<?php echo $term->name; ?>">
										<?php echo $term->name; ?>
									</a></span>
									<?php if ( get_theme_mod( 'home_cats_view_all', true ) ) : ?>
										<a href="<?php echo get_category_link( $term_id ); ?>" title="<?php echo $term->name; ?>" class="wpex-view-all wpex-border-button"><?php _e( 'View All', 'chic' ); ?></a>
									<?php endif; ?>
								</h2>

								<?php
								// Get posts from current cat
								$cat_posts = new WP_Query( array(
									'post_type'      => 'post',
									'posts_per_page' => wpex_get_theme_mod( 'home_cats_posts_per_cat', 2 ),
									'no_found_rows'  => true,
									'post__not_in'   => wpex_exclude_home_ids(),
									'tax_query'      => array ( array (
										'taxonomy' => 'category',
										'field'    => 'term_id',
										'terms'    => $term_id,
									) ),
								) );

								if ( $cat_posts->posts ) : ?>

									<div class="wpex-row wpex-home-cats-row wpex-clr">

										<?php
										// Set counter var
										$wpex_count = 0;

										// Loop through posts
										foreach( $cat_posts->posts as $post ) : setup_postdata( $post ); ?>

											<?php
											// Get entry content
											get_template_part( 'partials/home/cat-entry' ); ?>

										<?php
										// End post loop
										endforeach; ?>

									</div><!-- .wpex-home-cats-row -->

								<?php endif; ?>

								<?php wp_reset_postdata(); ?>

							</div><!-- .wpex-home-cat -->

						<?php
						// End foreach
						endforeach; ?>

					</div><!-- .home-cats -->

				<?php } ?>

			<?php endwhile; ?>

		</main><!-- .wpex-main -->

		<?php
		// Ad region
		wpex_ad_region( 'archives-bottom' ); ?>

	</div><!-- .wpex-content-area -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>