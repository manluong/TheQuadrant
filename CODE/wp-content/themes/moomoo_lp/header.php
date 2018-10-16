<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php echo bloginfo(); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri().'?ver=1.0.0'; ?>" />
	<?php wp_head(); ?>
</head>
<body id="" <?php body_class(); ?>>
<div id="container">
	<div id="header">
		<nav>
			<ul>
				<div id="logo"><img src="<?=MOOMOO_ASSET_URL?>imgs/logo.png"></div>
				<li>Home</li>
				<li>About us</li>
				<li>Get started</li>
				<li>Success Stories</li>
				<li>Give Back</li>
				<li>Contact Us</li>
			</ul>
		</nav>
	</div>
<div class="row">
