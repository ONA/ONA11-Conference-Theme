<div class="sidebar float-right">
	
	<div class="widget session-tracks">
	<h4 class="orange-callout"><?php _e( 'Tracks' ); ?></h4>
	<?php
		$args = array(
			'taxonomy' => 'ona11_session_types',
			'hide_empty' => false,
			'title_li' => '',
		);
		wp_list_categories( $args );
	?>
	</div>
	
	<div class="widget session-locations">
	<h4 class="orange-callout"><?php _e( 'Locations' ); ?></h4>
	<?php
		$args = array(
			'taxonomy' => 'ona11_locations',
			'hide_empty' => false,
			'title_li' => '',
		);
		wp_list_categories( $args );
	?>
	</div>
	
</div>