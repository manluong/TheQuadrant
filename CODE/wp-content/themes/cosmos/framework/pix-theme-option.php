<?php
/**
 * Dynamic css from theme options - Output will be included into end of head tag
 *
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
function cosmos_dynamic_css() {

	// page options
	do_action('cosmos_page_options');
	$content = "";
	$content_desktop = "";

	// page padding ( top, bottom ) 
	$content_ptop    = Cosmos::get_option('pix-content-padding-top');
	$content_pbottom = Cosmos::get_option('pix-content-padding-bottom');
	$content_pbottom = str_replace('px', '', $content_pbottom);
	$content_ptop = str_replace('px', '', $content_ptop);
	if( is_numeric( $content_ptop ) ) {
		$content_ptop = 'padding-top:'.$content_ptop.'px;';
	} else {
		$content_ptop = '';
	}
	if( is_numeric( $content_pbottom ) ) {
		$content_pbottom = 'padding-bottom:'.$content_pbottom.'px;';
	} else {
		$content_pbottom = '';
	}
	
	$content .= '#page-wrapper .page-detail {'.esc_attr($content_ptop).esc_attr($content_pbottom).'}';

	/*General*/
	
	$boxed_layout   = Cosmos::get_option('pix-layout');
	$boxed_bg       = Cosmos::get_option('pix-layout-boxed-bg');
	$back_to_top    = Cosmos::get_option('pix-backtotop');
	$back_to_top_image = Cosmos::get_option('pix-backtotop-image');
	// back to top button
	if( !empty($back_to_top) && $back_to_top_image ){
		$content .= '.back-on-top { background-image: url('.esc_url($back_to_top_image['url']).'); }';
	}
	// body background
	if ( $boxed_bg ) {
		$bg_image = '';
		if( !empty($boxed_bg['background-image']) ) {
			$bg_image = 'background-image: url("'.esc_url($boxed_bg['background-image']).'");';
		}
		if ( !empty($boxed_bg['background-color']) || $bg_image ) {
			$content .= 'body {background-color: ' .esc_attr($boxed_bg['background-color']). ';'.$bg_image.'background-repeat: ' .esc_attr($boxed_bg['background-repeat']). ';background-attachment: ' .esc_attr($boxed_bg['background-attachment']). ';background-position:'.esc_attr($boxed_bg['background-position']).';background-size:'.esc_attr($boxed_bg['background-size']).';}';
		}
	}
	
	/* Header */
	$header_bg_color   = Cosmos::get_option('pix-header-bg-color');
	$header_bg_color_scroll   = Cosmos::get_option('pix-header-bg-color-scroll');
	if ( !empty($header_bg_color_scroll) ) {
		if (is_array($header_bg_color_scroll) && isset($header_bg_color_scroll['rgba'])) {
			$header_bg_color_scroll_result = $header_bg_color_scroll['rgba'];
		} else {
			$header_bg_color_scroll_result = $header_bg_color_scroll;
		}
		$content .= 'header .cosmos-header .bg-tam, header .cosmos-header.bg-tam, header .cosmos-header .bg-tam.is_scroll, header .cosmos-header .bg-tam.is_open_menu_mb { background-color:'.esc_attr($header_bg_color_scroll_result).'}';
	}
	if ( !empty($header_bg_color) ) {
		if ( is_array($header_bg_color) && isset($header_bg_color['rgba']) ) {
			$header_bg_color_result = $header_bg_color['rgba'];
		} else {
			$header_bg_color_result = $header_bg_color;
		}
		$content_desktop .= 'header .cosmos-header .bg-tam, header .cosmos-header.bg-tam { background-color:'.esc_attr($header_bg_color_result).'}';
	}
 
	/* Menu */
	$menu_text   = Cosmos::get_option('pix-menu-item-text');
	$menu_custom = Cosmos::get_option('pix-menu-custom');

	// main menu
	if(!empty($menu_text)){
		$content .= 'header .cosmos-header .menu-head-page > ul > .menu__item > .menu__link {color:'.esc_attr($menu_text['regular']).'}';

		$content .= 'header .cosmos-header .menu-head-page > ul .menu__item.active > .menu__link,
					header .cosmos-header .menu-head-page ul .menu__item.active:hover > .menu__link {color:'.esc_attr($menu_text['active']).';}';
		$content .= 'header .cosmos-header .menu-head-page > ul > .menu__item:hover > .menu__link{ color:'.esc_attr($menu_text['hover']).'}';

		$content .= '.commont-menu.navi-type-1 .menu-head-page .menu__item.active:before, 
					.commont-menu.navi-type-1 .menu-head-page .menu__item.active:after, 
					.commont-menu.navi-type-1 .menu-head-page .menu__item.active .menu__link:before, 
					.commont-menu.navi-type-1 .menu-head-page .menu__item.active .menu__link:after,
					.commont-menu.navi-type-1 .menu-head-page .menu__item:hover > a:before, 
					.commont-menu.navi-type-1 .menu-head-page .menu__item:hover > a:after, 
					.commont-menu.navi-type-1 .menu-head-page .menu__item:hover:after, 
					.commont-menu.navi-type-1 .menu-head-page .menu__item:hover:before
					{ background-color: '.esc_attr($menu_text['hover']).'}';
		$content .= '.commont-menu.navi-type-1 .menu-head-page .menu__item.active:before, 
					.commont-menu.navi-type-1 .menu-head-page .menu__item.active:after, 
					.commont-menu.navi-type-1 .menu-head-page .menu__item.active .menu__link:before, 
					.commont-menu.navi-type-1 .menu-head-page .menu__item.active .menu__link:after						
					{ background-color: '.esc_attr($menu_text['active']).'}';

		$content .= 'header .commont-menu.navi-type-3 .menu-des > li.dot_slide span {background-color:'.esc_attr($menu_text['regular']).'}';

		$content .= 'header .commont-menu.navi-type-4 .menu-des > li.menu__item > .menu__link:before,
					header .commont-menu.navi-type-4 .menu-des > li.menu__item > .menu__link:after {border-color:'.esc_attr($menu_text['regular']).'}';
		$content .= 'header .commont-menu.navi-type-4 .menu-des > li.menu__item:hover > .menu__link:before,
					header .commont-menu.navi-type-4 .menu-des > li.menu__item:hover > .menu__link:after {border-color:'.esc_attr($menu_text['hover']).'}';
		$content .= 'header .commont-menu.navi-type-4 .menu-des > li.menu__item.active > .menu__link:before,
					header .commont-menu.navi-type-4 .menu-des > li.menu__item.active > .menu__link:after {border-color:'.esc_attr($menu_text['active']).'}';

		$content .= 'header .commont-menu.navi-type-5 .menu-des > li.menu__item > .menu__link:after {background-color:'.esc_attr($menu_text['regular']).'}';
		$content .= 'header .commont-menu.navi-type-5 .menu-des > li.menu__item:hover > .menu__link:after {background-color:'.esc_attr($menu_text['hover']).'}';
		$content .= 'header .commont-menu.navi-type-5 .menu-des > li.menu__item.active > .menu__link:after {background-color:'.esc_attr($menu_text['active']).'}';
	}
	
	// mega menu
	$mega_custom            = Cosmos::get_option('pix-megamenu-custom');
	$megamenu_bg       		= Cosmos::get_option('pix-megamenu-bg');
	$megamenu_item_bg       = Cosmos::get_option('pix-megamenu-item-bg');
	$megamenu_border   		= Cosmos::get_option('pix-megamenu-border');
	$megamenu_item_border   = Cosmos::get_option('pix-megamenu-item-border');
	$megamenu_color    		= Cosmos::get_option('pix-megamenu-color');
	$megamenu_padding  		= Cosmos::get_option('pix-megamenu-padding');

	if($mega_custom){
		if(!empty($megamenu_padding)){
			$content .='.mega-menu-content .dropdown-menu .link-page{'
			.'padding-right:'.esc_attr($megamenu_padding['padding-right'])
			.';padding-left:'.esc_attr($megamenu_padding['padding-left']).';'
			.'padding-top:'.esc_attr($megamenu_padding['padding-top'])
			.';padding-bottom:'.esc_attr($megamenu_padding['padding-bottom']).';}';
		}

		if($megamenu_color){
			$content .='.mega-menu-content .dropdown-menu .link-page{'
			.'color:'.esc_attr($megamenu_color['regular']).';}';
			$content.= '.mega-menu-content .dropdown-menu .link-page:hover{color:'.esc_attr($megamenu_color['hover']).';}';
		}
	
		if(!empty($megamenu_border)){
			$content.= '.mega-menu-content {border-bottom: '.esc_attr($megamenu_border['border-bottom']).' '.esc_attr($megamenu_border['border-style']).' '.esc_attr($megamenu_border['border-color']).'}';
		}
		
		if(!empty($megamenu_item_border)){
			$content.= '.mega-menu-content li {border-top: '.esc_attr($megamenu_item_border['border-bottom']).' '.esc_attr($megamenu_item_border['border-style']).' '.esc_attr($megamenu_item_border['border-color']).'}';
		}
		
		if($megamenu_bg['rgba']){
			$content.= '.mega-menu:hover .mega-menu-content{background-color:'.esc_attr($megamenu_bg['rgba']).'}';
		}
		if($megamenu_item_bg['rgba']){
			$content.= '.mega-menu:hover .mega-menu-content .dropdown-menu li{background-color:'.esc_attr($megamenu_item_bg['rgba']).'}';
		}
		
	}
	
	//drop down
	$submenu_bg        = Cosmos::get_option('pix-submenu-bg');
	$submenu_bg_hover        = Cosmos::get_option('pix-submenu-bg-hover');
	$custom_dropdown   = Cosmos::get_option('pix-dropdown-custom');
	$submenu_border    = Cosmos::get_option('pix-submenu-border');
	$submenu_color     = Cosmos::get_option('pix-submenu-color');
	$submenu_padding   = Cosmos::get_option('pix-submenu-padding');
	$submenu_1_width   = Cosmos::get_option('pix-submenu1-width');
	$submenu_2_width   = Cosmos::get_option('pix-submenu2-width');

	if ($custom_dropdown == '1'){
		if( isset($submenu_bg['rgba']) && $submenu_bg['rgba']){
			$content .= '.cosmos-header .parent-sub-menu > li {background-color:'.esc_attr($submenu_bg['rgba']).';}';
		}
		if( isset($submenu_bg_hover['rgba']) && $submenu_bg_hover['rgba']){
			$content .= '.cosmos-header .parent-sub-menu > li:hover {background-color:'.esc_attr($submenu_bg_hover['rgba']).';}';
		}
		if(!empty($submenu_color['regular'])){
			$content .= '.cosmos-header .menu-head-page ul.menu-des .parent-sub-menu a {color:'.esc_attr($submenu_color['regular']).';}';
		}
		if(!empty($submenu_color['hover'])){
			$content .= '.cosmos-header .menu-head-page ul.menu-des .parent-sub-menu li:hover > a{color:'.esc_attr($submenu_color['hover']).'}';
		}
		if($submenu_padding){
			$content .= '.cosmos-header .menu-head-page ul.menu-des .parent-sub-menu a {'
				.'padding-right:'.esc_attr($submenu_padding['padding-right'])
				.';padding-left:'.esc_attr($submenu_padding['padding-left']).';'
				.'padding-top:'.esc_attr($submenu_padding['padding-top'])
				.';padding-bottom:'.esc_attr($submenu_padding['padding-bottom']).';}';
		}
		if ( !empty($submenu_1_width) && is_array($submenu_1_width) ) {
			$content .= '.cosmos-header .menu-head-page ul.menu-des .parent-sub-menu {width:'.esc_attr($submenu_1_width['width']).'}';
		}
		if ( !empty($submenu_2_width) && is_array($submenu_2_width) ) {
			$content .= '.cosmos-header .menu-head-page ul.menu-des .parent-sub-menu .parent-sub-menu {width:'.esc_attr($submenu_2_width['width']).'}';
		}
	}
	
	/* Page Title */
	$typo_arr = array(
		'font-weight'		=> '',
		'font-size'			=> '',
		'text-transform'	=> '',
	);
	$page_title_show	= Cosmos::get_option('pix-page-title-show');
	$page_title_bg		= Cosmos::get_option('pix-page-title-bg');
	$page_title_height	= Cosmos::get_option('pix-page-title-height', 'height');
	$page_title_align	= Cosmos::get_option('pix-page-title-align');
	$bc_typo			= Cosmos::get_option('pix-breadcrumb-path');
	$bc_typo_hv			= Cosmos::get_option('pix-breadcrumb-path-hover');
	$bc_typo2			= Cosmos::get_option('pix-breadcrumb-path2');
	$title_typo			= Cosmos::get_option('pix-pagetitle-title');
	$bc_icon_next_color	= Cosmos::get_option('pix-breadcrumb-icon-color');
	if ( is_array($title_typo) ) {
		$title_typo			= array_merge($typo_arr, $title_typo);
	}
	if ( is_array($bc_typo) ) {
		$bc_typo			= array_merge($typo_arr, $bc_typo);
	}
	if ( is_array($bc_typo2) ) {
		$bc_typo2			= array_merge($typo_arr, $bc_typo2);
	}
	if($page_title_height){
		$content_desktop .= '.page-title-banner .page-title-wrapper {height: '.esc_attr($page_title_height).';}';
	}
	
	if ( $page_title_show == '1' ) {
		if( $page_title_bg ) {
			$bg_image = '';
			if( $page_title_bg['background-image'] ) {
				$bg_image = 'background-image: url("' .esc_url($page_title_bg['background-image']). '");';
			}
			$content .= '.page-title-banner{background-color: ' .esc_attr($page_title_bg['background-color']). ';' . $bg_image . 'background-repeat: ' .esc_attr($page_title_bg['background-repeat']). ';background-attachment: ' .esc_attr($page_title_bg['background-attachment']). ';background-position:'.esc_attr($page_title_bg['background-position']).';background-size:'.esc_attr($page_title_bg['background-size']).';}';
		}
		if ( !empty($page_title_align) ) {
			$content_desktop .= '.page-title-banner .page-link, .page-title-banner .title-page {text-align:'.esc_attr($page_title_align).';}';
		}
		// title
		if(!empty($title_typo)){
			$content .= '.page-title-banner .title-page {color:'.esc_attr($title_typo['color']).';font-weight:'.esc_attr($title_typo['font-weight']).';text-transform:'.esc_attr($title_typo['text-transform']).';}';

			$content_desktop .= '.page-title-banner .title-page {font-size:'.esc_attr($title_typo['font-size']).';}';
		}
		if($bc_icon_next_color){
			$content .= '.page-title-banner .page-link li {border-color:'.esc_attr($bc_icon_next_color).';}';
		}
		if(!empty($bc_typo)){
			$content .= '.page-title-banner .page-link .link {color:'.esc_attr($bc_typo['color']).';font-weight:'.esc_attr($bc_typo['font-weight']).';text-transform:'.esc_attr($bc_typo['text-transform']).';}';

			$content_desktop .= '.page-title-banner .page-link .link {font-size:'.$bc_typo['font-size'].';}';
		}
		if(!empty($bc_typo_hv)){
			$content .= '.page-title-banner .page-link .link:hover {color:'.esc_attr($bc_typo_hv['color']).';}';
		}
		if(!empty($bc_typo2)){

			$content .= '.page-title-banner .page-link .link.active, .page-title-banner .page-link .link.active:hover{color:'.esc_attr($bc_typo2['color']).';font-weight:'.esc_attr($bc_typo2['font-weight']).';text-transform:'.esc_attr($bc_typo2['text-transform']).';}';

			$content_desktop .= '.page-title-banner .page-link .link.active, .page-title-banner .page-link .link.active:hover {font-size:'.esc_attr($bc_typo2['font-size']).';}';
		}
		
	}

	/* Footer general*/
	// Subcribe
	$subcribe_bg     = Cosmos::get_option('pix-footer-subcribe-bg');
	
	if( !empty($subcribe_bg)){
		$content .='.footer-subcrible {background-color:'.esc_attr($subcribe_bg).' ;}';
	}

	$footer_show     = Cosmos::get_option('pix-footer-show');

	/*footer section*/
	$footer_mask     = Cosmos::get_option('pix-footer-mask');
	$footer_bg       = Cosmos::get_option('pix-footer-bg');

	if( !empty($footer_mask['rgba'])){
			$content .='footer:before {background-color:'.esc_attr($footer_mask['rgba']).' ;}';
	}

	if(!empty($footer_bg)){
		$footer_bg_image = '';
		if( $footer_bg['background-image'] ) {
			$footer_bg_image = 'background-image: url("' .esc_url($footer_bg['background-image']). '");';
		}
		if ( !empty($footer_bg['background-color']) || $footer_bg_image ) {
			$content .= 'footer {background-color: ' .esc_attr($footer_bg['background-color']). ';' . $footer_bg_image . 'background-repeat: ' .esc_attr($footer_bg['background-repeat']). ';background-attachment: ' .esc_attr($footer_bg['background-attachment']). ';background-position:'.esc_attr($footer_bg['background-position']).';background-size:'.esc_attr($footer_bg['background-size']).';}';
		}
	}
	
	/*footer top*/
	$footer_mask_top     = Cosmos::get_option('pix-footer-top-mask');
	$footer_bg_top       = Cosmos::get_option('pix-footer-top-bg');
	$footer_color_top    = Cosmos::get_option('pix-footer-top-font-color');

	if( !empty($footer_mask_top['rgba'])){
			$content .='.footer-top:before {background-color:'.esc_attr($footer_mask_top['rgba']).' ;}';
	}

	if(!empty($footer_bg_top)){
		$footer_bg_top_image = '';
		if( $footer_bg_top['background-image'] ) {
			$footer_bg_top_image = 'background-image: url("' .esc_url($footer_bg_top['background-image']). '");';
		}
		if ( !empty($footer_bg_top['background-color']) || $footer_bg_top_image ) {
			$content .= '.footer-top{background-color: ' .esc_attr($footer_bg_top['background-color']). ';' . $footer_bg_top_image . 'background-repeat: ' .esc_attr($footer_bg_top['background-repeat']). ';background-attachment: ' .esc_attr($footer_bg_top['background-attachment']). ';background-position:'.esc_attr($footer_bg_top['background-position']).';background-size:'.esc_attr($footer_bg_top['background-size']).';}';
		}
	}
	if ( !empty($footer_color_top) && is_array($footer_color_top) ) {
		if ( !empty($footer_color_top['regular']) ) {
			$content .='.footer-top, .footer-top p, .footer-top span, .footer-top a, .footer-top a:before, .footer-top i, .footer-top li {color:'.esc_attr($footer_color_top['regular']).' !important;}';
		}
		if ( !empty($footer_color_top['hover']) ) {
			$content .='.footer-top a:hover, .footer-top a:hover:before, .footer-top i:hover {color:'.esc_attr($footer_color_top['hover']).' !important; }';
		}
	}

	/*footer main*/
	$footer_mask_main     = Cosmos::get_option('pix-footer-main-mask');
	$footer_bg_main       = Cosmos::get_option('pix-footer-main-bg');
	$footer_color_main    = Cosmos::get_option('pix-footer-main-font-color');

	if( !empty($footer_mask_main['rgba'])){
			$content .='.footer-main:before {background-color:'.esc_attr($footer_mask_main['rgba']).' ;}';
	}
	if(!empty($footer_bg_main)){
		$footer_bg_main_image = '';
		if( $footer_bg_main['background-image'] ) {
			$footer_bg_main_image = 'background-image: url("' .esc_url($footer_bg_main['background-image']). '");';
		}
		if ( !empty($footer_bg_main['background-color']) || $footer_bg_main_image ) {
			$content .= '.footer-main{background-color: ' .esc_attr($footer_bg_main['background-color']). ';' . $footer_bg_main_image . 'background-repeat: ' .esc_attr($footer_bg_main['background-repeat']). ';background-attachment: ' .esc_attr($footer_bg_main['background-attachment']). ';background-position:'.esc_attr($footer_bg_main['background-position']).';background-size:'.esc_attr($footer_bg_main['background-size']).';}';
		}
	}
	if ( !empty($footer_color_main) && is_array($footer_color_main) ) {
		if ( !empty($footer_color_main['regular']) ) {
			$content .='.footer-main, .footer-main p, .footer-main span, .footer-main a, .footer-main a:before, .footer-main i, .footer-main li {color:'.esc_attr($footer_color_main['regular']).' !important;}';
		}
		if ( !empty($footer_color_main['hover']) ) {
			$content .='.footer-main a:hover, .footer-main a:hover:before, .footer-main i:hover {color:'.esc_attr($footer_color_main['hover']).' !important; }';
		}
	}

	/*footer bottom*/
	$footer_mask_main     	= Cosmos::get_option('pix-footer-bottom-bg-color');
	$footer_color_bottom    = Cosmos::get_option('pix-footer-bottom-font-color');

	if( !empty($footer_mask_main['rgba'])){
		$content .='.footer-bottom {background-color:'.esc_attr($footer_mask_main['rgba']).' ;}';
	}
	if ( !empty($footer_color_bottom) && is_array($footer_color_bottom) ) {
		if ( !empty($footer_color_bottom['regular']) ) {
			$content .='.footer-bottom, .footer-main p, .footer-bottom span, .footer-bottom a, .footer-bottom a:before, .footer-bottom i, .footer-bottom li {color:'.esc_attr($footer_color_bottom['regular']).' !important;}';
		}
		if ( !empty($footer_color_bottom['hover']) ) {
			$content .='.footer-bottom a:hover, .footer-bottom a:hover:before, .footer-bottom i:hover {color:'.esc_attr($footer_color_bottom['hover']).' !important; }';
		}
		if ( !empty($footer_color_bottom['active']) ) {
			$content .='.footer-bottom a.active, .footer-bottom .active a, .footer-bottom .active a:before, .footer-bottom a.active:before {color:'.esc_attr($footer_color_bottom['active']).' !important; }';
		}
	}


	/* Blog Display */
	$commentbox        = Cosmos::get_option('pix-commentbox');
	
	if ( $commentbox == '0' ) {
		$content .= '.blog-detail .blog-detail-wrapper .comments{display:none;}';
	}

	// /* Typography */
	$body_typo      = Cosmos::get_option('pix-typo-body');
	$para_typo      = Cosmos::get_option('pix-typo-p');
	$h1_typo        = Cosmos::get_option('pix-typo-h1');
	$h2_typo        = Cosmos::get_option('pix-typo-h2');
	$h3_typo        = Cosmos::get_option('pix-typo-h3');
	$h4_typo        = Cosmos::get_option('pix-typo-h4');
	$h5_typo        = Cosmos::get_option('pix-typo-h5');
	$h6_typo        = Cosmos::get_option('pix-typo-h6');
	$text_selection = Cosmos::get_option('pix-typo-selection');
	$link_color_opt = Cosmos::get_option('pix-link-color-type');
	$link_color     = Cosmos::get_option('pix-link-color');

	$body_typo_css = '';
	if( ! empty($body_typo) ){
		if ( $body_typo['font-family'] !== '' ) {
			$body_typo_css .= 'font-family:'.esc_attr($body_typo['font-family']).';';
		}
		if ( $body_typo['color'] !== '' ) {
			$body_typo_css .= 'color:'.esc_attr($body_typo['color']).';';
		}
		if ( $body_typo['font-size'] !== '' ) {
			$body_typo_css .= 'font-size:'.esc_attr($body_typo['font-size']).';';
		}
		if ( $body_typo['font-weight'] !== '' ) {
			$body_typo_css .= 'font-weight:'.esc_attr($body_typo['font-weight']).';';
		}
		if ( $body_typo['font-style'] !== '' ) {
			$body_typo_css .= 'font-style:'.esc_attr($body_typo['font-style']).';';
		}
		if ( $body_typo['text-align'] !== '' ) {
			$body_typo_css .= 'text-align:'.esc_attr($body_typo['text-align']).';';
		}
		if ( $body_typo['line-height'] !== '' ) {
			$body_typo_css .= 'line-height:'.esc_attr($body_typo['line-height']).';';
		}
	}
	$para_typo_css = '';
	if(!empty($para_typo)){
		if ( $para_typo['font-family'] !== '' ) {
			$para_typo_css .= 'font-family:'.esc_attr($para_typo['font-family']).';';
		}
		if ( $para_typo['color'] !== '' ) {
			$para_typo_css .= 'color:'.esc_attr($para_typo['color']).';';
		}
		if ( $para_typo['font-size'] !== '' ) {
			$para_typo_css .= 'font-size:'.esc_attr($para_typo['font-size']).';';
		}
		if ( $para_typo['font-weight'] !== '' ) {
			$para_typo_css .= 'font-weight:'.esc_attr($para_typo['font-weight']).';';
		}
		if ( $para_typo['font-style'] !== '' ) {
			$para_typo_css .= 'font-style:'.esc_attr($para_typo['font-style']).';';
		}
		if ( $para_typo['text-align'] !== '' ) {
			$para_typo_css .= 'text-align:'.esc_attr($para_typo['text-align']).';';
		}
		if ( $para_typo['line-height'] !== '' ) {
			$para_typo_css .= 'line-height:'.esc_attr($para_typo['line-height']).';';
		}
	}
	$h1_typo_css = '';
	if(!empty($h1_typo)){
		if ( $h1_typo['font-family'] !== '' ) {
			$h1_typo_css .= 'font-family:'.esc_attr($h1_typo['font-family']).';';
		}
		if ( $h1_typo['color'] !== '' ) {
			$h1_typo_css .= 'color:'.esc_attr($h1_typo['color']).';';
		}
		if ( $h1_typo['font-size'] !== '' ) {
			$h1_typo_css .= 'font-size:'.esc_attr($h1_typo['font-size']).';';
		}
		if ( $h1_typo['font-weight'] !== '' ) {
			$h1_typo_css .= 'font-weight:'.esc_attr($h1_typo['font-weight']).';';
		}
		if ( $h1_typo['font-style'] !== '' ) {
			$h1_typo_css .= 'font-style:'.esc_attr($h1_typo['font-style']).';';
		}
		if ( $h1_typo['text-align'] !== '' ) {
			$h1_typo_css .= 'text-align:'.esc_attr($h1_typo['text-align']).';';
		}
		if ( $h1_typo['line-height'] !== '' ) {
			$h1_typo_css .= 'line-height:'.esc_attr($h1_typo['line-height']).';';
		}
	}
	$h2_typo_css = '';
	if(!empty($h2_typo)){
		if ( $h2_typo['font-family'] !== '' ) {
			$h2_typo_css .= 'font-family:'.esc_attr($h2_typo['font-family']).';';
		}
		if ( $h2_typo['color'] !== '' ) {
			$h2_typo_css .= 'color:'.esc_attr($h2_typo['color']).';';
		}
		if ( $h2_typo['font-size'] !== '' ) {
			$h2_typo_css .= 'font-size:'.esc_attr($h2_typo['font-size']).';';
		}
		if ( $h2_typo['font-weight'] !== '' ) {
			$h2_typo_css .= 'font-weight:'.esc_attr($h2_typo['font-weight']).';';
		}
		if ( $h2_typo['font-style'] !== '' ) {
			$h2_typo_css .= 'font-style:'.esc_attr($h2_typo['font-style']).';';
		}
		if ( $h2_typo['text-align'] !== '' ) {
			$h2_typo_css .= 'text-align:'.esc_attr($h2_typo['text-align']).';';
		}
		if ( $h2_typo['line-height'] !== '' ) {
			$h2_typo_css .= 'line-height:'.esc_attr($h2_typo['line-height']).';';
		}
	}
	$h3_typo_css = '';
	if(!empty($h3_typo)){
		if ( $h3_typo['font-family'] !== '' ) {
			$h3_typo_css .= 'font-family:'.esc_attr($h3_typo['font-family']).';';
		}
		if ( $h3_typo['color'] !== '' ) {
			$h3_typo_css .= 'color:'.esc_attr($h3_typo['color']).';';
		}
		if ( $h3_typo['font-size'] !== '' ) {
			$h3_typo_css .= 'font-size:'.esc_attr($h3_typo['font-size']).';';
		}
		if ( $h3_typo['font-weight'] !== '' ) {
			$h3_typo_css .= 'font-weight:'.esc_attr($h3_typo['font-weight']).';';
		}
		if ( $h3_typo['font-style'] !== '' ) {
			$h3_typo_css .= 'font-style:'.esc_attr($h3_typo['font-style']).';';
		}
		if ( $h3_typo['text-align'] !== '' ) {
			$h3_typo_css .= 'text-align:'.esc_attr($h3_typo['text-align']).';';
		}
		if ( $h3_typo['line-height'] !== '' ) {
			$h3_typo_css .= 'line-height:'.esc_attr($h3_typo['line-height']).';';
		}
	}
	$h4_typo_css = '';
	if(!empty($h4_typo)){
		if ( $h4_typo['font-family'] !== '' ) {
			$h4_typo_css .= 'font-family:'.esc_attr($h4_typo['font-family']).';';
		}
		if ( $h4_typo['color'] !== '' ) {
			$h4_typo_css .= 'color:'.esc_attr($h4_typo['color']).';';
		}
		if ( $h4_typo['font-size'] !== '' ) {
			$h4_typo_css .= 'font-size:'.esc_attr($h4_typo['font-size']).';';
		}
		if ( $h4_typo['font-weight'] !== '' ) {
			$h4_typo_css .= 'font-weight:'.esc_attr($h4_typo['font-weight']).';';
		}
		if ( $h4_typo['font-style'] !== '' ) {
			$h4_typo_css .= 'font-style:'.esc_attr($h4_typo['font-style']).';';
		}
		if ( $h4_typo['text-align'] !== '' ) {
			$h4_typo_css .= 'text-align:'.esc_attr($h4_typo['text-align']).';';
		}
		if ( $h4_typo['line-height'] !== '' ) {
			$h4_typo_css .= 'line-height:'.esc_attr($h4_typo['line-height']).';';
		}
	}
	$h5_typo_css = '';
	if(!empty($h5_typo)){
		if ( $h5_typo['font-family'] !== '' ) {
			$h5_typo_css .= 'font-family:'.esc_attr($h5_typo['font-family']).';';
		}
		if ( $h5_typo['color'] !== '' ) {
			$h5_typo_css .= 'color:'.esc_attr($h5_typo['color']).';';
		}
		if ( $h5_typo['font-size'] !== '' ) {
			$h5_typo_css .= 'font-size:'.esc_attr($h5_typo['font-size']).';';
		}
		if ( $h5_typo['font-weight'] !== '' ) {
			$h5_typo_css .= 'font-weight:'.esc_attr($h5_typo['font-weight']).';';
		}
		if ( $h5_typo['font-style'] !== '' ) {
			$h5_typo_css .= 'font-style:'.esc_attr($h5_typo['font-style']).';';
		}
		if ( $h5_typo['text-align'] !== '' ) {
			$h5_typo_css .= 'text-align:'.esc_attr($h5_typo['text-align']).';';
		}
		if ( $h5_typo['line-height'] !== '' ) {
			$h5_typo_css .= 'line-height:'.esc_attr($h5_typo['line-height']).';';
		}
	}
	$h6_typo_css = '';
	if(!empty($h6_typo)){
		if ( $h6_typo['font-family'] !== '' ) {
			$h6_typo_css .= 'font-family:'.esc_attr($h6_typo['font-family']).';';
		}
		if ( $h6_typo['color'] !== '' ) {
			$h6_typo_css .= 'color:'.esc_attr($h6_typo['color']).';';
		}
		if ( $h6_typo['font-size'] !== '' ) {
			$h6_typo_css .= 'font-size:'.esc_attr($h6_typo['font-size']).';';
		}
		if ( $h6_typo['font-weight'] !== '' ) {
			$h6_typo_css .= 'font-weight:'.esc_attr($h6_typo['font-weight']).';';
		}
		if ( $h6_typo['font-style'] !== '' ) {
			$h6_typo_css .= 'font-style:'.esc_attr($h6_typo['font-style']).';';
		}
		if ( $h6_typo['text-align'] !== '' ) {
			$h6_typo_css .= 'text-align:'.esc_attr($h6_typo['text-align']).';';
		}
		if ( $h6_typo['line-height'] !== '' ) {
			$h6_typo_css .= 'line-height:'.esc_attr($h6_typo['line-height']).';';
		}
	}
	
	if(!empty($body_typo_css)){
		$content .= 'body{'.$body_typo_css.'}';
	}
	if($para_typo_css){
		$content .= 'p{'.$para_typo_css.'}';
	}
	if($h1_typo_css){
		$content .= 'h1{'.$h1_typo_css.'}';
	}
	if($h2_typo_css){
		$content .= 'h2{'.$h2_typo_css.'}';
	}
	if($h3_typo_css){
		$content .= 'h3{'.$h3_typo_css.'}';
	}
	if($h4_typo_css){
		$content .= 'h4{'.$h4_typo_css.'}';
	}
	if($h5_typo_css){
		$content .= 'h5{'.$h5_typo_css.'}';
	}
	if($h6_typo_css){
		$content .= 'h6{'.$h6_typo_css.'}';
	}
	

	if ( !empty($link_color) && $link_color_opt == '1' ) {
		$content .= 'a{color:'.esc_attr($link_color['regular']).'}';
		$content .= 'a:hover{color:'.esc_attr($link_color['hover']).'}';
		$content .= 'a:active{color:'.esc_attr($link_color['active']).'}';
	}

	$custom_css = '';
	if ( !empty($content) ) {
		$custom_css .= sprintf('@media screen { %s }', $content);
	}
	if ( !empty($content_desktop) ) {
		$custom_css .= sprintf('@media screen and (min-width: 769px) { %s }', $content_desktop);
	}
	$custom_css .= Cosmos::get_option('pix-custom-css');
	if ($custom_css != '') {
		do_action( COSMOS_THEME_ADD_INLINE_CSS, $custom_css );
	}

	$custom_js = Cosmos::get_option('pix-custom-js');
	if ($custom_js != '') {
		do_action( COSMOS_THEME_ADD_INLINE_SCRIPT, $custom_js );
	}
	

}

