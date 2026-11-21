<?php
/**
 * Abby Knox theme — functions and definitions.
 *
 * @package AbbyKnox
 */

defined( 'ABSPATH' ) || exit;

define( 'AK_VERSION', '1.0.0' );
define( 'AK_DIR', get_template_directory() );
define( 'AK_URI', get_template_directory_uri() );

require AK_DIR . '/inc/helpers.php';
require AK_DIR . '/inc/customizer.php';
require AK_DIR . '/inc/book-fields.php';
require AK_DIR . '/inc/setup-content.php';
if ( class_exists( 'WooCommerce' ) ) {
	require AK_DIR . '/inc/woocommerce.php';
}

/* -------------------------------------------------------------------------
 * Theme supports & menus
 * ---------------------------------------------------------------------- */
function ak_setup() {
	load_theme_textdomain( 'abbyknox', AK_DIR . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 84, 'width' => 84, 'flex-width' => true, 'flex-height' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );

	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 500,
		'single_image_width'    => 800,
		'product_grid'          => array( 'default_columns' => 4, 'min_columns' => 2, 'max_columns' => 6 ),
	) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus( array(
		'primary' => __( 'Main menu', 'abbyknox' ),
		'footer'  => __( 'Footer menu', 'abbyknox' ),
	) );

	add_image_size( 'ak-cover', 500, 750, false );
}
add_action( 'after_setup_theme', 'ak_setup' );

/* -------------------------------------------------------------------------
 * Assets
 * ---------------------------------------------------------------------- */
function ak_assets() {
	wp_enqueue_style( 'ak-fonts', 'https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,600&family=DM+Sans:wght@400;500;600;700&family=Caveat:wght@600&display=swap', array(), null );
	wp_enqueue_style( 'ak-main', AK_URI . '/assets/css/main.css', array(), AK_VERSION );
	wp_enqueue_style( 'ak-wp', AK_URI . '/assets/css/wordpress.css', array( 'ak-main' ), AK_VERSION );
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'ak-woo', AK_URI . '/assets/css/woocommerce.css', array( 'ak-main' ), AK_VERSION );
	}
	wp_enqueue_script( 'ak-main', AK_URI . '/assets/js/main.js', array(), AK_VERSION, array( 'in_footer' => true, 'strategy' => 'defer' ) );
}
add_action( 'wp_enqueue_scripts', 'ak_assets' );

function ak_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'ak_resource_hints', 10, 2 );

function ak_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'page-' . sanitize_html_class( get_post_field( 'post_name', get_queried_object_id() ) );
	}
	return $classes;
}
add_filter( 'body_class', 'ak_body_classes' );

/* -------------------------------------------------------------------------
 * Book series taxonomy (Universe → Series) for products
 * ---------------------------------------------------------------------- */
function ak_register_series() {
	register_taxonomy( 'book_series', array( 'product' ), array(
		'labels'            => array(
			'name'              => __( 'Series', 'abbyknox' ),
			'singular_name'     => __( 'Series', 'abbyknox' ),
			'menu_name'         => __( 'Series & Universes', 'abbyknox' ),
			'all_items'         => __( 'All series', 'abbyknox' ),
			'parent_item'       => __( 'Universe (parent)', 'abbyknox' ),
			'parent_item_colon' => __( 'Universe:', 'abbyknox' ),
			'edit_item'         => __( 'Edit series', 'abbyknox' ),
			'add_new_item'      => __( 'Add new series or universe', 'abbyknox' ),
			'new_item_name'     => __( 'New series name', 'abbyknox' ),
			'search_items'      => __( 'Search series', 'abbyknox' ),
		),
		'description'       => __( 'Top-level terms are universes (shown as headings on the Reading List). Child terms are series inside a universe.', 'abbyknox' ),
		'hierarchical'      => true,
		'public'            => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'series' ),
	) );
}
add_action( 'init', 'ak_register_series' );

/* Term order field (controls order on the Reading List) */
function ak_series_order_field_add() {
	?>
	<div class="form-field">
		<label for="ak_order"><?php esc_html_e( 'Display order', 'abbyknox' ); ?></label>
		<input type="number" name="ak_order" id="ak_order" value="0" />
		<p><?php esc_html_e( 'Lower numbers appear first on the Reading List.', 'abbyknox' ); ?></p>
	</div>
	<?php
}
add_action( 'book_series_add_form_fields', 'ak_series_order_field_add' );

function ak_series_order_field_edit( $term ) {
	$order = (int) get_term_meta( $term->term_id, 'ak_order', true );
	?>
	<tr class="form-field">
		<th scope="row"><label for="ak_order"><?php esc_html_e( 'Display order', 'abbyknox' ); ?></label></th>
		<td><input type="number" name="ak_order" id="ak_order" value="<?php echo esc_attr( $order ); ?>" />
		<p class="description"><?php esc_html_e( 'Lower numbers appear first on the Reading List.', 'abbyknox' ); ?></p></td>
	</tr>
	<?php
}
add_action( 'book_series_edit_form_fields', 'ak_series_order_field_edit' );

function ak_series_order_save( $term_id ) {
	if ( isset( $_POST['ak_order'] ) && current_user_can( 'manage_product_terms' ) ) { // phpcs:ignore WordPress.Security.NonceVerification -- core term screens verify the nonce.
		update_term_meta( $term_id, 'ak_order', (int) $_POST['ak_order'] ); // phpcs:ignore WordPress.Security.NonceVerification
	}
}
add_action( 'created_book_series', 'ak_series_order_save' );
add_action( 'edited_book_series', 'ak_series_order_save' );

/* -------------------------------------------------------------------------
 * Menu fallback
 * ---------------------------------------------------------------------- */
function ak_menu_fallback() {
	$items = ak_default_nav_items();
	echo '<ul>';
	foreach ( $items as $item ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $item['url'] ), esc_html( $item['label'] ) );
	}
	echo '</ul>';
}

/** Adds the `active` class to current menu links so the design highlights them. */
function ak_nav_link_atts( $atts, $item ) {
	if ( in_array( 'current-menu-item', (array) $item->classes, true ) || in_array( 'current-menu-ancestor', (array) $item->classes, true ) ) {
		$atts['class'] = trim( ( $atts['class'] ?? '' ) . ' active' );
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'ak_nav_link_atts', 10, 2 );
