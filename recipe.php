<?php
/**
 * Template Name: Recipes Page
 *
 */

get_header(); ?>

	

			<?php query_posts( 'post_type=recipe&posts_per_page=-1&orderby=title&order=ASC'); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'recipe', 'archive' ); ?>



			<?php endwhile; // end of the loop. ?>


<?php get_footer(); ?>
