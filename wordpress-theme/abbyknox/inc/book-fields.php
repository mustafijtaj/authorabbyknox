<?php
/**
 * Author-friendly admin: extra book fields, "Books" labels, dashboard quick-start.
 *
 * @package AbbyKnox
 */

defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------------------------
 * Extra fields on the product edit screen (Product data → General)
 * ---------------------------------------------------------------------- */
function ak_product_fields() {
	echo '<div class="options_group ak-book-fields">';
	woocommerce_wp_text_input( array(
		'id'          => '_ak_subtitle',
		'label'       => __( 'Book subtitle', 'abbyknox' ),
		'placeholder' => __( 'e.g. How to Fail at Fake Dating', 'abbyknox' ),
		'desc_tip'    => true,
		'description' => __( 'Shown under the title on book cards and the book page.', 'abbyknox' ),
	) );
	woocommerce_wp_text_input( array(
		'id'                => '_ak_series_order',
		'label'             => __( 'Book # in series', 'abbyknox' ),
		'type'              => 'number',
		'custom_attributes' => array( 'min' => '0', 'step' => '1' ),
		'desc_tip'          => true,
		'description'       => __( 'Reading order inside its series (1, 2, 3…). Choose the series in the "Series" box on the right.', 'abbyknox' ),
	) );
	woocommerce_wp_textarea_input( array(
		'id'          => '_ak_content_notes',
		'label'       => __( 'Content notes', 'abbyknox' ),
		'placeholder' => __( "One warning per line, e.g.\nDeath of a parent (off page)\nSurprise pregnancy", 'abbyknox' ),
		'desc_tip'    => true,
		'description' => __( 'Optional. If filled, the book appears on the Content Notes page and gets a "Content notes" tab.', 'abbyknox' ),
		'rows'        => 4,
	) );
	woocommerce_wp_text_input( array(
		'id'          => '_ak_content_flag',
		'label'       => __( 'Content notes — highlighted line', 'abbyknox' ),
		'placeholder' => __( 'e.g. Darker and kinkier than usual — self-care first.', 'abbyknox' ),
		'desc_tip'    => true,
		'description' => __( 'Optional bold line shown above the notes.', 'abbyknox' ),
	) );
	woocommerce_wp_textarea_input( array(
		'id'          => '_ak_content_footer',
		'label'       => __( 'Content notes — extra text', 'abbyknox' ),
		'desc_tip'    => true,
		'description' => __( 'Optional paragraph shown under the notes.', 'abbyknox' ),
		'rows'        => 2,
	) );
	echo '</div>';
}
add_action( 'woocommerce_product_options_general_product_data', 'ak_product_fields' );

