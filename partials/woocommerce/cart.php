<?php
/**
 * Shop Carousel
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

<div class="wpex-cart-dropdown wpex-invisible wpex-clr">
	<?php the_widget( 'WC_Widget_Cart' ); ?>
</div><!-- .wpex-cart-dropdown -->