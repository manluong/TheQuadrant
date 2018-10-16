<?php 
$model = new Cosmos_Blog();
$id = Cosmos::make_id();
$atts = array(
	'layout'          		=> 'blog',
	'limit_post'      		=> '',
	'posts_per_page'      	=> '6',
	'title_length' 			=> '8',
	'excerpt_length' 		=> '18',
	'orderby' 				=> 'rand',
	'query_related' 		=> true,
);
$model->init( $atts);

$html_format = '<div class="blog-detail-related-slider-item row">
					<div class="col-md-6 col-xs-12">
						%1$s
					</div>
					<div class="col-md-6 col-xs-12 padding">
						%3$s
						%2$s
						<div class="text" data-type="content">%4$s</div>
						<a class="link_posts" href="%5$s" data-type="link">'.esc_html__('READ MORE', 'cosmos').'</a>
					</div>
				</div>';
$html_format_no_image = '<div class="blog-detail-related-slider-item row">
							<div class="col-xs-12">
								%3$s
								%2$s
								<div class="text" data-type="content">%4$s</div>
								<a class="link_posts" href="%5$s" data-type="link">'.esc_html__('READ MORE', 'cosmos').'</a>
							</div>
						</div>';
if ($model->query->have_posts()) {
?>
<div id="<?php echo esc_attr( $id );?>" class="section_blog_detail style-2">
	<div class="blog-detail-related">
		<p class="blog-detail-related-title" data-type="title"><?php esc_html_e('Related Posts :', 'cosmos'); ?></p>
		<div class="carousel">
			<div class="blog-detail-related-slider">
				<div class="blog-detail-related-slideshow">
					<div class="carousel-items">
						<?php
							$html_options = array(
								'html_format'		=> $html_format,
								'html_format_no_image' => $html_format_no_image,
								'has_no_image'		=> false,
								'image_format'		=> '<div class="img-slider"><a href="%1$s">%2$s</a></div>',
								'title_format'		=> '<div class="content-title" data-type="content"><a href="%2$s" title="%3$s">%1$s</a></div>',
								'category_format'	=> '<a href="%1$s" class="content-topic" data-type="title">%2$s</a>',
							);
							$model->render_related_post( $html_options );
						?>
					</div>
				</div>
			</div>
			<!--end slide show -->
			<div class="nav-item carousel-prev" data-type="icon"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
			<div class="nav-item carousel-next" data-type="icon"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
		</div>
	</div>
</div>
<?php 
} ?>