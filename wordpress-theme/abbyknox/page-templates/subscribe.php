<?php
/**
 * Template Name: Subscribe
 *
 * @package AbbyKnox
 */

get_header();
while ( have_posts() ) :
	the_post();
	?>
	<main id="main">
		<section class="page-hero subscribe-hero">
			<div class="hero-bg" aria-hidden="true"><span class="blob b1"></span><span class="blob b2"></span><span class="blob b3"></span></div>
			<div class="container sub-grid">
				<div class="reveal">
					<p class="eyebrow"><?php esc_html_e( 'Abby’s newsletter', 'abbyknox' ); ?></p>
					<h1><?php echo wp_kses( __( '<em>Subscribe</em> for free books &amp; bonus material.', 'abbyknox' ), array( 'em' => array() ) ); ?></h1>
					<?php if ( has_excerpt() ) : ?><p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
					<ul class="perks">
						<li><span class="perk-icon"><?php echo ak_icon( 'book' ); // phpcs:ignore ?></span><div><strong><?php esc_html_e( 'Free books', 'abbyknox' ); ?></strong><span><?php esc_html_e( 'Reader-exclusive freebies', 'abbyknox' ); ?></span></div></li>
						<li><span class="perk-icon"><?php echo ak_icon( 'gift' ); // phpcs:ignore ?></span><div><strong><?php esc_html_e( 'Bonus material', 'abbyknox' ); ?></strong><span><?php esc_html_e( 'Extra scenes & epilogues', 'abbyknox' ); ?></span></div></li>
						<li><span class="perk-icon"><?php echo ak_icon( 'pulse' ); // phpcs:ignore ?></span><div><strong><?php esc_html_e( 'Latest book news', 'abbyknox' ); ?></strong><span><?php esc_html_e( 'Releases, sales & cover reveals', 'abbyknox' ); ?></span></div></li>
					</ul>
				</div>
				<div class="sub-card reveal">
					<h2><?php esc_html_e( 'Join the inner circle', 'abbyknox' ); ?></h2>
					<p><?php esc_html_e( 'Enter your email and you’ll finish signing up on Abby’s secure newsletter page.', 'abbyknox' ); ?></p>
					<form class="nl-form stacked" action="<?php echo esc_url( ak_opt( 'ak_newsletter_url' ) ); ?>" method="get" target="_blank" novalidate>
						<label for="subEmail"><?php esc_html_e( 'Email address', 'abbyknox' ); ?></label>
						<input id="subEmail" type="email" name="EMAIL" placeholder="you@example.com" autocomplete="email" required />
						<button type="submit" class="btn btn-primary"><?php esc_html_e( 'Subscribe Now', 'abbyknox' ); ?></button>
						<p class="form-msg" role="status" aria-live="polite"></p>
					</form>
					<p class="fine"><?php esc_html_e( 'No spam, ever. Unsubscribe with one click.', 'abbyknox' ); ?></p>
				</div>
			</div>
		</section>
		<?php if ( get_the_content() ) : ?>
			<section class="section"><div class="container narrow entry-content"><?php the_content(); ?></div></section>
		<?php endif; ?>
		<?php if ( ak_opt( 'ak_books2read' ) ) : ?>
			<section class="section">
				<div class="container follow-box reveal">
					<div>
						<p class="eyebrow"><?php esc_html_e( 'Never miss a release', 'abbyknox' ); ?></p>
						<h2><?php esc_html_e( 'Follow Abby on Books2Read', 'abbyknox' ); ?></h2>
						<p class="section-sub"><?php esc_html_e( 'Subscribe to Abby’s author page and get an alert from your favourite store the moment a new book goes live.', 'abbyknox' ); ?></p>
					</div>
					<a href="<?php echo esc_url( ak_opt( 'ak_books2read' ) ); ?>" target="_blank" rel="noopener" class="btn btn-primary"><?php echo esc_html( preg_replace( '#^https?://(www\.)?#', '', ak_opt( 'ak_books2read' ) ) ); ?></a>
				</div>
			</section>
		<?php endif; ?>
	</main>
	<?php
endwhile;
get_footer();
