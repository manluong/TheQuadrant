<?php
Cosmos::load_class( 'Abstract' );
class Cosmos_Page_Controller extends Cosmos_Abstract {
	/**
	 * Setting page
	 */
	public function meta_box_setting() {
		global $post;
		global $cosmos_default_options;
		$post_id = $post->ID;
		// default
		$bg_repeat      = Cosmos_Params::get( 'background-repeat' );
		$bg_size        = Cosmos_Params::get( 'background-size' );
		$bg_position    = Cosmos_Params::get( 'background-position' );
		$bg_attachment  = Cosmos_Params::get( 'background-attachment' );
		$sidebar_layout = Cosmos_Params::get( 'sidebar-layout' );
		$slider_type    = Cosmos_Params::get( 'slider-type' );
	
		// get meta
		$page_options = get_post_meta( $post_id, 'cosmos_page_options', true );
		if( $page_options ) {
			$bg_array = array(
				'background_transparent'        => 'background_color',
				'pt_background_transparent'     => 'pt_background_color',
				'pt_p_background_transparent'   => 'pt_p_background_color',
			);
			foreach($bg_array as $key=>$val ) {
				if( isset($page_options[$key]) && !empty($page_options[$key])) {
					$page_options[$val] = $page_options[$key];
				}
			}
		}

		// contact_form
		$args = array (
			'post_type'     => 'wpcf7_contact_form',
		);
		$options = array( 'empty' => esc_html__( '--Select Contact Form--', 'cosmos' ) );
		$contact_form = Cosmos_Core_Com::get_post_id2title( $args, $options );
		
		$params = array(
			'background-repeat'     => $bg_repeat,
			'background-attachment' => $bg_attachment,
			'background-position'   => $bg_position,
			'background-size'       => $bg_size,
			'sidebar_layout'        => $sidebar_layout,
			'slider-type'           => $slider_type,
			'regist_sidebars'       => Cosmos_Core_Com::get_regist_sidebars(),
			'show_header'           => array( ''    => esc_html__('Show', 'cosmos'), '1' => esc_html__('Hide', 'cosmos')),
			'show'                  => array( ''    => esc_html__('Hide', 'cosmos'), '1' => esc_html__('Show', 'cosmos')),
			'contact_form'          => $contact_form,
		);
		$this->parse_image($params, $page_options, $cosmos_default_options );
		$this->render( 'page-setting', array(
			'params' => $params,
			'defaults' => $cosmos_default_options,
			'page_options' => $page_options
		));
	}
	private function parse_image( &$params, $page_options, $cosmos_default_options ) {
		$image_id_keys = array(
			'bg_image'       => array('background_image', 'background_image_id' ),
			'pt_bg_image'    => array('pt_background_image', 'pt_background_image_id' )
		);
		foreach( $image_id_keys as $img_key => $img_val ) {
			$attachment = array ( 'id' => '', 'url' => '', 'class' => '' );
			$attachment['url'] = $this->get_field( $page_options, $img_val[0], $cosmos_default_options );
			if( empty( $attachment['url'] ) ) {
				$attachment['class'] = 'hide';
			}
			$thumb_id = $this->get_field( $page_options, $img_val[1], $cosmos_default_options );
			if( ! empty( $thumb_id )) {
				$attachment_image = wp_get_attachment_image_src($thumb_id, 'full');
				$attachment = array ( 'id' => $thumb_id, 'url' => $attachment_image[0], 'class' => '' );
			}
			$params[$img_key] = $attachment;
		}
	}
}