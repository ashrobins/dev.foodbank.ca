<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package dteskitchen
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">

<link rel='stylesheet' id='dteskitchen-style-css'  href='<?php echo get_template_directory_uri(); ?>/css/build/global.css' type='text/css' media='all' />
<script type="text/javascript" src="//use.typekit.net/cbi6aga.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
<a href="<?php echo get_site_url(); ?>">
	<header id="masthead" class="site-header" role="banner">
		<h1><img src="<?php echo get_template_directory_uri(); ?>/img/logo.png">Recipe Bank</h1>

	</header><!-- #masthead -->
</a>
	<div id="content" class="site-content">
