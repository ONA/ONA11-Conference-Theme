<?php if ( have_posts() ): ?>
	
	<?php
	$sessions_text = '';
	if ( ona11_p2p_enabled() ) {
		$args = array(
			'post_type' => 'ona11_session',
		    'connected_from' => get_queried_object_id(),
		);
		$sessions = new WP_Query( $args );
		if ( $sessions->have_posts() ) {
			$sessions_text = '&mdash; <span class="entry-session">Session: ';
			while ( $sessions->have_posts() ) {
				$sessions->the_post();
				$sessions_text .= '<a href="' . get_permalink() . '">' . get_the_title() . '</a>, ';
			}
			$sessions_text = rtrim( $sessions_text, ', ' ) . '</span>';
		}
	}
	?>
	
<?php while ( have_posts() ): the_post(); ?>
	<?php $post_format = get_post_format();
		if ( !$post_format )
			$post_format = 'standard';
	?>

	<div id="post-<?php the_ID() ?>" <?php post_class() ?>>
		<?php if ( in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>
		<h2 class="entry-title"><?php the_title() ?></h2>
		<?php endif; ?>
		
		<?php if ( in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>		
		<div class="entry-meta"><span class="entry-author">By <?php ona11_author_posts_link(); ?></span> &mdash; <span class="entry-timestamp"><?php ona11_timestamp(); ?></span>
			<?php if ( $sessions_text ) echo $sessions_text; ?>
		</div>
		<?php endif; ?>		
		
		<div class="entry-content">
			<?php the_content() ?>
		</div>
		
		<?php if ( !in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>		
		<div class="entry-meta"><span class="entry-author">By <?php ona11_author_posts_link(); ?></span> &mdash; <span class="entry-timestamp"><?php ona11_timestamp(); ?></span>
			<?php if ( $sessions_text ) echo $sessions_text; ?>	
		</div>
		<?php endif; ?>		
		
		<?php if ( function_exists( 'get_coauthors' ) && in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>
		<div class="entry-bios">
			<?php
				$coauthors = get_coauthors();
			?>
			<?php foreach( $coauthors as $coauthor ): ?>
			<div class="coauthor-bio">
				<?php
				if ( $avatar_url = get_avatar( $coauthor->ID, '64' ) ): ?>
					<?php echo $avatar_url; ?>
				<?php endif; ?>
				<h4 class="coauthor-name"><a href="<?php echo get_author_posts_url( $coauthor->ID ); ?>"><?php esc_html_e( $coauthor->display_name ); ?></a></h4>
				<?php if ( !empty( $coauthor->description ) ): ?>
					<p><?php esc_html_e( $coauthor->description ); ?></p>
				<?php endif; ?>
				<div class="clear-left"></div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	
	</div><!-- .post -->
	
<?php endwhile; ?>

<?php endif; ?>