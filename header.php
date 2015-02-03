<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package dteskitchen
 */
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel='stylesheet' id='dteskitchen-style-css'  href='<?php echo get_template_directory_uri(); ?>/css/build/global.css' type='text/css' media='all' />
<link rel="Shortcut Icon" href="http://dteskitchentables.org/wp-content/themes/structure_blog_full/images/favicon.ico" type="image/x-icon" />

<script>
  document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/g, '') + 'js';
  </script>
<script type="text/javascript" src="//use.typekit.net/cbi6aga.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

<?php if ( is_user_logged_in() ) { ?>
 
<style type="text/css" media="screen">
  html { margin-top: 32px !important; }
  * html body { margin-top: 32px !important; }
  @media screen and ( max-width: 782px ) {
    html { margin-top: 46px !important; }
    * html body { margin-top: 46px !important; }
  }

</style>
  
<?php } ?>


</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

<a href="<?php echo get_site_url(); ?>">
	<header id="masthead" class="site-header" role="banner">
    <div class="a-wrapper">
  

		<div class="masthead-subhead"><a class="masthead-link" href="http://potluckcatering.org/">Potluck Cafe Society</a> Presents</div>
    <h1><a href="/" class="masthead-home-link">Recipe Bank</a></h1>
    <div class="masthead-subhead">A <a class="masthead-link" href="http://dteskitchentables.org">DTES Kitchen Tables</a> Tool</div>
  </div><!---wrap-->
	</header><!-- #masthead -->
</a>
	<div id="content" class="site-content">
