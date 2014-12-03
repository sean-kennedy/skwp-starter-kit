<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<?php if (has_post_thumbnail()) : ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a>
	<?php endif; ?>
	
	<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
	
	<?php the_excerpt(); ?>
	
<?php endwhile; ?>

<?php else: ?>

	<h2>Sorry, nothing to display.</h2>

<?php endif; ?>

<div class="pagination">
	<?php skwp_pagination(); ?>
</div>