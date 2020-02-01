<?php
/**
 * Outputs social sharing links for single posts
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

// Heading text
$heading = apply_filters( 'wpex_social_share_heading', null );

// Post data
$post_id = get_the_ID();

// Sharing vars
if ( has_post_thumbnail() ) {
    $img = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
    $img = esc_url( $img );
} else {
    $img = false;
}

// Source URL
$source = home_url();

// Post Data
$permalink = get_permalink( $post_id );
$url       = urlencode( $permalink );
$title     = urlencode( esc_attr( the_title_attribute( 'echo=0' ) ) );
$summary   = urlencode( get_the_excerpt() );
$img       = urlencode( wp_get_attachment_url( get_post_thumbnail_id( $post_id ) ) );
$source    = urlencode( home_url() ); ?>

<div class="wpex-post-share wpex-clr">

    <?php if ( $heading ) : ?>
        <h4 class="heading"><?php echo $heading; ?></h4>
    <?php endif; ?>

    <ul class="wpex-post-share-list wpex-clr">
    
        <li class="wpex-twitter">
            <a href="http://twitter.com/share?text=<?php echo $title; ?>&amp;url=<?php echo $url; ?>" title="<?php _e( 'Share on Twitter', 'chic' ); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <span class="fa fa-twitter"></span><?php _e( 'Tweet', 'chic' ); ?>
            </a>
        </li>

        <li class="wpex-facebook">
            <a href="http://www.facebook.com/share.php?u=<?php echo $url; ?>" title="<?php _e( 'Share on Facebook', 'chic' ); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <span class="fa fa-facebook"></span><?php _e( 'Share', 'chic' ); ?>
            </a>
        </li>

        <li class="wpex-googleplus">
            <a href="https://plus.google.com/share?url=<?php echo $url; ?>" title="<?php _e( 'Share on Google+', 'chic' ); ?>" rel="external" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <span class="fa fa-google-plus"></span><?php _e( 'Plus One', 'chic' ); ?>
            </a>
        </li>

        <li class="wpex-pinterest">
            <a href="http://pinterest.com/pin/create/button/?url=<?php echo $url; ?>&amp;media=<?php echo $img; ?>&amp;description=<?php echo $summary; ?>" title="<?php _e( 'Share on Pinterest', 'chic' ); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <span class="fa fa-pinterest"></span><?php _e( 'Pin it', 'chic' ); ?>
            </a>
        </li>

        <?php /*
        <li class="wpex-linkedin">
            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $url; ?>&amp;title=<?php echo $title; ?>&amp;summary=<?php echo $summary; ?>&amp;source=<?php echo $source; ?>" title="<?php _e( 'Share on LinkedIn', 'chic' ); ?>" rel="nofollow" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <span class="fa fa-linkedin"></span><?php _e( 'Share', 'chic' ); ?>
            </a>
        </li>
        */ ?>

    </ul>

</div><!-- .wpex-post-share -->