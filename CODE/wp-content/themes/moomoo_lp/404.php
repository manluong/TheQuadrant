<?php 
	/** 
		Template Name: 404 page not found
	**/
 ?>
<?php get_header(); ?>
<?php //get_template_part('page'); 
$page_404 = get_page_by_path('404-page-not-found');

if(isset($page_404)){
	if(is_page('404-page-not-found')){
		get_template_part('page'); 
	}else{
		echo do_shortcode($page_404->post_content);
	} 

}else{
	   $layoutDefault404 = array(
        'post_content' => '[vc_row full_width="stretch_row" css=".vc_custom_1537243845859{background-color: #1e73be !important;}" el_class="search-property-page"][vc_column css=".vc_custom_1496388603668{padding-top: 35px !important;}"][vc_single_image image="20" img_size="full" alignment="center"][/vc_column][/vc_row][vc_row][vc_column][vc_empty_space height="70px"][/vc_column][/vc_row][vc_row equal_height="yes" content_placement="middle"][vc_column width="5/12"][vc_column_text]
<h2 style="text-align: center; font-size: 120px;"><span style="color: #95774c;">404</span></h2>
[/vc_column_text][/vc_column][vc_column width="7/12"][vc_column_text]
<h2 style="color: #95774c;">Sorry we couldn\'t find the page you\'re looking for.</h2>
&nbsp;
<h2 style="color: #95774c;">Please click <span style="color: #95774c;"><em><a style="color: #95774c; font-size: 45px; font-family: Libre Baskerville; text-decoration: underline;" href="'.home_url().'">here</a></em> </span>to return to the home page</h2>
[/vc_column_text][/vc_column][/vc_row][vc_row][vc_column][vc_empty_space height="100px"][/vc_column][/vc_row]',
        'post_title' => '404 page not found',
        'post_status' => 'publish',
         'post_type' => 'page',
    	);
	 $postID = wp_insert_post($layoutDefault404);
	 $page_404 = get_page_by_path('404-page-not-found');

	 echo do_shortcode($page_404->post_content);
}
$output =""	;
$shortcodes_custom_css = visual_composer()->parseShortcodesCustomCss( $page_404->post_content );		
if ( ! empty( $shortcodes_custom_css ) ) {
    $shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
    $output .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
    $output .= $shortcodes_custom_css;
    $output .= '</style>';
    echo $output;
}	

?>

<?php get_footer(); ?>