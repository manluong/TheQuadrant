<?php get_header(); ?>
<div class="col-md-8">
	<div class="wrap-blog">
		<section id="content" role="main">		
			<h3 class="entry-title"><?php 
			if ( is_day() ) { printf( __( 'Daily Archives: %s', 'blankslate' ), get_the_time( get_option( 'date_format' ) ) ); }
			elseif ( is_month() ) { printf( __( 'Monthly Archives: %s', 'blankslate' ), get_the_time( 'F Y' ) ); }
			elseif ( is_year() ) { printf( __( 'Yearly Archives: %s', 'blankslate' ), get_the_time( 'Y' ) ); }
			else { _e( 'Archives', 'blankslate' ); }
			?></h3>	
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