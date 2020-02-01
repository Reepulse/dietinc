<?php
/**
 * Single post layout
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
} ?>

<article class="wpex-port-article wpex-clr">

	<div class="wpex-boxed-container wpex-post-article-box wpex-clr">

		<?php
		// Display post video
		if ( get_post_meta( get_the_ID(), 'wpex_post_video', true ) ) : ?>

			<?php get_template_part( 'partials/post/video' ); ?>

		<?php elseif ( wpex_get_theme_mod( 'post_thumbnail', true ) ) : ?> 

			<?php
			// Display post slider
			if ( wpex_get_gallery_ids() ) : ?>

				<?php get_template_part( 'partials/post/slider' ); ?>

			<?php
			// Display post thumbnail
			elseif ( has_post_thumbnail() ) : ?>

				<?php get_template_part( 'partials/post/thumbnail' ); ?>

			<?php endif ?>

		<?php endif ?>

		<?php
		// Display category tag
		if ( get_theme_mod( 'post_category', true ) ) : ?>
			<?php get_template_part( 'partials/post/category' ); ?>
		<?php endif; ?>

		<?php
		// Display post header
		get_template_part( 'partials/post/header' ); ?>

		<?php
		// Display meta
		if ( wpex_get_theme_mod( 'post_meta', true ) ) : ?>
			<?php get_template_part( 'partials/post/meta' ); ?>
		<?php endif; ?>

		<?php
		// Display post share above post
		if ( wpex_has_social_share() ) : ?>
			<?php get_template_part( 'partials/post/share' ); ?>
		<?php endif; ?>

		<?php
		// Display post content
		get_template_part( 'partials/post/content' ); ?>

		<?php
		// Display post links
		get_template_part( 'partials/global/link-pages' ); ?>

		<?php
		// Display post edit link
		get_template_part( 'partials/global/edit' ); ?>

		<?php
		// Display post tags
		if ( get_theme_mod( 'post_tags', true ) ) : ?>

			<?php get_template_part( 'partials/post/tags' ); ?>

		<?php endif; ?>

	</div><!-- .wpex-boxed-container -->

	<?php
	// Display post nav
	get_template_part( 'partials/post/navigation' ); ?>

	<?php
	// Display post author
	if ( wpex_has_author_bio() ) : ?>

		<?php get_template_part( 'partials/post/author' ); ?>

	<?php endif; ?>

	<?php
	// Display related posts
	if ( wpex_get_theme_mod( 'post_related', true ) ) : ?>

		<?php get_template_part( 'partials/post/related' ); ?>

	<?php endif; ?>

	<?php
	// Display comments
	if ( get_theme_mod( 'comments_on_posts', true ) ) : ?>
		<?php comments_template(); ?>
	<?php endif; ?>

</article><!-- .wpex-port-article -->