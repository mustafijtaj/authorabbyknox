<?php
/**
 * One-time setup on theme activation: pages, book categories, menu, static front page.
 * Safe to run again — it never duplicates or overwrites existing content.
 *
 * @package AbbyKnox
 */

defined( 'ABSPATH' ) || exit;

function ak_find_page_by_slug( $slug ) {
	$page = get_page_by_path( $slug, OBJECT, 'page' );
	return $page ? (int) $page->ID : 0;
}

function ak_ensure_page( $slug, $title, $template = '', $content = '', $excerpt = '' ) {
	$id = ak_find_page_by_slug( $slug );
	if ( ! $id ) {
		$id = wp_insert_post( array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_name'    => $slug,
			'post_title'   => $title,
			'post_content' => $content,
			'post_excerpt' => $excerpt,
		) );
	}
	if ( $id && ! is_wp_error( $id ) && $template ) {
		update_post_meta( $id, '_wp_page_template', 'page-templates/' . $template . '.php' );
	}
	return (int) $id;
}

function ak_about_content() {
	return <<<'HTML'
<!-- wp:heading -->
<h2 class="wp-block-heading">Fantasy vs. <em>Reality</em></h2>
<!-- /wp:heading -->

<!-- wp:columns {"className":"ak-vs"} -->
<div class="wp-block-columns ak-vs"><!-- wp:column {"className":"vs-card fantasy"} -->
<div class="wp-block-column vs-card fantasy"><!-- wp:paragraph {"className":"vs-label"} -->
<p class="vs-label">Fantasy Abby</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Dreams big (and rural)</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Pictures herself on a farm with Ryan Gosling, raising goats and chickens — or living in a cottage in a magical wood as a historical re-enactor.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"vs-card reality"} -->
<div class="wp-block-column vs-card reality"><!-- wp:paragraph {"className":"vs-label"} -->
<p class="vs-label">Reality Abby</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Keeps it on the page</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Has absolutely no interest in mucking out stalls or wearing bloomers. So she does the next best thing: turns those daydreams into romance novels.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Favourite tropes</h2>
<!-- /wp:heading -->

<!-- wp:list {"className":"trope-cloud light-bg"} -->
<ul class="wp-block-list trope-cloud light-bg"><!-- wp:list-item -->
<li>Forced proximity</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Only one bed</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Opposites attract</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Grumpy / sunshine</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Age gap</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Boss / employee</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Fated mates</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Insta-love</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Raised on…</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><em>Buffy the Vampire Slayer</em>, <em>Gilmore Girls</em> and <em>LOST</em> — but I promise you’ll never have to suffer through a Luke-and-Lorelai-sized rough patch in my books.</p>
<!-- /wp:paragraph -->
HTML;
}

