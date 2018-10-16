<?php get_header(); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
		<?php the_content(); ?>
		
	</article>
	<?php if ( ! post_password_required() ) comments_template( '', true ); ?>
	<?php endwhile; endif; ?>

<?php get_footer(); ?>