<?php get_header(); ?>
	
	<section class="body-container">
	
		<div class="wrap group">
		
			<div class="body-content">
	
				<h1><?php echo $wp_query->found_posts; ?> Search Results for: <?php echo get_search_query(); ?></h1>
				
				<?php get_template_part('loop'); ?>
		
			</div>
			
			<?php get_sidebar(); ?>
			
		</div>
	
	</section>

<?php get_footer(); ?>