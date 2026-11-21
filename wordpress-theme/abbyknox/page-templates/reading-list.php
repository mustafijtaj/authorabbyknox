<?php
/**
 * Template Name: Reading List
 * Built automatically from Books → Series & Universes.
 *
 * @package AbbyKnox
 */

get_header();

/** Sorted child terms of a parent. */
function ak_rl_terms( $parent ) {
	$terms = get_terms( array( 'taxonomy' => 'book_series', 'parent' => $parent, 'hide_empty' => false ) );
	if ( is_wp_error( $terms ) ) {
		return array();
	}
	usort( $terms, static function ( $a, $b ) {
		$oa = (int) get_term_meta( $a->term_id, 'ak_order', true );
		$ob = (int) get_term_meta( $b->term_id, 'ak_order', true );
		return $oa === $ob ? strcasecmp( $a->name, $b->name ) : $oa <=> $ob;
	} );
	return $terms;
}

/** Books directly in a term, in series order. */
function ak_rl_books( $term_id ) {
	if ( ! function_exists( 'wc_get_products' ) ) {
		return array();
	}
	$books = wc_get_products( array(
		'status'    => 'publish',
		'limit'     => -1,
		'tax_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery
			array( 'taxonomy' => 'book_series', 'field' => 'term_id', 'terms' => $term_id, 'include_children' => false ),
		),
	) );
	usort( $books, static function ( $a, $b ) {
		$oa = (int) $a->get_meta( '_ak_series_order' );
		$ob = (int) $b->get_meta( '_ak_series_order' );
		return $oa === $ob ? strcasecmp( $a->get_name(), $b->get_name() ) : $oa <=> $ob;
	} );
	return $books;
}

$ak_groups = array();
$ak_total  = 0;
$ak_series = 0;
foreach ( ak_rl_terms( 0 ) as $ak_u ) {
	$ak_cards = array();
	$ak_own   = ak_rl_books( $ak_u->term_id );
	if ( $ak_own ) {
		$ak_cards[] = array( 'name' => $ak_u->name, 'note' => '', 'books' => $ak_own );
	}
	foreach ( ak_rl_terms( $ak_u->term_id ) as $ak_s ) {
		$ak_b = ak_rl_books( $ak_s->term_id );
		if ( $ak_b ) {
			$ak_cards[] = array( 'name' => $ak_s->name, 'note' => $ak_s->description, 'books' => $ak_b );
		}
	}
	if ( $ak_cards ) {
		$ak_groups[] = array( 'term' => $ak_u, 'cards' => $ak_cards );
		foreach ( $ak_cards as $ak_c ) {
			$ak_total += count( $ak_c['books'] );
		}
		$ak_series += count( $ak_cards );
	}
}

while ( have_posts() ) :
	the_post();
	?>
	<main id="main">
		<section class="page-hero">
			<div class="hero-bg" aria-hidden="true"><span class="blob b1"></span><span class="blob b2"></span></div>
			<div class="container page-hero-inner reveal">
				<p class="eyebrow"><?php the_title(); ?></p>
				<h1><?php echo wp_kses( __( 'Can’t decide what to <em>read first?</em>', 'abbyknox' ), array( 'em' => array() ) ); ?></h1>
				<?php if ( has_excerpt() ) : ?><p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
				<?php if ( $ak_total ) : ?>
					<div class="rl-stats">
						<span><strong><?php echo esc_html( $ak_total ); ?></strong> <?php esc_html_e( 'titles', 'abbyknox' ); ?></span>
						<span><strong><?php echo esc_html( count( $ak_groups ) ); ?></strong> <?php esc_html_e( 'worlds', 'abbyknox' ); ?></span>
						<span><strong><?php echo esc_html( $ak_series ); ?></strong> <?php esc_html_e( 'series & collections', 'abbyknox' ); ?></span>
					</div>
				<?php endif; ?>
			</div>
		</section>

		<section class="section rl-section">
			<div class="container">
				<?php if ( get_the_content() ) : ?><div class="entry-content narrow-text"><?php the_content(); ?></div><?php endif; ?>
				<?php if ( ! $ak_groups ) : ?>
					<p class="empty"><?php esc_html_e( 'Add books and assign them to a Series (Books → Series & Universes) and they will appear here automatically.', 'abbyknox' ); ?></p>
				<?php else : ?>
					<div class="rl-toolbar reveal">
						<label class="search">
							<span class="sr-only"><?php esc_html_e( 'Search all titles', 'abbyknox' ); ?></span>
							<?php echo ak_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
							<input type="search" id="rlSearch" placeholder="<?php esc_attr_e( 'Search every title…', 'abbyknox' ); ?>" />
						</label>
						<nav class="rl-jump" id="rlJump" aria-label="<?php esc_attr_e( 'Jump to universe', 'abbyknox' ); ?>">
							<?php foreach ( $ak_groups as $ak_g ) : ?>
								<a class="chip" href="#<?php echo esc_attr( $ak_g['term']->slug ); ?>"><?php echo esc_html( $ak_g['term']->name ); ?></a>
							<?php endforeach; ?>
						</nav>
					</div>
					<div id="rlList">
						<?php foreach ( $ak_groups as $ak_g ) : ?>
							<section class="universe reveal" id="<?php echo esc_attr( $ak_g['term']->slug ); ?>" data-universe>
								<header class="universe-head">
									<h2><?php echo esc_html( $ak_g['term']->name ); ?></h2>
									<?php if ( $ak_g['term']->description ) : ?><p><?php echo esc_html( $ak_g['term']->description ); ?></p><?php endif; ?>
								</header>
								<div class="series-cards">
									<?php foreach ( $ak_g['cards'] as $ak_c ) : ?>
										<article class="series-card" data-series>
											<h3><?php echo esc_html( $ak_c['name'] ); ?></h3>
											<?php if ( $ak_c['note'] ) : ?><p class="series-note"><?php echo esc_html( $ak_c['note'] ); ?></p><?php endif; ?>
											<ol class="title-list">
												<?php
												foreach ( $ak_c['books'] as $ak_n => $ak_p ) :
													$ak_ext   = $ak_p->is_type( 'external' );
													$ak_url   = $ak_ext && $ak_p->get_product_url() ? $ak_p->get_product_url() : $ak_p->get_permalink();
													$ak_thumb = $ak_p->get_image_id() ? wp_get_attachment_image_url( $ak_p->get_image_id(), 'thumbnail' ) : '';
													?>
													<li data-title="<?php echo esc_attr( strtolower( $ak_p->get_name() ) ); ?>">
														<a href="<?php echo esc_url( $ak_url ); ?>"<?php echo $ak_ext ? ' target="_blank" rel="noopener"' : ''; ?>>
															<?php if ( $ak_thumb ) : ?>
																<img src="<?php echo esc_url( $ak_thumb ); ?>" alt="" loading="lazy" width="36" height="54" />
															<?php else : ?>
																<span class="num"><?php echo esc_html( $ak_n + 1 ); ?></span>
															<?php endif; ?>
															<span class="t"><?php echo esc_html( $ak_p->get_name() ); ?></span>
															<span class="go" aria-hidden="true">→</span>
														</a>
													</li>
												<?php endforeach; ?>
											</ol>
										</article>
									<?php endforeach; ?>
								</div>
							</section>
						<?php endforeach; ?>
					</div>
					<p class="empty" id="rlEmpty" hidden><?php esc_html_e( 'No titles match that search — try another word.', 'abbyknox' ); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<?php ak_newsletter_section(); ?>
	</main>
	<?php
endwhile;
get_footer();
