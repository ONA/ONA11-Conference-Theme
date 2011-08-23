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