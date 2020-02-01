<?php
/**
 * Outputs a read more link for entries
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

// Define text
$text = get_theme_mod( 'entry_readmore_text' );
$text = $text ? $text : __( 'Continue Reading', 'chic' );
$text = apply_filters( 'wpex_entry_readmore_text', $text ); ?>


<?php if ( $text ) : ?>

	<div class="wpex-loop-entry-readmore wpex-clr">

		<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $text ); ?>" class="wpex-readmore wpex-border-button"><?php echo $text; ?></a>
		
	</div><!-- .wpex-loop-entry-readmore -->

<?php endif; ?>