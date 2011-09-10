<?php

/**
 * Produce the <title> tag for the header
 */
function ona11_head_title() {
	
	$title = get_bloginfo('name') . ' | ' . get_bloginfo('description');
	
	if ( is_single() ) {
		global $post;
		$title = get_the_title( $post->ID );
	}
	
	echo '<title>' . $title . '</title>';
	
}

function ona11_author_posts_link() {
	
	if ( function_exists( 'coauthors_posts_links' ) )
		coauthors_posts_links();
	else
		the_author_posts_link();
}

function ona11_timestamp( $type = 'long', $show_updated = true ) {
	global $post;
	$post_id = $post->ID;

	$post_timestamp = get_post_time( 'U', true, $post_id );
	$current_timestamp = time();

	// Only do the relative timestamps for 7 days or less, then just the month and day
	if ( $post_timestamp > ( $current_timestamp - 604800 ) ) {
		echo human_time_diff( $post_timestamp ) . ' ago';
	} else if ( $post_timestamp > ( $current_timestamp - 220752000 ) ) {
		the_time( 'F jS' );
	} else {
		the_time( 'F j, Y' );
	}
	
}