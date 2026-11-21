<?php
/**
 * Template Name: About
 * Hero uses the page's featured image + excerpt; the rest is the page content (block editor).
 *
 * @package AbbyKnox
 */

get_header();
while ( have_posts() ) :
	the_post();
	?>
	<main id="main">
		<section class="page-hero about-hero">
			<div class="hero-bg" aria-hidden="true"><span class="blob b1"></span><span class="blob b2"></span><span class="blob b3"></span></div>
			<div class="container about-grid">
				<div class="about-visual reveal">
					<div class="polaroid">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'large' ); ?>
						<?php else : ?>
							<span class="polaroid-fallback"><?php bloginfo( 'name' ); ?></span>
						<?php endif; ?>
						<span class="caption"><?php esc_html_e( 'xo, Abby', 'abbyknox' ); ?></span>
					</div>
				</div>
				<div class="about-copy reveal">
					<p class="eyebrow"><?php esc_html_e( 'Meet the author', 'abbyknox' ); ?></p>
					<h1><?php esc_html_e( 'Hi, I’m', 'abbyknox' ); ?> <em><?php bloginfo( 'name' ); ?>.</em></h1>
					<?php if ( has_excerpt() ) : ?><p class="lead"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
					<div class="hero-actions">
						<?php if ( ak_opt( 'ak_email' ) ) : ?>
							<a href="mailto:<?php echo esc_attr( antispambot( ak_opt( 'ak_email' ) ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Say Hello', 'abbyknox' ); ?></a>
						<?php endif; ?>
						<a href="<?php echo esc_url( ak_page_url( 'reading-list' ) ); ?>" class="btn btn-ghost"><?php esc_html_e( 'Browse My Books', 'abbyknox' ); ?></a>
					</div>
				</div>
			</div>
		</section>

		<section class="section page-content">
			<div class="container about-content entry-content">
				<?php the_content(); ?>
			</div>
		</section>

		<section class="section" style="padding-top:0">
			<div class="container">
				<div class="section-head reveal">
					<p class="eyebrow"><?php esc_html_e( 'Let’s be friends', 'abbyknox' ); ?></p>
					<h2><?php esc_html_e( 'Say hello', 'abbyknox' ); ?></h2>
				</div>
				<div class="contact-grid">
					<?php if ( ak_opt( 'ak_email' ) ) : ?>
						<a class="contact-card reveal" href="mailto:<?php echo esc_attr( antispambot( ak_opt( 'ak_email' ) ) ); ?>"><span class="extra-icon"><?php echo ak_icon( 'mail' ); // phpcs:ignore ?></span><strong><?php esc_html_e( 'Email', 'abbyknox' ); ?></strong><span><?php echo esc_html( antispambot( ak_opt( 'ak_email' ) ) ); ?></span></a>
					<?php endif; ?>
					<a class="contact-card reveal" href="<?php echo esc_url( ak_page_url( 'subscribe' ) ); ?>"><span class="extra-icon"><?php echo ak_icon( 'book' ); // phpcs:ignore ?></span><strong><?php esc_html_e( 'Newsletter', 'abbyknox' ); ?></strong><span><?php esc_html_e( 'Free books & bonus material', 'abbyknox' ); ?></span></a>
					<?php if ( ak_opt( 'ak_facebook' ) ) : ?>
						<a class="contact-card reveal" href="<?php echo esc_url( ak_opt( 'ak_facebook' ) ); ?>" target="_blank" rel="noopener"><span class="extra-icon"><?php echo ak_icon( 'facebook' ); // phpcs:ignore ?></span><strong>Facebook</strong><span><?php esc_html_e( 'Join the conversation', 'abbyknox' ); ?></span></a>
					<?php endif; ?>
					<?php if ( ak_opt( 'ak_instagram' ) ) : ?>
						<a class="contact-card reveal" href="<?php echo esc_url( ak_opt( 'ak_instagram' ) ); ?>" target="_blank" rel="noopener"><span class="extra-icon"><?php echo ak_icon( 'instagram' ); // phpcs:ignore ?></span><strong>Instagram</strong><span><?php esc_html_e( 'Covers & sneak peeks', 'abbyknox' ); ?></span></a>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php ak_newsletter_section(); ?>
	</main>
	<?php
endwhile;
get_footer();
