<?php
/**
 * Core functions used for the theme
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

/**
 * Returns theme mod
 *
 * @since 1.0.0
 */
function wpex_get_theme_mod( $key, $default = null ) {
	if ( ! empty( $_GET[ 'theme_'. $key ] ) ) {
		$return = ( 'false' == $_GET[ 'theme_'. $key ] ) ? false : $_GET[ 'theme_'. $key ];
		return $return;
	} else {
		return get_theme_mod( $key, $default );
	}
}

/**
 * Echos theme mod
 *
 * @since 1.0.0
 */
function wpex_theme_mod( $key, $default = null ) {
	echo wpex_get_theme_mod( $key, $default );
}

/**
 * Returns correct header style
 *
 * @since 1.0.0
 */
function wpex_get_header_style( $style = 'default' ) {
	$style = wpex_get_theme_mod( 'header_style', $style );
	$style = apply_filters( 'wpex_header_style', $style );
	$style = $style ? $style : 'default';
	return $style;
}

/**
 * Returns correct header logo src
 *
 * @since 1.0.0
 */
function wpex_get_header_logo_src() {
	$src = wpex_get_theme_mod( 'logo' );
	$src = apply_filters( 'wpex_header_logo_src', $src );
	$src = esc_url( $src );
	return $src;
}

/**
 * Returns correct header nav position
 *
 * @since 1.0.0
 */
function wpex_get_nav_position( $position = 'default' ) {
	$header_style = wpex_get_header_style();
	if ( 'centered-logo-full-nav' == $header_style ) {
		$position = wpex_get_theme_mod( 'full_nav_location', 'bottom' );
	}
	$position = apply_filters( 'wpex_get_nav_position', $position );
	return $position;
}

/**
 * Check if full-nav is enabled
 *
 * @since 1.0.0
 */
function wpex_has_full_nav() {
	$position = wpex_get_nav_position();
	if ( 'top' == $position || 'bottom' == $position ) {
		return true;
	} else {
		return false;
	}
}


/**
 * Check if full-nav is enabled
 *
 * @since 1.0.0
 */
function wpex_get_mobile_menu_switch_point() {
	if ( ! wpex_is_responsive() ) {
		return null;
	}
	$default = wpex_has_full_nav() ? 960 : 1120;
	$return  = wpex_get_theme_mod( 'mobile_menu_switch_point', $default );
	$return  = intval( $return );
	$return  = $return ? $return : $default;
	return $return;
}

/**
 * Returns escaped post title
 *
 * @since 1.0.0
 */
function wpex_get_esc_title() {
	return esc_attr( the_title_attribute( 'echo=0' ) );
}

/**
 * Outputs escaped post title
 *
 * @since 1.0.0
 */
function wpex_esc_title() {
	echo wpex_get_esc_title();
}

/**
 * Returns current page or post ID
 *
 * @since 1.0.0
 */
function wpex_get_the_id() {

	// If singular get_the_ID
	if ( is_singular() ) {
		return get_the_ID();
	}

	// Get ID of WooCommerce product archive
	elseif ( is_post_type_archive( 'product' ) && class_exists( 'Woocommerce' ) && function_exists( 'wc_get_page_id' ) ) {
		$shop_id = wc_get_page_id( 'shop' );
		if ( isset( $shop_id ) ) {
			return wc_get_page_id( 'shop' );
		}
	}

	// Posts page
	elseif ( is_home() && $page_for_posts = get_option( 'page_for_posts' ) ) {
		return $page_for_posts;
	}

	// Return nothing
	else {
		return NULL;
	}

}

/**
 * Translate ID
 *
 * @since 1.0.9
 */
function wpex_translate_id( $id, $type = null ) {

	// Default vars
	$wpml_active     = function_exists( 'icl_object_id' ) ? true : false;
	$polylang_active = function_exists( 'pll_get_term' ) ? true : false;

	// Return ID
	if ( ! $wpml_active && ! $polylang_active ) {
		return $id;
	}

	// Translate category ID
	if ( 'category' == $type ) {
		if ( $wpml_active ) {
			$id = icl_object_id( $id, 'category' );
		} elseif ( $polylang_active ) {
			$id = pll_get_term( $id );
		}
	}

	// Return id
	return $id;

}

/**
 * Returns current page or post layout
 *
 * @since 1.0.0
 */
function wpex_get_post_layout() {

	// Check URL
	if ( ! empty( $_GET['theme_post_layout'] ) ) {
		return $_GET['theme_post_layout'];
	}

	// Get post ID
	$post_id = wpex_get_the_id();

	// Set default layout
	$layout = 'right-sidebar';

	// Posts
	if ( is_page() ) {
		$layout = get_theme_mod( 'page_layout' );
	}

	// Posts
	elseif ( is_singular() ) {
		$layout = get_theme_mod( 'post_layout' );
	}

	// Full-width pages
	if ( is_404()
		|| is_page_template( 'templates/login-register.php' )
		|| is_page_template( 'templates/archives.php' )
	) {
		$layout = 'full-width';
	}

	// Homepage
	elseif ( is_home() || is_front_page() ) {
		$layout = get_theme_mod( 'home_layout' );
	}

	// Search
	elseif ( is_search() ) {
		$layout = get_theme_mod( 'search_layout' );
	}

	// Archive
	elseif ( is_archive() ) {

		// Default archive layout
		$layout = get_theme_mod( 'archives_layout' );

		// Categories => check meta
		if ( is_category() ) {
			$obj = get_queried_object();
			$term_id = $obj->term_id;
			if ( $meta = get_term_meta( $term_id, 'wpex_post_layout', true ) ) {
				$layout = $meta;
			}
		}

	}

	// Apply filters
	$layout = apply_filters( 'wpex_post_layout', $layout );

	// Check meta
	if ( $meta = get_post_meta( wpex_get_the_id(), 'wpex_post_layout', true ) ) {
		$layout = $meta;
	}

	// Sanitize
	$layout = $layout ? $layout : 'right-sidebar';

	// Return layout
	return $layout;

}


