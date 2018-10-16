<?php
Cosmos::load_class( 'front.Blog' );
$userID = get_query_var('author');
$limit_post = get_option('posts_per_page');
$model = new Cosmos_Blog;
$atts = array(
	'layout'      => 'author',
	'pagination'  => 'yes',
	'offset_post' => 0,
	'limit_post'  => $limit_post,
	'author'      => $userID
);
$model->init( $atts );
$html_format = 
'	
<div class="content-blog layout-2 %6$s">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-blog-left">
             %1$s
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="main-blog-right">
            <div class="wrapper-infomation ">
                <div class="title">%2$s</div>
                 %4$s
            </div>
             %3$s
            <p class="text">%5$s</p>
        </div>
    </div>
</div>
';
if ( $model->query->have_posts() ) :
	$display_name = get_the_author_meta( 'display_name', $userID);
	printf('<div class=" author_article page-title ">%s %s</div>',
			esc_html( ucfirst($display_name) ),
			esc_html__( 'Articles', 'cosmos' ));?>
	<div class="pix-shortcode blog-wrapper blog-content" data-item=".<?php echo esc_attr( $model->attributes['block-class'] ) ?>">
			<?php 
			$post_options = array(
				'html_format' => $html_format,
				'image_format'=> '<div class="wp-img"><a href="%1$s">%2$s</a></div>'
				);
			$model->render_author( $post_options );
			echo '<div class="clearfix"></div>';
			if( $model->attributes['pagination'] == 'yes' ) {
				echo ( $model->paging_nav( $model->query->max_num_pages, 2, $model->query) );
			}
			wp_reset_postdata();?>
	</div>
<?php endif; ?>