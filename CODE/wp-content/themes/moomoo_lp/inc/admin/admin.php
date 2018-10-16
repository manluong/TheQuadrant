<?php
class StreamlineAdmin{
	public function __construct(){
		add_action( 'admin_enqueue_scripts', array($this,'MOOMOO_load_scripts' ));
	}

/* =============================================================== 
   Remove auto resize image wordpress 
  =============================================================== */
/**
 * load css and js
 * @return [type] [description]
 */
  public function MOOMOO_load_scripts(){     
      wp_enqueue_script( 'admin',MOOMOO_ASSET_URL.'js/admin.js',array('jquery'),'1.0.0' );
      wp_enqueue_style('admin',MOOMOO_ASSET_URL.'css/admin/admin.css',array(),'1.0.0' );
  }
	
}
new StreamlineAdmin;