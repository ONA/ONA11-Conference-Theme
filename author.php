<?php get_header() ?>

	<div class="main">
		
		<div class="wrap">
			
		<?php get_sidebar(); ?>			
		
		<div class="content">

		<?php if ( have_posts() ): ?>
			
			<?php $author = get_queried_object(); ?>

			<?php $avatar_url = get_avatar( $author->ID, '64' ); ?>
			<div class="author-avatar float-left"><?php echo $avatar_url; ?></div>
			<h2 class="page-title author"><?php esc_html_e( $author->display_name ); ?></h2>
			<?php if ( !empty( $author->description ) ): ?>
				<div class="author-description"><?php echo wpautop( $author->description ); ?></div>
			<?php endif;?>
			
			<div class="all-posts">

			<?php while ( have_posts() ) : the_post() ?>

				<?php
					$post_format = get_post_format();
					if ( !$post_format )
						$post_format = 'standard';
					$sessions_text = '';
					if ( ona11_p2p_enabled() ) {
						global $wpdb;

						$post_id = get_the_id();
						$query = $wpdb->prepare( "SELECT p2p_to FROM $wpdb->p2p WHERE p2p_from=$post_id;" );
						$results = $wpdb->get_results( $query );

						if ( count( $results ) ) {
							$post_ids = array();
							foreach( $results as $result )
								$post_ids[] = $result->p2p_to;
							$results_str = implode( ', ', $post_ids );
							$query = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE ID in(%s);", $results_str );
							$associated_posts = $wpdb->get_results( $query );
							$sessions_text = '<div class="entry-meta align-right"><span class="entry-session">&rarr; ';
							foreach( $associated_posts as $associated_post ) {
								$sessions_text .= '<a href="' . get_permalink( $associated_post->ID ) . '">' . get_the_title( $associated_post->ID ) . '</a>, ';
							}
							$sessions_text = rtrim( $sessions_text, ', ' ) . '</span></div>';
						}
					}
				?>
				<div id="post-<?php the_id(); ?>" <?php post_class(); ?>>
					<?php if ( has_post_thumbnail() ) {
						echo '<a href="' . get_permalink() . '">';
						the_post_thumbnail( 'thumbnail', array( 'class' => 'float-right' ) );
						echo '</a>';
					}
					?>
					<?php if ( $sessions_text ) echo $sessions_text; ?>						
					<?php if ( 'standard' == $post_format ): ?>
					<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3>
					<?php endif; ?>

					<?php if ( 'standard' == $post_format ): ?>		
					<div class="entry-meta"><span class="entry-author">By <?php ona11_author_posts_link(); ?></span> &mdash; <span class="entry-timestamp"><?php ona11_timestamp( 'long', false ); ?></span>
					</div>
					<?php endif; ?>		

					<?php if ( 'standard' == $post_format ): ?>
					<div class="entry-excerpt">
						<?php the_excerpt() ?>
					</div>
					<?php elseif ( 'gallery' == $post_format ): ?>
					<div class="entry-content">
						<?php echo do_shortcode( '[gallery size="thumbnail" columns="0"]' ); ?>
					</div>
					<?php else: ?>
					<div class="entry-content">
						<?php the_content() ?>
					</div>
					<?php endif; ?>

					<?php if ( 'standard' != $post_format ): ?>
					<div class="entry-meta"><a href="<?php the_permalink(); ?>">&#8734; Permalink</a> &mdash; <span class="entry-timestamp"><?php ona11_timestamp( 'short', false ); ?></span> &mdash; <span class="entry-author">Posted by <?php ona11_author_posts_link(); ?></span></div>
					<?php endif; ?>

				</div>

			<?php endwhile ?>
			
			</div>

			<div class="navigation pagination">
				<span class="nav-previous"><?php next_posts_link(__( '<span class="meta-nav">&laquo;</span> Older posts', 'sandbox' )) ?></div>
				<span class="nav-next"><?php previous_posts_link(__( 'Newer posts <span class="meta-nav">&raquo;</span>', 'sandbox' )) ?></div>
			</div>
			
		<?php endif; ?>
			
		</div>

		</div><!-- #content -->
		
		</div>
		
	</div><!-- #container -->

<?php get_footer() ?>