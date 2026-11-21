<?php
/**
 * WooCommerce integration.
 *
 * @package AbbyKnox
 */

defined( 'ABSPATH' ) || exit;

/* Layout wrappers: use the theme container instead of Woo's default + no sidebar. */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_action( 'woocommerce_before_main_content', static function () {
	echo '<div class="section woo-section"><div class="container">';
}, 10 );
add_action( 'woocommerce_after_main_content', static function () {
	echo '</div></div>';
}, 10 );

/* Products per page & columns on the shop. */
add_filter( 'loop_shop_per_page', static function () {
	return 24;
} );
add_filter( 'loop_shop_columns', static function () {
	return 4;
} );

/* Hide listing-only books without covers from the main shop grid (they still live on the Reading List). Category pages show everything. */
function ak_shop_only_covers( $q ) {
	if ( is_admin() || ! $q->is_main_query() || ! ( is_shop() || is_product_tag() || is_tax( 'book_series' ) ) ) {
		return;
	}
	$meta   = (array) $q->get( 'meta_query' );
	$meta[] = array( 'key' => '_thumbnail_id', 'compare' => 'EXISTS' );
	$q->set( 'meta_query', $meta );
}
add_action( 'woocommerce_product_query', 'ak_shop_only_covers' );

/* -------------------------------------------------------------------------
 * Single book page
 * ---------------------------------------------------------------------- */

/** Subtitle + series under the title. */
function ak_single_subtitle() {
	global $product;
	$sub = ak_subtitle( $product->get_id() );
	if ( $sub ) {
		echo '<p class="book-subtitle">' . esc_html( $sub ) . '</p>';
	}
	$terms = get_the_terms( $product->get_id(), 'book_series' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		$t     = $terms[0];
		$order = (int) $product->get_meta( '_ak_series_order' );
		$link  = ak_page_url( 'reading-list' ) . '#' . ( $t->parent ? get_term( $t->parent, 'book_series' )->slug : $t->slug );
		printf(
			'<p class="book-series">%s <a href="%s">%s</a></p>',
			$order ? esc_html( sprintf( /* translators: %d book number */ __( 'Book %d in', 'abbyknox' ), $order ) ) : esc_html__( 'Part of', 'abbyknox' ),
			esc_url( $link ),
			esc_html( $t->name )
		);
	}
}
add_action( 'woocommerce_single_product_summary', 'ak_single_subtitle', 6 );

/** Format badge above the price. */
function ak_single_format_badge() {
	global $product;
	if ( $product->is_type( 'external' ) ) {
		$label = __( 'Available from your favourite store', 'abbyknox' );
	} elseif ( $product->is_downloadable() ) {
		$label = __( 'Ebook · instant download after payment', 'abbyknox' );
	} else {
		$label = __( 'Signed paperback · shipped by Abby', 'abbyknox' );
	}
	echo '<span class="pill format-pill">' . esc_html( $label ) . '</span>';
}
add_action( 'woocommerce_single_product_summary', 'ak_single_format_badge', 8 );

/** "Content notes" tab. */
function ak_content_notes_tab( $tabs ) {
	global $product;
	if ( $product && trim( (string) $product->get_meta( '_ak_content_notes' ) ) ) {
		$tabs['ak_content_notes'] = array(
			'title'    => __( 'Content notes', 'abbyknox' ),
			'priority' => 25,
			'callback' => static function () use ( $product ) {
				echo '<p class="cn-spoiler">' . esc_html__( 'May contain spoilers.', 'abbyknox' ) . '</p>';
				ak_render_content_notes( $product );
			},
		);
	}
	unset( $tabs['additional_information'] );
	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'ak_content_notes_tab' );

/** Renders a product's content notes list. */
function ak_render_content_notes( $product ) {
	$flag   = (string) $product->get_meta( '_ak_content_flag' );
	$notes  = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $product->get_meta( '_ak_content_notes' ) ) ) );
	$footer = (string) $product->get_meta( '_ak_content_footer' );
	echo '<div class="note-body">';
	if ( $flag ) {
		echo '<p class="note-flag">' . esc_html( $flag ) . '</p>';
	}
	if ( $notes ) {
		echo '<ul>';
		foreach ( $notes as $n ) {
			echo '<li>' . esc_html( $n ) . '</li>';
		}
		echo '</ul>';
	}
	if ( $footer ) {
		echo '<p>' . esc_html( $footer ) . '</p>';
	}
	echo '</div>';
}

