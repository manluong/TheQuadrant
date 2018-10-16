<?php
/**
 * Cosmos params class.
 * 
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
class Cosmos_Params {
	/**
	 * Retrieve value from the params variable.
	 *
	 * @param string $name The key name of first level.
	 * @param string $field optional The key name of second level.
	 * @return mixed.
	 */
	public static function get( $name, $field = NULL ) {
		//get param from special function
		if ( method_exists( __CLASS__, $name ) ) {
			$params = call_user_func( array(__CLASS__, $name) );
			if( $field ) {
				return ( isset( $params[ $field ] ) ) ? $params[ $field ] : null;
			} else {
				return $params;
			}
		}
		//get param from setting function
		if ( method_exists( __CLASS__, 'setting' ) ) {
			$setting_params = call_user_func( array(__CLASS__, 'setting') );
			if(isset( $setting_params[ $name ] )  ) {
				if( $field ) {
					if( isset($setting_params[ $name ][ $field ]) ){
						return $setting_params[ $name ][ $field ];
					} else {
						return null;
					}
				} else {
					return $setting_params[ $name ];
				}
			}
		}
		return array();
	}
	public static function setting() {
		return array(
			'header-social' => array(
				'facebook'   => 'fa-facebook',
				'twitter'    => 'fa-twitter',
				'google-plus'=> 'fa-google-plus',
				'pinterest'  => 'fa-pinterest',
				'instagram'  => 'fa-instagram',
				'dribbble'   => 'fa-dribbble',
			),
			'header-contact' => array(
				'workingtime'  => 'fa-clock-o',
				'phone'        => 'fa-phone',
				'address'      => 'fa-map-marker',
			),
			'social-icons' =>array(
				'facebook'      => 'fa-facebook',
				'twitter'       => 'fa-twitter',
				'google-plus'   => 'fa-google-plus',
				'skype'         => 'fa-skype',
				'youtube'       => 'fa-youtube',
				'rss'           => 'fa-rss',
				'delicious'     => 'fa-delicious',
				'flickr'        => 'fa-flickr',
				'lastfm'        => 'fa-lastfm',
				'linkedin'      => 'fa-linkedin',
				'vimeo'         => 'fa-vimeo',
				'tumblr'        => 'fa-tumblr',
				'pinterest'     => 'fa-pinterest',
				'deviantart'    => 'fa-deviantart',
				'git'           => 'fa-git',
				'instagram'     => 'fa-instagram',
				'soundcloud'    => 'fa-soundcloud',
				'stumbleupon'   => 'fa-stumbleupon',
				'behance'       => 'fa-behance',
				'tripAdvisor'   => 'fa-tripadvisor',
				'vk'            => 'fa-vk',
				'foursquare'    => 'fa-foursquare',
				'xing'          => 'fa-xing',
				'weibo'         => 'fa-weibo',
				'odnoklassniki' => 'fa-odnoklassniki',
			),
			// image size
			'default-image-size' => array(
				'wg_recent_post'		=> array( 'large' => '200x200' ),
				'recent_news'			=> array( 'large' => '200x200' ),
				'blog'					=> array( 'large' => '800x600', 'medium' => '400x300', 'small' => '200x200' ),
			),
			//************* CustomPost/ Page Setting << ****************
			'video-type' => array(
				''              => esc_html__( 'None', 'cosmos'),
				'vimeo'         => esc_html__( 'Vimeo', 'cosmos'),
				'youtube'       => esc_html__( 'Youtube', 'cosmos'),
			),
			'background-repeat' => array(
				''          => esc_html__( '-Background Repeat-', 'cosmos'),
				'no-repeat' => esc_html__( 'No Repeat', 'cosmos'),
				'repeat'    => esc_html__( 'Repeat All', 'cosmos'),
				'repeat-x'  => esc_html__( 'Repeat Horizontally', 'cosmos'),
				'repeat-y'  => esc_html__( 'Repeat Vertically', 'cosmos'),
				'inherit'   => esc_html__( 'Inherit', 'cosmos'),
			),
			'background-size' => array(
				''        => esc_html__( '-Background Size-', 'cosmos'),
				'inherit' => esc_html__( 'Inherit', 'cosmos'),
				'cover'   => esc_html__( 'Cover', 'cosmos'),
				'contain' => esc_html__( 'Contain', 'cosmos'),
			),
			'background-position' => array(
				''              => esc_html__( '-Background Position-', 'cosmos'),
				'left top'      => esc_html__( 'Left Top', 'cosmos'),
				'left center'   => esc_html__( 'Left Center', 'cosmos'),
				'left bottom'   => esc_html__( 'Left Bottom', 'cosmos'),
				'center top'    => esc_html__( 'Center Top', 'cosmos'),
				'center center' => esc_html__( 'Center Center', 'cosmos'),
				'center bottom' => esc_html__( 'Center Bottom', 'cosmos'),
				'right top'     => esc_html__( 'Right Top', 'cosmos'),
				'right center'  => esc_html__( 'Right Center', 'cosmos'),
				'right bottom'  => esc_html__( 'Right Bottom', 'cosmos'),
			),
			'background-attachment' => array(
				''        => esc_html__( '-Background Attachment-', 'cosmos'),
				'fixed'   => esc_html__( 'Fixed', 'cosmos'),
				'scroll'  => esc_html__( 'Scroll', 'cosmos'),
				'inherit' => esc_html__( 'Inherit', 'cosmos'),
			),
			'sidebar-layout' => array(
				'none'  => esc_html__( 'None', 'cosmos'),
				'left'  => esc_html__( 'Left', 'cosmos'),
				'right' => esc_html__( 'Right', 'cosmos')
			),
			'header_layout' => array(
				'one'   => 'header_style_01.png',
			),
			'menu_style' => array(
				'1'		=> 'menu_style_01.png',
				'2'		=> 'menu_style_02.png',
				'3'		=> 'menu_style_03.png',
				'4'		=> 'menu_style_04.png',
				'5'		=> 'menu_style_05.png',
			),
			'theme_skin_color' => array(
				'bronze'		=> 'skin_bronze.png',
				'black'			=> 'skin_black.png',
				'blue'			=> 'skin_blue.png',
				'green'			=> 'skin_green.png',
				'orange'		=> 'skin_orange.png',
				'red'			=> 'skin_red.png',
				'violet'		=> 'skin_violet.png',
				'yellow'		=> 'skin_yellow.png',
			),
		);
	}
	public static function author_social_links() {
		return array(
			'behance'       => esc_html__( 'Behance', 'cosmos' ),
			'delicious'     => esc_html__( 'Delicious', 'cosmos' ),
			'deviantart'    => esc_html__( 'Deviantart', 'cosmos' ),
			'facebook'      => esc_html__( 'Facebook', 'cosmos' ),
			'flickr'        => esc_html__( 'Flickr', 'cosmos' ),
			'foursquare'    => esc_html__( 'Foursquare', 'cosmos' ),
			'lastfm'        => esc_html__( 'Lastfm', 'cosmos' ),
			'linkedin'      => esc_html__( 'Linkedin', 'cosmos' ),
			'git'           => esc_html__( 'Github', 'cosmos' ),
			'google-plus'   => esc_html__( 'Google+', 'cosmos' ),
			'instagram'     => esc_html__( 'Instagram', 'cosmos' ),
			'odnoklassniki' => esc_html__( 'Odnoklassniki', 'cosmos' ),
			'pinterest'     => esc_html__( 'Pinterest', 'cosmos' ),
			'rss'           => esc_html__( 'RSS', 'cosmos' ),
			'skype'         => esc_html__( 'Skype', 'cosmos' ),
			'soundcloud'    => esc_html__( 'Soundcloud', 'cosmos' ),
			'stumbleupon'   => esc_html__( 'Stumbleupon', 'cosmos' ),
			'tripadvisor'   => esc_html__( 'TripAdvisor', 'cosmos' ),
			'tumblr'        => esc_html__( 'Tumblr', 'cosmos' ),
			'twitter'       => esc_html__( 'Twitter', 'cosmos' ),
			'vimeo'         => esc_html__( 'Vimeo', 'cosmos' ),
			'vk'            => esc_html__( 'VK', 'cosmos' ),
			'weibo'         => esc_html__( 'Weibo', 'cosmos' ),
			'xing'          => esc_html__( 'XING', 'cosmos' ),
			'youtube'       => esc_html__( 'YouTube', 'cosmos' ),
		);
	} 
	public static function style_formats() {
		return array(
			'cosmos_dropcap' => array(
				'title' => esc_html__( 'Dropcaps', 'cosmos' ),
				'items' => array(
					array(
						'parent_id' => 'cosmos_dropcap',
						'title'     => esc_html__( 'Box', 'cosmos' ),
						'classes'   => 'dropcap',
						'inline'    => 'span',
					),
					array(
						'parent_id' => 'cosmos_dropcap',
						'title'     => esc_html__( 'Circle', 'cosmos' ),
						'classes'   => 'dropcap1',
						'inline'    => 'span',
					),
					array(
						'parent_id' => 'cosmos_dropcap',
						'title'     => esc_html__( 'Regular', 'cosmos' ),
						'classes'   => 'dropcap2',
						'inline'    => 'span',
					),
					array(
						'parent_id' => 'cosmos_dropcap',
						'title'     => esc_html__( 'Bold', 'cosmos' ),
						'classes'   => 'dropcap3',
						'inline'    => 'span',
					),
				)
			),
			'cosmos_text_highlight' => array(
				'title' => esc_html__( 'Text Highlighting', 'cosmos' ),
				'items' => array(
					array(
						'parent_id' => 'cosmos_text_highlight',
						'title'     => esc_html__( 'Black censured', 'cosmos' ),
						'classes'   => 'highlight',
						'inline'    => 'span',
					),
					array(
						'parent_id' => 'cosmos_text_highlight',
						'title'     => esc_html__( 'Red marker', 'cosmos' ),
						'classes'   => 'highlight_maker red',
						'inline'    => 'span',
					),
					array(
						'parent_id' => 'cosmos_text_highlight',
						'title'     => esc_html__( 'Blue marker', 'cosmos' ),
						'classes'   => 'highlight_maker blue',
						'inline'    => 'span',
					),
					array(
						'parent_id' => 'cosmos_text_highlight',
						'title'     => esc_html__( 'Green marker', 'cosmos' ),
						'classes'   => 'highlight_maker green',
						'inline'    => 'span',
					),
					array(
						'parent_id' => 'cosmos_text_highlight',
						'title'     => esc_html__( 'Yellow  marker', 'cosmos' ),
						'classes'   => 'highlight_maker yellow ',
						'inline'    => 'span',
					),
					array(
						'parent_id' => 'cosmos_text_highlight',
						'title'     => esc_html__( 'Pink  marker', 'cosmos' ),
						'classes'   => 'highlight_maker pink ',
						'inline'    => 'span',
					),
				)
			),
			'cosmos_blockquote' => array(
				'title' => esc_html__( 'Text Blockquote', 'cosmos' ),
				'items' => array(
					array(
						'parent_id' => 'cosmos_blockquote',
						'title'		=> esc_html__( 'Style 01', 'cosmos' ),
						'block'		=> 'blockquote',
						'classes'	=> 'blockquote-01 blockquote',
						'wrapper'	=> true,
					),
				)
			)
		);
	}
	public static function sort_blog(){
		return array(
			esc_html__( '- Latest -', 'cosmos' )               => '',
			esc_html__( 'A to Z', 'cosmos')                    => 'az_order',
			esc_html__( 'Z to A', 'cosmos')                    => 'za_order',
			esc_html__( 'Random posts today', 'cosmos' )       => 'random_today',
			esc_html__( 'Random posts a week ago', 'cosmos' )  => 'random_7_day',
			esc_html__( 'Random posts a month ago', 'cosmos' ) => 'random_month',
			esc_html__( 'Random Posts', 'cosmos' )             => 'random_posts',
			esc_html__( 'Most Commented', 'cosmos' )           => 'comment_count',
		);
	}
	
	
}