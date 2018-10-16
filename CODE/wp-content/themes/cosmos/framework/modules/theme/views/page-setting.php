 <?php
	// Slider Revolution
	global $wpdb;
	$revolution_sliders = array( '' => esc_html('No Slider', 'cosmos') );
	if( COSMOS_REVSLIDER_ACTIVE ) {
		$db_revslider = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'revslider_sliders %', '')  );
		if ( $db_revslider ) {
			foreach ( $db_revslider as $slider ) {
				$revolution_sliders[$slider->alias] = $slider->title;
			}
		}
	}

	// post
	$image_uri = get_template_directory_uri() . '/assets/admin/images/';
	$img_options = array( 'class' => 'pix-block-9' );
	$header_layout = Cosmos_Params::get( 'header_layout');
	$header_layout = $this->radio_image_label( $header_layout, $image_uri, $img_options );
	$menu_style_param = Cosmos_Params::get( 'menu_style');
	$menu_style = $this->radio_image_label( $menu_style_param, $image_uri, array( 'class' => 'pix-block-5' ) );
	$theme_skin_color_param = Cosmos_Params::get( 'theme_skin_color');
	$theme_skin_color = $this->radio_image_label( $theme_skin_color_param, $image_uri, array( 'class' => 'pix-block-4' ) );
	$html_options = array(
		'separator'    => '',
		'class'        => 'pix-w190 hide',
		'labelOptions' => array(
			'class'          => ' pix-image-select ',
			'selected_class' => ' pix-image-select-selected ',
		)
	);
	//sidebar
	$sidebar_layout = 'sidebar_layout';
	$sidebar_layout_id = 'sidebar_id';
	$screen = get_current_screen();
	$sidebar_screen = array(
		'post' => 'sidebar_post_layout',
	);
	$pt_bg_image_show = true;
	$pt_bg_prefix = 'pt_';
	$is_page = false;
	if( $screen ) {
		$screen_type = $screen->post_type;
		switch( $screen_type ) {
			case 'page':
				$is_page = true;
				break;
			case 'post':
				$sidebar_layout = 'sidebar_post_layout';
				$sidebar_layout_id = 'sidebar_post_id';
				break;
		}
	}
	$footer_style = $this->get_field( $page_options, 'footer_style', $defaults );
	if( empty($footer_style)) {
		$footer_style = 'dark';
	}
