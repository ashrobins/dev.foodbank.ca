<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package dteskitchen
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<div class="a-wrapper">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php 
							$term = $wp_query->get_queried_object();
							$title = $term->name;
							$id = $term->id;
							echo("Recipes using " . $title);


					?>
				</h1>
			
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

			<?php archiveList('ingedient-archive'); ?>

		
			<?php endwhile; ?>

			<?php ?>




		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

	</div>

		</main><!-- #main -->
	</section><!-- #primary -->

	<div class="ingredient-archive-description">
	<div class="a-wrapper">
	<h2>About <?php echo $title; ?></h2>
	
	<div class="ingredient-archive-description-text">
	<?php the_field('about', $term); ?>
	</div>
	</div>
	
	</div>


<?php get_footer(); ?>
