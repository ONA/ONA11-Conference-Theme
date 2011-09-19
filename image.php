<?php get_header() ?>

	<div class="main">
		
		<div class="wrap">
		
		<div class="content">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<?php $image_id = get_the_id(); ?>

							<div class="image post" id="image-<?php echo $image_id; ?>">
								
								<div class="left-navigation navigation-link float-left">
								<?php previous_image_link( false, '&larr;' ); ?>
								</div>

								<div class="right-navigation navigation-link float-right">
									<?php next_image_link( false, '&rarr;' ); ?>
								</div>
								<h2 class="align-center"><?php the_title(); ?></h2>
								<div class="align-center"><a href="<?php echo get_permalink($post->post_parent); ?>"><?php echo get_the_title($post->post_parent); ?></a></div>								

								<div class="primary-image align-center"><?php echo wp_get_attachment_image( $post->ID, array( 600, 600 ) ); ?></div>
								<?php echo edit_post_link( 'Edit this image', '<p>', '</p>' ); ?>

								<?php if ( !empty( $post->post_excerpt ) ) : ?>
								<div class="image-caption"><?php the_excerpt(); ?></div>
								<?php endif; ?>

								<?php if ( !empty( $post->post_content ) ) : ?>			
								<div class="image-description"><?php the_content(); ?></div>
								<?php endif; ?>

								<div style="clear:both;"></div>

							</div><!-- END - .image -->

						<?php endwhile; else: ?>

							<div class="message info">Sorry, no attachments matched your criteria.</div>

						<?php endif; ?>

						<div class="gallery-images">

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

						<?php while ( $gallery_images->have_posts() ) : $gallery_images->the_post(); ?>

						<div class="gallery-thumbnail float-left<?php if ( get_the_id() == $image_id ) { echo ' active'; } ?>">
							<a href="<?php echo get_permalink( get_the_id() ); ?>"><?php echo wp_get_attachment_image( get_the_id(), array( 75, 75 ) ); ?></a>
						</div>

						<?php endwhile; endif; ?>

						</div><!-- END .gallery-images -->

					<div class="clear-both"></div>

		</div><!-- .content -->
		
		<div>
		
	</div><!-- #container -->

<?php get_footer() ?>