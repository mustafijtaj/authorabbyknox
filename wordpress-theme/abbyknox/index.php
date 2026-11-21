<?php
/**
 * Fallback template (blog/archive).
 *
 * @package AbbyKnox
 */
get_header();
?>
<main id="main">
	<?php ak_page_hero( '', is_home() ? esc_html__( 'News', 'abbyknox' ) : wp_strip_all_tags( get_the_archive_title() ) ); ?>
	<section class="section">
		<div class="container narrow">
			<?php if ( have_posts() ) : ?>
				<div class="post-list">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<article <?php post_class( 'post-card reveal' ); ?>>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p class="post-meta"><?php echo esc_html( get_the_date() ); ?></p>
							<?php the_excerpt(); ?>
						</article>
					<?php endwhile; ?>
				</div>
				<?php the_posts_pagination(); ?>
			<?php else : ?>
				<p><?php esc_html_e( 'Nothing here yet.', 'abbyknox' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();
