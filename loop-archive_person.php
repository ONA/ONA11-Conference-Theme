<?php
	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'ona11_person',
		'order' => 'ASC',
		'orderby' => 'title',
	);
	$presenters = new WP_Query( $args );
?>

<?php if ( $presenters->have_posts() ): ?>

<?php while ( $presenters->have_posts() ) : $presenters->the_post(); ?>
	
	<div id="post-<?php the_id(); ?>" <?php post_class( 'post' ); ?>>
	
	<?php if ( has_post_thumbnail() ): ?>
		<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'post-thumbnail float-left' ) ); ?>
	<?php endif; ?>
	<h3 class="person-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
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
	
	</div>

<?php endwhile; ?>

<?php endif; ?>