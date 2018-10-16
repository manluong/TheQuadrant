<?php
/**
 * Header template.
 * 
 * @author PIXArtThemes
 * @since 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif; ?>
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php cosmos_show_loading_page(); ?>
		<?php cosmos_show_tool_box(); ?>
		<div class="color-pink body-wrapper-content <?php echo cosmos_get_body_wrapper_class();?>">
			<!-- HEADER-->
			<div id="page" class="wrapper-content site <?php echo cosmos_get_page_class();?>">
				<?php do_action('cosmos_show_header');?>
				<!-- WRAPPER-->
				<div id="wrapper-content">
					<!-- PAGE WRAPPER-->
					<div id="page-wrapper">
						<!-- MAIN CONTENT-->
						<div class="main-content">
							<!-- CONTENT-->
							<div class="content">
								<?php do_action('cosmos_show_slider');?>
								<?php if( ! is_front_page()  && cosmos_has_header_page() ) :?>
								<?php do_action('cosmos_show_page_title');?>
								<?php endif;?>