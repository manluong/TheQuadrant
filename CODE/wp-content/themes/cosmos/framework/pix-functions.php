<?php

// Set post view
add_action('wp_head', 'cosmos_postview_set');
if( ! function_exists( 'cosmos_postview_set' ) ) :

	function cosmos_postview_set() {
		global $post;
		$post_types = array('post');
		if( $post ) {
			$post_id = $post->ID;
			if( in_array(get_post_type(), $post_types) && is_single() ) {
				$count_key = 'cosmos_postview_number';
				$count = get_post_meta( $post_id, $count_key, true );
				if( $count == '' ) {
					$count = 0;
					delete_post_meta( $post_id, $count_key );
					add_post_meta( $post_id, $count_key, '0' );
				} else {
					$count++;
					update_post_meta( $post_id, $count_key, $count );
				}
			}
		}
	}
endif;

// Get post view
if( ! function_exists( 'cosmos_postview_get' ) ) :

	function cosmos_postview_get( $post_id ) {
		$view_text = esc_html__( 'view', 'cosmos' );
		$count_key = 'cosmos_postview_number';
		$count = get_post_meta( $post_id, $count_key, true );
		$res = '';
		if($count == '') {
			delete_post_meta( $post_id, $count_key );
			add_post_meta( $post_id, $count_key, '0' );
			$res = 0;
		} else {
			$res = $count;
		}
		return $res;
	}
endif;

//-----------------------------------------------
if ( ! function_exists( 'cosmos_is_custom_post_type_archive' ) ) :
function cosmos_is_custom_post_type_archive() {
	if( is_post_type_archive('cosmos_tour') || is_tax( 'cosmos_tour_cat' ) || is_tax( 'cosmos_tour_location' ) || is_tax( 'cosmos_tour_tag' ) ) {
		return 1;
	} else if( is_post_type_archive('cosmos_room') || is_tax( 'cosmos_room_cat' ) || is_tax( 'cosmos_room_tag' ) ) {
		return 2;
	} else if( is_post_type_archive('cosmos_team') || is_tax( 'cosmos_team_cat' ) ) {
		return 3;
	} else if( is_post_type_archive('cosmos_restaurant') || is_tax( 'cosmos_restaurant_cat' ) ) {
		return 4;
	} else if( is_post_type_archive('cosmos_activity') || is_tax( 'cosmos_activity_cat' ) ) {
		return 5;
	} else if( is_post_type_archive('cosmos_package') || is_tax( 'cosmos_package_cat' ) ) {
		return 6;
	} else if( is_post_type_archive('cosmos_gallery') || is_tax( 'cosmos_gallery_cat' )
			|| is_post_type_archive('cosmos_testi')   || is_tax( 'cosmos_testi_cat' )
			|| is_post_type_archive('cosmos_faq') 
			|| is_post_type_archive('cosmos_partner') ) {
		return 99;
	}
	return false;
}
endif;

// Breadcrumb
if ( ! function_exists( 'cosmos_get_breadcrumb' ) ) :
	function cosmos_get_breadcrumb()
	{
		if ( COSMOS_WOOCOMMERCE_ACTIVE && get_post_type() == 'product' ) 
		{
			$breadcrumbs = new WC_Breadcrumb();
			$breadcrumbs->add_crumb( esc_html_x( 'Home', 'breadcrumb', 'cosmos' ), apply_filters( 'woocommerce_breadcrumb_home_url', esc_url( home_url('/') ) ) );
		} else {
			$breadcrumbs = new Cosmos_Breadcrumb();
			$breadcrumbs->add_crumb( esc_html_x( 'Home', 'breadcrumb', 'cosmos' ), apply_filters( 'cosmos_breadcrumb_home_url', esc_url( home_url('/') ) ) );
		}
		return $breadcrumbs->generate();
	}
