<div class="sidebar float-right">

<?php
	if ( ona11_p2p_enabled() ):
		$args = array(
		    'post_type' => 'ona11_person',
		    'connected_from' => get_queried_object_id()
		);
		$presenters = new WP_Query( $args );
		if ( $presenters->have_posts() ) :
		?>
		<div class="widget session-presenters">
		<h4 class="orange-callout"><?php _e( 'Presenters' ); ?></h4>
		<ul>
		<?php while ( $presenters->have_posts() ) : $presenters->the_post(); ?>
		    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		<?php endwhile; ?>
		</ul>
		</div>
	<?php endif; ?>
<?php endif; ?>
	
</div>