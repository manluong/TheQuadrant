<?php 
if (COSMOS_NEWSLETTER_ACTIVE) {
	$text  = Cosmos::get_option('pix-footer-subcribe-text');
	$btn_text  = Cosmos::get_option('pix-footer-subcribe-btn');
	$form = '';
	global $newsletter;
	$form = NewsletterSubscription::instance()->get_form_javascript();

	$form .= '<form action="' . home_url('/') . '?na=s" onsubmit="return newsletter_check(this)" method="post">';
		$form .= '<div class="input-group form-subscribe-email">';
		$form .= '<input type="hidden" name="nr" value="widget"/>';
		$form .= '<input class="txt-subcrible" type="email" required name="ne" placeholder="'.esc_attr($text).'" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/>';
		$form .= '<span class="input-group-btn">';
					$form .= '<button type="submit" class="btn btn-subcrible">'.esc_html($btn_text).'</button>';
					$form .= '</span>';
		$form .= '</div></form>';
	$form = $newsletter->replace($form);
?>
<div class="container-fluid footer-subcrible">
	<div class="container">
		<div class="input-group subcrible">
				<?php printf ('%s',$form);?>
		</div>
	</div>
</div>
<?php
}
?>