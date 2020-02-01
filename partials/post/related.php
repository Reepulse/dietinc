<?php
/**
 * Single related posts
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

// Make sure we should display related items
if ( 'post' != get_post_type() || 'on' == get_post_meta( get_the_ID(), 'wpex_disable_related', true ) ) {
	return;
}

// Get count
$count = get_theme_mod( 'post_related_count', '4' );
if ( ! $count || 0 == $count ) {
	return;
}

if ( $count > 99 ) {
	$count = 10;
}

// Get Current post
$post_id = get_the_ID();

// What should be displayed?
$get_posts = get_theme_mod( 'post_related_displays', 'random' );

// Create an array of current category ID's
if ( 'related_category' == $get_posts ) {
	$cats = wp_get_post_terms( $post_id, 'category' ); 
	$cats_ids = array();  
	foreach( $cats as $wpex_related_cat ) {
		$cats_ids[] = $wpex_related_cat->term_id; 
	}
} else {
	$cats_ids = null;
}

// Related exclude formats
$exclude_formats = array( 'post-format-quote', 'post-format-link', 'post-format-status' );
$exclude_formats = apply_filters( 'wpex_related_posts_exclude_formats', $exclude_formats );

// Related query arguments
$args = array(
	'posts_per_page' => $count,
	'orderby'        => 'rand',
	'category__in'   => $cats_ids,
	'post__not_in'   => array( $post_id ),
	'no_found_rows'  => true,
	'meta_key'       => '_thumbnail_id',
);
$args = apply_filters( 'wpex_related_posts_args', $args );
$wpex_query = new wp_query( $args );

if ( $wpex_query->have_posts() ) { ?>

	<div class="wpex-related-posts-wrap wpex-boxed-container wpex-clr">

		<h4 class="wpex-heading"><?php _e( 'You May Also Like', 'chic' ); ?></h4>

		<div class="wpex-related-posts wpex-clr">
			<?php
			// Loop through related posts
			$count = 0;
			foreach( $wpex_query->posts as $post ) : setup_postdata( $post );
			$count ++; ?>

				<div class="wpex-related-post wpex-clr <?php if ( $count == count( $wpex_query->posts ) ) echo 'last'; ?>">

					<?php if ( has_post_thumbnail() ) : ?>

						<div class="wpex-related-post-thumbnail wpex-clr">
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>">
								<?php the_post_thumbnail( 'post-related' ); ?>
								<?php if ( wpex_has_post_video() ) : ?>
									<span class="wpex-related-post-video-tag fa fa-video-camera"></span>
								<?php endif; ?>
							</a>
						</div><!-- .related-wpex-post-thumbnail -->

					<?php endif; ?>

					<div class="wpex-related-post-content wpex-clr">

						<?php
						// Get category
						$category = wpex_get_post_terms( 'category', true, 'wpex-accent-bg' );

						// Return if we can't find any category
						if ( $category ) : ?>

							<div class="wpex-entry-cat wpex-clr wpex-button-typo">
								<?php echo $category; ?>
							</div><!-- .wpex-entry-cat -->

						<?php endif; ?>

						<h3 class="wpex-related-post-heading"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h3>

						<div class="wpex-related-post-date"><?php echo get_the_date(); ?></div>

						</div><!-- .related-post-content -->

				</div><!-- .related-post -->

			<?php endforeach; ?>

		</div><!-- .wpex-related-posts -->

	</div>

<?php } // End related items

// Reset post data
wp_reset_postdata();