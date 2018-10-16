<?php get_header(); ?>
<div class="col-md-8">
	<div class="wrap-blog">
		<section id="content" role="main">		
			<h3 class="entry-title"><?php _e( 'Category Archives: ', 'blankslate' ); ?><?php single_cat_title(); ?></h3>
				<?php if ( '' != category_description() ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . category_description() . '</div>' ); ?>
			
			<?php 

			if ( have_posts() ) : while ( have_posts() ) : the_post(); 
				 get_template_part( 'list-posts' );
			endwhile; endif;

			?>		
			
		</section>
	</div>
</div>
<div class="col-md-4">
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>