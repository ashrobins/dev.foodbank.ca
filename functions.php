<?php
/**
 * dteskitchen functions and definitions
 *
 * @package dteskitchen
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

// Hacky way of getting rid of width/height in featured image
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );

function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

if ( ! function_exists( 'dteskitchen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function dteskitchen_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on dteskitchen, use a find and replace
	 * to change 'dteskitchen' to the name of your theme in all the template files
	 */
	// load_theme_textdomain( 'dteskitchen', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'dteskitchen' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );



	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
	) );
}
endif; // dteskitchen_setup
add_action( 'after_setup_theme', 'dteskitchen_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function dteskitchen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'dteskitchen' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'dteskitchen_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function dteskitchen_scripts() {
	wp_enqueue_style( 'dteskitchen-style', get_stylesheet_uri() );

	wp_enqueue_script( 'dteskitchen-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'dteskitchen-skip-link-focus-fix', get_template_directory_uri() . '/js/build/production.min.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dteskitchen_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

require get_template_directory() . '/inc/recipebank.php';


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Set up recipe cloning script - but only on recipe pages
 * TODO: This should probably be moved to a plugin.
 */

add_action( 'admin_print_scripts-post-new.php', 'recipe_clone_script', 11 );
add_action( 'admin_print_scripts-post.php', 'recipe_clone_script', 11 );

function recipe_clone_script() {
    global $post_type;
    if( 'recipe' == $post_type )
    wp_enqueue_script( 'recipe-clone-script', get_stylesheet_directory_uri() . '/js/clonerecipe.js' );
}

function iconify($icon) {
	echo get_template_directory_uri() .'/img/' . $icon . '.svg';
}




