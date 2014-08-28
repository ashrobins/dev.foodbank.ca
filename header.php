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
<script>
  document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/g, '') + 'js';
  </script>
<script type="text/javascript" src="//use.typekit.net/cbi6aga.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
<a href="<?php echo get_site_url(); ?>">
	<header id="masthead" class="site-header" role="banner">
<!--       <img src="<?php echo get_template_directory_uri(); ?>/img/logo.png"> -->
		<div class="masthead-subhead">Potluck Cafe Society Presents</div>
    <h1>Recipe Bank</h1>
    <div class="masthead-subhead">A DTES Kitchen Tables Tool</div>

	</header><!-- #masthead -->
</a>
	<div id="content" class="site-content">
