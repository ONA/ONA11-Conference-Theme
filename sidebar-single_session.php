<div class="sidebar float-right">

<?php
	if ( ona11_p2p_enabled() ):
		$args = array(
		    'post_type' => 'ona11_person',
		    'connected_from' => get_queried_object_id()
		);
		$presenters = new WP_Query( $args );
		if ( $presenters->have_posts() ) :
		?>
		<div class="widget session-presenters">
		<h4 class="orange-callout"><?php _e( 'Presenters' ); ?></h4>
		<ul>
		<?php while ( $presenters->have_posts() ) : $presenters->the_post(); ?>
		    <li <?php post_class('post'); ?>>
				<?php if ( has_post_thumbnail() ): ?>
					<?php the_post_thumbnail( 'small-square', array( 'class' => 'post-thumbnail float-right' ) ); ?>
				<?php endif; ?>
				<h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				<?php if ( $title = get_post_meta( get_the_id(), '_ona11_person_title', true ) ): ?>
				<div class="person-meta person-title"><span class="label highlight">Title:</span> <?php echo $title; ?></div>
				<?php endif; ?>
				<?php if ( $organization = get_post_meta( get_the_id(), '_ona11_person_organization', true ) ): ?>	
				<div class="person-meta person-organization"><span class="label highlight">Organization:</span> <?php echo $organization; ?></div>
				<?php endif; ?>
			</li>
		<?php endwhile; ?>
		</ul>
		</div>
	<?php endif; ?>
<?php endif; ?>
	
</div>