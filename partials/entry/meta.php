<?php
/**
 * Used to output entry meta info - date, category, comments, author...etc
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

// Get items to display
$meta_items = array( 'date', 'author', 'comments' );
$meta_items	= array_combine( $meta_items, $meta_items );

// You can tweak the meta output via a function, yay!
$meta_items = apply_filters( 'wpex_meta_items', $meta_items );

// Get taxonomy for the posted under section
if ( 'post' == get_post_type() ) {
	$taxonomy = 'category';
} else {
	$taxonomy = NULL;
}

// Get terms
if ( $taxonomy ) {
	$terms = wpex_get_post_terms( $taxonomy );
} else {
	$terms = NULL;
} ?>

<div class="wpex-loop-entry-meta wpex-clr">

	<ul class="wpex-clr">

		<?php
		// Loop through meta options
		foreach ( $meta_items as $meta_item ) : ?>

			<?php
			// Display date
			if ( 'date' == $meta_item ) : ?>

				<li class="wpex-date"><?php _e( 'Posted on', 'chic' ); ?> <span><?php echo get_the_date(); ?></span></li>

			<?php endif; ?>

			<?php
			// Display author
			if ( 'author' == $meta_item ) : ?>

				<li class="wpex-author"><?php _e( 'by', 'chic' ); ?> <?php the_author_posts_link(); ?></li>

			<?php endif; ?>

			<?php
			// Display category
			if ( 'category' == $meta_item && isset( $terms ) ) : ?>

				<li class="wpex-categories"><?php _e( 'in', 'chic' ); ?> <?php echo $terms; ?></li>

			<?php endif; ?>

			<?php
			// Display comments
			if ( 'comments' == $meta_item && comments_open() && wpex_has_comments() ) : ?>

				<li class="wpex-comments"><?php _e( 'with', 'chic' ); ?> <?php comments_popup_link( __( '0 Comments', 'chic' ), __( '1 Comment',  'chic' ), __( '% Comments', 'chic' ), 'comments-link' ); ?></li>

			<?php endif; ?>

		<?php endforeach; ?>

	</ul>

</div><!-- .wpex-entry-meta -->