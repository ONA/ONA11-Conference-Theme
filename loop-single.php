<?php if ( have_posts() ): ?>
	
<?php while ( have_posts() ): the_post(); ?>

	<div id="post-<?php the_ID() ?>" <?php post_class() ?>>
		<h2 class="entry-title"><?php the_title() ?></h2>
		
		<div class="entry-meta"><span class="entry-author">By <?php ona11_author_posts_link(); ?></span> &mdash; <span class="entry-timestamp"><?php ona11_timestamp(); ?></span></div>
		
		<div class="entry-content">
			<?php the_content() ?>
		</div>
	
	</div><!-- .post -->
	
<?php endwhile; ?>

<?php endif; ?>