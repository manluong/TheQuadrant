<?php
	$bloginfo = Cosmos::get_option('pix-bloginfo', 'enabled');
?>
<div class="content-text">
	<?php edit_post_link( esc_html__( 'Edit', 'cosmos' ), '<div class="meta-item edit-link"><i class="fa fa-pencil"></i>', '</div>' ); ?>
	<?php if ( is_sticky() && is_home() && ! is_paged() ) { 
			$sticky_string = '<span class="meta-item sticky-item"><i class="dashicons dashicons-admin-post"></i> %1$s</span>';
			echo sprintf(
				$sticky_string,
				esc_html__('Sticky', 'cosmos')
			);
		}
	?>
	<?php
	if ( !empty($bloginfo) ) :
		foreach ($bloginfo as $key => $value) {
			switch ( $key ) {
				case 'author':
					$author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
					$prefix = esc_html__( 'Posted by ', 'cosmos' );
					if( $author_url ) {
						$author_string = '<div class="meta-item author">%3$s <a href="%1$s"> %2$s</a></div>';
					} else {
						$author_string = '<div class="meta-item author">%3$s%2$s</div>';
					}
					echo sprintf( 
						$author_string,
						esc_url( $author_url ),
						esc_html( get_the_author_meta( 'display_name' ) ),
						$prefix
					);
					break;

				case 'date':
					echo cosmos_post_date();
					break;

				case 'view':
					$view_count = cosmos_postview_get( get_the_ID() );?>
					<div class="meta-item views"><?php printf( _n('%s View', '%s Views', $view_count, 'cosmos'), $view_count ); ?></div>
					<?php
					break;

				case 'comment':
					if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
						<div class="meta-item comment"><a href="<?php echo esc_url( get_comments_link() )?>" ><?php echo wp_kses_post( get_comments_number_text() );?></a>
						</div>
					<?php endif;
					break;

				default:
					break;
			}
		}
	endif; ?>
</div>