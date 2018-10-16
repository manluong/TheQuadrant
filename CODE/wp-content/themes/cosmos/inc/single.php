<?php
/**
 * The default template for displaying content
 *
 * Used for single.
 *
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
?>
<div <?php post_class(); ?> >
	<div class="blog-post">
		<!-- thumbnail -->
		<?php 
		if( has_action('cosmos_core_social_share') && Cosmos::get_option('pix-blog-social-position') != '1' ){
			do_action( 'cosmos_entry_video');
		} 
		if (!COSMOS_CORE_IS_ACTIVE) {
			do_action( 'cosmos_entry_video');
		} ?>
		<div class="blog-content">
			<div class="blog-detail-content">
				<div class="content">
					<?php
					if (Cosmos::get_option('pix-blog-cat') == '1'){
						do_action('cosmos_categories_meta');
					}
					?>
					<!-- title -->
					<?php the_title( '<h1 class="title">', '</h1>' );?>
					<div class="wrapper-infomation">
						<?php do_action( 'cosmos_entry_meta'); ?> 
					</div>
					<?php 
					if( COSMOS_CORE_IS_ACTIVE && has_action('cosmos_core_social_share') && Cosmos::get_option('pix-blog-social-position') == '1' ){
						do_action( 'cosmos_entry_video'); 
						do_action('cosmos_core_social_share' );
					} ?>
					<div class="description">
						<?php
							the_content( sprintf( '<a href="%s" class="read-more">%s<i class="fa fa-angle-right"></i></a>',
									get_permalink(),
									esc_html__( 'Read more', 'cosmos' )
							) );
							wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'cosmos' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
						?>
						
					</div>
				</div>
				
				<div class="wrapper-tags">
					<?php 
					if (Cosmos::get_option('pix-blog-tag') == '1'){
						do_action('cosmos_tags_meta');
					}
					if(has_action('cosmos_core_social_share') && Cosmos::get_option('pix-blog-social-position') != '1' ){
						do_action('cosmos_core_social_share' );
					} ?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<?php 
		if (Cosmos::get_option('pix-blog-show-related') == '1'){
			do_action( 'cosmos_related_post' );
		} ?>
		<?php 
		if (Cosmos::get_option('pix-blog-author') == '1'){
			do_action( 'cosmos_post_author' );
		} ?>
	</div>
</div>