?>
<div class="tab-panel pix-tab-mbox">
	<ul class="tab-list">
		<li class="pix-tab active pix-tab-general">
			<a href="pix-tab-page-general"><?php esc_html_e( 'General', 'cosmos' );?></a>
		</li>
		<li class="pix-tab">
			<a href="pix-tab-page-header"><?php esc_html_e( 'Header', 'cosmos' );?></a>
		</li>
		<li class="pix-tab">
			<a href="pix-tab-page-menu"><?php esc_html_e( 'Menu', 'cosmos' );?></a>
		</li>
		<li class="pix-tab">
			<a href="pix-tab-page-pagetitle"><?php esc_html_e( 'Page Title', 'cosmos' );?></a>
		</li>
		<li class="pix-tab">
			<a href="pix-tab-page-sidebar"><?php esc_html_e( 'Sidebar', 'cosmos' );?></a>
		</li>
		<li class="pix-tab">
			<a href="pix-tab-page-footer"><?php esc_html_e( 'Footer', 'cosmos' );?></a>
		</li>
	</ul>
	<div class="tab-container">
		<div class="tab-wrapper pix-page-meta">

			<!-- General -->
			<div id="pix-tab-page-general" class="tab-content active pix-tab-general">
				<table class="form-table">
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Choose Slider', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( wp_kses(esc_html__( 'Display or not slider in the page.<br/> Default no display slider in the page. To add new slider, please go to .', 'cosmos' ), array('br') ) .'<a href="'.esc_url( admin_url( 'revslider.php' ) ).'" >Slider Revolutions</a>' );?></span>
						</th>
						<td>
							<?php echo ( $this->drop_down_list( 'cosmos_page_options[revolution_slider]',
																	$this->get_field( $page_options, 'revolution_slider', $defaults ),
																	$revolution_sliders,
																	array( 'class' => 'pix-w190' ) ) );?>
							
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Body Extra Class', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Add custom class if you want to change style of your site.', 'cosmos' ) );?></span>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options[body_extra_class]',
																$this->get_field( $page_options, 'body_extra_class' ),
																array() ) );?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Enter content top/bottom padding (px)', 'cosmos' ) );?></span>
							<label><?php wp_kses(_e( 'Content Padding <br/> (Top/Bottom)', 'cosmos' ), array('br' => array()));?></label>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options[ct_padding_top]',
																$this->get_field( $page_options, 'ct_padding_top' ),
																array( 'class' => '' ) ) );?>
							<?php echo ( $this->text_field( 'cosmos_page_options[ct_padding_bottom]',
																$this->get_field( $page_options, 'ct_padding_bottom' ),
																array( 'class' => '' ) ) );?>
						</td>
					</tr>
					<!-- Default -->
					<tr>
						<th scope="row">
							<label><?php echo ( $this->check_box( 'cosmos_page_options[general_default]',
																	$this->get_field( $page_options, 'general_default', 1 ),
																	array( 'class' => 'pix-general-option' ) ) );
									esc_html_e( 'Default Setting', 'cosmos' )?></label>
							<span class="f-right"><?php $this->tooltip_html(esc_html__( 'Using setting of theme options. All below setting will NOT be allowed. Uncheck to change setting this page.', 'cosmos' ) );?></span>
						</th>
						<td></td>
					</tr>
				</table>
				<table id="div_pix_general_option" class="form-table <?php echo ( $this->get_field( $page_options, 'general_default', 1 )? 'hide' : '' ); ?>">
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Theme Skin Color', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Choose skin color to page.', 'cosmos' ) );?></span>
						</th>
						<td class="pix-mbox-radio-row">
							<?php echo ( $this->radio_button_list( 'cosmos_page_options[theme_skin_color]',
																		$this->get_field( $page_options, 'theme_skin_color', $defaults ),
																		$theme_skin_color,
																		$html_options ) );?>
							
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Body Background', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html(esc_html__( 'Setting background in the page.', 'cosmos' ) .'<br/>background-color <br/>background-repeat, background-size <br/>background-attachment, background-position <br/>background-image' );?></span>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options[background_color]',
																$this->get_field( $page_options, 'background_color', $defaults ),
																array('class' => 'pixcore-meta-color') ) );?>
							<span class="valign-top">
								<?php echo (  $this->check_box( 'cosmos_page_options[background_transparent]',
																	$this->get_field( $page_options, 'background_transparent', $defaults ),
																	array( 'id'=>'background_transparent_id' ,'value' => 'transparent') ) );
									esc_html_e( 'Transparent', 'cosmos' );?>
							</span>
							<br/>
							<div><?php echo ( $this->drop_down_list( 'cosmos_page_options[background_repeat]',
																		$this->get_field( $page_options, 'background_repeat', $defaults ),
																		$params['background-repeat'],
																		array( 'class' => 'pix-w200' ) ) );?>
								<?php echo ( $this->drop_down_list( 'cosmos_page_options[background_size]',
																		$this->get_field( $page_options, 'background_size', $defaults ),
																		$params['background-size'],
																		array( 'class' => 'pix-w200' ) ) );?>
								
							</div>
							<br/>
							<div>
								<?php echo ( $this->drop_down_list( 'cosmos_page_options[background_attachment]',
																		$this->get_field( $page_options, 'background_attachment', $defaults ),
																		$params['background-attachment'],
																		array( 'class' => 'pix-w200' ) ) );?>
								<?php echo ( $this->drop_down_list( 'cosmos_page_options[background_position]',
																		$this->get_field( $page_options, 'background_position', $defaults ),
																		$params['background-position'],
																		array( 'class' => 'pix-w200' ) ) ); ?>
								
							</div>
							<br/>
							<div class="bg-image">
								<?php echo ( $this->text_field( 'cosmos_page_options[background_image]',
																	esc_attr( $params['bg_image']['url'] ),
																	array( 'id' => 'pix_bg_image_name', 'readonly'=>'readonly', 'class' => 'pix-block' ) ) );?>
								<input type="hidden" name="cosmos_page_options[background_image_id]" id="pix_bg_image_id" value="<?php echo esc_attr( $params['bg_image']['id'] ); ?>" />
								<div class="screenshot <?php echo esc_attr( $params['bg_image']['class'] );?>" >
									<img src="<?php echo esc_url( $params['bg_image']['url'] ); ?>" />
								</div>
								<br/>
								<input type="button" data-rel="pix_bg_image" class="button pix-btn-upload" value="<?php esc_html_e( 'Upload Image', 'cosmos' )?>" />
								<input type="button" data-rel="pix_bg_image" class="button pix-btn-remove <?php echo esc_attr( $params['bg_image']['class'] );?>" value="<?php esc_html_e( 'Remove', 'cosmos' )?>" />
							</div>

						</td>
					</tr>
				</table>
			</div>

			<!-- Header -->
			<div id="pix-tab-page-header" class="tab-content">
				<table class="form-table">
					<tr>
						<th scope="row">
							<label><?php echo ( $this->check_box( 'cosmos_page_options[header_default]',
																	$this->get_field( $page_options, 'header_default', 1 ),
																	array( 'class' => 'pix-header-option' ) ) );
									esc_html_e( 'Default Setting', 'cosmos' )?></label>
							<span class="f-right"><?php $this->tooltip_html(esc_html__( 'Using setting of theme options. All below setting will NOT be allowed. Uncheck to change setting this page.', 'cosmos' ) );?></span>
						</th>
						<td></td>
					</tr>
				</table>
				<table id="div_pix_header_option" class="form-table <?php echo ($this->get_field( $page_options, 'header_default', 1 )? 'hide' : '');?>">
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Show Header', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Show/Hide header.', 'cosmos' ) );?></span>
						</th>
						<td>
							<label><?php echo ( $this->check_box( 'cosmos_page_options[header_show]',
																	$this->get_field( $page_options, 'header_show', 1 ),
																	array( 'class' => '' ) ) );
									esc_html_e( 'Show', 'cosmos' )?></label>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Header Sticky', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Enable/Disable fixed header', 'cosmos' ) );?></span>
						</th>
						<td>
							<label><?php echo ( $this->check_box( 'cosmos_page_options[header_sticky_enable]',
																	$this->get_field( $page_options, 'header_sticky_enable', 0 ),
																	array( 'class' => '' ) ) );
									esc_html_e( 'Enable', 'cosmos' )?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Header Full', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Enable/Disable full header when scroll', 'cosmos' ) );?></span>
						</th>
						<td>
							<label><?php echo ( $this->check_box( 'cosmos_page_options[header_full_1920]',
																	$this->get_field( $page_options, 'header_full_1920', 0 ),
																	array( 'class' => '' ) ) );
									esc_html_e( 'Enable', 'cosmos' )?></label>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Show Icon In Menu Item', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Show/Hide icon menu item', 'cosmos' ) );?></span>
						</th>
						<td>
							<label><?php echo ( $this->check_box( 'cosmos_page_options[header_menu_icon_item]',
																	$this->get_field( $page_options, 'header_menu_icon_item', 0 ),
																	array( 'class' => '' ) ) );
									esc_html_e( 'Show ?', 'cosmos' )?></label>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Header Background Color', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Set background color in header.', 'cosmos' ) );?></span>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options[header_bg_color]',
																$this->get_field( $page_options, 'header_bg_color' ),
																array('class' => 'pixcore-meta-color', 'data-alpha' => 'true' ) ) );?>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Header Background Color Scroll', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Set background color in header when scroll.', 'cosmos' ) );?></span>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options[header_bg_color_scroll]',
																$this->get_field( $page_options, 'header_bg_color_scroll' ),
																array('class' => 'pixcore-meta-color', 'data-alpha' => 'true') ) );?>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Header Logo', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Choose logo for header.', 'cosmos' ) );?></span>
						</th>
						<td colspan="2" class="second">
							<?php echo ( $this->single_image( 'cosmos_page_options[header_logo]',
																$this->get_field( $page_options, 'header_logo', $defaults ),
																array( 'id'=> 'header_logo_name',
																	'data-rel' => 'header_logo' ) ) );?>
						</td>
					</tr>

				</table>
			</div>

			<!-- Menu -->
			<div id="pix-tab-page-menu" class="tab-content">
				<table class="form-table">
					<tr>
						<th scope="row">
							<label><?php echo ( $this->check_box( 'cosmos_page_options[menu_default]',
																	$this->get_field( $page_options, 'menu_default', 1 ),
																	array( 'class' => 'pix-menu-option' ) ) );
									esc_html_e( 'Default Setting', 'cosmos' )?></label>
							<span class="f-right"><?php $this->tooltip_html(esc_html__( 'Using setting of theme options. All below setting will NOT be allowed. Uncheck to change setting this page.', 'cosmos' ) );?></span>
						</th>
						<td></td>
					</tr>
				</table>
				<table id="div_pix_menu_option" class="form-table <?php echo ($this->get_field( $page_options, 'menu_default', 1 )? 'hide' : '');?>">
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Menu Style', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Choose menu style to display in the page.', 'cosmos' ) );?></span>
						</th>
						<td class="pix-mbox-radio-row">
							<?php echo ( $this->radio_button_list( 'cosmos_page_options[menu_style]',
																		$this->get_field( $page_options, 'menu_style', $defaults ),
																		$menu_style,
																		$html_options ) );?>
							
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Menu Main Text Color', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Set text item in main menu.', 'cosmos' ) );?></span>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options[menu_text_color_regular]',
																$this->get_field( $page_options, 'menu_text_color_regular', $defaults ),
																array('class' => 'pixcore-meta-color') ) );?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Menu Main Text Hover Color', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Set text item in main menu.', 'cosmos' ) );?></span>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options[menu_text_color_hover]',
																$this->get_field( $page_options, 'menu_text_color_hover', $defaults ),
																array('class' => 'pixcore-meta-color') ) );?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Menu Main Text Active Color', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Set text item in main menu.', 'cosmos' ) );?></span>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options[menu_text_color_active]',
																$this->get_field( $page_options, 'menu_text_color_active', $defaults ),
																array('class' => 'pixcore-meta-color') ) );?>
						</td>
					</tr>
				</table>
			</div>

			<!-- Page Title -->
			<div id="pix-tab-page-pagetitle" class="tab-content">
				<table class="form-table">
					<tr>
						<th scope="row">
							<label><?php echo ( $this->check_box( 'cosmos_page_options[page_title_default]',
																	$this->get_field( $page_options, 'page_title_default', 1 ),
																	array( 'class' => 'pix-page-title-option' ) ) );
									esc_html_e( 'Default Setting', 'cosmos' )?></label>
							<span class="f-right"><?php $this->tooltip_html(esc_html__( 'Using setting of theme options. All below setting will NOT be allowed. Uncheck to change setting this page.', 'cosmos' ) );?></span>
						</th>
						<td></td>
					</tr>
				</table>
				<table id="div_pix_page_title_option" class="form-table <?php echo ($this->get_field( $page_options, 'page_title_default', 1 )? 'hide' : '');?>">
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Show Page Title', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Show/Hide page title in the page', 'cosmos' ) );?></span>
						</th>
						<td>
							<label><?php echo ( $this->check_box( 'cosmos_page_options[page_title_show]',
																	$this->get_field( $page_options, 'page_title_show', 1 ),
																	array( 'class' => '' ) ) );
									esc_html_e( 'Show', 'cosmos' )?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Align Page Title', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Choose alignment for page title', 'cosmos' ) );?></span>
						</th>
						<td>
							<?php echo ( $this->drop_down_list( 'cosmos_page_options[page_title_align]',
																	$this->get_field( $page_options, 'page_title_align' ),
																	array(
																		'' => esc_html__( '--Default--', 'cosmos' ),
																		'left' => esc_html__( 'Left', 'cosmos' ),
																		'right' => esc_html__( 'Right', 'cosmos' ),
																		'center' => esc_html__( 'Center', 'cosmos' )
																	),
																	array( 'class' => 'pix-page-title-align' ) ) );?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Heading Page Title', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Choose heading for page title', 'cosmos' ) );?></span>
						</th>
						<td>
							<?php echo ( $this->drop_down_list( 'cosmos_page_options[page_title_heading]',
																	$this->get_field( $page_options, 'page_title_heading' ),
																	array(
																		'' => esc_html__( '--Default--', 'cosmos' ),
																		'1' => esc_html__( 'H1', 'cosmos' ),
																		'2' => esc_html__( 'H2', 'cosmos' ),
																		'3' => esc_html__( 'H3', 'cosmos' ),
																		'4' => esc_html__( 'H4', 'cosmos' ),
																		'5' => esc_html__( 'H5', 'cosmos' ),
																		'6' => esc_html__( 'H6', 'cosmos' ),
																	),
																	array( 'class' => 'pix-page-title-heading' ) ) );?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Background Style', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html(esc_html__( 'Setting background of page title in the page.', 'cosmos' ) .'<br/>background-color <br/>background-repeat, background-size <br/>background-attachment, background-position <br/>background-image' );?></span>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options['.$pt_bg_prefix.'background_color]',
																$this->get_field( $page_options, $pt_bg_prefix.'background_color', $defaults ),
																array('class' => 'pixcore-meta-color') ) );?>
							<span class="valign-top">
								<?php echo ( $this->check_box( 'cosmos_page_options['.$pt_bg_prefix.'background_transparent]',
																	$this->get_field( $page_options, $pt_bg_prefix.'background_transparent', $defaults ),
																	array( 'class' => '', 'value' => 'transparent' ) ) );
									esc_html_e( 'Transparent', 'cosmos' )?>
							</span>
							<br/>
							<div><?php echo ( $this->drop_down_list( 'cosmos_page_options['.$pt_bg_prefix.'background_repeat]',
																		$this->get_field( $page_options, $pt_bg_prefix.'background_repeat', $defaults ),
																		$params['background-repeat'],
																		array( 'class' => 'pix-w200' ) ) );?>
								<?php echo ( $this->drop_down_list( 'cosmos_page_options['.$pt_bg_prefix.'background_size]',
																		$this->get_field( $page_options, $pt_bg_prefix.'background_size', $defaults ),
																		$params['background-size'],
																		array( 'class' => 'pix-w200' ) ) );?>
								
							</div>
							<br/>
							<div>
								<?php echo ( $this->drop_down_list( 'cosmos_page_options['.$pt_bg_prefix.'background_attachment]',
																		$this->get_field( $page_options, $pt_bg_prefix.'background_attachment', $defaults ),
																		$params['background-attachment'],
																		array( 'class' => 'pix-w200' ) ) );?>
								<?php echo ( $this->drop_down_list( 'cosmos_page_options['.$pt_bg_prefix.'background_position]',
																		$this->get_field( $page_options, $pt_bg_prefix.'background_position', $defaults ),
																		$params['background-position'],
																		array( 'class' => 'pix-w200' ) ) ); ?>
							</div>
							<br/>
							<?php if( $pt_bg_image_show ) :?>
							<div class="bg-image">
								<?php echo ( $this->text_field( 'cosmos_page_options[pt_background_image]',
																	esc_attr( $params['pt_bg_image']['url'] ),
																	array( 'id' => 'pix_pt_bg_image_name', 'readonly'=>'readonly', 'class' => 'pix-block' ) ) );?>
								<input type="hidden" name="cosmos_page_options[pt_background_image_id]" id="pix_pt_bg_image_id" value="<?php echo esc_attr( $params['pt_bg_image']['id'] ); ?>" />
								<div class="screenshot <?php echo esc_attr( $params['pt_bg_image']['class'] );?>" >
									<img src="<?php echo esc_url( $params['pt_bg_image']['url'] ); ?>" />
								</div>
								<br/>
								<input type="button" data-rel="pix_pt_bg_image" class="button pix-btn-upload" value="<?php esc_html_e( 'Upload Image', 'cosmos' )?>" />
								<input type="button" data-rel="pix_pt_bg_image" class="button pix-btn-remove <?php echo esc_attr( $params['pt_bg_image']['class'] );?>" value="<?php esc_html_e( 'Remove', 'cosmos' )?>" />
							</div>
							<?php endif;?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Insert page title height (px)', 'cosmos' ) );?></span>
							<label><?php esc_html_e( 'Height', 'cosmos' );?></label>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options[pt_height]',
																$this->get_field( $page_options, 'pt_height', $defaults ),
																array( 'class' => '' ) ) );?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Show Title', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Show/Hide title in page title', 'cosmos' ) );?></span>
						</th>
						<td>
							<label><?php echo ( $this->check_box( 'cosmos_page_options[title_show]',
																	$this->get_field( $page_options, 'title_show', 1 ),
																	array( 'class' => '' ) ) );
									esc_html_e( 'Show', 'cosmos' )?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Type Page Title', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Choose type default Page Title will be display. Choose "Post Title" to show post title if it at page have post title. Choose "Level Title" to show label of the level  if it at page of archive, taxonomy or page has hierarchical', 'cosmos' ) );?></span>
						</th>
						<td>
							<?php echo ( $this->drop_down_list( 'cosmos_page_options[page_title_type_display]',
																	$this->get_field( $page_options, 'page_title_type_display' ),
																	array(
																		'' => esc_html__( '-None-', 'cosmos' ),
																		'post' => esc_html__( 'Post Title', 'cosmos' ),
																		'level' => esc_html__( 'Level Title', 'cosmos' )
																	),
																	array( 'class' => 'pix-page-title-type-display' ) ) );?>
						</td>
					</tr>

					<tr id="div_page_title_type_display" >
						<th scope="row">
							<label><?php esc_html_e( 'Custom Title', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Enter custom title to display in page title.', 'cosmos' ) );?></span>
							<p class="description" ></p>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options[title_custom_content]',
																$this->get_field( $page_options, 'title_custom_content' ),
																array('class' => 'pix-block title_custom_content') ) );?>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Title Color', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Set title color in page title.', 'cosmos' ) );?></span>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options[title_color]',
																$this->get_field( $page_options, 'title_color' ),
																array('class' => 'pixcore-meta-color') ) );?>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Show Breadcrumb', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Show/Hide breadcrumb', 'cosmos' ) );?></span>
						</th>
						<td>
							<label><?php echo ( $this->check_box( 'cosmos_page_options[breadcrumb_show]',
																	$this->get_field( $page_options, 'breadcrumb_show', 1 ),
																	array( 'class' => '' ) ) );
									esc_html_e( 'Show', 'cosmos' )?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Breadcrumb Icon Next Color', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Set color to breadcrumb icon next in the page.', 'cosmos' ) );?></span>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options[breadcrumb_icon_color]',
																$this->get_field( $page_options, 'breadcrumb_icon_color' ),
																array('class' => 'pixcore-meta-color') ) );?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Breadcrumb Path Color', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Set color to breadcrumb path in the page.', 'cosmos' ) );?></span>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options[breadcrumb_color]',
																$this->get_field( $page_options, 'breadcrumb_color' ),
																array('class' => 'pixcore-meta-color') ) );?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Breadcrumb Text Color', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Set color to breadcrumb Text Active in the page.', 'cosmos' ) );?></span>
						</th>
						<td>
							<?php echo ( $this->text_field( 'cosmos_page_options[breadcrumb_text_color]',
																$this->get_field( $page_options, 'breadcrumb_text_color' ),
																array('class' => 'pixcore-meta-color') ) );?>
						</td>
					</tr>
				</table>
			</div>
			<!-- Sidebar -->
			<div id="pix-tab-page-sidebar" class="tab-content">
				<table class="form-table">
					<tr>
						<th scope="row">
							<label><?php echo ( $this->check_box( 'cosmos_page_options[sidebar_default]',
																	$this->get_field( $page_options, 'sidebar_default', 1 ),
																	array( 'class' => 'pix-sidebar-option' ) ) );
									esc_html_e( 'Default Setting', 'cosmos' )?></label>
							<span class="f-right"><?php $this->tooltip_html(esc_html__( 'Using setting of theme options. All below setting will NOT be allowed. Uncheck to change setting this page.', 'cosmos' ) );?></span>
						</th>
						<td></td>
					</tr>
				</table>
				<table id="div_pix_sidebar_option" class="form-table <?php echo ($this->get_field( $page_options, 'sidebar_default', 1 )? 'hide' : '');?>">
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Sidebar Layout', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Choose locate to display sidebar in the page.', 'cosmos' ) );?></span>
						</th>
						<td>
							<?php echo ( $this->drop_down_list( 'cosmos_page_options['.$sidebar_layout.']',
																	$this->get_field( $page_options, $sidebar_layout, $defaults ),
																	$params['sidebar_layout'],
																	array( 'class' => 'pix-w200' ) ) );?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Sidebar Name', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Choose sidebar to display in the page. To add new sidebar, please go to ', 'cosmos' ) .'<a href="'.esc_url( admin_url( 'widgets.php' ) ).'" >Appearance>Widgets</a>' );?></span>
						</th>
						<td>
							<?php echo ( $this->drop_down_list( 'cosmos_page_options['.$sidebar_layout_id.']',
																	$this->get_field( $page_options, $sidebar_layout_id, $defaults ),
																	$params['regist_sidebars'],
																	array( 'class' => 'pix-w200', 'prompt' => 'Default sidebar') ) );?>
						</td>
					</tr>
				</table>
			</div>
			<!-- Footer -->
			<div id="pix-tab-page-footer" class="tab-content">
				<table class="form-table">
					<tr>
						<th scope="row">
							
							<label><?php echo ( $this->check_box( 'cosmos_page_options[footer_default]',
																	$this->get_field( $page_options, 'footer_default', 1 ),
																	array( 'class' => 'pix-footer-option' ) ) );
									esc_html_e( 'Default Setting', 'cosmos' )?></label>
							<span class="f-right"><?php $this->tooltip_html(esc_html__( 'Using setting of theme options. All below setting will NOT be allowed. Uncheck to change setting this page.', 'cosmos' ) );?></span>
						</th>
						<td></td>
					</tr>
				</table>
				<table id="div_pix_footer_option" class="form-table <?php echo ($this->get_field( $page_options, 'footer_default', 1 )? 'hide' : '');?>">
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Footer Logo', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Choose logo for footer.', 'cosmos' ) );?></span>
						</th>
						<td colspan="2" class="second">
							<?php echo ( $this->single_image( 'cosmos_page_options[footer_logo]',
																$this->get_field( $page_options, 'footer_logo', $defaults ),
																array( 'id'=> 'footer_logo_name',
																	'data-rel' => 'footer_logo' ) ) );?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Footer Section', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Show/Hide footer', 'cosmos' ) );?></span>
						</th>
						<td>
							<label><?php echo ( $this->check_box( 'cosmos_page_options[footer_show]',
																	$this->get_field( $page_options, 'footer_show', $defaults ),
																	array( 'class' => '' ) ) );
									esc_html_e( 'Show', 'cosmos' )?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Footer Main', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Show/Hide footer main', 'cosmos' ) );?></span>
						</th>
						<td>
							<label><?php echo ( $this->check_box( 'cosmos_page_options[footer_main_show]',
																	$this->get_field( $page_options, 'footer_main_show', 1 ),
																	array( 'class' => '' ) ) );
									esc_html_e( 'Show', 'cosmos' )?></label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label><?php esc_html_e( 'Footer Bottom', 'cosmos' );?></label>
							<span class="f-right"><?php $this->tooltip_html( esc_html__( 'Show/Hide footer bottom', 'cosmos' ) );?></span>
						</th>
						<td>
							<label><?php echo ( $this->check_box( 'cosmos_page_options[footer_bottom_show]',
																	$this->get_field( $page_options, 'footer_bottom_show', 1 ),
																	array( 'class' => '' ) ) );
									esc_html_e( 'Show', 'cosmos' )?></label>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>