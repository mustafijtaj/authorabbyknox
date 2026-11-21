<?php
/**
 * Template helpers.
 *
 * @package AbbyKnox
 */

defined( 'ABSPATH' ) || exit;

/** Customizer defaults (also used as fallbacks everywhere). */
function ak_defaults() {
	return array(
		'ak_hero_eyebrow'     => 'New release out now',
		'ak_hero_line1'       => 'Swoony.',
		'ak_hero_line2'       => 'Spicy.',
		'ak_hero_line3'       => 'Sweet.',
		'ak_hero_lead'        => 'Quirky, sexy, adorable and funny romance from Abby Knox — grumpy/sunshine, one-bed, boss/employee and fated mates, always with a guaranteed happily ever after.',
		'ak_hero_stat'        => '130',
		'ak_tropes'           => 'Grumpy / Sunshine, Only One Bed, Opposites Attract, Boss / Employee, Age Gap, Fated Mates, Insta-Love, Fake Dating',
		'ak_series_eyebrow'   => 'The latest from Darling Creek',
		'ak_series_heading'   => 'Runaway Brides & Heroes',
		'ak_series_text'      => 'Brides who bolt. Heroes who catch them. Six small-town romances with cowboys, farmers, mountain men and protectors who fall hard and fast.',
		'ak_series_slugs'     => 'the-runaway-brides-of-darling-creek, the-heroes-of-darling-creek',
		'ak_about_short'      => 'I write upbeat romance with plenty of heat. Readers call my books quirky, sexy, adorable and funny — and I’ll take all four.',
		'ak_newsletter_url'   => 'http://eepurl.com/c7pNu5',
		'ak_newsletter_title' => 'Get the swoon straight to your inbox.',
		'ak_newsletter_text'  => 'Free books, bonus material and the latest book news — first. No spam, unsubscribe any time.',
		'ak_email'            => 'authorabbyknox@gmail.com',
		'ak_footer_tagline'   => 'Swoony, spicy, sweet romance.',
		'ak_facebook'         => 'https://www.facebook.com/abbyknoxauthor/',
		'ak_instagram'        => 'https://www.instagram.com/author_abby_knox/',
		'ak_threads'          => 'https://www.threads.net/@author_abby_knox',
		'ak_goodreads'        => 'https://www.goodreads.com/AuthorAbbyKnox',
		'ak_bookbub'          => 'https://www.bookbub.com/profile/abby-knox',
		'ak_books2read'       => 'https://www.books2read.com/abbyknox',
	);
}

/** Theme option with default. */
function ak_opt( $key ) {
	$defaults = ak_defaults();
	return get_theme_mod( $key, $defaults[ $key ] ?? '' );
}

/** Permalink of the first page using a given page template (falls back to home). */
function ak_page_url( $template ) {
	static $cache = array();
	if ( isset( $cache[ $template ] ) ) {
		return $cache[ $template ];
	}
	$pages = get_posts( array(
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'meta_key'       => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery
		'meta_value'     => 'page-templates/' . $template . '.php', // phpcs:ignore WordPress.DB.SlowDBQuery
		'posts_per_page' => 1,
		'fields'         => 'ids',
	) );
	$cache[ $template ] = $pages ? get_permalink( $pages[0] ) : home_url( '/' );
	return $cache[ $template ];
}

/** Product category archive URL by slug. */
function ak_cat_url( $slug ) {
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		return home_url( '/' );
	}
	$term = get_term_by( 'slug', $slug, 'product_cat' );
	if ( ! $term ) {
		return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
	}
	$link = get_term_link( $term );
	return is_wp_error( $link ) ? home_url( '/' ) : $link;
}

/** Default navigation (used when no menu is assigned). */
function ak_default_nav_items() {
	return array(
		array( 'label' => __( 'Home', 'abbyknox' ), 'url' => home_url( '/' ) ),
		array( 'label' => __( 'Reading List', 'abbyknox' ), 'url' => ak_page_url( 'reading-list' ) ),
		array( 'label' => __( 'Bonus', 'abbyknox' ), 'url' => ak_cat_url( 'bonus' ) ),
		array( 'label' => __( 'Signed Books', 'abbyknox' ), 'url' => ak_cat_url( 'signed-books' ) ),
		array( 'label' => __( 'Abby Bites', 'abbyknox' ), 'url' => ak_cat_url( 'abby-bites' ) ),
		array( 'label' => __( 'Content Notes', 'abbyknox' ), 'url' => ak_page_url( 'content-notes' ) ),
		array( 'label' => __( 'About', 'abbyknox' ), 'url' => ak_page_url( 'about' ) ),
	);
}

