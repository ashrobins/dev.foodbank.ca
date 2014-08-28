<?php
/**
 * @package dteskitchen
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="recipe-header">
		<h1 class="recipe-title"><?php the_title(); ?></h1>
	   <div class="recipe-intro">
       <?php the_field('recipe_short_description'); ?>
     </div>
     

  </header><!-- .entry-header -->



	<div class="recipe-content">
		<div class="recipe-info">
		<h3>Basic Facts</h3>
		<ul>
			<li>Prep time: <?php the_field('prep_time'); ?></li>
			<li>Cook time: <?php the_field('cook_time'); ?></li>
			<li>Ready in:  <?php the_field('ready_in'); ?></li>
		</ul>
    <div class="recipe-suggestions">
    <?php the_field('recipe_suggestions'); ?>
	 </div>
   </div>
   <div class="recipe-serving-size">
   <h3>Serving Size:</h3>
   <ul class="recipe-serving-size-selection">

     <li><a href="#small-ingredients" id="small-ingredient-toggle" class="ingredient-toggle">Small</a></li>
     <li><a href="#medium-ingredients" id="medium-ingredient-toggle"  class="ingredient-toggle">Medium</a></li>
     <li><a href="#large-ingredients" id="large-ingredient-toggle" class="ingredient-toggle">Large</a></li>
   </ul>
   </div>  
  <div id="recipe-ingredients-list">
  <h3 class="recipe-ingredients-list-header">Ingredients</h3>

	
		<div class="ingredients-list" id="small-ingredients">
      <header class="ingredients-list-header">
			
      <h4>Serves 15</h4>
      </header>

			<?php listSmallIngredients() ?>
		</div>
    
    <div class="ingredients-list" id="medium-ingredients">
      <header class="ingredients-list-header">
        
        <h4>Serves 50</h4>
       </header>

      <?php listMediumIngredients() ?>
    </div>
    

    <div class="ingredients-list" id="large-ingredients">
      <header class="ingredients-list-header">
            
            <h4>Serves 100</h4>
            </header>

      <?php listLargeIngredients() ?>
    </div>
    </div>

		<div class="the-steps">
						<h3>Directions</h3>

			<?php listSteps() ?>

		</div>

    

        
      </div>

      <div class="recipe-categories"><?php the_terms( $post->ID, 'recipe_categories', 'Filed Under: ', ' ', ' ' ); ?></div>

      </div><!-- .entry-content -->

    </article><!-- #post-## -->


		<?php
$post_type = 'recipe';
$tax = 'main_ingredients';
$tax_terms = wp_get_post_terms($post->ID,$tax);
if ($tax_terms) {
  foreach ($tax_terms  as $tax_term) {
    $args=array(
      'post_type' => $post_type,
      "$tax" => $tax_term->slug,
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'caller_get_posts'=> 1
    );

    $my_query = null;
    $my_query = new WP_Query($args);
    $count = $my_query->post_count;
    if ($count > 1) {
    	if( $my_query->have_posts() ) {
      echo '<div class="related-recipes"><h2>Other Recipes using <a href="' . get_site_url() . '/main_ingredients/' .$tax_term->slug. '/">'. $tax_term->name . '</a></h2>';
      while ($my_query->have_posts()) : $my_query->the_post(); ?>

      	<?php if ( $post->ID != $wp_query->post->ID ) { ?>
        <h4 class="recipe-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
        </div>

        <?php }
      endwhile;
    }


    }


    wp_reset_query();
  }
}
?>
