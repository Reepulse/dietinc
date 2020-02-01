<?php
/**
 * Displays the entry thumbnail.
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

// Display thumbnail
if (  has_post_thumbnail() ) : ?>

	<div class="wpex-loop-entry-thumbnail wpex-loop-entry-media wpex-clr">

		<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>"><?php the_post_thumbnail( 'entry' ); ?></a>

	</div><!-- .wpex-loop-entry-thumbnail -->

<?php endif; ?>