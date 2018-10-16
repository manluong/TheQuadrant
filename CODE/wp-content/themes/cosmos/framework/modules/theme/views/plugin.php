<div class="wrap about-wrap pix-wrap pix-tab-style">
	<?php do_action('cosmos_get_theme_header');?>
	<div class="pix-important-notice">
		<p class="about-description"><?php esc_html_e('These are the plugins we include with Cosmos.  Currently Pix Core is the only required plugin that is needed to use Cosmos. You can activate, deactivate or update the plugins from this tab.', 'cosmos' );?></p>
	</div>
	<div class="pix-demo-themes pix-install-plugins">
		<div class="feature-section theme-browser rendered">
			<?php
			$required_plugin  = array( 'pix-core', 'redux-framework', 'js_composer', 'contact-form-7', 'contact-form-7-dynamic-text-extension' );
			$recommend_plugin = array( 'revslider', 'wp-user-avatar', 'newsletter', 'tinymce-advanced' );
			$plugins = TGM_Plugin_Activation::$instance->plugins;
			$installed_plugins = get_plugins();
			foreach( $required_plugin as $plg_name ):
				$plugin = $plugins[$plg_name];
				$class = '';
				$plugin_status = '';
				$file_path = $plugin['file_path'];
				$plugin_action = $this->plugin_link( $plugin );

				if( is_plugin_active( $file_path ) ) {
					$plugin_status = 'active';
					$class = 'active';
				}
			?>
			<div class="theme <?php echo esc_attr( $class ); ?>">
				<div class="theme-screenshot">
					<img src="<?php echo esc_url($plugin['image_url']); ?>" alt="" />
				</div>
				<h3 class="theme-name">
					<?php
					if( $plugin_status == 'active' ) {
						echo sprintf( '<span>%s</span> ', esc_html__( 'Active:', 'cosmos' ) );
					}
					echo esc_html($plugin['name']);
					?>
				</h3>
				<div class="theme-actions">
					<?php
					foreach( $plugin_action as $action ) {
						echo wp_kses_post($action);
					}
					?>
				</div>
				<?php if( isset( $plugin_action['update'] ) && $plugin_action['update'] ): ?>
				<div class="theme-update"><?php echo esc_html__( 'Update Available: Version', 'cosmos' ) . esc_html($plugin['version']); ?></div>
				<?php endif; ?>

				<?php if( isset( $installed_plugins[$plugin['file_path']] ) ): ?> 
				<div class="plugin-info">
					<?php echo sprintf(esc_html__( 'Version %s | %s', 'cosmos'), $installed_plugins[$plugin['file_path']]['Version'], $installed_plugins[$plugin['file_path']]['Author'] ); ?>
				</div>
				<?php endif; ?>
				<?php if( isset($plugin['required']) && $plugin['required'] ): ?>
				<div class="plugin-required">
					<?php esc_html_e( 'Required', 'cosmos' ); ?>
				</div>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
		<h2><?php esc_html_e('Tested Plugins', 'cosmos');?></h2>
		<p><?php esc_html_e('These are the plugins we tested with Cosmos and they are compatible with together. If you want to use these plugins, you can activate, deactivate or update them in this tab.', 'cosmos' );?></p>
		<div class="tested-plugin feature-section theme-browser rendered">
			<?php
			foreach( $recommend_plugin as $plg_name ):
				$plugin = $plugins[$plg_name];
				$class = '';
				$plugin_status = '';
				$file_path = $plugin['file_path'];
				$plugin_action = $this->plugin_link( $plugin );

				if( is_plugin_active( $file_path ) ) {
					$plugin_status = 'active';
					$class = 'active';
				}
			?>
			<div class="theme <?php echo esc_attr( $class ); ?>">
				<div class="theme-screenshot">
					<img src="<?php echo esc_url($plugin['image_url']); ?>" alt="" />
				</div>
				<h3 class="theme-name">
					<?php
					if( $plugin_status == 'active' ) {
						echo sprintf( '<span>%s</span> ', esc_html__( 'Active:', 'cosmos' ) );
					}
					echo esc_html($plugin['name']);
					?>
				</h3>
				<div class="theme-actions">
					<?php
					foreach( $plugin_action as $action ) {
						echo wp_kses_post($action);
					}
					?>
				</div>
				<?php if( isset( $plugin_action['update'] ) && $plugin_action['update'] ): ?>
				<div class="theme-update"><?php printf( esc_html__( 'Update Available: Version %s', 'cosmos' ), esc_html($plugin['version']) ); ?></div>
				<?php endif; ?>

				<?php if( isset( $installed_plugins[$plugin['file_path']] ) ): ?> 
				<div class="plugin-info">
					<?php echo sprintf(esc_html__( 'Version %s | %s', 'cosmos' ), $installed_plugins[$plugin['file_path']]['Version'], $installed_plugins[$plugin['file_path']]['Author'] ); ?>
				</div>
				<?php endif; ?>
				<div class="plugin-recommend">
					<?php esc_html_e( 'Recommend', 'cosmos' ); ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>