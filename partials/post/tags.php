<?php
/**
 * Displays the post tags
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

// Return if post tags shouldn't display
if ( post_password_required() ) {
	return;
} 

the_tags( '<div class="wpex-post-tags wpex-clr"><span class="fa fa-tags"></span>' . __( 'Explore:', 'chic' ) .' ', ', ', '</div><!-- .wpex-post-tags -->' ); ?>