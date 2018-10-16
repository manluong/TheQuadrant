<?php
/**
 * Sample implementation of the Custom Header feature
 * 
 * @author PIXArtThemes
 * @package Cosmos
 * @since 1.0
 */

if ( ! function_exists( 'cosmos_custom_header_setup' ) ) :
	/**
	 * Set up the WordPress core custom header feature.
	 *
	 * @uses cosmos_header_style()
	 * @uses cosmos_admin_header_style()
	 * @uses cosmos_admin_header_image()
	 */
	function cosmos_custom_header_setup() {
		add_theme_support( 'custom-header', apply_filters( 'cosmos_custom_header_args', array(
			'default-image'          => '',
			'default-text-color'     => '000000',
			'width'                  => 1000,
			'height'                 => 250,
			'flex-height'            => true,
			'wp-head-callback'       => 'cosmos_header_style',
			'admin-head-callback'    => 'cosmos_admin_header_style',
			'admin-preview-callback' => 'cosmos_admin_header_image',
		) ) );
	}
endif;// cosmos_custom_header_setup
add_action( 'after_setup_theme', 'cosmos_custom_header_setup' );

if ( ! function_exists( 'cosmos_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog
	 *
	 * @see cosmos_custom_header_setup().
	 */
	function cosmos_header_style() {
		$header_text_color = get_header_textcolor();
	
		// If no custom options for text are set, let's bail
		// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value.
		if ( HEADER_TEXTCOLOR == $header_text_color ) {
			return;
		}
	
		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
			// Has the text been hidden?
			if ( 'blank' == $header_text_color ) :
		?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif; // cosmos_header_style

if ( ! function_exists( 'cosmos_admin_header_style' ) ) :
	/**
	 * Styles the header image displayed on the Appearance > Header admin panel.
	 *
	 * @see cosmos_custom_header_setup().
	 */
	function cosmos_admin_header_style() {
	?>
		<style type="text/css">
			.appearance_page_custom-header #headimg {
				border: none;
			}
			#headimg h1,
			#desc {
			}
			#headimg h1 {
			}
			#headimg h1 a {
			}
			#desc {
			}
			#headimg img {
			}
		</style>
	<?php
	}
endif; // cosmos_admin_header_style

if ( ! function_exists( 'cosmos_admin_header_image' ) ) :
	/**
	 * Custom header image markup displayed on the Appearance > Header admin panel.
	 *
	 * @see cosmos_custom_header_setup().
	 */
	function cosmos_admin_header_image() {
	?>
		<div id="headimg">
			<h1 class="displaying-header-text">
				<a id="name" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			</h1>
			<div class="displaying-header-text" id="desc"><?php bloginfo( 'description' ); ?></div>
			<?php if ( get_header_image() ) : ?>
			<img src="<?php header_image(); ?>" alt="">
			<?php endif; ?>
		</div>
	<?php
	$custom_css = "";
	$custom_css .= '#headimg .displaying-header-text #name{color: #'.get_header_textcolor().';}';
	$custom_css .= '#headimg #desc{color: #'.get_header_textcolor().';}';
	do_action( 'cosmos_add_inline_style', $custom_css );
	}
endif; // cosmos_admin_header_image