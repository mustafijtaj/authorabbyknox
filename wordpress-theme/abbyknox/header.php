<?php
/**
 * Site header.
 *
 * @package AbbyKnox
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="theme-color" content="#3b0f2a" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'abbyknox' ); ?></a>

<header class="site-header" id="top">
	<div class="container nav-wrap">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' — ' . __( 'home', 'abbyknox' ) ); ?>">
			<?php
			$logo_id = get_theme_mod( 'custom_logo' );
			if ( $logo_id ) {
				echo wp_get_attachment_image( $logo_id, 'thumbnail', false, array( 'class' => 'logo-img', 'alt' => '' ) );
			} else {
				$initials = '';
				foreach ( preg_split( '/\s+/', trim( get_bloginfo( 'name' ) ) ) as $w ) {
					$initials .= function_exists( 'mb_substr' ) ? mb_substr( $w, 0, 1 ) : substr( $w, 0, 1 );
				}
				echo '<span class="logo-mark">' . esc_html( strtoupper( substr( $initials, 0, 2 ) ) ) . '</span>';
			}
			?>
			<span class="logo-text"><?php bloginfo( 'name' ); ?></span>
		</a>
		<nav class="nav" id="nav" aria-label="<?php esc_attr_e( 'Main', 'abbyknox' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'depth'          => 1,
				'fallback_cb'    => 'ak_menu_fallback',
			) );
			?>
			<a href="<?php echo esc_url( ak_page_url( 'subscribe' ) ); ?>" class="btn btn-primary btn-sm nav-cta"><?php esc_html_e( 'Subscribe', 'abbyknox' ); ?></a>
		</nav>
		<div class="header-tools">
			<?php if ( function_exists( 'ak_cart_link' ) ) : ?>
				<a class="account-link" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" aria-label="<?php esc_attr_e( 'My account & ebook downloads', 'abbyknox' ); ?>"><?php echo ak_icon( 'user' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
				<?php echo ak_cart_link(); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped inside. ?>
			<?php endif; ?>
			<button class="nav-toggle" id="navToggle" aria-label="<?php esc_attr_e( 'Open menu', 'abbyknox' ); ?>" aria-expanded="false" aria-controls="nav">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>
