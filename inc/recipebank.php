<?php
/**
 * Custom functions that act independently of the theme templates
 *
 *
 *  <li>Serving Size: <?php the_field('default_serving_size'); ?></li>
 *     <li>Prep time: <?php the_field('prep_time'); ?></li>
 *     <li>Cook time: <?php the_field('cook-time'); ?></li>
 *     <li>Ready in: <?php the_field('ready_in'); ?></li>
 * @package dteskitchen
 */

/*
 Main Ingredient Highlight   
*/

function show_weekly_ingredient() {

  $term = get_field('featured_ingredient');

  if( $term ): ?>
  <h2 class="weekly-ingredient-heading">This week's featured ingredient</h2>
  <h3 class="weekly-ingredient-feature"><?php echo $term->name; ?></h3>
  <p><?php echo $term->description; ?></p>

 
  <div class="weekly-ingredient-info">
      <?php the_field('about', $term); ?>
  </div>
  <footer class='weekly-ingredient-footer'>
      <h2>Recipes using <?php echo $term->name; ?> </h3>

      <?php related_recipes($term->slug) ?>
  </footer>

  <?php endif; 
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


function listSteps() {
	if( have_rows('the_steps') ): ?>
 			<ol class="recipe-steps">
 	<?php
     // loop through the rows of data
    while ( have_rows('the_steps') ) : the_row();

			$step_or_tip = get_sub_field(step_tip);
			$step_class = strtolower($step_or_tip);
			?>
				<?php if ($step_or_tip == "Step"):
					?><li> 	        	<?php the_sub_field('step'); ?> </li>
					<?php ;
					else:
						?>
						<div class="recipe-tip">
							<span class="label">Hot Tip</span>
							<?php the_sub_field('step'); ?>
						</div>
						<?php
						endif;



    endwhile;
    			?> </ol> <?php


else :

    // no layouts found

endif;

}
?>
