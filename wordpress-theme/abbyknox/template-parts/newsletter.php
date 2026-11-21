<?php
/**
 * Newsletter call-to-action band.
 *
 * @package AbbyKnox
 */
$ak_nl_id = 'nlEmail' . wp_rand( 100, 999 );
?>
<section class="newsletter" aria-label="<?php esc_attr_e( 'Newsletter', 'abbyknox' ); ?>">
	<div class="container nl-box reveal">
		<div>
			<p class="eyebrow light"><?php esc_html_e( 'Abby’s inner circle', 'abbyknox' ); ?></p>
			<h2><?php echo esc_html( ak_opt( 'ak_newsletter_title' ) ); ?></h2>
			<p><?php echo esc_html( ak_opt( 'ak_newsletter_text' ) ); ?></p>
		</div>
		<form class="nl-form" action="<?php echo esc_url( ak_opt( 'ak_newsletter_url' ) ); ?>" method="get" target="_blank" novalidate>
			<label for="<?php echo esc_attr( $ak_nl_id ); ?>" class="sr-only"><?php esc_html_e( 'Email address', 'abbyknox' ); ?></label>
			<input id="<?php echo esc_attr( $ak_nl_id ); ?>" type="email" name="EMAIL" placeholder="you@example.com" autocomplete="email" required />
			<button type="submit" class="btn btn-light"><?php esc_html_e( 'Sign Me Up', 'abbyknox' ); ?></button>
			<p class="form-msg" role="status" aria-live="polite"></p>
		</form>
	</div>
</section>