/** Inline SVG icons (stroke style). */
function ak_icon( $name ) {
	$paths = array(
		'facebook'  => '<path d="M14 8h3V4h-3a4 4 0 0 0-4 4v2H8v4h2v8h4v-8h3l1-4h-4V8z"/>',
		'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".8"/>',
		'threads'   => '<path d="M16.5 11.2c-.4-2.6-2.2-3.7-4.4-3.7-2 0-3.4 1-4 2.4M12 21c-5 0-8-3.3-8-9s3-9 8-9c4.3 0 7 2.4 7.8 6.3M9 14.8c0 1.4 1.3 2.4 3 2.3 2.4-.1 3.7-1.9 3.7-5-3-.6-6.7-.3-6.7 2.7z"/>',
		'goodreads' => '<path d="M16 4v11a5 5 0 0 1-9 3M16 9.5a4 4 0 1 1-8 0 4 4 0 0 1 8 0z"/>',
		'bookbub'   => '<path d="M4 4h7a4 4 0 0 1 0 8H4zM4 12h8a4 4 0 0 1 0 8H4z"/>',
		'cart'      => '<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.7 13.4a2 2 0 0 0 2 1.6h9.7a2 2 0 0 0 2-1.6L23 6H6"/>',
		'user'      => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
		'search'    => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
		'gift'      => '<path d="M20 12v9H4v-9M2 7h20v5H2zM12 22V7M12 7H7.5a2.5 2.5 0 1 1 0-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 1 0 0-5C13 2 12 7 12 7z"/>',
		'pen'       => '<path d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>',
		'cup'       => '<path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4zM6 1v3M10 1v3M14 1v3"/>',
		'shield'    => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
		'mail'      => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/>',
		'book'      => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V3H6.5A2.5 2.5 0 0 0 4 5.5z"/><path d="M4 19.5A2.5 2.5 0 0 0 6.5 22H20v-5"/>',
		'pulse'     => '<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>',
		'alert'     => '<path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0zM12 9v4M12 17h.01"/>',
		'download'  => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>',
	);
	return '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">' . ( $paths[ $name ] ?? '' ) . '</svg>';
}

/** Social links list. */
function ak_social_links() {
	$networks = array(
		'facebook'  => 'Facebook',
		'instagram' => 'Instagram',
		'threads'   => 'Threads',
		'goodreads' => 'Goodreads',
		'bookbub'   => 'BookBub',
	);
	echo '<ul class="socials">';
	foreach ( $networks as $key => $label ) {
		$url = ak_opt( 'ak_' . $key );
		if ( $url ) {
			printf( '<li><a href="%1$s" target="_blank" rel="noopener" aria-label="%2$s">%3$s</a></li>', esc_url( $url ), esc_attr( $label ), ak_icon( $key ) ); // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG.
		}
	}
	echo '</ul>';
}

/* -------------------------------------------------------------------------
 * Product / book helpers
 * ---------------------------------------------------------------------- */

/** Categories that are not "books" for the home page lists. */
function ak_non_listing_cats() {
	return array( 'signed-books', 'bonus' );
}

/** Book subtitle meta. */
function ak_subtitle( $product_id ) {
	return (string) get_post_meta( $product_id, '_ak_subtitle', true );
}

/** Cover image URL for a product (or empty). */
function ak_cover_url( $product, $size = 'ak-cover' ) {
	$id = $product->get_image_id();
	return $id ? wp_get_attachment_image_url( $id, $size ) : '';
}

/** Short label telling the reader where the buy button goes. */
function ak_store_label( $product ) {
	if ( $product->is_type( 'external' ) ) {
		$url = $product->get_product_url();
		if ( false !== stripos( $url, 'amazon' ) || false !== stripos( $url, 'alsoby.me' ) ) {
			return __( 'Amazon', 'abbyknox' );
		}
		if ( false !== stripos( $url, 'bookhip' ) || false !== stripos( $url, 'bookfunnel' ) ) {
			return __( 'Free download', 'abbyknox' );
		}
		return __( 'All stores', 'abbyknox' );
	}
	if ( $product->is_downloadable() ) {
		return __( 'Ebook · Buy direct', 'abbyknox' );
	}
	return __( 'Signed paperback', 'abbyknox' );
}

/** URL a book card should open: retailer for listings, product page for direct sales. */
function ak_card_url( $product ) {
	return $product->is_type( 'external' ) && $product->get_product_url() ? $product->get_product_url() : $product->get_permalink();
}

/** Universe slugs (top-level series) of a product, for client-side filters. */
function ak_product_filter_tags( $product ) {
	$tags  = array();
	$terms = get_the_terms( $product->get_id(), 'book_series' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $t ) {
			$tags[] = $t->slug;
			foreach ( get_ancestors( $t->term_id, 'book_series' ) as $anc ) {
				$a = get_term( $anc, 'book_series' );
				if ( $a && ! is_wp_error( $a ) ) {
					$tags[] = $a->slug;
				}
			}
		}
	}
	foreach ( (array) $product->get_category_ids() as $cid ) {
		$c = get_term( $cid, 'product_cat' );
		if ( $c && ! is_wp_error( $c ) ) {
			$tags[] = 'cat-' . $c->slug;
		}
	}
	return array_unique( $tags );
}