/**
 * Returns current page or post layout
 *
 * @since 1.0.0
 */
function wpex_get_loop_columns() {

	// Check URL
	if ( ! empty( $_GET['theme_loop_columns'] ) ) {
		return $_GET['theme_loop_columns'];
	}

	// Get post ID
	$post_id = wpex_get_the_id();

	// Set default layout
	$columns = 1;

	// Homepage
	if ( is_home() ) {
		$columns = get_theme_mod( 'homepage_entry_columns', 1 );
	}

	// Archives
	if ( is_archive() ) {

		// Default archive columns
		$columns = get_theme_mod( 'archives_entry_columns', 1 );

		// Categories => check meta
		if ( is_category() ) {
			$obj = get_queried_object();
			$term_id = $obj->term_id;
			if ( $meta = get_term_meta( $term_id, 'wpex_loop_columns', true ) ) {
				$columns = $meta;
			}
		}
		
	}

	// Search
	if ( is_search() ) {
		$columns = get_theme_mod( 'search_entry_columns', 1 );
	}

	// Set to 2 for the categories homepage template
	if ( is_page_template( 'templates/home-categories.php' ) ) {
		$columns = 2;
	}

	// Apply filters
	$columns = apply_filters( 'wpex_loop_columns', $columns );

	// Return layout
	return $columns;

}

/**
 * Sanitizes data
 *
 * @since 1.0.0
 */
function wpex_sanitize( $data, $type ) {

	// URL
	if ( 'url' == $type ) {
		$data = esc_url( $data );
	}

	// HTML
	elseif ( 'html' == $type ) {
		$data = wp_kses( $data, array(
				'a'         => array(
					'href'  => array(),
					'title' => array()
				),
				'br'        => array(),
				'em'        => array(),
				'strong'    => array(),
		) );
	}

	// Videos
	elseif ( 'video' == $type ) {
		$data = wp_kses( $data, array(
			'iframe' => array(
				'src'               => array(),
				'type'              => array(),
				'allowfullscreen'   => array(),
				'allowscriptaccess' => array(),
				'height'            => array(),
				'width'             => array()
			),
			'embed' => array(
				'src'               => array(),
				'type'              => array(),
				'allowfullscreen'   => array(),
				'allowscriptaccess' => array(),
				'height'            => array(),
				'width'             => array()
			),
		) );
	}

	// Apply filters
	$data = apply_filters( 'wpex_sanitize', $data );

	// Return data
	return $data;

}

/**
 * Checks a custom field value and returns the type (embed, oembed, etc )
 *
 * @since 1.0.0
 */
function wpex_check_meta_type( $value ) {
	if ( strpos( $value, 'embed' ) ) {
		return 'embed';
	} elseif ( strpos( $value, 'iframe' ) ) {
		return 'iframe';
	} else {
		return 'url';
	}
}

/**
 * Custom menu walker
 * 
 * @link  http://codex.wordpress.org/Class_Reference/Walker_Nav_Menu
 * @since 1.0.0
 */
if ( ! class_exists( 'WPEX_Dropdown_Walker_Nav_Menu' ) ) {
	class WPEX_Dropdown_Walker_Nav_Menu extends Walker_Nav_Menu {
		function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
			$id_field = $this->db_fields['id'];
			if ( ! empty( $children_elements[$element->$id_field] ) && ( $depth == 0 ) ) {
				$element->title .= ' <span class="fa fa-caret-down wpex-dropdown-arrow-down"></span>';
			}
			if ( ! empty( $children_elements[$element->$id_field] ) && ( $depth > 0 ) ) {
				$element->title .= ' <span class="fa fa-caret-right wpex-dropdown-arrow-side"></span>';
			}
			Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
		}
	}
}

/**
 * Custom comments callback
 * 
 * @link  http://codex.wordpress.org/Function_Reference/wp_list_comments
 * @since 1.0.0
 */
if ( ! function_exists( 'wpex_comment' ) ) {
	function wpex_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				// Display trackbacks differently than normal comments. ?>
				<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
				<p><strong><?php _e( 'Pingback:', 'chic' ); ?></strong> <?php comment_author_link(); ?></p>
			<?php
			break;
			default :
				// Proceed with normal comments. ?>
				<li id="li-comment-<?php comment_ID(); ?>">
					<div id="comment-<?php comment_ID(); ?>" <?php comment_class( 'wpex-clr' ); ?>>
						<div class="comment-author vcard">
							<?php echo get_avatar( $comment, 50 ); ?>
						</div><!-- .comment-author -->
						<div class="comment-details wpex-clr">
							<header class="comment-meta">
								<cite class="fn"><?php comment_author_link(); ?></cite>
								<span class="comment-date">
								<?php
									printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
										esc_url( get_comment_link( $comment->comment_ID ) ),
										get_comment_time( 'c' ),
										sprintf( _x( '%1$s', '1: date', 'chic' ), get_comment_date() )
									); ?>
								</span><!-- .comment-date -->
							</header><!-- .comment-meta -->
							<?php if ( '0' == $comment->comment_approved ) : ?>
								<p class="comment-awaiting-moderation">
									<?php _e( 'Your comment is awaiting moderation.', 'chic' ); ?>
								</p><!-- .comment-awaiting-moderation -->
							<?php endif; ?>
							<div class="comment-content wpex-entry wpex-clr">
								<?php comment_text(); ?>
							</div><!-- .comment-content -->
							<footer class="comment-footer wpex-clr">
								<?php
								// Cancel comment link
								comment_reply_link( array_merge( $args, array(
									'reply_text'    => __( 'Reply', 'chic' ) . '',
									'depth'         => $depth,
									'max_depth'     => $args['max_depth']
								) ) ); ?>
								<?php
								// Edit comment link
								edit_comment_link( __( 'Edit', 'chic' ), '<div class="edit-comment">', '</div>' ); ?>
							</footer>
						</div><!-- .comment-details -->
					</div><!-- #comment-## -->
			<?php
			break;
		endswitch;
	}
}

