<?php if ( have_posts() ): ?>

<div class="session-navigation">
	<a href="<?php echo get_site_url( null, '/sessions/' ); ?>"><?php _e( 'All Sessions' ); ?></a>
	<?php
	$session_types = wp_get_post_terms( get_queried_object_id(), 'ona11_session_types' );
	$current_track = false;
	if ( count( $session_types ) ) {
		$current_track = $session_types[0]->slug;
		$session_types_html = ' &rarr; <a href="' . get_term_link( $session_types[0] ) . '">' . esc_html( $session_types[0]->name ) . '</a>';
		if ( $session_types[0]->parent ) {
			$parent_session = get_term_by( 'id', $session_types[0]->parent, 'ona11_session_types' );
			$session_types_html = ' &rarr; <a href="' . get_term_link( $parent_session ) . '">' . esc_html( $parent_session->name ) . '</a>' . $session_types_html;
		}
		echo $session_types_html;
	}
	?>
</div>

<?php while ( have_posts() ) : the_post(); ?>
	
	<div id="post-<?php the_id(); ?>" <?php post_class( 'post' ); ?>>
	
	<?php
		// Set up the session data
		$start_timestamp = (int)get_post_meta( get_the_id(), '_ona11_start_timestamp', true );
		if ( $start_timestamp )
			$session_when = date( 'l, g:i a', $start_timestamp );
		else
			$session_when = 'Session start time coming soon';
			
		$end_timestamp = (int)get_post_meta( get_the_id(), '_ona11_end_timestamp', true );	
			
		$session_location = wp_get_post_terms( get_the_id(), 'ona11_locations' );
		if ( count( $session_location ) ) {
			$session_where = '<a href="' . get_term_link( $session_location[0] ) . '">' . esc_html( $session_location[0]->name ) . '</a>';
			if ( $session_location[0]->parent ) {
				$parent_location = get_term_by( 'id', $session_location[0]->parent, 'ona11_locations' );
				$session_where .= ', <a href="' . get_term_link( $parent_location ) . '">' . esc_html( $parent_location->name ) . '</a>';
			}
		} else {
			$session_where = 'Location to be announced soon';
		}
	?>
	
	<h2 class="session-title"><?php the_title(); ?></h2>
	<div class="session-meta session-when"><span class="label highlight">When:</span> <?php echo $session_when; ?></div>
	<div class="session-meta session-where"><span class="label highlight">Where:</span> <?php echo $session_where; ?></div>
	
	<?php
		$current_time = current_time( 'timestamp' );
		global $ona11;
		if ( $current_time >= ( $start_timestamp - 600 ) && $current_time <= ( $end_timestamp + 900 ) && isset( $ona11->livestreams[$current_track] ) ): 
	?>
		<div class="session-livestream"><?php echo $ona11->livestreams[$current_track]; ?></div>
	<?php endif; ?>

	<div class="session-content">
		<?php the_content(); ?>
	</div>
	
	</div>

<?php endwhile; ?>

<?php endif; ?>