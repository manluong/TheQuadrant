<?php
/**
 * Header Content
 */
$show_header = Cosmos::get_option('pix-header-show');
$page_options = get_post_meta( get_the_ID(), 'cosmos_page_options', true );
$this->get_field( $page_options, 'header_logo' );
$show_laguage_switcher = Cosmos::get_option('pix-language-switcher');

if ( $show_header == '1' ) {

	$show_search  =  Cosmos::get_option('pix-header-search-icon');
	$header_logo_url  = Cosmos::get_option( 'pix-logo-header', 'url' );
	if( empty($header_logo_url) ) {
		$header_logo_data = '<span class="cosmos-name">' .get_bloginfo( 'name', 'display' ) . '</span>';
	} else {
		$header_logo_data = '<img src="'. esc_url($header_logo_url).'" alt="logo">';
	}

	$header_full_1920 = Cosmos::get_option('pix-header-full-1920');
	$class_header_full_1920 = '';
	if ($header_full_1920 == 1) {
		$class_header_full_1920 = 'col-full-1920';
	}

	$fixed_menu = Cosmos::get_option('pix-sticky');
	$class_fixed_menu = 'bg-tam';
	if ($fixed_menu == 1) {
		$class_fixed_menu = 'blk-menu-fix bg-tam';
	}

	if ($header_full_1920 == 1 && $fixed_menu == 1) {
		$class_header_full_1920 = 'col-full-1920 ';
		$class_fixed_menu = 'blk-menu-fix bg-tam';
	}
	if ($header_full_1920 == 1 && $fixed_menu != 1) {
		$class_header_full_1920 = 'col-full-1920 bg-tam';
		$class_fixed_menu = '';
	}

	/************************* Layout **************************/
	$template = Cosmos::get_option( 'pix-header-layout' );

	$layouts = array('one');
	if( ! in_array( $template , $layouts)) {
		$template = 'one';
	}
	
	$menu_style = Cosmos::get_option( 'pix-menu-style' );
	$menu_arr = array('1','2','3','4','5');
	if ( !in_array( $menu_style , $menu_arr) ) {
		$menu_style = '1';
	}

	include locate_template('inc/header/header-' . $template . '.php');
}

