<?php
if( is_search() ) return;
$post_id = get_the_ID();
if( $post_id ) {
	$slider_page_settings = get_post_meta( $post_id, 'cosmos_page_options', true );
	if ( $slider_page_settings ){
		$slider = Cosmos::get_value( $slider_page_settings, 'revolution_slider');
		if ( !empty( $slider ) ){
			echo do_shortcode( '[rev_slider_vc alias="'.$slider_page_settings['revolution_slider'].'"]' );
		}
	}
}