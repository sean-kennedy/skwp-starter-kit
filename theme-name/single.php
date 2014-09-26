<?php get_header(); ?>
	
	<section class="body-container">
	
		<div class="wrap group">
		
			<div class="body-content">
	
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
				<?php if (has_post_thumbnail()) : ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a>
				<?php endif; ?>
	
				<h1><?php the_title(); ?></h1>
				
				<?php the_content(); ?>
				
			<?php endwhile; ?>
			
			<?php else: ?>
					
				<h1>Sorry, nothing to display.</h1>
			
			<?php endif; ?>
		
			</div>
			
			<?php get_sidebar(); ?>
			
		</div>
	
	</section>

<?php get_footer(); ?>