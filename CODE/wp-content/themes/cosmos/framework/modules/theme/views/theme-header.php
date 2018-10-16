	<?php
	$arr_pages = array(
		'requirement'	=> esc_html__( "Requirements & Recommendations", 'cosmos' ),
		'plugin'		=> esc_html__( "Plugins", 'cosmos' ),
		'importer'		=> esc_html__( "Demo Importer", 'cosmos' ),
		'icon'			=> esc_html__( "Cosmos Icons", 'cosmos' ),
		'changelog'		=> esc_html__( "Changes Log", 'cosmos' )
	);
	$screen = get_current_screen();
	$args = explode('_', $screen->id);
	$id_page = array_pop($args);
	?>
	<h1><?php esc_html_e( "Welcome to Cosmos!", 'cosmos' ); ?></h1>
	<div class="about-text">
		<?php esc_html_e( "Cosmos is now installed and ready to use!  Get ready to build something beautiful. Please register your purchase to get support and automatic theme updates. Read below for additional information. We hope you enjoy it!", 'cosmos' ); ?>
	</div>
	<h2 class="nav-tab-wrapper">
		<?php 
		foreach ( $arr_pages as $id => $name ) {
			$active = '';
			if( $id == $id_page || $id == 'welcome') {
				$active = 'nav-tab-active';
			}
			if( $id == 'icon' && ! COSMOS_CORE_IS_ACTIVE ){
				continue;
			}
			printf( '<a href="%1$s" class="nav-tab %3$s">%2$s</a>',
					esc_url( admin_url( 'admin.php?page=cosmos_' . $id ) ),
					$name,
					$active );
		}
		?>
	</h2>