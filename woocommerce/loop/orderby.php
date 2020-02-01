<?php
/**
 * Show options for ordering
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     999999 // prevent notice
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<ul class="wpex-shop-orderby wpex-clr wpex-dropdown">
	<li class="wpex-border-button"><?php _e( 'Sort Products', 'chic' ); ?><span class="fa fa-caret-down"></span>
		<ul>
			<?php foreach ( $catalog_orderby_options as $id => $name ) :
				$name = str_replace( 'Sort by', '', $name ); ?>
				<li>
					<a href="?orderby=<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>>
						<?php echo esc_html( $name ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</li>
</ul>