<?php
/**
 * Displays the next/previous post links
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

// Get post navigation
$post_nav = get_the_post_navigation( array(
	'prev_text'	=> '<span>'. __( 'Next Article', 'chic' ) .'</span><i class="fa fa-chevron-right"></i>',
	'next_text'	=> '<i class="fa fa-chevron-left"></i><span>'. __( 'Previous Article', 'chic' ) .'</span>',
) );

// Display post navigation
if ( ! is_attachment() && ! post_password_required() && $post_nav ) : ?>

	<div class="wpex-post-navigation wpex-clr">

		<?php echo $post_nav; ?>

	</div><!-- .wpex-post-navigation -->

<?php endif; ?>