endif;
if( !function_exists( 'cosmos_is_wishlist_page') ) {
	/**
	 * Check if current page is wishlist
	 *
	 * @return bool
	 */
	function cosmos_is_wishlist_page() {
		if( ! COSMOS_WOOCOMMERCE_WISHLIST ) {
			return false;
		}
		$wishlist_page_id = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) );
		if ( ! $wishlist_page_id ) {
			return false;
		}
		return is_page( $wishlist_page_id );
	}
}
if( !function_exists( 'cosmos_get_post_id') ) {
	function cosmos_get_post_id(){
		$post_id = get_the_ID();
		$shop_page = false;
		if( COSMOS_WOOCOMMERCE_ACTIVE ) {
			if( is_shop() ) {
				$post_id = get_option('woocommerce_shop_page_id');
				$shop_page = true;
			} else if( is_cart() ) {
				$post_id = get_option('woocommerce_cart_page_id');
				$shop_page = true;
			} else if( is_account_page() ) {
				$post_id = get_option('woocommerce_myaccount_page_id');
				$shop_page = true;
			} else if( is_checkout() || is_checkout_pay_page() ) {
				$post_id = get_option('woocommerce_checkout_page_id');
				$shop_page = true;
			} else if( cosmos_is_wishlist_page() ) {
				$shop_page = true;
			}
		}
		return array($post_id, $shop_page);
	}
}

if( !function_exists('cosmos_regex') ) :

	function cosmos_regex($string, $pattern = false, $start = "^", $end = "")
	{
		if(!$pattern) return false;

		if($pattern == "url")
		{
			$pattern = "!$start((https?|ftp)://(-\.)?([^\s/?\.#-]+\.?)+(/[^\s]*)?)$end!";
		}
		else if($pattern == "mail")
		{
			$pattern = "!$start\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$end!";
		}
		else if($pattern == "image")
		{
			$pattern = "!$start(https?(?://([^/?#]*))?([^?#]*?\.(?:jpg|gif|png)))$end!";
		}
		else if(strpos($pattern,"<") === 0)
		{
			$pattern = str_replace('<',"",$pattern);
			$pattern = str_replace('>',"",$pattern);

			if(strpos($pattern,"/") !== 0) { $close = "\/>"; $pattern = str_replace('/',"",$pattern); }
			$pattern = trim($pattern);
			if(!isset($close)) $close = "<\/".$pattern.">";

			$pattern = "!$start\<$pattern.+?$close!";

		}

		preg_match($pattern, $string, $result);

		if(empty($result[0]))
		{
			return false;
		}
		else
		{
			return $result;
		}

	}
endif;

