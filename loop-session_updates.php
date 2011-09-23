<?php
	$args = array(
		'post_type' => 'post',
	    'connected_to' => get_queried_object_id(),
		'posts_per_page' => -1,
	);
	$end_timestamp = get_post_meta( get_queried_object_id(), '_ona11_end_timestamp', true );
	if ( current_time( 'timestamp' ) > ( $end_timestamp + 900 ) )
		$args['order'] = 'ASC';
	$session_updates = new WP_Query( $args );
?>

<?php if ( $session_updates->have_posts() ): ?>
	
	<div class="session-updates-wrap">
	
	<h3 class="section-title">Session Updates</h3>
	
	<div class="session-updates">

<?php while ( $session_updates->have_posts() ): $session_updates->the_post(); ?>
	
	<?php $post_format = get_post_format();
		if ( !$post_format )
			$post_format = 'standard';
	?>
	
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<?php if ( in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php endif; ?>
		
		<?php if ( in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>
		<div class="entry-meta"><span class="entry-author">By <?php ona11_author_posts_link(); ?></span> &mdash; <span class="entry-timestamp"><?php ona11_timestamp( 'short', false ); ?></span></div>
		<?php endif; ?>
		
		<?php if ( !in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>		
		<div class="entry-content">
			<?php the_content() ?>
		</div>
		<?php elseif ( 'gallery' == $post_format ): ?>
		<div class="entry-content">
			<?php echo do_shortcode( '[gallery size="thumbnail" columns="0"]' ); ?>
		</div>
		<?php else: ?>
		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div>
		<?php endif; ?>
		
		<?php if ( !in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>
		<div class="entry-meta"><a href="<?php the_permalink(); ?>">&#8734; Permalink</a> &mdash; <span class="entry-timestamp"><?php ona11_timestamp( 'short', false ); ?></span> &mdash; <span class="entry-author">Posted by <?php ona11_author_posts_link(); ?></span></div>
		<?php endif; ?>
	
	</div><!-- .post -->
	
<?php endwhile; ?>

	</div>
	
	</div>

<?php else: ?>
	
	<div class="message info">
		<p>No updates from the session yet, stay tuned.</p>
	</div>

<?php endif; ?>