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
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>
<body <?php body_class(); ?>>
	
	<?php get_template_part('partials/menu/mobile-menu'); ?>
	
	<div class="body-wrapper js-body-wrapper">

		<header class="header">
		
			<div class="wrap group">
			
				<a class="logo" href="<?php echo home_url(); ?>">
					<!--<img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="<?php bloginfo('name'); ?>">-->
				</a>
				
				<?php get_template_part('partials/menu/desktop-menu'); ?>
				
				<?php get_template_part('partials/menu/mobile-menu-trigger'); ?>
			
			</div>
		
		</header>