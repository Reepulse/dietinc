<?php
/**
 * Useful conditionals for this theme
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

/**
 * Check if js minify is enabled
 *
 * @since 1.0.0
 */
function wpex_has_minified_js() {
	return apply_filters( 'wpex_has_minified_js', false );
}

/**
 * Check if responsiveness is enabled
 *
 * @since 1.0.0
 */
function wpex_is_responsive() {
	return wpex_get_theme_mod( 'responsive', true );
}

/**
 * Check if sticky header is enabled
 *
 * @since 1.0.0
 */
function wpex_has_sticky_header() {
	return wpex_get_theme_mod( 'sticky_header', true );
}

/**
 * Check if notice bar is enabled
 *
 * @since 1.0.0
 */
function wpex_has_notice_bar() {
	if ( wpex_get_notice_bar_content() ) {
		return true;
	}
}

/**
 * Check if the header search is enabled
 *
 * @since 1.0.0
 */
function wpex_has_header_search() {
	return wpex_get_theme_mod( 'header_search', true );
}

/**
 * Check if comments are enabled
 *
 * @since 1.0.0
 */
function wpex_has_comments( $bool = true ) {
	if ( 'page' == get_post_type() && ! get_theme_mod( 'page_comments', true ) ) {
		$bool = false;
	}
	return apply_filters( 'wpex_has_comments', $bool );
}

/**
 * Check if post has a video
 *
 * @since 1.0.0
 */
function wpex_has_post_video( $bool = false ) {
	if ( get_post_meta( get_the_ID(), 'wpex_post_video', true ) ) {
		$bool = true;
	}
	return apply_filters( 'wpex_has_post_video', $bool );
}

/**
 * Check if facebook comments are enabled
 *
 * @since 1.0.0
 */
function wpex_has_fb_comments( $bool = false ) {
	if ( ! empty( $_GET['theme_fb_comments'] ) ) {
		$bool = $_GET['theme_fb_comments'];
	} elseif ( get_theme_mod( 'fb_comments' ) ) {
		$bool = true;
	}
	return apply_filters( 'wpex_has_fb_comments', $bool );
}

/**
 * Check if woocommerce is active
 *
 * @since 1.0.0
 */
function wpex_is_woocommerce_active() {
	return WPEX_WOOCOMMERCE_ACTIVE;
}

/**
 * Check if the woocommerce carousel should display
 *
 * @since 1.0.0
 */
function wpex_has_woocommerce_carousel() {
	$bool = wpex_is_woocommerce_active();
	if ( 'null' == get_theme_mod( 'woo_carousel_display', 'recent' ) ) {
		$bool = false;
	}
	if ( function_exists( 'is_cart' ) && is_cart() ) {
		$bool = false;
	}
	return apply_filters( 'wpex_has_woocommerce_carousel', $bool );
}

/**
 * Check if social share is enabled
 *
 * @since 1.0.0
 */
function wpex_has_social_share( $bool = true ) {
	$bool = get_theme_mod( 'post_share', true );
	if ( post_password_required() ) {
		$bool = false;
	}
	$bool = apply_filters( 'wpex_has_social_share', $bool );
	return $bool;
}

/**
 * Check if social share is enabled
 *
 * @since 1.0.0
 */
function wpex_has_author_bio( $bool = true ) {
	$bool = get_theme_mod( 'post_author_info', true );
	$bool = apply_filters( 'wpex_has_author_bio', $bool );
	return $bool;
}

/**
 * Check if footer widgets are enabled
 *
 * @since 1.0.0
 */
function wpex_has_footer_widgets( $bool = true ) {
	$columns = get_theme_mod( 'footer_widget_columns', '4' );
	if ( ! $columns || '0' == $columns || 'disable' == $columns ) {
		$bool = false;
	}
	$bool = apply_filters( 'wpex_has_footer_widgets', $bool );
	return $bool;
}

/**
 * Check if custom excerpt is enabled
 *
 * @since 1.0.0
 */
function wpex_has_custom_excerpt() {
	$display = wpex_get_theme_mod( 'entry_content_display', 'excerpt' );
	$length  = wpex_get_entry_excerpt_length();
	if ( 'excerpt' == $display && $length > 0 ) {
		$bool = true;
	} else {
		$bool = false;
	}
	$bool = apply_filters( 'wpex_has_custom_excerpt', $bool );
	return $bool;
}

/**
 * Checks if the posts should display in left/right format
 *
 * @since 1.0.0
 */
function wpex_has_entry_mobile_left_right( $bool = false ) {
	if ( wpex_get_loop_columns() > 1 ) {
		$bool = true;
	}
	$bool = wpex_get_theme_mod( 'entry_mobile_left_right', $bool );
	$bool = apply_filters( 'wpex_has_entry_mobile_left_right', $bool );
	return $bool;
}