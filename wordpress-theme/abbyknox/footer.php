<?php
/**
 * Site footer.
 *
 * @package AbbyKnox
 */
?>
<footer class="site-footer">
	<div class="container footer-grid">
		<div>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo light"><span class="logo-mark">AK</span><span class="logo-text"><?php bloginfo( 'name' ); ?></span></a>
			<p class="foot-tag"><?php echo esc_html( ak_opt( 'ak_footer_tagline' ) ); ?></p>
			<?php if ( ak_opt( 'ak_email' ) ) : ?>
				<a class="foot-mail" href="mailto:<?php echo esc_attr( antispambot( ak_opt( 'ak_email' ) ) ); ?>"><?php echo esc_html( antispambot( ak_opt( 'ak_email' ) ) ); ?></a>
			<?php endif; ?>
		</div>
		<nav aria-label="<?php esc_attr_e( 'Books', 'abbyknox' ); ?>">
			<h3><?php esc_html_e( 'Books', 'abbyknox' ); ?></h3>
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/#latest' ) ); ?>"><?php esc_html_e( 'Latest Releases', 'abbyknox' ); ?></a></li>
				<li><a href="<?php echo esc_url( ak_page_url( 'reading-list' ) ); ?>"><?php esc_html_e( 'Complete Reading List', 'abbyknox' ); ?></a></li>
				<li><a href="<?php echo esc_url( ak_cat_url( 'abby-bites' ) ); ?>"><?php esc_html_e( 'Abby Bites', 'abbyknox' ); ?></a></li>
				<li><a href="<?php echo esc_url( ak_cat_url( 'signed-books' ) ); ?>"><?php esc_html_e( 'Signed Books', 'abbyknox' ); ?></a></li>
			</ul>
		</nav>
		<nav aria-label="<?php esc_attr_e( 'Readers', 'abbyknox' ); ?>">
			<h3><?php esc_html_e( 'Readers', 'abbyknox' ); ?></h3>
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'depth' => 1 ) );
			} else {
				?>
				<ul>
					<li><a href="<?php echo esc_url( ak_cat_url( 'bonus' ) ); ?>"><?php esc_html_e( 'Bonus Content', 'abbyknox' ); ?></a></li>
					<li><a href="<?php echo esc_url( ak_page_url( 'content-notes' ) ); ?>"><?php esc_html_e( 'Content Notes', 'abbyknox' ); ?></a></li>
					<li><a href="<?php echo esc_url( ak_page_url( 'subscribe' ) ); ?>"><?php esc_html_e( 'Newsletter', 'abbyknox' ); ?></a></li>
					<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
						<li><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'My Ebook Downloads', 'abbyknox' ); ?></a></li>
					<?php endif; ?>
				</ul>
			<?php } ?>
		</nav>
		<div>
			<h3><?php esc_html_e( 'Follow Abby', 'abbyknox' ); ?></h3>
			<?php ak_social_links(); ?>
			<?php if ( ak_opt( 'ak_books2read' ) ) : ?>
				<a class="foot-b2r" href="<?php echo esc_url( ak_opt( 'ak_books2read' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Follow on Books2Read →', 'abbyknox' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
	<div class="container foot-bottom">
		<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'abbyknox' ); ?></p>
		<a href="#top" class="back-top"><?php esc_html_e( 'Back to top ↑', 'abbyknox' ); ?></a>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
