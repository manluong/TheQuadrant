<?php get_header(); ?>

<?php 
$postType = get_post_type(get_the_ID());

if($postType=='property'){
	do_action('before_single_property');
}
?>
<section id="content" role="main">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>				
		<?php the_content(); ?>
		<div class="entry-links"><?php wp_link_pages(); ?></div>		
	<?php endwhile; endif; ?>

</section>
<?php get_footer(); ?>