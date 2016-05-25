<?php

/**
 * Lattice integration with Easy Digital Downloads
 *
 * This file adds all the functions which integrate Lattice with
 * Easy Digital Downloads.
 *
 * @package Lattice
 * @since   1.0
 * @version 1.0
 */

/**
 * Customisze the EDD Purchase Link
 *
 * @global  $edd_options EDD Options
 * @global  $post WordPress Post Object
 * @since   1.0
 * @version 1.0
 */
function lattice_purchase_link( $post_id = null ) {
	global $edd_options, $post;

	if ( ! $post_id ) {
		$post_id = $post->ID;
	} // end if

	if( ! is_singular( 'download' ) ) {
		remove_action( 'edd_purchase_link_top', 'edd_download_purchase_form_quantity_field', 10 );
	}

	$variable_pricing = edd_has_variable_prices( $post_id );

	if ( ! $variable_pricing ) {
		echo edd_get_purchase_link( array( 'download_id' => $post_id, 'price' => false ) );
	} else if ( ! is_single() && $variable_pricing ) {
		$button = ! empty( $edd_options[ 'add_to_cart_text' ] ) ? $edd_options[ 'add_to_cart_text' ] : __( 'Purchase', 'lattice' );
		printf( '<a href="#edd-pricing-%s" class="button edd-add-to-cart-trigger">%s</a>', $post->ID, $button );
		echo edd_get_purchase_link( array( 'download_id' => $post_id, 'price' => false ) );
	} else if ( is_single() && $variable_pricing ) {
		echo edd_get_purchase_link( array( 'download_id' => $post_id, 'price' => false ) );
	} // end if
} // end lattice_purchase_link

/**
 * Custom shopping cart which is displayed in the modal box after a user clicks
 * on the 'shopping cart' icon in the header
 *
 * @since   1.0
 * @version 1.0
 */
function lattice_shopping_cart() {
	ob_start();
	?>
	<div id="shopping-cart-modal">
		<!--dynamic-cached-content-->
		<?php $cart_items = edd_get_cart_contents(); ?>

		<?php
		if ( $cart_items ) {
			printf( '<h2>%s</h2>', __( 'Shopping Cart', 'lattice' ) );
			foreach ( $cart_items as $key => $item ) {
				echo edd_get_cart_item_template( $key, $item, false );
			} // end foreach
			edd_get_template_part( 'widget', 'cart-checkout' );
		} else {
			edd_get_template_part( 'widget', 'cart-empty' );
		} // end if
		?>
		<!--/dynamic-cached-content-->
	</div><!-- /#shopping-cart-modal -->
	<?php
	echo ob_get_clean();
} // end lattice_shopping_cart

/**
 * Remove default output of the review title and star rating,
 * lattice_comment() for the modified output of the review title
 * and star rating.
 */
add_filter( 'edd_reviews_ratings_html', '__return_false' );

/**
 * Override the template based on the page being viewed
 *
 * @global  $edd_options
 * @global  WordPress Post Object $post;
 * @since   1.0
 * @version 1.0
 */
function lattice_template_override() {
	global $edd_options, $post;

	if ( is_page( $edd_options['purchase_page'] ) ) {
		load_template( dirname( __FILE__ ) . '/template-full-width.php' );
		die();
	} // end if
} // end lattice_template_override
add_action( 'template_redirect', 'lattice_template_override' );

/**
 * Modify the default output of the [downloads] shortcode
 *
 * @since   1.0
 * @version 1.0
 */
function lattice_downloads_shortcode( $display, $atts, $buy_button, $columns, $column_width, $downloads, $excerpt, $full_content, $price, $thumbnails, $query ) {
	switch( intval( $columns ) ) {
		case 1:
			$column_number = 'col-1';
			break;
		case 2:
			$column_number = 'col-2';
			break;
		case 3:
		case 4:
		case 5:
		case 6:
			$column_number = 'col-3';
			break;
	} // end switch

	ob_start();
	$i = 1;
	?>
	<div class="downloads <?php echo $column_number; ?> clearfix">
		<?php
		// Start the Loop.
		while ( $downloads->have_posts() ) {
			$downloads->the_post();
		?>
		<div itemscope itemtype="http://schema.org/Product" class="edd-download <?php if ( $i % $columns == 0 ) { echo 'col-end'; } ?>" id="edd_download_<?php echo get_the_ID(); ?>">
			<div class="edd-download-inner">
				<?php do_action( 'edd_download_before' ); ?>

				<?php
				if ( 'false' != $thumbnails ) {
					edd_get_template_part( 'shortcode', 'content-image' );
				} // end if

				edd_get_template_part( 'shortcode', 'content-title' );

				if ( $excerpt == 'yes' && $full_content != 'yes' ) {
						edd_get_template_part( 'shortcode', 'content-excerpt' );
				} else if ( $full_content == 'yes' ) {
						edd_get_template_part( 'shortcode', 'content-full' );
				} // end if

				if ( $price == 'yes' ) {
					edd_get_template_part( 'shortcode', 'content-price' );
				} // end if

				if ( $buy_button == 'yes' ) {
					echo edd_get_purchase_link( array( 'download_id' => get_the_ID(), 'price' => false ) );
				} // end if
				?>

				<?php do_action( 'edd_download_after' ); ?>
			</div><!-- /.edd-download-inner -->
		</div><!-- /.edd-download -->
		<?php if ( $i % $columns == 0 ) { ?><div style="clear:both;"></div><?php } ?>
		<?php $i++; } // end while ?>

		<?php wp_reset_postdata(); ?>
	</div><!-- /.downloads.<?php echo $column_number; ?> -->

	<div class="download-pagination navigation">
		<?php
		if ( is_single() ) {
			echo paginate_links( array(
				'base'    => get_permalink() . '%#%',
				'format'  => '?paged=%#%',
				'current' => max( 1, $query['paged'] ),
				'total'   => $downloads->max_num_pages
			) );
		} else {
			$big = 999999;
			echo paginate_links( array(
				'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'  => '?paged=%#%',
				'current' => max( 1, $query['paged'] ),
				'total'   => $downloads->max_num_pages
			) );
		} // end if
		?>
	</div><!-- /.download-pagination -->
	<?php
	$display = ob_get_clean();
	return $display;
} // end lattice_downloads_shortcode
add_filter( 'downloads_shortcode', 'lattice_downloads_shortcode', 10, 11 );

/**
 * Add template name body classes to custom pages
 *
 * @global  $edd_options
 * @param   array $classes Default body classes
 * @return  array $classes Updated body classes
 * @since   1.0
 * @version 1.0
 */
function lattice_body_class( $classes ) {
	global $edd_options;

	if ( ! function_exists( 'edd_get_option' ) ) {
		return;
	}

	/* Add custom <body> classes to the checkout */
	if ( is_page( edd_get_option( 'purchase_page' ) ) ) {
		$classes[] = 'page-template';
		$classes[] = 'page-template-template-full-width-php';
	} // end if

	/* Add custom <body> classes to the purchase confirmation page */
	if ( is_page( edd_get_option( 'success_page' ) ) ) {
		$classes[] = 'edd-success-page';
	} // end if

	return $classes;
} // end lattice_body_class
add_filter( 'body_class', 'lattice_body_class' );