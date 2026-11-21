<?php
/**
 * Customizer: lets the author edit homepage text, newsletter link, contact and social links.
 * Appearance → Customize → "Abby Knox site settings".
 *
 * @package AbbyKnox
 */

defined( 'ABSPATH' ) || exit;

function ak_customize_register( $wp_customize ) {
	$wp_customize->add_panel( 'ak_panel', array(
		'title'    => __( 'Abby Knox site settings', 'abbyknox' ),
		'priority' => 20,
	) );

	$sections = array(
		'ak_home'    => array(
			'title'  => __( 'Homepage', 'abbyknox' ),
			'fields' => array(
				'ak_hero_eyebrow'   => array( __( 'Hero small label', 'abbyknox' ), 'text' ),
				'ak_hero_line1'     => array( __( 'Hero line 1', 'abbyknox' ), 'text' ),
				'ak_hero_line2'     => array( __( 'Hero line 2 (pink italic)', 'abbyknox' ), 'text' ),
				'ak_hero_line3'     => array( __( 'Hero line 3 (handwritten)', 'abbyknox' ), 'text' ),
				'ak_hero_lead'      => array( __( 'Hero paragraph', 'abbyknox' ), 'textarea' ),
				'ak_hero_stat'      => array( __( 'Number of books (hero counter)', 'abbyknox' ), 'number' ),
				'ak_tropes'         => array( __( 'Scrolling tropes (comma separated)', 'abbyknox' ), 'textarea' ),
				'ak_series_eyebrow' => array( __( 'Series section — small label', 'abbyknox' ), 'text' ),
				'ak_series_heading' => array( __( 'Series section — heading', 'abbyknox' ), 'text' ),
				'ak_series_text'    => array( __( 'Series section — text', 'abbyknox' ), 'textarea' ),
				'ak_series_slugs'   => array( __( 'Series section — series slugs to show (comma separated, from Products → Series)', 'abbyknox' ), 'text' ),
				'ak_about_short'    => array( __( 'Short bio on homepage', 'abbyknox' ), 'textarea' ),
			),
		),
		'ak_news'    => array(
			'title'  => __( 'Newsletter', 'abbyknox' ),
			'fields' => array(
				'ak_newsletter_url'   => array( __( 'Newsletter sign-up URL (Mailchimp etc.)', 'abbyknox' ), 'url' ),
				'ak_newsletter_title' => array( __( 'Newsletter heading', 'abbyknox' ), 'text' ),
				'ak_newsletter_text'  => array( __( 'Newsletter text', 'abbyknox' ), 'textarea' ),
			),
		),
		'ak_contact' => array(
			'title'  => __( 'Contact & social links', 'abbyknox' ),
			'fields' => array(
				'ak_email'          => array( __( 'Contact email', 'abbyknox' ), 'email' ),
				'ak_footer_tagline' => array( __( 'Footer tagline', 'abbyknox' ), 'text' ),
				'ak_facebook'       => array( 'Facebook URL', 'url' ),
				'ak_instagram'      => array( 'Instagram URL', 'url' ),
				'ak_threads'        => array( 'Threads URL', 'url' ),
				'ak_goodreads'      => array( 'Goodreads URL', 'url' ),
				'ak_bookbub'        => array( 'BookBub URL', 'url' ),
				'ak_books2read'     => array( 'Books2Read author page URL', 'url' ),
			),
		),
	);

	$defaults = ak_defaults();
	foreach ( $sections as $section_id => $section ) {
		$wp_customize->add_section( $section_id, array( 'title' => $section['title'], 'panel' => 'ak_panel' ) );
		foreach ( $section['fields'] as $key => $field ) {
			list( $label, $type ) = $field;
			$sanitize = 'sanitize_text_field';
			if ( 'textarea' === $type ) {
				$sanitize = 'sanitize_textarea_field';
			} elseif ( 'url' === $type ) {
				$sanitize = 'esc_url_raw';
			} elseif ( 'email' === $type ) {
				$sanitize = 'sanitize_email';
			} elseif ( 'number' === $type ) {
				$sanitize = 'absint';
			}
			$wp_customize->add_setting( $key, array(
				'default'           => $defaults[ $key ] ?? '',
				'sanitize_callback' => $sanitize,
				'transport'         => 'refresh',
			) );
			$wp_customize->add_control( $key, array(
				'label'   => $label,
				'section' => $section_id,
				'type'    => $type,
			) );
		}
	}
}
add_action( 'customize_register', 'ak_customize_register' );