// Paging
if(!function_exists('cosmos_paging_nav')) :
	/**
	 * Displays a page pagination if more posts are available than can be displayed on one page
	 * @param string $pages pass the number of pages instead of letting the script check the gobal paged var
	 * @return string $output returns the pagination html code
	 */
	function cosmos_paging_nav( $pages = '', $current_query = '' )
	{
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
		
		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if( ! $pages ) {
				$pages = 1;
			}
		}
		$method = "get_pagenum_link";
		if(is_single()) {
			$method = 'cosmos_post_pagination_link';
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
						$output_page .= '<li class="active pagi-inner"><span class="pagi-link">'.$i.'</span></li>';
					} else {
						$output_page .= sprintf( $page_format, $i, $method($i) );
					}
					$showpages = $i;
				}
			}
			// show ...
			if( $paged < $pages-1 && $showpages < $pages -1 ){
				$showpages = $showpages + 1;
				$output_page .= sprintf( $page_format, '&bull;&bull;&bull;', $method($showpages) );
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

	function cosmos_post_pagination_link($link)
	{
		$url =  preg_replace('!">$!','',_wp_link_page($link));
		$url =  preg_replace('!^<a href="!','',$url);
		return $url;
	}

	function cosmos_get_pagenum_link( $pagenum = 1, $escape = true, $base = null) {
		global $wp_rewrite;

		$pagenum = (int) $pagenum;
	
		$request = $base ? remove_query_arg( 'paged', $base ) : remove_query_arg( 'paged' );
	
		$home_root = parse_url(home_url('/'));
		$home_root = ( isset($home_root['path']) ) ? $home_root['path'] : '';
		$home_root = preg_quote( $home_root, '|' );
	
		$request = preg_replace('|^'. $home_root . '|i', '', $request);
		$request = preg_replace('|^/+|', '', $request);
	
		if ( !$wp_rewrite->using_permalinks() || is_admin() ) {
			$base = trailingslashit( home_url('/') );
	
			if ( $pagenum > 1 ) {
				$result = add_query_arg( 'paged', $pagenum, $base . $request );
			} else {
				$result = $base . $request;
			}
		} else {
			$qs_regex = '|\?.*?$|';
			preg_match( $qs_regex, $request, $qs_match );
	
			if ( !empty( $qs_match[0] ) ) {
				$query_string = $qs_match[0];
				$request = preg_replace( $qs_regex, '', $request );
			} else {
				$query_string = '';
			}
	
			$request = preg_replace( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request);
			$request = preg_replace( '|^' . preg_quote( $wp_rewrite->index, '|' ) . '|i', '', $request);
			$request = ltrim($request, '/');
	
			$base = trailingslashit( home_url('/') );
	
			if ( $wp_rewrite->using_index_permalinks() && ( $pagenum > 1 || '' != $request ) )
				$base .= $wp_rewrite->index . '/';
	
			if ( $pagenum > 1 ) {
				$request = ( ( !empty( $request ) ) ? trailingslashit( $request ) : $request ) . user_trailingslashit( $wp_rewrite->pagination_base . "/" . $pagenum, 'paged' );
			}
	
			$result = $base . $request . $query_string;
		}
	
		/**
		 * Filter the page number link for the current request.
		 *
		 * @since 2.5.0
		 *
		 * @param string $result The page number link.
		 */
		$result = apply_filters( 'get_pagenum_link', $result );
	
		if ( $escape )
			return esc_url( $result );
		else
			return esc_url_raw( $result );
	}
endif;

// Post Navigation
if ( ! function_exists( 'cosmos_post_nav' ) ) :
	/**
	 * Display navigation to next/previous post when applicable.
	*
	*/
	function cosmos_post_nav() {
		global $post;
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
		if ( ! $next && ! $previous )
			return;
		?>
		<nav class="post-navigation row" >
			<div class="nav-links">
				<div class="col-sm-6 col-xs-12">
					<div class="pull-left nav-post prev-post">
					<?php previous_post_link( '%link', _x( '<i class="nav-meta fa fa-angle-left" aria-hidden="true"></i> %title', 'Previous post link', 'cosmos' ) ); ?>
					</div>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="pull-right nav-post next-post">
					<?php next_post_link( '%link', _x( '%title <i class="nav-meta fa fa-angle-right" aria-hidden="true"></i>', 'Next post link', 'cosmos' ) ); ?>
					</div>
				</div>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
endif;

// Get link of blog content ( post-format: link)
if ( ! function_exists( 'cosmos_get_link_url' ) ) :
	/**
	 * Return the post URL.
	 *
	 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
	 * the first link found in the post content.
	 *
	 * Falls back to the post permalink if no URL is found in the post.
	 *
	 *
	 * @return string The Link format URL.
	 */
	function cosmos_get_link_url() {
		$has_url = '';
		if( get_post_format() == 'link') {
			$content = get_the_content();
			$has_url = get_url_in_content( $content );
		}
		return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
endif;

// Get Format Date
if ( ! function_exists( 'cosmos_post_date' ) ) :
	function cosmos_post_date() {
		$output = '';
		$format_string = '
			<div class="meta-item dates">
				<a href="%4$s">
					<span class="day">%1$s</span>
					<span class="month-year">%2$s</span>
					<span class="year">%3$s</span>
				</a>
			</div>';
		$day = get_the_time('d');
		$month = get_the_time('M');
		$year = get_the_time('Y');
		$output = sprintf( $format_string, $day, $month, $year, esc_url( cosmos_get_link_url() ) );
		return $output;
	}
endif;

// Get css to show/hide sidebar
if ( ! function_exists( 'cosmos_get_container_css' ) ) :
	function cosmos_get_container_css( $show_sidebar = false ) {
		/* Global variable from theme option */
		do_action('cosmos_page_options');
		$def_sidebar = Cosmos::get_option('pix-sidebar-layout');
		$def_sidebar_id = Cosmos::get_option('pix-sidebar');
		$post_type = get_post_type();
		$sidebar = $sidebar_id = $has_sidebar = '';
		if( is_single() ) {
			if( $post_type == 'product' ) {
				$sidebar = Cosmos::get_option('pix-shop-sidebar-layout');
				$sidebar_id = Cosmos::get_option('pix-shop-sidebar');
			} 
			if( $post_type == 'post') {
				$sidebar = Cosmos::get_option('pix-blog-single-sidebar-layout');
				$sidebar_id = Cosmos::get_option('pix-blog-single-sidebar');
			} 
			if ($post_type == 'cosmos_team') {
				$sidebar = Cosmos::get_option('pix-team-single-sidebar-layout');
				$sidebar_id = Cosmos::get_option('pix-team-single-sidebar');
			}
		}else if( is_archive() ) {
			if( COSMOS_WOOCOMMERCE_ACTIVE ) {
				if( !is_shop()  && $post_type == 'product' ) {
					$sidebar = Cosmos::get_option('pix-shop-sidebar-layout');
					$sidebar_id = Cosmos::get_option('pix-shop-sidebar');
				}
			}
			if( $post_type == 'cosmos_team') {
				$sidebar = Cosmos::get_option('pix-team-sidebar-layout');
				$sidebar_id = Cosmos::get_option('pix-team-sidebar');
			}
			if( $post_type == 'post') {
				$sidebar = Cosmos::get_option('pix-blog-sidebar-layout');
				$sidebar_id = Cosmos::get_option('pix-blog-sidebar');
			}
			if( (is_author() || is_tax() || is_category() || is_archive()) && $post_type != 'product' ) {
				if( empty($sidebar)) {
					$sidebar = 'right';
				}
			}
		} else if( is_search() ) {
			$sidebar = 'right';
		}
		if( empty($sidebar)) {
			$sidebar = $def_sidebar;
		}
		if( empty($sidebar_id)) {
			$sidebar_id = $def_sidebar_id;
		}
		$content_css = 'col-md-8';
		$sidebar_css = 'col-md-4';

		if ( $sidebar == 'left' ) {
			$content_css = 'col-md-8 content-with-sidebar-left';
			$sidebar_css = 'col-md-4 sidebar-left';
		} else if ( $sidebar == 'right' ) {
			$content_css = 'col-md-8 content-with-sidebar-right';
			$sidebar_css = 'col-md-4 sidebar-right';
		} else {
			if( $show_sidebar ){
				$content_css = 'col-md-8 layout-left';
				$sidebar_css = 'col-md-4 layout-right';
			} else {
				$content_css = 'col-md-12';
				$sidebar_css = 'hide';
				$has_sidebar = 'none';
			}
		}
		$container_css = 'container';

		return array(
			'container_css' => $container_css,
			'content_css'   => $content_css,
			'sidebar_css'   => $sidebar_css,
			'sidebar'       => $sidebar,
			'sidebar_id'    => $sidebar_id,
			'has_sidebar'   => $has_sidebar
		);
	}
endif;

if ( ! function_exists( 'cosmos_get_sidebar' ) ) :
	function cosmos_get_sidebar( $sidebar_id ) {
		if( empty($sidebar_id) ) {
			get_sidebar();
		} else {
			if ( is_active_sidebar( $sidebar_id ) ) {
				dynamic_sidebar( $sidebar_id );
			}
		}
	}
endif;
/**
 * Custom callback function, see comments.php
 * 
 */
if ( ! function_exists( 'cosmos_display_comments' ) ) : 
	function cosmos_display_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		$comment_id = get_comment_ID();
		$url	= get_comment_author_url( $comment_id );
		$author = get_comment_author( $comment_id );
		?>
		<li class="parent" id="comment-<?php echo get_comment_ID() ?>">
			<div class="comment-item">
				<div class="comment-left">
					<div class="comment-wrapper-left">	
						<a href="<?php echo esc_url($url);?>" class="media-image"><?php echo get_avatar($comment, 70) ?></a>
					</div>
				</div>
				<div class="comment-right">
					<div class="comment-wrapper-right">						
						<div class="pull-left">
							<div class="author">
								<?php 
								if ( empty( $url ) || 'http://' == $url ){
									printf('<span>%2$s</span> <a class="url" title="%1$s">%1$s</a>',
										esc_html(ucfirst($author)),
										esc_html__( 'By', 'cosmos' )
									);
									
								}else {
									printf('<span>%3$s</span> <a class="url" href="%1$s" title="%2$s">%2$s</a>',
											esc_url($url),
											esc_html(ucfirst($author)),
											esc_html__( 'By', 'cosmos' )										
									);
								} ?>
								<span>|</span>
								<span class="date"><?php echo cosmos_display_comments_date(); ?></span>
							</div>
						</div>
						<div class="des"><?php comment_text() ?></div>
						<div class="pull-left">
							<?php
								$comment_reply_link_args = array(
									'depth'  => $depth, 
									'before' => '',
									'after'  => ''
								);
								comment_reply_link( array_merge ( $args, $comment_reply_link_args ) ); 
							?>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		<!-- </li> no open -->
		<?php
	}
endif;

if ( ! function_exists( 'cosmos_display_comments_date' ) ) : 
	function cosmos_display_comments_date() {
		$cmt_time = get_comment_time( 'U' );
		$current_time = current_time( 'timestamp' );
		$subtract_time = $current_time - $cmt_time;
		$days = ( 60*60*24*5 ); // 5 days
		if( $subtract_time > $days ){
			$res = get_comment_date();
		}
		else {
			$res = human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) );
			$res .= esc_html__( ' ago', 'cosmos' );
		}
		return $res;
	}
