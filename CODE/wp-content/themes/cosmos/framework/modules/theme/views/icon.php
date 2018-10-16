<div class="wrap about-wrap pix-wrap pix-tab-style">
	<?php do_action('cosmos_get_theme_header');?>
	<div class="pix-demo-themes pix-install-plugins pix-icons">
	<?php
	if( class_exists('Cosmos_Core_Params')){
		$flat_icons = Cosmos_Core_Params::get('font_flaticon');
		$awesome_icons = Cosmos_Core_Params::get('font_awesome');
		$material_icons = Cosmos_Core_Params::get('font_material');
		$icons = array_merge( $flat_icons, $awesome_icons, $material_icons );
		unset($icons['']);
		foreach( $icons as $key => $value ) {
			printf('<div class="glyph">
						<div class="clearfix pbs">
							<span class="%1$s"></span>
							<span class="mls">%2$s</span>
						</div>
					</div>', $key, $value);
		}
	}
	?>
		<div class="clearfix"></div>
	</div>
</div>