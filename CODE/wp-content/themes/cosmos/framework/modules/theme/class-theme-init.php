<?php
/**
 * Theme class.
 * 
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
Cosmos::load_class( 'Abstract' );
class Cosmos_Theme_Init extends Cosmos_Abstract {
	/**
	 * Register style/script in admin
	 * 
	 */
	public function admin_enqueue(){
		$uri = get_template_directory_uri() . '/assets/admin';
		// css
		wp_enqueue_style( 'cosmos-admin-style',   $uri . '/css/cosmos-admin-style.css', false, COSMOS_THEME_VER, 'all' );
		wp_enqueue_style( 'font-awesome.min',      COSMOS_PUBLIC_URI . '/fonts/font-icon/font-awesome/css/font-awesome.min.css', array(), false );
		// js
		wp_enqueue_media();
		wp_enqueue_script( 'cosmos-widget',      $uri . '/js/cosmos-widget.js', array('jquery'), COSMOS_THEME_VER, true );
		//menu
		wp_enqueue_script( 'cosmos-menu',        $uri . '/js/cosmos-menu.js', array('jquery'), COSMOS_THEME_VER, true );
	}

	/**
	 * Register style/script in public
	 */
	public function public_enqueue() {
		$dir_uri = get_template_directory_uri();
		$uri = COSMOS_PUBLIC_URI;

		//google fonts
		wp_enqueue_style( 'cosmos-fonts',                $this->add_fonts_url(), array(), null );
		//font
		wp_enqueue_style( 'font-awesome.min',				$uri . '/fonts/font-icon/font-awesome/css/font-awesome.min.css', array(), false );
		//libs
		wp_enqueue_style( 'bootstrap.min',					$uri . '/libs/bootstrap/css/bootstrap.min.css', array(), false );
		wp_enqueue_style( 'animate',						$uri . '/libs/animate/animate.css', array(), false );
		wp_enqueue_style( 'owl.carousel',					$uri . '/libs/owl.carousel/css/owl.carousel.css', array(), false );
		wp_enqueue_style( 'owl.carousel.theme',				$uri . '/libs/owl.carousel/css/owl.theme.min.css', array(), false );		
		wp_enqueue_style( 'bootstrap-datepicker.min',		$uri . '/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css', array(), false );
		wp_enqueue_style( 'jquery-ui',						$uri . '/libs/jquery-ui/jquery-ui.min.css', array(), false );
		wp_enqueue_style( 'fancybox',						$uri . '/libs/fancybox/source/jquery.fancybox.css', array(), '2.1.5' );
		wp_enqueue_style( 'fancybox-buttons',				$uri . '/libs/fancybox/source/helpers/jquery.fancybox-buttons.css', array(), '1.0.5' );
		wp_enqueue_style( 'fancybox-thumbs',				$uri . '/libs/fancybox/source/helpers/jquery.fancybox-thumbs.css', array(), '1.0.7' );

		//style
		wp_enqueue_style( 'cosmos-layout',					$uri . '/css/cosmos-layout.css', array(), COSMOS_THEME_VER );
		wp_enqueue_style( 'cosmos-components',				$uri . '/css/cosmos-components.css', array(), COSMOS_THEME_VER );
		wp_enqueue_style( 'cosmos-responsive',				$uri . '/css/cosmos-responsive.css', array(), COSMOS_THEME_VER );
		wp_enqueue_style( 'cosmos-style',					get_stylesheet_uri(), array(), COSMOS_THEME_VER );
		wp_enqueue_style( 'cosmos-custom-editor',			$uri . '/css/cosmos-custom-editor.css', array(), COSMOS_THEME_VER );
		wp_enqueue_style( 'cosmos-custom-theme',			$uri . '/css/cosmos-custom-theme.css', array(), COSMOS_THEME_VER );

		// comment
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		//load by skin
		$site_skin_array = array('bronze','black','blue','green','orange','red','violet','yellow');
		$site_skin = Cosmos::get_option( 'pix-theme-skin-color' );
		if ( isset($_GET['color']) ) {
			$site_skin = $_GET['color'];
		}
		if ( in_array( $site_skin,$site_skin_array ) ){
			wp_enqueue_style( 'cosmos-skin-color',            $uri . '/css/color/'.$site_skin.'.css', array(), COSMOS_THEME_VER );
		}


		//libs
		wp_enqueue_script( 'bootstrap.min',					$uri . '/libs/bootstrap/js/bootstrap.min.js', array('jquery'), false, true );
		wp_enqueue_script( 'bootstrap-datepicker.min',		$uri . '/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js', array('jquery'), false, true );
		wp_enqueue_script( 'owl.carousel',					$uri . '/libs/owl.carousel/js/owl.carousel.min.js', array('jquery'), false, true );
		wp_enqueue_script( 'jquery-ui',						$uri . '/libs/jquery-ui/jquery-ui.min.js', array('jquery'), false, true );
		wp_enqueue_script( 'trianglify',					$uri . '/libs/trianglify/trianglify.min.js', array('jquery'), false, true );
		wp_enqueue_script( 'fancybox',						$uri . '/libs/fancybox/source/jquery.fancybox.js', array('jquery'), '2.1.5', true );
		wp_enqueue_script( 'fancybox-buttons',				$uri . '/libs/fancybox/source/helpers/jquery.fancybox-buttons.js', array('jquery'), '1.0.5', true );
		wp_enqueue_script( 'fancybox-thumbs',				$uri . '/libs/fancybox/source/helpers/jquery.fancybox-thumbs.js', array('jquery'), '1.0.7', true );
		wp_enqueue_script( 'fancybox-media',				$uri . '/libs/fancybox/source/helpers/jquery.fancybox-media.js', array('jquery'), '1.0.6', true );
		wp_enqueue_script( 'modernizr.custom',				$uri . '/libs/jquery-gallery/modernizr.custom.js', array('jquery'), false, true );
		wp_enqueue_script( 'jquery-gallery',				$uri . '/libs/jquery-gallery/jquery.gallery.js', array('jquery'), false, true );

		// theme js
		wp_enqueue_script( 'cosmos-main',					$uri . '/js/cosmos-main.js', array(), COSMOS_THEME_VER, true );
		wp_enqueue_script( 'cosmos-custom',					$uri . '/js/cosmos-custom.js', array(), COSMOS_THEME_VER, true );
		
		//for contact form 7 plugin
		if ( COSMOS_WPCF7_ACTIVE ) {
			wp_localize_script(
					'cosmos-form',
					'ajaxurl',
					esc_url( admin_url( 'admin-ajax.php' ) )
			);
			wp_enqueue_script( 'cosmos-cf7-jquery', plugins_url() . '/contact-form-7/includes/js/jquery.form.min.js', array(), false, true );
			wp_enqueue_script( 'cosmos-cf7-scripts', plugins_url() . '/contact-form-7/includes/js/scripts.js', array(), false, true );
		}
	}
	/**
	 * Google fonts
	 */
	function add_fonts_url() {
		$fonts_url    = '';
		$family_fonts = array();
		$subsets      = 'latin,latin-ext';

		/* Translators: If there are characters in your language that are not supported
			by chosen font(s), translate this to 'off'. Do not translate into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Raleway font: on or off', 'cosmos' ) ) {
			$family_fonts[] = 'Raleway:100,400,700,900';
		}
		if ( 'off' !== _x( 'on', 'Source Sans Pro font: on or off', 'cosmos' ) ) {
			$family_fonts[] = 'Source+Sans+Pro:300,400,400i,700,900';
		}
		
		/* encode url | ~ %7C */
		if ( $family_fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => esc_attr( implode( '%7C', $family_fonts ) ),
				'subset' => esc_attr( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}
	
		return $fonts_url;
	}
	/**
	 * General setting
	 * 
	 */
	public function theme_setup() {
		// Editor
		$this->add_theme_supports();
		$this->add_image_sizes();
	}
	/**
	 * Add theme_supports
	 * 
	 */
	public function add_theme_supports() {
	
		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );
		// Default custom header
		add_theme_support( 'custom-header' );
		// Default custom backgrounds
		add_theme_support( 'custom-background' );
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		/*
		* Enable support for Post Formats.
		*/
		// Post Formats
		add_theme_support( 'post-formats', array( 'gallery', 'link', 'image', 'quote', 'video', 'audio', 'chat' ) );
		// Add post thumbnail functionality
		add_theme_support('post-thumbnails');
		set_post_thumbnail_size(800, 600, true);
		//
		add_theme_support( 'title-tag' );
		// woocommerce support
		add_theme_support( 'woocommerce' );
	}
	
	/**
	 * Add image sizes
	 * 
	 */
	public function add_image_sizes() {
		$cosmos_image_sizes = Cosmos_Config::get('image_sizes');
		foreach($cosmos_image_sizes as $cosmos_key => $cosmos_sizes ) {
			$cosmos_crop = true;
			if( isset( $cosmos_sizes['crop'] ) ) {
				$cosmos_crop = $cosmos_sizes['crop'];
			}
			add_image_size( $cosmos_key, $cosmos_sizes['width'], $cosmos_sizes['height'], $cosmos_crop );
		}
	}

	/**
	 * action using generate inline css
	 * @param string $custom_css
	 */
	public function add_inline_style( $cosmos_custom_css ) {
		wp_enqueue_style('cosmos-custom-style', COSMOS_PUBLIC_URI . '/css/cosmos-custom-inline.css');
		wp_add_inline_style( 'cosmos-custom-style', $cosmos_custom_css );
	}

	/**
	 * action using generate inline script
	 * @param string $custom_css
	 */
	public function add_inline_script( $cosmos_script_css ) {
		wp_enqueue_script('cosmos-custom-script', COSMOS_PUBLIC_URI . '/js/cosmos-custom-inline.js');
		wp_add_inline_script( 'cosmos-custom-script', $cosmos_script_css );
	}

	//************************* Front Page << ***********************
	/**
	 * Get page options, apply to theme options.(front page)
	 *
	 */
	public function get_page_options() {
		global $cosmos_options;
		global $cosmos_page_options;

		$post_types = Cosmos_Config::get('page_options','post_types');

		if( get_post_type() != 'product' && ( is_search() || is_archive() || is_category() || is_tag() ) ){
			return;
		}
		list($post_id, $shop_page) = cosmos_get_post_id();
		if( ! $post_id ) {
			return;
		}
		$post_type = get_post_type($post_id);
		//
		$cosmos_page_options = get_post_meta( $post_id, 'cosmos_page_options', true );
		if( empty( $cosmos_page_options ) ) {
			return;
		}
		$image_id_keys = array('background_image_id', 'pt_background_image_id');
		$maps = Cosmos_Config::get( 'mapping', 'options' );
	
		$no_default = Cosmos_Config::get( 'mapping', 'no-default-options' );
		foreach($maps as $option_type => $page_options ) {
			$is_theme_default = $option_type .'_default';
			if( ( ! in_array($option_type, $no_default) ) &&
					(!isset( $cosmos_page_options[$is_theme_default] ) || isset( $cosmos_page_options[$is_theme_default] ) && ! empty( $cosmos_page_options[$is_theme_default] ) ) )
			{
				// no get page options
				continue;
			} else {
				foreach( $page_options as $key => $option) {
					$default = '';
					$bg_img = '';
					$bg_array = array(
						'background_transparent'       => 'background_color',
						'pt_background_transparent'    => 'pt_background_color'
					);
					foreach($bg_array as $bg_key=>$bg_val ) {
						if( isset($cosmos_page_options[$bg_key]) && !empty($cosmos_page_options[$bg_key])) {
							$cosmos_page_options[$bg_val] = $cosmos_page_options[$bg_key];
							unset($page_options[$bg_key]);
						}
					}
					if( isset( $cosmos_page_options[$key] ) ) {
						$option_val = $cosmos_page_options[$key];
						if( in_array( $key, $image_id_keys ) && ! empty( $option_val ) ) {
							$attachment_image = wp_get_attachment_image_src($option_val, 'full');
							$bg_img = $attachment_image[0];
							$default = $option_val;
						} else {
							$default = $option_val;
						}
					}
					if( $option && in_array(get_post_type(), $post_types) ) {
						if( is_array( $option ) ) {
							if( count( $option ) == 3 ) {
								if( $default ) {
									$cosmos_options[$option[0]][$option[1]][$option[2]] = $default;
									if( !empty( $bg_img ) ) {
										$cosmos_options[$option[0]]['background-image'] = $bg_img;
									}
								}
							}
							else {
								$cosmos_options[$option[0]][$option[1]] = $default;
							}
						} else {
							$cosmos_options[$option] = $default;
						}
					}
				}
			}
		}
		
	}
	//************************* Front Page >> ***********************
	//************************* Admin Page << ***********************
	/**
	 * Get theme options to init page options. (admin page)
	 */
	public function init_page_setting() {
		global $cosmos_default_options;
		global $cosmos_options;

		$maps = Cosmos_Config::get( 'mapping', 'options' );
		$special_keys = array( 'pt_padding_top', 'pt_padding_bottom', 'header_padding_top', 'header_padding_bottom' );
		$transparent_keys = array( 'background_transparent', 'pt_background_transparent' );
		
		foreach( $maps as $option_type => $options ) {
			foreach( $options as $key => $option) {
				$default = '';
				if( $option ) {
					if( is_array( $option ) ) {
						if(count($option) == 3) {
							if( isset( $cosmos_options[$option[0]][$option[1]][$option[2]] ) ) {
								$default = $cosmos_options[$option[0]][$option[1]][$option[2]];
							}
						}
						else if( isset( $cosmos_options[$option[0]][$option[1]] ) ) {
							$default = $cosmos_options[$option[0]][$option[1]];
						}
					} else if( isset( $cosmos_options[$option] ) ) {
						$default = $cosmos_options[$option];
					}
					if( in_array( $key, $special_keys ) ) {
						$default = str_replace( 'px', '', $default );
					} else if( in_array( $key, $transparent_keys ) ) {
						if( $default =='transparent' ) {
							$default = 1;
						} else {
							$default = '';
						}
					}
					$cosmos_default_options[$key] = $default;
				}
			}
		}
	}
	/**
	 * Add meta box page setting to page or post type.
	 */
	public function add_page_options() {
		if( COSMOS_CORE_IS_ACTIVE ) {
			$post_types = Cosmos_Config::get( 'page_options', 'post_types');
			foreach( $post_types as $post_type ) {
				add_meta_box( 'cosmos_mbox_page_setting', 'Page Setting', array( 'Cosmos', '[theme.Page_Controller, meta_box_setting]' ), $post_type, 'normal', 'low' );
			}
		}
	}
	/**
	 * Save page
	 */
	public function save_page( $post_id = '' ) {
		if( empty( $post_id ) ) {
			global $post;
			$post_id = $post->ID;
			parent::save();
		}
		// save page options start
		$maps = Cosmos_Config::get( 'mapping', 'options' );
		$no_default = Cosmos_Config::get( 'mapping', 'no-default-options' );
		foreach($maps as $k=>$v) {
			$is_default = $k .'_default';
			if( ( !isset($_POST['cosmos_page_options'][$is_default]) ) ){
				$_POST['cosmos_page_options'][$is_default] = '';
			}
		}
		update_post_meta( $post_id, 'cosmos_page_options', isset( $_POST['cosmos_page_options'] ) ? $_POST['cosmos_page_options'] : '' );
	}
	/**
	 * Save post
	 */
	public function save_post() {
		global $post;
		$post_id = $post->ID;
		parent::save();
		// save page options
		$this->save_page( $post_id );
		if( COSMOS_CORE_IS_ACTIVE ) {
			do_action( 'cosmos_core_save_feature_video', $post_id );
		}
	}
	/**
	 * Save product
	 */
	public function save_product() {
		global $post;
		$post_id = $post->ID;
		parent::save();
		// save page options
		$this->save_page( $post_id );
	}
}