/**
 * Returns correct entry excerpt length
 * 
 * @since 1.0.0
 */
function wpex_get_entry_excerpt_length() {
	$length = wpex_get_theme_mod( 'entry_excerpt_length', 45 );
	if ( is_page_template( 'templates/home-categories.php' ) ) {
		$length = wpex_get_theme_mod( 'home_cats_entry_excerpt_length', 20 );
	}
	if ( is_category() ) {
		$obj = get_queried_object();
		$term_id = $obj->term_id;
		if ( $meta = get_term_meta( $term_id, 'wpex_excerpt_length', true ) ) {
			$length = $meta;
		}
	}
	return $length;
}

/**
 * Custom excerpts based on wp_trim_words
 * Created for child-theming purposes
 * 
 * @link  http://codex.wordpress.org/Function_Reference/wp_trim_words
 * @since 1.0.0
 */
function wpex_excerpt( $length = 45, $readmore = false ) {

	// Get global post data
	global $post;
	$id = $post->ID;

	// Check for custom excerpt
	if ( has_excerpt( $id ) ) {
		$output = $post->post_excerpt;
	}

	// No custom excerpt...so lets generate one
	else {

		// Check for more tag and return content if it exists
		if ( strpos( $post->post_content, '<!--more-->' ) ) {
			$output = get_the_content( '' );
		}

		// No more tag defined so generate excerpt using wp_trim_words
		else {

			// Generate excerpt
			$output = wp_trim_words( strip_shortcodes( get_the_content( $id ) ), $length );

			// Add readmore to excerpt if enabled
			if ( $readmore == true ) {
				$readmore_link = false; // Remove readmore link for this theme
				$output .= apply_filters( 'wpex_readmore_link', $readmore_link );
			}

		}

	}

	// Apply filters
	$output = apply_filters( 'wpex_excerpt', $output );

	// Echo excerpt output
	echo $output;

}

/**
 * Remove more link
 *
 * @since 1.0.0
 */
function wpex_remove_more_link( $link ) {
	return null;
}
add_filter( 'the_content_more_link', 'wpex_remove_more_link' );

/**
 * Includes correct template part
 *
 * @since 1.0.0
 */
function wpex_include_template( $template ) {

	// Return if no template is defined
	if ( ! $template ) {
		return;
	}

	// Locate template
	$template = locate_template( $template, false );

	// Load template if it exists
	if ( $template ) {
		include( $template );
	}

}

/**
 * List categories for specific taxonomy
 * 
 * @link    http://codex.wordpress.org/Function_Reference/wp_get_post_terms
 * @since   1.0.0
 */
if ( ! function_exists( 'wpex_get_post_terms' ) ) {

	function wpex_get_post_terms( $taxonomy = 'category', $first_only = false, $classes = '' ) {

		// Define return var
		$return = array();

		// Get terms
		$terms = wp_get_post_terms( get_the_ID(), $taxonomy );

		// Loop through terms and create array of links
		foreach ( $terms as $term ) {

			// Add classes
			$add_classes = 'wpex-term-'. $term->term_id;
			if ( $classes ) {
				$add_classes .= ' '. $classes;
			}
			if ( $add_classes ) {
				$add_classes = ' class="'. $add_classes .'"';
			}

			// Get permalink
			$permalink = get_term_link( $term->term_id, $taxonomy );

			// Add term to array
			$return[] = '<a href="'. $permalink .'" title="'. $term->name .'"'. $add_classes .'>'. $term->name .'</a>';

		}

		// Return if no terms are found
		if ( ! $return ) {
			return;
		}

		// Return first category only
		if ( $first_only ) {
			
			$return = $return[0];

		}

		// Turn terms array into comma seperated list
		else {

			$return = implode( '', $return );

		}

		// Return or echo
		return $return;

	}

}

/**
 * Echos the wpex_list_post_terms function
 * 
 * @since 1.0.0
 */
function wpex_post_terms( $taxonomy = 'category', $first_only = false, $classes = '' ) {
	echo wpex_get_post_terms( $taxonomy, $first_only, $classes );
}

/**
 * Checks if a user has social options defined
 *
 * @since 1.0.0
 */

