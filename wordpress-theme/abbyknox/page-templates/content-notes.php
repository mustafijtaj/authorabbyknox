<?php
/**
 * Template Name: Content Notes
 * Lists every book that has "Content notes" filled in.
 *
 * @package AbbyKnox
 */

get_header();

$ak_books = function_exists( 'wc_get_products' ) ? wc_get_products( array(
	'status'     => 'publish',
	'limit'      => -1,
	'orderby'    => 'title',
	'order'      => 'ASC',
	'meta_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery
		array( 'key' => '_ak_content_notes', 'value' => '', 'compare' => '!=' ),
	),
) ) : array();
$ak_books = array_filter( $ak_books, static function ( $p ) {
	return '' !== trim( (string) $p->get_meta( '_ak_content_notes' ) );
} );

while ( have_posts() ) :
	the_post();
	?>
	<main id="main">
		<?php ak_page_hero( __( 'Read with confidence', 'abbyknox' ), ak_em( get_the_title() === 'Content Notes' ? 'Content *Notes*' : get_the_title() ), has_excerpt() ? get_the_excerpt() : '' ); ?>
		<section class="section">
			<div class="container narrow">
				<div class="spoiler-alert reveal" role="note">
					<?php echo ak_icon( 'alert' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
					<div>
						<strong><?php esc_html_e( 'Spoiler warning', 'abbyknox' ); ?></strong>
						<p><?php esc_html_e( 'Skip this page if you don’t want spoilers. Each note is hidden until you open it. This list is a work in progress — check back for notes on past and future releases.', 'abbyknox' ); ?></p>
					</div>
				</div>
				<?php if ( get_the_content() ) : ?><div class="entry-content"><?php the_content(); ?></div><?php endif; ?>

				<?php if ( $ak_books ) : ?>
					<div class="accordion">
						<?php
						foreach ( $ak_books as $ak_p ) :
							$ak_terms = get_the_terms( $ak_p->get_id(), 'book_series' );
							?>
							<details class="note reveal">
								<summary>
									<span class="note-title"><?php echo esc_html( $ak_p->get_name() ); ?></span>
									<?php if ( $ak_terms && ! is_wp_error( $ak_terms ) ) : ?><span class="note-series"><?php echo esc_html( $ak_terms[0]->name ); ?></span><?php endif; ?>
								</summary>
								<?php ak_render_content_notes( $ak_p ); ?>
							</details>
						<?php endforeach; ?>
					</div>
				<?php else : ?>
					<p class="empty"><?php esc_html_e( 'No content notes yet.', 'abbyknox' ); ?></p>
				<?php endif; ?>

				<div class="cn-help reveal">
					<p><?php esc_html_e( 'Looking for notes on a title that isn’t listed?', 'abbyknox' ); ?>
					<?php if ( ak_opt( 'ak_email' ) ) : ?>
						<?php esc_html_e( 'Email', 'abbyknox' ); ?> <a href="mailto:<?php echo esc_attr( antispambot( ak_opt( 'ak_email' ) ) ); ?>"><?php echo esc_html( antispambot( ak_opt( 'ak_email' ) ) ); ?></a>.
					<?php endif; ?></p>
					<button class="btn btn-ghost btn-sm" id="toggleAll" type="button"><?php esc_html_e( 'Show all notes', 'abbyknox' ); ?></button>
				</div>
			</div>
		</section>
		<?php ak_newsletter_section(); ?>
	</main>
	<?php
endwhile;
get_footer();
