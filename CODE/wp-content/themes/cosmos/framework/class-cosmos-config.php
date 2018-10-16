<?php
/**
 * Cosmos config class.
 * 
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
class Cosmos_Config {
	private static $setting = array(
		'save_post' => array(
			'page'             => array( 'theme.Theme_Init', 'save_page' ),
			'post'             => array( 'theme.Theme_Init', 'save_post' ),
		),
		'page_options' => array(
			'post_types' => array( 'post', 'page' ),
		),
		'mapping' => array(
			'special_options' => array(
				'', 
				'header_top_show', 
				'header_logo_show', 
				'header_sticky_enable',
				'header_full_1920',
				'footer_show', 
				'footer_main_show', 
				'footer_bottom_show', 
				'page_title_show', 
				'breadcrumb_show', 
				'title_show'
			),
			'no-default-options' => array( 
				'no_default' 
			),
			'options' => array(
				'general' => array(
					'theme_skin_color'   		=> 'pix-theme-skin-color',
					'background_transparent'   => array( 'pix-layout-boxed-bg', 'background-color' ),
					'background_color'         => array( 'pix-layout-boxed-bg', 'background-color' ),
					'background_repeat'        => array( 'pix-layout-boxed-bg', 'background-repeat' ),
					'background_attachment'    => array( 'pix-layout-boxed-bg', 'background-attachment' ),
					'background_position'      => array( 'pix-layout-boxed-bg', 'background-position' ),
					'background_size'          => array( 'pix-layout-boxed-bg', 'background-size' ),
					'background_image'         => array( 'pix-layout-boxed-bg', 'background-image' ),
					'background_image_id'      => array( 'pix-layout-boxed-bg', 'media', 'id' ),
					
				),
				'header' => array(
					'header_show'      			=> 'pix-header-show',
					'header_sticky_enable'		=> 'pix-sticky',
					'header_full_1920'			=> 'pix-header-full-1920',
					'header_menu_icon_item'		=> 'pix-menu-icon',
					'header_bg_color'			=> 'pix-header-bg-color',
					'header_bg_color_scroll'	=> 'pix-header-bg-color-scroll',
					'header_logo'				=> array( 'pix-logo-header', 'url'),
				),
				'menu' => array(
					'menu_style'				=> 'pix-menu-style',
					'menu_text_color_regular'	=> array( 'pix-menu-item-text', 'regular' ),
					'menu_text_color_hover'		=> array( 'pix-menu-item-text', 'hover' ),
					'menu_text_color_active'	=> array( 'pix-menu-item-text', 'active' ),
				),
				'page_title' => array(
					'page_title_show'          => 'pix-page-title-show',
					'page_title_align'  	   => 'pix-page-title-align',
					'page_title_heading'  	   => 'pix-page-title-heading',
					'page_title_type_display'  => 'pix-page-title-type-display',
					'pt_background_color'      => array( 'pix-page-title-bg', 'background-color' ),
					'pt_background_repeat'     => array( 'pix-page-title-bg', 'background-repeat' ),
					'pt_background_attachment' => array( 'pix-page-title-bg', 'background-attachment' ),
					'pt_background_position'   => array( 'pix-page-title-bg', 'background-position' ),
					'pt_background_size'       => array( 'pix-page-title-bg', 'background-size' ),
					'pt_background_image'      => array( 'pix-page-title-bg', 'background-image' ),
					'pt_background_image_id'   => array( 'pix-page-title-bg', 'media', 'id' ),
					'pt_height'                => array('pix-page-title-height', 'height'),
					'title_show'               => 'pix-show-title',
					'title_custom_content'     => '',
					'title_color'              => array( 'pix-pagetitle-title', 'color' ),
					'breadcrumb_show'          => 'pix-show-breadcrumb',
					'breadcrumb_text_color'    => array( 'pix-breadcrumb-path2', 'color' ),
					'breadcrumb_color'         => array( 'pix-breadcrumb-path', 'color' ),
					'breadcrumb_icon_color'    => 'pix-breadcrumb-icon-color',
				),
				'footer' => array(
					'footer_show'              => 'pix-footer-show',
					'footer_main_show'         => 'pix-footer-main-show',
					'footer_bottom_show'       => 'pix-footer-bottom-show',
					'footer_logo'              => array( 'pix-logo-footer', 'url'),
				),
				'sidebar' => array(
					'sidebar_layout'             => 'pix-sidebar-layout',
					'sidebar_id'                 => 'pix-sidebar',
					'sidebar_post_layout'        => 'pix-blog-sidebar-layout',
					'sidebar_post_id'            => 'pix-blog-sidebar',
					'sidebar_shop_layout'        => 'pix-shop-sidebar-layout',
					'sidebar_shop_id'            => 'pix-shop-sidebar',
				),
				'no_default' => array(
					'body_extra_class'         	=> 'pix-body-extra-class',
					'ct_padding_top'           	=> 'pix-content-padding-top',
					'ct_padding_bottom'        	=> 'pix-content-padding-bottom',
				),
			),
		),
		'image_sizes' => array(
			'cosmos-thumb-200x200'         => array( 'width' => 200, 'height' => 200 ),//testimonial
			'cosmos-thumb-400x300'         => array( 'width' => 400, 'height' => 300 ), //portfolio small, blog
			'cosmos-thumb-500x400'         => array( 'width' => 500, 'height' => 300 ), //blog, timeline
			'cosmos-thumb-600x600'         => array( 'width' => 600, 'height' => 600 ), //screenshot style 2
			'cosmos-thumb-800x600'         => array( 'width' => 800, 'height' => 600 ), //portfolio large,blog
			'cosmos-thumb-300x550'         => array( 'width' => 300, 'height' => 550 ), //carousel, screenshot style 1
		),
	);
	public static function get_theme_options_init() {
		$params = array(
			// default theme options
			'pix-header-show'     	   => '1',
			'pix-sticky'        	   => 'false',
			'pix-header-layout'        => 'one',
			'pix-menu-style'           => '1',
			'pix-social-facebook'      => '1',
			'pix-social-twitter'       => '1',
			'pix-social-pinterest'     => '1',
			'pix-page-title-show'      => '1',
			'pix-show-title'           => '1',
			'pix-show-breadcrumb'      => '1',
			'pix-footer-show'     	   => '1',
			'pix-footer-top-show'      => '0',
			'pix-footer-main-show'     => '0',
			'pix-footer-bottom-show'   => '1',
			'pix-footerbt-col1'        => array( 'enabled' => array('text' => '') ),
			'pix-footerbt1-text'       => esc_html__('&copy; 2017 BY PIXARTTHEMS. ALL RIGHT RESERVE.', 'cosmos'),
			'pix-sidebar-layout'       => 'left',
			'pix-blog-sidebar-layout'  => 'right',
			'pix-404-title'            => esc_html__('Sorry, this page does not exist', 'cosmos'),
			'pix-404-desc'             => esc_html__('The link you clicked might be corrupted, or the page may have been removed.', 'cosmos'),
			//blog
			'pix-bloginfo'             => array(
											'enabled' => array(
												'author' => '', 
												'date' => '', 
												'view' => '', 
												'comment' => ''
												)
											),
			'pix-blog-showdate'        => '1',
			'pix-blog-author'          => '1',
			'pix-blog-tag'             => '1',
			'pix-blog-cat'             => '1',
		);
		return $params;
	}
	/**
	 * Retrieve value from the config variable.
	 *
	 * @param string $name The key name of first level.
	 * @param string $field optional The key name of second level.
	 * @return mixed.
	 */
	public static function get( $name, $field = NULL ) {
		if( isset( self::$setting[ $name ] ) ) {
			if( $field ) {
				return ( isset( self::$setting[ $name ][ $field ] ) ) ? self::$setting[ $name ][ $field ] : null;
			} else {
				return self::$setting[ $name ];
			}
		}
		
		return array();
	}
}