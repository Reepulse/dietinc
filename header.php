<?php
/**
 * The Header for our theme.
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script><![endif]-->
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<!--[if IE 8]><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie8.css" media="screen"><![endif]-->
</head>

<body <?php body_class(); ?>>

	<?php do_action( 'wpex_after_body_tag' ); ?>

	<div class="wpex-site-wrap wpex-clr">

		<?php get_template_part( 'partials/layout-header' ); ?>

		<?php
		// Homepage slider Above
		if ( ( is_home() || is_front_page() ) && 'above' == get_theme_mod( 'home_slider_location', 'above' ) ) {
			get_template_part( 'partials/home/slider' );
		} ?>
		
		<div class="wpex-site-content wpex-container wpex-clr">