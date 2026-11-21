<?php
/**
 * Single blog post.
 *
 * @package AbbyKnox
 */
get_header();
while ( have_posts() ) :
	the_post();
	?>
	<main id="main">
		<?php ak_page_hero( get_the_date(), esc_html( get_the_title() ) ); ?>
		<section class="section page-content">
			<div class="container narrow">
				<?php if ( has_post_thumbnail() ) : ?><div class="post-thumb"><?php the_post_thumbnail( 'large' ); ?></div><?php endif; ?>
				<div class="entry-content"><?php the_content(); ?></div>
			</div>
		</section>
	</main>
	<?php
endwhile;
get_footer();
