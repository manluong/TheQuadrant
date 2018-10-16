<?php
/**
 * Widget_Init class.
 * 
 * @since 1.0
 */
Cosmos::load_class( 'widget.Widget_Social' );
Cosmos::load_class( 'widget.Widget_Recent_Post' );
if(COSMOS_CORE_IS_ACTIVE) {
	Cosmos::load_class( 'widget.Widget_Advertisement' );
	Cosmos::load_class( 'widget.Widget_Categories' );
}
class Cosmos_Widget_Init {
	/**
	 * Load widgets
	 *
	 */
	public function load() {
		register_widget( 'Cosmos_Widget_Social' );
		register_widget( 'Cosmos_Widget_Recent_Post' );
		if(COSMOS_CORE_IS_ACTIVE) {
			register_widget( 'Cosmos_Widget_Advertisement' );
			register_widget( 'Cosmos_Widget_Categories' );
		}
	}
	/**
	 * Register sidebars
	 *
	 */
	public function widgets_init() {
		register_sidebar( array (
			'name'          => esc_html__( 'Default Widget Area', 'cosmos' ),
			'id'            => 'cosmos-sidebar-default',
			'description'   => esc_html__( 'Add widgets here to appear in sidebar of posts and pages', 'cosmos'),
			'before_widget' => '<div id="%1$s" class="widget-sidebar pix-widget  box %2$s widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="title-widget">',
			'after_title'   => '</div>'
		));
		//Register sidebar main
		register_sidebar( array (
			'name'          => esc_html__( 'Main Widget Area', 'cosmos' ),
			'id'            => 'cosmos-sidebar-main',
			'description'   => esc_html__( 'Add widgets here to appear in sidebar pages.', 'cosmos' ),
			'before_widget' => '<div id="%1$s" class="widget-sidebar pix-widget  box %2$s widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="title-widget">',
			'after_title'   => '</div>'
		));
		//Register sidebar mblog
		register_sidebar( array (
			'name'          => esc_html__( 'Blog Widget Area', 'cosmos' ),
			'id'            => 'cosmos-sidebar-blog',
			'description'   => esc_html__( 'Add widgets here to appear in sidebar of posts.', 'cosmos' ),
			'before_widget' => '<div id="%1$s" class="widget-sidebar pix-widget box %2$s widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="title-widget">',
			'after_title'   => '</div>'
		));
		// Register custom sidebar
		$sidebars = get_option('cosmos_custom_sidebar');
		$args =  array (
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => ''
		);
		if( is_array( $sidebars ) ) {
			foreach ( $sidebars as $sidebar ) {
				if( !empty($sidebar) ) {
					$name = isset($sidebar['name']) ? $sidebar['name'] : '';
					$title = isset($sidebar['title']) ? $sidebar['title'] : '';
					$class = isset($sidebar['class']) ? $sidebar['class'] : '';
					$args['name']   = $title;
					$args['id']     = str_replace(' ','-',strtolower( $name ));
					$args['class']  = 'pix-custom';
					$args['before_widget'] = '<div class="widget-sidebar pix-widget box %2$s widget '. $class .'">';
					$args['after_widget']  = '</div>';
					$args['before_title']  = '<div class="title-widget">';
					$args['after_title']   = '</div>';
					register_sidebar($args);
				}
			}
		}
	}
	/**
	 * Add custom sidebar area
	 *
	 */
	public function add_widget_field() {
		$nonce =  wp_create_nonce ('cosmos-delete-sidebar-nonce');
		$nonce = '<input type="hidden" name="cosmos-delete-sidebar-nonce" value="'.esc_attr($nonce).'" />';
		echo "\n<script type='text/html' id='cosmos-custom-widget'>";
		echo "\n  <form class='cosmos-add-widget' method='POST'>";
		echo "\n  <h3>".esc_html__('Cosmos Custom Widgets', 'cosmos')."</h3>";
		echo "\n    <input class='cosmos_style_wrap' type='text' value='' placeholder = '". esc_html__('Enter Name of the new Widget Area here', 'cosmos') ."' name='cosmos-add-widget[name]' />";
		echo "\n    <input class='cosmos_style_wrap' type='text' value='' placeholder = '". esc_html__('Enter class display on front-end', 'cosmos') ."' name='cosmos-add-widget[class]' />";
		echo "\n    <input class='cosmos_button' type='submit' value='". esc_html__('Add Widget Area', 'cosmos') ."' />";
		echo "\n    ".$nonce;
		echo "\n  </form>";
		echo "\n</script>\n";
	}

	public function add_sidebar_area() {
		if( isset($_POST['cosmos-add-widget']) && !empty($_POST['cosmos-add-widget']['name']) ) {
			$sidebars = array();
			$sidebars = get_option('cosmos_custom_sidebar');
			$name = $this->get_name($_POST['cosmos-add-widget']['name']);
			$class = $_POST['cosmos-add-widget']['class'];
			$sidebars[] = array('name'=>sanitize_title($name), 'title' => $name, 'class'=>$class);
			update_option('cosmos_custom_sidebar', $sidebars);
			wp_redirect( esc_url( admin_url('widgets.php') ) );
			die();
		}
	}

	public function get_name( $name ) {
		if( empty($GLOBALS['wp_registered_sidebars']) ){
			return $name;
		}

		$taken = array();
		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
			$taken[] = $sidebar['name'];
		}
		$sidebars = get_option('cosmos_custom_sidebar');

		if( empty($sidebars) ) {
			$sidebars = array();
		}

		$taken = array_merge($taken, $sidebars);
		if( in_array($name, $taken) ) {
			$counter  = substr($name, -1);
			$new_name = "";
			if( !is_numeric($counter) ) {
				$new_name = $name . " 1";
			}
			else {
				$new_name = substr($name, 0, -1) . ((int) $counter + 1);
			}
			$name = $new_name;
		}
		return $name;
	}
	public function delete_custom_sidebar() {
		check_ajax_referer('cosmos-delete-sidebar-nonce');
		if( !empty($_POST['name']) ) {
			$name = sanitize_title($_POST['name']);
			$sidebars = get_option('cosmos_custom_sidebar');
			foreach($sidebars as $key => $sidebar){
				if( strcmp(trim($sidebar['name']), trim($name)) == 0) {
					unset($sidebars[$key]);
					update_option('cosmos_custom_sidebar', $sidebars);
					echo "success";
					break;
				}
			}
		}
		die();
	}
}