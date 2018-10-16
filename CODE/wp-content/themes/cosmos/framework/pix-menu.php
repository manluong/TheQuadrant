<?php
	//Back end
	add_filter( 'wp_edit_nav_menu_walker', 'cosmos_edit_nav_menu', 10, 2 );
	function cosmos_edit_nav_menu( $walker, $menu_id ) {
		return 'cosmos_Nav_Menu_Edit_Custom';
	}
	
	add_action( 'wp_update_nav_menu_item', 'cosmos_update_menu', 100, 3);

	//update menu
	function cosmos_update_menu($menu_id, $menu_item_db)
	{
		
		$check = array('show-megamenu','megamenu-style','megamenu-column','choose-icon','hashtag','choose-widgetarea','show-widget','tab-title','megamenu-widget-column');
		foreach ( $check as $key )
		{
			if(!isset($_POST['menu-item-pix-'.esc_attr($key)][$menu_item_db]))
			{
				$_POST['menu-item-pix-'.esc_attr($key)][$menu_item_db] = "";
			}
			$value = $_POST['menu-item-pix-'.esc_attr($key)][$menu_item_db];
			update_post_meta( $menu_item_db, '_menu-item-pix-'.esc_attr($key), $value );
		}
	}
	if( !class_exists( 'cosmos_Nav_Menu_Edit_Custom' ) )
	{
		class cosmos_Nav_Menu_Edit_Custom extends Walker_Nav_Menu
		{
			/**
			 * @see Walker_Nav_Menu::start_lvl()
			 * @since 3.0.0
			 *
			 * @param string $output Passed by reference.
			 * @param int $depth Depth of page.
			 */
			public function start_lvl(&$output, $depth = 0, $args = array() ) {}

			/**
			 * @see Walker_Nav_Menu::end_lvl()
			 * @since 3.0.0
			 *
			 * @param string $output Passed by reference.
			 * @param int $depth Depth of page.
			 */
			public function end_lvl(&$output, $depth = 0, $args = array()) {}
			/**
			 * @see Walker::start_el()
			 * @since 3.0.0
			 *
			 * @param string $output Passed by reference. Used to append additional content.
			 * @param object $item Menu item data object.
			 * @param int $depth Depth of menu item. Used for padding.
			 * @param int $current_page Menu item ID.
			 * @param object $args
			 */
			public function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
				global $_wp_nav_menu_max_depth;
				$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
				$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
				ob_start();
				$item_id = esc_attr( $item->ID );
				$removed_args = array(
					'action',
					'customlink-tab',
					'edit-menu-item',
					'menu-item',
					'page-tab',
					'_wpnonce',
				);

				$original_title = '';
				if ( 'taxonomy' == $item->type ) {
					$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
				} elseif ( 'post_type' == $item->type ) {
					$original_object = get_post( $item->object_id );
					$original_title = $original_object->post_title;
				}

				$classes = array(
					'menu-item menu-item-depth-' . esc_attr($depth),
					'menu-item-' . esc_attr( $item->object ),
					'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
				);

				$title = $item->title;

				if ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
					$classes[] = 'pending';
					$title = sprintf( esc_html__('%s (Pending)', 'cosmos'), $item->title );
				}

				$title = empty( $item->label ) ? $title : $item->label;

				$itemValue = "";
				if($depth == 0)
				{
					$itemValue = get_post_meta( $item->ID, '_menu-item-pix-megamenu', true);
					if($itemValue != "") $itemValue = 'pix_mega_active ';
				}
				?>
				<li id="menu-item-<?php echo esc_attr( $item_id ); ?>" class="<?php echo esc_attr( $itemValue ); echo ' ' . implode(' ', $classes ); ?>">
					<dl class="menu-item-bar">
						<dt class="menu-item-handle">
							<span class="item-title"><?php echo esc_html( $title ); ?></span>
							<span class="item-controls">
								<span class="item-type item-type-default"><?php echo esc_html( $item->type_label ); ?></span>
								<a class="item-edit" id="edit-<?php echo esc_attr( $item_id ); ?>" title="<?php esc_html_e('Edit Menu Item', 'cosmos' ); ?>" href="<?php
									echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? esc_url( admin_url( 'nav-menus.php' ) ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, esc_url( admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) ) );
								?>"><?php esc_html_e('Edit Menu Item', 'cosmos' ); ?></a>
							</span>
						</dt>
					</dl>

					<div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr( $item_id ); ?>">
						<?php if( 'custom' == $item->type ) : ?>
							<p class="field-url description description-wide">
								<label for="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>">
									<?php esc_html_e( 'URL', 'cosmos' ); ?><br />
									<input type="text" id="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
								</label>
							</p>
						<?php endif; ?>
						<p class="description description-thin description-label pix_label_desc_on_active">
							<label for="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>">
							<span class='pix_default_label'><?php esc_html_e( 'Navigation Label', 'cosmos'  ); ?></span>
								<br />
								<input type="text" id="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
							</label>
						</p>
						<p class="description description-thin description-title">
							<label for="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>">
								<?php esc_html_e( 'Title Attribute', 'cosmos'  ); ?><br />
								<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
							</label>
						</p>
						<p class="field-link-target description description-thin">
							<label for="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>">
								<?php esc_html_e( 'Link Target', 'cosmos'  ); ?><br />
								<select id="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-target" name="menu-item-target[<?php echo esc_attr( $item_id ); ?>]">
									<option value="" <?php selected( $item->target, ''); ?>><?php esc_html_e('Same window or tab', 'cosmos' ); ?></option>
									<option value="_blank" <?php selected( $item->target, '_blank'); ?>><?php esc_html_e('New window or tab', 'cosmos' ); ?></option>
								</select>
							</label>
						</p>
						<p class="field-css-classes description description-thin">
							<label for="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>">
								<?php esc_html_e( 'CSS Classes (optional)' , 'cosmos' ); ?><br />
								<input type="text" id="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
							</label>
						</p>
						<p class="field-xfn description description-thin">
							<label for="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>">
								<?php esc_html_e( 'Link Relationship (XFN)', 'cosmos'  ); ?><br />
								<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
							</label>
						</p>
						<p class="field-description description description-wide">
							<label for="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>">
								<?php esc_html_e( 'Description', 'cosmos'  ); ?><br />
								<textarea id="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr( $item_id ); ?>]"><?php echo esc_html( $item->post_content ); ?></textarea>
							</label>
						</p>
						<?php do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args ); ?>
						
						<!--custom menu-->
						<div class='pix_menu_options'>
							<!--choose icon-->
							<?php
							$key = "menu-item-pix-choose-icon";
							$value = get_post_meta( $item->ID, '_'.$key, true);
							?>
							<p class="shw_hide_d0 shw_text choose-icon  shw_mega_menu ">
								<label for="edit-<?php echo esc_attr( $key ).'-'. esc_attr( $item_id ); ?>"><?php esc_html_e( 'Enter icon for menu' , 'cosmos'); ?><br>
									<input type="text"  id="edit-<?php echo esc_attr( $key ).'-'. esc_attr( $item_id ); ?>" class=" <?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ) . "[". $item_id ."]";?>" value="<?php echo esc_attr( $value ); ?>" /><?php esc_html_e( 'Ex:fa-crosshairs', 'cosmos' );?>
								</label>
							</p>
							<!-- hashtag -->
							<?php
							$key = "menu-item-pix-hashtag";
							$value = get_post_meta( $item->ID, '_'.$key, true);
							?>
							<p class="shw_hide_d0 shw_text choose-icon  shw_mega_menu ">
								<label for="edit-<?php echo esc_attr( $key ).'-'. esc_attr( $item_id ); ?>"><?php esc_html_e( 'Enter Hashtag' , 'cosmos'); ?><br>
									<input type="text"  id="edit-<?php echo esc_attr( $key ).'-'. esc_attr( $item_id ); ?>" class=" <?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ) . "[". $item_id ."]";?>" value="<?php echo esc_attr( $value ); ?>" /><?php esc_html_e( 'You should enter hashtag have been set class within trang. Ex: home-page', 'cosmos' );?>
								</label>
							</p>

							<!--use mega menu-->
							<?php 
							$key = "menu-item-pix-show-megamenu";
							$show_megamenu  = get_post_meta( $item->ID, '_'.esc_attr($key), true);
							$megamenu_item = '';
							$widget_item = '';
							if( $show_megamenu  != "" ){
								$show_megamenu = "checked='checked'";
								$megamenu_item = "pix-mega-menu-d0";
								$widget_item = "open";
							}
							
							?>
							<!-- <p class="description description-wide pix-show-megamenu pix-mega-menu-d0">
								<label for="edit-<?php echo esc_attr( $key ) . '-' . esc_attr( $item_id ); ?>">
									<input type="checkbox" value="active" id="edit-<?php echo esc_attr( $key ) . '-' .esc_attr( $item_id ); ?>" class=" <?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ) . "[". esc_attr( $item_id )."]";?>" <?php echo esc_attr( $show_megamenu ); ?> /><?php esc_html_e( 'Use as Mega Menu' , 'cosmos'); ?>
								</label>
							</p> -->
							<!--Choose column for normal mega menu-->
							<?php
							$key = "menu-item-pix-megamenu-style";
							$value = get_post_meta( $item->ID, '_'.esc_attr($key), true);
							?>
							<p class="megamenu-style description description-wide <?php echo esc_attr( $megamenu_item ); ?>">
								<label for="edit-menu-item-megamenu-style-<?php echo esc_attr( $item_id ); ?>">
									<?php esc_html_e( 'Select style for megamenu' , 'cosmos'); ?>
									<select id="edit-menu-item-megamenu-style-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-megamenu-style" name="menu-item-pix-megamenu-style[<?php echo esc_attr( $item_id ); ?>]">
										<option value="0" <?php selected( $value, '0' ); ?>><?php esc_html_e( 'Block' , 'cosmos'); ?></option>
										<option value="1" <?php selected( $value, '1' ); ?>><?php esc_html_e( 'Tab' , 'cosmos'); ?></option>
									</select>
								</label>
							</p>
							<!--Choose column for normal mega menu-->
							<?php
							$key = "menu-item-pix-megamenu-column";
							$value = get_post_meta( $item->ID, '_'.esc_attr($key), true);
							?>
							<p class="megamenu-column description description-wide <?php echo esc_attr( $megamenu_item ); ?>">
								<label for="edit-menu-item-megamenu-column-<?php echo esc_attr( $item_id ); ?>">
									<?php esc_html_e( 'Select column number for megamenu' , 'cosmos'); ?>
									<select id="edit-menu-item-megamenu-column-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-megamenu-column" name="menu-item-pix-megamenu-column[<?php echo esc_attr( $item_id ); ?>]">
										<option value="0" <?php selected( $value, '0' ); ?>><?php esc_html_e( '1 Column' , 'cosmos'); ?></option>
										<option value="1" <?php selected( $value, '1' ); ?>><?php esc_html_e( '2 Columns' , 'cosmos'); ?></option>
										<option value="2" <?php selected( $value, '2' ); ?>><?php esc_html_e( '3 Columns' , 'cosmos'); ?></option>
										<option value="3" <?php selected( $value, '3' ); ?>><?php esc_html_e( '4 Columns' , 'cosmos'); ?></option>
									</select>
								</label>
							</p>
							

							<!--Title for menu has widget-->
							<?php
							$key = "menu-item-pix-tab-title";
							$value = get_post_meta( $item->ID, '_'.esc_attr($key), true);
							?>
							<p class="pix_text tab-title pix_mega_menu <?php echo esc_attr( $megamenu_item ); ?>">
								<label for="edit-<?php echo esc_attr( $key ) . '-' . esc_attr( $item_id ); ?>"><?php esc_html_e( 'Enter title  for mega menu style "Tab" ' , 'cosmos'); ?><br>
									<input type="text"  id="edit-<?php echo esc_attr( $key ) . '-' . esc_attr( $item_id ); ?>" class="menu-text-box  <?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ) . "[". esc_attr( $item_id ) ."]";?>" value="<?php esc_attr( $value ); ?>" />
								</label>
							</p>
							 <!--Choose widget area-->
							<?php
							$key = "menu-item-pix-choose-widgetarea";
							$value = get_post_meta( $item->ID, '_'.esc_attr($key), true);?>
							<p class="description description-wide choose-widgetarea  <?php echo esc_attr( $widget_item ) ;?>">
								<label for="edit-menu-item-megamenu-widgetarea-<?php echo esc_attr( $item_id ); ?>">
									<?php esc_html_e( 'Select Widget Area' , 'cosmos'); ?>
									<select id="edit-menu-item-megamenu-widgetarea-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-megamenu-widgetarea" name="menu-item-pix-choose-widgetarea[<?php echo esc_attr( $item_id ); ?>]">
										<option value="0"><?php esc_html_e( 'Select Widget Area' , 'cosmos'); ?></option>
										<?php
										global $wp_registered_sidebars;
										if( ! empty( $wp_registered_sidebars ) && is_array( $wp_registered_sidebars ) ):
											foreach( $wp_registered_sidebars as $sidebar ):
										?>
										<option value="<?php echo esc_attr( $sidebar['id'] ); ?>" <?php selected( $value, $sidebar['id'] ); ?>><?php echo esc_html( $sidebar['name'] ); ?></option>
										<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</label>
							</p>
							
							<!--End option-->

							<div class="menu-item-actions description-wide submitbox">
								<?php if( 'custom' != $item->type ) : ?>
									<p class="link-to-original">
										<?php printf( esc_html__('Original: %s', 'cosmos'), '<a href="' . esc_url( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
									</p>
								<?php endif; ?>
								<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr( $item_id ); ?>" href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'delete-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, esc_url( admin_url( 'nav-menus.php' ) ) )
									),
									'delete-menu_item_' . $item_id
								); ?>"><?php esc_html_e('Remove', 'cosmos'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo esc_attr( $item_id ); ?>" href="<?php echo add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, esc_url( admin_url( 'nav-menus.php' ) ) ) );
									?>#menu-item-settings-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e('Cancel', 'cosmos'); ?></a>
							</div>

							<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item_id ); ?>" />
							<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
							<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
							<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
							<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
							<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
						</div>
						<div class="clearfix"></div>
					</div>
					<ul class="menu-item-transport"></ul>
				<?php
				$output .= ob_get_clean();
			} // end start_el func
		} // end class
	}

	//frontend
	if( ! function_exists( 'cosmos_show_top_menu' ) ) {
		function cosmos_show_top_menu() {
			$walker = new Cosmos_Nav_Walker;
			return wp_nav_menu( array(
				'theme_location'  => 'top-nav',
				'container'       => 'ul',
				'menu_class'      => 'nav-links nav navbar-nav cosmos-menu cosmos-top-menu',
				'walker'          => $walker,
				'echo' => false
			));
		}
	}
	if( ! function_exists( 'cosmos_show_main_menu' ) ) {
		function cosmos_show_main_menu() {
			$walker = new Cosmos_Nav_Walker;
			if ( has_nav_menu( 'main-nav' ) ) {
				wp_nav_menu( array(
					'theme_location'  => 'main-nav',
					'container'       => 'ul',
					'menu_class'      => 'menu-des menu__list js-dynamic-menu-des',
					'walker'          => $walker
				));
			}
		}
	}
	if( ! function_exists( 'cosmos_show_main_menu_mobile' ) ) {
		function cosmos_show_main_menu_mobile() {
			$walker = new Cosmos_Nav_Walker;
			if ( has_nav_menu( 'main-nav' ) ) {
				wp_nav_menu( array(
					'theme_location'  => 'main-nav',
					'container'       => 'ul',
					'menu_class'      => 'menu-mb not-fixed',
					'walker'          => $walker
				));
			}
		}
	}
	/**
	 * Add class active
	 */
	if( ! function_exists( 'cosmos_special_nav_class' ) ) {
		function cosmos_special_nav_class( $classes, $item ) {
			if( in_array( 'current-menu-item', $classes ) || ( in_array( 'current-menu-ancestor', $classes ) ) ) {
				$classes[] = 'active';
			}
			return $classes;
		}
		add_filter( 'nav_menu_css_class', 'cosmos_special_nav_class', 10, 2 );
	}
	/**
	 * Menu
	 */
	class Cosmos_Nav_Walker extends Walker_Nav_Menu {
		
		
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
			$dropdown_align =  Cosmos::get_option('pix-dropdownmenu-align');
			if(empty($dropdown_align)){
				$dropdown_align = 'left';
			}
			$class_dropdown_align = 'pos-menu-'.$dropdown_align;

			$indent = str_repeat( "\t", $depth );
			if ($this->mega_active == "active" ){
				if($this->mega_style == 1){
					if( $depth == 0 ) {
						$output .= $indent.'<div class="mega-menu-content menu-tabs"><div class="row"><div class="col-md-3 prn"><ul class="nav nav-tabs"><li><h3 class="heading">'.$this->menu_tab_title.'</h3></li>';
					}
					else if( $depth == 1 ){
						$output .= $indent.'<ul class="menu-tab-depth-2">';
					}else{
						$output .= $indent.'<ul>';
					}
					
				}else{
					if( $depth == 0 ) {
						$output .= $indent.'<ul class="mega-content-wrap"><li class="mega-wrap">';
					}
					else{
						$output .= $indent.'<ul class="dropdown-menu-1">';
					}
				}
			}else{
				if( $depth == 0 ) {
					$output .= $indent.'<ul class="dropdown-menu-1 cosmos-dropdown-menu-1 parent-sub-menu '.$class_dropdown_align.'">';
				}
				else{
					$output .= $indent.'<ul class="dropdown-menu-2 cosmos-dropdown-menu-2 parent-sub-menu '.$class_dropdown_align.'">';
				}
			}
		}
		
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent  = str_repeat( "\t", $depth );
			if ($this->mega_active == "active" ){
				if($this->mega_style == 1){
					if( $depth == 0 ) {
						$output .= $indent.'</ul></div><div class="col-md-9 pln"><div class="tab-content "></div></div></div></div>'; 
					}else{
						$output .= $indent.'</ul>'; 
					}
				}
				else{
					if( $depth == 0 ) {
						$output .= $indent.'</li></ul>';
					}else{
						$output .= $indent.'</ul>'; 
					}
				
				}
			}else{
				if( $depth == 0 ) {
					$output .= $indent.'</ul>';
				} else {
					$output .= $indent.'</ul>';
				}
			}
			
		}

		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			if( empty( $args ) ) {
				return '';
			}
			$args        = (object) $args;
			$indent      = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[]   = 'menu-item-' . $item->ID;
			$class_names = join( ' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$this->icon = get_post_meta( $item->ID, '_menu-item-pix-choose-icon', true);
			$show_menu_icon  =  Cosmos::get_option('pix-menu-icon');
			if( !empty($show_menu_icon) && $show_menu_icon ==1 && !empty($this->icon)){
				$this->icon = $this->icon.' '.'menu-icon';
				$html_icon = '<i class="fa '.$this->icon.' menu-icon"></i>';
			}else{
				$this->icon = $html_icon = '';
			}
			$this->hashtag = get_post_meta( $item->ID, '_menu-item-pix-hashtag', true);

			//mega menu
			if ($depth === 0){
				$this->megamenu_column = get_post_meta( $item->ID, '_menu-item-pix-megamenu-column', true);
				$this->mega_active = get_post_meta( $item->ID, '_menu-item-pix-show-megamenu', true);
				$this->mega_style = get_post_meta( $item->ID, '_menu-item-pix-megamenu-style', true);
				$this->menu_tab_title = get_post_meta( $item->ID, '_menu-item-pix-tab-title', true);
			
				if ( $this->megamenu_column == 0 ){
					$this->megamenu_column = "col-md-12";
				}
				else if ( $this->megamenu_column == 1 ){
					$this->megamenu_column = "col-md-6";
				}
				else if ( $this->megamenu_column == 2 ){
					$this->megamenu_column = "col-md-4";
				}
				else {
					$this->megamenu_column = "col-md-3";
				}
			}else if ($depth === 1){
				$this->menu_megamenu_widgetarea = get_post_meta( $item->ID, '_menu-item-pix-choose-widgetarea', true);
			}
			if ($this->mega_active == "active"){

				if($this->mega_style == 1){
					if ( $depth == 0 ){
						$class_names = $class_names ? ' class="menu__item ' . esc_attr( $class_names ) . ' dropdown-menu-03 mega-menu" ' : '';
					}else if ( $depth == 1 ){
						$class_names = $class_names ? ' class="menu__item ' . esc_attr( $class_names ) . ' pix-tab-item " ' : '';
					}else{
						$class_names ='';
					}
					$id      = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
					$tab_id  = 'menutab-id-'.$item->ID;
					$id      = $id ? ' id="' . esc_attr( $id ) . '"' : '';
					$output .= $indent . '<li' . $id . $class_names . '>';

					$atts = array();
					$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
					$atts['target'] = ! empty( $item->target ) ? $item->target : '';
					$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
					$atts['href']   = ! empty( $item->url ) ? $item->url : '';
					$atts['data-hashtag']   = ! empty( $this->hashtag ) ? $this->hashtag : '';

					if ( !empty($this->hashtag) ) {
						$atts['href'] .= '#'.$this->hashtag;
					}

					$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
					$attributes = '';
					foreach( $atts as $attr => $value ) {
						if( ! empty( $value ) ) {
							$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
							$attributes .= ' ' . $attr . '="' . $value . '"';
						}
					}
					$item_output = $args->before;
					
					if( $depth == 0 ) {
						$item_output .= '<a class="main-menu menu__link" '. $attributes . '>'.$html_icon.'';
					} 
					else if($depth == 1){
						$item_output .= '<a href="#'.$tab_id.'">'.$html_icon.'';
					}else{
						$item_output .= '<a class="link-page" ' . $attributes . '>'.$html_icon.'';
					}
					
					$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
					if ($depth != 1){
						$item_output .= '';
					}
					
					if( $args->walker->has_children  ){
						$item_output .= '<span class="arrow-down-ico"><i class="fa fa-angle-down" aria-hidden="true"></i></span>';
					}
					$item_output .= '</a>';
					
					if ($depth == 1){
						//add widget
						if( $this->menu_megamenu_widgetarea && is_active_sidebar( $this->menu_megamenu_widgetarea )) {
							$item_output .= '<div data-column="'. $this->megamenu_column.'" id="'.$tab_id.'" class="row tab-pane '.$this->menu_megamenu_widgetarea.'"><div class="tab-content-item">';
								ob_start();
								dynamic_sidebar( $this->menu_megamenu_widgetarea );
							$item_output .= ob_get_clean() . '</div></div>';
						}else{
							$item_output .= '<div data-column="'. $this->megamenu_column.'" id="'.$tab_id.'" class="tab-pane row"><div class="tab-content-item tab-widget-none"></div></div>';
						}
					}
					$item_output .= $args->after;
					
					$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

				}else{
					if ( $depth == 0 ){
					$class_names = $class_names ? ' class="menu__item ' . esc_attr( $class_names ) . ' mega-menu dropdown" ' : '';
					}else if ( $depth == 1 ){
						$class_names = $class_names ? ' class="menu__item ' . esc_attr( $class_names ) . ' mega-menu-title sub-menu " ' : '';
					}else{
						$class_names ='';
					}
				
					$id      = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
					$id      = $id ? ' id="' . esc_attr( $id ) . '"' : '';
					if ( $depth == 1 ){
						$output .= '<div class="mega-menu-column '.$this->megamenu_column.'"><ul class="mega-menu-column-box">';
					}
					$output .= $indent . '<li' . $id . $class_names . '>';

					$atts = array();
					$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
					$atts['target'] = ! empty( $item->target ) ? $item->target : '';
					$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
					$atts['href']   = ! empty( $item->url ) ? $item->url : '';
					$atts['data-hashtag']   = ! empty( $this->hashtag ) ? $this->hashtag : '';

					if ( !empty($this->hashtag) ) {
						$atts['href'] .= '#'.$this->hashtag;
					}

					$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
					$attributes = '';
					foreach( $atts as $attr => $value ) {
						if( ! empty( $value ) ) {
							$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
							$attributes .= ' ' . $attr . '="' . $value . '"';
						}
					}
					$item_output = $args->before;
					
					if( $depth == 0 ) {
						$item_output .= '<a class="main-menu menu__link" '. $attributes . '>'.$html_icon.'';
					} 
					else if($depth == 1){
						$item_output .= '<a href="javascript:void(0)" class="sf-with-ul">'.$html_icon.'';
					}else{
						$item_output .= '<a class="link-page menu__link" ' . $attributes . '>'.$html_icon.'';
					}

					
					$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
					if ($depth != 1){
						$item_output .= '';
					}
					
					if( $args->walker->has_children  ){
						$item_output .= '<span class="arrow-down-ico"><i class="fa fa-angle-down" aria-hidden="true"></i></span>';
					}
					$item_output .= '</a>';
					if( $depth == 0 ) {
					$item_output .= 
					'<div class="mega-menu-content clearfix">';
					} 
					if ($depth == 1){
						//add widget
						if( $this->menu_megamenu_widgetarea && is_active_sidebar( $this->menu_megamenu_widgetarea )) {
							$item_output .= '<div class="tab-pane '.$this->menu_megamenu_widgetarea.'">';
								ob_start();
								dynamic_sidebar( $this->menu_megamenu_widgetarea );
							$item_output .= ob_get_clean() . '</div>';
						}
					}
					$item_output .= $args->after;
					
					$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

					}
					
			}else {
				
				if( $args->walker->has_children ) {
					if ( $depth == 0 ){
						$class_names = $class_names ? ' class="menu__item ' . esc_attr( $class_names ) . ' has-sub-menu menu-item-depth1" ' : '';
					}else{
						$class_names = $class_names ? ' class="menu__item ' . esc_attr( $class_names ) . ' has-sub-menu " ' : '';
					}
				}else {
					$class_names = $class_names ? ' class="menu__item ' . esc_attr( $class_names ) . '" ' : '';
				}

				$id      = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
				$id      = $id ? ' id="' . esc_attr( $id ) . '"' : '';
				$output .= $indent . '<li' . $id . $class_names . '>';

				$atts = array();
				$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
				$atts['target'] = ! empty( $item->target ) ? $item->target : '';
				$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
				$atts['href']   = ! empty( $item->url ) ? $item->url : '';
				$atts['data-hashtag']   = ! empty( $this->hashtag ) ? $this->hashtag : '';

				if ( !empty($this->hashtag) ) {
					$atts['href'] .= '#'.$this->hashtag;
				}

				$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
				$attributes = '';
				foreach( $atts as $attr => $value ) {
					if( ! empty( $value ) ) {
						$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
						$attributes .= ' ' . $attr . '="' . $value . '"';
					}
				}
				
				$item_output = $args->before;
				if( $depth == 0 ) {
					$item_output .= '<a class="main-menu menu__link" '. $attributes . '>';
				}else if( $args->walker->has_children && $depth != 0 ){
					$item_output .= '<a class="link-page dropdown-parent menu__link" ' . $attributes . '>';
				}
				else{
					$item_output .= '<a class="link-page menu__link" ' . $attributes . '>';
				}
				
				$item_output .= $html_icon;
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				if( $args->walker->has_children  ){
					$item_output .= '<span class="arrow-down-ico"><i class="fa fa-angle-down" aria-hidden="true"></i></span>';
				}
				$item_output .= '</a>';
				$item_output .= $args->after;
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
		}
		public function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			if ($this->mega_active == "active"){
				if($this->mega_style == 1){
					$output .= "</li>\n";
				}else{
					if( $depth == 0 ) {
						$output .= "</div></li>\n";
					}else if( $depth == 1 ){
						$output .= "</li></ul></div>\n";
					}else{
						$output .= "</li>\n";
					}
				}
			}else{
				if ( $depth == 0 ) {
					$output .= "</li>\n";
				} else {
					$output .= "</li>\n";
				}
			}
		}
	}