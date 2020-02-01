<?php
/**
 * Edit post link
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

// Not needed for these pages
if ( ( function_exists( 'is_cart' ) && is_cart() ) || ( function_exists( 'is_checkout' ) && is_checkout() ) ) {
	return;
}

// Define text
if ( is_page() ) {
	$text = __( 'Edit This Page', 'chic' );
} else {
	$text = __( 'Edit This Article', 'chic' );
}
$text = apply_filters( 'wpex_post_edit_text', $text );

// Display edit post link
edit_post_link(
	$text,
	'<div class="wpex-post-edit wpex-clr">', '</div>'
); ?>