<?php
/**
 * Displays the page thumbnail
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

<?php if ( has_post_thumbnail() ) : ?>
	<div class="wpex-page-thumbnail wpex-clr">
		<?php the_post_thumbnail( 'post' ); ?>
	</div><!-- .wpex-page-thumbnail -->
<?php endif; ?>