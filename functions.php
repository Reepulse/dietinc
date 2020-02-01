<?php
/**
 * Theme functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

class WPEX_Theme_Setup {
	private $theme_version;

	/**
	 * Start things up
	 *
     * @since  1.0.0
     * @access public
	 */
	public function __construct() {

		// Paths
		$this->template_dir     = get_template_directory();
		$this->template_dir_uri = get_template_directory_uri();

		// Get Theme Version
		$get_theme = wp_get_theme();
		$this->theme_version = $get_theme->get( 'Version' );

		// Add Filters
		add_filter( 'wpex_gallery_metabox_post_types', array( $this, 'gallery_metabox_post_types' ) );
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
		add_filter( 'embed_oembed_html', array( $this, 'embed_oembed_html' ), 99, 4 );
		add_filter( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
		add_filter( 'manage_post_posts_columns', array( $this, 'posts_columns' ), 10 );
		add_filter( 'manage_page_posts_columns', array( $this, 'posts_columns' ), 10 );
		add_filter( 'mce_buttons_2', array( $this, 'mce_font_size_select' ) );
		add_filter( 'tiny_mce_before_init', array( $this, 'fontsize_formats' ) );
		add_filter( 'mce_buttons', array( $this, 'formats_button' ) );
		add_filter( 'tiny_mce_before_init', array( $this, 'formats' ) );
		add_filter( 'use_default_gallery_style', array( $this, 'remove_gallery_styles' ) );
		add_filter( 'wp_nav_menu_items', array( $this, 'menu_add_items' ), 11, 2 );
		add_filter( 'user_contactmethods', array( $this, 'user_fields' ) );
		add_filter( 'previous_post_link', array( $this, 'previous_post_link' ) );
		add_filter( 'next_post_link', array( $this, 'next_post_link' ) );
		add_filter( 'body_class', array( $this, 'body_classes' ) );
		add_filter( 'post_class', array( $this, 'post_class' ) );

		// Actions
		add_action( 'after_setup_theme', array( $this, 'constants' ), 1 );
		add_action( 'after_setup_theme', array( $this, 'setup' ), 2 );
		add_action( 'after_setup_theme', array( $this, 'load_files' ), 3 );
		add_action( 'init', array( $this, 'remove_locale_stylesheet' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'theme_css' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'rtl_css' ), 50 );
		add_action( 'wp_enqueue_scripts', array( $this, 'responsive_css' ), 999 );
		add_action( 'wp_enqueue_scripts', array( $this, 'theme_js' ) );
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'posts_custom_columns' ), 10, 2 );
		add_action( 'manage_pages_custom_column', array( $this, 'posts_custom_columns' ), 10, 2 );
		add_action( 'wp_head', array( $this, 'retina_logo' ) );
		add_action( 'wpex_after_body_tag', array( $this, 'fb_comments' ) );
		add_action( 'wp_head', array( $this, 'mobile_menu_breakpoint' ) );

		// Custom Widgets
		$this->load_custom_widgets();

	}

	/**
	 * Define constants
	 *
     * @since  1.0.0
     * @access public
	 */
	public function constants() {
		define( 'WPEX_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );
	}

	/**
	 * Include functions and classes
	 *
     * @since  1.0.0
     * @access public
	 */
	public function load_files() {

		// WooCommerce tweaks - load first so we can use theme filters and hooks
		if ( WPEX_WOOCOMMERCE_ACTIVE ) {
			require_once ( $this->template_dir .'/inc/woocommerce-config.php' );
		}

		// Include Theme Functions
		require_once( $this->template_dir .'/inc/core-functions.php' );
		require_once( $this->template_dir .'/inc/conditionals.php' );
		require_once( $this->template_dir .'/inc/customizer-config.php' );
		require_once( $this->template_dir .'/inc/post-meta-config.php' );
		require_once( $this->template_dir .'/inc/category-meta.php' );
		require_once( $this->template_dir .'/inc/accent-config.php' );

		// Include Classes
		require_once ( $this->template_dir .'/inc/classes/custom-css/custom-css.php' );
		require_once ( $this->template_dir .'/inc/classes/customizer/customizer.php' );
		require_once ( $this->template_dir .'/inc/classes/gallery-metabox/gallery-metabox.php' );
		require_once ( $this->template_dir .'/inc/classes/custom-metaboxes/init.php' );
		require_once ( $this->template_dir .'/inc/classes/accent.php' );
		require_once( $this->template_dir .'/inc/classes/category-colors.php' );
		require_once ( $this->template_dir .'/inc/classes/category-thumbnails/category-thumbnails.php' );

	}

	/**
	 * Include custom widgets
	 *
     * @since  1.0.0
     * @access public
	 */
	public function load_custom_widgets() {

		// Define theme widgets
		$widgets = array( 'social', 'recent-posts-thumbnails', 'mailchimp', 'about', 'instagram-slider', 'comments-avatar' );

		// Apply filters so you can remove custom widgets via a child theme or plugin
		$widgets = apply_filters( 'wpex_theme_widgets', $widgets );

		// Loop through and load widget files
		foreach ( $widgets as $widget ) {
			$widget_file = $this->template_dir .'/inc/classes/widgets/'. $widget .'.php';
			if ( file_exists( $widget_file ) ) {
				require_once( $widget_file );
		   }
		}

	}

	/**
	 * Remove locale_stylesheet so we can load it prior to responsive.css
	 *
     * @since  1.0.0
     * @access public
	 */
	public function remove_locale_stylesheet() {
		remove_action( 'wp_head', 'locale_stylesheet' );
	}

	/**
	 * Functions called during each page load, after the theme is initialized
	 * Perform basic setup, registration, and init actions for the theme
	 *
     * @since  1.0.0
     * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Action_Reference/after_setup_theme
	 */
	public function setup() {

		// Define content_width variable
		if ( ! isset( $content_width ) ) {
			$content_width = 745;
		}

		// Register navigation menus
		register_nav_menus (
			array(
				'main'  => __( 'Main', 'chic' ),
			)
		);

		// Add editor styles
		add_editor_style( 'css/editor-style.css' );
		
		// Localization support
		load_theme_textdomain( 'chic', get_template_directory() .'/languages' );
			
		// Add theme support
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'custom-header' );

		// Add image sizes
		add_image_size(
			'entry',
			get_theme_mod( 'entry_thumbnail_width', 940 ),
			get_theme_mod( 'entry_thumbnail_height', 480 ),
			get_theme_mod( 'entry_thumbnail_crop', true )
		);
		add_image_size(
			'post',
			get_theme_mod( 'post_thumbnail_width', 940 ),
			get_theme_mod( 'post_thumbnail_height', 480 ),
			get_theme_mod( 'post_thumbnail_crop', true )
		);
		add_image_size(
			'post-related',
			get_theme_mod( 'post_related_thumbnail_width', 940 ),
			get_theme_mod( 'post_related_thumbnail_height', 480 ),
			get_theme_mod( 'post_related_thumbnail_crop', true )
		);

		// Homepage Slider
		$crop = get_theme_mod( 'homepage_slider_thumbnail_crop', true ) ? true : false;
		add_image_size(
			'homepage-slider',
			get_theme_mod( 'homepage_slider_thumbnail_width', 1100 ),
			get_theme_mod( 'homepage_slider_thumbnail_height', 500 ),
			$crop
		);

		// Add support for page excerpts
		add_post_type_support( 'page', 'excerpt' );

	}

	/**
	 * Define post types for the gallery metabox
	 *
     * @since  1.0.0
     * @access public
	 */
	public function gallery_metabox_post_types( $post_types ) {
		$post_types = array( 'post' );
		return $post_types;
	}

	/**
	 * Load custom CSS scripts in the front end
	 *
     * @since  1.0.0
     * @access public
     *
     * @link   https://codex.wordpress.org/Function_Reference/wp_enqueue_style
	 */
	public function theme_css() {

		// Define css directory
		$css_dir_uri = $this->template_dir_uri .'/css/';

		// Font Awesome
		wp_enqueue_style( 'font-awesome', $css_dir_uri .'font-awesome.css', false, $this->theme_version );

		// Slider
		wp_enqueue_style( 'lightslider', $css_dir_uri .'lightslider.css', false, $this->theme_version );

		// Popups
		wp_enqueue_style( 'magnific-popup', $css_dir_uri .'magnific-popup.css', false, $this->theme_version );

		// Main CSS
		wp_enqueue_style( 'style', get_stylesheet_uri(), false, $this->theme_version );

		// Remove Contact Form 7 Styles
		if ( function_exists( 'wpcf7_enqueue_styles') ) {
			wp_dequeue_style( 'contact-form-7' );
		}

	}

	/**
	 * Load RTL CSS
	 *
     * @since  1.0.0
     * @access public
     *
     * @link   https://codex.wordpress.org/Function_Reference/wp_enqueue_style
	 */
	public function rtl_css() {
		if ( is_RTL() ) {
			wp_enqueue_style( 'wpex-rtl', $this->template_dir_uri .'/css/rtl.css' );
		}
	}

	/**
	 * Load responsive css
	 *
     * @since  1.0.0
     * @access public
     *
     * @link   https://codex.wordpress.org/Function_Reference/wp_enqueue_style
	 */
	public function responsive_css() {
		if ( wpex_is_responsive() ) {
			wp_enqueue_style( 'wpex-responsive', $this->template_dir_uri .'/css/responsive.css' );
		} else {
			wp_deregister_style( 'woocommerce-smallscreen' );
			wp_dequeue_style( 'woocommerce-smallscreen' );
		}
	}

	/**
	 * Load custom JS scripts in the front end
	 *
     * @since  1.0.0
     * @access public
     *
	 * @link   https://codex.wordpress.org/Function_Reference/wp_enqueue_script
	 */
	public function theme_js() {

		// Define js directory
		$js_dir_uri = $this->template_dir_uri .'/js/';

		// Comment reply
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Check if js should be minified
		$minify_js = wpex_has_minified_js();

		// Localize scripts
		$sidr_side = wpex_has_full_nav() ? 'left' : 'right';
		$localize  = apply_filters( 'wpex_localize', array(
			'isRTL'                  => is_rtl(),
			'wpGalleryLightbox'      => true,
			'noticeBarCookieExpires' => 5,
			'sidrSource'             => '.wpex-site-nav',
			'sidrSide'               => $sidr_side,
			'sidrDisplace'           => true,
			'sidrSpeed'              => 150,
		) );

		// Output minified js
		if ( $minify_js ) {

			wp_enqueue_script( 'wpex-theme-min', $js_dir_uri .'theme-min.js', array( 'jquery' ), false, true );
			wp_localize_script( 'wpex-theme-min', 'wpexLocalize', $localize );

		}

		// Non-minified js
		else {

			// jQuery Plugins
			wp_register_script( 'lightslider', $js_dir_uri .'plugins/lightslider.js', array( 'jquery' ), false, true );
			wp_register_script( 'match-height', $js_dir_uri .'plugins/match-height.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'magnific-popup', $js_dir_uri .'plugins/jquery.magnific-popup.js', array( 'jquery' ), false, true );

			if ( wpex_has_sticky_header() ) {
				wp_enqueue_script( 'sticky', $js_dir_uri .'plugins/sticky.js', array( 'jquery' ), '0.5.2', true );
			}

			// jQuery Cookie used for TopBar
			if ( get_theme_mod( 'notice_bar', true ) ) {
				wp_enqueue_script( 'jquery-cookie', $js_dir_uri .'plugins/jquery-cookie.js', array( 'jquery' ), false, true );
			}

			// Responsive menu
			if ( wpex_is_responsive() ) {
				wp_enqueue_script( 'sidr', $js_dir_uri .'plugins/jquery.sidr.js', array( 'jquery' ), false, true );
			}

			// Theme functions
			wp_enqueue_script( 'wpex-functions', $js_dir_uri .'functions.js', array( 'jquery' ), false, true );
			wp_localize_script( 'wpex-functions', 'wpexLocalize', $localize );

		}

	}

	/**
	 * Registers the theme sidebars
	 *
     * @since  1.0.0
     * @access public
	 *
	 * @link   http://codex.wordpress.org/Function_Reference/register_sidebar
	 */
	function register_sidebars() {

		// Sidebar
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'chic' ),
			'id'            => 'sidebar',
			'description'   => __( 'Widgets in this area are used in the sidebar region.', 'chic' ),
			'before_widget' => '<div class="sidebar-widget %2$s wpex-clr">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title"><span>',
			'after_title'   => '</span></h5>',
		) );

		// WooCommerce Sidebar
		if ( WPEX_WOOCOMMERCE_ACTIVE ) {

			register_sidebar( array(
				'name'          => __( 'WooCommerce - Sidebar', 'chic' ),
				'id'            => 'sidebar_woocommerce',
				'description'   => __( 'Widgets in this area are used in the sidebar region for WooCommerce pages.', 'chic' ),
				'before_widget' => '<div class="sidebar-widget %2$s wpex-clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title"><span>',
				'after_title'   => '</span></h5>',
			) );

		}

		// Get footer columns
		$cols = get_theme_mod( 'footer_columns', '4' );

		// Footer 1
		if ( $cols >= 1 ) {

			register_sidebar( array(
				'name'          => __( 'Footer 1', 'chic' ),
				'id'            => 'footer-one',
				'description'   => __( 'Widgets in this area are used in the first footer region.', 'chic' ),
				'before_widget' => '<div class="footer-widget %2$s wpex-clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			) );

		}

		// Footer 2
		if ( $cols > 1 ) {

			register_sidebar( array(
				'name'          => __( 'Footer 2', 'chic' ),
				'id'            => 'footer-two',
				'description'   => __( 'Widgets in this area are used in the second footer region.', 'chic' ),
				'before_widget' => '<div class="footer-widget %2$s wpex-clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			) );

		}

		// Footer 3
		if ( $cols > 2 ) {

			register_sidebar( array(
				'name'          => __( 'Footer 3', 'chic' ),
				'id'            => 'footer-three',
				'description'   => __( 'Widgets in this area are used in the third footer region.', 'chic' ),
				'before_widget' => '<div class="footer-widget %2$s wpex-clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			) );

		}

		// Footer 4
		if ( $cols > 3 ) {

			register_sidebar( array(
				'name'          => __( 'Footer 4', 'chic' ),
				'id'            => 'footer-four',
				'description'   => __( 'Widgets in this area are used in the fourth footer region.', 'chic' ),
				'before_widget' => '<div class="footer-widget %2$s wpex-clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="widget-title">',
				'after_title'   => '</h6>',
			) );

		}

	}
	
	/**
	 * Adds classes to the body_class function
	 *
     * @since  1.0.0
     * @access public
	 *
	 * @link   http://codex.wordpress.org/Function_Reference/body_class
	 */
	public function body_classes( $classes ) {

		// Add post layout
		$classes[] = wpex_get_post_layout();

		// Fixed header/nav
		if ( wpex_has_sticky_header() ) {
			if ( wpex_has_full_nav() ) {
				$classes[] = 'wpex-has-sticky-nav';
			} else {
				$classes[] = 'wpex-has-sticky-header';
			}
		}

		// Header style
		$classes[] = 'wpex-header-'. wpex_get_header_style();

		// Hide mobile search
		if ( ! get_theme_mod( 'sidr_search', true ) ) {
			$classes[] = 'wpex-hide-mobile-search';
		}
		
		// Return classes
		return $classes;

	}

	/**
	 * Adds classes to the post_class
	 *
     * @since  1.0.0
     * @access public
	 *
	 * @link   http://codex.wordpress.org/Function_Reference/post_class
	 */
	public function post_class( $classes ) {

		// Add a 'wpex-no-media' class
		if ( ! has_post_thumbnail() && ! wpex_has_post_video() ) {
			$classes[] = 'wpex-no-media';
		}

		// Left right on mobile class
		if ( wpex_has_entry_mobile_left_right() ) {
			$classes[] = 'wpex-mobile-left-right';
		}
		
		// Return classes
		return $classes;

	}

	/**
	 * Return custom excerpt more string
	 *
     * @since  1.0.0
     * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Filter_Reference/excerpt_more
	 */
	public function excerpt_more( $more ) {
		global $post;
		return '&hellip;';
	}

	/**
	 * Alters the default oembed output
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   https://developer.wordpress.org/reference/hooks/embed_oembed_html/
	 */
	function embed_oembed_html( $html, $url, $attr, $post_id ) {
		return '<div class="wpex-responsive-embed">' . $html . '</div>';
	}

	/**
	 * Alter the main query
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
	 */
	public function pre_get_posts( $query ) {

		// Alter search results
		if ( ! is_admin() && $query->is_main_query() && is_search() ) {
			$post_type_query_var = false;
			if ( ! empty( $_GET[ 'post_type' ] ) ) {
				$post_type_query_var = true;
			}
			if ( ! $post_type_query_var ) {
				$query->set( 'post_type', array( 'post' ) );
			}
		}

		// Exclude posts on the homepage
		if ( $query->is_home() AND $query->is_main_query() && function_exists( 'wpex_exclude_home_ids' ) ) {
			$ids = wpex_exclude_home_ids();
			if ( is_array( $ids ) && ! empty( $ids ) ) {
				$query->set('post__not_in', $ids );
			}
		}

		// Alter posts per page
		if ( ! empty( $_GET['theme_posts_per_page'] ) ) {
			return $query->set( 'posts_per_page', $_GET['theme_posts_per_page'] );
		}

	}

	/**
	 * Adds new "Featured Image" column to the WP dashboard
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Filter_Reference/manage_posts_columns
	 */
	public function posts_columns( $defaults ) {
		$defaults['wpex_post_thumbs'] = __( 'Featured Image', 'chic' );
		return $defaults;
	}

	/**
	 * Display post thumbnails in WP admin
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Filter_Reference/manage_posts_columns
	 */
	public function posts_custom_columns( $column_name, $id ) {
		$id = get_the_ID();
		if ( $column_name != 'wpex_post_thumbs' ) {
			return;
		}
		if ( has_post_thumbnail( $id ) ) {
			$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'thumbnail', false );
			if( ! empty( $img_src[0] ) ) { ?>
					<img src="<?php echo $img_src[0]; ?>" alt="<?php echo esc_attr( the_title_attribute( 'echo=0' ) ); ?>" style="max-width:100%;max-height:90px;" />
				<?php
			}
		} else {
			echo '&mdash;';
		}
	}

	/**
	 * Adds js for the retina logo
	 *
	 * @since 1.0.0
	 */
	function retina_logo() {
		$logo_url    = get_theme_mod( 'logo_retina' );
		$logo_url    = wpex_sanitize( $logo_url, 'url' );
		$logo_height = get_theme_mod( 'logo_height' );
		if ( $logo_url && $logo_height ) {
			$output = '<!-- Retina Logo --><script type="text/javascript">jQuery(function($){if (window.devicePixelRatio >= 2) {$("#wpex-site-logo img").attr("src", "'. $logo_url .'");$("#wpex-site-logo img").css("height", "'. intval( $logo_height ) .'");}});</script>';
			echo $output;
		}
	}

	/**
	 * Add facebook comments js
	 *
	 * @since 1.0.0
	 */
	function fb_comments() {

		if ( ! wpex_has_fb_comments() ) return; ?>

		<!-- Theme Facebook Comments -->
		<div id="fb-root"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=171112522968749";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>

	<?php }

	/**
	 * Add Font size select to tinymce
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Filter_Reference/mce_buttons,_mce_buttons_2,_mce_buttons_3,_mce_buttons_4
	 */
	public function mce_font_size_select( $buttons ) {
		array_unshift( $buttons, 'fontsizeselect' );
		return $buttons;
	}
	
	/**
	 * Customize default font size selections for the tinymce
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Filter_Reference/mce_buttons,_mce_buttons_2,_mce_buttons_3,_mce_buttons_4
	 */
	public function fontsize_formats( $initArray ) {
		$initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px";
		return $initArray;
	}

	/**
	 * Add Formats Button
	 *
	 * @since  1.0.0
	 * @access public 
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Filter_Reference/mce_buttons,_mce_buttons_2,_mce_buttons_3,_mce_buttons_4
	 */
	function formats_button( $buttons ) {
		array_push( $buttons, 'styleselect' );
		return $buttons;
	}

	/**
	 * Add new formats
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/TinyMCE_Custom_Styles
	 */
	public function formats( $settings ) {
		$new_formats = array(
			array(
				'title'     => __( 'Highlight', 'chic' ),
				'inline'    => 'span',
				'classes'   => 'wpex-text-highlight'
			),
			array(
				'title' => __( 'Buttons', 'chic' ),
				'items' => array(
					array(
						'title'     => __( 'Default', 'chic' ),
						'selector'  => 'a',
						'classes'   => 'wpex-theme-button'
					),
					array(
						'title'     => __( 'Red', 'chic' ),
						'selector'  => 'a',
						'classes'   => 'wpex-theme-button red'
					),
					array(
						'title'     => __( 'Green', 'chic' ),
						'selector'  => 'a',
						'classes'   => 'wpex-theme-button green'
					),
					array(
						'title'     => __( 'Blue', 'chic' ),
						'selector'  => 'a',
						'classes'   => 'wpex-theme-button blue'
					),
					array(
						'title'     => __( 'Orange', 'chic' ),
						'selector'  => 'a',
						'classes'   => 'wpex-theme-button orange'
					),
					array(
						'title'     => __( 'Black', 'chic' ),
						'selector'  => 'a',
						'classes'   => 'wpex-theme-button black'
					),
					array(
						'title'     => __( 'White', 'chic' ),
						'selector'  => 'a',
						'classes'   => 'wpex-theme-button white'
					),
					array(
						'title'     => __( 'Clean', 'chic' ),
						'selector'  => 'a',
						'classes'   => 'wpex-theme-button clean'
					),
				),
			),
			array(
				'title' => __( 'Notices', 'chic' ),
				'items' => array(
					array(
						'title'     => __( 'Default', 'chic' ),
						'block'     => 'div',
						'classes'   => 'wpex-notice'
					),
					array(
						'title'     => __( 'Info', 'chic' ),
						'block'     => 'div',
						'classes'   => 'wpex-notice wpex-info'
					),
					array(
						'title'     => __( 'Warning', 'chic' ),
						'block'     => 'div',
						'classes'   => 'wpex-notice wpex-warning'
					),
					array(
						'title'     => __( 'Success', 'chic' ),
						'block'     => 'div',
						'classes'   => 'wpex-notice wpex-success'
					),
				),
			),
		);
		$settings['style_formats'] = json_encode( $new_formats );
		return $settings;
	}

	/**
	 * Remove gallery styles
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   https://developer.wordpress.org/reference/hooks/use_default_gallery_style/
	 */
	public function remove_gallery_styles() {
		return false;
	}

	/**
	 * Adds extra items to the end of the main menu
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/Function_Reference/wp_get_nav_menu_items
	 */
	function menu_add_items( $items, $args ) {

		if ( 'main' == $args->theme_location ) {

			if ( 'default' == wpex_get_header_style() ) {

				// Social icons
				$social_options = wpex_header_social_options_array();

				if ( $social_options ) {

					foreach( $social_options as $key => $val ) {

						$default = null;
						if ( 'twitter' == $key ) {
							$default = 'http://twitter.com/';
						} elseif ( 'facebook' == $key ) {
							$default = 'http://facebook.com/';
						} elseif ( 'instagram' == $key ) {
							$default = 'http://instagram.com/';
						}

						$url    = esc_url( get_theme_mod( 'header_social_'. $key, $default ) );
						$target = 'blank' == get_theme_mod( 'header_social_target', 'blank' ) ? ' target="_blank"' : null;

						if ( $url ) {
							$items .= '<li class="wpex-xtra-menu-item wpex-menu-social-link '. $key .'">
								<a href="'. $url .'" title="'. esc_attr( $val['label'] ) .'"'. $target .'>
									<span class="'. $val['icon_class'] .'"></span>
								</a>
							</li>';
						}
					}
					
				}

				// Login
				if ( $page = wpex_get_theme_mod( 'menu_login_icon_page' ) ) {
					$page = ( 'wp_login' == $page ) ? wp_login_url() : get_permalink( $page );
					if ( is_customize_preview() || ! is_user_logged_in() ) {
						$items .= '<li class="wpex-xtra-menu-item wpex-menu-login">
							<a href="'. esc_url( $page ) .'" title="'. __( 'Login', 'chic' ) .'">
								<span class="fa fa-user"></span>
							</a>
						</li>';
					}
				}

				// Cart
				if ( WPEX_WOOCOMMERCE_ACTIVE && function_exists( 'wpex_menu_woocart_link' ) ) {
					$menu_shop_type = get_theme_mod( 'menu_shop_type', 'cart_dropdown' );
					if ( 'disabled' != $menu_shop_type ) {
						$classes = 'wpex-xtra-menu-item wpex-menu-cart-toggle';
						if ( is_cart() || is_checkout() || 'link_to_shop' == $menu_shop_type ) {
							$classes .= 'toggle-disabled';
						}
						$items .= '<li class="'. $classes .'">'. wpex_menu_woocart_link() .'</li>';
					}
				}

				// Search Icon
				if ( wpex_has_header_search() ) {
					$items .= '<li class="wpex-xtra-menu-item wpex-menu-search-toggle">
						<a href="#" class="wpex-toggle-menu-search" title="'. __( 'Search', 'chic' ) .'">
							<span class="fa fa-search"></span>
						</a>
					</li>';
				}

			}

			// Menu Toggle
			if ( get_theme_mod( 'menu_search', true ) ) {
				$text = get_theme_mod( 'mobile_menu_toggle_text', __( 'Menu', 'chic' ) );
				$items .= '<li class="wpex-xtra-menu-item wpex-menu-mobile-toggle">
					<a href="#" class="wpex-toggle-mobile-menu" title="'. __( 'Menu', 'chic' ) .'">
						<span class="fa fa-navicon"></span>';
						if ( $text ) {
							$items .= '<span class="text">'. $text .'</span>';
						}
					$items .= '</a>
				</li>';
			}

		}

		// Return nav items
		return $items;

	}

	/**
	 * Add new user fields
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   http://codex.wordpress.org/Plugin_API/Filter_Reference/user_contactmethods
	 */
	public function user_fields( $contactmethods ) {

		// Add Twitter
		if ( ! isset( $contactmethods['wpex_twitter'] ) ) {
			$contactmethods['wpex_twitter'] = 'Chic - Twitter';
		}

		// Add Facebook
		if ( ! isset( $contactmethods['wpex_facebook'] ) ) {
			$contactmethods['wpex_facebook'] = 'Chic - Facebook';
		}

		// Add GoglePlus
		if ( ! isset( $contactmethods['wpex_googleplus'] ) ) {
			$contactmethods['wpex_googleplus'] = 'Chic - Google+';
		}

		// Add LinkedIn
		if ( ! isset( $contactmethods['wpex_linkedin'] ) ) {
			$contactmethods['wpex_linkedin'] = 'Chic - LinkedIn';
		}

		// Add Pinterest
		if ( ! isset( $contactmethods['wpex_pinterest'] ) ) {
			$contactmethods['wpex_pinterest'] = 'Chic - Pinterest';
		}

		// Add Pinterest
		if ( ! isset( $contactmethods['wpex_instagram'] ) ) {
			$contactmethods['wpex_instagram'] = 'Chic - Instagram';
		}

		// Return contactmethods
		return $contactmethods;

	}

	/**
	 * Filters the previous post link HTML if empty to display simple text
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   https://developer.wordpress.org/reference/functions/get_adjacent_post_link/
	 */
	public function previous_post_link( $output ) {

		if ( ! $output ) {
			$output = '<div class="nav-previous wpex-disabled"><span>'. __( 'Next Article', 'chic' ) .'<i class="fa fa-chevron-right"></i></span></div>';
		}

		return $output;

	}

	/**
	 * Filters the next post link HTML if empty to display simple text
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @link   https://developer.wordpress.org/reference/functions/get_adjacent_post_link/
	 */
	public function next_post_link( $output ) {

		if ( ! $output ) {
			$output = '<div class="nav-next wpex-disabled"><span><i class="fa fa-chevron-left"></i>'. __( 'Previous Article', 'chic' ) .'</span></div>';
		}

		return $output;

	}


	/**
	 * Mobile Breakpoint inline code
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function mobile_menu_breakpoint() {

		// Add css
		$css = '';

		// Mobile menu switch point
		$mobileMenuSwitchPoint = wpex_get_mobile_menu_switch_point();

		if ( $mobileMenuSwitchPoint ) {

			if ( '-1' == $mobileMenuSwitchPoint ) {

				$css .= '.wpex-site-nav .wpex-dropdown-menu > li {
						  display: none;
						}
						.wpex-site-nav li.wpex-xtra-menu-item {
							display: block;
							font-size: 16px;
							margin-right: 20px !important;
						}
						.wpex-site-nav li.wpex-menu-search-toggle {
							display: none;
						}
						.wpex-site-nav li.wpex-menu-mobile-toggle {
							margin-right: 0 !important;
						}';

			} else {

				$css .= '@media only screen and ( max-width: '. $mobileMenuSwitchPoint .'px ) {
					.wpex-site-nav .wpex-dropdown-menu > li {
						display: none;
					}
					.wpex-site-nav li.wpex-xtra-menu-item {
						display: block;
						font-size: 16px;
						margin-right: 20px !important;
					}
					.wpex-site-nav li.wpex-menu-search-toggle {
						display: none;
					}
					.wpex-site-nav li.wpex-menu-mobile-toggle {
							margin-right: 0 !important;
					}
				}';

			}

		}

		// Container width
		$width = get_theme_mod( 'layout_container_width', '1100px' );

		if ( $width && strpos( $width, '%' ) == false ) {
			$width = intval( $width );
			$width = $width ? $width .'px' : null;
		}

		if ( $width && '1100px' !== $width ) {
			$css .= '.wpex-container { width: '. $width .'; }';
		}

		// Content width
		$default = '68.18&#37;';
		$width   = $this->px_pct( get_theme_mod( 'layout_content_width' ), $default );

		if ( $width && $default != $width ) {
			$css .= '.wpex-content-area { width: '. $width .'; }';
		}

		// Sidebar width
		$default = '27.27&#37;';
		$width   = $this->px_pct( get_theme_mod( 'layout_sidebar_width', $default ) );

		if ( $width && $default != $width ) {
			$css .= '.wpex-sidebar { width: '. $width .'; }';
		}

		// Container Max Width
		if ( wpex_is_responsive() ) {

			$width = intval( get_theme_mod( 'layout_container_max_width', '85' ) );

			if ( $width && '85' !== $width ) {
				$css .= '.wpex-container { max-width: '. $width .'%; }';
			}

		}

		// Minitfy CSS
		$css = wpex_minify_css( $css );

		// Return css
		if ( $css ) {
			echo '<!-- Theme Inline CSS --><style type="text/css">'. $css .'</style>';
		}

	}

	/**
     * Returns a Pixel or Percent
     *
     * @access private
     * @since  1.0.0
     */
    private function px_pct( $data ) {

        if ( 'none' == $data || '0px' == $data ) {
            return '0';
        } elseif ( strpos( $data, '%' ) ) {
            return $data;
        } elseif ( strpos( $data , '&#37;' ) ) {
        	return $data;
        } elseif ( $data = floatval( $data ) ) {
            return $data .'px';
        }

    }

}
$wpex_theme_setup = new WPEX_Theme_Setup;