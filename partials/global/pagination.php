<?php
/**
 * Outputs pagination
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

// Get global query
global $wp_query, $wpex_query;

// Get total pages based on query
if ( $wpex_query ) {
	$total = $wpex_query->max_num_pages;
} else {
	$total = $wp_query->max_num_pages;
}

if ( $total > 1 ) : ?>

	<div class="wpex-page-numbers wpex-clr"> 

		<?php
		// Get current page
		if ( ! $current_page = get_query_var( 'paged' ) ) {
			$current_page = 1;
		}

		// Get correct permalink structure
		if ( get_option( 'permalink_structure' ) ) {
			$format = 'page/%#%/';
		} else {
			$format = '&paged=%#%';
		}

		// Args
		$args = array(
			'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			'format'    => $format,
			'current'   => max( 1, get_query_var( 'paged') ),
			'total'     => $total,
			'mid_size'  => 3,
			'type'      => 'list',
			'prev_text' => '<i class="fa fa-angle-left"></i>',
			'next_text' => '<i class="fa fa-angle-right"></i>',
		);
		$args = apply_filters( 'wpex_pagination_args', $args );

		// Output pagination
		echo paginate_links( $args ); ?>

	 </div><!-- .page-numbers -->

<?php endif; ?>