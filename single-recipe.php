<?php
/**
 * The Template for displaying single recipes.
 *
 * @package dteskitchen
 */

get_header(); ?>


<section>
	

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'recipe', 'single' ); ?>


			

		<?php endwhile; // end of the loop. ?>
</section>

<?php get_footer(); ?>