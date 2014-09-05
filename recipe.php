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


<section class="recipe-list" id="all-recipes">
  <header>
    <h2 class="recipe-list-header">All Recipes by Name</h2>
    <li>
      <a href="#recipe-by-name" id="name-recipe-toggle" class="recipe-toggle">Name</a>
    </li>
    <li>
      <a href="#recipe-by-season" id="season-recipe-toggle" class="recipe-toggle">Season</a>
    </li>
    <li>
      <a href="#recipe-by-ingredient" id="ingredient-recipe-toggle" class="recipe-toggle">Name</a>
    </li>
    <li>
      <a href="#recipe-by-category" id="category-recipe-toggle" class="recipe-toggle">Category</a>
    </li>
  </header>

<div class="recipe-list-section" id="recipe-by-name">

<?php
  $recipesbyname = new WP_Query(array(
    'post_type'   => 'recipe',
    'posts_per_page'  => -1,
    'orderby'   => 'title',
    'order'     => 'ASC'
    ));

  if ( $recipesbyname->have_posts() ) :
    $curr_letter = '';


    while ( $recipesbyname->have_posts() ) : $recipesbyname->the_post();

     $this_letter = strtoupper(substr($post->post_title,0,1));
                  
      if ($this_letter != $curr_letter) {
          echo "<h2 class='recipe-list-alphabet'> $this_letter </h2>";
          $curr_letter = $this_letter;
          }

      get_template_part( 'recipe', 'archive' );

     endwhile;
     endif;
     wp_reset_postdata();	

?>
</div>

<div class="recipe-list-section" id="recipe-by-season">

<?php
  $recipesbyname = new WP_Query(array(
    'post_type'   => 'recipe',
    'posts_per_page'  => -1,
    'orderby'   => 'seasons',
    'order'     => 'ASC'
    ));

  if ( $recipesbyname->have_posts() ) :
    $curr_season = '';


    while ( $recipesbyname->have_posts() ) : $recipesbyname->the_post();

     $terms = wp_get_object_terms($post->ID, 'seasons');
     $this_season = $terms[0]->name;
                  
      if ($this_season != $curr_season) {
          echo "<h2 class='recipe-list-alphabet'> $this_season </h2>";
          $curr_season = $this_season;
          }

      get_template_part( 'recipe', 'archive' );

     endwhile;
     endif;
     wp_reset_postdata(); 

?>
</div>

<div class="recipe-list-section" id="recipe-by-ingredient">

<?php 
$taxonomies = 'main_ingredients';

$args = array(
    'orderby'           => 'name', 
    'order'             => 'ASC',
    'cache_domain'      => 'recipeIngredients'
); 

$terms = get_terms($taxonomies, $args);

foreach ($terms as $term) {
   $term_slug = $term->slug;
   $term_name = $term->name;

    $recipesbyname = new WP_Query(array(
      'post_type'   => 'recipe',
      'posts_per_page'  => -1,
      'main_ingredients'    => $term_slug,
      'order'     => 'ASC'
      ));

    if ( $recipesbyname->have_posts() ) :
      echo "<h2 class='recipe-list-alphabet'> $term_name </h2>";


      while ( $recipesbyname->have_posts() ) : $recipesbyname->the_post();

      
     
           
           

        get_template_part( 'recipe', 'archive' );

       endwhile;
       endif;
       wp_reset_postdata(); 


}

?>
</div>

<div class="recipe-list-section" id="recipe-by-category">

<?php 
$taxonomies = 'recipe_categories';

$args = array(
    'orderby'           => 'name', 
    'order'             => 'ASC'
    ); 

$terms = get_terms($taxonomies, $args);

foreach ($terms as $term) {
   $term_slug = $term->slug;
   $term_name = $term->name;

    $recipesbycategory = new WP_Query(array(
      'post_type'   => 'recipe',
      'posts_per_page'  => -1,
      'recipe_categories'    => $term_slug,
      'order'     => 'ASC'
      ));
    
    if ( $recipesbycategory->have_posts() ) :
      echo "<h2 class='recipe-list-alphabet'> $term_name </h2>";


      while ( $recipesbyname->have_posts() ) : $recipesbyname->the_post();

      
     
           
           

        get_template_part( 'recipe', 'archive' );

       endwhile;
       endif;
       wp_reset_postdata(); 


}

?>
</div>



</section>


<?php get_footer(); ?>
