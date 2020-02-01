<?php
/**
 * Returns the page layout components
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

<article class="wpex-page-article wpex-clr">

	<div class="wpex-boxed-container wpex-clr">

		<?php get_template_part( 'partials/page/thumbnail' ); ?>

		<?php get_template_part( 'partials/page/header' ); ?>

		<?php get_template_part( 'partials/page/content' ); ?>

	</div><!-- .wpex-boxed-container -->

	<?php do_action( 'wpex_page_after_boxed_container' ); // used for woo cart ?>

	<?php get_template_part( 'partials/global/edit' ); ?>

	<?php if ( get_theme_mod( 'comments_on_pages', false ) ) : ?>
		<?php comments_template(); ?>
	<?php endif; ?>

</article><!-- .wpex-page-article -->