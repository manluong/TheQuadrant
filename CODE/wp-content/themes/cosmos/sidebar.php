<?php
/**
 * The sidebar containing the main widget area.
 * 
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */
if ( ! is_active_sidebar( 'cosmos-sidebar-default' ) ) {
	return;
}

?>
<div class="sidebar-wrapper">
	<?php dynamic_sidebar( 'cosmos-sidebar-default' ); ?>
</div>