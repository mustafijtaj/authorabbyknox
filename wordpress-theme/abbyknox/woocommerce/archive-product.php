<?php
/**
 * Shop, book categories (Signed Books, Abby Bites, Bonus…) and series archives.
 * Overrides woocommerce/templates/archive-product.php.
 *
 * @package AbbyKnox
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$ak_term = ( is_product_category() || is_tax( 'book_series' ) || is_product_tag() ) ? get_queried_object() : null;
$ak_slug = $ak_term ? $ak_term->slug : 'shop';

$ak_heroes = array(
	'signed-books' => array( __( 'Straight from Abby’s desk', 'abbyknox' ), 'Signed *Books*', '' ),
	'abby-bites'   => array( __( 'Welcome to', 'abbyknox' ), 'Abby *Bites*', 'dark bites-hero' ),
	'bonus'        => array( __( 'Free for readers', 'abbyknox' ), 'Bonus Epilogues *& Stories*', '' ),
	'ebooks'       => array( __( 'Buy direct', 'abbyknox' ), 'Ebooks *from Abby*', '' ),
	'shop'         => array( __( 'The bookshop', 'abbyknox' ), 'All *Books*', '' ),
);
if ( isset( $ak_heroes[ $ak_slug ] ) ) {
	list( $ak_eyebrow, $ak_title, $ak_class ) = $ak_heroes[ $ak_slug ];
} else {
	$ak_eyebrow = is_tax( 'book_series' ) ? __( 'Series', 'abbyknox' ) : __( 'Books', 'abbyknox' );
	$ak_title   = $ak_term ? $ak_term->name : woocommerce_page_title( false );
	$ak_class   = '';
}
$ak_lead = $ak_term ? $ak_term->description : '';
?>
<main id="main">
	<?php ak_page_hero( $ak_eyebrow, ak_em( $ak_title ), $ak_lead, $ak_class ); ?>

	<?php if ( 'abby-bites' === $ak_slug ) : ?>
		<div class="steps-band">
			<ol class="steps">
				<li><span>1</span><?php esc_html_e( 'Choose your read', 'abbyknox' ); ?></li>
				<li><span>2</span><?php esc_html_e( 'Pay securely with PayPal', 'abbyknox' ); ?></li>
				<li><span>3</span><?php esc_html_e( 'Download instantly', 'abbyknox' ); ?></li>
			</ol>
		</div>
	<?php endif; ?>

	<section class="section woo-section">
		<div class="container">
			<?php woocommerce_output_all_notices(); ?>

			<?php if ( ! woocommerce_product_loop() ) : ?>
				<?php do_action( 'woocommerce_no_products_found' ); ?>

			<?php elseif ( 'abby-bites' === $ak_slug ) : ?>
				<div class="bites-list">
					<?php
					$ak_n = 0;
					while ( have_posts() ) :
						the_post();
						global $product;
						$ak_tags = wc_get_product_terms( $product->get_id(), 'product_tag', array( 'fields' => 'names' ) );
						?>
						<article class="bite<?php echo ( $ak_n++ % 2 ) ? ' reverse' : ''; ?> reveal">
							<a class="bite-cover" href="<?php the_permalink(); ?>"><?php echo $product->get_image( 'ak-cover', array( 'loading' => 'lazy' ) ); // phpcs:ignore ?></a>
							<div class="bite-body">
								<?php if ( $ak_tags ) : ?><ul class="tags"><?php foreach ( $ak_tags as $ak_t ) : ?><li><?php echo esc_html( $ak_t ); ?></li><?php endforeach; ?></ul><?php endif; ?>
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<?php if ( ak_subtitle( $product->get_id() ) ) : ?><p class="book-subtitle"><?php echo esc_html( ak_subtitle( $product->get_id() ) ); ?></p><?php endif; ?>
								<div class="bite-desc"><?php echo wp_kses_post( wpautop( $product->get_short_description() ) ); ?></div>
								<div class="buy-row">
									<?php if ( $product->get_price_html() ) : ?><span class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span><?php endif; ?>
									<?php woocommerce_template_loop_add_to_cart(); ?>
								</div>
							</div>
						</article>
					<?php endwhile; ?>
					<p class="happy reveal"><?php esc_html_e( 'Happy reading!', 'abbyknox' ); ?> <span>♥</span></p>
				</div>

			<?php elseif ( 'signed-books' === $ak_slug ) : ?>
				<div class="shop-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						global $product;
						$ak_tags = wc_get_product_terms( $product->get_id(), 'product_tag', array( 'fields' => 'names' ) );
						?>
						<article class="shop-card reveal">
							<a class="product-img" href="<?php the_permalink(); ?>">
								<?php echo $product->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy' ) ); // phpcs:ignore ?>
								<?php if ( $product->is_on_sale() ) : ?>
									<span class="pill hot"><?php esc_html_e( 'Sale', 'abbyknox' ); ?></span>
								<?php elseif ( ! $product->is_in_stock() ) : ?>
									<span class="pill"><?php esc_html_e( 'Sold out', 'abbyknox' ); ?></span>
								<?php elseif ( $ak_tags ) : ?>
									<span class="pill"><?php echo esc_html( $ak_tags[0] ); ?></span>
								<?php endif; ?>
							</a>
							<div class="product-body">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="product-desc"><?php echo wp_kses_post( wp_trim_words( $product->get_short_description(), 28 ) ); ?></div>
								<div class="product-foot">
									<span class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
									<?php woocommerce_template_loop_add_to_cart(); ?>
								</div>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
				<?php if ( ak_opt( 'ak_email' ) ) : ?>
					<p class="shop-note reveal"><?php esc_html_e( 'Questions about an order or a personalised inscription? Email', 'abbyknox' ); ?> <a href="mailto:<?php echo esc_attr( antispambot( ak_opt( 'ak_email' ) ) ); ?>"><?php echo esc_html( antispambot( ak_opt( 'ak_email' ) ) ); ?></a>.</p>
				<?php endif; ?>

			<?php elseif ( 'bonus' === $ak_slug ) : ?>
				<?php
				$ak_free  = array();
				$ak_bonus = array();
				while ( have_posts() ) {
					the_post();
					global $product;
					if ( has_term( 'free-book', 'product_tag', $product->get_id() ) ) {
						$ak_free[] = $product;
					} else {
						$ak_bonus[] = $product;
					}
				}
				?>
				<?php if ( $ak_bonus ) : ?>
					<div class="bonus-grid">
						<?php
						foreach ( $ak_bonus as $ak_p ) :
							$ak_url  = ak_card_url( $ak_p );
							$ak_ext  = $ak_p->is_type( 'external' );
							$ak_tags = wc_get_product_terms( $ak_p->get_id(), 'product_tag', array( 'fields' => 'names' ) );
							?>
							<a class="bonus-card reveal" href="<?php echo esc_url( $ak_url ); ?>"<?php echo $ak_ext ? ' target="_blank" rel="noopener"' : ''; ?>>
								<div class="bonus-img"><?php echo $ak_p->get_image( 'ak-cover', array( 'loading' => 'lazy' ) ); // phpcs:ignore ?></div>
								<div class="bonus-body">
									<span class="pill"><?php echo esc_html( $ak_tags ? $ak_tags[0] : __( 'Bonus', 'abbyknox' ) ); ?></span>
									<h3><?php echo esc_html( $ak_p->get_name() ); ?></h3>
									<div class="bonus-desc"><?php echo wp_kses_post( wpautop( $ak_p->get_short_description() ) ); ?></div>
									<span class="link-arrow"><?php echo esc_html( $ak_ext && $ak_p->get_button_text() ? $ak_p->get_button_text() : __( 'Get it free', 'abbyknox' ) ); ?></span>
								</div>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<?php foreach ( $ak_free as $ak_p ) : ?>
					<div class="free-book-band reveal">
						<div class="free-grid">
							<div class="free-cover"><?php echo $ak_p->get_image( 'ak-cover', array( 'loading' => 'lazy' ) ); // phpcs:ignore ?><span class="free-badge"><?php esc_html_e( 'Free', 'abbyknox' ); ?></span></div>
							<div class="free-copy">
								<p class="eyebrow light"><?php esc_html_e( 'Free book!', 'abbyknox' ); ?></p>
								<h2><?php echo esc_html( $ak_p->get_name() ); ?></h2>
								<div><?php echo wp_kses_post( wpautop( $ak_p->get_short_description() ) ); ?></div>
								<div class="hero-actions">
									<a href="<?php echo esc_url( ak_card_url( $ak_p ) ); ?>"<?php echo $ak_p->is_type( 'external' ) ? ' target="_blank" rel="noopener"' : ''; ?> class="btn btn-light"><?php esc_html_e( 'Download Free', 'abbyknox' ); ?></a>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>

			<?php else : ?>
				<div class="shop-toolbar"><?php do_action( 'woocommerce_before_shop_loop' ); ?></div>
				<div class="book-grid">
					<?php
					$ak_i = 0;
					while ( have_posts() ) :
						the_post();
						global $product;
						ak_book_card( $product, $ak_i++ );
					endwhile;
					?>
				</div>
				<?php do_action( 'woocommerce_after_shop_loop' ); ?>
			<?php endif; ?>
		</div>
	</section>
	<?php ak_newsletter_section(); ?>
</main>
<?php
get_footer( 'shop' );
