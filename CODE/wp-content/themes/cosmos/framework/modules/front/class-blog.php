<?php
Cosmos::load_class( 'models.Blog_Model' );

class Cosmos_Blog extends Cosmos_Blog_Model {

	private $row_post_counter = 0;
	private $row_counter;
	private $post_counter = 0;
	private $block_atts;
	
	public $large_image_post = true;
	public $start_group = true;
	public $show_full_meta = true;
	public $show_widget_meta = false;

	public function init( $atts ) {
		// default
		$this->large_image_post = true;
		$this->start_group = true;
		$this->row_post_counter = 0;
		$this->row_counter = 1;
		$this->post_counter = 0;

		// set attributes
		$this->block_atts = $atts;
		$this->set_attributes( $atts );
		$this->block_atts['block-class'] = $this->attributes['block-class'];

		$this->get_thumb_size();
		$this->set_responsive_class($atts);
		
	}
	public function set_post_options_defaults( $atts ) {
		$default = array(
			'large_post_format' => '',
			'small_post_format' => '',
			'open_group'        => '',
			'open_row'          => '',
			'close_row'         => '',
			'close_group'       => '',
			'content_length'    => '',
			'large_post_counter'=> 1,
			'show_related_post' => '',
			'new_row'           => '1',
			'thumb_href_class'  => '',
			'show_full_meta'    => '',
			'show_widget_meta'  => '',
			'meta_more_format'  => '',
			'html_format'       => '',
			'title_format'      => '<a href="%2$s" class="%3$s" >%1$s</a>',
			'excerpt_format'    => '<div class="text">%1$s</div>',
			'meta_info_format'  => '<div class="content-text">%1$s</div>',
			'video_format'      => '<div class="video-thumbnail">
										<div class="video-bg">
											%2$s
										</div>
										<div class="video-button-play"><i class="icons fa fa-play"></i></div>
										<div class="video-button-close"><i class="fa fa-times"></i></div>
										%1$s
									</div>',
			'no_thumbnails_image' => '',
			'bg_image' => '',
		);
		foreach($default as $key => $val ) {
			if( isset( $atts[$key] ) ) {
				$default[$key] = $atts[$key];
				unset( $atts[$key] );
			}
		}
		if( $atts ) {
			foreach($atts as $key => $val ) {
				$default[$key] = $atts[$key];
			}
		}
		return $default;
	}
	public function set_responsive_class($atts) {
		$class = '';
		$column = $this->attributes['column'];
		if( isset($atts['res_class']) ) {
			$class = $atts['res_class'];
		}
		$def = array(
			'1' => 'col-sm-12',
			'2' => 'col-sm-6 ' . $class,
			'3' => 'col-sm-4 col-xs-12',
			'4' => 'col-sm-3',
		);;
		
		if( $column && isset($def[$column])) {
			$this->attributes['responsive-class'] = $def[$column];
		} else {
			$this->attributes['responsive-class'] = $def['1'];
		}
	}
	/**
	 * Render html to author
	 *
	 */
	public function render_author( $options = array() ) {
		$this->html_format = $this->set_post_options_defaults( $options );
		$number_post = $this->query->query_vars['posts_per_page'] * ( $this->query->query_vars['paged'] -1 );
		$count = 0;
		if( $this->query->have_posts() ) {
			while ( $this->query->have_posts() ) {
				$count++;
				$this->query->the_post();
				$this->loop_index();
				$post_class = $this->get_post_class();
				$excerpt = $this->get_excerpt();
				if( $this->attributes['style'] == 'layout-2' && $this->attributes['show_content'] == 'content' ){
					$excerpt = apply_filters('the_content', get_the_content());
				}
				printf( $this->html_format['html_format'],
						$this->get_featured_by_format( 'large', $options ),
						$this->get_post_date(),
						$this->get_title(),
						$this->get_meta_info(),
						$excerpt,
						$post_class
				);
			}// end while
			// reset query
			wp_reset_postdata();
		}
	}

	public function render_block( $options = array() ) {
		$exclude = array();
		$options = $this->set_post_options_defaults( $options );
		while ( $this->query->have_posts() ) {
			$this->query->the_post();
			$this->loop_index();
			$this->post_counter ++;
			$related_post = '';
			$limit_content = true;
			// render post
			$html_format = $options['small_post_format'];
			if( $this->large_image_post ) {
				// large image group
				if( empty($options['large_post_counter']) || 
					( !empty($options['large_post_counter']) && $options['large_post_counter'] == $this->post_counter ) ) {
						$this->large_image_post = false;
				}
				$type = 'large';
				$related_post = $this->get_related_post($this->attributes['related_post_count']);
				$html_format = $options['large_post_format'];
				$limit_content = false;
				if( isset($options['large_thumb_href_class'] ) ) {
					$options['thumb_href_class'] = $options['large_thumb_href_class'];
				}
				if( isset($options['large_title_class'])) {
					$options['title_class'] = $options['large_title_class'];
				}
			} else {
				if( isset($options['small_thumb_href_class'] ) ) {
					$options['thumb_href_class'] = $options['small_thumb_href_class'];
				}
				unset($options['title_class']);
				if( isset($options['small_title_class'])) {
					$options['title_class'] = $options['small_title_class'];
				}
				// small image group
				$type = 'small';
				if( $this->start_group ) {
					echo wp_kses_post( $options['open_group'] . $options['open_row'] );
					$this->start_group = false;
				}
				$this->row_post_counter ++;
			}
			if( $options['new_row'] && $this->attributes['column'] > 1 && $this->row_post_counter > $this->attributes['column'] ) {
				// add new row
				$this->row_counter ++;
				$this->row_post_counter = 1;
				echo wp_kses_post( $options['close_row'] . $options['open_row'] );
			}
			$options['title_format'] = '<a href="%2$s" class="title-post">%1$s</a>';
			printf( $html_format,
					$this->get_featured_image( $type, false, $options ),
					$this->get_title(true,false,$options),
					$this->get_date(false, true),
					$this->get_post_view(),
					$this->get_comments(false, '<span class="fa-custom">%2$s '.esc_html__( 'comments', 'cosmos' ).'</span>', false)
			);
		}// end while
		echo wp_kses_post( $options['close_row'] . $options['close_group'] );
		// reset postdata
		wp_reset_postdata();
	}