endif;
/*move field of comment form*/
if ( ! function_exists( 'cosmos_move_comment_field' ) ) : 
	function cosmos_move_comment_field( $fields ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;
		return $fields;
	}
	add_filter( 'comment_form_fields', 'cosmos_move_comment_field' );
endif;
/**
 * getPosts
 * @param  string $postType : post type
 * @param  array $params   	: aguments to get post
 * @return array            : posts terms and conditions
 */
if ( ! function_exists( 'cosmos_getPosts' ) ) : 
	function cosmos_getPosts($postType = null, $params = null, $wp_query = false) {
		$postType || $postType = 'post';
		$defaultParams = array(
			'post_type' => $postType,
			'posts_per_page' => -1,
			'suppress_filters' => false
		);
		($params != null && is_array($params)) && $defaultParams = array_merge($defaultParams, $params);
		return !$wp_query ? get_posts($defaultParams) : new WP_Query($defaultParams);
	}
endif;

/*
* getTermSimpleByPost (Related post or post tag)
* params:
* 		- post id
* 		- taxonomy: (taxonomy slug | category | post_tag)
* return: One term related by post
*/
if ( ! function_exists( 'cosmos_getTermSimpleByPost' ) ) : 
	function cosmos_getTermSimpleByPost( $postID, $taxonomy ) {
		if( empty( $postID ) && empty($taxonomy) ) {
			return;
		}
		$result = array();
		$terms = get_the_terms( $postID, $taxonomy );
		if ($terms && ! is_wp_error($terms)) {
			$result = current( $terms );
		}
		return (array)$result;
	}
