<?php
/**
 * cosmos template team list of archive
 * 
 * @author PIXArtThemes
 * @package cosmos
 * @since 1.0
 */
$cosmos_container_css = cosmos_get_container_css();
get_header();
?>
<div class="section team-archive padding-top padding-bottom">
	<div class="<?php echo esc_attr( $cosmos_container_css['container_css'] ); ?>">
		<div class="team-archive-wrapper">
			<div class="row">
				<div id="page-content" class="team-archive-content <?php echo esc_attr( $cosmos_container_css['content_css'] ); ?>">
					<div <?php post_class(); ?> >
						<?php do_action( 'cosmos_core_team_list', array( 'has_sidebar' => $cosmos_container_css['has_sidebar'] ) ); ?>
					</div>
				</div>
				<!-- #page-content -->
				<?php if ( $cosmos_container_css['has_sidebar'] != 'none' ) :?>
					<div id='page-sidebar' class="sidebar <?php echo esc_attr( $cosmos_container_css['sidebar_css'] )?>">
						<?php cosmos_get_sidebar($cosmos_container_css['sidebar_id']);?>
					</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>