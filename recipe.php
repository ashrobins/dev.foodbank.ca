<?php
/**
 * Template Name: Recipes Page
 *
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php query_posts( 'post_type=recipe&posts_per_pag=-1&orderby=title&order=ASC'); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'recipe', 'archive' ); ?>



			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
