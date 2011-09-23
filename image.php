<?php get_header() ?>

	<div class="main">
		
		<div class="wrap">
		
		<div class="content full-width">

			<?php if (have_posts()) : ?>

				<?php $image_id = get_queried_object_id(); ?>
				<div class="navigation">
					<span class="previous-image navigation-link left-navigation"><?php previous_image_link( false, '&laquo; Previous' ); ?></span>
					<a class="navigation-link" href="<?php echo get_permalink( $post->post_parent ); ?>"><?php echo get_the_title( $post->post_parent ); ?></a>	
					<span class="next-image navigation-link right-navigation"><?php next_image_link( false, 'Next &raquo;' ); ?></span>					
				</div>
				
			 	<?php while (have_posts()) : the_post(); ?>

				<div class="image post" id="image-<?php echo $image_id; ?>">						

					<div class="sidebar float-right">
						<h2><?php the_title(); ?></h2>							
						<?php if ( !empty( $post->post_excerpt ) ) : ?>
						<div class="image-caption"><?php the_excerpt(); ?></div>
						<?php endif; ?>
						<?php if ( !empty( $post->post_content ) ) : ?>			
						<div class="image-description"><?php the_content(); ?></div>
						<?php endif; ?>
					</div>
					<?php echo wp_get_attachment_image( $post->ID, array( 600, 600 ) ); ?>

					<div style="clear:both;"></div>

				</div><!-- END - .image -->
				

			<?php endwhile; ?>
			
			<?php
				$args = array(
					'post_type' => 'attachment',
					'post_parent' => $post->post_parent,
					'posts_per_page' => -1,
					'post_status' => 'inherit',
					'order' => 'ASC',
					'orderby' => 'menu_order ID'
				);
				$gallery_images = new WP_Query( $args );
			?>
			<?php if ( $gallery_images->have_posts() && $gallery_images->post_count > 1 ): ?>

			<div class="gallery-images">				

			<?php while ( $gallery_images->have_posts() ) : $gallery_images->the_post(); ?>

			<div class="gallery-thumbnail float-left<?php if ( get_the_id() == $image_id ) { echo ' active'; } ?>">
				<a href="<?php echo get_permalink( get_the_id() ); ?>#content"><?php echo wp_get_attachment_image( get_the_id(), array( 75, 75 ) ); ?></a>
			</div>

			<?php endwhile; ?>

			<div class="clear-left"></div>

			</div><!-- END .gallery-images -->
			
			<?php else: ?>

				<div class="message info">Sorry, no attachments matched your criteria.</div>

			<?php endif; ?>		
			
			<?php endif; ?>

		<div class="clear-both"></div>

		</div><!-- .content -->
		
	</div><!-- #container -->

<?php get_footer() ?>