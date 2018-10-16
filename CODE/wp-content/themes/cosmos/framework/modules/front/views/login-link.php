<?php
$cart_link = '';
$cart_icon = '';
$header_account = Cosmos::get_option('pix-header-account');
if( $header_account != 'hide' ){
	if($header_account == 'woo' && COSMOS_WOOCOMMERCE_ACTIVE) {
		$cart_link        = get_permalink( get_option( 'woocommerce_cart_page_id') );
		$register_page_id = $login_page_id = get_option( 'woocommerce_myaccount_page_id' );
		$account_link     =  get_permalink( $login_page_id );
		$account_text     = esc_html__( 'My Account', 'cosmos' );
	}else{
		$login_page_id    = get_option( 'cosmos_login_page_id' );
		$register_page_id = get_option( 'cosmos_register_page_id' );
		$account_link     = esc_url( admin_url( 'profile.php' ) );
		$account_text     = esc_html__( 'My Profile', 'cosmos' );
	}
	
	if( !empty( $cart_link ) ) {
		$cart_icon = sprintf('<li class="woo-login"><a href="%s" class="item"><i class="icons fa fa-shopping-cart"></i></a></li>',
			esc_url($cart_link)
		);
	}
	if ( is_user_logged_in() ) {
		printf('
			<li class="woo-login"><a href="%1$s" class="item">%2$s</a></li>
			<li class="woo-login"><a href="%3$s" class="item">%4$s</a></li>'.wp_kses_post($cart_icon).'',
			esc_url($account_link),
			esc_html( $account_text ),
			esc_url( wp_logout_url( get_permalink( $login_page_id ) ) ),
			esc_html__( 'Sign out', 'cosmos' )
		);
	}
	else {
		printf('<li class="woo-login"><a href="%1$s" class="item">%2$s</a></li>
				<li class="woo-login"><a href="%3$s" class="item">%4$s</a></li>'.wp_kses_post($cart_icon),
				esc_url( get_permalink( $login_page_id ) ),
				esc_html__( 'Login', 'cosmos' ),
				esc_url( get_permalink( $register_page_id ) ),
				esc_html__( 'Register', 'cosmos' )
		);
	}
}