/**
 * Renders the design's book card.
 *
 * @param WC_Product $product Product.
 * @param int        $i       Index (for staggered animation).
 * @param string     $extra   Extra HTML placed under the cover.
 */
function ak_book_card( $product, $i = 0, $extra = '' ) {
	$external = $product->is_type( 'external' );
	$url      = ak_card_url( $product );
	$cover    = ak_cover_url( $product );
	$title    = $product->get_name();
	$sub      = ak_subtitle( $product->get_id() );
	$price    = $product->get_price_html();
	$cta      = $external ? ( $product->get_button_text() ? $product->get_button_text() : __( 'Buy now', 'abbyknox' ) ) : __( 'View & buy', 'abbyknox' );
	$haystack = strtolower( $title . ' ' . $sub );
	?>
	<a class="book-card" href="<?php echo esc_url( $url ); ?>"<?php echo $external ? ' target="_blank" rel="noopener"' : ''; ?>
		data-tags="<?php echo esc_attr( implode( ' ', ak_product_filter_tags( $product ) ) ); ?>"
		data-search="<?php echo esc_attr( $haystack ); ?>"
		aria-label="<?php echo esc_attr( $title . ( $sub ? ': ' . $sub : '' ) . ' — ' . $cta ); ?>"
		style="animation-delay:<?php echo (int) min( $i, 12 ) * 35; ?>ms">
		<div class="cover">
			<?php if ( $cover ) : ?>
				<img src="<?php echo esc_url( $cover ); ?>" alt="<?php echo esc_attr( sprintf( /* translators: %s book title */ __( '%s book cover', 'abbyknox' ), $title ) ); ?>" loading="lazy" width="300" height="450" />
			<?php else : ?>
				<span class="cover-fallback"><span><?php echo esc_html( $title ); ?></span></span>
			<?php endif; ?>
			<span class="buy"><?php echo esc_html( $cta ); ?></span>
		</div>
		<?php echo $extra; // phpcs:ignore WordPress.Security.EscapeOutput -- built from escaped parts by callers. ?>
		<h3><?php echo esc_html( $title ); ?></h3>
		<?php if ( $sub ) : ?><p class="sub"><?php echo esc_html( $sub ); ?></p><?php endif; ?>
		<span class="store"><?php echo esc_html( ak_store_label( $product ) ); ?><?php if ( $price && ! $external ) : ?> · <span class="card-price"><?php echo wp_kses_post( $price ); ?></span><?php endif; ?></span>
	</a>
	<?php
}

/** Query listing books (newest first, with covers). */
function ak_listing_products( $limit = 10, $extra_args = array() ) {
	if ( ! function_exists( 'wc_get_products' ) ) {
		return array();
	}
	$args = array_merge( array(
		'status'     => 'publish',
		'limit'      => $limit,
		'orderby'    => array( 'date' => 'DESC', 'ID' => 'DESC' ),
		'visibility' => 'catalog',
		'tax_query'  => array( // phpcs:ignore WordPress.DB.SlowDBQuery
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => ak_non_listing_cats(),
				'operator' => 'NOT IN',
			),
		),
	), $extra_args );
	$products = wc_get_products( $args );
	return array_values( array_filter( $products, static function ( $p ) {
		return (bool) $p->get_image_id();
	} ) );
}

/** Page hero markup used by inner pages. */
function ak_page_hero( $eyebrow, $title_html, $lead = '', $class = '' ) {
	?>
	<section class="page-hero <?php echo esc_attr( $class ); ?>">
		<div class="hero-bg<?php echo false !== strpos( $class, 'dark' ) ? ' dark' : ''; ?>" aria-hidden="true"><span class="blob b1"></span><span class="blob b2"></span></div>
		<div class="container page-hero-inner reveal">
			<?php if ( $eyebrow ) : ?><p class="eyebrow<?php echo false !== strpos( $class, 'dark' ) ? ' light' : ''; ?>"><?php echo esc_html( $eyebrow ); ?></p><?php endif; ?>
			<h1><?php echo wp_kses( $title_html, array( 'em' => array(), 'span' => array( 'class' => array() ) ) ); ?></h1>
			<?php if ( $lead ) : ?><div class="lead"><?php echo wp_kses_post( wpautop( $lead ) ); ?></div><?php endif; ?>
		</div>
	</section>
	<?php
}

/** Turns "Big *Words*" into "Big <em>Words</em>" for styled headings. */
function ak_em( $text ) {
	return preg_replace( '/\*(.+?)\*/', '<em>$1</em>', esc_html( $text ) );
}

/** Newsletter section. */
function ak_newsletter_section() {
	get_template_part( 'template-parts/newsletter' );
}
