<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>

	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<title><?php wp_title(''); ?></title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">-->
		
	<!-- CSS -->
	<?php wp_head(); ?>
	
	<!--[if lt IE 9]>
	    <script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.min.js"></script>
	<![endif]-->
	
</head>
<body>
	
	<!-- Start #main -->
	<div id="main" class="m-scene">
		
		<!-- Start body_class -->
		<div <?php body_class(); ?>>

			<header class="header">
			
				<div class="wrap group">
				
					<div class="logo">
						<a href="<?php echo home_url(); ?>">
							<!--<img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="<?php bloginfo('name'); ?>">-->
						</a>
					</div>
					
					<nav class="nav js-nav">
						<?php main_nav(); ?>
					</nav>
					
					<div class="nav-trigger js-nav-trigger">
						<i class="fa fa-bars"></i>
					</div>
				
				</div>
			
			</header>
			
			<!-- Start animation container -->
			<div class="scene_element scene_element--fadein">