<?php
/**
 * Cosmos functions and definitions
 *
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 * */
clearstatcache();

function cosmos_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cosmos_content_width', 1024 );
}
add_action( 'after_setup_theme', 'cosmos_content_width', 0 );
// load constants
require_once ( get_template_directory() . '/framework/constants.php' );

// load textdomain
load_theme_textdomain( 'cosmos', COSMOS_THEME_DIR . '/languages' );

/* Theme Initialization */
require_once( COSMOS_FRAMEWORK_DIR . '/pix-init.php' );

$app = Cosmos::new_object('Application');
$app->run();