endif;


//---- Change logo in login page
if ( ! function_exists( 'cosmos_login_style' ) ) {
	function cosmos_login_style() {
		$logo = Cosmos::get_option('pix-logo-header', 'url');
		if( $logo ) {
			$custom_css = '.login h1 a { 
								background : url('.esc_url($logo).') center no-repeat; 
								width: 100%; 
							}';
			wp_enqueue_style( 'cosmos-login-style', get_template_directory_uri()."/assets/admin/css/admin-style.css", false, COSMOS_THEME_VER, 'all' );
			wp_add_inline_style( 'cosmos-login-style', $custom_css );
		}
	}
}
add_action( 'login_enqueue_scripts', 'cosmos_login_style' );
if ( ! function_exists( 'cosmos_login_logo_url' ) ) {
	function cosmos_login_logo_url() {
		return esc_url(home_url('/'));
	}
}
add_filter( 'login_headerurl', 'cosmos_login_logo_url' );
//-------------------------Header Functions <<-----------------
//---- Add body class to special template
if ( ! function_exists( 'cosmos_add_body_class' ) ) {
	function cosmos_add_body_class( $classes)  {
		$classes[] = 'template-login';
		return $classes;
	}
}
//---- Check header page, using on header
if ( ! function_exists( 'cosmos_has_header_page' ) ) {
	function cosmos_has_header_page() {
		$header_page = true;
		if(is_page_template ( 'page-templates/page-login.php' )
				|| is_page_template ( 'page-templates/page-register.php' )
				|| is_page_template ( 'page-templates/page-coming-soon.php' )){
			$header_page = false;
			add_filter( 'body_class', 'cosmos_add_body_class' );
		}
		return $header_page;
	}
}
//---- Get body wraper class, using on header
if ( ! function_exists( 'cosmos_get_body_wrapper_class' ) ) {
	function cosmos_get_body_wrapper_class( $wapper_class = array() )  {
		//body-extra-class
		$wapper_class[] = Cosmos::get_option('pix-body-extra-class');
		//header layout
		$header = Cosmos::get_option('pix-header-layout');
		$header_class_mapping = array(
			'one'   => 'homepage-1',
			'two'   => 'homepage-2',
			'three' => 'homepage-3',
		);
		$header_class = 'homepage-2';
		if( isset($header_class_mapping[$header]) ) {
			$header_class = $header_class_mapping[$header];
		}
		$wapper_class[] = $header_class;
		
		//convert to string
		$wapper_class = array_map( 'esc_attr', $wapper_class );
		$wapper_class = join( ' ', array_unique( $wapper_class ) );
		return $wapper_class;
	}
}
//---- Get page class, using on header
if ( ! function_exists( 'cosmos_get_page_class' ) ) {
	function cosmos_get_page_class() {
		$page_class = '';
		//Layout boxed
		if ( Cosmos::get_option('pix-layout') == '2' ) {
			$page_class .= 'layout-boxed';
		}
		return $page_class;
	}
}
//------------------------>> Header Functions -----------------
//----Footer class
if ( ! function_exists( 'cosmos_get_footer_class' ) ) {
	function cosmos_get_footer_class() {
		$footer_col = Cosmos::get_option('pix-footer-col');
		$arr_footer_css = array(
			'footer_c1' => '',
			'footer_c2' => '',
			'footer_c3' => '',
			'footer_c4' => '',
		);
		if ( $footer_col == '2' ) {
			$arr_footer_css = array(
				'footer_c1' => 'col-md-6 col-sm-6',
				'footer_c2' => 'col-md-6 col-sm-6',
				'footer_c3' => 'hide',
				'footer_c4' => 'hide',
			);
		}
		if ( $footer_col == '3' ) {
			$arr_footer_css = array(
				'footer_c1' => 'col-md-4 col-sm-4',
				'footer_c2' => 'col-md-4 col-sm-4',
				'footer_c3' => 'col-md-4 col-sm-4',
				'footer_c4' => 'hide',
			);
		}
		if ( $footer_col == '4' ) {
			$arr_footer_css = array(
				'footer_c1' => 'col-md-3 prl col-sm-3',
				'footer_c2' => 'col-md-3 pll prl col-sm-3',
				'footer_c3' => 'col-md-3 pll col-sm-3',
				'footer_c4' => 'col-md-3 prl col-sm-3',
			);
		}
		return $arr_footer_css;
	}
}
//----Latest tweets
if( COSMOS_LATEST_TWEETS_ACTIVE ){
	add_filter( 'latest_tweets_render_date', 'cosmos_latest_tweets_render_date', 10 , 1 );
}
if ( ! function_exists( 'cosmos_latest_tweets_render_date' ) ) {
	function cosmos_latest_tweets_render_date( $created_at ) {
		$created_date = new DateTime( $created_at );
		$current_date = new DateTime();
		$dates = $created_date->diff($current_date);
		$number = esc_html__( 'just now', 'cosmos' );
		if( $dates->format('%a') > 0 ){
			$number = $dates->format('%a') . esc_html__( ' days ago', 'cosmos' );
		}
		elseif( $dates->format('%h') > 0 ){
			$number = $dates->format('%h') . esc_html__( ' hours ago', 'cosmos' );
		}
		elseif( $dates->format('%i') > 0 ){
			$number = $dates->format('%i') . esc_html__( ' minutes ago', 'cosmos' );
		}
		return sprintf( '<i class="icons fa fa-twitter"></i><span>%s</span>', $number );
	}
}

