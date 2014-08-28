<?php
/**
 * Template Name: Recipes Page
 *
 */

get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<section class="weekly-ingredient">
<?php show_weekly_ingredient(); ?>

<?php the_content(); ?>
</section>


<?php endwhile; else : ?>
  <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>


<section class="recipe-list">
  <header>
    <h2 class="recipe-list-header">All Recipes by Name</h2>
  </header>

	

			<?php query_posts( 'post_type=recipe&posts_per_page=-1&orderby=title&order=ASC'); ?>
      <?php
      $curr_letter = '';

     

			while ( have_posts() ) : the_post(); 
      $this_letter = strtoupper(substr($post->post_title,0,1));
            if ($this_letter != $curr_letter) {
               echo "<h2 class='recipe-list-alphabet'> $this_letter </h2>";
               $curr_letter = $this_letter;
            }

			  get_template_part( 'recipe', 'archive' );


			endwhile; // end of the loop. 
      ?>
</section>


<?php get_footer(); ?>
