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
		$html .= get_the_time( 'l' ) . ' at ' . get_the_time( 'g:i a' );
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
		$html .= get_the_modified_time( 'l' ) . ' at ' . get_the_modified_time( 'g:i a' );
	} else if ( $post_modified_timestamp > ( $current_timestamp - 220752000 ) ) {
		$html .= get_the_modified_time( 'F jS' );
	} else {
		$html .= get_the_modified_time( 'F j, Y' );
	}
	$html .= '</span><span class="full-date">' . get_the_modified_time( 'l, F j, Y' ) . ' at ' . get_the_modified_time( 'g:i a T' ) . '</span></span>';
	
	echo $html;
	
}

/**
 * Helper method for whether the P2P plugin is enabled
 *
 * @return bool $p2p_enabled Whether or not the plugin is enabled
 */
function ona11_p2p_enabled() {
	if ( !function_exists( 'p2p_register_connection_type' ) )
		return false;
	else
		return true;
}

/**
 * Generate a link to the previous session in the track
 */
function ona11_get_previous_session_link() {
	global $post;
	$post_id = $post->ID;
	$start_timestamp = (int)get_post_meta( $post_id, '_ona11_start_timestamp', true );
	$args = array(
		'posts_per_page' => 1,
		'post_type' => 'ona11_session',
		'meta_key' =>  '_ona11_start_timestamp',
		'meta_value' => $start_timestamp,
		'meta_compare' => '<',
	);
	
	$session_type_tax = wp_get_object_terms( $post_id, 'ona11_session_types' );
	if ( count( $session_type_tax ) )
		$args['tax_query'] = array(
			'taxonomy' => 'ona11_session_types',
			'field' => 'id',
			'terms' => $session_type_tax[0]->term_id,
			'operator' => 'AND',
		);
	
	$match_posts = get_posts( $args );
	if ( count( $match_posts ) && wp_get_object_terms( $match_posts[0]->ID, 'ona11_session_types' ) )
 		return get_permalink( $match_posts[0]->ID );
	else
	 	return false;
}

/**
 * Generate a link to the next session in the track
 */
function ona11_get_next_session_link() {
	global $post;
	$post_id = $post->ID;
	$start_timestamp = (int)get_post_meta( $post_id, '_ona11_start_timestamp', true );
	$args = array(
		'posts_per_page' => 1,
		'post_type' => 'ona11_session',
		'meta_key' =>  '_ona11_start_timestamp',
		'meta_value' => $start_timestamp,
		'meta_compare' => '>',
	);
	
	$session_type_tax = wp_get_object_terms( $post_id, 'ona11_session_types' );
	if ( count( $session_type_tax ) )
		$args['tax_query'] = array(
			'taxonomy' => 'ona11_session_types',
			'field' => 'id',
			'terms' => $session_type_tax[0]->term_id,
			'operator' => 'IN',
		);
	
	$match_posts = get_posts( $args );
	if ( count( $match_posts ) && wp_get_object_terms( $match_posts[0]->ID, 'ona11_session_types' ) )
 		return get_permalink( $match_posts[0]->ID );
	else
	 	return false;
}