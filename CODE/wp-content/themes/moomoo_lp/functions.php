<?php

/**
 * @author: ngadt
 * @date-create : 11-10-2018
 */

define("MOOMOO_ADMIN_PATH", get_template_directory().'/inc/admin/' );
define("MOOMOO_FRONTEND_PATH", get_template_directory().'/inc/frontend/');
define("MOOMOO_ASSET_PATH", get_template_directory().'/assets/');
define("MOOMOO_ASSET_URL",  get_template_directory_uri().'/assets/'); 

if(is_admin()){
    require_once(MOOMOO_ADMIN_PATH.'admin.php');   
    add_filter( 'wp_calculate_image_srcset', '__return_false' );
}else{
    require_once(MOOMOO_FRONTEND_PATH.'frontend.php');    
} 