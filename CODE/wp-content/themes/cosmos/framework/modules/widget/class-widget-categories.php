<?php 
/**
 * Widget_Categories class.
 *
 * @since 1.0
 */

class Cosmos_Widget_Categories extends WP_Widget{
	
	public function __construct(){
		$widget_ops = array('classname' => 'widget_pix_categories', 'description' => esc_html__('A list of categories','cosmos'));
		parent::__construct('cosmos_categories', esc_html_x('PIX: Categories', 'Categories widget','cosmos' ),$widget_ops);
	}
	
	function form($instance){
		$default = array(
			'title'      => esc_html__("Categories", 'cosmos'),
			'limit_list' => '5',
			'taxonomy'   => '',
			'show_count' => 'on',
		);
		$check_box = array(
			'show_count'      	=> esc_html__( 'Show post counts?', 'cosmos' ),
		);
		$instance = wp_parse_args((array) $instance, $default);
		$title      = $instance['title'];
		$limit_list = $instance['limit_list'];
		$taxonomy   = $instance['taxonomy'];
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title') );?>"><?php esc_html_e('Title: ', 'cosmos' ); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('title') ); ?>" name="<?php echo esc_attr($this->get_field_name('title') ); ?>" value="<?php echo esc_attr($title); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('limit_list') );?>"><?php esc_html_e('Enter limit of list category: ', 'cosmos' ); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('limit_list') ); ?>" name="<?php echo esc_attr($this->get_field_name('limit_list') ); ?>" value="<?php echo esc_attr($limit_list); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('taxonomy') ); ?>"><?php esc_html_e( 'Choose Taxonomy', 'cosmos' );?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('taxonomy') ); ?>" name="<?php echo esc_attr( $this->get_field_name('taxonomy') ); ?>" >
			<?php
				$arr_tax = array(
					''							=> esc_html__( 'Categories', 'cosmos' ),
					'cosmos_room_cat'		=> esc_html__( 'Room Categories', 'cosmos' ),
					'cosmos_tour_cat'		=> esc_html__( 'Tour Categories', 'cosmos' ),
					'cosmos_tour_location'	=> esc_html__( 'Tour Location', 'cosmos' ),
					'cosmos_team_cat'		=> esc_html__( 'Team Categories', 'cosmos' ),
					'cosmos_restaurant_cat'	=> esc_html__( 'Restaurant Categories', 'cosmos' ),
					'cosmos_package_cat'		=> esc_html__( 'Package Categories', 'cosmos' ),
					'cosmos_gallery_cat'		=> esc_html__( 'Gallery Categories', 'cosmos' ),
					'cosmos_activity_cat'	=> esc_html__( 'Activity Categories', 'cosmos' ),
				);
				foreach( $arr_tax as $key=>$value ){
					$selected = '';
					if( $taxonomy == $key ){
						$selected = 'selected';
					}
					printf('<option value="%1$s" %2$s>%3$s</option>', $key, $selected, $value);
				}
			?>
			</select>
		</p>
		<?php
			$format = '
				<p>
					<input class="checkbox" type="checkbox" %1$s id="%2$s" name="%3$s" />
					<label for="%4$s">%5$s</label>
				</p>';
			foreach( $check_box as $field => $text ) {
				printf( $format,
						checked($instance[$field], 'on', false ),
						esc_attr( $this->get_field_id($field) ),
						esc_attr( $this->get_field_name($field) ),
						esc_attr( $this->get_field_id($field) ),
						$text
					);
			}?>
	<?php
	}
	function update($new_instance,$old_instance){
		$instance = $old_instance;
		$instance['title']      = strip_tags($new_instance['title']);
		$instance['limit_list'] = strip_tags($new_instance['limit_list']);
		$instance['taxonomy']   = strip_tags($new_instance['taxonomy']);
		$instance['show_count'] = strip_tags($new_instance['show_count']);
		return $instance;
	}
	function widget($args,$instance){
		extract($args);
		$class_is_count = '';
		$default = array(
			'title'      => '',
			'limit_list' => '',
			'taxonomy'   => '',
			'show_count' => ''
		);
		$instance = wp_parse_args((array) $instance, $default);
		$title = apply_filters('widget_title',$instance['title'] );
		$limit_list   = $instance['limit_list'];
		$taxonomy     = $instance['taxonomy'];
		$show_count   = $instance['show_count'];
		if( empty($taxonomy) ) {
			$taxonomy = 'category';
		}

		$args_list = array(
			'show_option_none'		=> esc_html__( 'No categories', 'cosmos' ),
			'style'					=> 'list',
			'taxonomy'				=> $taxonomy,
			'title_li'				=> '',
		);
		if ( !empty($show_count) ) {
			$args_list['show_count'] = 1;
			$class_is_count = 'is_count';
		}
		if ( !empty($limit_list) ) {
			$args_list['number'] = $limit_list;
		}

		echo wp_kses_post( $before_widget );
		?>
			<div class="categories-widget widget">
				<?php
				if( !empty( $title ) ) {
					echo wp_kses_post( $before_title );
					echo esc_html( $title );
					echo wp_kses_post( $after_title );
				}
				?>
				<div class="content-widget">
					<ul class="widget-list <?php echo esc_attr($class_is_count);?>">
						<?php 
						wp_list_categories($args_list);
						?>
					</ul>
				</div>
			</div>
		<?php 
		echo wp_kses_post( $after_widget );
	}
}