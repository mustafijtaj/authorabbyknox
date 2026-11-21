<?php
/**
 * 404.
 *
 * @package AbbyKnox
 */
get_header();
?>
<main id="main">
	<?php ak_page_hero( __( 'Page not found', 'abbyknox' ), wp_kses( __( 'This page ran off with a <em>cowboy.</em>', 'abbyknox' ), array( 'em' => array() ) ), __( 'The page you’re looking for doesn’t exist — but your next favourite book does.', 'abbyknox' ) ); ?>
	<section class="section" style="padding-top:0">
		<div class="container center-cta">
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Home', 'abbyknox' ); ?></a>
			<a class="btn btn-ghost" href="<?php echo esc_url( ak_page_url( 'reading-list' ) ); ?>"><?php esc_html_e( 'Browse the Reading List', 'abbyknox' ); ?></a>
		</div>
	</section>
</main>
<?php
get_footer();