if ( ! function_exists( 'cosmos_show_loading_page' ) ) {
	function cosmos_show_loading_page() {
		$show_loading_page = Cosmos::get_option('pix-loading-page');
		if ( !empty($show_loading_page) && $show_loading_page == 1 ) {
		?>
		<!--loading-->
		<div class="loading-wrap">
			<div class="cssload-dots">
				<div class="cssload-dot"></div>
				<div class="cssload-dot"></div>
				<div class="cssload-dot"></div>
				<div class="cssload-dot"></div>
				<div class="cssload-dot"></div>
			</div>
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg">
				<defs>
					<filter id="goo">
						<feGaussianBlur in="SourceGraphic" result="blur" stdDeviation="12" ></feGaussianBlur>
						<feColorMatrix in="blur" values="1 0 0 0 0    0 1 0 0 0   0 0 1 0 0   0 0 0 18 -7" result="goo" ></feColorMatrix>
					</filter>
				</defs>
			</svg>
		</div>
		<!--end loading-->
		<?php
		}
	}
}

if ( ! function_exists( 'cosmos_show_tool_box' ) ) {
	function cosmos_show_tool_box() {
		$show_toolbox = Cosmos::get_option('pix-show-tool-box');
		$site_skin_array = array('bronze','black','blue','green','orange','red','violet','yellow');
		if ( COSMOS_CORE_IS_ACTIVE && !empty($show_toolbox) && $show_toolbox == 1 ) {
		?>
		<div class="theme-setting pd-t20 pd-b20">
			<div class="button-theme-setting">
				<i class="fa fa-cog" aria-hidden="true"></i>
			</div>
			<a href="https://themeforest.net/item/cosmos-redel-responsive-app-landing-wordpress-theme/19374966" class="button-style background-gray border-style2 shadow mg-b20" target="_blank"><?php esc_html_e('Purchase Now', 'cosmos');?></a>
			<div class="theme-skin-color">
				<div class="theme-skin-color-text mg-b10">
					<h3>Skin color</h3>
				</div>
				<div class="theme-skin-color-list">
					<?php 
					if ( is_array($site_skin_array) ) {
						foreach ($site_skin_array as $color) {
							$href = COSMOS_PUBLIC_URI . '/css/color/'.$color.'.css';
							$logo = COSMOS_PUBLIC_URI . '/images/logo/logo_'.$color.'.png';
							printf('<div class="theme-skin-color-item %1$s" data-href="%2$s" data-logo="%3$s"></div>', 
								esc_attr( $color ),
								esc_url( $href ),
								esc_url( $logo )
							);
						}
					}
					?>
				</div>
			</div>
		</div>
		<?php
		}
	}
}

/* Remove Query String from Static Resources */
if ( ! function_exists( 'cosmos_remove_cssjs_ver' ) ) {
	function cosmos_remove_cssjs_ver( $src ) {
	 if( strpos( $src, '?ver=' ) )
	 $src = remove_query_arg( 'ver', $src );
	 return $src;
	}
	add_filter( 'style_loader_src', 'cosmos_remove_cssjs_ver', 10, 2 );
	add_filter( 'script_loader_src', 'cosmos_remove_cssjs_ver', 10, 2 );
}