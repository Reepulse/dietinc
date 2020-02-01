<?php
/**
 * Displays Category Thumbnail
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.1.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get thumbnail
$thumbnail = wpex_get_term_thumbnail();

if ( $thumbnail ) : ?>

	<div class="wpex-category-thumbnail wpex-clr">
		<img src="<?php echo $thumbnail; ?>" alt="<?php single_term_title(); ?>" />
	</div><!-- .wpex-category-thumbnail -->

<?php endif; ?>