function wpex_author_has_social( $user_id = NULL ) {
	if ( get_the_author_meta( 'wpex_twitter', $user_id ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpex_facebook', $user_id ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpex_googleplus', $user_id ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpex_linkedin', $user_id ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpex_instagram', $user_id ) ) {
		return true;
	} elseif ( get_the_author_meta( 'wpex_pinterest', $user_id ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Header Social Options array
 *
 * @since 1.0.0
 */
function wpex_header_social_options_array() {
	$options = array(
		'twitter' => array(
			'label'      => 'Twitter',
			'icon_class' => 'fa fa-twitter',
		),
		'facebook' => array(
			'label'      => 'Facebook',
			'icon_class' => 'fa fa-facebook',
		),
		'googleplus' => array(
			'label'      => 'Google Plus',
			'icon_class' => 'fa fa-google-plus',
		),
		'pinterest' => array(
			'label'      => 'Pinterest',
			'icon_class' => 'fa fa-pinterest',
		),
		'dribbble' => array(
			'label'      => 'Dribbble',
			'icon_class' => 'fa fa-dribbble',
		),
		'vk' => array(
			'label'      => 'Vk',
			'icon_class' => 'fa fa-vk',
		),
		'instagram' => array(
			'label'      => 'Instagram',
			'icon_class' => 'fa fa-instagram',
		),
		'linkedin' => array(
			'label'      => 'LinkedIn',
			'icon_class' => 'fa fa-linkedin',
		),
		'tumblr' => array(
			'label'      => 'Tumblr',
			'icon_class' => 'fa fa-tumblr',
		),
		'github' => array(
			'label'      => 'Github',
			'icon_class' => 'fa fa-github-alt',
		),
		'flickr' => array(
			'label'      => 'Flickr',
			'icon_class' => 'fa fa-flickr',
		),
		'skype' => array(
			'label'      => 'Skype',
			'icon_class' => 'fa fa-skype',
		),
		'youtube' => array(
			'label'      => 'Youtube',
			'icon_class' => 'fa fa-youtube-play',
		),
		'vimeo' => array(
			'label'      => 'Vimeo',
			'icon_class' => 'fa fa-vimeo-square',
		),
		'vine' => array(
			'label'      => 'Vine',
			'icon_class' => 'fa fa-vine',
		),
		'xing' => array(
			'label'      => 'Xing',
			'icon_class' => 'fa fa-xing',
		),
		'yelp' => array(
			'label'      => 'Yelp',
			'icon_class' => 'fa fa-yelp',
		),

		'rss' => array(
			'label'      => __( 'RSS', 'chic' ),
			'icon_class' => 'fa fa-rss',
		),
		'email' => array(
			'label'      => __( 'Email', 'chic' ),
			'icon_class' => 'fa fa-envelope',
		),
	);
	$options = apply_filters( 'wpex_header_social_options_array', $options );
	return $options;
}

/**
 * Footer Social Options array
 *
 * @since 1.0.0
 */
function wpex_footer_social_options_array() {
	$options = wpex_header_social_options_array();
	$options = apply_filters( 'wpex_footer_social_options_array', $options );
	return $options;
}


/**
 * Returns correct ad region template part
 *
 * @since 1.0.0
 */
function wpex_ad_region( $location ) {
	if ( ! empty( $_GET['theme_disable_ads'] ) ) {
		return;
	}
	$location = 'partials/ads/'. $location;
	get_template_part( $location );
}

/**
 * Returns correct ad region template part
 *
 * @since 1.0.0
 */
function wpex_fb_comments_url() {
	if ( ! empty( $_GET['theme_fb_comments'] ) ) {
		return 'http://developers.facebook.com/docs/plugins/comments/';
	} else {
		return get_permalink();
	}
}

/**
 * Returns the ID's to exclude for the homepage
 *
 * @since 1.0.0
 */
function wpex_exclude_home_ids(){

	$ids = array();

	// Build array of slider ID's
	if ( $exclude = get_theme_mod( 'home_slider_exclude_posts' ) ) {

		$content = get_theme_mod( 'home_slider_content', 'recent_posts' );
		$count   = get_theme_mod( 'home_slider_count', 4 );

		if ( $content && 'none' != $content && $count >= 1 ) {

			if ( 'recent_posts' == $content ) {

				$posts = get_posts( array(
					'post_type'      => 'post',
					'posts_per_page' => $count,
					'meta_key'       => '_thumbnail_id',
				) );

				if ( $posts ) {
					foreach( $posts as $post ) {
						$ids[] = $post->ID;
					}
				}


			} elseif ( 'none' != $content ) {

				$posts = get_posts( array(
					'post_type'      => 'post',
					'posts_per_page' => $count,
					'meta_key'       => '_thumbnail_id',
					'tax_query'      => array (
						array (
							'taxonomy' => 'category',
							'field'    => 'ID',
							'terms'    => $content,
						)
					)
				) );

				if ( $posts ) {
					foreach( $posts as $post ) {
						$ids[] = $post->ID;
					}
				}

			}

		}

	}

	$ids = apply_filters( 'wpex_exclude_home_ids', $ids );

	return $ids;
}

/**
 * Return full slider style
 *
 * @since 1.0.0
 */
function wpex_get_full_slider_style( $style = 'default' ) {
	if ( ! empty( $_GET['theme_full_slider_style'] ) ) {
		return 'style-'. $_GET['theme_full_slider_style'];
	}
	$style = apply_filters( 'wpex_full_slider_style', $style );
	return 'style-'. $style;
}
function wpex_full_slider_style() {
	echo wpex_get_full_slider_style();
}

/**
 * Minify css
 *
 * @since 1.0.0
 */
function wpex_get_notice_bar_content() {
	return ( apply_filters( 'wpex_notice_bar_content', get_theme_mod( 'notice_bar_content', 'Get 30&#37; off our store with coupon code 30PERCENTOFF!' ) ) );
}

/**
 * Minify css
 *
 * @since 1.0.0
 */
function wpex_minify_css( $css = null ) {

	// Normalize whitespace
	$css = preg_replace( '/\s+/', ' ', $css );

	// Remove ; before }
	$css = preg_replace( '/;(?=\s*})/', '', $css );

	// Remove space after , : ; { } */ >
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

	// Remove space before , ; { }
	$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

	// Strips leading 0 on decimal values (converts 0.5px into .5px)
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

	// Strips units if value is 0 (converts 0px to 0)
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

	// Return minified CSS
	return trim( $css );
	
}

/**
 * Returns thumbnail sizes
 *
 * @since 1.0.0
 * @link  http://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
 */
function wpex_get_thumbnail_sizes( $size = '' ) {

	global $_wp_additional_image_sizes;

	$sizes = array(
		'full'  => array(
		'width'  => '9999',
		'height' => '9999',
		'crop'   => 0,
		),
	);
	$get_intermediate_image_sizes = get_intermediate_image_sizes();

	// Create the full array with sizes and crop info
	foreach( $get_intermediate_image_sizes as $_size ) {

		if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

			$sizes[ $_size ]['width']   = get_option( $_size . '_size_w' );
			$sizes[ $_size ]['height']  = get_option( $_size . '_size_h' );
			$sizes[ $_size ]['crop']    = (bool) get_option( $_size . '_crop' );

		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

			$sizes[ $_size ] = array( 
				'width'     => $_wp_additional_image_sizes[ $_size ]['width'],
				'height'    => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'      => $_wp_additional_image_sizes[ $_size ]['crop']
			);

		}

	}

	// Get only 1 size if found
	if ( $size ) {
		if ( isset( $sizes[ $size ] ) ) {
			return $sizes[ $size ];
		} else {
			return false;
		}
	}

	// Return sizes
	return $sizes;
}

/**
 * Array of Font Awesome Icons
 * Learn more: http://fortawesome.github.io/Font-Awesome/
 *
 * @since   1.0.0
 * @return  array
 */ 
function wpex_get_awesome_icons() {
	$icons = array('none'=>'','adjust'=>'adjust','anchor'=>'anchor','archive'=>'archive','arrows'=>'arrows','arrows-h'=>'arrows-h','arrows-v'=>'arrows-v','asterisk'=>'asterisk','automobile'=>'automobile','ban'=>'ban','bank'=>'bank','bar-chart'=>'bar-chart','bar-chart-o'=>'bar-chart-o','barcode'=>'barcode','bars'=>'bars','beer'=>'beer','bell'=>'bell','bell-o'=>'bell-o','bolt'=>'bolt','bomb'=>'bomb','book'=>'book','bookmark'=>'bookmark','bookmark-o'=>'bookmark-o','briefcase'=>'briefcase','bug'=>'bug','building'=>'building','building-o'=>'building-o','bullhorn'=>'bullhorn','bullseye'=>'bullseye','cab'=>'cab','calendar'=>'calendar','calendar-o'=>'calendar-o','camera'=>'camera','camera-retro'=>'camera-retro','car'=>'car','caret-square-o-down'=>'caret-square-o-down','caret-square-o-left'=>'caret-square-o-left','caret-square-o-right'=>'caret-square-o-right','caret-square-o-up'=>'caret-square-o-up','certificate'=>'certificate','check'=>'check','check-circle'=>'check-circle','check-circle-o'=>'check-circle-o','check-square'=>'check-square','check-square-o'=>'check-square-o','child'=>'child','circle'=>'circle','circle-o'=>'circle-o','circle-o-notch'=>'circle-o-notch','circle-thin'=>'circle-thin','clock-o'=>'clock-o','cloud'=>'cloud','cloud-download'=>'cloud-download','cloud-upload'=>'cloud-upload','code'=>'code','code-fork'=>'code-fork','coffee'=>'coffee','cog'=>'cog','cogs'=>'cogs','comment'=>'comment','comment-o'=>'comment-o','comments'=>'comments','comments-o'=>'comments-o','compass'=>'compass','credit-card'=>'credit-card','crop'=>'crop','crosshairs'=>'crosshairs','cube'=>'cube','cubes'=>'cubes','cutlery'=>'cutlery','dashboard'=>'dashboard','database'=>'database','desktop'=>'desktop','dot-circle-o'=>'dot-circle-o','download'=>'download','edit'=>'edit','ellipsis-h'=>'ellipsis-h','ellipsis-v'=>'ellipsis-v','envelope'=>'envelope','envelope-o'=>'envelope-o','envelope-square'=>'envelope-square','eraser'=>'eraser','exchange'=>'exchange','exclamation'=>'exclamation','exclamation-circle'=>'exclamation-circle','exclamation-triangle'=>'exclamation-triangle','external-link'=>'external-link','external-link-square'=>'external-link-square','eye'=>'eye','eye-slash'=>'eye-slash','fax'=>'fax','female'=>'female','fighter-jet'=>'fighter-jet','file-archive-o'=>'file-archive-o','file-audio-o'=>'file-audio-o','file-code-o'=>'file-code-o','file-excel-o'=>'file-excel-o','file-image-o'=>'file-image-o','file-movie-o'=>'file-movie-o','file-pdf-o'=>'file-pdf-o','file-photo-o'=>'file-photo-o','file-picture-o'=>'file-picture-o','file-powerpoint-o'=>'file-powerpoint-o','file-sound-o'=>'file-sound-o','file-video-o'=>'file-video-o','file-word-o'=>'file-word-o','file-zip-o'=>'file-zip-o','film'=>'film','filter'=>'filter','fire'=>'fire','fire-extinguisher'=>'fire-extinguisher','flag'=>'flag','flag-checkered'=>'flag-checkered','flag-o'=>'flag-o','flash'=>'flash','flask'=>'flask','folder'=>'folder','folder-o'=>'folder-o','folder-open'=>'folder-open','folder-open-o'=>'folder-open-o','frown-o'=>'frown-o','gamepad'=>'gamepad','gavel'=>'gavel','gear'=>'gear','gears'=>'gears','gift'=>'gift','glass'=>'glass','globe'=>'globe','graduation-cap'=>'graduation-cap','group'=>'group','hdd-o'=>'hdd-o','headphones'=>'headphones','heart'=>'heart','heart-o'=>'heart-o','history'=>'history','home'=>'home','image'=>'image','inbox'=>'inbox','info'=>'info','info-circle'=>'info-circle','institution'=>'institution','key'=>'key','keyboard-o'=>'keyboard-o','language'=>'language','laptop'=>'laptop','leaf'=>'leaf','legal'=>'legal','lemon-o'=>'lemon-o','level-down'=>'level-down','level-up'=>'level-up','life-bouy'=>'life-bouy','life-ring'=>'life-ring','life-saver'=>'life-saver','lightbulb-o'=>'lightbulb-o','location-arrow'=>'location-arrow','lock'=>'lock','magic'=>'magic','magnet'=>'magnet','mail-forward'=>'mail-forward','mail-reply'=>'mail-reply','mail-reply-all'=>'mail-reply-all','male'=>'male','map-marker'=>'map-marker','meh-o'=>'meh-o','microphone'=>'microphone','microphone-slash'=>'microphone-slash','minus'=>'minus','minus-circle'=>'minus-circle','minus-square'=>'minus-square','minus-square-o'=>'minus-square-o','mobile'=>'mobile','mobile-phone'=>'mobile-phone','money'=>'money','moon-o'=>'moon-o','mortar-board'=>'mortar-board','music'=>'music','navicon'=>'navicon','paper-plane'=>'paper-plane','paper-plane-o'=>'paper-plane-o','paw'=>'paw','pencil'=>'pencil','pencil-square'=>'pencil-square','pencil-square-o'=>'pencil-square-o','phone'=>'phone','phone-square'=>'phone-square','photo'=>'photo','picture-o'=>'picture-o','plane'=>'plane','plus'=>'plus','plus-circle'=>'plus-circle','plus-square'=>'plus-square','plus-square-o'=>'plus-square-o','power-off'=>'power-off','print'=>'print','puzzle-piece'=>'puzzle-piece','qrcode'=>'qrcode','question'=>'question','question-circle'=>'question-circle','quote-left'=>'quote-left','quote-right'=>'quote-right','random'=>'random','recycle'=>'recycle','refresh'=>'refresh','reorder'=>'reorder','reply'=>'reply','reply-all'=>'reply-all','retweet'=>'retweet','road'=>'road','rocket'=>'rocket','rss'=>'rss','rss-square'=>'rss-square','search'=>'search','search-minus'=>'search-minus','search-plus'=>'search-plus','send'=>'send','send-o'=>'send-o','share'=>'share','share-alt'=>'share-alt','share-alt-square'=>'share-alt-square','share-square'=>'share-square','share-square-o'=>'share-square-o','shield'=>'shield','shopping-cart'=>'shopping-cart','sign-in'=>'sign-in','sign-out'=>'sign-out','signal'=>'signal','sitemap'=>'sitemap','sliders'=>'sliders','smile-o'=>'smile-o','sort'=>'sort','sort-alpha-asc'=>'sort-alpha-asc','sort-alpha-desc'=>'sort-alpha-desc','sort-amount-asc'=>'sort-amount-asc','sort-amount-desc'=>'sort-amount-desc','sort-asc'=>'sort-asc','sort-desc'=>'sort-desc','sort-down'=>'sort-down','sort-numeric-asc'=>'sort-numeric-asc','sort-numeric-desc'=>'sort-numeric-desc','sort-up'=>'sort-up','space-shuttle'=>'space-shuttle','spinner'=>'spinner','spoon'=>'spoon','square'=>'square','square-o'=>'square-o','star'=>'star','star-half'=>'star-half','star-half-empty'=>'star-half-empty','star-half-full'=>'star-half-full','star-half-o'=>'star-half-o','star-o'=>'star-o','suitcase'=>'suitcase','sun-o'=>'sun-o','support'=>'support','tablet'=>'tablet','tachometer'=>'tachometer','tag'=>'tag','tags'=>'tags','tasks'=>'tasks','taxi'=>'taxi','terminal'=>'terminal','thumb-tack'=>'thumb-tack','thumbs-down'=>'thumbs-down','thumbs-o-down'=>'thumbs-o-down','thumbs-o-up'=>'thumbs-o-up','thumbs-up'=>'thumbs-up','ticket'=>'ticket','times'=>'times','times-circle'=>'times-circle','times-circle-o'=>'times-circle-o','tint'=>'tint','toggle-down'=>'toggle-down','toggle-left'=>'toggle-left','toggle-right'=>'toggle-right','toggle-up'=>'toggle-up','trash-o'=>'trash-o','tree'=>'tree','trophy'=>'trophy','truck'=>'truck','umbrella'=>'umbrella','university'=>'university','unlock'=>'unlock','unlock-alt'=>'unlock-alt','unsorted'=>'unsorted','upload'=>'upload','user'=>'user','users'=>'users','video-camera'=>'video-camera','volume-down'=>'volume-down','volume-off'=>'volume-off','volume-up'=>'volume-up','warning'=>'warning','wheelchair'=>'wheelchair','wrench'=>'wrench','file'=>'file','file-archive-o'=>'file-archive-o','file-audio-o'=>'file-audio-o','file-code-o'=>'file-code-o','file-excel-o'=>'file-excel-o','file-image-o'=>'file-image-o','file-movie-o'=>'file-movie-o','file-o'=>'file-o','file-pdf-o'=>'file-pdf-o','file-photo-o'=>'file-photo-o','file-picture-o'=>'file-picture-o','file-powerpoint-o'=>'file-powerpoint-o','file-sound-o'=>'file-sound-o','file-text'=>'file-text','file-text-o'=>'file-text-o','file-video-o'=>'file-video-o','file-word-o'=>'file-word-o','file-zip-o'=>'file-zip-o','circle-o-notch'=>'circle-o-notch','cog'=>'cog','gear'=>'gear','refresh'=>'refresh','spinner'=>'spinner','check-square'=>'check-square','check-square-o'=>'check-square-o','circle'=>'circle','circle-o'=>'circle-o','dot-circle-o'=>'dot-circle-o','minus-square'=>'minus-square','minus-square-o'=>'minus-square-o','plus-square'=>'plus-square','plus-square-o'=>'plus-square-o','square'=>'square','square-o'=>'square-o','bitcoin'=>'bitcoin','btc'=>'btc','cny'=>'cny','dollar'=>'dollar','eur'=>'eur','euro'=>'euro','gbp'=>'gbp','inr'=>'inr','jpy'=>'jpy','krw'=>'krw','money'=>'money','rmb'=>'rmb','rouble'=>'rouble','rub'=>'rub','ruble'=>'ruble','rupee'=>'rupee','try'=>'try','turkish-lira'=>'turkish-lira','usd'=>'usd','won'=>'won','yen'=>'yen','align-center'=>'align-center','align-justify'=>'align-justify','align-left'=>'align-left','align-right'=>'align-right','bold'=>'bold','chain'=>'chain','chain-broken'=>'chain-broken','clipboard'=>'clipboard','columns'=>'columns','copy'=>'copy','cut'=>'cut','dedent'=>'dedent','eraser'=>'eraser','file'=>'file','file-o'=>'file-o','file-text'=>'file-text','file-text-o'=>'file-text-o','files-o'=>'files-o','floppy-o'=>'floppy-o','font'=>'font','header'=>'header','indent'=>'indent','italic'=>'italic','link'=>'link','list'=>'list','list-alt'=>'list-alt','list-ol'=>'list-ol','list-ul'=>'list-ul','outdent'=>'outdent','paperclip'=>'paperclip','paragraph'=>'paragraph','paste'=>'paste','repeat'=>'repeat','rotate-left'=>'rotate-left','rotate-right'=>'rotate-right','save'=>'save','scissors'=>'scissors','strikethrough'=>'strikethrough','subscript'=>'subscript','superscript'=>'superscript','table'=>'table','text-height'=>'text-height','text-width'=>'text-width','th'=>'th','th-large'=>'th-large','th-list'=>'th-list','underline'=>'underline','undo'=>'undo','unlink'=>'unlink','angle-double-down'=>'angle-double-down','angle-double-left'=>'angle-double-left','angle-double-right'=>'angle-double-right','angle-double-up'=>'angle-double-up','angle-down'=>'angle-down','angle-left'=>'angle-left','angle-right'=>'angle-right','angle-up'=>'angle-up','arrow-circle-down'=>'arrow-circle-down','arrow-circle-left'=>'arrow-circle-left','arrow-circle-o-down'=>'arrow-circle-o-down','arrow-circle-o-left'=>'arrow-circle-o-left','arrow-circle-o-right'=>'arrow-circle-o-right','arrow-circle-o-up'=>'arrow-circle-o-up','arrow-circle-right'=>'arrow-circle-right','arrow-circle-up'=>'arrow-circle-up','arrow-down'=>'arrow-down','arrow-left'=>'arrow-left','arrow-right'=>'arrow-right','arrow-up'=>'arrow-up','arrows'=>'arrows','arrows-alt'=>'arrows-alt','arrows-h'=>'arrows-h','arrows-v'=>'arrows-v','caret-down'=>'caret-down','caret-left'=>'caret-left','caret-right'=>'caret-right','caret-square-o-down'=>'caret-square-o-down','caret-square-o-left'=>'caret-square-o-left','caret-square-o-right'=>'caret-square-o-right','caret-square-o-up'=>'caret-square-o-up','caret-up'=>'caret-up','chevron-circle-down'=>'chevron-circle-down','chevron-circle-left'=>'chevron-circle-left','chevron-circle-right'=>'chevron-circle-right','chevron-circle-up'=>'chevron-circle-up','chevron-down'=>'chevron-down','chevron-left'=>'chevron-left','chevron-right'=>'chevron-right','chevron-up'=>'chevron-up','hand-o-down'=>'hand-o-down','hand-o-left'=>'hand-o-left','hand-o-right'=>'hand-o-right','hand-o-up'=>'hand-o-up','long-arrow-down'=>'long-arrow-down','long-arrow-left'=>'long-arrow-left','long-arrow-right'=>'long-arrow-right','long-arrow-up'=>'long-arrow-up','toggle-down'=>'toggle-down','toggle-left'=>'toggle-left','toggle-right'=>'toggle-right','toggle-up'=>'toggle-up','arrows-alt'=>'arrows-alt','backward'=>'backward','compress'=>'compress','eject'=>'eject','expand'=>'expand','fast-backward'=>'fast-backward','fast-forward'=>'fast-forward','forward'=>'forward','pause'=>'pause','play'=>'play','play-circle'=>'play-circle','play-circle-o'=>'play-circle-o','step-backward'=>'step-backward','step-forward'=>'step-forward','stop'=>'stop','youtube-play'=>'youtube-play','adn'=>'adn','android'=>'android','apple'=>'apple','behance'=>'behance','behance-square'=>'behance-square','bitbucket'=>'bitbucket','bitbucket-square'=>'bitbucket-square','bitcoin'=>'bitcoin','btc'=>'btc','codepen'=>'codepen','css3'=>'css3','delicious'=>'delicious','deviantart'=>'deviantart','digg'=>'digg','dribbble'=>'dribbble','dropbox'=>'dropbox','drupal'=>'drupal','empire'=>'empire','facebook'=>'facebook','facebook-square'=>'facebook-square','flickr'=>'flickr','foursquare'=>'foursquare','ge'=>'ge','git'=>'git','git-square'=>'git-square','github'=>'github','github-alt'=>'github-alt','github-square'=>'github-square','gittip'=>'gittip','google'=>'google','google-plus'=>'google-plus','google-plus-square'=>'google-plus-square','hacker-news'=>'hacker-news','html5'=>'html5','instagram'=>'instagram','joomla'=>'joomla','jsfiddle'=>'jsfiddle','linkedin'=>'linkedin','linkedin-square'=>'linkedin-square','linux'=>'linux','maxcdn'=>'maxcdn','openid'=>'openid','pagelines'=>'pagelines','pied-piper'=>'pied-piper','pied-piper-alt'=>'pied-piper-alt','pied-piper-square'=>'pied-piper-square','pinterest'=>'pinterest','pinterest-square'=>'pinterest-square','qq'=>'qq','ra'=>'ra','rebel'=>'rebel','reddit'=>'reddit','reddit-square'=>'reddit-square','renren'=>'renren','share-alt'=>'share-alt','share-alt-square'=>'share-alt-square','skype'=>'skype','slack'=>'slack','soundcloud'=>'soundcloud','spotify'=>'spotify','stack-exchange'=>'stack-exchange','stack-overflow'=>'stack-overflow','steam'=>'steam','steam-square'=>'steam-square','stumbleupon'=>'stumbleupon','stumbleupon-circle'=>'stumbleupon-circle','tencent-weibo'=>'tencent-weibo','trello'=>'trello','tumblr'=>'tumblr','tumblr-square'=>'tumblr-square','twitter'=>'twitter','twitter-square'=>'twitter-square','vimeo-square'=>'vimeo-square','vine'=>'vine','vk'=>'vk','wechat'=>'wechat','weibo'=>'weibo','weixin'=>'weixin','windows'=>'windows','wordpress'=>'wordpress','xing'=>'xing','xing-square'=>'xing-square','yahoo'=>'yahoo','youtube'=>'youtube','youtube-play'=>'youtube-play','youtube-square'=>'youtube-square','ambulance'=>'ambulance','h-square'=>'h-square','hospital-o'=>'hospital-o','medkit'=>'medkit','plus-square'=>'plus-square','stethoscope'=>'stethoscope','user-md'=>'user-md','wheelchair'=>'wheelchair','angellist'=>'angellist','area-chart'=>'fa-area-chart','at'=>'at','bell-slash'=>'bell-slash','bell-slash-o'=>'bell-slash-o','bicycle'=>'bicycle','binoculars'=>'binoculars','birthday-cake'=>'birthday-cake','bus'=>'bus','calculator'=>'calculator','cc'=>'cc','cc-amex'=>'cc-amex','cc-discover'=>'cc-discover','cc-paypal'=>'cc-paypal','cc-stripe'=>'cc-stripe','cc-visa'=>'cc-visa','copyright'=>'copyright','eyedropper'=>'eyedropper','futbol-o'=>'futbol-o','google-wallet'=>'google-wallet','ils'=>'ils','ioxhost'=>'ioxhost','lastfm'=>'lastfm','lastfm-square'=>'lastfm-square','line-chart'=>'line-chart','meanpath'=>'meanpath','newspaper-o'=>'newspaper-o','paint-brush'=>'paint-brush','paypal'=>'paypal','pie-chart'=>'pie-chart','plug'=>'plug','shekel'=>'shekel','sheqel'=>'sheqel','slideshare'=>'slideshare','soccer-ball-o'=>'soccer-ball-o','toggle-off'=>'toggle-off','toggle-on'=>'toggle-on','trash'=>'trash','tty'=>'tty','twitch'=>'twitch','wifi'=>'wifi','yelp'=>'yelp');
	return apply_filters( 'wpex_get_awesome_icons', $icons );
}

/**
 * Array of Font Icons for meta options
 *
 * @since 1.0.0
 * @return array
 */
function wpex_get_meta_awesome_icons() {
	$awesome_icons = wpex_get_awesome_icons();
	$return_array = array();
	foreach ( $awesome_icons as $awesome_icon ) {
		$return_array[] = array(
			'name'  => $awesome_icon,
			'value' => $awesome_icon
		);
	}
	return $return_array;
}