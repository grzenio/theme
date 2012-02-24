<?php
//Some simple code for our widget-enabled sidebar
if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
        'name' => 'Main Sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}

//Add support for WordPress 3.0's custom menus
add_action( 'init', 'register_my_menu' );

//Register area for custom menu
function register_my_menu() {
	register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
}

//Code for custom background support
add_custom_background();

//Enable post and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );
remove_action('wp_head', 'wp_generator');

// Enable post thumbnails
add_theme_support('post-thumbnails');
set_post_thumbnail_size(520, 250, true);

function html5_scripts()  
{  
	wp_register_script( 'modernizr', get_template_directory_uri() . '/js/libs/modernizr-2.5.2.min.js' );  
	wp_enqueue_script( 'modernizr' );  
}  
add_action( 'wp_enqueue_scripts', 'html5_scripts', 1 );  

function jq() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', false, '1.7.1', true);
	wp_enqueue_script('jquery');
	
	wp_register_script( 'plugins', get_template_directory_uri() . '/js/plugins.js', false, '1.7.1', true);
	wp_enqueue_script('plugins');
	
	wp_register_script( 'scripts', get_template_directory_uri() . '/js/script.js', false, '1.7.1', true);
	wp_enqueue_script('scripts');
}    

add_action('wp_enqueue_scripts', 'jq');





?>