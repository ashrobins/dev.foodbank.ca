<?php
/**
 * Template Name: Recipes Page
 *
 */

get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


<section class="weekly-ingredient">
  <div class="a-wrapper">
<?php show_weekly_ingredient(); ?>




<?php the_content(); ?>
  </div>
</section>



<?php endwhile; else : ?>
  <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

<footer class="single-recipe-footer">
<div class="a-wrapper" style="text-align:center;">
<a href="#all-recipes">&DownTeeArrow;  Browse all Recipes &DownTeeArrow;</a>
</div>
</footer>

<footer role="contentinfo" id="about">
<div class="a-wrapper">
<div class="footer-about-rb">
<h2>About the Recipe Bank</h2>
<?php the_field('about_recipe_bank', 472); ?>

<span class="footer-about-kitchen">
<h2>About DTES Kitchen Tables</h2>

<?php the_field('about-dtes', 472); ?>

</span>

</div>


<div class="footer-about-dtes">


<a href="http://dteskitchentables.org/">
  <img src="<?php echo get_template_directory_uri() . '/img/dteslogo.jpg'; ?>" class="the-logo">
</a>
</div>


</div>

</footer>

<section class="recipe-list" id="all-recipes">
  <div class='a-wrapper'>

    <header class="recipe-list-header">
    <ul class="recipe-index-select">
    List Recipes by:
    <li>
      <a href="#recipe-by-name" id="name-recipe-toggle" class="recipe-toggle">Name</a>
    </li>
    <li>
      <a href="#recipe-by-season" id="season-recipe-toggle" class="recipe-toggle">Season</a>
    </li>
    <li>
      <a href="#recipe-by-ingredient" id="ingredient-recipe-toggle" class="recipe-toggle">Ingredient</a>
    </li>
    <li>
      <a href="#recipe-by-category" id="category-recipe-toggle" class="recipe-toggle">Category</a>
    </li>
    </ul>
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
$taxonomies = 'seasons';

$args = array(
    'orderby'           => 'name', 
    'order'             => 'ASC',
    'cache_domain'      => 'recipeIngredients'
); 

$terms = get_terms($taxonomies, $args);

  echo "<h3 class='recipe-index-categories'>";

foreach ($terms as $term) {
   $term_slug = $term->slug;
   $term_name = $term->name;

   echo "<a href='#$term_slug' class='recipe-index-list'>$term_name </a>";

   }

   echo "</h3>";


  $recipesbyname = new WP_Query(array(
    'post_type'   => 'recipe',
    'posts_per_page'  => -1,
    'orderby'   => 'seasons',
    'order'     => 'DESC'
    ));

  if ( $recipesbyname->have_posts() ) :
    $curr_season = '';


    while ( $recipesbyname->have_posts() ) : $recipesbyname->the_post();

     $terms = wp_get_object_terms($post->ID, 'seasons');
     $this_season = $terms[0]->name;
     $season_slug = $terms[0]->slug;
                  
      if ($this_season != $curr_season) {
          echo "<h2 class='recipe-list-alphabet' id='$season_slug'> $this_season </h2>";
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

  echo "<h3 class='recipe-index-categories'>";

foreach ($terms as $term) {
   $term_slug = $term->slug;
   $term_name = $term->name;

   echo "<a href='#$term_slug' class='recipe-index-list'>$term_name </a>";

   }

   echo "</h3>";

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
      echo "<h2 class='recipe-list-alphabet' id='$term_slug'> $term_name </h2>";


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

  echo "<h3 class='recipe-index-categories'>";

foreach ($terms as $term) {
   $term_slug = $term->slug;
   $term_name = $term->name;

   echo "<a href='#$term_slug' class='recipe-index-list'>$term_name </a>";


   }

   echo "</h3>";

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
      echo "<h2 class='recipe-list-alphabet' id='$term_slug'> $term_name </h2>";
      while ( $recipesbycategory->have_posts() ) : $recipesbycategory->the_post();
        get_template_part( 'recipe', 'archive' );
      endwhile;
    endif;
  wp_reset_postdata(); 


}

?>
</div>


</div><!--wrap-->
</section>


<?php get_footer(); ?>
