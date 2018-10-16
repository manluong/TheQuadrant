<?php
/**
 * Widget_Social class.
 * 
 * @since 1.0
 */

class Cosmos_Widget_Social extends WP_Widget {
	
	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_social', 'description' => esc_html__( 'A list social links.', 'cosmos' ) );
		parent::__construct( 'cosmos_social', esc_html_x( 'PIX: Social', 'Social widget', 'cosmos' ), $widget_ops );
	}
	
	function form( $instance ) {
		$default = array(
			'title' => esc_html__("Social", 'cosmos' ),
			'style' => '1',
		);
		$social_default = array();
		$arr_social = Cosmos_Params::get('social-icons');
		foreach($arr_social as $k => $v){
			$social_default[$k] = '';
		}
		$instance   = wp_parse_args( (array) $instance, $social_default );
		$instance   = wp_parse_args( (array) $instance, $default );
		$title      = esc_attr( $instance['title'] );
		$style      = esc_attr( $instance['style'] );
		?>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('style') ); ?>"><?php esc_html_e('Display Style', 'cosmos');?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name('style') ); ?>" >
				<option value="1"<?php if( $style == 1 ) { echo " selected"; } ?>><?php esc_html_e('Style 1', 'cosmos');?></option>
				<option value="2"<?php if( $style == 2 ) { echo " selected"; } ?>><?php esc_html_e('Style 2', 'cosmos');?></option>
				<option value="3"<?php if( $style == 3 ) { echo " selected"; } ?>><?php esc_html_e('Style 3', 'cosmos');?></option>
				<option value="4"<?php if( $style == 4 ) { echo " selected"; } ?>><?php esc_html_e('Style 4', 'cosmos');?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title', 'cosmos' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
		foreach( $social_default as $k => $v ){
			printf('<p><label for="%1$s">%2$s<input type="text" class="widefat" id="%1$s" name="%3$s" value="%4$s" /></label></p>',
				esc_attr( $this->get_field_id($k) ),
				esc_attr( ucfirst( str_replace('-', ' ', $k ) ) ),
				esc_attr( $this->get_field_name($k) ),
				esc_attr($instance[$k])
			);
		}
	}
	
	function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['style'] = strip_tags( $new_instance['style'] );
		$arr_social        = Cosmos_Params::get('social-icons');
		foreach( $arr_social as $k => $v ){
			$instance[$k] = $new_instance[$k];
		}
		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$style       = $instance['style'];
		$arr_social  = Cosmos_Params::get('social-icons');
		echo wp_kses_post( $before_widget );
			echo '<div class="social-widget widget style-'.$style.'">';
				if( !empty( $title ) ) {
					echo wp_kses_post( $before_title );
					echo esc_attr( $title );
					echo wp_kses_post( $after_title );
				}
				echo '<div class="content-widget">';
					echo '<ul class="list-unstyled list-inline">';
						foreach( $arr_social as $k => $v ){
							if( !empty( $instance[$k] ) ){
								printf('<li><a href="%1$s" class="social-icon fa %3$s" target="_blank"></a></li>',
								esc_url( $instance[$k] ),
								esc_attr($k),
								esc_attr($v)
								);
							}
						}
					echo '</ul>';
				echo '</div>';
			echo '</div>';
		echo wp_kses_post( $after_widget );
	}
}