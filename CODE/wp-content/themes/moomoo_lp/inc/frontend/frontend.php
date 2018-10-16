<?php 
class StreamlineFrontend{ 
	
	public function __construct(){
		add_action('wp_enqueue_scripts', array($this,'MOOMOO_load_scripts' ));		

	}
/**
* load css and js
* @return [type] [description]
*/
	public function MOOMOO_load_scripts(){

		$blog_ID = get_current_blog_id();				    
		
		wp_enqueue_script( 'moomoo-custom',MOOMOO_ASSET_URL.'js/custom.js',array(),time(),true );
		wp_enqueue_style( 'bootstrap',MOOMOO_ASSET_URL.'css/frontend/bootstrap.min.css', array(), '3.3.5');
		wp_enqueue_style( 'moomoo-theme',MOOMOO_ASSET_URL.'css/frontend/themes.css', array('bootstrap'),time() );			
	}

 }new StreamlineFrontend;
