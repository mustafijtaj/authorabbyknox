<?php
/**
 * Homepage. Books come from WooCommerce; text from Appearance → Customize → Abby Knox site settings.
 *
 * @package AbbyKnox
 */

get_header();

$ak_latest   = ak_listing_products( 10 );
$ak_hero     = array_slice( $ak_latest, 0, 3 );
$ak_featured = function_exists( 'wc_get_products' ) ? wc_get_products( array( 'status' => 'publish', 'featured' => true, 'limit' => 1, 'orderby' => 'date', 'order' => 'DESC' ) ) : array();
$ak_spot     = $ak_featured ? $ak_featured[0] : ( $ak_latest ? $ak_latest[0] : null );
$ak_tropes   = array_filter( array_map( 'trim', explode( ',', ak_opt( 'ak_tropes' ) ) ) );
?>
<main id="main">
	<!-- HERO -->
	<section class="hero">
		<div class="hero-bg" aria-hidden="true"><span class="blob b1"></span><span class="blob b2"></span><span class="blob b3"></span></div>
		<div class="container hero-grid">
			<div class="hero-copy reveal">
				<?php if ( ak_opt( 'ak_hero_eyebrow' ) ) : ?>
					<p class="eyebrow"><span class="dot"></span> <?php echo esc_html( ak_opt( 'ak_hero_eyebrow' ) ); ?></p>
				<?php endif; ?>
				<h1><?php echo esc_html( ak_opt( 'ak_hero_line1' ) ); ?> <em><?php echo esc_html( ak_opt( 'ak_hero_line2' ) ); ?></em> <span class="script"><?php echo esc_html( ak_opt( 'ak_hero_line3' ) ); ?></span></h1>
				<p class="lead"><?php echo esc_html( ak_opt( 'ak_hero_lead' ) ); ?></p>
				<div class="hero-actions">
					<a href="#latest" class="btn btn-primary"><?php esc_html_e( 'Browse the Latest', 'abbyknox' ); ?></a>
					<a href="<?php echo esc_url( ak_page_url( 'reading-list' ) ); ?>" class="btn btn-ghost"><?php esc_html_e( 'Complete Reading List', 'abbyknox' ); ?></a>
				</div>
				<ul class="hero-stats">
					<li><strong><span data-count="<?php echo esc_attr( (int) ak_opt( 'ak_hero_stat' ) ); ?>"><?php echo esc_html( (int) ak_opt( 'ak_hero_stat' ) ); ?></span>+</strong><span><?php esc_html_e( 'romances', 'abbyknox' ); ?></span></li>
					<li><strong>100%</strong><span><?php esc_html_e( 'HEA guaranteed', 'abbyknox' ); ?></span></li>
					<li><strong><?php esc_html_e( 'Hot', 'abbyknox' ); ?></strong><span><?php esc_html_e( 'plenty of heat', 'abbyknox' ); ?></span></li>
				</ul>
			</div>
			<?php if ( count( $ak_hero ) === 3 ) : ?>
				<div class="hero-books reveal" aria-label="<?php esc_attr_e( 'Featured new releases', 'abbyknox' ); ?>">
					<?php
					// Order on screen: left (2nd newest), right (3rd), centre (newest).
					$ak_fan = array( 'fan-1' => $ak_hero[1], 'fan-3' => $ak_hero[2], 'fan-2' => $ak_hero[0] );
					foreach ( $ak_fan as $ak_class => $ak_p ) :
						$ak_ext = $ak_p->is_type( 'external' );
						?>
						<a class="fan <?php echo esc_attr( $ak_class ); ?>" href="<?php echo esc_url( ak_card_url( $ak_p ) ); ?>"<?php echo $ak_ext ? ' target="_blank" rel="noopener"' : ''; ?>>
							<img src="<?php echo esc_url( ak_cover_url( $ak_p ) ); ?>" alt="<?php echo esc_attr( $ak_p->get_name() ); ?>" width="300" height="450" <?php echo 'fan-2' === $ak_class ? 'fetchpriority="high"' : ''; ?> />
							<?php if ( 'fan-2' === $ak_class ) : ?><span class="badge-new"><?php esc_html_e( 'New!', 'abbyknox' ); ?></span><?php endif; ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( $ak_tropes ) : ?>
		<!-- TROPES -->
		<div class="marquee-wrap"><div class="marquee" aria-label="<?php esc_attr_e( 'Favourite tropes', 'abbyknox' ); ?>">
			<div class="marquee-track">
				<?php foreach ( array( false, true ) as $ak_dup ) : ?>
					<?php foreach ( $ak_tropes as $ak_trope ) : ?>
						<span<?php echo $ak_dup ? ' aria-hidden="true"' : ''; ?>><?php echo esc_html( $ak_trope ); ?></span><i aria-hidden="true">♥</i>
					<?php endforeach; ?>
				<?php endforeach; ?>
			</div>
		</div></div>
	<?php endif; ?>

	<?php if ( $ak_spot ) : ?>
		<!-- SPOTLIGHT (WooCommerce "featured" ★ book, else newest) -->
		<section class="section featured" aria-labelledby="featTitle">
			<div class="container featured-grid">
				<div class="featured-cover reveal">
					<img src="<?php echo esc_url( ak_cover_url( $ak_spot, 'large' ) ); ?>" alt="<?php echo esc_attr( $ak_spot->get_name() ); ?>" loading="lazy" width="400" height="600" />
				</div>
				<div class="featured-copy reveal">
					<p class="eyebrow"><?php esc_html_e( 'Spotlight', 'abbyknox' ); ?></p>
					<h2 id="featTitle"><?php echo esc_html( $ak_spot->get_name() ); ?><?php if ( ak_subtitle( $ak_spot->get_id() ) ) : ?>: <em><?php echo esc_html( ak_subtitle( $ak_spot->get_id() ) ); ?></em><?php endif; ?></h2>
					<?php if ( $ak_spot->get_short_description() ) : ?>
						<div class="featured-desc"><?php echo wp_kses_post( wpautop( $ak_spot->get_short_description() ) ); ?></div>
					<?php endif; ?>
					<?php $ak_tags = wc_get_product_terms( $ak_spot->get_id(), 'product_tag', array( 'fields' => 'names' ) ); ?>
					<?php if ( $ak_tags ) : ?>
						<ul class="tags"><?php foreach ( $ak_tags as $ak_t ) : ?><li><?php echo esc_html( $ak_t ); ?></li><?php endforeach; ?></ul>
					<?php endif; ?>
					<div class="hero-actions">
						<a href="<?php echo esc_url( ak_card_url( $ak_spot ) ); ?>" class="btn btn-primary"<?php echo $ak_spot->is_type( 'external' ) ? ' target="_blank" rel="noopener"' : ''; ?>><?php esc_html_e( 'Get Your Copy', 'abbyknox' ); ?></a>
						<a href="<?php echo esc_url( $ak_spot->get_permalink() ); ?>" class="btn btn-ghost"><?php esc_html_e( 'Read more', 'abbyknox' ); ?></a>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $ak_latest ) : ?>
		<!-- LATEST -->
		<section class="section" id="latest" aria-labelledby="latestTitle">
			<div class="container">
				<div class="section-head reveal">
					<p class="eyebrow"><?php esc_html_e( 'Fresh off the press', 'abbyknox' ); ?></p>
					<h2 id="latestTitle"><?php esc_html_e( 'Latest Releases', 'abbyknox' ); ?></h2>
					<p class="section-sub"><?php esc_html_e( 'The newest swoon-worthy reads. Tap any cover to grab it from your favourite store.', 'abbyknox' ); ?></p>
				</div>
				<div class="carousel reveal">
					<button class="car-btn prev" aria-label="<?php esc_attr_e( 'Scroll left', 'abbyknox' ); ?>" data-dir="-1">‹</button>
					<div class="book-row" id="latestRow">
						<?php foreach ( $ak_latest as $ak_i => $ak_p ) { ak_book_card( $ak_p, $ak_i ); } ?>
					</div>
					<button class="car-btn next" aria-label="<?php esc_attr_e( 'Scroll right', 'abbyknox' ); ?>" data-dir="1">›</button>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php
	// SERIES SPOTLIGHT.
	$ak_series_slugs = array_filter( array_map( 'trim', explode( ',', ak_opt( 'ak_series_slugs' ) ) ) );
	$ak_series_books = array();
	if ( $ak_series_slugs && function_exists( 'wc_get_products' ) ) {
		foreach ( $ak_series_slugs as $ak_slug ) {
			$ak_ps = wc_get_products( array(
				'status'    => 'publish',
				'limit'     => 12,
				'tax_query' => array( array( 'taxonomy' => 'book_series', 'field' => 'slug', 'terms' => $ak_slug ) ), // phpcs:ignore WordPress.DB.SlowDBQuery
			) );
			usort( $ak_ps, static function ( $a, $b ) {
				return (int) $a->get_meta( '_ak_series_order' ) <=> (int) $b->get_meta( '_ak_series_order' );
			} );
			$ak_series_books = array_merge( $ak_series_books, $ak_ps );
		}
	}
	if ( $ak_series_books ) :
		?>
		<section class="section series" id="series" aria-labelledby="dcTitle">
			<div class="container">
				<div class="series-head reveal">
					<div>
						<p class="eyebrow light"><?php echo esc_html( ak_opt( 'ak_series_eyebrow' ) ); ?></p>
						<h2 id="dcTitle"><?php echo wp_kses( str_replace( '&amp;', '<span class="amp">&amp;</span>', esc_html( ak_opt( 'ak_series_heading' ) ) ), array( 'span' => array( 'class' => array() ) ) ); ?></h2>
					</div>
					<p class="series-copy"><?php echo esc_html( ak_opt( 'ak_series_text' ) ); ?></p>
				</div>
				<ol class="series-grid">
					<?php foreach ( $ak_series_books as $ak_i => $ak_p ) : ?>
						<li class="reveal"><?php ak_book_card( $ak_p, $ak_i, '<span class="num">' . esc_html( sprintf( /* translators: %d book number */ __( 'Book %d', 'abbyknox' ), $ak_i + 1 ) ) . '</span>' ); ?></li>
					<?php endforeach; ?>
				</ol>
			</div>
		</section>
	<?php endif; ?>

	<?php
	// LIBRARY (all listing books with covers), filter chips by universe.
	$ak_library = ak_listing_products( 60 );
	if ( $ak_library ) :
		$ak_universes = get_terms( array( 'taxonomy' => 'book_series', 'parent' => 0, 'hide_empty' => true ) );
		$ak_used      = array();
		foreach ( $ak_library as $ak_p ) {
			$ak_used = array_merge( $ak_used, ak_product_filter_tags( $ak_p ) );
		}
		?>
		<section class="section" id="library" aria-labelledby="libTitle">
			<div class="container">
				<div class="section-head reveal">
					<p class="eyebrow"><?php esc_html_e( 'Browse the books', 'abbyknox' ); ?></p>
					<h2 id="libTitle"><?php esc_html_e( 'Find Your Next Swoon', 'abbyknox' ); ?></h2>
					<p class="section-sub"><?php esc_html_e( 'Filter by world or search by title.', 'abbyknox' ); ?></p>
				</div>
				<div class="lib-tools reveal">
					<div class="filters" role="tablist" aria-label="<?php esc_attr_e( 'Filter books', 'abbyknox' ); ?>" data-filter-for="bookGrid">
						<button class="chip active" data-filter="all" role="tab" aria-selected="true"><?php esc_html_e( 'All', 'abbyknox' ); ?></button>
						<?php
						if ( ! is_wp_error( $ak_universes ) ) :
							foreach ( $ak_universes as $ak_u ) :
								if ( ! in_array( $ak_u->slug, $ak_used, true ) ) {
									continue;
								}
								?>
								<button class="chip" data-filter="<?php echo esc_attr( $ak_u->slug ); ?>" role="tab" aria-selected="false"><?php echo esc_html( $ak_u->name ); ?></button>
								<?php
							endforeach;
						endif;
						?>
					</div>
					<label class="search">
						<span class="sr-only"><?php esc_html_e( 'Search titles', 'abbyknox' ); ?></span>
						<?php echo ak_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
						<input type="search" id="search" data-search-for="bookGrid" placeholder="<?php esc_attr_e( 'Search titles…', 'abbyknox' ); ?>" />
					</label>
				</div>
				<div class="book-grid" id="bookGrid">
					<?php foreach ( $ak_library as $ak_i => $ak_p ) { ak_book_card( $ak_p, $ak_i ); } ?>
				</div>
				<p class="empty" id="bookGridEmpty" hidden><?php esc_html_e( 'No books match that search — try another word.', 'abbyknox' ); ?></p>
				<div class="center-cta reveal"><a href="<?php echo esc_url( ak_page_url( 'reading-list' ) ); ?>" class="btn btn-ghost"><?php esc_html_e( 'See every title in the Complete Reading List', 'abbyknox' ); ?></a></div>
			</div>
		</section>
	<?php endif; ?>

	<!-- EXTRAS -->
	<section class="section extras" id="extras" aria-labelledby="extrasTitle">
		<div class="container">
			<div class="section-head reveal">
				<p class="eyebrow"><?php esc_html_e( 'For superfans', 'abbyknox' ); ?></p>
				<h2 id="extrasTitle"><?php esc_html_e( 'Extras & Goodies', 'abbyknox' ); ?></h2>
			</div>
			<div class="extra-grid">
				<?php
				$ak_extras = array(
					array( 'gift', __( 'Bonus Content', 'abbyknox' ), __( 'Bonus scenes, bonus epilogues and a free book — free for readers.', 'abbyknox' ), ak_cat_url( 'bonus' ), __( 'Unlock bonuses', 'abbyknox' ) ),
					array( 'pen', __( 'Signed Books', 'abbyknox' ), __( 'Signed paperbacks, bundles and mystery packs, shipped by Abby.', 'abbyknox' ), ak_cat_url( 'signed-books' ), __( 'Order signed', 'abbyknox' ) ),
					array( 'cup', __( 'Abby Bites', 'abbyknox' ), __( 'Monster and paranormal reads you can buy direct and download instantly.', 'abbyknox' ), ak_cat_url( 'abby-bites' ), __( 'Take a bite', 'abbyknox' ) ),
					array( 'shield', __( 'Content Notes', 'abbyknox' ), __( 'Read with confidence. Check content notes before you dive in.', 'abbyknox' ), ak_page_url( 'content-notes' ), __( 'View notes', 'abbyknox' ) ),
				);
				foreach ( $ak_extras as $ak_x ) :
					?>
					<article class="extra-card reveal">
						<div class="extra-icon"><?php echo ak_icon( $ak_x[0] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
						<h3><?php echo esc_html( $ak_x[1] ); ?></h3>
						<p><?php echo esc_html( $ak_x[2] ); ?></p>
						<a href="<?php echo esc_url( $ak_x[3] ); ?>" class="link-arrow"><?php echo esc_html( $ak_x[4] ); ?></a>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- ABOUT TEASER -->
	<section class="section about" id="about" aria-labelledby="aboutTitle">
		<div class="container about-grid">
			<div class="about-visual reveal">
				<div class="polaroid">
					<?php
					$ak_about_page = get_page_by_path( 'about' );
					$ak_about_id   = $ak_about_page ? (int) $ak_about_page->ID : 0;
					if ( $ak_about_id && has_post_thumbnail( $ak_about_id ) ) {
						echo get_the_post_thumbnail( $ak_about_id, 'large', array( 'loading' => 'lazy' ) );
					} else {
						echo '<span class="polaroid-fallback">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
					}
					?>
					<span class="caption"><?php esc_html_e( 'xo, Abby', 'abbyknox' ); ?></span>
				</div>
			</div>
			<div class="about-copy reveal">
				<p class="eyebrow"><?php esc_html_e( 'Meet the author', 'abbyknox' ); ?></p>
				<h2 id="aboutTitle"><?php esc_html_e( 'Hi, I’m', 'abbyknox' ); ?> <em><?php bloginfo( 'name' ); ?>.</em></h2>
				<p><?php echo esc_html( ak_opt( 'ak_about_short' ) ); ?></p>
				<div class="hero-actions">
					<a href="<?php echo esc_url( ak_page_url( 'about' ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'More About Abby', 'abbyknox' ); ?></a>
					<?php if ( ak_opt( 'ak_email' ) ) : ?>
						<a href="mailto:<?php echo esc_attr( antispambot( ak_opt( 'ak_email' ) ) ); ?>" class="btn btn-ghost"><?php esc_html_e( 'Say Hello', 'abbyknox' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<?php ak_newsletter_section(); ?>
</main>
<?php
get_footer();
