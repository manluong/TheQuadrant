<?php
/**
 * The template for displaying all pages.
 *
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
// css to show/hide sidebar.
$cosmos_container_css = cosmos_get_container_css();

get_header();
?>

<!-- Content section -->
<div class="section section-padding page-detail padding-top-100 padding-bottom-100">
	<div class="<?php echo esc_attr($cosmos_container_css['container_css']);?>">
		<div class="row">
			<div id="page-content" class="<?php echo esc_attr( $cosmos_container_css['content_css'] ); ?>">
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
					<?php while ( have_posts() ) : the_post(); ?>
						<?php do_action( 'cosmos_entry_thumbnail', array('page') );?>
						<div class="section-page-content clearfix ">
							<div class="entry-content">
								<?php the_content(); ?>
								<?php
									wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'cosmos' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
								?>
							</div>
							<?php edit_post_link( esc_html__( 'Edit', 'cosmos' ), '<div class="edit-link"><i class="fa fa-pencil"></i>', '</div>' ); ?>
							<?php if ( comments_open() ) :
									echo '<div class="entry-comment entry-page-comment blog-detail">';
										comments_template();
									echo '</div>';
								endif;
							?>
						</div>

					<?php endwhile; // End of the loop. ?>

				</div>
			</div>
			<?php if ( $cosmos_container_css['has_sidebar'] != 'none' ) :?>
			<div id='page-sidebar' class="sidebar <?php echo esc_attr( $cosmos_container_css['sidebar_css'] ); ?>">
				<?php cosmos_get_sidebar($cosmos_container_css['sidebar_id']);?>
			</div>
			<?php endif;?>
		</div>
	</div>
</div>
<!-- #section -->
<?php get_footer(); ?>