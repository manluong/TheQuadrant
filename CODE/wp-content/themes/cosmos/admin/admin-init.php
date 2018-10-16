<?php
// Load Redux extensions - MUST be loaded before your options are set
if ( COSMOS_REDUX_ACTIVE && COSMOS_CORE_IS_ACTIVE && file_exists( COSMOS_THEME_CORE_URI.'/extensions/extensions-init.php')) {
	require_once COSMOS_THEME_CORE_URI.'/extensions/extensions-init.php';
}

// Load the theme/plugin options
if ( COSMOS_REDUX_ACTIVE && file_exists( COSMOS_THEME_DIR.'/admin/options-init.php')) {
	require_once COSMOS_THEME_DIR.'/admin/options-init.php';
}