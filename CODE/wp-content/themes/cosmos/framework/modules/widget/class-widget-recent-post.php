<?php
/**
 * Widget_Recent_Post class.
 * 
 * @since 1.0
 */
Cosmos::load_class( 'front.Blog' );
class Cosmos_Widget_Recent_Post extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => 'widget_pix_recent_post', 'description' => esc_html__( "A recent posts list.", 'cosmos') );
		parent::__construct( 'cosmos_recent_post', esc_html_x( 'PIX: Recent Posts', 'Recent posts widget', 'cosmos' ), $widget_ops );
	}
	function form( $instance ) {
		$default = array(
			'title'           		=> esc_html__( "Recent Post", 'cosmos'),
			'limit_post'      		=> '5',
			'show_date'       		=> 'on',
			'show_views_count'   	=> 'on',
			'show_comments_count' 	=> 'on',
			'show_thumbnail'  		=> 'on',
		);
		$check_box = array(
			'show_date'      		=> esc_html__( 'Display post date', 'cosmos' ),
			'show_views_count'  	=> esc_html__( 'Display view count', 'cosmos' ),
			'show_comments_count'  	=> esc_html__( 'Display comment count', 'cosmos' ),
			'show_thumbnail' 	   	=> esc_html__( 'Display thumbnail', 'cosmos' ),
		);
		$instance = wp_parse_args( (array) $instance, $default );
		$title 		= esc_attr( $instance['title'] );
		$limit_post = esc_attr( $instance['limit_post'] );
		?>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title', 'cosmos' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo  esc_attr( $this->get_field_id('limit_post') ); ?>"><?php esc_html_e( 'Number Post', 'cosmos' );?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id('limit_post') ); ?>" name="<?php echo esc_attr( $this->get_field_name('limit_post') ); ?>" value="<?php echo esc_attr( $limit_post ); ?>" />
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
			}
	}

	function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['limit_post'] = strip_tags( $new_instance['limit_post'] );
		$params = array(
				'title',
				'limit_post',
				'show_date',
				'show_views_count',
				'show_comments_count',
				'show_thumbnail',
			);
		foreach( $params as $item ) {
			$instance[$item] = strip_tags( $new_instance[$item] );
		}
		return $instance;
	}

	function widget($args, $instance) {
		extract( $args );
		$limit_post = $instance['limit_post'];
		$title      = apply_filters('widget_title', $instance['title']);
		$id         = Cosmos::make_id();
		$model = new Cosmos_Blog();
		$default = array(
			'layout'          		=> 'wg_recent_post',
			'title'           		=> '',
			'limit_post'      		=> '',
			'prefix_category' 		=> '',
			'show_date'       		=> '',
			'show_views_count'      => '',
			'show_comments_count'   => '',
			'show_thumbnail'  		=> '',
			'show_category'   		=> '',
		);
		$check_box = array(
			'show_date'      		=> '',
			'show_thumbnail' 		=> '',
			'show_views_count'     	=> '',
			'show_comments_count'  	=> '',
		);
		$instance = wp_parse_args( (array) $instance, $default );
		extract( $instance );
		$atts = $instance;
		foreach( $check_box as $k => $v ) {
			if( isset($atts[$k]) && $atts[$k] != 'on'){
				$atts[$k] = 'hide';
			}
			if( isset($atts[$k]) && $atts[$k] == 'on') {
				$atts[$k] = '';
			}
		}
		$model->init( $atts);
		$model->large_image_post = false;
		$model->show_widget_meta = true;
		$show_thumbnail  	= '';
		$show_views_count   = '';
		$show_comments_count   = '';
		$show_date       	= '';
		$show_cls = '';
		if( $atts['show_date'] != 'hide' ) {
			$show_date = '%3$s';
			if( $atts['show_views_count'] != 'hide' || $atts['show_comments_count'] != 'hide' ){
				$show_date .= '<span class="sep">/</span>';
			}
		}

		if( $atts['show_views_count'] != 'hide' ) {
			$show_views_count = '<span class="fa-custom">%4$s '.esc_html__( 'viewed', 'cosmos' ).'</span>';
			if( $atts['show_views_count'] != 'hide' ){
				$show_views_count .= '<span class="sep">/</span>';
			}
		}

		if( $atts['show_comments_count'] != 'hide' ) {
			$show_comments_count = '%5$s';
		}
		if( $atts['show_thumbnail'] != 'hide' ) {
			$show_thumbnail = '%1$s';
		}
		if($atts['show_date'] != 'hide' || $atts['show_views_count'] != 'hide' || $atts['show_comments_count'] != 'hide' ){
			$show_cls = '<div class="meta-info">'.$show_date.$show_views_count.$show_comments_count.'</div>';
		}
		$html_format = '<div class="single-recent-post-widget">
								'.$show_thumbnail.'
								<div class="post-info">
									%2$s
									'.$show_cls.'
								</div>
						</div>';
		echo wp_kses_post( $before_widget );?>
		<div class="recent-post-widget widget wg-recent-post <?php echo esc_attr( $id );?>">
			<?php
				if( !empty( $title ) ){
					echo wp_kses_post( $before_title );
					echo esc_attr( $title );
					echo wp_kses_post( $after_title );
				}
				if ( $model->query->have_posts() ) :?>
					<div class="content-widget">
						<div class="recent-post-list">
						<?php
							$post_options = array(
								'small_post_format' 	=> $html_format,
								'small_not_div'         => true,
								'thumb_href_class'		=> 'thumb img-wrapper',
								);
							$model->render_block( $post_options );
						?>
						</div>
					</div>
				<?php
				endif;
			?>
		</div>
		<?php 
		echo wp_kses_post( $after_widget );
	}
}
