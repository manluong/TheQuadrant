<?php
/**
 * Widget_advertisement class.
 * 
 * @since 1.0
 */
Cosmos_Core::load_class( 'Abstract' );
class Cosmos_Widget_Advertisement extends WP_Widget {
	
	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_advertisement', 'description' => esc_html__( 'A list advertisement.', 'cosmos' ) );
		parent::__construct( 'cosmos_advertisement', esc_html_x( 'PIX: Advertisement', 'advertisement widget', 'cosmos' ), $widget_ops );
	}
	
	function form( $instance ) {
		$default = array(
			'title' => '',
			'url'	=> '',
			'image'	=> '',
		);
		$instance   = wp_parse_args( (array) $instance, $default );
		$title      = esc_attr( $instance['title'] );
		$url        = esc_attr( $instance['url'] );
		$image      = esc_attr( $instance['image'] );
		?>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title', 'cosmos' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('url') ); ?>"><?php esc_html_e( 'Link', 'cosmos' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('url') ); ?>" name="<?php echo esc_attr( $this->get_field_name('url') ); ?>" value="<?php echo esc_attr( $url ); ?>" />
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('image') ); ?>"><?php esc_html_e( 'Image', 'cosmos' );?></label>
			<?php 
			$abstract = new Cosmos_Abstract();

			echo ( $abstract->single_image( esc_attr( $this->get_field_name('image') ),
																esc_attr( $image ),
																array( 'id'=> $this->get_field_id('image').'_name',
																	'data-rel' => $this->get_field_id('image') ) ) );
			?>
		</p>
		<?php
	}
	
	function update( $new_instance, $old_instance ) {
		$instance 			= $old_instance;
		$instance['title'] 	= strip_tags( $new_instance['title'] );
		$instance['url']	= strip_tags( $new_instance['url'] );
		$instance['image'] 	= strip_tags( $new_instance['image'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$arr_advertisement  = Cosmos_Params::get('advertisement-icons');
		$url = !empty($instance['url']) ? esc_url($instance['url']) : 'javascript:;';
		$alt = !empty($instance['title']) ? $instance['title'] : 'advertisement';
		echo wp_kses_post( $before_widget );
			echo '<div class="advertisement-widget">';
				if( !empty( $title ) ) {
					echo wp_kses_post( $before_title );
					echo esc_attr( $title );
					echo wp_kses_post( $after_title );
				}
				echo '<div class="content-widget">';
					if( !empty( $instance['image'] ) ){
						printf('<a href="%1$s"><img src="%2$s" alt="%3$s" class="img-responsive"/></a>',
						esc_attr( $url ),
						esc_url( $instance['image'] ),
						esc_attr( $alt )
						);
					}
				echo '</div>';
			echo '</div>';
		echo wp_kses_post( $after_widget );
	}
}