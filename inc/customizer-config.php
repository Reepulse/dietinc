<?php
/**
 * Defines all settings for the customizer class
 *
 * @package Chic WordPress Theme
 * @author Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link http://www.wpexplorer.com
 * @since 1.0.0
 */

if ( ! function_exists( 'wpex_customizer_config' ) ) {

	function wpex_customizer_config( $panels ) {

		/*-----------------------------------------------------------------------------------*/
		/* - Useful vars
		/*-----------------------------------------------------------------------------------*/

		// Columns
		$columns = array(
			'' => __( 'Default', 'chic' ),
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
		);

		// Accents
		$accents = array(
			'' => __( 'Default', 'chic' ),
			'#27ae60' => __( 'Green', 'chic' ),
			'#e67e22' => __( 'Orange', 'chic' ),
			'#2980b9' => __( 'Blue', 'chic' ),
			'#2c3e50' => __( 'Navy', 'chic' ),
			'#c0392b' => __( 'Red', 'chic' ),
			'#8e44ad' => __( 'Purple', 'chic' ),
			'#16a085' => __( 'Teal', 'chic' ),
			'#1abc9c' => __( 'Turquoise', 'chic' ),
			'#7f8c8d' => __( 'Gray', 'chic' ),
		);

		// Layouts
		$layouts = array(
			'' => __( 'Default', 'chic' ),
			'right-sidebar' => __( 'Right Sidebar', 'chic' ),
			'left-sidebar' => __( 'Left Sidebar', 'chic' ),
			'full-width' => __( 'No Sidebar', 'chic' ),
		);
		
		// Font Weights
		$font_weights = array(
			'' => __( 'Default', 'chic' ),
			'100' => '100',
			'200' => '200',
			'300' => '300',
			'400' => '400',
			'500' => '500',
			'600' => '600',
			'700' => '700',
			'800' => '800',
			'900' => '900',
		);

		// Get parent categories
		$parent_cats = get_categories( array(
			'orderby' => 'name',
			'parent' => 0
		) );

		// Homepage slider choices
		$slider_slider_choices = array(
			''			 => __( 'None - Disable', 'chic' ),
			'custom_code'	=> __( 'Custom HTML or Shortcode', 'chic' ),
			'recent_posts'	=> __( 'Recent Posts', 'chic' ),
		);
		if ( $parent_cats && is_array( $parent_cats ) ) {
			foreach ( $parent_cats as $cat ) {
				$slider_slider_choices[$cat->term_id] = $cat->name;
			}
		}

		// Homepage cat choices
		$home_cat_choices = array();
		$home_cat_default = null;
		if ( $parent_cats && is_array( $parent_cats ) ) {
			foreach ( $parent_cats as $cat ) {
				$home_cat_default .= $cat->term_id .',';
				$home_cat_choices[$cat->term_id] = $cat->name;
			}
		}


		// Login page choices
		$login_page_choices = array(
			''	 => __( 'None - Disable', 'chic' ),
			'wp_login'	=> __( 'WordPress Login', 'chic' ),
		);
		$pages = get_pages( array(
			'number' => 100,
		) );
		if ( $pages && is_array( $pages ) ) {
			foreach ( $pages as $page ) {
				$login_page_choices[$page->ID] = $page->post_title;
			}
		}

		/*-----------------------------------------------------------------------------------*/
		/* - General Panel
		/*-----------------------------------------------------------------------------------*/
		$panels['general'] = array(
			'title' => __( 'General Theme Settings', 'chic' ),
			'sections' => array()
		);

		// Site Widths
		$panels['general']['sections']['site-widths'] = array(
			'id' => 'wpex_site_widths',
			'title' => __( 'Site Widths', 'chic' ),
			'settings' => array(
				array(
					'id' => 'layout_container_width',
					'default' => '1100px',
					'control' => array (
						'label' => __( 'Container Width', 'chic' ),
						'type' => 'text',
					),
				),
				array(
					'id' => 'layout_container_max_width',
					'default' => '85&#37;',
					'control' => array (
						'label' => __( 'Container Max Width Percent', 'chic' ),
						'type' => 'text',
						'active_callback' => 'wpex_is_responsive',
					),
				),
				array(
					'id' => 'layout_content_width',
					'default' => '68.18&#37;',
					'control' => array (
						'label' => __( 'Content Area Width', 'chic' ),
						'type' => 'text',
					),
				),
				array(
					'id' => 'layout_sidebar_width',
					'default' => '27.27&#37;',
					'control' => array (
						'label' => __( 'Sidebar Width', 'chic' ),
						'type' => 'text',
					),
				),
			),
		);

		// Layouts
		$panels['general']['sections']['layouts'] = array(
			'id' => 'wpex_layouts',
			'title' => __( 'Layouts', 'chic' ),
			'settings' => array(
				array(
					'id' => 'home_layout',
					'control' => array (
						'label' => __( 'Homepage Layout', 'chic' ),
						'type' => 'select',
						'choices' => $layouts,
					),
				),
				array(
					'id' => 'archives_layout',
					'control' => array (
						'label' => __( 'Archives Layout', 'chic' ),
						'type' => 'select',
						'choices' => $layouts,
						'desc' => __( 'Categories, tags, author...etc', 'chic' ),
					),
				),
				array(
					'id' => 'search_layout',
					'control' => array (
						'label' => __( 'Search Layout', 'chic' ),
						'type' => 'select',
						'choices' => $layouts,
					),
				),
				array(
					'id' => 'post_layout',
					'control' => array (
						'label' => __( 'Post Layout', 'chic' ),
						'type' => 'select',
						'choices' => $layouts,
					),
				),
				array(
					'id' => 'page_layout',
					'control' => array (
						'label' => __( 'Page Layout', 'chic' ),
						'type' => 'select',
						'choices' => $layouts,
					),
				),
			),
		);

		// Responsive
		$panels['general']['sections']['responsive'] = array(
			'id' => 'wpex_responsive',
			'title' => __( 'Responsiveness', 'chic' ),
			'settings' => array(
				array(
					'id' => 'responsive',
					'default' => true,
					'control' => array (
						'label' => __( 'Enable', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'mobile_menu_switch_point',
					'control' => array (
						'label' => __( 'Custom Mobile Menu Switch Point', 'chic' ),
						'type' => 'text',
						'desc' => __( 'The default is 1120 for the default header style and 960 for the full width menu header style. Enter -1 to display toggle menu always.', 'chic' ),
						'active_callback' => 'wpex_is_responsive',
					),
				),
				array(
					'id' => 'mobile_menu_toggle_text',
					'default' => __( 'Menu', 'chic' ),
					'control' => array (
						'label' => __( 'Mobile Menu Toggle Text', 'chic' ),
						'type' => 'text',
						'active_callback' => 'wpex_is_responsive',
					),
				),
			),
		);

		// Notice bar section
		$panels['general']['sections']['notice_bar'] = array(
			'id' => 'wpex_notice_bar',
			'title' => __( 'Notice bar', 'chic' ),
			'settings' => array(
				array(
					'id' => 'notice_bar_content',
					'default' => 'Get 30&#37; off our store with coupon code 30PERCENTOFF!',
					'control' => array (
						'label' => __( 'Notice Bar Content', 'chic' ),
						'type' => 'textarea',
					),
				),
			),
		);

		// Header Section
		$panels['general']['sections']['general'] = array(
			'id' => 'wpex_general',
			'title' => __( 'Header', 'chic' ),
			'settings' => array(
				array(
					'id' => 'header_style',
					'default' => 'default',
					'control' => array (
						'label' => __( 'Header Style', 'chic' ),
						'type' => 'select',
						'choices' => array(
							'default' => __( 'Default', 'chic' ),
							'centered-logo-full-nav' => __( 'Centered Logo & Full Nav', 'chic' ),
						),
					),
				),
				array(
					'id' => 'full_nav_location',
					'default' => 'bottom',
					'control' => array (
						'label' => __( 'Full Nav Position', 'chic' ),
						'type' => 'select',
						'active_callback' => 'wpex_has_full_nav',
						'choices' => array(
							'bottom' => __( 'Bottom', 'chic' ),
							'top' => __( 'Top', 'chic' ),
						),
					),
				),
				array(
					'id' => 'sticky_header',
					'default' => true,
					'control' => array (
						'label' => __( 'Sticky Header/Menu', 'chic' ),
						'type' => 'checkbox'
					),
				),
				array(
					'id' => 'site_description',
					'default' => true,
					'control' => array (
						'label' => __( 'Display description?', 'chic' ),
						'type' => 'checkbox'
					),
				),
				array(
					'id' => 'header_search',
					'default' => true,
					'control' => array (
						'label' => __( 'Display Search In Menu?', 'chic' ),
						'type' => 'checkbox'
					),
				),
				array(
					'id' => 'menu_login_icon_page',
					'control' => array (
						'label' => __( 'Menu Login Icon URL', 'chic' ),
						'type' => 'select',
						'choices' => $login_page_choices,
					),
				),
				array(
					'id' => 'logo',
					'control' => array (
						'label' => __( 'Custom Logo', 'chic' ),
						'type' => 'upload',
					),
				),
				array(
					'id' => 'logo_retina',
					'control' => array (
						'label' => __( 'Custom Retina Logo', 'chic' ),
						'type' => 'upload',
					),
				),
				array(
					'id' => 'logo_retina_height',
					'control' => array (
						'label' => __( 'Standard Logo Height', 'chic' ),
						'desc' => __( 'Enter the standard height for your logo. Used to set your retina logo to the correct dimensions', 'chic' ),
					),
				),
			),
		);

		// Header Social
		$social_options = wpex_header_social_options_array();
		
		if ( $social_options ) {

			$panels['general']['sections']['social_header'] = array(
				'id' => 'wpex_social_header',
				'title' => __( 'Header Social Profiles', 'chic' ),
				'desc' => __( 'Enter the full URL to your social media profile.', 'chic' ),
				'settings' => array(),
			);

			foreach ( $social_options as $key => $val ) {

				// Set defaults
				$default = null;
				if ( 'twitter' == $key ) {
					$default = 'http://twitter.com/';
				} elseif ( 'facebook' == $key ) {
					$default = 'http://facebook.com/';
				} elseif ( 'instagram' == $key ) {
					$default = 'http://instagram.com/';
				}

				$panels['general']['sections']['social_header']['settings'][$key] = array(
					'id' => 'header_social_'. $key,
					'default' => $default,
					'control' => array (
						'label' => $val['label'] .' - '. __( 'URL', 'chic' ),
					),
				);


			}

		}

		// Homepage
		$panels['general']['sections']['homepage_slider'] = array(
			'id' => 'wpex_homepage_slider',
			'title' => __( 'Homepage Slider', 'chic' ),
			'settings' => array(
				array(
					'id' => 'home_slider_location',
					'default' => 'above',
					'control' => array (
						'label' => __( 'Homepage Slider Location', 'chic' ),
						'type' => 'select',
						'choices' => array(
							'above' => __( 'Above', 'chic' ),
							'inline' => __( 'Inline', 'chic' ),
						),
					),
				),
				array(
					'id' => 'home_slider_content',
					'default' => 'recent_posts',
					'control' => array (
						'label' => __( 'Homepage Slider Content', 'chic' ),
						'type' => 'select',
						'choices' => $slider_slider_choices,
					),
				),
				array(
					'id' => 'home_slider_count',
					'default' => 4,
					'control' => array (
						'label' => __( 'Homepage Slider Count', 'chic' ),
						'type' => 'text',
						'active_callback' => 'wpex_is_slider_not_custom',
					),
				),
				array(
					'id' => 'home_slider_exclude_posts',
					'default' => false,
					'control' => array (
						'label' => __( 'Exclude Posts', 'chic' ),
						'type' => 'checkbox',
						'desc' => __( 'Check this box to exclude posts included in the carousel from the homepage grid.', 'chic' ),
						'active_callback' => 'wpex_is_slider_not_custom',
					),
				),
				array(
					'id' => 'home_slider_slideshow',
					'default' => true,
					'control' => array (
						'label' => __( 'Automatic Slideshow', 'chic' ),
						'type' => 'checkbox',
						'active_callback' => 'wpex_is_slider_not_custom',
					),
				),
				array(
					'id' => 'home_slider_pause',
					'default' => 5000,
					'control' => array (
						'label' => __( 'Slideshow Pause Time', 'chic' ),
						'type' => 'text',
						'desc' => __( 'Enter a value in milliseconds.', 'chic' ),
						'active_callback' => 'wpex_is_slider_not_custom',
					),
				),
				array(
					'id' => 'home_slider_custom_code',
					'control' => array (
						'label' => __( 'Custom Code', 'chic' ),
						'type' => 'textarea',
						'desc' => __( 'HTML and shortcodes allowed.', 'chic' ),
						'active_callback' => 'wpex_is_slider_custom',
					),
				),
			),
		);

		// Homepage
		if ( $home_cat_choices ) {

			$panels['general']['sections']['homepage_cats'] = array(
				'id' => 'wpex_homepage_cats',
				'title' => __( 'Homepage Categories', 'chic' ),
				'desc' => __( 'Settings used for the Category Homepage page template.', 'chic' ),
				'settings' => array(
					array(
						'id' => 'home_cats_view_all',
						'default' => true,
						'control' => array (
							'label' => __( 'View All Link', 'chic' ),
							'type' => 'checkbox',
						),
					),
					array(
						'id' => 'home_cats_posts_per_cat',
						'default' => 2,
						'control' => array (
							'label' => __( 'Posts Per Category', 'chic' ),
							'type' => 'text',
						),
					),
					array(
						'id' => 'home_cats_columns',
						'control' => array (
							'label' => __( 'Columns', 'chic' ),
							'type' => 'select',
							'choices' => $columns
						),
					),
					array(
						'id' => 'home_cats_entry_excerpt_length',
						'default' => 20,
						'control' => array (
							'label' => __( 'Excerpt Length', 'chic' ),
							'type' => 'text',
							'desc' => __( 'How many words to display per excerpt', 'chic' ),
						),
					),
					array(
						'id' => 'home_cats',
						'default' => $home_cat_default,
						'control' => array (
							'label' => __( 'Homepage Categories', 'chic' ),
							'type' => 'sorter',
							'choices' => $home_cat_choices,
						),
					),
				),
			);

		}

		// Entries
		$panels['general']['sections']['entries'] = array(
			'id' => 'wpex_entries',
			'title' => __( 'Entries', 'chic' ),
			'settings' => array(
				array(
					'id' => 'homepage_entry_columns',
					'default' => 1,
					'control' => array (
						'label' => __( 'Homepage Entry Columns', 'chic' ),
						'type' => 'select',
						'choices' => $columns,
					),
				),
				array(
					'id' => 'archives_entry_columns',
					'default' => 1,
					'control' => array (
						'label' => __( 'Archives Entry Columns', 'chic' ),
						'type' => 'select',
						'choices' => $columns,
						'desc' => __( 'Categories, tags, author...etc', 'chic' ),
					),
				),
				array(
					'id' => 'search_entry_columns',
					'default' => 1,
					'control' => array (
						'label' => __( 'Search Entry Columns', 'chic' ),
						'type' => 'select',
						'choices' => $columns,
					),
				),
				array(
					'id' => 'search_entry_columns',
					'default' => 1,
					'control' => array (
						'label' => __( 'Search Entry Columns', 'chic' ),
						'type' => 'select',
						'choices' => $columns,
					),
				),
				array(
					'id' => 'entry_content_display',
					'default' => 'excerpt',
					'control' => array (
						'label' => __( 'Entry Displays?', 'chic' ),
						'type' => 'select',
						'choices' => array(
							'excerpt' => __( 'Custom Excerpt', 'chic' ),
							'content' => __( 'Full Content', 'chic' ),
						),
					),
				),
				array(
					'id' => 'entry_excerpt_length',
					'default' => 45,
					'control' => array (
						'label' => __( 'Entry Excerpt Length', 'chic' ),
						'type' => 'text',
						'desc' => __( 'How many words to display per excerpt', 'chic' ),
						'active_callback' => 'wpex_has_custom_excerpt'
					),
				),
				array(
					'id' => 'entry_thumbnail',
					'default' => true,
					'control' => array (
						'label' => __( 'Entry Thumbnail', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'entry_category',
					'default' => true,
					'control' => array (
						'label' => __( 'Entry Category Tag', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'entry_category_first_only',
					'default' => true,
					'control' => array (
						'label' => __( 'Display First Category Only', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'entry_meta',
					'default' => true,
					'control' => array (
						'label' => __( 'Entry Meta', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'entry_readmore',
					'default' => true,
					'control' => array (
						'label' => __( 'Entry Readmore', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'entry_readmore_text',
					'control' => array (
						'label' => __( 'Entry Readmore Text', 'chic' ),
						'type' => 'text',
					),
				),
			),
		);

		// Posts
		$panels['general']['sections']['posts'] = array(
			'id' => 'wpex_posts',
			'title' => __( 'Posts', 'chic' ),
			'settings' => array(
				array(
					'id' => 'post_thumbnail',
					'default' => true,
					'control' => array (
						'label' => __( 'Post Thumbnail', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_category',
					'default' => true,
					'control' => array (
						'label' => __( 'Entry Category Tag', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_category_first_only',
					'default' => true,
					'control' => array (
						'label' => __( 'Display First Category Only', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_meta',
					'default' => true,
					'control' => array (
						'label' => __( 'Post Meta', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_tags',
					'default' => true,
					'control' => array (
						'label' => __( 'Post Tags', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_share',
					'default' => true,
					'control' => array (
						'label' => __( 'Post Social Share', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_author_info',
					'default' => true,
					'control' => array (
						'label' => __( 'Post Author Box', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_related',
					'default' => true,
					'control' => array (
						'label' => __( 'Post Related', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'post_related_displays',
					'default' => 'random',
					'control' => array (
						'label' => __( 'Post Related: Displays?', 'chic' ),
						'type' => 'select',
						'choices' => array(
							'random' => __( 'Random Posts', 'chic' ),
							'related_category' => __( 'Related From Same Category', 'chic' ),
						),
					),
				),
				array(
					'id' => 'post_related_count',
					'default' => 4,
					'control' => array (
						'label' => __( 'Post Related Count', 'chic' ),
						'type' => 'number',
					),
				),
			),
		);

		// Footer
		$panels['general']['sections']['footer'] = array(
			'id' => 'wpex_footer',
			'title' => __( 'Footer', 'chic' ),
			'settings' => array(
				array(
					'id' => 'footer_widget_columns',
					'default' => 4,
					'control' => array (
						'label' => __( 'Footer Widgets Columns', 'chic' ),
						'type' => 'select',
						'choices' => array(
							'disable' => __( 'None - Disable', 'chic' ),
							1 => 1,
							2 => 2,
							3 => 3,
							4 => 4,
						)
					),
				),
				array(
					'id' => 'footer_copyright',
					'default' => '<a href="http://www.wordpress.org" title="WordPress" target="_blank">WordPress</a> Theme Designed &amp; Developed by <a href="http://www.wpexplorer.com/" target="_blank" title="WPExplorer">WPExplorer</a>',
					'control' => array (
						'label' => __( 'Footer Copyright', 'chic' ),
						'type' => 'textarea',
					),
				),
			),
		);

		// Footer Social
		$social_options = wpex_footer_social_options_array();

		if ( $social_options ) {

			$panels['general']['sections']['social_footer'] = array(
				'id' => 'wpex_social_footer',
				'title' => __( 'Footer Social Profiles', 'chic' ),
				'desc' => __( 'Enter the full URL to your social media profile.', 'chic' ),
				'settings' => array(
					array(
						'id' => 'footer_social',
						'default' => true,
						'control' => array (
							'label' => __( 'Footer Social', 'chic' ),
							'type' => 'checkbox',
						),
					),
					array(
						'id' => 'footer_social_font_size',
						'control' => array (
							'label' => __( 'Font Size', 'chic' ),
							'type' => 'textfield',
						),
						'inline_css' => array(
							'target' => '.wpex-footer-social',
							'alter' => 'font-size',
							'sanitize' => 'px',
						),
					),
				),
			);

			foreach ( $social_options as $key => $val ) {

				// Set defaults
				$default = null;
				if ( 'twitter' == $key ) {
					$default = 'http://twitter.com/';
				} elseif ( 'facebook' == $key ) {
					$default = 'http://facebook.com/';
				} elseif ( 'instagram' == $key ) {
					$default = 'http://instagram.com/';
				} elseif ( 'youtube' == $key ) {
					$default = 'http://youtube.com/';
				} elseif ( 'rss' == $key ) {
					$default = home_url() .'/rss/';
				}


				$panels['general']['sections']['social_footer']['settings'][$key] = array(
					'id' => 'footer_social_'. $key,
					'default' => $default,
					'control' => array (
						'label' => $val['label'] .' - '. __( 'URL', 'chic' ),
					),
				);


			}

		}

		// Advertisement
		$panels['general']['sections']['ads'] = array(
			'id' => 'wpex_ads',
			'title' => __( 'Advertisements', 'chic' ),
			'settings' => array(
				array(
					'id' => 'ad_homepage_top',
					'default' => '<img src="'. get_template_directory_uri() .'/images/750x90.jpg" alt="'. __( 'Banner', 'chic' ) .'" />',
					'control' => array (
						'label' => __( 'Homepage: Top', 'chic' ),
						'type' => 'textarea',
					),
				),
				array(
					'id' => 'ad_homepage_bottom',
					'default' => '<img src="'. get_template_directory_uri() .'/images/750x90.jpg" alt="'. __( 'Banner', 'chic' ) .'" />',
					'control' => array (
						'label' => __( 'Homepage: Bottom', 'chic' ),
						'type' => 'textarea',
					),
				),
				array(
					'id' => 'ad_archives_top',
					'default' => '<img src="'. get_template_directory_uri() .'/images/750x90.jpg" alt="'. __( 'Banner', 'chic' ) .'" />',
					'control' => array (
						'label' => __( 'Archives: Top', 'chic' ),
						'type' => 'textarea',
					),
				),
				array(
					'id' => 'ad_archives_bottom',
					'default' => '<img src="'. get_template_directory_uri() .'/images/750x90.jpg" alt="'. __( 'Banner', 'chic' ) .'" />',
					'control' => array (
						'label' => __( 'Archives: Bottom', 'chic' ),
						'type' => 'textarea',
					),
				),
				array(
					'id' => 'ad_single_top',
					'default' => '<img src="'. get_template_directory_uri() .'/images/750x90.jpg" alt="'. __( 'Banner', 'chic' ) .'" />',
					'control' => array (
						'label' => __( 'Post: Top', 'chic' ),
						'type' => 'textarea',
					),
				),
				array(
					'id' => 'ad_single_bottom',
					'default' => '<img src="'. get_template_directory_uri() .'/images/750x90.jpg" alt="'. __( 'Banner', 'chic' ) .'" />',
					'control' => array (
						'label' => __( 'Post: Bottom', 'chic' ),
						'type' => 'textarea',
					),
				),
			),
		);

		// Discussion
		$panels['general']['sections']['discussion'] = array(
			'id' => 'wpex_site_discussion',
			'title' => __( 'Discussion', 'chic' ),
			'settings' => array(
				array(
					'id' => 'comments_on_pages',
					'default' => false,
					'control' => array (
						'label' => __( 'Comments For Pages', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'comments_on_posts',
					'default' => true,
					'control' => array (
						'label' => __( 'Comments For Posts', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'fb_comments',
					'default' => false,
					'control' => array (
						'label' => __( 'Enable Facebook Comments', 'chic' ),
						'type' => 'checkbox',
					),
				),
				array(
					'id' => 'disable_comment_form_notes',
					'default' => false,
					'control' => array (
						'label' => __( 'Disable Comment Form Notes', 'chic' ),
						'type' => 'checkbox',
						'desc' => __( 'This is the part that says what tags you can use in your comment', 'chic' ),
					),
				),
			)
		);

		/*-----------------------------------------------------------------------------------*/
		/* - WooCommerce
		/*-----------------------------------------------------------------------------------*/

		if ( wpex_is_woocommerce_active() ) {

			$panels['woocommerce'] = array(
				'title' => __( 'WooCommerce', 'chic' ),
				'sections' => array()
			);

			// Menu Section
			$panels['woocommerce']['sections']['menu_shop'] = array(
				'id' => 'wpex_woocommerce_menu_shop',
				'title' => __( 'Menu Shop Icon', 'chic' ),
				'settings' => array(
					array(
						'id' => 'menu_shop_type',
						'default' => 'cart_dropdown',
						'control' => array (
							'label' => __( 'Menu Shop Type', 'chic' ),
							'type' => 'select',
							'choices' => array(
								'disabled' => __( 'Disabled', 'chic' ),
								'cart_dropdown' => __( 'Cart Dropdown', 'chic' ),
								'link_to_shop' => __( 'Link To Shop', 'chic' ),
								'link_to_cart' => __( 'Link To Cart', 'chic' ),
							),
						),
					),
				),
			);

			// Shop Section
			$panels['woocommerce']['sections']['shop'] = array(
				'id' => 'wpex_woocommerce_shop',
				'title' => __( 'Shop', 'chic' ),
				'settings' => array(
					array(
						'id' => 'woo_shop_layout',
						'control' => array (
							'label' => __( 'Layout', 'chic' ),
							'type' => 'select',
							'choices' => $layouts,
						),
					),
					array(
						'id' => 'woo_shop_count',
						'default' => 12,
						'control' => array (
							'label' => __( 'Shop Count', 'chic' ),
							'type' => 'text',
						),
					),
					array(
						'id' => 'woo_shop_columns',
						'default' => 3,
						'control' => array (
							'label' => __( 'Shop Columns', 'chic' ),
							'type' => 'select',
							'choices' => array(
								1 => 1,
								2 => 2,
								3 => 3,
								4 => 4,
							),
						),
					),
				),
			);

			// Product Section
			$panels['woocommerce']['sections']['product'] = array(
				'id' => 'wpex_woocommerce_product',
				'title' => __( 'Product', 'chic' ),
				'settings' => array(
					array(
						'id' => 'woo_product_layout',
						'control' => array (
							'label' => __( 'Layout', 'chic' ),
							'type' => 'select',
							'choices' => $layouts,
						),
					),
					array(
						'id' => 'woo_upsells_count',
						'default' => 3,
						'control' => array (
							'label' => __( 'Up-sells Count', 'chic' ),
							'type' => 'text',
						),
					),
					array(
						'id' => 'woo_upsells_columns',
						'default' => 3,
						'control' => array (
							'label' => __( 'Up-Sells Columns', 'chic' ),
							'type' => 'select',
							'choices' => array(
								1 => 1,
								2 => 2,
								3 => 3,
								4 => 4,
							),
						),
					),
					array(
						'id' => 'woo_related_count',
						'default' => 3,
						'control' => array (
							'label' => __( 'Related Count', 'chic' ),
							'type' => 'text',
						),
					),
					array(
						'id' => 'woo_related_columns',
						'default' => 3,
						'control' => array (
							'label' => __( 'Related Columns', 'chic' ),
							'type' => 'select',
							'choices' => array(
								1 => 1,
								2 => 2,
								3 => 3,
								4 => 4,
							),
						),
					),
				),
			);

			// Carousel Section
			$panels['woocommerce']['sections']['carousel'] = array(
				'id' => 'wpex_woocommerce_carousel',
				'title' => __( 'Carousel', 'chic' ),
				'settings' => array(
					array(
						'id' => 'woo_carousel_display',
						'default' => 'recent',
						'control' => array (
							'label' => __( 'Display?', 'chic' ),
							'type' => 'select',
							'choices' => array(
								'null' => __( 'None (Disabled)', 'chic' ),
								'recent' => __( 'Recent Products', 'chic' ),
							),
						),
					),
					array(
						'id' => 'woo_carousel_count',
						'default' => 10,
						'control' => array (
							'label' => __( 'Count', 'chic' ),
							'type' => 'text',
						),
					),
					array(
						'id' => 'woo_carousel_columns',
						'default' => 5,
						'control' => array (
							'label' => __( 'Columns', 'chic' ),
							'type' => 'text',
						),
					),
					array(
						'id' => 'woo_carousel_margin',
						'default' => 30,
						'control' => array (
							'label' => __( 'Margin Between Items', 'chic' ),
							'type' => 'text',
						),
					),
				),
			);

		}


		/*-----------------------------------------------------------------------------------*/
		/* - Typography
		/*-----------------------------------------------------------------------------------*/
		$panels['typography'] = array(
			'title' => __( 'Typography', 'chic' ),
			'sections' => array(

				// Body Typography
				array(
					'id' => 'body',
					'title' => __( 'Body', 'chic' ),
					'settings' => array(
						array(
							'id' => 'body_font_family',
							'default' => 'Droid Serif',
							'control' => array (
								'label' => __( 'Font Family', 'chic' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => 'body, a#cancel-comment-reply-link',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'body_font_weight',
							'control' => array (
								'label' => __( 'Font Weight', 'chic' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => 'body',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'body_font_size',
							'control' => array (
								'label' => __( 'Font Size', 'chic' ),
							),
							'inline_css' => array(
								'target' => 'body',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'body_letter_spacing',
							'control' => array (
								'label' => __( 'Letter Spacing', 'chic' ),
							),
							'inline_css' => array(
								'target' => 'body',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Logo Typography
				array(
					'id' => 'wpex_logo_typography',
					'title' => __( 'Logo', 'chic' ),
					'settings' => array(
						array(
							'id' => 'logo_font_family',
							'default' => 'Open Sans',
							'control' => array (
								'label' => __( 'Font Family', 'chic' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.wpex-site-logo',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'logo_font_weight',
							'control' => array (
								'label' => __( 'Font Weight', 'chic' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.wpex-site-logo .site-text-logo',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'logo_size',
							'control' => array (
								'label' => __( 'Font Size', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.wpex-site-logo .site-text-logo',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'logo_letter_spacing',
							'control' => array (
								'label' => __( 'Letter Spacing', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.wpex-site-logo .site-text-logo',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Menu Typography
				array(
					'id' => 'wpex_menu_typography',
					'title' => __( 'Menu', 'chic' ),
					'settings' => array(
						array(
							'id' => 'menu_font_family',
							'default' => 'Open Sans',
							'control' => array (
								'label' => __( 'Font Family', 'chic' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.wpex-site-nav',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'menu_font_weight',
							'control' => array (
								'label' => __( 'Font Weight', 'chic' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.wpex-site-nav .wpex-dropdown-menu a',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'menu_font_size',
							'control' => array (
								'label' => __( 'Font Size', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.wpex-site-nav .wpex-dropdown-menu a',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'menu_letter_spacing',
							'control' => array (
								'label' => __( 'Letter Spacing', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.wpex-site-nav .wpex-dropdown-menu a',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Mobile Menu Typography
				array(
					'id' => 'wpex_mobile_menu_typography',
					'title' => __( 'Mobile Menu', 'chic' ),
					'settings' => array(
						array(
							'id' => 'mobile_menu_font_family',
							'default' => 'Open Sans',
							'control' => array (
								'label' => __( 'Font Family', 'chic' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '#wpex-main-sidr',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'mobile_menu_font_weight',
							'control' => array (
								'label' => __( 'Font Weight', 'chic' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '#wpex-main-sidr',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'mobile_menu_font_size',
							'control' => array (
								'label' => __( 'Font Size', 'chic' ),
							),
							'inline_css' => array(
								'target' => '#wpex-main-sidr',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'mobile_menu_letter_spacing',
							'control' => array (
								'label' => __( 'Letter Spacing', 'chic' ),
							),
							'inline_css' => array(
								'target' => '#wpex-main-sidr',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Headings Typography
				array(
					'id' => 'wpex_headings_typography',
					'title' => __( 'Headings', 'chic' ),
					'desc' => 'h1,h2,h3,h4,h5,h6',
					'settings' => array(
						array(
							'id' => 'headings_font_family',
							'default' => 'Playfair Display',
							'control' => array (
								'label' => __( 'Font Family', 'chic' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => 'h1,h2,h3,h4,h5,h6,.wpex-heading-font-family, .theme-heading',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'headings_font_weight',
							'default' => '400',
							'control' => array (
								'label' => __( 'Font Weight', 'chic' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => 'h1,h2,h3,h4,h5,h6,.wpex-heading-font-family, .theme-heading',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'headings_letter_spacing',
							'control' => array (
								'label' => __( 'Letter Spacing', 'chic' ),
							),
							'inline_css' => array(
								'target' => 'h1,h2,h3,h4,h5,h6,.wpex-heading-font-family, .theme-heading',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Entry Category
				array(
					'id' => 'wpex_entry_cat_typography',
					'title' => __( 'Entry Category', 'chic' ),
					'settings' => array(
						array(
							'id' => 'entry_cat_font_family',
							'default' => 'Open Sans',
							'control' => array (
								'label' => __( 'Font Family', 'chic' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.wpex-entry-cat',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'entry_cat_font_weight',
							'control' => array (
								'label' => __( 'Font Weight', 'chic' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.wpex-entry-cat',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'entry_cat_size',
							'control' => array (
								'label' => __( 'Font Size', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.wpex-entry-cat',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'entry_cat_letter_spacing',
							'control' => array (
								'label' => __( 'Letter Spacing', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.wpex-entry-cat',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Entry Title Typography
				array(
					'id' => 'wpex_entry_title_typography',
					'title' => __( 'Entry Title', 'chic' ),
					'settings' => array(
						array(
							'id' => 'entry_title_font_family',
							'control' => array (
								'label' => __( 'Font Family', 'chic' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.wpex-loop-entry-title',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'entry_title_font_weight',
							'control' => array (
								'label' => __( 'Font Weight', 'chic' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.wpex-loop-entry-title',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'entry_title_size',
							'control' => array (
								'label' => __( 'Font Size', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.wpex-loop-entry-title',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'entry_title_color',
							'control' => array (
								'label' => __( 'Text Color', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-loop-entry-title a',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'entry_title_letter_spacing',
							'control' => array (
								'label' => __( 'Letter Spacing', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.wpex-loop-entry-title a',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Readmore button Titles Typography
				array(
					'id' => 'wpex_readmore_typography',
					'title' => __( 'ReadMore Button', 'chic' ),
					'settings' => array(
						array(
							'id' => 'readmore_font_family',
							'control' => array (
								'label' => __( 'Font Family', 'chic' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.wpex-readmore',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'readmore_font_weight',
							'control' => array (
								'label' => __( 'Font Weight', 'chic' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.wpex-readmore',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'readmore_size',
							'control' => array (
								'label' => __( 'Font Size', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.wpex-readmore',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'readmore_letter_spacing',
							'control' => array (
								'label' => __( 'Letter Spacing', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.wpex-readmore',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Post Title Typography
				array(
					'id' => 'wpex_post_title_typography',
					'title' => __( 'Post Title', 'chic' ),
					'settings' => array(
						array(
							'id' => 'post_title_font_family',
							'control' => array (
								'label' => __( 'Font Family', 'chic' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.wpex-post-title',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'post_title_font_weight',
							'control' => array (
								'label' => __( 'Font Weight', 'chic' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.wpex-post-title',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'post_title_size',
							'control' => array (
								'label' => __( 'Font Size', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.wpex-post-title',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'post_title_color',
							'control' => array (
								'label' => __( 'Text Color', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-post-title',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'post_title_letter_spacing',
							'control' => array (
								'label' => __( 'Letter Spacing', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.wpex-post-title',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Post Typography
				array(
					'id' => 'wpex_post_typography',
					'title' => __( 'Main Content', 'chic' ),
					'settings' => array(
						array(
							'id' => 'post_font_family',
							'control' => array (
								'label' => __( 'Font Family', 'chic' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.entry',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'post_font_weight',
							'control' => array (
								'label' => __( 'Font Weight', 'chic' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.entry',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'post_size',
							'control' => array (
								'label' => __( 'Font Size', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.entry',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'post_color',
							'control' => array (
								'label' => __( 'Text Color', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.entry',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'post_letter_spacing',
							'control' => array (
								'label' => __( 'Letter Spacing', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.entry',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

				// Widget Titles Typography
				array(
					'id' => 'wpex_sidebar_heading_typography',
					'title' => __( 'Widget Titles', 'chic' ),
					'settings' => array(
						array(
							'id' => 'sidebar_heading_font_family',
							'default' => 'Open Sans',
							'control' => array (
								'label' => __( 'Font Family', 'chic' ),
								'type' => 'google_font',
							),
							'inline_css' => array(
								'target' => '.wpex-sidebar .widget-title',
								'alter' => 'font-family',
							),
						),
						array(
							'id' => 'sidebar_heading_font_weight',
							'control' => array (
								'label' => __( 'Font Weight', 'chic' ),
								'type' => 'select',
								'choices' => $font_weights,
							),
							'inline_css' => array(
								'target' => '.wpex-sidebar .widget-title',
								'alter' => 'font-weight',
							),
						),
						array(
							'id' => 'sidebar_heading_size',
							'control' => array (
								'label' => __( 'Font Size', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.wpex-sidebar .widget-title',
								'alter' => 'font-size',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'sidebar_heading_color',
							'control' => array (
								'label' => __( 'Color', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-sidebar .widget-title',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'sidebar_heading_letter_spacing',
							'control' => array (
								'label' => __( 'Letter Spacing', 'chic' ),
							),
							'inline_css' => array(
								'target' => '.wpex-sidebar .widget-title',
								'alter' => 'letter-spacing',
								'sanitize' => 'px',
							),
						),
					),
				),

			),
		);

		/*-----------------------------------------------------------------------------------*/
		/* - Styling Panel
		/*-----------------------------------------------------------------------------------*/
		$panels['styling'] = array(
			'title' => __( 'Styling', 'chic' ),
			'sections' => array(

				// Main
				array(
					'id' => 'wpex_styling_main',
					'title' => __( 'Main', 'chic' ),
					'settings' => array(
						array(
							'id' => 'body_bg',
							'control' => array (
								'label' => __( 'Body Background ', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => 'body',
								'sanitize' => 'hex',
								'alter' => 'background-color',
							),
						),
						array(
							'id' => 'accent_color',
							'control' => array (
								'label' => __( 'Accent Color', 'chic' ),
								'type' => 'select',
								'choices' => $accents
							),
						),
						array(
							'id' => 'custom_accent_color',
							'control' => array (
								'label' => __( 'Custom Accent Color', 'chic' ),
								'type' => 'color',
							),
						),
						array(
							'id' => 'link_color',
							'control' => array (
								'label' => __( 'Links', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => 'a, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
						array(
							'id' => 'link_color_hover',
							'control' => array (
								'label' => __( 'Links: Hover', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => 'a:hover',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
					),
				),

				// Top Notice
				array(
					'id' => 'wpex_styling_notice_bar',
					'title' => __( 'Notice Bar', 'chic' ),
					'settings' => array(
						array(
							'id' => 'topbar_notice_bg',
							'control' => array (
								'label' => __( 'Notice Bar Background', 'chic' ),
								'type' => 'color',
								'active_callback' => 'wpex_has_notice_bar',
							),
							'inline_css' => array(
								'target' => '.wpex-notice-bar, body.wpex-header-centered-logo-full-nav .wpex-notice-bar',
								'sanitize' => 'hex',
								'alter' => 'background-color',
							),
						),
						array(
							'id' => 'topbar_notice_color',
							'control' => array (
								'label' => __( 'Notice Bar Color', 'chic' ),
								'type' => 'color',
								'active_callback' => 'wpex_has_notice_bar',
							),
							'inline_css' => array(
								'target' => '.wpex-notice-bar',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
					),
				),

				// Header
				array(
					'id' => 'wpex_styling_header',
					'title' => __( 'Header', 'chic' ),
					'settings' => array(
						array(
							'id' => 'header_bg',
							'control' => array (
								'label' => __( 'Header Background', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-site-header-wrap, .wpex-sticky-header.is-sticky .wpex-site-header-wrap',
								'alter' => 'background-color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'header_padding',
							'control' => array (
								'label' => __( 'Header Padding', 'chic' ),
								'type' => 'text',
							),
							'inline_css' => array(
								'target' => '.wpex-site-header-wrap',
								'alter' => 'padding',
							),
						),
						array(
							'id' => 'logo_color',
							'control' => array (
								'label' => __( 'Logo Color', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-site-logo a',
								'alter' => 'color',
							),
						),
						array(
							'id' => 'logo_color_hover',
							'control' => array (
								'label' => __( 'Logo: Hover Color', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-site-logo a:hover',
								'alter' => 'color',
							),
						),
						array(
							'id' => 'site_description_color',
							'control' => array (
								'label' => __( 'Site Description Color', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-site-description',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'header_search_width',
							'control' => array (
								'label' => __( 'Header Search Width', 'chic' ),
								'type' => 'text',
								'active_callback' => 'wpex_has_header_search',
							),
							'inline_css' => array(
								'target' => '.wpex-header-searchform.wpex-visible',
								'alter' => 'width',
								'sanitize' => 'px',
							),
						),
						array(
							'id' => 'header_search_bg',
							'control' => array (
								'label' => __( 'Header Search Background', 'chic' ),
								'type' => 'color',
								'active_callback' => 'wpex_has_header_search',
							),
							'inline_css' => array(
								'target' => '.wpex-header-searchform',
								'alter' => 'background-color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'header_search_border_color',
							'control' => array (
								'label' => __( 'Header Search Border', 'chic' ),
								'type' => 'color',
								'active_callback' => 'wpex_has_header_search',
							),
							'inline_css' => array(
								'target' => '.wpex-header-searchform input[type="search"]',
								'alter' => 'border-color',
								'sanitize' => 'hex',
							),
						),
					),
				),

				// Menu
				array(
					'id' => 'wpex_styling_nav',
					'title' => __( 'Menu', 'chic' ),
					'settings' => array(
						array(
							'id' => 'nav_bg',
							'control' => array (
								'label' => __( 'Menu Background', 'chic' ),
								'type' => 'color',
								'active_callback' => 'wpex_has_full_nav'
							),
							'inline_css' => array(
								'target' => '.wpex-site-header-wrap.centered-logo-full-nav .wpex-site-nav',
								'alter' => 'background-color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'nav_color',
							'control' => array (
								'label' => __( 'Menu Link', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-site-nav .wpex-dropdown-menu > li > a,
											.centered-logo-full-nav .wpex-site-nav .wpex-dropdown-menu a,
											.wpex-nav-aside a',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'nav_color_hover',
							'control' => array (
								'label' => __( 'Menu Link: Hover', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-site-nav .wpex-dropdown-menu > li > a:hover,
											.centered-logo-full-nav .wpex-site-nav .wpex-dropdown-menu a:hover,
											.wpex-nav-aside a:hover',
								'alter' => 'color',
								'sanitize' => 'hex',
								'important' => true,
							),
						),
						array(
							'id' => 'nav_color_active',
							'control' => array (
								'label' => __( 'Menu Link: Active', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-site-nav .wpex-dropdown-menu li.current-menu-item > a, .wpex-site-nav .wpex-dropdown-menu li.parent-menu-item > a, .wpex-site-nav .wpex-dropdown-menu > li.current-menu-ancestor > a',
								'alter' => 'color',
								'sanitize' => 'hex',
								'important' => true,
							),
						),
						array(
							'id' => 'nav_drop_bg',
							'control' => array (
								'label' => __( 'Menu Dropdown Background', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-site-nav .wpex-dropdown-menu .sub-menu,
												.wpex-site-header-wrap.centered-logo-full-nav .wpex-dropdown-menu .sub-menu',
								'alter' => 'background-color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'nav_drop_color',
							'control' => array (
								'label' => __( 'Menu Dropdown Link', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-site-nav .wpex-dropdown-menu .sub-menu a',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'nav_drop_color_hover',
							'control' => array (
								'label' => __( 'Menu Dropdown Link: Hover', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-site-nav .wpex-dropdown-menu .sub-menu a:hover',
								'alter' => 'color',
								'sanitize' => 'hex',
								'important' => true,
							),
						),
					),
				),

				// Mobile Menu
				array(
					'id' => 'wpex_styling_sidr',
					'title' => __( 'Mobile Menu', 'chic' ),
					'settings' => array(
						array(
							'id' => 'sidr_search',
							'default' => true,
							'control' => array (
								'label' => __( 'Mobile Menu Search', 'chic' ),
								'type' => 'checkbox',
							),

						),
						array(
							'id' => 'sidr_bg',
							'control' => array (
								'label' => __( 'Mobile Menu Background', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '#wpex-main-sidr',
								'alter' => 'background',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'sidr_color',
							'control' => array (
								'label' => __( 'Mobile Menu Link', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '#wpex-main-sidr a, #wpex-main-sidr .sidr-class-dropdown-toggle',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'sidr_color_hover',
							'control' => array (
								'label' => __( 'Mobile Menu Link: Hover', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '#wpex-main-sidr a:hover, #wpex-main-sidr .sidr-class-dropdown-toggle:hover',
								'alter' => 'color',
								'sanitize' => 'hex',
								'important' => true,
							),
						),
						array(
							'id' => 'sidr_color_active',
							'control' => array (
								'label' => __( 'Mobile Menu Link: Active', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '#wpex-main-sidr a:hover,#wpex-main-sidr .active > a,#wpex-main-sidr .active > a > .sidr-class-dropdown-toggle',
								'alter' => 'color',
								'sanitize' => 'hex',
								'important' => true,
							),
						),
					),
				),

				// Sidebar
				array(
					'id' => 'wpex_styling_sidebar',
					'title' => __( 'Sidebar', 'chic' ),
					'settings' => array(
						array(
							'id' => 'sidebar_text_color',
							'control' => array (
								'label' => __( 'Text', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-sidebar',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'sidebar_links_color',
							'control' => array (
								'label' => __( 'Links', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-sidebar a',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'sidebar_links_hover_color',
							'control' => array (
								'label' => __( 'Links: Hover', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-sidebar a:hover',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'sidebar_tags_bg',
							'control' => array (
								'label' => __( 'Tags Background', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-sidebar .widget_tag_cloud a',
								'alter' => 'background-color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'sidebar_tags_color',
							'control' => array (
								'label' => __( 'Tags Color', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-sidebar .widget_tag_cloud a',
								'alter' => 'color',
								'sanitize' => 'hex',
								'important' => true,
							),
						),
						array(
							'id' => 'sidebar_tags_bg_hover',
							'control' => array (
								'label' => __( 'Tags: Hover Background', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-sidebar .widget_tag_cloud a:hover',
								'alter' => 'background-color',
								'sanitize' => 'hex',
							),
						),
						array(
							'id' => 'sidebar_tags_color_hover',
							'control' => array (
								'label' => __( 'Tags: Hover Color', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-sidebar .widget_tag_cloud a:hover',
								'alter' => 'color',
								'sanitize' => 'hex',
							),
						),
					),
				),

				// Main
				array(
					'id' => 'wpex_styling_footer',
					'title' => __( 'Footer', 'chic' ),
					'settings' => array(
						array(
							'id' => 'footer_bg',
							'control' => array (
								'label' => __( 'Footer Background ', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-site-footer',
								'sanitize' => 'hex',
								'alter' => 'background-color',
							),
						),
						array(
							'id' => 'footer_color',
							'control' => array (
								'label' => __( 'Footer Color ', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-site-footer',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
						array(
							'id' => 'footer_widget_title_color',
							'control' => array (
								'label' => __( 'Footer Widget Titles', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-footer-widgets .widget-title',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
						array(
							'id' => 'footer_link',
							'control' => array (
								'label' => __( 'Footer Link', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-site-footer a, .wpex-footer-widgets .widget-recent-list .wpex-title a',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
						array(
							'id' => 'footer_link_hover',
							'control' => array (
								'label' => __( 'Footer Link: Hover ', 'chic' ),
								'type' => 'color',
							),
							'inline_css' => array(
								'target' => '.wpex-site-footer a:hover, .wpex-footer-widgets .widget-recent-list .wpex-title a:hover',
								'sanitize' => 'hex',
								'alter' => 'color',
							),
						),
					),
				),

			),
		);

		/*-----------------------------------------------------------------------------------*/
		/* - Image Sizes
		/*-----------------------------------------------------------------------------------*/
		$panels['image_sizes'] = array(
			'title' => __( 'Image Sizes', 'chic' ),
			'sections' => array(

				// Entries
				array(
					'id' => 'wpex_entry_thumbnail_sizes',
					'title' => __( 'Entries', 'chic' ),
					'desc' => __( 'If you alter any image sizes you will have to regenerate your thumbnails.', 'chic' ),
					'settings' => array(
						array(
							'id' => 'entry_thumbnail_width',
							'default' => '940',
							'control' => array (
								'label' => __( 'Image Width', 'chic' ),
								'type' => 'text',
							),
						),
						array(
							'id' => 'entry_thumbnail_height',
							'default' => '480',
							'control' => array (
								'label' => __( 'Image Height', 'chic' ),
								'type' => 'text',
							),
						),
						array(
							'id' => 'entry_thumbnail_crop',
							'default' => true,
							'control' => array (
								'label' => __( 'Force Crop', 'chic' ),
								'type' => 'checkbox',
							),
						),
					),
				),

				// Posts
				array(
					'id' => 'wpex_post_thumbnail_sizes',
					'title' => __( 'Posts', 'chic' ),
					'desc' => __( 'If you alter any image sizes you will have to regenerate your thumbnails.', 'chic' ),
					'settings' => array(
						array(
							'id' => 'post_thumbnail_width',
							'default' => '940',
							'control' => array (
								'label' => __( 'Image Width', 'chic' ),
								'type' => 'text',
							),
						),
						array(
							'id' => 'post_thumbnail_height',
							'default' => '480',
							'control' => array (
								'label' => __( 'Image Height', 'chic' ),
								'type' => 'text',
							),
						),
						array(
							'id' => 'post_thumbnail_crop',
							'default' => true,
							'control' => array (
								'label' => __( 'Force Crop', 'chic' ),
								'type' => 'checkbox',
							),
						),
					),
				),

				// Related Posts
				array(
					'id' => 'wpex_posts_related_thumbnail_sizes',
					'title' => __( 'Related Posts', 'chic' ),
					'desc' => __( 'If you alter any image sizes you will have to regenerate your thumbnails.', 'chic' ),
					'settings' => array(
						array(
							'id' => 'post_related_thumbnail_width',
							'default' => '940',
							'control' => array (
								'label' => __( 'Image Width', 'chic' ),
								'type' => 'text',
							),
						),
						array(
							'id' => 'post_related_thumbnail_height',
							'default' => '480',
							'control' => array (
								'label' => __( 'Image Height', 'chic' ),
								'type' => 'text',
							),
						),
						array(
							'id' => 'post_related_thumbnail_crop',
							'default' => true,
							'control' => array (
								'label' => __( 'Force Crop', 'chic' ),
								'type' => 'checkbox',
							),
						),
					),
				),

				// Homepage Slider
				array(
					'id' => 'wpex_home_slider_thumbnail_sizes',
					'title' => __( 'Homepage Slider', 'chic' ),
					'desc' => __( 'If you alter any image sizes you will have to regenerate your thumbnails.', 'chic' ),
					'settings' => array(
						array(
							'id' => 'homepage_slider_thumbnail_width',
							'default' => '1100',
							'control' => array (
								'label' => __( 'Image Width', 'chic' ),
								'type' => 'text',
							),
						),
						array(
							'id' => 'homepage_slider_thumbnail_height',
							'default' => '500',
							'control' => array (
								'label' => __( 'Image Height', 'chic' ),
								'type' => 'text',
							),
						),
						array(
							'id' => 'homepage_slider_thumbnail_crop',
							'default' => true,
							'control' => array (
								'label' => __( 'Force Crop', 'chic' ),
								'type' => 'checkbox',
							),
						),
					),
				),

			),
		);

		// Return panels array
		return $panels;

	}
}
add_filter( 'wpex_customizer_panels', 'wpex_customizer_config' );

// Callback functions
function wpex_is_slider_custom() {
	if ( 'custom_code' == get_theme_mod( 'home_slider_content' ) ) {
		return true;
	}
}
function wpex_is_slider_not_custom() {
	if ( 'custom_code' != get_theme_mod( 'home_slider_content' ) ) {
		return true;
	}
}