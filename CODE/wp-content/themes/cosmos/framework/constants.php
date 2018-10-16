<?php
/**
 * Constants.
 * 
 * @package Cosmos
 * @since 1.0
 */
defined( 'COSMOS_THEME_VER' )      || define( 'COSMOS_THEME_VER', '1.0.0' );

defined( 'COSMOS_THEME_DIR' )      || define( 'COSMOS_THEME_DIR', get_template_directory() );
defined( 'COSMOS_THEME_URI' )      || define( 'COSMOS_THEME_URI', get_template_directory_uri() );
defined( 'COSMOS_FRAMEWORK_DIR' )  || define( 'COSMOS_FRAMEWORK_DIR', COSMOS_THEME_DIR . '/framework' );
defined( 'COSMOS_REDUX_EXT_DIR' )  || define( 'COSMOS_REDUX_EXT_DIR', get_template_directory() . '/admin/redux-extensions' );

defined( 'COSMOS_MODULES_DIR' )    || define( 'COSMOS_MODULES_DIR', COSMOS_FRAMEWORK_DIR . '/modules' );
defined( 'COSMOS_FRONT_DIR' )      || define( 'COSMOS_FRONT_DIR', COSMOS_FRAMEWORK_DIR . '/modules/front' );
defined( 'COSMOS_PLUGINS_DIR' )    || define( 'COSMOS_PLUGINS_DIR', COSMOS_FRAMEWORK_DIR . '/plugins' );
defined( 'COSMOS_EXTERNAL_DIR' )   || define( 'COSMOS_EXTERNAL_DIR', COSMOS_FRAMEWORK_DIR . '/external' );

defined( 'COSMOS_ADMIN_URI' )      || define( 'COSMOS_ADMIN_URI', COSMOS_THEME_URI . '/assets/admin' );
defined( 'COSMOS_PUBLIC_URI' )     || define( 'COSMOS_PUBLIC_URI', COSMOS_THEME_URI . '/assets/public' );
defined( 'COSMOS_PLUGIN_IMG_URI' ) || define( 'COSMOS_PLUGIN_IMG_URI', COSMOS_THEME_URI . '/assets/admin/images/plugin' );
defined( 'COSMOS_THEME_CORE_URI' ) || define( 'COSMOS_THEME_CORE_URI', WP_PLUGIN_DIR . '/pix-core/' );

defined( 'COSMOS_COPYRIGHT' )      || define( 'COSMOS_COPYRIGHT', esc_html__('&#169; 2017 PIXARTTHEMS', 'cosmos') );
defined( 'COSMOS_LOGO' )           || define( 'COSMOS_LOGO', COSMOS_PUBLIC_URI . '/images/logo/logo-default.png' );
defined( 'COSMOS_LOGO_MOBILE' )    || define( 'COSMOS_LOGO_MOBILE', COSMOS_PUBLIC_URI . '/images/logo/logo-default-mobile.png' );

defined( 'COSMOS_NO_IMG' )         || define( 'COSMOS_NO_IMG', COSMOS_PUBLIC_URI.'/images/thumb-no-image.gif' );
defined( 'COSMOS_NO_IMG_URI' )     || define( 'COSMOS_NO_IMG_URI', COSMOS_PUBLIC_URI.'/images/no-image/' );
defined( 'COSMOS_THEME_PREFIX' )       || define( 'COSMOS_THEME_PREFIX', 'cosmos' );
defined( 'COSMOS_THEME_ADD_INLINE_CSS' )     || define( 'COSMOS_THEME_ADD_INLINE_CSS', COSMOS_THEME_PREFIX . '_add_inline_style' );
defined( 'COSMOS_THEME_ADD_INLINE_SCRIPT' )     || define( 'COSMOS_THEME_ADD_INLINE_SCRIPT', COSMOS_THEME_PREFIX . '_add_inline_script' );

//*********************Plugin***************************
//Active pix-core Plugin - COSMOS_CORE_VERSION
if( defined( 'COSMOS_CORE_VERSION' ) ) {
	define( 'COSMOS_CORE_IS_ACTIVE', defined( 'COSMOS_CORE_VERSION' ) );
}
else {
	define( 'COSMOS_CORE_IS_ACTIVE', '' );
}
//ReduxFrameworkPlugin
defined( 'COSMOS_REDUX_ACTIVE' )     || define( 'COSMOS_REDUX_ACTIVE', class_exists( 'ReduxFrameworkPlugin' ) );

//Active RS
if( defined( 'RS_PLUGIN_PATH' ) ) {
	define( 'COSMOS_REVSLIDER_ACTIVE', defined( 'RS_PLUGIN_PATH' ) );
}
else {
	define( 'COSMOS_REVSLIDER_ACTIVE', '' );
}

//Active ContactForm7 Plugin
if( defined( 'WPCF7_LOAD_JS' ) ) {
	define( 'COSMOS_WPCF7_ACTIVE', defined( 'WPCF7_LOAD_JS' ) );
}
else {
	define( 'COSMOS_WPCF7_ACTIVE', '' );
}
//Active Woocommerce Plugin
defined( 'COSMOS_WOOCOMMERCE_ACTIVE' )     || define( 'COSMOS_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );

defined( 'COSMOS_WOOCOMMERCE_WISHLIST' )   || define( 'COSMOS_WOOCOMMERCE_WISHLIST', class_exists( 'YITH_WCWL_Shortcode' ) );


// Active Newsletter Plugin
if( defined( 'NEWSLETTER_VERSION' ) ) {
	define( 'COSMOS_NEWSLETTER_ACTIVE', defined( 'NEWSLETTER_VERSION' ) );
}
else {
	define( 'COSMOS_NEWSLETTER_ACTIVE', '' );
}

//Active Latest Tweets Widget Plugin
defined( 'COSMOS_LATEST_TWEETS_ACTIVE' )   || define( 'COSMOS_LATEST_TWEETS_ACTIVE', class_exists( 'Latest_Tweets_Widget' ) );

