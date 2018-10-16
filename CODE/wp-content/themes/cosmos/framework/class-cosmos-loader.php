<?php
/**
 * Cosmos loader class.
 * 
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
class Cosmos_Loader {
	public static function run(){
		// Register widgets
		add_action( 'widgets_init', array( 'Cosmos', '[widget.Widget_Init, load]') );
		// action inline css
		add_action( 'cosmos_add_inline_style',     array( 'Cosmos', '[theme.Theme_Init, add_inline_style]') );
		// action inline script
		add_action( 'cosmos_add_inline_script',     array( 'Cosmos', '[theme.Theme_Init, add_inline_script]') );
		// get page options
		add_action( 'cosmos_page_options',         array( 'Cosmos', '[theme.Theme_Init, get_page_options]') );
		// show index content
		add_action( 'cosmos_show_index',           array( 'Cosmos', '[front.Top_Controller, show_post_index]') );
		// team archive
		add_action( 'cosmos_show_team_archive',    array( 'Cosmos', '[front.Top_Controller, show_team_archive]') );
		
		add_action( 'cosmos_show_header',         array( 'Cosmos', '[front.Top_Controller, header]') );
		add_action( 'cosmos_show_footer',         array( 'Cosmos', '[front.Top_Controller, footer_main]'));
		add_action( 'cosmos_show_breadcrumb',     array( 'Cosmos', '[front.Top_Controller, breadcrumb]') );
		add_action( 'cosmos_entry_thumbnail',     array( 'Cosmos', '[front.Top_Controller, show_post_entry_thumbnail]') );
		add_action( 'cosmos_entry_video',         array( 'Cosmos', '[front.Top_Controller, show_post_entry_video]') );
		add_action( 'cosmos_entry_meta',          array( 'Cosmos', '[front.Top_Controller, show_post_entry_meta]') );
		add_action( 'cosmos_tags_meta',           array( 'Cosmos', '[front.Top_Controller, show_post_tags_meta]') );
		add_action( 'cosmos_categories_meta',     array( 'Cosmos', '[front.Top_Controller, show_post_category_meta]') );
		add_action( 'cosmos_show_page_title',     array( 'Cosmos', '[front.Top_Controller, show_page_title]') );
		add_action( 'cosmos_show_slider',         array( 'Cosmos', '[front.Top_Controller, show_slider]') );
		add_action( 'cosmos_related_post',        array( 'Cosmos', '[front.Top_Controller, show_related_post]') );
		add_action( 'cosmos_post_author',         array( 'Cosmos', '[front.Top_Controller, show_post_author]') );
		add_action( 'cosmos_post_author_list',    array( 'Cosmos', '[front.Top_Controller, show_author_list]') );
		
		add_action( 'cosmos_show_frm_comment',    array( 'Cosmos', '[front.Top_Controller, show_frm_comment]') );
		add_action( 'cosmos_show_help_link',      array( 'Cosmos', '[front.Top_Controller, show_help_link]') );
		
		// share post
		add_action( 'cosmos_share_link',          array( 'Cosmos', '[front.Top_Controller, get_share_link]') );
		
		// login
		add_action( 'cosmos_login_link',          array( 'Cosmos', '[front.Top_Controller, show_login_link]') );

		// subcribe
		add_action( 'cosmos_subcribe',            array( 'Cosmos', '[front.Top_Controller, show_subcribe]') );
	}
	
	/**
	 * Fires after WordPress has finished loading but before any headers are sent.
	 */
	public static function init(){
		// Regist Menu
		register_nav_menu( 'main-nav',     esc_html__( 'Main Navigation', 'cosmos' ) );
		register_nav_menu( 'footer-nav',   esc_html__( 'Footer Navigation', 'cosmos' ) );
		register_nav_menu( 'page-404-nav', esc_html__( '404 Navigation', 'cosmos' ) );
		
		// Ajax
		add_action( 'wp_ajax_cosmos',        array( 'Cosmos', '[Application, ajax]' ) );
		add_action( 'wp_ajax_nopriv_cosmos', array( 'Cosmos', '[Application, ajax]' ) );
		
		// Welcome page
		add_action( 'admin_menu', array( 'Cosmos', '[theme.Theme_Controller, add_welcome]' ) );
		add_action( 'admin_init', array( 'Cosmos', '[theme.Theme_Controller, call_tgm_plugin_action]' ) );
		
		// Add sidebar area
		add_action( 'admin_print_scripts',                array( 'Cosmos', '[theme.Widget_Init, add_widget_field]' ) );
		add_action( 'load-widgets.php',                   array( 'Cosmos', '[widget.Widget_Init, add_sidebar_area]' ) );
		add_action( 'wp_ajax_cosmos_del_custom_sidebar', array( 'Cosmos', '[widget.Widget_Init, delete_custom_sidebar]' ) );
	}
	
	/**
	 * It is triggered before any other hook when a user accesses the admin area. 
	 */
	public static function admin(){
		// add action
		add_action( 'save_post',             array( 'Cosmos', '[Application, save]' ) );
		add_action( 'admin_enqueue_scripts', array( 'Cosmos', '[theme.Theme_Init, admin_enqueue]' ) );
		
		// init page options
		add_action( 'cosmos_init_page_setting',   array( 'Cosmos', '[theme.Theme_Init, init_page_setting]' ) );
		do_action(  'cosmos_init_page_setting');
		
		// save_page
		add_action( 'cosmos_save_page',           array( 'Cosmos', '[theme.Theme_Init, save_page]') );
		
		// add mbox page options
		add_action( 'cosmos_metabox_pageoption',  array( 'Cosmos', '[theme.Theme_Init, add_page_options]' ) );
		do_action(  'cosmos_metabox_pageoption' );
		
		add_action( 'cosmos_get_theme_header',    array( 'Cosmos', '[theme.Theme_Controller, get_theme_header]') );
	}
}