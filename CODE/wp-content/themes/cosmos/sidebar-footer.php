<?php
/**
 * The Content Sidebar
 * 
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
$cosmos_footer_css = cosmos_get_footer_class();
if ( ! is_active_sidebar( 'cosmos-sidebar-footer-1' ) &&
	 ! is_active_sidebar( 'cosmos-sidebar-footer-2' ) &&
	 ! is_active_sidebar( 'cosmos-sidebar-footer-3' ) &&
	 ! is_active_sidebar( 'cosmos-sidebar-footer-4' ) &&
	 ! is_active_sidebar( 'cosmos-sidebar-footer-5' )) {
	return;
}
?>
<div id="footer" class="content-sidebar widget-area"
	role="complementary">
	<div id="section-footer" class="section">
		<div class="container">
			<div class="section-content">
				<div class=row>
					<div class="<?php echo esc_attr( $cosmos_footer_css['footer_c1'] ); ?>"><?php dynamic_sidebar( 'cosmos-sidebar-footer-1' ); ?></div>
					<div class="<?php echo esc_attr( $cosmos_footer_css['footer_c2'] ); ?>"><?php dynamic_sidebar( 'cosmos-sidebar-footer-2' ); ?></div>
					<div class="<?php echo esc_attr( $cosmos_footer_css['footer_c3'] ); ?>"><?php dynamic_sidebar( 'cosmos-sidebar-footer-3' ); ?></div>
					<div class="<?php echo esc_attr( $cosmos_footer_css['footer_c4'] ); ?>"><?php dynamic_sidebar( 'cosmos-sidebar-footer-4' ); ?></div>
					<div class="<?php echo esc_attr( $cosmos_footer_css['footer_c5'] ); ?>"><?php dynamic_sidebar( 'cosmos-sidebar-footer-5' ); ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- #content-sidebar -->