/* Friendlier button text. */
add_filter( 'woocommerce_product_single_add_to_cart_text', static function ( $text, $product ) {
	if ( $product->is_type( 'simple' ) ) {
		return $product->is_downloadable() ? __( 'Buy ebook', 'abbyknox' ) : __( 'Add signed copy to cart', 'abbyknox' );
	}
	return $text;
}, 10, 2 );

add_filter( 'woocommerce_product_related_products_heading', static function () {
	return __( 'You might also love', 'abbyknox' );
} );

/* -------------------------------------------------------------------------
 * Header cart count (live updates via Woo fragments)
 * ---------------------------------------------------------------------- */
function ak_cart_link() {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return '';
	}
	$count = WC()->cart->get_cart_contents_count();
	return sprintf(
		'<a class="cart-link" href="%1$s" aria-label="%2$s">%3$s<span class="cart-count%4$s">%5$d</span></a>',
		esc_url( wc_get_cart_url() ),
		esc_attr( sprintf( /* translators: %d items */ _n( 'Cart, %d item', 'Cart, %d items', $count, 'abbyknox' ), $count ) ),
		ak_icon( 'cart' ),
		$count ? '' : ' is-empty',
		$count
	);
}

add_filter( 'woocommerce_add_to_cart_fragments', static function ( $fragments ) {
	$fragments['a.cart-link'] = ak_cart_link();
	return $fragments;
} );

/* Ensure cart fragments script loads (needed for the header count on classic themes). */
add_action( 'wp_enqueue_scripts', static function () {
	wp_enqueue_script( 'wc-cart-fragments' );
}, 20 );

/* Notices are printed once at the top of our archive template. */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );

/* -------------------------------------------------------------------------
 * CSV import support (Books → Import): series path, release date
 *   Meta: _ak_series_import  "Universe > Series"  (or just "Universe")
 *   Meta: _ak_universe_desc / _ak_series_desc     term descriptions (only if empty)
 *   Meta: _ak_release_date   YYYY-MM-DD           sets the publish date (controls "latest")
 * ---------------------------------------------------------------------- */
function ak_import_get_term( $name, $parent = 0, $desc = '' ) {
	$found = get_terms( array( 'taxonomy' => 'book_series', 'name' => $name, 'parent' => $parent, 'hide_empty' => false, 'number' => 1 ) );
	if ( $found && ! is_wp_error( $found ) ) {
		$term_id = (int) $found[0]->term_id;
		if ( $desc && '' === $found[0]->description ) {
			wp_update_term( $term_id, 'book_series', array( 'description' => $desc ) );
		}
		return $term_id;
	}
	$siblings = get_terms( array( 'taxonomy' => 'book_series', 'parent' => $parent, 'hide_empty' => false, 'fields' => 'ids' ) );
	$res      = wp_insert_term( $name, 'book_series', array( 'parent' => $parent, 'description' => $desc ) );
	if ( is_wp_error( $res ) ) {
		return isset( $res->error_data['term_exists'] ) ? (int) $res->error_data['term_exists'] : 0;
	}
	update_term_meta( $res['term_id'], 'ak_order', ( is_array( $siblings ) ? count( $siblings ) : 0 ) * 10 );
	return (int) $res['term_id'];
}

function ak_import_after_product( $product ) {
	$decode = static function ( $v ) {
		return trim( html_entity_decode( (string) $v, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
	};
	$path   = $decode( $product->get_meta( '_ak_series_import' ) );
	if ( $path ) {
		$parts  = array_map( 'trim', explode( '>', $path ) );
		$parent = ak_import_get_term( $parts[0], 0, $decode( $product->get_meta( '_ak_universe_desc' ) ) );
		$target = $parent;
		if ( ! empty( $parts[1] ) && $parent ) {
			$target = ak_import_get_term( $parts[1], $parent, $decode( $product->get_meta( '_ak_series_desc' ) ) );
		}
		if ( $target ) {
			wp_set_object_terms( $product->get_id(), array( $target ), 'book_series', false );
		}
	}
	$date = trim( (string) $product->get_meta( '_ak_release_date' ) );
	if ( $date && preg_match( '/^\d{4}-\d{2}-\d{2}/', $date ) ) {
		$time = strtotime( $date . ' 12:00:00' );
		wp_update_post( array(
			'ID'            => $product->get_id(),
			'post_date'     => gmdate( 'Y-m-d H:i:s', $time ),
			'post_date_gmt' => gmdate( 'Y-m-d H:i:s', $time ),
		) );
	}
	foreach ( array( '_ak_series_import', '_ak_universe_desc', '_ak_series_desc', '_ak_release_date' ) as $k ) {
		delete_post_meta( $product->get_id(), $k );
	}
}
add_action( 'woocommerce_product_import_inserted_product_object', 'ak_import_after_product', 20 );
