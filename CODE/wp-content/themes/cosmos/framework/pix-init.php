<?php
/**
 * Theme init
 *
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme setup
add_action('after_setup_theme', array( 'Cosmos', '[theme.Theme_Init, theme_setup]' ) );

require_once COSMOS_FRAMEWORK_DIR . '/class-cosmos-loader.php';
require_once COSMOS_FRAMEWORK_DIR . '/class-cosmos-config.php';
require_once COSMOS_FRAMEWORK_DIR . '/class-cosmos-params.php';
require_once COSMOS_FRAMEWORK_DIR . '/class-cosmos.php';
require_once COSMOS_THEME_DIR . '/admin/admin-init.php';

/**
 * Theme option function
 */
require_once COSMOS_FRAMEWORK_DIR . '/pix-theme-option.php';

// Setup plugins
require COSMOS_FRAMEWORK_DIR . '/pix-tgm.php';

// Load class
Cosmos::load_class( 'Breadcrumb' );

/**
 * Register sidebars
 */
add_action( 'widgets_init', array('Cosmos', '[widget.Widget_Init, widgets_init]') );

/**
 * Add scripts && css front-end
 */
if( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', array( 'Cosmos', '[theme.Theme_Init, public_enqueue]' ) );
}

require_once COSMOS_FRAMEWORK_DIR . '/pix-functions.php';
require_once COSMOS_FRAMEWORK_DIR . '/pix-menu.php';

// default
/**
 * Customizer additions.
 */
require COSMOS_THEME_DIR . '/inc/customizer.php';