<?php
	$args = array(
		'post_type' => 'ona11_session',		
		'posts_per_page' => -1,
		'meta_key' => '_ona11_start_timestamp',
		'orderby' => 'meta_value',
		'order' => 'asc',
	);
	$sessions = new WP_Query( $args );
	
	$session_days = array(
		'09/22/2011',
		'09/23/2011',
		'09/24/2011',		
	);
	
	// Load all of the sessions into an array based on start date and time
	$all_sessions = array();
	while( $sessions->have_posts() ) {
		$sessions->the_post();
		$start_timestamp = get_post_meta( $post->ID, '_ona11_start_timestamp', true );
		$start_date = date( 'm/d/Y', $start_timestamp );
		$start_time = date( 'g:i a', $start_timestamp );
		$all_sessions[$start_date][$start_time][$post->ID] = $post;
	}
	
	
?>

<?php foreach( $all_sessions as $session_day => $days_sessions ):
	$day_full_name = date( 'l', strtotime( $session_day ) );
	$day_slugify = sanitize_title( $day_full_name );

?>

<div id="session-day-<?php echo $day_slugify; ?>" class="session-day">
	<a id="<?php echo $day_slugify; ?>"></a>
	<h3><?php echo $day_full_name; ?></h3>
	<div class="day-sessions">
	<?php foreach( $days_sessions as $start_time => $posts ): ?>
		<div class="session-start-time"><?php echo $start_time; ?></div>
		<div class="session-time-block">
			<ul>
			<?php foreach( $posts as $post ): ?>
				<?php setup_postdata( $post ); ?>
				<li><?php the_title(); ?></li>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php endforeach; ?>
	</div>
</div>
<?php endforeach; ?>