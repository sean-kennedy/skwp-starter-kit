<?php get_header(); ?>
	
	<section class="body-container">
	
		<div class="wrap group">
		
			<div class="body-content">
	
				<h1>Latest Posts</h1>
			
				<?php get_template_part('partials/loop'); ?>
		
			</div>
			
			<?php get_sidebar(); ?>
			
		</div>
	
	</section>

<?php get_footer(); ?>