	public function render_related_post( $options = array() ) {
		$options = $this->set_post_options_defaults( $options );
		while ( $this->query->have_posts() ) {
			$this->query->the_post();
			$this->loop_index();
			$this->post_counter ++;
			if ( has_post_thumbnail( $this->post_id ) ) {
				$html_format = $options['html_format'];
			} else {
				$html_format = $options['html_format_no_image'];
			}
			printf( $html_format,
					$this->get_featured_image( 'medium', false, $options ),
					$this->get_title(true,false,$options),
					$this->get_category($options),
					$this->get_excerpt(true),
					$this->permalink
			);
		}
		wp_reset_postdata();
	}

	public function get_meta_info() {
		$meta_array = array(
			'author'   => $this->get_author(),
			'view'     => $this->get_views(),
			'comment'  => $this->get_comments()
		);
		$output = '';
		foreach( $meta_array as $key => $val ) {
			if( !empty( $val ) ) {
				$output .= $val;
			}
		}
		if( !empty( $output ) ) {
			$output = sprintf( $this->html_format['meta_info_format'], $output );
		}
		return $output;
	}
	
	private function get_thumb_size() {
		$params = Cosmos_Params::get('default-image-size');
		if( !isset($params[$this->attributes['layout']]) ) {
			$this->attributes['thumb-size'] = array(
				'large'          => 'post-thumbnail',
				'no-image-large' => 'thumb-800x600.gif',
			);
		}
		else {
			$this->attributes['thumb-size'] = $this->get_thumb_sizes( $params[$this->attributes['layout']], $this->attributes );
		}
	}
	
	private function get_post_date() {
		$format = '<a href="%4$s" class="wrapper-infomation dates">
						<span class="day">%1$s</span><span class="month-year">- %2$s</span><span class="year">%3$s</span>
					</a>';
		$day    = get_the_time('d');
		$month  = get_the_time('F');
		$year   = get_the_time('Y');
		$output = sprintf( $format, $day, $month, $year, esc_url( cosmos_get_link_url() ) );
		return $output;
	}

	//paging
	public  function paging_nav( $pages = '', $range = 2, $current_query = '' ) {
		$theme_post_pagination_link = 'cosmos_post_pagination_link';
		global $paged;
		if( $current_query == '' ) {
			if( empty( $paged ) ) $paged = 1;
		} else {
			$paged = $current_query->query_vars['paged'];
		}
		$prev = $paged - 1;
		$next = $paged + 1;
		$range = 1; // only edit this if you want to show more page-links
		$showitems = ($range * 2);
		
		if( $pages == '' ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if( ! $pages ) {
				$pages = 1;
			}
		}
		$method = "get_pagenum_link";
		if(is_single()) {
			$method = self::theme_post_pagination_link;
		}
		$output = $output_page = $showpages = $disable = '';
		$page_format = '<li class="pagi-inner"><a href="%2$s" class="pagi-link" >%1$s</a></li>';
		if( 1 != $pages ) {
			$output_page .= '<ul class="pagination">';
			// prev
			if( $paged == 1 ) {
				$disable = ' hide';
			}
			$output_page .= '<li class="pagi-inner '.$disable.'"><a href="'.$method($prev).'" rel="prev" class="pagi-link"><span aria-hidden="true" class="fa fa-chevron-left"></span></a></li>';
			// first pages
			if( $paged > $showitems ) {
				$output_page .= sprintf( $page_format, 1, $method(1) );
			}
			// show ...
			if( $paged - $range > $showitems && $paged - $range > 2 ) {
				$output_page .= sprintf( $page_format, '&bull;&bull;&bull;', $method($paged - $range - 1) );'<li><a href="'.$method($prev).'">&bull;&bull;&bull;</a></li>';
			}
			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$showitems || $i <= $paged-$showitems) || $pages <= $showitems )) {
					if( $paged == $i ) {
						$output_page .= '<li class="pagi-inner"><span class="pagi-link active">'.$i.'</span></li>';
					} else {
						$output_page .= sprintf( $page_format, $i, $method($i) );
					}
					$showpages = $i;
				}
			}
			// show ...
			if( $paged < $pages-1 && $showpages < $pages -1 ){
				$showpages = $showpages + 1;
				$output_page .= sprintf( $page_format, '...', $method($showpages) );
			}
			// end pages
			if( $paged < $pages && $showpages < $pages ) {
				$output_page .= sprintf( $page_format, $pages, $method($pages) );
			}
			//next
			$disable = '';
			if( $paged == $pages ) {
				$disable = ' hide';
			}
			$output_page .= '<li class="pagi-inner '.$disable.'"><a href="'.$method($next).'" rel="next" class="pagi-link"><span aria-hidden="true" class="fa fa-chevron-right"></span></a></li>';
			$output_page .= '</ul>'."\n";
			$output = sprintf('<nav class="pagination-wrapper">%1$s</nav>', $output_page );
		}
		return $output;
	}
	
}