add_action('wp_head', 'cosmos_dynamic_css');

/*
 * Extras Options Not use CSS
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
if ( get_option('cosmos_options') ) {
	function cosmos_sticky_class( $classes ) {
		if ( Cosmos::get_option('pix-sticky') == '1') {
			$classes[] = 'sticky-enable';
		} else {			
			$classes[] = 'sticky-disable';
		}
		return $classes;
	}
	add_filter( 'body_class', 'cosmos_sticky_class' );
}

/* Custom Styles to WordPress Visual Editor */
function cosmos_mce_buttons_2($buttons) {
	array_unshift($buttons, 'styleselect');
	return $buttons;
}
add_filter('mce_buttons_2', 'cosmos_mce_buttons_2');

// Callback function to filter the MCE settings
function cosmos_mce_before_init_insert_formats( $init_array ) {
	$init_array['style_formats'] = json_encode( Cosmos_Params::get('style_formats') );
	return $init_array;
}
// Attach callback to 'tiny_mce_before_init'
add_filter( 'tiny_mce_before_init', 'cosmos_mce_before_init_insert_formats' );

/* add editor style */
function cosmos_add_editor_styles() {
	//add_editor_style( get_template_directory_uri() . '/assets/public/css/custom-editor.css' );
	add_editor_style( get_template_directory_uri() . '/assets/public/libs/bootstrap/css/bootstrap.min.css' );
	add_editor_style( get_template_directory_uri() . '/assets/public/font/font-icon/font-awesome/css/font-awesome.min.css' );
}
add_action( 'init', 'cosmos_add_editor_styles' );

/* Custom comment_reply_link */
function cosmos_comment_reply($link, $args, $comment) {
	$reply_link_text = $args['reply_text'];
	$link = str_replace($reply_link_text, '<i class="fa fa-reply"></i>' . esc_html__('Reply', 'cosmos'), $link);
	$link = str_replace("class='comment-reply-link", "class='btn-crystal btn ", $link);
	return $link;
}
add_filter('comment_reply_link', 'cosmos_comment_reply', 10, 3);

// change default avatar
add_filter( 'get_avatar' , 'cosmos_custom_avatar' , get_current_user_id(), 5 );
function cosmos_custom_avatar( $avatar, $user_id, $size, $default, $alt ) {
	$avatar_url = '';
	$avatar_id = get_user_meta($user_id, 'profile_image_id', true);
	if( $avatar_id ) {
		$avatar_url = wp_get_attachment_url( $avatar_id );
	}
	else {
		$avatar_url = get_avatar_url( $user_id );
	}
	$avatar = "<img alt='{}' src='{$avatar_url}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}'/>";
	return $avatar;
}