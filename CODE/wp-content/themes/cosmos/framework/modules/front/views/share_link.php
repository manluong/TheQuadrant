<?php
if( ! COSMOS_CORE_IS_ACTIVE ) return;
$display_social = Cosmos::get_option('pix-post-social-share', 'enabled');
$post_type = get_post_type();
$share_format ='<a class="social-icon fa fa-%3$s" href="%1$s" onclick="%2$s; return false;"></a>';
if( isset($display_social[$post_type]) ) {
	$cls_share = new Cosmos_Core_Social_Share;
	$share_url = $cls_share->get_share_link();
	$action = 'window.open(this.href, \'Share Window\',\'left=50,top=50,width=600,height=350,toolbar=0\');';
	$social_enable  = Cosmos::get_option('pix-social-share', 'enabled');
	$share_link = '';
	if( $social_enable) {
		foreach ($social_enable as $key => $value) {
			if ( isset($share_url[$key])){
				$share_link[] = sprintf($share_format, esc_url($share_url[$key]), $action, $key);
			}
		}
	}
	if( $share_link ):
?>
		<div class="social-widget widget style-1 social-share-blog pull-left">
			<div class="content-widget">			
				<ul class="list-unstyled list-inline">
					<li class="text"><?php esc_html_e( 'Share:', 'cosmos' );?></li>
					<li><?php echo implode('</li><li>', $share_link)?></li>
				</ul>
			</div>
		</div>
<?php
	endif;// has share links
}


