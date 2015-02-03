<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package dteskitchen
 */
?>

<?php if ( ! is_page_template('recipe.php') ) { ?>

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

<?php } ?>
	
<?php wp_footer(); ?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <script src="<?php echo get_template_directory_uri() . '/js/iconic.min.js'; ?>"></script>


<?php if (is_single()){ ?>

<script>
$(function() {
  var panels = $('.ingredients-list'),
      stored_tab = localStorage.getItem('active_tab'),
      current_active_tab,
      active_panel,
      stored_tab;
      
      if (stored_tab){
        current_active_tab = $(stored_tab);
      }
      else {
        current_active_tab = $('#small-ingredient-toggle');
      }
     
      active_panel = current_active_tab.attr('href');
      panels.hide();
      current_active_tab.toggleClass('active');

      $(active_panel).show();

      $('.ingredient-toggle').on('click', function(e){
          e.preventDefault();
          el = $(this);
          
          $(active_panel).hide();
          panel = el.attr('href');
          $(panel).fadeIn(); 
          active_panel = panel;
          current_active_tab.toggleClass('active');
          el.toggleClass('active');
          current_active_tab = el;

          stored_tab = '#' + el.attr('id');

          localStorage.setItem('active_tab', stored_tab);

    
     

          
    })

      
});



</script>

<?php } ?>

<?php if (is_page_template( 'recipe.php' )) { ?>

<script>
$(function() {
  var panels = $('.recipe-list-section'),
      stored_tab = localStorage.getItem('active_index'),
      current_active_tab,
      active_panel,
      stored_tab;
      
      if (stored_tab){
        current_active_tab = $(stored_tab);
      }
      else {
        current_active_tab = $('#name-recipe-toggle');
      }
     
      active_panel = current_active_tab.attr('href');
      panels.hide();
      current_active_tab.toggleClass('active');

      $(active_panel).show();

      $('.recipe-toggle').on('click', function(e){
          e.preventDefault();
          el = $(this);
          
          $(active_panel).hide();
          panel = el.attr('href');
          $(panel).fadeIn(); 
          active_panel = panel;
          current_active_tab.toggleClass('active');
          el.toggleClass('active');
          current_active_tab = el;

          stored_tab = '#' + el.attr('id');

          localStorage.setItem('active_index', stored_tab);

    
     

          
    })

      
});



</script>


<?php } ?>

<script src="//localhost:35729/livereload.js"></script>

</body>
</html>
