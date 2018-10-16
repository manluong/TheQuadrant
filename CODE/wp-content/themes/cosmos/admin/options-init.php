<?php
/**
 * Options Config (ReduxFramework Sample Config File).
 *
 * For full documentation, please visit: https://docs.reduxframework.com
 *
 */
if (!class_exists('Cosmos_Redux_Framework_Config')) {

	class Cosmos_Redux_Framework_Config {

		public $args     = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct() {

			if ( ! class_exists('ReduxFramework') ) {
				return;
			}

			// This is needed. Bah WordPress bugs.  ;)
			if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
				$this->initSettings();
			} else {
				add_action('plugins_loaded', array($this, 'initSettings'), 10);
			}

		}

		public function initSettings() {

			// Just for demo pureposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();

			if (!isset($this->args['opt_name'])) { // No errors please
				return;
			}

			// If Redux is running as a plugin, this will remove the demo notice and links
			add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
		}

		/**
		 * This is a test function that will let you see when the compiler hook occurs.
		 *
		 * It only runs if a field   set with compiler=>true is changed.
		 */
		function compiler_action($options, $css) {
			return;
		}

		/**
		 * Custom function for filtering the sections array.
		 *
		 */
		function dynamic_section($sections) {
			$sections[] = array(
				'title'  => esc_html__('Section via hook', 'cosmos'),
				'desc'   => sprintf('<p class="description">%s</p>', esc_html__('This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.', 'cosmos')),
				'icon'   => 'el-icon-paper-clip',
				// Leave this as a blank section, no options just some intro text set above.
				'fields' => array()
			);

			return $sections;
		}

		/**
		 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
		 *
		 */
		function change_arguments($args) {
			//$args['dev_mode'] = false;
			return $args;
		}

		/**
		 * Filter hook for filtering the default value of any given field. Very useful in development mode.
		 */
		function change_defaults($defaults) {
			$defaults['str_replace'] = esc_html__('Testing filter hook!', 'cosmos');

			return $defaults;
		}

		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo() {

			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if ( class_exists('ReduxFrameworkPlugin') ) {
				remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);
			}
		}

		public function setSections() {

			/*
			  Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
			*/
			// Background Patterns Reader
			$sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
			$sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
			$sample_patterns        = array();
			$image_opt_path         = get_template_directory_uri() . '/assets/admin/images/';

			ob_start();

			$ct          = wp_get_theme();
			$this->theme = $ct;
			$item_name   = $this->theme->get('Name');
			$tags        = $this->theme->Tags;
			$screenshot  = $this->theme->get_screenshot();
			$class       = $screenshot ? 'has-screenshot' : '';

			$customize_title = sprintf( esc_html__( 'Customize &#8220;%s&#8221;', 'cosmos' ), $this->theme->display('Name') );

			?>
			<div id="current-theme" class="<?php echo esc_attr($class); ?>">
			<?php if ( $screenshot ) : ?>
				<?php if ( current_user_can('edit_theme_options') ) : ?>
						<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
							<img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'cosmos'); ?>" />
						</a>
				<?php endif; ?>
					<img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'cosmos' ); ?>" />
				<?php endif; ?>

				<h4><?php echo esc_html( $this->theme->display('Name') ); ?></h4>

				<div>
					<ul class="theme-info">
						<li><?php printf(esc_html__('By %s', 'cosmos'), $this->theme->display('Author')); ?></li>
						<li><?php printf(esc_html__('Version %s', 'cosmos'), $this->theme->display('Version')); ?></li>
						<li><?php echo '<strong>' . esc_html__('Tags', 'cosmos') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
					</ul>
					<p class="theme-description"><?php echo esc_html( $this->theme->display('Description') ); ?></p>
			<?php
			if ( $this->theme->parent() ) {
				printf(' <p class="howto">' . wp_kses( __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'cosmos'), array( 'a' => array('href' => array()) ) ) . '</p>', 'http://codex.wordpress.org/Child_Themes', $this->theme->parent()->display('Name'));
			}
			?>

				</div>
			</div>

			<?php
			$item_info = ob_get_contents();

			ob_end_clean();

			$admin_widget_url = '<a href="' . esc_url( admin_url('widgets.php','http')).'" target="_blank">' .esc_html__('Widget', 'cosmos') .'</a>';
			$admin_menus_url  = '<a href="' . esc_url( admin_url('nav-menus.php','http')).'" target="_blank">' .esc_html__('Menus', 'cosmos') .'</a>';
			$admin_icon_url   = '<a href="' . esc_url( admin_url('admin.php?page=cosmos_icon','http')).'" target="_blank">' .esc_html__('Icon Page', 'cosmos') .'</a>';
			$fontawesome_url  = '<a href="' . esc_url('https://fortawesome.github.io/Font-Awesome/icons/'). '">' .esc_html__('Font-Awesome', 'cosmos') .'</a>';
			$get_latlong      = '<a href="' . esc_url('http://www.latlong.net/'). '" target="_blank">http://www.latlong.net/</a>';

			// ACTUAL DECLARATION OF SECTIONS
			// General setting
			$this->sections[] = array(
				'title'     => esc_html__( 'General', 'cosmos' ),
				'icon'      => 'el-icon-adjust-alt',
				'fields'    => array(
					array(
						'id'       => 'pix-layout',
						'type'     => 'image_select',
						'title'    => esc_html__( 'Layout display', 'cosmos' ),
						'subtitle' => esc_html__( 'Choose type of layout', 'cosmos' ),
						'desc'     => esc_html__( 'This option will change layout for all page of theme.', 'cosmos' ),
						'options'  => array(
							'1' => array(
								'alt' => esc_html__( 'Fluid', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'full.png'
							),
							'2' => array(
								'alt' => esc_html__( 'Boxed', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'boxed.png'
							),
						),
						'default'  => '1'
					),

					array(
			            'id'       => 'pix-theme-skin-color',
			            'type'     => 'palette',
			            'title'    => esc_html__( 'Theme Skin Color', 'cosmos' ),
			            'subtitle' => esc_html__( 'Select a theme color', 'cosmos' ),
			            'default'  => 'bronze',
			            'palettes' => array(
							'bronze'	=> array('#e1b55a'),
							'black'		=> array('#000000'),
							'blue'		=> array('#24aae7'),
							'green'		=> array('#006023'),
							'orange'	=> array('#ff7800'),
							'red'		=> array('#b83835'),
							'violet'	=> array('#614e9f'),
							'yellow'	=> array('#ffe85e'),
			            )
				    ),
					
					array(
						'id'       => 'pix-layout-boxed-bg',
						'type'     => 'background',
						'title'    => esc_html__( 'Body Background', 'cosmos' ),
						'required' => array('pix-layout','=','2'),
						'default'  => array(
							'background-color'      => '#ffffff',
							'background-image'      => '',
							'background-repeat'     => 'no-repeat',
							'background-attachment' => '',
							'background-position'	=> 'center center',
							'background-size'		=> 'cover'
						)
					),
					array(
						'id'       => 'pix-logo-header',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Header Logo', 'cosmos' ),
						'compiler' => 'true',
						'subtitle' => esc_html__( 'Choose logo image', 'cosmos' ),
						'default'  => array( 'url' => esc_url( COSMOS_LOGO ) )
					),
					array(
						'id'       => 'pix-logo-footer',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Footer Logo', 'cosmos' ),
						'compiler' => 'true',
						'subtitle' => esc_html__( 'Choose logo image for footer', 'cosmos' ),
						'default'  => array( 'url' => esc_url( COSMOS_LOGO ) )
					),
					array(
						'id'        => 'pix-loading-page',
						'type'      => 'switch',
						'title'     => esc_html__('Show Loading Page?', 'cosmos'),
						'subtitle'  => esc_html__( 'Enable or disable show loading page.', 'cosmos' ),
						'default'   => false,
					),
					array(
						'id'        => 'pix-backtotop',
						'type'      => 'switch',
						'title'     => esc_html__( 'Back To Top Button', 'cosmos' ),
						'subtitle'  => esc_html__( 'Setting for back to top button', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos' ),
						'off'       => esc_html__( 'Hide', 'cosmos' ),
						'default'   => true
					),
					array(
						'id'        => 'pix-show-tool-box',
						'type'      => 'switch',
						'title'     => esc_html__( 'Show Tool Box', 'cosmos' ),
						'subtitle'  => esc_html__( 'Setting for tool box', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos' ),
						'off'       => esc_html__( 'Hide', 'cosmos' ),
						'default'   => false
					),
					array(
						'id'       => 'pix-backtotop-image',
						'type'     => 'media',
						'url'      => true,
						'title'    => esc_html__( 'Image Button Back To Top', 'cosmos' ),
						'compiler' => 'true',
						'subtitle' => esc_html__( 'Choose image for button', 'cosmos' ),
						'default'  => array( 'url' => esc_url( COSMOS_PUBLIC_URI.'/images/backontop.png' ) ),
						'required' 	=> array('pix-backtotop','=',true),
					),
					array(
						'id'       => 'pix-map-key-api',
						'type'     => 'text',
						'default'  => '',
						'title'    => esc_html__( 'Map google API Key', 'cosmos' ),
						'subtitle' => esc_html__( 'This key is used to run a some feature of Map.Please refer document to create a key', 'cosmos' ),
					),
					array(
						'id'       => 'pix-language-switcher',
						'type'     => 'switch',
						'title'    => esc_html__( 'Language Switcher', 'cosmos' ),
						'subtitle' => esc_html__( 'Show language switcher of WPML plugin on header top left.', 'cosmos' ),
						'on'       => esc_html__( 'Show', 'cosmos' ),
						'off'      => esc_html__( 'Hide', 'cosmos' ),
						'default'  => false
					),	


					// Money
					array(
						'id'        => 'pix-social-share-section-start',
						'type'      => 'section',
						'title'     => esc_html__( 'Currency', 'cosmos' ),
						'subtitle'  => esc_html__( 'Currency Setting', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'       => 'pix-currency',
						'type'     => 'text',
						'default'  => '$',
						'title'    => esc_html__( 'Currency Unit', 'cosmos' ),
						'subtitle' => esc_html__( 'Enter the currency unit you use. Ex: $', 'cosmos' ),
					),
					array(
						'id'       => 'pix-currency-location',
						'type'     => 'switch',
						'title'    => esc_html__( 'Where To Show The Currency Sign?', 'cosmos' ),
						'subtitle' => esc_html__( 'Choose the location where the currency will show.', 'cosmos' ),
						'on'       => esc_html__( 'Before', 'cosmos' ),
						'off'      => esc_html__( 'After', 'cosmos' ),
						'default'  => true
					),
					array(
						'id'       => 'pix-currency-space',
						'type'     => 'switch',
						'title'    => esc_html__( 'Currency has space ?', 'cosmos' ),
						'subtitle' => esc_html__( 'Choose whether there is space between value and currency.', 'cosmos' ),
						'on'       => esc_html__( 'On', 'cosmos' ),
						'off'      => esc_html__( 'Off', 'cosmos' ),
						'default'  => false
					),
					array(
						'id'       => 'pix-currency-thousand-separator',
						'type'     => 'text',
						'title'    => esc_html__( 'Thousand Separator', 'cosmos' ),
						'subtitle' => esc_html__( 'Enter the thousand separator you use. Ex: 1,000 or 1.000', 'cosmos' ),
						'default'  => ',',
					),
					array(
						'id'       => 'pix-currency-decimal-separator',
						'type'     => 'text',
						'title'    => esc_html__( 'Decimal Separator', 'cosmos' ),
						'subtitle' => esc_html__( 'Choose the decimal separator you use (default is "."). Ex: 1.23 or 1,23', 'cosmos' ),
						'default'  => '.',
					),
					array(
						'id'       => 'pix-currency-number-decimals',
						'type'     => 'text',
						'title'    => esc_html__( 'Number of Decimals', 'cosmos' ),
						'subtitle' => esc_html__( 'Enter the number of decimals you use. Ex: 1.23 or 1.234', 'cosmos' ),
						'default'  => '0'
					),
					array(
						'id'        => 'pix-social-share-section-end',
						'type'      => 'section',
						'indent'    => false,
					),
					
				)
			);

			// Social Setting
			$this->sections[] = array (
				'title'     => esc_html__( 'Social', 'cosmos' ),
				'desc'      => esc_html__( 'Setting social links and social share', 'cosmos' ),
				'icon'      => 'el-icon-group-alt',
				'fields'    => array(
					array(
						'id'        => 'pix-social-section-start',
						'type'      => 'section',
						'title'     => esc_html__( 'Social Links', 'cosmos' ),
						'subtitle'  => wp_kses( __( 'These information will be used for content in <strong>Header</strong> & <strong>Footer</strong>', 'cosmos' ), array('<strong>' => array())),
						'indent'    => true,
					),
					array(
						'id'       => 'pix-social-facebook',
						'type'     => 'text',
						'title'    => esc_html__( 'Facebook', 'cosmos' ),
						'default'  => ''
					),
					array(
						'id'       => 'pix-social-twitter',
						'type'     => 'text',
						'title'    => esc_html__( 'Twitter', 'cosmos' ),
						'default'  => ''
					),
					array(
						'id'       => 'pix-social-google-plus',
						'type'     => 'text',
						'title'    => esc_html__( 'Googleplus', 'cosmos' ),
						'default'  => ''
					),
					array(
						'id'       => 'pix-social-pinterest',
						'type'     => 'text',
						'title'    => esc_html__( 'Pinterest', 'cosmos' ),
						'default'  => ''
					),
					array(
						'id'       => 'pix-social-instagram',
						'type'     => 'text',
						'title'    => esc_html__( 'Instagram', 'cosmos' ),
						'default'  => ''
					),
					array(
						'id'       => 'pix-social-dribbble',
						'type'     => 'text',
						'title'    => esc_html__( 'Dribbble', 'cosmos' ),
						'default'  => ''
					),
					array(
						'id'        => 'pix-social-section-end',
						'type'      => 'section',
						'indent'    => false,
					),
					array(
						'id'        => 'pix-social-share-section-start',
						'type'      => 'section',
						'title'     => esc_html__( 'Social Share', 'cosmos' ),
						'subtitle'  => esc_html__( 'Configure social networks to share', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'       => 'pix-social-share',
						'type'     => 'sorter',
						'title'    => esc_html__('Social network for share','cosmos'),
						'subtitle' => esc_html__('Choose what social networks to share','cosmos'),
						'options'  => array(
							'disabled' => array(
								'linkedin'     => esc_html__( 'Linkedin', 'cosmos' ),
								'digg'         => esc_html__( 'Digg', 'cosmos' ),
								'pinterest'    => esc_html__( 'Pinterest', 'cosmos' )
							),
							'enabled'  => array(
								'facebook'     => esc_html__( 'Facebook', 'cosmos' ),
								'twitter'      => esc_html__( 'Twitter', 'cosmos' ),
								'google-plus'  => esc_html__( 'Google plus', 'cosmos' )
							),
						),
					),
					array(
						'id'       => 'pix-post-social-share',
						'type'     => 'sorter',
						'title'    => esc_html__('Display Social Share','cosmos'),
						'subtitle' => esc_html__('Choose what post types to display social share in detail pages.','cosmos'),
						'options'  => array(
							'disabled' => array(
								
							),
							'enabled'  => array(
								'post'					=> esc_html__( 'Post', 'cosmos' ),
							),
						),
					),
					array(
						'id'        => 'pix-social-share-section-end',
						'type'      => 'section',
						'indent'    => false,
					),
				)
			);

			// Header Setting
			$this->sections[] = array(
				'title'   => esc_html__( 'Header', 'cosmos' ),
				'desc'    => esc_html__( 'This section will change setting for header', 'cosmos' ),
				'icon'    => 'el-icon-caret-up',
				'fields'  => array(
					array(
						'id'        => 'pix-header-show',
						'type'      => 'switch',
						'title'     => esc_html__( 'Show Header ?', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos' ),
						'off'       => esc_html__( 'Hide', 'cosmos' ),
						'default'   => true
					),
					array(
						'id'        => 'pix-sticky',
						'type'      => 'switch',
						'title'     => esc_html__('Header Menu Sticky Enable', 'cosmos'),
						'subtitle'  => esc_html__( 'Enable or disable fixed header menu when scroll', 'cosmos' ),
						'default'   => false,
					),
					array(
						'id'        => 'pix-header-full-1920',
						'type'      => 'switch',
						'title'     => esc_html__( 'Header Full ?', 'cosmos' ),
						'on'        => esc_html__( 'On', 'cosmos' ),
						'off'       => esc_html__( 'Off', 'cosmos' ),
						'default'   => false
					),
					array(
						'id'        => 'pix-header-bg-color',
						'type'      => 'color_rgba',
						'title'     => esc_html__( 'Header Background Color', 'cosmos' ),
						'mode'      => 'background',
						'default'   => array(
							'color'     => '',
        					'alpha'     => '',
							'rgba'      => ''
						)
					),
					array(
						'id'        => 'pix-header-bg-color-scroll',
						'type'      => 'color_rgba',
						'title'     => esc_html__( 'Header Background Color Scroll', 'cosmos' ),
						'subtitle'  => esc_html__( 'Background color when scroll', 'cosmos' ),
						'default'   => array(
							'color'     => '',
        					'alpha'     => '',
							'rgba'      => ''
						),
					),
				)
			);

			// Menu
			$this->sections[] = array(
				'title'    => esc_html__( 'Menu', 'cosmos' ),
				'desc'     => esc_html__( 'Configuration for main navigation on top', 'cosmos' ),
				'icon'     => 'el-icon-brush',
				'fields'   => array(
					array(
						'id'        => 'pix-menu-icon',
						'type'      => 'switch',
						'title'     => esc_html__('Show Icon On Menu ?', 'cosmos'),
						'subtitle'  => esc_html__( 'Enable or disable show icon on item menu.', 'cosmos' ),
						'default'   => false,
					),
					array(
						'id'            => 'pix-menu-style',
						'type'          => 'image_select',
						'title'         => esc_html__( 'Menu Style', 'cosmos' ),
						'indent'        => true,
						'subtitle'      => esc_html__( 'Configuration Menu Style', 'cosmos' ),
						'options'       => array(
							'1'   => array(
								'alt' => esc_html__( 'Style 1', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'menu_style_01.png'
							),
							'2' => array(
								'alt' => esc_html__( 'Style 2', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'menu_style_02.png'
							),
							'3' => array(
								'alt' => esc_html__( 'Style 3', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'menu_style_03.png'
							),
							'4' => array(
								'alt' => esc_html__( 'Style 4', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'menu_style_04.png'
							),
							'5' => array(
								'alt' => esc_html__( 'Style 5', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'menu_style_05.png'
							),
						),
						'default'  => '1'
					),
					array(
						'id'        => 'pix-submenu-section-start',
						'type'      => 'section',
						'title'     => esc_html__( 'Main Menu Setting', 'cosmos' ),
						'subtitle'  => esc_html__( 'Configuration for Main Menu', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'        => 'pix-menu-custom',
						'type'      => 'switch',
						'title'     => esc_html__( 'Main Menu Custom', 'cosmos' ),
						'on'        => esc_html__( 'Custom', 'cosmos' ),
						'off'       => esc_html__( 'Default', 'cosmos' ),
						'default'   => false,
					),
					array(
						'id'        => 'pix-menu-item-text',
						'type'      => 'link_color',
						'title'     => esc_html__( 'Menu Item Color', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set color for Menu item', 'cosmos' ),
						'required'  => array('pix-menu-custom','=',true),
						'default'   => array(
							'regular'   => '',
							'hover'     => '',
							'active'    => ''
						)
					),
					array(
						'id'     => 'pix-submenu-section-end',
						'type'   => 'section',
						'indent' => false,
					),

					/* Mega Menu Setting */
					/*array(
						'id'        => 'pix-megamenu-section-start',
						'type'      => 'section',
						'title'     => esc_html__( 'Mega Menu Setting', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'        => 'pix-megamenu-custom',
						'type'      => 'switch',
						'title'     => esc_html__( 'Mega Menu Custom', 'cosmos' ),
						'on'        => esc_html__( 'Custom', 'cosmos' ),
						'off'       => esc_html__( 'Default', 'cosmos' ),
						'default'   => false,
					),
					array(
						'id'        => 'pix-megamenu-bg',
						'type'      => 'color_rgba',
						'title'     => esc_html__( 'Background Color', 'cosmos' ),
						'required'  => array('pix-megamenu-custom','=',true),
						'default'   => array(
							'color'    => '#fff',
							'alpha'    => '1',
							'rgba'     => 'rgba(255, 255, 255, 1)'
						),
						'mode'      => 'background',
						'validate'  => 'colorrgba'
					),
					array(
						'id'        => 'pix-megamenu-border',
						'type'      => 'border',
						'title'     => esc_html__( 'Border Bottom of Mega Menu', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set borde attribute for mega menu', 'cosmos' ),
						'required'  => array('pix-megamenu-custom','=',true),
						'all'       => false,
						'top'       => false,
						'left'      => false,
						'right'     => false,
						'default'   => array(
							'border-style'  => 'solid',
							'border-color'  => '#93c23d',
							'border-bottom' => '1px',
							'border-top'    => '0px',
							'border-left'   => '0px',
							'border-right'  => '0px'
						)
					),
					array(
						'id'        => 'pix-megamenu-item-bg',
						'type'      => 'color_rgba',
						'title'     => esc_html__( 'Item Background Color', 'cosmos' ),
						'required'  => array('pix-megamenu-custom','=',true),
						'default'   => array(
							'color'    => '#fff',
							'alpha'    => '1',
							'rgba'     => 'rgba(255, 255, 255, 1)'
						),
						'mode'      => 'background',
						'validate'  => 'colorrgba'
					),
					array(
						'id'        => 'pix-megamenu-color',
						'type'      => 'link_color',
						'title'     => esc_html__( 'Item Color', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set color for text in submenu', 'cosmos' ),
						'required'  => array('pix-megamenu-custom','=',true),
						'default'   => array(
							'regular'   => '#333',
							'hover'     => '#333',
							'active'    => '#333',
						)
					),
					array(
						'id'        => 'pix-megamenu-item-border',
						'type'      => 'border',
						'title'     => esc_html__( 'Border of Item', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set borde attribute for mega menu', 'cosmos' ),
						'required'  => array('pix-megamenu-custom','=',true),
						'all'       => false,
						'top'       => false,
						'left'      => false,
						'right'     => false,
						'default'   => array(
							'border-style'  => 'solid',
							'border-color'  => 'rgba(133, 202, 8, 0.18)',
							'border-bottom' => '1px',
							'border-top'    => '0px',
							'border-left'   => '0px',
							'border-right'  => '0px'
						)
					),
					array(
						'id'             => 'pix-megamenu-padding',
						'type'           => 'spacing',
						'mode'           => 'padding',
						'all'            => false,
						'units'          => 'px',      // You can specify a unit value. Possible: px, em, %
						'units_extended' => 'false',   // Allow users to select any type of unit
						'title'          => esc_html__( 'SubMenu Item Padding', 'cosmos' ),
						'subtitle'       => esc_html__( 'Choose inwards spacing for each submenu item', 'cosmos' ),
						'desc'           => esc_html__( 'unit is "px"', 'cosmos' ),
						'required'  => array('pix-megamenu-custom','=',true),
						'default'        => false
					),
					array(
						'id'     => 'pix-megamenu-section-end',
						'type'   => 'section',
						'indent' => false,
					),*/
					
					/* Dropdown Menu Setting */
					array(
						'id'        => 'pix-dropdownmenu-section-start',
						'type'      => 'section',
						'title'     => esc_html__( 'Dropdown Menu Setting', 'cosmos' ),
						'subtitle'  => esc_html__( 'Configuration for submenu', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'        => 'pix-dropdown-custom',
						'type'      => 'switch',
						'title'     => esc_html__( 'Dropdown Menu Custom', 'cosmos' ),
						'on'       	=> esc_html__( 'Custom', 'cosmos' ),
						'off'      	=> esc_html__( 'Default', 'cosmos' ),
						'default'   => false,
					),
					array(
						'id'        => 'pix-submenu-bg',
						'type'      => 'color_rgba',
						'title'     => esc_html__( 'Item Background Color', 'cosmos' ),
						'required'  => array('pix-dropdown-custom','=',true),
						'default'   => array(
							'color'    => '',
							'alpha'    => '',
							'rgba'     => ''
						),
						'mode'      => 'background',
						'validate'  => 'colorrgba'
					),
					array(
						'id'        => 'pix-submenu-bg-hover',
						'type'      => 'color_rgba',
						'title'     => esc_html__( 'Item Background Color Hover', 'cosmos' ),
						'required'  => array('pix-dropdown-custom','=',true),
						'default'   => array(
							'color'    => '',
							'alpha'    => '',
							'rgba'     => ''
						),
						'mode'      => 'background',
						'validate'  => 'colorrgba'
					),
					array(
						'id'        => 'pix-submenu-color',
						'type'      => 'link_color',
						'active'    => false,
						'title'     => esc_html__( 'Item Color', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set color for text in submenu', 'cosmos' ),
						'required'  => array('pix-dropdown-custom','=',true),
						'default'   => array(
							'regular'   => '',
							'hover'     => '',
						)
					),
					array(
						'id'             => 'pix-submenu-padding',
						'type'           => 'spacing',
						'mode'           => 'padding',
						'all'            => false,
						'units'          => 'px',      // You can specify a unit value. Possible: px, em, %
						'units_extended' => 'false',   // Allow users to select any type of unit
						'title'          => esc_html__( 'SubMenu Item Padding', 'cosmos' ),
						'subtitle'       => esc_html__( 'Choose inwards spacing for each submenu item', 'cosmos' ),
						'desc'           => esc_html__( 'unit is "px"', 'cosmos' ),
						'required'       => array('pix-dropdown-custom','=',true),
						'default'        => false
					),
					array(
						'id'             => 'pix-submenu1-width',
						'type'           => 'dimensions',
						'units'          => 'px',
						'units_extended' => 'false',
						'all'            => false,
						'height'         => false,
						'title'          => esc_html__( 'SubMenu 1 Width', 'cosmos' ),
						'subtitle'       => esc_html__( 'Set width for submenu item 1', 'cosmos' ),
						'default'        => array (
							'width'   => '',
							'height'  => 'auto'
						),
						'required'       => array('pix-dropdown-custom','=',true),
					),
					array(
						'id'             => 'pix-submenu2-width',
						'type'           => 'dimensions',
						'units'          => 'px',
						'units_extended' => 'false',
						'all'            => false,
						'height'         => false,
						'title'          => esc_html__( 'SubMenu 2 Width', 'cosmos' ),
						'subtitle'       => esc_html__( 'Set width for submenu item 2', 'cosmos' ),
						'default'        => array (
							'width'   => '',
							'height'  => 'auto'
						),
						'required'       => array('pix-dropdown-custom','=',true),
					),
					array(
						'id'        => 'pix-dropdownmenu-align',
						'type'      => 'radio',
						'title'     => esc_html__( 'Dropdown Menu Align', 'cosmos' ),
						'options'   => array(
							'left'     => esc_html__( 'Left', 'cosmos' ),
							'right'    => esc_html__( 'Right', 'cosmos' )
						),
						'required'  => array('pix-dropdown-custom','=',true),
						'default'   => 'left'
					),
					array(
						'id'     => 'pix-dropdownmenu-section-end',
						'type'   => 'section',
						'indent' => false,
					),
				)
			);

			// Page title setting
			$this->sections[] = array(
				'title'     => esc_html__( 'Page Title', 'cosmos' ),
				'icon'      => 'el-icon-website',
				'fields'    => array(
					array(
						'id'        => 'pix-page-title-show',
						'type'      => 'switch',
						'title'     => esc_html__( 'Show Page Title', 'cosmos' ),
						'subtitle'  => esc_html__( 'Choose to show or hide page title', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos'),
						'off'       => esc_html__( 'Hide', 'cosmos'),
						'default'   => true,
					),
					array(
						'id'        => 'pix-page-title-bg',
						'type'      => 'background',
						'title'     => esc_html__( 'Page Title background image', 'cosmos' ),
						'subtitle'  => esc_html__( 'Body background image for page title section', 'cosmos' ),
						'default'   => array(
							'background-color'      => '',
							'background-repeat'     => 'no-repeat',
							'background-size'       => 'cover',
							'background-attachment' => 'fixed',
							'background-position'   => 'center center',
							'background-image'      => COSMOS_PUBLIC_URI.'/images/header/custom_1/bg_top_ct_1.jpg'
						),
					),
					array(
						'id'        => 'pix-pagetitle-pl-notice',
						'type'      => 'info',
						'notice'    => false,
						'style'     => 'info',
						'title'     => esc_html__( 'Background Parallax', 'cosmos' ),
						'desc'      => esc_html__( 'To use background parallax effect for Page Title, please set background-attachment field is "Fixed"', 'cosmos')
					),
					array(
						'id'        => 'pix-page-title-align',
						'type'      => 'radio',
						'title'     => esc_html__( 'Page Title Text Align', 'cosmos' ),
						'options'   => array(
							'center'   => esc_html__( 'Center', 'cosmos' ),
							'left'     => esc_html__( 'Left', 'cosmos' ),
							'right'    => esc_html__( 'Right', 'cosmos' ),
						),
						'default'   => 'center'
					),
					array(
						'id'             => 'pix-page-title-height',
						'type'           => 'dimensions',
						'units'          => 'px',
						'units_extended' => 'false',
						'all'            => false,
						'width'          => false,
						'title'          => esc_html__( 'Page Title Height', 'cosmos' ),
						'subtitle'       => esc_html__( 'Set height for page title session', 'cosmos' ),
						'default'        => array (
							'width'   => 'auto',
							'height'  => '200'
						)
					),
					array(
						'id'        => 'pix-title-section-start',
						'type'      => 'section',
						'title'     => esc_html__( 'The Title', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'       => 'pix-show-title',
						'type'     => 'switch',
						'title'    => esc_html__( 'Show Title', 'cosmos' ),
						'subtitle' => esc_html__( 'Choose to show or hide Title (only apply for page)', 'cosmos' ),
						'on'       => esc_html__( 'Show', 'cosmos'),
						'off'      => esc_html__( 'Hide', 'cosmos'),
						'default'  => true,
					),
					array(
						'id'        => 'pix-page-title-heading',
						'type'      => 'radio',
						'title'     => esc_html__( 'Heading Title', 'cosmos' ),
						'subtitle'  => esc_html__( 'Choose "H1" or "H2" or "H3" to show html headding. Serving for SEO', 'cosmos' ),
						'options'   => array(
										'1' => esc_html__( 'H1', 'cosmos' ),
										'2' => esc_html__( 'H2', 'cosmos' ),
										'3' => esc_html__( 'H3', 'cosmos' ),
										'4' => esc_html__( 'H4', 'cosmos' ),
										'5' => esc_html__( 'H5', 'cosmos' ),
										'6' => esc_html__( 'H6', 'cosmos' )
									),
						'default'   => '2',
					),
					array(
						'id'        => 'pix-page-title-type-display',
						'type'      => 'radio',
						'title'     => esc_html__( 'Type Page Title', 'cosmos' ),
						'subtitle'  => esc_html__( 'Choose "Level Title" to show label of the level  if it at page of archive, taxonomy or page has hierarchical', 'cosmos' ),
						'options'   => array(
										'post' => esc_html__( 'Default', 'cosmos' ),
										'level' => esc_html__( 'Level Title', 'cosmos' )
									),
						'default'   => 'post',
					),
					array(
						'id'             => 'pix-pagetitle-title',
						'type'           => 'typography',
						'title'          => esc_html__( 'Page Title Text', 'cosmos' ),
						'google'         => false,
						'font-backup'    => true,
						'line-height'    => false,
						'preview'        => true,
						'text-transform' => true,
						'font-family'    => false,
						'text-align'     => false,
						'all_styles'     => true,
						'units'          => 'px',
						// Defaults to px
						'subtitle'       => esc_html__( 'Config typography for page title text', 'cosmos' ),
						'default'        => array(
							'color'           => '',
							'font-weight'     => '',
							'font-size'       => '',
							'text-transform'  => ''
						),
					),
					array(
						'id'     => 'pix-title-section-end',
						'type'   => 'section',
						'indent' => false,
					),
					array(
						'id'        => 'pix-breadcrumb-section-start',
						'type'      => 'section',
						'title'     => esc_html__( 'Breadcrumb', 'cosmos' ),
						'subtitle'  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipisicing.', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'        => 'pix-show-breadcrumb',
						'type'      => 'switch',
						'title'     => esc_html__( 'Show Breadcrumb', 'cosmos' ),
						'subtitle'  => esc_html__( 'Choose to show or hide breadcrumb', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos'),
						'off'       => esc_html__( 'Hide', 'cosmos'),
						'default'   => true,
					),
					array(
					    'id'             => 'pix-breadcrumb-icon-color',
					    'type'           => 'color',
					    'title'          => esc_html__('Icon Next Color', 'cosmos'), 
					    'transparent'    => false,
					    'default'        => '#fff',
					    'validate'       => 'color',
					),
					array(
						'id'             => 'pix-breadcrumb-path',
						'type'           => 'typography',
						'title'          => esc_html__( 'Breadcrumb Path', 'cosmos' ),
						'google'         => false,
						'font-backup'    => true,
						'line-height'    => false,
						'preview'        => true,
						'text-transform' => true,
						'font-family'    => false,
						'text-align'     => false,
						'all_styles'     => true,
						'units'          => 'px',
						// Defaults to px
						'subtitle'       => esc_html__( 'Config typography for breadcrumb title', 'cosmos' ),
						'default'        => array(
							'color'           => '',
							'font-weight'     => '',
							'font-size'       => '',
							'text-transform'  => '',
						)
					),
					array(
						'id'             => 'pix-breadcrumb-path-hover',
						'type'           => 'typography',
						'title'          => esc_html__( 'Breadcrumb Path Hover', 'cosmos' ),
						'google'         => false,
						'font-backup'    => false,
						'line-height'    => false,
						'preview'        => false,
						'text-transform' => false,
						'font-weight'    => false,
						'font-size'      => false,
						'font-family'    => false,
						'font-style'     => false,
						'text-align'     => false,
						'all_styles'     => false,
						'units'          => 'px',
						// Defaults to px
						'subtitle'       => esc_html__( 'Config typography for breadcrumb title when hover', 'cosmos' ),
						'default'        => array(
							'color'           => '',
						)
					),
					array(
						'id'             => 'pix-breadcrumb-path2',
						'type'           => 'typography',
						'title'          => esc_html__( 'Breadcrumb Text Active', 'cosmos' ),
						'google'         => false,
						'font-backup'    => false,
						'line-height'    => false,
						'preview'        => true,
						'text-transform' => true,
						'font-family'    => false,
						'text-align'     => false,
						'all_styles'     => false,
						'units'          => 'px',
						// Defaults to px
						'subtitle'       => esc_html__( 'Config typography for breadcrumb title', 'cosmos' ),
						'default'        => array(
							'color'           => '',
							'font-weight'     => '',
							'font-size'       => '',
							'text-transform'  => '',
						)
					),
					array(
						'id'     => 'pix-breadcrumb-section-end',
						'type'   => 'section',
						'indent' => false,
					),
				)
			);

			// Sidebar setting
			$this->sections[] = array(
				'title'     => esc_html__( 'Sidebar', 'cosmos' ),
				'desc'      => esc_html__( 'Configuration for sidebar', 'cosmos' ),
				'icon'      => 'el-icon-caret-right',
				'fields'    => array(
					array(
						'id'        => 'pix-sidebar-section-st',
						'type'      => 'section',
						'title'     => esc_html__( 'Default Sidebar', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'        => 'pix-sidebar-layout',
						'type'      => 'image_select',
						'title'     => esc_html__( 'Default Sidebar Layout', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set how to display default sidebar', 'cosmos' ),
						'options'   => array(
							'left'  => array(
								'alt' => esc_html__( 'left', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'left.png'
							),
							'right' => array(
								'alt' => esc_html__( 'right', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'right.png'
							),
							'none'  => array(
								'alt' => esc_html__( 'none', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'nosidebar.png'
							)
						),
						'default'   => 'left'
					),
					array(
						'id'        => 'pix-sidebar',
						'type'      => 'select',
						'data'      => 'sidebars',
						'title'     => esc_html__( 'Default Sidebar', 'cosmos' ),
						'subtitle'  => sprintf(esc_html__( 'You can create new sidebar in Appearance -> %s', 'cosmos' ), $admin_widget_url ),
						'default'   => ''
					),

					// Blog archive sidebar
					array(
						'id'        => 'pix-bsidebar-section-st',
						'type'      => 'section',
						'title'     => esc_html__( 'Blog Archive Sidebar', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'        => 'pix-blog-sidebar-layout',
						'type'      => 'image_select',
						'title'     => esc_html__( 'Blog Sidebar Layout', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set how to display sidebar  in blog single pages.', 'cosmos' ),
						'options'   => array(
							'left'  => array(
								'alt' => esc_html__( 'left', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'left.png'
							),
							'right' => array(
								'alt' => esc_html__( 'right', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'right.png'
							),
							'none'  => array(
								'alt' => esc_html__( 'none', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'nosidebar.png'
							)
						),
						'default'   => 'left'
					),
					array(
						'id'        => 'pix-blog-sidebar',
						'type'      => 'select',
						'data'      => 'sidebars',
						'title'     => esc_html__( 'Blog Sidebar', 'cosmos' ),
						'subtitle'  => sprintf( esc_html__( 'You can create new sidebar in Appearance -> %s', 'cosmos' ), $admin_widget_url ),
						'default'   => ''
					),
					array(
						'id'     => 'pix-bsidebar-section-ed',
						'type'   => 'section',
						'indent' => false,
					),
					
					// Blog single sidebar
					array(
						'id'        => 'pix-bsidebar-section-st',
						'type'      => 'section',
						'title'     => esc_html__( 'Blog Single Sidebar', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'        => 'pix-blog-single-sidebar-layout',
						'type'      => 'image_select',
						'title'     => esc_html__( 'Blog Single Sidebar Layout', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set how to display sidebar  in blog single pages.', 'cosmos' ),
						'options'   => array(
							'left'  => array(
								'alt' => esc_html__( 'left', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'left.png'
							),
							'right' => array(
								'alt' => esc_html__( 'right', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'right.png'
							),
							'none'  => array(
								'alt' => esc_html__( 'none', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'nosidebar.png'
							)
						),
						'default'   => 'left'
					),
					array(
						'id'        => 'pix-blog-single-sidebar',
						'type'      => 'select',
						'data'      => 'sidebars',
						'title'     => esc_html__( 'Blog Single Sidebar', 'cosmos' ),
						'subtitle'  => sprintf( esc_html__( 'You can create new sidebar in Appearance -> %s', 'cosmos' ), $admin_widget_url ),
						'default'   => ''
					),
					array(
						'id'     => 'pix-bsidebar-section-ed',
						'type'   => 'section',
						'indent' => false,
					),
					
					// Team
					array(
						'id'        => 'pix-teamsidebar-section-st',
						'type'      => 'section',
						'title'     => esc_html__( 'Team Archive Sidebar', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'        => 'pix-team-sidebar-layout',
						'type'      => 'image_select',
						'title'     => esc_html__( 'Team Sidebar Layout', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set how to display sidebar in team archives page.', 'cosmos' ),
						'options'   => array(
							'left'  => array(
								'alt' => esc_html__( 'left', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'left.png'
							),
							'right' => array(
								'alt' => esc_html__( 'right', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'right.png'
							),
							'none'  => array(
								'alt' => esc_html__( 'none', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'nosidebar.png'
							)
						),
						'default'   => 'left'
					),
					array(
						'id'        => 'pix-team-sidebar',
						'type'      => 'select',
						'data'      => 'sidebars',
						'title'     => esc_html__( 'Team Sidebar', 'cosmos' ),
						'subtitle'  => sprintf( esc_html__( 'You can create new sidebar in Appearance -> %s', 'cosmos' ), $admin_widget_url ),
						'default'   => ''
					),
					// Team single sidebar
					array(
						'id'        => 'pix-bsidebar-section-st',
						'type'      => 'section',
						'title'     => esc_html__( 'Team Single Sidebar', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'        => 'pix-team-single-sidebar-layout',
						'type'      => 'image_select',
						'title'     => esc_html__( 'Team Single Sidebar Layout', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set how to display sidebar  in team single pages.', 'cosmos' ),
						'options'   => array(
							'left'  => array(
								'alt' => esc_html__( 'left', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'left.png'
							),
							'right' => array(
								'alt' => esc_html__( 'right', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'right.png'
							),
							'none'  => array(
								'alt' => esc_html__( 'none', 'cosmos' ),
								'img' => esc_url($image_opt_path) . 'nosidebar.png'
							)
						),
						'default'   => 'left'
					),
					array(
						'id'        => 'pix-team-single-sidebar',
						'type'      => 'select',
						'data'      => 'sidebars',
						'title'     => esc_html__( 'Team Single Sidebar', 'cosmos' ),
						'subtitle'  => sprintf( esc_html__( 'You can create new sidebar in Appearance -> %s', 'cosmos' ), $admin_widget_url ),
						'default'   => ''
					),
					array(
						'id'     => 'pix-bsidebar-section-ed',
						'type'   => 'section',
						'indent' => false,
					),
						
					array(
						'id'        => 'pix-sersidebar-section-ed',
						'type'      => 'section',
						'indent'    => false,
					),
				)
			);

			// Footer setting
			$this->sections[] = array(
				'title'     => esc_html__( 'Footer', 'cosmos' ),
				'icon'      => 'el-icon-caret-down',
				'desc'      => esc_html__( 'Configuration for footer of site', 'cosmos' ),
				'fields'    => array(
					
					// footer section
					array(
						'id'        => 'pix-footertop-section-st',
						'type'      => 'section',
						'title'     => esc_html__( 'Footer Section', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'        => 'pix-footer-show',
						'type'      => 'switch',
						'title'     => esc_html__( 'Show Footer ?', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos' ),
						'off'       => esc_html__( 'Hide', 'cosmos' ),
						'default'   => true
					),
					array(
						'id'        => 'pix-footer-bg',
						'type'      => 'background',
						'title'     => esc_html__( 'Footer Background Image', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set background image for footer section', 'cosmos' ),
						'default'   => array(
							'background-color'      => '',
							'background-image'      => '',
							'background-repeat'     => 'no-repeat',
							'background-attachment' => '',
							'background-position'	=> '',
							'background-size'		=> ''
						)
					),
					array(
					    'id'        => 'pix-footer-mask',
					    'type'      => 'color_rgba',
					    'title'     => esc_html__( 'Footer overlay background', 'cosmos' ),
					    'subtitle'  => esc_html__( 'Set background color for mask layer above footer', 'cosmos' ),
					    'default'   => array(
					        'color'     => '',
					        'rgba'     => '',
					    )
				    ),
					array(
						'id'     => 'pix-footertop-section-ed',
						'type'   => 'section',
						'indent' => false,
					),

					//footer main
					array(
						'id'        => 'pix-footerbt-main-section-st',
						'type'      => 'section',
						'title'     => esc_html__( 'Footer Main', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'        => 'pix-footer-main-show',
						'type'      => 'switch',
						'title'     => esc_html__( 'Show Footer Main ?', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos' ),
						'off'       => esc_html__( 'Hide', 'cosmos' ),
						'default'   => false
					),
					array(
						'id'        => 'pix-footer-main-logo',
						'type'      => 'switch',
						'title'     => esc_html__( 'Show Logo In Footer Main ?', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos' ),
						'off'       => esc_html__( 'Hide', 'cosmos' ),
						'default'   => true
					),
					array(
						'id'        => 'pix-footer-main-font-color',
						'type'      => 'link_color',
						'active'	=> false,
						'title'     => esc_html__( 'Footer Main Font Color', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set color for text or item footer main', 'cosmos' ),
					),
					array(
						'id'        => 'pix-footer-main-bg',
						'type'      => 'background',
						'title'     => esc_html__( 'Footer Background Image', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set background image for footer section', 'cosmos' ),
						'default'   => array(
							'background-color'      => '',
							'background-image'      => '',
							'background-repeat'     => 'no-repeat',
							'background-attachment' => '',
							'background-position'	=> '',
							'background-size'		=> ''
						)
					),
					array(
					    'id'        => 'pix-footer-main-mask',
					    'type'      => 'color_rgba',
					    'title'     => esc_html__( 'Footer overlay background', 'cosmos' ),
					    'subtitle'  => esc_html__( 'Set background color for mask layer above footer', 'cosmos' ),
					    'default'   => array(
					        'color'     => '',
					        'rgba'     => 'rgba(255, 255, 255, 0)',
					        )
				    ),
					array(
						'id'        => 'pix-footer-main-text',
						'type'      => 'textarea',
						'title'     => esc_html__( 'Text Of Footer Main', 'cosmos' ),
						'default'   => '',
					),
					array(
						'id'       => 'pix-footer-main-gallery',
						'type'     => 'gallery',
						'title'    => __('Add/Edit Images', 'cosmos'),
					),
					array(
						'id'        => 'pix-footerbt-main-section-ed',
						'type'      => 'section',
						'indent'    => true,
					),

					/* Footer Bottom */
					array(
						'id'        => 'pix-footerbt-section-st',
						'type'      => 'section',
						'title'     => esc_html__( 'Footer Bottom', 'cosmos' ),
						'indent'    => true,
					),
					array(
						'id'        => 'pix-footer-bottom-show',
						'type'      => 'switch',
						'title'     => esc_html__( 'Footer Bottom', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos' ),
						'off'       => esc_html__( 'Hide', 'cosmos' ),
						'default'   => true,
					),
					array(
						'id'        => 'pix-footer-bottom-font-color',
						'type'      => 'link_color',
						'title'     => esc_html__( 'Footer Bottom Font Color', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set color for text or item footer bottom', 'cosmos' ),
					),
					array(
					    'id'        => 'pix-footer-bottom-bg-color',
					    'type'      => 'color_rgba',
					    'title'     => esc_html__( 'Footer Bottom Background Color', 'cosmos' ),
					    'subtitle'  => esc_html__( 'Set background color for footer bottom', 'cosmos' ),
					    'default'   => array(
					        'color'     => '',
					        'rgba'     => '',
					    )
				    ),
					array(
						'id'        => 'pix-footerbt-col1',
						'type'      => 'sorter',
						'title'     => esc_html__( 'Content Of 1st Column', 'cosmos' ),
						'subtitle'  => esc_html__( 'Choose what information to show in 1st column', 'cosmos' ),
						'options'   => array(
							'disabled' => array(
								'menu'    => esc_html__( 'Navigation', 'cosmos' ),
								'social'  => esc_html__( 'Social Link', 'cosmos' ),
							),
							'enabled'  => array(
								'text'    => esc_html__( 'Text', 'cosmos' ),
							),
						),
					),
					array(
						'id'        => 'pix-footerbt1-text',
						'type'      => 'textarea',
						'title'     => esc_html__( 'Text Of 1st Column', 'cosmos' ),
						'subtitle'  => esc_html__( 'Information of footer bottom', 'cosmos' ),
						'default'   => COSMOS_COPYRIGHT,
					),
					array(
						'id'        => 'pix-footerbt-col2',
						'type'      => 'sorter',
						'title'     => esc_html__( 'Content Of 2nd Column', 'cosmos' ),
						'subtitle'  => esc_html__( 'Choose what information to show in 2nd column', 'cosmos' ),
						'options'   => array(
							'disabled' => array(
								'menu'    => esc_html__( 'Navigation', 'cosmos' ),
								'text'    => esc_html__( 'Text', 'cosmos' ),
								'social'  => esc_html__( 'Social Link', 'cosmos' ),
							),
							'enabled'  => array(
							),
						),
					),
					array(
						'id'        => 'pix-footerbt2-text',
						'type'      => 'textarea',
						'title'     => esc_html__( 'Text Of 2nd Column', 'cosmos' ),
						'default'   => COSMOS_COPYRIGHT,
					),
					array(
						'id'     => 'pix-footerbt-section-ed',
						'type'   => 'section',
						'indent' => false,
					)
				)
			);
			
			// Blog Setting
			$this->sections[] = array(
				'title'     => esc_html__( 'Blog Display', 'cosmos' ),
				'icon'      => 'el-icon-edit',
				'desc'      => esc_html__( 'Configuration layout for blog template', 'cosmos' ),
				'fields'    => array(
					array(
						'id'        => 'pix-blog-showdate',
						'type'      => 'switch',
						'title'     => esc_html__( 'Show Date Of Blog', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos' ),
						'off'       => esc_html__( 'Hide', 'cosmos' ),
						'default'   => true
					),
					array(
						'id'        => 'pix-blog-show-related',
						'type'      => 'switch',
						'title'     => esc_html__( 'Show Related Post Of Blog', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos' ),
					'off'       => esc_html__( 'Hide', 'cosmos' ),
						'default'   => true
					),
					array(
						'id'        => 'pix-blog-social-position',
						'type'      => 'switch',
						'title'     => esc_html__( 'Where To Show Social Share?', 'cosmos' ),
						'on'        => esc_html__( 'Above', 'cosmos' ),
						'off'       => esc_html__( 'Below', 'cosmos' ),
						'default'   => false
					),
					array(
						'id'        => 'pix-bloginfo',
						'type'      => 'sorter',
						'title'     => esc_html__( 'Blog Info', 'cosmos' ),
						'subtitle'  => esc_html__( 'Choose what information to show below blog content', 'cosmos' ),
						'options'   => array(
							'disabled' => array(
								'date'    => esc_html__( 'Date', 'cosmos' ),
							),
							'enabled'  => array(
								'author'    => esc_html__( 'Author', 'cosmos' ),
								'view'      => esc_html__( 'View', 'cosmos' ),
								'comment'   => esc_html__( 'Comment number', 'cosmos' ),
							),
						),
					),
					
					array(
						'id'        => 'pix-blog-author',
						'type'      => 'switch',
						'title'     => esc_html__( 'Author Section', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos' ),
						'off'       => esc_html__( 'Hide', 'cosmos' ),
						'default'   => true
					),
					array(
						'id'        => 'pix-blog-tag',
						'type'      => 'switch',
						'title'     => esc_html__( 'Tag Section', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos' ),
						'off'       => esc_html__( 'Hide', 'cosmos' ),
						'default'   => true
					),
					array(
						'id'        => 'pix-blog-cat',
						'type'      => 'switch',
						'title'     => esc_html__( 'Category Section', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos' ),
						'off'       => esc_html__( 'Hide', 'cosmos' ),
						'default'   => true
					),
					array(
						'id'        => 'pix-commentbox',
						'type'      => 'switch',
						'title'     => esc_html__( 'Comments Section', 'cosmos' ),
						'on'        => esc_html__( 'Show', 'cosmos' ),
						'off'       => esc_html__( 'Hide', 'cosmos' ),
						'default'   => true
					),
				)
			);

			// 404  Setting
			$this->sections[] = array(
				'title'     => esc_html__( '404 Setting', 'cosmos' ),
				'icon'      => 'el-icon-info-circle',
				'desc'      => esc_html__( 'This page will display options for 404 page', 'cosmos' ),
				'fields'    => array(
					array(
					    'id'             => 'pix-text-404-color',
					    'type'           => 'color',
					    'title'          => esc_html__('Color 404', 'cosmos'), 
					    'transparent'    => false,
					    'validate'       => 'color'
					),
					array(
						'id'        => 'pix-404-title',
						'type'      => 'text',
						'title'     => esc_html__( 'Title', 'cosmos' ),
						'default'   => esc_html__( 'Sorry, this page does not exist', 'cosmos' ),
					),
					array(
						'id'        => 'pix-404-desc',
						'type'      => 'text',
						'title'     => esc_html__( 'Description', 'cosmos'),
						'default'   => esc_html__( 'The link you clicked might be corrupted, or the page may have been removed.', 'cosmos' ),
					),
					
				)
			);

			// Custom CSS
			$this->sections[] = array(
				'title'     => esc_html__( 'Custom Style', 'cosmos' ),
				'icon'      => 'el-icon-css',
				'desc'      => esc_html__( 'Customize your site by code', 'cosmos' ),
				'fields'    => array(
					array(
						'id'       => 'pix-custom-css',
						'type'     => 'ace_editor',
						'title'    => esc_html__( 'CSS Code', 'cosmos' ),
						'subtitle' => esc_html__( 'Paste your CSS code here.', 'cosmos' ),
						'mode'     => 'css',
						'theme'    => 'monokai',
						'default'  => "body{\n   margin: 0 auto;\n}"
					)
				)
			);

			// Custom js
			$this->sections[] = array(
				'title'     => esc_html__( 'Custom Script', 'cosmos' ),
				'icon'      => 'el-icon-link',
				'desc'      => esc_html__( 'Customize your site by code', 'cosmos' ),
				'fields'    => array(
					array(
						'id'       => 'pix-custom-js',
						'type'     => 'ace_editor',
						'title'    => esc_html__( 'JS Code', 'cosmos' ),
						'subtitle' => esc_html__( 'Paste your JS code here.', 'cosmos' ),
						'mode'     => 'javascript',
						'theme'    => 'chrome',
						'default'  => "jQuery(document).ready(function(){\n\n});"
					),
				)
			);

			// Typography
			$this->sections[] = array(
				'title'     => esc_html__( 'Typography', 'cosmos' ),
				'icon'      => 'el-icon-text-height',
				'desc'      => esc_html__( 'Customize your site by code', 'cosmos' ),
				'fields'    => array(
					array(
						'id'        => 'pix-typo-body',
						'type'      => 'typography',
						'title'     => esc_html__( 'Body text', 'cosmos' ),
						'subtitle'  => esc_html__( 'Set font ', 'cosmos' ),
						'google'    => true,
						'default'   => false
					),
					array(
						'id'        => 'pix-typo-p',
						'type'      => 'typography',
						'title'     => esc_html__( 'Paragraph text', 'cosmos' ),
						'google'    => true,
						'default'   => false
					),
                    array(
						'id'       	=> 'pix-link-color-type',
						'type'     	=> 'switch',
						'title'    	=> esc_html__( 'Link color options', 'cosmos' ),
						'on'       	=> esc_html__( 'Custom', 'cosmos' ),
						'off'      	=> esc_html__( 'Default', 'cosmos' ),
						'default'  	=> false
					),
					array(
						'id'       => 'pix-link-color',
						'type'     => 'link_color',
						'title'    => esc_html__( 'Links Color', 'cosmos' ),
						'subtitle' => esc_html__( 'Only color validation can be done on this field type', 'cosmos' ),
						'required' => array('pix-link-color-type','=',true),
						'default'  => array(
							'regular' => '#51616b',
							'hover'   => '#0f77ad',
							'active'  => '#0f77ad',
						)
					),
					array(
						'id'        => 'pix-typo-h1',
						'type'      => 'typography',
						'title'     => esc_html__( 'H1 text', 'cosmos' ),
						'google'    => true,
						'default'   => false
					),
					array(
						'id'        => 'pix-typo-h2',
						'type'      => 'typography',
						'title'     => esc_html__( 'H2 text', 'cosmos' ),
						'google'    => true,
						'default'   => false
					),
					array(
						'id'        => 'pix-typo-h3',
						'type'      => 'typography',
						'title'     => esc_html__( 'H3 text', 'cosmos' ),
						'google'    => true,
						'default'   => false
					),
					array(
						'id'        => 'pix-typo-h4',
						'type'      => 'typography',
						'title'     => esc_html__( 'H4 text', 'cosmos' ),
						'google'    => true,
						'default'   => false
					),
					array(
						'id'        => 'pix-typo-h5',
						'type'      => 'typography',
						'title'     => esc_html__( 'H5 text', 'cosmos' ),
						'google'    => true,
						'default'   => false
					),
					array(
						'id'        => 'pix-typo-h6',
						'type'      => 'typography',
						'title'     => esc_html__( 'H6 text', 'cosmos' ),
						'google'    => true,
						'default'   => false
					)
				)
			);

		}

		public function setHelpTabs() {

			// Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
			$this->args['help_tabs'][] = array(
				'id'        => 'redux-help-tab-1',
				'title'     => esc_html__('Theme Information 1', 'cosmos'),
				'content'   => sprintf('<p>%s</p>', esc_html__('This is the tab content, HTML is allowed.', 'cosmos'))
			);

			$this->args['help_tabs'][] = array(
				'id'        => 'redux-help-tab-2',
				'title'     => esc_html__('Theme Information 2', 'cosmos'),
				'content'   => sprintf('<p>%s</p>', esc_html__('This is the tab content, HTML is allowed.', 'cosmos'))
			);

			// Set the help sidebar
			$this->args['help_sidebar'] = sprintf('<p>%s</p>', esc_html__('This is the sidebar content, HTML is allowed.', 'cosmos'));
		}

		/*
	      All the possible arguments for Redux.
	      For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
		*/

		public function setArguments() {

			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
				'opt_name'              => 'cosmos_options',
				'dev_mode'              => false, // disable dev mode when release
				'use_cdn'               => false,
				'global_variable'       => 'cosmos_options',
				'display_name'          => esc_html__( 'Cosmos', 'cosmos' ),
				'display_version'       => false,
				'page_slug'             => 'Cosmos_options',
				'page_title'            => esc_html__( 'Cosmos Option Panel', 'cosmos' ),
				'update_notice'         => false,
				'menu_type'             => 'menu',
				'menu_title'            => esc_html__( 'Theme Options', 'cosmos' ),
				'menu_icon'             => COSMOS_ADMIN_URI.'/images/menu-icon.png',
				'allow_sub_menu'        => true,
				'page_priority'         => '4',
				'page_parent'           => 'cosmos_welcome',
				'customizer'            => true,
				'default_mark'          => '*',
				'class'                 => 'sw_theme_options_panel',
				'hints'                 => array(
					'icon'          => 'el-icon-question-sign',
					'icon_position' => 'right',
					'icon_size'     => 'normal',
					'tip_style'     => array(
						'color' => 'light',
					),
					'tip_position' => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect' => array(
						'show' => array(
							'duration' => '500',
							'event'    => 'mouseover',
						),
						'hide' => array(
							'duration' => '500',
							'event'    => 'mouseleave unfocus',
						),
					),
				),
				'intro_text'         => '',
				'footer_text'        => '<p>'. esc_html__( 'Thank you for purchased Cosmos!', 'cosmos' ).'</p>',
				'page_icon'          => 'icon-themes',
				'page_permissions'   => 'manage_options',
				'save_defaults'      => true,
				'show_import_export' => true,
				'database'           => 'options',
				'transient_time'     => '3600',
				'network_sites'      => true,
			);

			$this->args['share_icons'][] = array(
				'url'   => esc_url( 'https://www.facebook.com/pixartthemes/' ),
				'title' => esc_html__( 'Like us on Facebook', 'cosmos' ),
				'icon'  => esc_attr__( 'el-icon-facebook', 'cosmos' )
			);
			$this->args['share_icons'][] = array(
				'url'   => esc_url( 'http://themeforest.net/user/pixartthemes' ),
				'title' => esc_html__( 'Follow us on themeforest', 'cosmos' ),
				'icon'  => esc_attr__( 'el-icon-user', 'cosmos' )
			);
			$this->args['share_icons'][] = array(
				'url'   => esc_attr( 'mailto:admin@pixartthemes.co' ),
				'title' => esc_html__( 'Send us email', 'cosmos' ),
				'icon'  => esc_attr__( 'el-icon-envelope', 'cosmos' )
			);
		}

	}

	global $cosmos_reduxConfig;
	$cosmos_reduxConfig = new Cosmos_Redux_Framework_Config();
}
/*
  Custom function for the callback validation referenced above
*/
if (!function_exists('cosmos_validate_callback_function')):
	function cosmos_validate_callback_function($field, $value, $existing_value) {
		$error = false;
		$value = 'just testing';

		$return['value'] = $value;
		if ($error == true) {
			$return['error'] = $field;
		}
		return $return;
	}
endif;