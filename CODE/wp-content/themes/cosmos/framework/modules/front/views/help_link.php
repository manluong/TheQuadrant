<div class="help-links">
	<?php
	$menu_location = 'page-404-nav' ;
	$locations = get_nav_menu_locations();
	if( isset($locations[$menu_location]) ):?>
		<h3 class="title"><?php esc_html_e('Helpful Links', 'cosmos')?></h3>
		<div class="help-links-content row"><?php
			$nav_items = wp_get_nav_menu_items( $locations[$menu_location] );
			if( $nav_items ) {
				$item_columns = array_chunk($nav_items, ceil(count($nav_items) / 3));
				if( $item_columns ) {
					foreach( $item_columns as $columns ) {
						if( $columns ) {
							echo '<div class="col-md-4 col-sm-4">';
								echo '<ul class="list-useful list-unstyled">';
									foreach( $columns as $menu_item ){
										printf('<li><a class="link" href="%1$s">%2$s</a></li>', esc_url($menu_item->url), esc_html($menu_item->title) );
									}
								echo '</ul>';
							echo '</div>';
						}
					}
				}
			}?>
		</div><?php
	endif;
	?>
</div>