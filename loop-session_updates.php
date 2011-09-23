<?php
	$args = array(
		'post_type' => 'post',
	    'connected_to' => get_queried_object_id(),
	);
	$session_updates = new WP_Query( $args );
?>

<?php if ( $session_updates->have_posts() ): ?>
	
	<h3 class="orange-callout">Session Updates</h3>
	
	<div class="session-updates">

<?php while ( $session_updates->have_posts() ): $session_updates->the_post(); ?>
	
	<?php $post_format = get_post_format(); ?>
	
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<?php if ( in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>
		<h2 class="entry-title"><?php the_title() ?></h2>
		<?php endif; ?>
		
		<?php if ( in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>
		<div class="entry-meta"><span class="entry-author">By <?php ona11_author_posts_link(); ?></span> &mdash; <span class="entry-timestamp"><?php ona11_timestamp(); ?></span></div>
		<?php endif; ?>
		
		<?php if ( !in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>		
		<div class="entry-content">
			<?php the_content() ?>
		</div>
		<?php else: ?>
		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div>
		<?php endif; ?>
		
		<?php if ( !in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>
		<div class="entry-meta"><span class="entry-author">By <?php ona11_author_posts_link(); ?></span> &mdash; <a href="<?php the_permalink(); ?>">Link</a> &mdash; <span class="entry-timestamp"><?php ona11_timestamp( 'short', false ); ?></span></div>
		<?php endif; ?>
	
	</div><!-- .post -->
	
<?php endwhile; ?>

	</div>

<?php else: ?>
	
	<div class="message info">
		<p>No updates from the session yet, stay tuned.</p>
	</div>

<?php endif; ?>