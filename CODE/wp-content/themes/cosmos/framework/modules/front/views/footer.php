<?php
$footer_stt = '1';
$footer_stt = Cosmos::get_option('pix-footer-show');

// footer main
$footer_main_stt    = Cosmos::get_option('pix-footer-main-show');
$footer_main_text    = Cosmos::get_option('pix-footer-main-text');
$footer_main_images    = Cosmos::get_option('pix-footer-main-gallery');
// foter bottom
$footer_bottom_stt       	= Cosmos::get_option('pix-footer-bottom-show');
$footerbt_content_col1  = Cosmos::get_option('pix-footerbt-col1');
$footerbt_content_col2  = Cosmos::get_option('pix-footerbt-col2');
$social_facebook = Cosmos::get_option('pix-social-facebook');
$social_twitter = Cosmos::get_option('pix-social-twitter');
$social_google = Cosmos::get_option('pix-social-google-plus');
$social_pinterest = Cosmos::get_option('pix-social-pinterest');
$social_instagram = Cosmos::get_option('pix-social-instagram');
$social_dribbble = Cosmos::get_option('pix-social-dribbble');

$menu_location = 'footer-nav';
$footerbt_nav = '';
if( has_nav_menu( $menu_location ) ) {
	$walker = new Cosmos_Nav_Walker;
	$footerbt_nav = wp_nav_menu( array(
		'theme_location'	=> $menu_location,
		'container'			=> 'ul',
		'menu_class'		=> 'nav-links nav navbar-nav',
		'echo'				=> '0',
		'walker'			=> $walker
	));
}
?>
<?php 
if ( $footer_stt == '1' ) { ?>

<div class="row-builder section_footer style-3">
<?php
	if ( $footer_main_stt == '1' ) {?>
	<div class="footer-main">
		<div class="container">
			<?php
			$footer_main_logo = Cosmos::get_option('pix-footer-main-logo');
			$footer_logo = Cosmos::get_option('pix-logo-footer', 'url');
			if( $footer_main_logo == 1 && !empty($footer_logo )){
				echo '<div class="logo"><a class="logo" href="'.esc_url(home_url('/')).'"><img src="'.esc_url($footer_logo).'" alt="" class="img-responsive" data-type="image"/></a></div>';
			} ?>

			<?php 
			if ( !empty($footer_main_text) ) { ?>
		    <div class="footer-content">
		        <span data-type="content"><?php echo wp_kses_post( $footer_main_text ); ?></span>
		    </div>
			<?php } ?>

			<?php 
			if ( !empty($footer_main_images) ) { 
				$images_id = str_replace(',,', ',', $footer_main_images);
				$images_id = str_replace(',,', ',', $images_id);
				$images_arr = explode(',', $images_id);
				$images_arr = array_filter($images_arr);
				if ( is_array($images_arr) ) {
			?>
		    <div class="footer-app">
		    	<?php 
		    	foreach ($images_arr as $key => $value) {
		    		echo wp_get_attachment_image($value, 'full');
		    	} ?>
		    </div>
			<?php } } ?>

		</div>
		<div class="clearfix"></div>
    </div>
	<?php }

	if ( $footer_bottom_stt == '1' ) { ?>
	<div class="footer-page footer-bottom">
		<div class="container-fluid">
	        <div class="container">
		        <div class="row">
		       		<div class="col-md-6 footerbt-col col-left">
		       			<?php if(!empty($footerbt_content_col1['enabled'])){
		   					foreach ($footerbt_content_col1['enabled'] as $k => $v) {
		   						switch ($k) {
									case 'text':
										$copyright =  nl2br(Cosmos::get_option('pix-footerbt1-text'));
										echo '<div class="text-item">';
							            echo wp_kses_post($copyright);
							            echo '</div>';
										break;
									case 'menu':
										echo '<nav class="footerbt-item footer-nav collapse navbar-collapse">';
							            echo wp_kses_post($footerbt_nav);
							            echo '</nav>';
										break;
									case 'social':
										echo '<div class="social-group">';
										if ( !empty($social_facebook) ) {
											printf( '<a href="%s" class="social-item" target="_blank"><i class="fa fa-facebook social-icon" aria-hidden="true"></i></a>', esc_url($social_facebook) );
										}
										if ( !empty($social_twitter) ) {
											printf( '<a href="%s" class="social-item" target="_blank"><i class="fa fa-twitter social-icon" aria-hidden="true"></i></a>', esc_url($social_twitter) );
										}
										if ( !empty($social_google) ) {
											printf( '<a href="%s" class="social-item" target="_blank"><i class="fa fa-google-plus social-icon" aria-hidden="true"></i></a>', esc_url($social_google) );
										}
										if ( !empty($social_pinterest) ) {
											printf( '<a href="%s" class="social-item" target="_blank"><i class="fa fa-pinterest social-icon" aria-hidden="true"></i></a>', esc_url($social_pinterest) );
										}
										if ( !empty($social_instagram) ) {
											printf( '<a href="%s" class="social-item" target="_blank"><i class="fa fa-instagram social-icon" aria-hidden="true"></i></a>', esc_url($social_instagram) );
										}
										if ( !empty($social_dribbble) ) {
											printf( '<a href="%s" class="social-item" target="_blank"><i class="fa fa-dribbble social-icon" aria-hidden="true"></i></a>', esc_url($social_dribbble) );
										}
							            echo '</div>';
										break;
									default:
										break;
								}
		   					}
		       			}
		       		?>
		       		</div>
		       		<div class="col-md-6 footerbt-col col-right">
		       			<?php if(!empty($footerbt_content_col2['enabled'])){
		   					foreach ($footerbt_content_col2['enabled'] as $k => $v) {
		   						switch ($k) {
									case 'text':
										$copyright =  nl2br(Cosmos::get_option('pix-footerbt2-text'));
										echo '<div class="text-item text-right">';
							            echo wp_kses_post($copyright);
							            echo '</div>';
										break;
									case 'menu':
										echo '<nav class="footerbt-item footer-nav collapse navbar-collapse">';
							            echo wp_kses_post($footerbt_nav);
							            echo '</nav>';
										break;
									case 'social':
										echo '<div class="social-group">';
										if ( !empty($social_facebook) ) {
											printf( '<a href="%s" class="social-item" target="_blank"><i class="fa fa-facebook social-icon" aria-hidden="true"></i></a>', esc_url($social_facebook) );
										}
										if ( !empty($social_twitter) ) {
											printf( '<a href="%s" class="social-item" target="_blank"><i class="fa fa-twitter social-icon" aria-hidden="true"></i></a>', esc_url($social_twitter) );
										}
										if ( !empty($social_google) ) {
											printf( '<a href="%s" class="social-item" target="_blank"><i class="fa fa-google-plus social-icon" aria-hidden="true"></i></a>', esc_url($social_google) );
										}
										if ( !empty($social_pinterest) ) {
											printf( '<a href="%s" class="social-item" target="_blank"><i class="fa fa-pinterest social-icon" aria-hidden="true"></i></a>', esc_url($social_pinterest) );
										}
										if ( !empty($social_instagram) ) {
											printf( '<a href="%s" class="social-item" target="_blank"><i class="fa fa-instagram social-icon" aria-hidden="true"></i></a>', esc_url($social_instagram) );
										}
										if ( !empty($social_dribbble) ) {
											printf( '<a href="%s" class="social-item" target="_blank"><i class="fa fa-dribbble social-icon" aria-hidden="true"></i></a>', esc_url($social_dribbble) );
										}
							            echo '</div>';
										break;
									default:
										break;
								}
		   					}
		       			}?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php 
	} 
?>
</div>
<?php
} ?>