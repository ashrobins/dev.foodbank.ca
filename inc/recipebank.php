<?php
/**
 * Custom functions that act independently of the theme templates
 *
 *
 *  
 *     
 *    
 *    
 * @package dteskitchen
 */

/*
 Main Ingredient Highlight   
*/

function show_weekly_ingredient() {


  $term = get_field('featured_ingredient');


  if( $term ): ?>
  <h2 class="weekly-ingredient-heading">This week's featured ingredient</h2>
 
 
  <div class="weekly-ingredient-info">
  <h3 class="weekly-ingredient-feature"><?php echo $term->name; ?></h3>
  
  <p><?php echo $term->description; ?></p>

  

      <?php the_field('about', $term); ?>

  

  </div>
  <footer class='weekly-ingredient-footer'>
  <?php if (get_field('procurement_pitch', 472)) { ?>
    <div class="weekly-ingredient-procurement">
    <?php the_field('procurement_pitch'); ?>
    </div>
  <?php  } ?>
      <div class="weekly-ingredient-recipes">
      <h2>Recipes using <?php echo $term->name; ?> </h3>

      <?php related_recipes($term->slug) ?>
      </div>
  </footer>
  

  </div>

  <?php endif; 
}

function show_ingredient_info(){


}


function related_recipes($term){

  $args=array(
    'post_type' => 'recipe',
    'main_ingredients' => $term,
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'caller_get_posts'=> 1
  );

  $my_query = null;
  $my_query = new WP_Query($args);
  
    if( $my_query->have_posts() ) {
    echo "<ul>";
    while ($my_query->have_posts()) : $my_query->the_post(); ?>

     
      <li class="recipe-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></li>

      <?php 
    endwhile;
    echo "</ul>";
  }


}

function readyIn(){
  $value = get_field( "ready_in" );
  if( $value )
  {
    echo '<span class="recipe-ready">' . $value . '</span>';
  }
}

/*
 Different Recipe Archives 
*/

 function recipesByName() {
  // get posts

 }

function archiveList($class_name) { ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class($class_name); ?>>
    <header>
      <h4 class="recipe-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
    </header><!-- .recipe-header -->

    <div class="recipe-short-description">
      <?php the_field('recipe_short_description'); ?>
    </div>
    <footer><?php readyIn() ?></footer>
    
  </article><!-- #post-## -->

<? }

function recipesBySeason(){


}



/*
 Recipe Ingredient Displays
*/

function listSmallIngredients(){
  ?>
  <div class="ingredient-list">
  <?php the_field('small_ingredients_list'); ?>
  </div>
<?}

function listMediumIngredients(){
  ?><div class="ingredient-list">
  <?php the_field('medium_ingredients_list'); ?>
  </div><?
}

function listLargeIngredients(){
  ?><div class="ingredient-list">
  <?php the_field('large_ingredients_list'); ?>
  </div><?
}


function listSteps() { ?>
	
 			<div class="recipe-steps">

    <?php the_field('the_steps'); ?>

	
    		</div> <?php



}
?>
