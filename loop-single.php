<?php if ( have_posts() ): ?>
	
<?php while ( have_posts() ): the_post(); ?>

	<div id="post-<?php the_ID() ?>" <?php post_class() ?>>
		<h2 class="entry-title"><?php the_title() ?></h2>
		
		<div class="entry-content">
			<?php the_content() ?>
		</div>
	
	</div><!-- .post -->
	
<?php endwhile; ?>

<?php endif; ?>