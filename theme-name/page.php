<?php get_header(); ?>
	
	<section class="body-container">
	
		<div class="wrap group">
		
			<div class="body-content">
	
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
				<h1><?php the_title(); ?></h1>
				
				<?php the_content(); ?>
							
			<?php endwhile; ?>
			
			<?php else: ?>
					
				<h2>Sorry, nothing to display.</h2>
			
			<?php endif; ?>
			
			</div>
			
			<?php get_sidebar(); ?>
		
		</div>
	
	</section>

<?php get_footer(); ?>