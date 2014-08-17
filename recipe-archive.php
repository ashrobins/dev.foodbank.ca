<?php
/**
 * The template used for displaying recipe archive content in recipe.php
 *
 * @package dteskitchen
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
		<h4 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_field('recipe_short_description'); ?>
	</div>
	<footer><?php if has_field('ready_in') { ?>Ready in: <?php the_field('ready_in'); ?><?php } ?></footer>
	
</article><!-- #post-## -->
