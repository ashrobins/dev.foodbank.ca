<?php
/**
 * @package dteskitchen
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?> <!-- <a href="javascript:window.print()" class="print-button"><img src="<?php echo get_template_directory_uri(); ?>/ing/print.png"></a> --></h1>
	</header><!-- .entry-header -->



	<div class="recipe-content">
		<div class="recipe-info">
		<h3>Basic Facts</h3>
		<ul>
			<li>Serving Size: <?php the_field('default_serving_size'); ?>
			<li>Prep time: <?php the_field('prep_time'); ?></li>
			<li>Cook time: <?php the_field('cook-time'); ?></li>
			<li>Ready in: <?php the_field('ready_in'); ?></li>
		</ul>
	</div>
		<div class="recipe-intro">
		<?php the_content(); ?>

		<span class="recipe-author">
			<p><?php the_field('contributor_acknowledgement'); ?></p>
		</span>
		</div>


		<div class="ingredients-list">
			<h2>Ingredients</h2>

			<?php listIngredients() ?>
		</div>

		<div class="the-steps">
						<h2>Directions</h2>

			<?php listSteps() ?>

		</div>

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
      echo '<h2>Other Recipes using <a href="' . get_site_url() . '/main_ingredients/' .$tax_term->slug. '/">'. $tax_term->name . '</a></h2>';
      while ($my_query->have_posts()) : $my_query->the_post(); ?>

      	<?php if ( $post->ID != $wp_query->post->ID ) { ?>
        <p><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
        <?php }
      endwhile;
    }


    }


    wp_reset_query();
  }
}
?>

		<div class="recipe-categories"><?php the_terms( $post->ID, 'recipe_categories', 'Filed Under: ', ' ', ' ' ); ?>
	</div>


	</div><!-- .entry-content -->

	<footer class="entry-footer">

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
