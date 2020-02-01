<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */ ?>

<div class="wpex-entry-none wpex-boxed-container wpex-clr">

	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) { ?>

		<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'chic' ), admin_url( 'post-new.php' ) ); ?></p>

	<?php } elseif ( is_search() ) { ?>

		<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'chic' ); ?></p>

	<?php } elseif ( is_category() ) { ?>

		<p><?php _e( 'There aren\'t any posts currently published in this category.', 'chic' ); ?></p>

	<?php } elseif ( is_tax() ) { ?>

		<p><?php _e( 'There aren\'t any posts currently published under this taxonomy.', 'chic' ); ?></p>

	<?php } elseif ( is_tag() ) { ?>

		<p><?php _e( 'There aren\'t any posts currently published under this tag.', 'chic' ); ?></p>

	<?php } elseif ( is_404() ) { ?>
	
		<h1>404</h1>
		<p><?php _e( 'Unfortunately, the page you are looking for does not exist.', 'chic' ); ?></p>

	<?php } else { ?>

		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'chic' ); ?></p>

	<?php } ?>

</div><!-- .wpex-entry-none -->