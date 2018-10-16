<?php
$show_page_title = Cosmos::get_option('pix-page-title-show');
$show_title = Cosmos::get_option('pix-show-title');
$show_breadcrumb = Cosmos::get_option('pix-show-breadcrumb');

if ( $show_page_title != '1' ) {
	return;
}
$title = '';
$opt_title_type = Cosmos::get_option('pix-page-title-type-display');
$opt_title_heading = Cosmos::get_option('pix-page-title-heading');
$title_heading = '2';
if ( !empty($opt_title_heading) ) {
	$title_heading = $opt_title_heading;
}
$breadcrumb = cosmos_get_breadcrumb();
$count_breadcrumb = count($breadcrumb);
list($post_id, $shop_page) = cosmos_get_post_id();
//title
$page_options = get_post_meta( $post_id, 'cosmos_page_options', true);
$page_title_default = Cosmos::get_value($page_options, 'page_title_default');
if( empty($page_title_default) && !empty($page_options['title_custom_content']) ) {
	$title = $page_options['title_custom_content'];
}
elseif ( empty($page_title_default) && !empty($page_options['page_title_type_display']) ) {
	if ( $page_options['page_title_type_display'] == 'level' && $count_breadcrumb > 2 ) {
		$title = $breadcrumb[$count_breadcrumb-2][0];
	} elseif ( $page_options['page_title_type_display'] == 'post' ) {
		$title = get_the_title();
	}
}
elseif ( ( $opt_title_type == 'level' ) && $count_breadcrumb > 2 ) {
	$title = $breadcrumb[$count_breadcrumb-2][0];
}
elseif( is_single() ) {
	$post_type = get_post_type( $post_id );
	if ( $post_type && 'post' != $post_type ) {
		$post_type_obj = get_post_type_object( $post_type );
		$title = $post_type_obj->labels->singular_name;
	} else {
		$cat = current( get_the_category( $post_id ) );
		if( $cat ) {
			$title = $cat->name;
		}
	}
} else {
	$title = get_the_title();
}
?>
<!-- Page Title -->
<?php if ( $show_page_title  == '1' ):?>
<div class="page-title-banner">
	<div class="container">
		<div class="page-title-table">
			<div class="page-title-wrapper">
				<?php if ( $show_title == '1' ): ?>
					<h<?php echo esc_attr($title_heading); ?> class="title-page">
					<?php
					$output_title = '';
					if ( is_search() ) {
						$output_title = esc_html__( 'Search results', 'cosmos' );
					} elseif ( is_tax() && $opt_title_type == 'level' && $count_breadcrumb > 2 ) {
						$output_title = $title;
					} elseif( is_archive() ) {
						if ( is_month() ) {
							$output_title = sprintf( '%s' , get_the_date( _x( 'F Y', 'monthly archives date format', 'cosmos' ) ) );
						} elseif ( is_day() ) {
							$output_title = sprintf( '%s' , get_the_date( _x( 'F j, Y', 'daily archives date format', 'cosmos' ) ) );
						} else{
							$output_title = get_the_archive_title();
						}
						if( COSMOS_WOOCOMMERCE_ACTIVE ) {
							if( is_shop() ) {
								if( empty($page_title_default) && !empty($page_options['title_custom_content']) ) {
									$output_title = $page_options['title_custom_content'];
								} else {
									$output_title = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
									if ( ! $output_title ) {
										$product_post_type = get_post_type_object( 'product' );
										$output_title = $product_post_type->labels->singular_name;
									}
								}
							}
						}
					} else if( is_404() ) {
						$output_title = esc_html__( 'Error 404', 'cosmos' );
					} 
					else {
						$output_title = esc_html($title);
					}
					echo wp_kses_post( $output_title );?>
				
				</h<?php echo esc_attr($title_heading); ?>>
				<?php endif; // show_title ?>
				<?php if ( $show_breadcrumb  == '1' ):
					$breadcrumb_html = '';
					if ( $breadcrumb ) {
						foreach ( $breadcrumb as $key => $crumb ) {
							if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
								$breadcrumb_html .= '<li><a class="link home" href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a></li>';
							} else {
								if( ! empty( $crumb[0] ) ) {
									$breadcrumb_html .= '<li><a class="link active">' . esc_html( $crumb[0] ) . '</a></li>';
								}
							}
						}
					}
					printf('<div class="page-link"><ul>%s</ul></div>', $breadcrumb_html );
				endif;//show_breadcrumb?>
			</div><!-- page-title-wrapper -->
		</div><!-- page-title-table -->
	</div> <!-- container -->
</div><!-- page-title-banner -->
<?php endif; // show_title ?>