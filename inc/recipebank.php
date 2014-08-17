<?php
/**
 * Custom functions that act independently of the theme templates
 *
 *
 *
 * @package dteskitchen
 */

function relatedIngredients() {

}
// Delete this. No longer relevant
function listIngredients() {
	if( have_rows('ingredients') ):
 	?><div class="ingredient-list"><?php
 	// loop through the rows of data
    while ( have_rows('ingredients') ) : the_row();
 		?> <div class="ingredient-single"><span class="ingredient-amount"> <?php the_sub_field('amount'); ?></span><span class="ingredient-measurement"> <?php the_sub_field('measurement'); ?></span><span class="ingredient-ingredient">  <?php the_sub_field('ingredient');?></span> </div>
       <?php
    endwhile;
 	?> </div><?php
else :

    // no rows found

endif;
}

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
							<h2>Hot Tip</h2>
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