function ak_save_product_fields( $product ) {
	// phpcs:disable WordPress.Security.NonceVerification -- WooCommerce verifies the product save nonce.
	$product->update_meta_data( '_ak_subtitle', isset( $_POST['_ak_subtitle'] ) ? sanitize_text_field( wp_unslash( $_POST['_ak_subtitle'] ) ) : '' );
	$product->update_meta_data( '_ak_series_order', isset( $_POST['_ak_series_order'] ) ? absint( $_POST['_ak_series_order'] ) : 0 );
	$product->update_meta_data( '_ak_content_notes', isset( $_POST['_ak_content_notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['_ak_content_notes'] ) ) : '' );
	$product->update_meta_data( '_ak_content_flag', isset( $_POST['_ak_content_flag'] ) ? sanitize_text_field( wp_unslash( $_POST['_ak_content_flag'] ) ) : '' );
	$product->update_meta_data( '_ak_content_footer', isset( $_POST['_ak_content_footer'] ) ? sanitize_textarea_field( wp_unslash( $_POST['_ak_content_footer'] ) ) : '' );
	// phpcs:enable
}
add_action( 'woocommerce_admin_process_product_object', 'ak_save_product_fields' );

/** Help box on the book edit screen explaining the three kinds of books. */
function ak_book_help_metabox() {
	add_meta_box( 'ak_book_help', __( 'How to add a book', 'abbyknox' ), 'ak_book_help_render', 'product', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'ak_book_help_metabox' );

function ak_book_help_render() {
	?>
	<div class="ak-help">
		<p><strong><?php esc_html_e( '1. Ebook sold here', 'abbyknox' ); ?></strong><br>
		<?php esc_html_e( 'Product type: Simple product → tick Virtual + Downloadable → set Regular price → upload the EPUB/PDF under "Downloadable files". Buyers get the download link by email and in their account after paying.', 'abbyknox' ); ?></p>
		<p><strong><?php esc_html_e( '2. Signed paperback', 'abbyknox' ); ?></strong><br>
		<?php esc_html_e( 'Simple product (no ticks) → set price → set weight in Shipping tab → set stock in Inventory. Add category "Signed Books". Orders show under WooCommerce → Orders for you to ship.', 'abbyknox' ); ?></p>
		<p><strong><?php esc_html_e( '3. Listing only (Amazon, Books2Read…)', 'abbyknox' ); ?></strong><br>
		<?php esc_html_e( 'Product type: External/Affiliate product → paste the store link in "Product URL" → Button text e.g. "Buy on Amazon". Price is optional.', 'abbyknox' ); ?></p>
		<p><?php esc_html_e( 'Always: add a cover in "Product image", pick the Series on the right, and (optionally) a subtitle and content notes below.', 'abbyknox' ); ?></p>
	</div>
	<?php
}

/* -------------------------------------------------------------------------
 * Rename "Products" to "Books" in the admin for the author
 * ---------------------------------------------------------------------- */
function ak_product_labels( $labels ) {
	$map = array(
		'name'               => __( 'Books', 'abbyknox' ),
		'singular_name'      => __( 'Book', 'abbyknox' ),
		'menu_name'          => __( 'Books', 'abbyknox' ),
		'all_items'          => __( 'All Books', 'abbyknox' ),
		'add_new'            => __( 'Add New Book', 'abbyknox' ),
		'add_new_item'       => __( 'Add new book', 'abbyknox' ),
		'edit_item'          => __( 'Edit book', 'abbyknox' ),
		'new_item'           => __( 'New book', 'abbyknox' ),
		'view_item'          => __( 'View book', 'abbyknox' ),
		'search_items'       => __( 'Search books', 'abbyknox' ),
		'not_found'          => __( 'No books found', 'abbyknox' ),
		'not_found_in_trash' => __( 'No books found in trash', 'abbyknox' ),
	);
	foreach ( $map as $k => $v ) {
		$labels->$k = $v;
	}
	return $labels;
}
add_filter( 'post_type_labels_product', 'ak_product_labels' );

/** Small admin CSS for the help box. */
function ak_admin_css() {
	echo '<style>.ak-help p{margin:0 0 .8em;font-size:12.5px;line-height:1.5}.ak-help strong{color:#c2185b}#ak_dashboard .ak-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px}#ak_dashboard .ak-grid a{display:block;padding:10px 12px;border:1px solid #f0dbe3;border-radius:8px;text-decoration:none;background:#fff7f9}#ak_dashboard .ak-grid a:hover{border-color:#c2185b}#ak_dashboard .ak-grid strong{display:block;color:#3b0f2a}</style>';
}
add_action( 'admin_head', 'ak_admin_css' );

/* -------------------------------------------------------------------------
 * Dashboard quick-start widget
 * ---------------------------------------------------------------------- */
function ak_dashboard_widget() {
	add_meta_box( 'ak_dashboard', __( 'Abby Knox — quick start', 'abbyknox' ), 'ak_dashboard_render', 'dashboard', 'normal', 'high' );
	// Put it first, above WooCommerce's own boxes.
	global $wp_meta_boxes;
	$high = $wp_meta_boxes['dashboard']['normal']['high'] ?? array();
	if ( isset( $high['ak_dashboard'] ) ) {
		$ours = array( 'ak_dashboard' => $high['ak_dashboard'] );
		unset( $high['ak_dashboard'] );
		$wp_meta_boxes['dashboard']['normal']['high'] = $ours + $high; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
	}
}
add_action( 'wp_dashboard_setup', 'ak_dashboard_widget', 999 );

function ak_dashboard_render() {
	$links = array(
		array( admin_url( 'post-new.php?post_type=product' ), __( 'Add a new book', 'abbyknox' ), __( 'Ebook, signed paperback or store listing', 'abbyknox' ) ),
		array( admin_url( 'edit.php?post_type=product' ), __( 'All books & prices', 'abbyknox' ), __( 'Edit titles, prices, covers', 'abbyknox' ) ),
		array( admin_url( 'admin.php?page=wc-orders' ), __( 'Orders', 'abbyknox' ), __( 'See and ship new orders', 'abbyknox' ) ),
		array( admin_url( 'edit-tags.php?taxonomy=book_series&post_type=product' ), __( 'Series & universes', 'abbyknox' ), __( 'Controls the Reading List', 'abbyknox' ) ),
		array( admin_url( 'customize.php?autofocus[panel]=ak_panel' ), __( 'Homepage text & links', 'abbyknox' ), __( 'Hero, newsletter, socials', 'abbyknox' ) ),
		array( admin_url( 'admin.php?page=wc-settings&tab=checkout' ), __( 'Payments (PayPal)', 'abbyknox' ), __( 'Connect your PayPal account', 'abbyknox' ) ),
	);
	echo '<div class="ak-grid">';
	foreach ( $links as $l ) {
		printf( '<a href="%s"><strong>%s</strong><span>%s</span></a>', esc_url( $l[0] ), esc_html( $l[1] ), esc_html( $l[2] ) );
	}
	echo '</div>';
}
