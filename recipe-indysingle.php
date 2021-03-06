<?php
/**
 * @package dteskitchen
 */

$postclass = "";
$has_photo = false;
$url = get_permalink( $post->ID );
$scopedurl = urlencode($url);

if(has_post_thumbnail()){
  $postclass = "photo-recipe";
  $has_photo = true;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($postclass); ?>>
<div class="a-wrapper">
	<header class="recipe-header">
 

		
    <h1 class="recipe-title"><?php the_title(); ?></h1>

    <aside class="share-icons">
    <a href="javascript:window.print()"><img src="<?php iconify('print') ?>" class="iconic" ></a>
    <a href="http://twitter.com/share?url=<?php echo $scopedurl; ?>"><img data-type="twitter" data-src="<?php iconify('social') ?>" class="iconic i-twitter" alt="social" /></a>
    <a href="<?php echo 'http://facebook.com/sharer.php?u=' . $scopedurl; ?>"><img data-type="facebook" data-src="<?php iconify('social') ?>" class="iconic i-facebook" alt="social" /></a>
    </aside>
	  
     

  </header><!-- .entry-header -->

 

  
  


	<div class="recipe-content">

      <div class="recipe-information">
      <div class="recipe-info">
      <h3>Basic Facts</h3>
      <ul>
        <?php if(get_field('prep_time')) { ?>
        <li>Prep time: <?php the_field('prep_time'); ?></li>
        <?php }?>
        <?php if(get_field('cook_time')) { ?>
        <li>Cook time: <?php the_field('cook_time'); ?></li>
        <?php }?>
        <?php if(get_field('ready_in')) { ?>
        <li>Ready in:  <?php the_field('ready_in'); ?></li>
        <?php }?>
      </ul>
      
    
     <div class="recipe-categories">
      <?php the_terms( $post->ID, 'recipe_categories', 'Filed Under: ', ' ', ' ' ); ?>
    </div>

    <div class="recipe-intro">
      <?php the_field('recipe_short_description'); ?>
    </div>

    <?php if(the_field('contributor_acknowledgement')) { ?>

    <div class="recipe-contributor">
     <?php the_field('contributor_acknowledgement') ?>
    </div>

    <?php } ?>

     </div>

     <?php if($has_photo){ ?>
      
      <div class="recipe-photo">
        <?php the_post_thumbnail() ?>
      </div>

     <?php } ?>
     </div>

 
  <div id="recipe-ingredients-list">
  <h3 class="recipe-ingredients-list-header">Ingredients</h3>
    <header class="ingredients-list-header">
      <h4>Serves <?php the_field('default_serving_size'); ?></h4>
    </header>

	
		<div class="ingredient-list">
     <ul>
      <?php echo str_replace(array('<p>','</p>', '<br />'),array('<li>','</li>','</li><li>'),get_field('ingredients') );?>
    </ul>
		</div>
    
  
   
    </div>

		<div class="the-steps">
			<h3>Directions</h3>
			<?php listSteps() ?>      
      <?php if(get_field('recipe_suggestions')) {
        echo '<div class="recipe-tip">';
        echo '<span class="label">Hot Tip</span>';
        the_field('recipe_suggestions');
        echo "</div>";
      } ?>
      </div>

		</div>
    </div> <!-- recipe content-->




      </div><!-- .entry-content -->
      </div>
    
   
    </article><!-- #post-## -->


		<?php
$post_type = 's_recipe';
$tax = 'main_ingredients';
$tax_terms = wp_get_post_terms($post->ID,$tax);
if ($tax_terms) {
  echo '<div class="related-recipes"><div class="a-wrapper">';
  foreach ($tax_terms  as $tax_term) {
    $args=array(
      'post_type' => $post_type,
      "$tax" => $tax_term->slug,
      'post_status' => 'publish',
      'posts_per_page' => -1
          );

    $my_query = null;
    $my_query = new WP_Query($args);
    $count = $my_query->post_count;
    if ($count > 1) {
    	if( $my_query->have_posts() ) {
      echo '<h2>Other Recipes using <a href="' . get_site_url() . '/ingredient/' .$tax_term->slug. '/">'. $tax_term->name . '</a></h2>';
      while ($my_query->have_posts()) : $my_query->the_post(); ?>

      	<?php if ( $post->ID != $wp_query->post->ID ) { ?>
        <h4 class="recipe-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
        

        <?php }
      endwhile;

    }


    }
    

    wp_reset_query();
  }
  echo "</div></div>";
}
?>

<footer class="single-recipe-footer">
<div class="a-wrapper">
<a href="<?php echo site_url(); ?>/individual-recipes/#all-recipes">&larr; Browse all Recipes</a>
</div>
</footer>
