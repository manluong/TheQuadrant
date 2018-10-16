<?php
/**
 * The default template for displaying content
 *
 * Used for search.
 *
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
?>
<div id="post-<?php the_ID();?>" class="content-blog">
	<div class="blog-content">
		<div class="no-image">
			<div class="main-blog-right">
				<?php if ( 'page' !== get_post_type() ) : ?>
					<div class="wrapper-infomation">
						<?php do_action( 'cosmos_entry_meta');?>
					</div>
				<?php else:?>
				<?php edit_post_link( esc_html__( 'Edit', 'cosmos' ), '<div class="item edit-link search-edit-link"><i class="fa fa-pencil"></i>', '</div>' ); ?>
				<?php endif;?>
				<div class="content">
					<?php the_title( sprintf( '<a class="title" href="%s">', esc_url( get_permalink() ) ) , '</a>' ) ;?>
					<div class="text"><?php the_excerpt(); ?></div>
					<div class="wrapper-tags">
						<?php
						do_action('cosmos_categories_meta');
						do_action('cosmos_tags_meta'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>