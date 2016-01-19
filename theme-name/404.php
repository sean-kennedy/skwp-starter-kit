<?php get_header(); ?>

	<section class="body-container">
	
		<div class="wrap group">
		
			<div class="body-content">
		
				<h1>That page can&rsquo;t be found (404).</h1>
				
				<p>It looks like nothing was found at this location.</p>
				
				<p>Return <a href="<?php echo home_url(); ?>">home</a>? or maybe try a search:</p>
				
				<?php get_template_part('partials/search-form'); ?>
				
			</div>
			
			<?php get_sidebar(); ?>
			
		</div>
		
	</section>

<?php get_footer(); ?>