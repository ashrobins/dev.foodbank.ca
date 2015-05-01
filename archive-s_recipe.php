<?php
/**
 * Individual Recipes Archive Page
 * 
 */

$therecipetype = 's_recipe';

get_header(); ?>



<section class="weekly-ingredient">
  <div class="a-wrapper">
  <h2 class="weekly-ingredient-heading"><?php the_field('individual_archive_heading', 472); ?></h2>

    
    
    <div class="weekly-ingredient-info">

    
    <?php the_field('individual_intro', 472); ?>

    

       
    

    </div>
    <footer class='weekly-ingredient-footer'>
     
    <?php if (get_field('featured_recipes', 472)) { ?>
      <div class="weekly-ingredient-procurement">
        <h2>Featured Recipes</h2>
     <?php 

     $posts = get_field('featured_recipes', 472);

     if( $posts ): ?>
         <ul>
         <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
             <?php setup_postdata($post); ?>
             <li>
                 <h3 class="recipe-title sidebar-recipe"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                 <?php the_field('recipe_short_description'); ?>
               
             </li>
            
         <?php endforeach; ?>
         </ul>
         <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
     <?php endif; ?>


      </div>
    <?php  } ?>
        
    </footer>
    

    </div>

  </div>
</section>

<footer class="single-recipe-footer">
<div class="a-wrapper" style="text-align:center;">
<a href="#all-recipes">Browse all Recipes</a>
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
      <a href="#recipe-by-equipment" id="equipment-recipe-toggle" class="recipe-toggle">Equipment</a>
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
    'post_type'   => 's_recipe',
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

<div class="recipe-list-section" id="recipe-by-equipment">

<?php 
$args = array(
    'orderby'           => 'name', 
    'order'             => 'ASC',
    'post_type'         => 's_recipe',
); 

$postobjs = get_posts( $args );
$postids = wp_list_pluck( $postobjs, 'ID' );
$taxonomy = 'equipment'; // your taxonomy name
$terms = wp_get_object_terms( $postids, $taxonomy );


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
         'post_type'   => 's_recipe',
         'posts_per_page'  => -1,
         'equipment'    => $term_slug,
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

<div class="recipe-list-section" id="recipe-by-ingredient">

<?php 
$taxonomies = 'main_ingredients';



$postobjs = get_posts( $args );
$postids = wp_list_pluck( $postobjs, 'ID' );
$taxonomy = 'main_ingredients'; // your taxonomy name
$terms = wp_get_object_terms( $postids, $taxonomy );


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
      'post_type'   => 's_recipe',
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

$args = array(
    'orderby'           => 'name', 
    'order'             => 'ASC',
    'post_type'         => 's_recipe'
    ); 



$postobjs = get_posts( $args );
$postids = wp_list_pluck( $postobjs, 'ID' );
$taxonomy = 'recipe_categories'; // your taxonomy name
$terms = wp_get_object_terms( $postids, $taxonomy );

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
      'post_type'   => 's_recipe',
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
