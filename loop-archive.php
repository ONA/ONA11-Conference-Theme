<?php if ( have_posts() ) : ?>

<?php while ( have_posts() ) : the_post() ?>

	<div id="post-<?php the_ID() ?>" <?php post_class(); ?>>
		
		<h3 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
		<div class="entry-meta"><span class="entry-author">By <?php ona11_author_posts_link(); ?></span> &mdash; <span class="entry-timestamp"><?php ona11_timestamp(); ?></span></div>
		<div class="entry-excerpt">
			<?php the_excerpt() ?>
		</div>
	</div><!-- .post -->

<?php endwhile; ?>

	<div class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&laquo;</span> Older posts', 'sandbox' ) ) ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&raquo;</span>', 'sandbox' ) ) ?></div>
	</div>
	
<?php endif; ?>