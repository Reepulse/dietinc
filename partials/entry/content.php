<?php
/**
 * The post entry title
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

<div class="wpex-loop-entry-excerpt entry wpex-clr">
	<?php if ( wpex_has_custom_excerpt() ) : ?>
		<?php wpex_excerpt( wpex_get_entry_excerpt_length(), false ); ?>
	<?php else : ?>
	   <?php the_content(); ?>
	<?php endif; ?>
</div><!-- .wpex-loop-entry-excerpt -->