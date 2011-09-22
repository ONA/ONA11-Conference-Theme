<?php if ( have_posts() ): ?>

<?php while ( have_posts() ) : the_post(); ?>
	
	<div id="post-<?php the_id(); ?>" <?php post_class( 'post' ); ?>>
	
	<?php if ( has_post_thumbnail() ): ?>
		<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'post-thumbnail float-left' ) ); ?>
	<?php endif; ?>
	<h2 class="session-title"><?php the_title(); ?></h2>
	<?php if ( $title = get_post_meta( get_the_id(), '_ona11_person_title', true ) ): ?>
	<div class="person-meta person-title"><span class="label highlight">Title:</span> <?php echo $title; ?></div>
	<?php endif; ?>
	<?php if ( $organization = get_post_meta( get_the_id(), '_ona11_person_organization', true ) ): ?>	
	<div class="person-meta person-organization"><span class="label highlight">Organization:</span> <?php echo $organization; ?></div>
	<?php endif; ?>

	<div class="session-content">
		<?php the_content(); ?>
	</div>
	
	<div class="clear-left"></div>
	
	<?php
		if ( ona11_p2p_enabled() ):
			$args = array(
			    'post_type' => 'ona11_session',
			    'connected_to' => get_queried_object_id()
			);
			$sessions = new WP_Query( $args );
			if ( $sessions->have_posts() ) :
			?>
			<div class="associated-sessions">
			<h3><?php _e( 'Sessions' ); ?></h3>
			<ul>
			<?php while ( $sessions->have_posts() ) : $sessions->the_post(); ?>
			    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php endwhile; ?>
			</ul>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	
	</div>

<?php endwhile; ?>

<?php endif; ?>