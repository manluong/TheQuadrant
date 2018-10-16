<?php 
add_action( 'wp_enqueue_scripts', 'blueocean_theme_enqueue_styles' );
function blueocean_theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

/**
* Setup My Child Theme's textdomain.
*
* Declare textdomain for this child theme.
* Translations can be filed in the /languages/ directory.
*/
function blueocean_child_theme_setup() {
	load_child_theme_textdomain( 'blueocean-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'blueocean_child_theme_setup' );