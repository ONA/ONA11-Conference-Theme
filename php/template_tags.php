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
	$html = '<span class="post-date clickable-date"><span class="readable-date">';
	if ( get_post_time( 'l, F j, Y', true, $post_id ) == date( 'l, F j, Y' ) ) {
		$html .= human_time_diff( $post_timestamp ) . ' ago';
	} else if ( $post_timestamp > ( $current_timestamp - 518400 ) ) {
		$html .= get_the_time( 'l' ) . ' at ' . get_the_time( 'g:i a T' );
	} else if ( $post_timestamp > ( $current_timestamp - 220752000 ) ) {
		$html .= get_the_time( 'F jS' );
	} else {
		$html .= get_the_time( 'F j, Y' );
	}
	$html .= '</span><span class="full-date">' . get_the_time( 'l, F j, Y' ) . ' at ' . get_the_time( 'g:i a T' ) . '</span></span>';
	if ( !$show_updated || ( get_the_time( 'U' ) == get_the_modified_time( 'U' ) ) ) {
		echo $html;
		return;
	}
	
	$post_modified_timestamp = get_post_modified_time( 'U', true, $post_id );
	$html .= ', <span class="post-modified-date clickable-date">last modified <span class="readable-date">';
	if ( get_post_modified_time( 'l, F j, Y', true, $post_id ) == date( 'l, F j, Y' ) ) {
		$html .= human_time_diff( $post_modified_timestamp ) . ' ago';
	} else if ( $post_modified_timestamp > ( $current_timestamp - 518400 ) ) {
		$html .= get_the_modified_time( 'l' ) . ' at ' . get_the_modified_time( 'g:i a T' );
	} else if ( $post_modified_timestamp > ( $current_timestamp - 220752000 ) ) {
		$html .= get_the_modified_time( 'F jS' );
	} else {
		$html .= get_the_modified_time( 'F j, Y' );
	}
	$html .= '</span><span class="full-date">' . get_the_modified_time( 'l, F j, Y' ) . ' at ' . get_the_modified_time( 'g:i a T' ) . '</span></span>';
	
	echo $html;
	
}