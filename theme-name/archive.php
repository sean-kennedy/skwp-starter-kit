<?php get_header(); ?>
	
	<section class="body-container">
	
		<div class="wrap group">
		
			<div class="body-content">
	
				<h1><?php post_type_archive_title(); ?><?php single_cat_title(); ?></h1>
				
				<?php get_template_part('partials/loop'); ?>
				
			</div>
			
			<?php get_sidebar(); ?>
			
		</div>
	
	</section>

<?php get_footer(); ?>