function ak_run_setup() {
	// Pages.
	$home = ak_ensure_page( 'home', 'Home' );
	ak_ensure_page( 'reading-list', 'The Complete Reading List', 'reading-list', '', 'Want to see anything you might have missed? This is your ultimate guide to every title by Abby — grouped by universe and series, in reading order.' );
	ak_ensure_page( 'content-notes', 'Content Notes', 'content-notes', '', 'Trigger warnings and content notes for Abby’s books, so you can look after yourself while you read.' );
	ak_ensure_page( 'subscribe', 'Subscribe', 'subscribe', '', 'Get free books, bonus material and the latest book news delivered right to your inbox.' );
	ak_ensure_page( 'about', 'About', 'about', ak_about_content(), 'I write upbeat romance with plenty of heat. Readers describe my books as quirky, sexy, adorable and funny — and honestly, that’s the dream.' );

	if ( $home ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home );
	}

	// Book categories (needs WooCommerce).
	$cats = array(
		'signed-books' => array( 'Signed Books', 'Signed paperbacks, bundles and surprise book packs — many with little extras tucked inside.' ),
		'abby-bites'   => array( 'Abby Bites', 'Monster and paranormal romance reads, sold direct. Pay securely and download your ebook straight away.' ),
		'bonus'        => array( 'Bonus', 'Bonus scenes, bonus epilogues and a free book — on the house.' ),
		'ebooks'       => array( 'Ebooks', 'Ebooks you can buy direct from Abby and download instantly.' ),
	);
	if ( taxonomy_exists( 'product_cat' ) ) {
		foreach ( $cats as $slug => $c ) {
			if ( ! get_term_by( 'slug', $slug, 'product_cat' ) ) {
				wp_insert_term( $c[0], 'product_cat', array( 'slug' => $slug, 'description' => $c[1] ) );
			}
		}
	}

	// Main menu.
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( empty( $locations['primary'] ) ) {
		$menu_id = wp_create_nav_menu( 'Main menu' );
		if ( ! is_wp_error( $menu_id ) ) {
			$pos = 0;
			foreach ( ak_default_nav_items_for_menu() as $item ) {
				$args = array( 'menu-item-title' => $item['label'], 'menu-item-status' => 'publish', 'menu-item-position' => ++$pos );
				if ( ! empty( $item['page'] ) ) {
					$args += array( 'menu-item-type' => 'post_type', 'menu-item-object' => 'page', 'menu-item-object-id' => $item['page'] );
				} elseif ( ! empty( $item['term'] ) ) {
					$args += array( 'menu-item-type' => 'taxonomy', 'menu-item-object' => 'product_cat', 'menu-item-object-id' => $item['term'] );
				} else {
					$args += array( 'menu-item-type' => 'custom', 'menu-item-url' => $item['url'] );
				}
				wp_update_nav_menu_item( $menu_id, 0, $args );
			}
			$locations['primary'] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}

	update_option( 'ak_setup_done', AK_VERSION );
	flush_rewrite_rules();
}

function ak_default_nav_items_for_menu() {
	$term = static function ( $slug ) {
		$t = taxonomy_exists( 'product_cat' ) ? get_term_by( 'slug', $slug, 'product_cat' ) : false;
		return $t ? (int) $t->term_id : 0;
	};
	$items = array(
		array( 'label' => 'Home', 'page' => ak_find_page_by_slug( 'home' ) ),
		array( 'label' => 'Reading List', 'page' => ak_find_page_by_slug( 'reading-list' ) ),
		array( 'label' => 'Bonus', 'term' => $term( 'bonus' ) ),
		array( 'label' => 'Signed Books', 'term' => $term( 'signed-books' ) ),
		array( 'label' => 'Abby Bites', 'term' => $term( 'abby-bites' ) ),
		array( 'label' => 'Content Notes', 'page' => ak_find_page_by_slug( 'content-notes' ) ),
		array( 'label' => 'About', 'page' => ak_find_page_by_slug( 'about' ) ),
	);
	return array_filter( $items, static function ( $i ) {
		return ! empty( $i['page'] ) || ! empty( $i['term'] );
	} );
}

add_action( 'after_switch_theme', 'ak_run_setup' );

/* If WooCommerce is activated after the theme, finish the category/menu setup once. */
function ak_maybe_finish_setup() {
	if ( taxonomy_exists( 'product_cat' ) && ! get_term_by( 'slug', 'signed-books', 'product_cat' ) && current_user_can( 'manage_options' ) ) {
		ak_run_setup();
	}
}
add_action( 'admin_init', 'ak_maybe_finish_setup' );

/** Admin notice if WooCommerce is missing. */
function ak_woo_notice() {
	if ( class_exists( 'WooCommerce' ) || ! current_user_can( 'install_plugins' ) ) {
		return;
	}
	printf(
		'<div class="notice notice-warning"><p><strong>%s</strong> %s <a href="%s">%s</a></p></div>',
		esc_html__( 'Abby Knox theme:', 'abbyknox' ),
		esc_html__( 'please install and activate WooCommerce to sell books.', 'abbyknox' ),
		esc_url( admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term' ) ),
		esc_html__( 'Install WooCommerce', 'abbyknox' )
	);
}
add_action( 'admin_notices', 'ak_woo_notice' );
