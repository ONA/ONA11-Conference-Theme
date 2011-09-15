<?php if ( have_posts() ): ?>

<div class="session-navigation">
	<div class="session-navigation-previous session-navigation-link">
	<?php if ( $previous_session_link = ona11_get_previous_session_link() ): ?>
 		<a href="<?php echo $previous_session_link; ?>">&larr;</a>
	<?php else: ?>
		&larr;
	<?php endif; ?>
	</div>
	<div class="session-navigation-home session-navigation-link">
	<a href="<?php echo get_site_url( null, '/sessions/' ); ?>"><?php _e( 'All' ); ?><a>
	</div>
	<div class="session-navigation-previous session-navigation-link">	
	<?php if ( $next_session_link = ona11_get_next_session_link() ): ?>
 		<a href="<?php echo $next_session_link; ?>">&rarr;</a>
	<?php else: ?>
		&rarr;
	<?php endif; ?>
	</div>

</div>

<?php while ( have_posts() ) : the_post(); ?>
	
	<div id="post-<?php the_id(); ?>" <?php post_class( 'post' ); ?>>
	
	<?php
		// Set up the session data
		$start_timestamp = get_post_meta( get_the_id(), '_ona11_start_timestamp', true );
		if ( $start_timestamp )
			$session_when = date( 'l, g:i a', $start_timestamp );
		else
			$session_when = 'Session start time coming soon';
			
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
		
		$session_type_tax = wp_get_object_terms( get_the_id(), 'ona11_session_types' );
		if ( count( $session_type_tax ) ) {
			$session_which = '<a href="' . get_term_link( $session_type_tax[0] ) . '">' . esc_html( $session_type_tax[0]->name ) . '</a>';
		} else {
			$session_which = 'Not listed';
		}
	?>
	
	<h2 class="session-title"><?php the_title(); ?></h2>
	<div class="session-meta session-when"><span class="label highlight">When:</span> <?php echo $session_when; ?></div>
	<div class="session-meta session-where"><span class="label highlight">Where:</span> <?php echo $session_where; ?></div>
	<div class="session-meta session-type"><span class="label highlight">Type:</span> <?php echo $session_which; ?></div>	

	<div class="session-content">
		<?php the_content(); ?>
	</div>
	
	</div>

<?php endwhile; ?>

<?php endif; ?>