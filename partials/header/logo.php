<?php
/**
 * Outputs the header logo
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

// Get data
$logo      = wpex_get_header_logo_src();
$blog_name = get_bloginfo( 'name' );
$home_url  = home_url();

// Sanitize data
$blog_name = esc_attr( $blog_name ); ?>

<div class="wpex-site-logo wpex-clr">

	<?php if ( $logo ) : ?>

		<a href="<?php echo $home_url; ?>" title="<?php echo $blog_name; ?>" rel="home">
			<img src="<?php echo $logo; ?>" alt="<?php echo $blog_name; ?>" />
		</a>

	<?php else : ?>

		<div class="site-text-logo wpex-clr">
			<a href="<?php echo $home_url; ?>" title="<?php echo $blog_name; ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</div>

	<?php endif; ?>

</div><!-- .wpex-site-logo -->