<?php
/**
 * Default page (also used for Cart, Checkout and My Account).
 *
 * @package AbbyKnox
 */
get_header();
while ( have_posts() ) :
	the_post();
	?>
	<main id="main">
		<?php ak_page_hero( '', esc_html( get_the_title() ), has_excerpt() ? get_the_excerpt() : '' ); ?>
		<section class="section page-content">
			<div class="container <?php echo ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() ) ) ? 'shop-page' : 'narrow'; ?>">
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</div>
		</section>
	</main>
	<?php
endwhile;
get_footer();
