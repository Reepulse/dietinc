<?php
/**
 * Defines the array for the custom fields and metaboxes class
 *
 * @package   Chic WordPress Theme
 * @author    Alexander Clarke
 * @copyright Copyright (c) 2015, WPExplorer.com
 * @link      http://www.wpexplorer.com
 * @since     1.0.0
 */

// Only needed for the admin side
if ( ! is_admin() ) {
    return;
}

// Define meta array
function wpex_metaboxes( array $meta_boxes ) {

    // Meta prefix
    $prefix = 'wpex_';

    // Layouts
    $layouts = array(
        ''              => __( 'Default', 'chic' ),
        'right-sidebar' => __( 'Right Sidebar', 'chic' ),
        'left-sidebar'  => __( 'Left Sidebar', 'chic' ),
        'full-width'    => __( 'No Sidebar', 'chic' ),
    );

    // Posts
    $meta_boxes[] = array(
        'id'            => 'wpex-wpex-post-meta',
        'title'         => __( 'Post Settings', 'chic' ),
        'pages'         => array( 'post' ),
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true,
        'fields'        => array(
            array(
                'name'  => __( 'Video', 'chic' ),
                'desc'  => __( 'Enter your embed code or enter in a URL that is compatible with WordPress\'s built-in oEmbed function or self-hosted video function.', 'chic' ),
                'id'    => $prefix . 'post_video',
                'type'  => 'textarea_code',
                'std'   => '',
            ),
        ),
    );

    // Pages
    $meta_boxes[] = array(
        'id'            => 'wpex-wpex-page-meta',
        'title'         => __( 'Page Settings', 'chic' ),
        'pages'         => array( 'page' ),
        'context'       => 'side',
        'priority'      => 'high',
        'show_names'    => true,
        'fields'        => array(
            array(
                'name'    => __( 'Post Layout', 'chic' ),
                'default' => '',
                'desc'    => __( 'Select your post layout.', 'chic' ),
                'id'      => $prefix . 'post_layout',
                'type'    => 'select',
                'options' => $layouts,
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'wpex_metaboxes' );