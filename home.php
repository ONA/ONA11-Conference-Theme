<?php
	get_header();
	// Variable to store the IDs of posts already shown
	$already_shown = array();
?>
		
<div class="main">
			
	<div class="wrap">
		
		<div class="home-row">
			
			<div class="left-col float-left ona11-featured-stories">
				<div class="ona11-main-featured float-left">
				<?php
					$args = array(
						'posts_per_page' => 1,
						'post__not_in' => $already_shown,						
					);
					$lead_story = new WP_Query( $args );
				?>
				<?php if ( $lead_story->have_posts() ):
						while( $lead_story->have_posts() ): $lead_story->the_post();
						$already_shown[] = get_the_id();
						?>
						<div id="post-<?php the_id(); ?>" <?php post_class(); ?>>
							<?php if ( has_post_thumbnail() ) {
								echo '<a href="' . get_permalink() . '">';							
								the_post_thumbnail( 'home-featured' );
								echo '</a>';
								}
							?>
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>							
							<div class="entry-meta"><span class="entry-author">By <?php ona11_author_posts_link(); ?></span> &mdash; <span class="entry-timestamp"><?php ona11_timestamp( 'long', false ); ?></span></div>

							<?php if ( !has_post_thumbnail() ): ?>
							<div class="entry-excerpt">
								<?php the_excerpt() ?>
							</div>
							<?php endif; ?>
						</div>
						<?php
						endwhile;
					  endif;?>
				</div>
				
				<div class="ona11-secondary-featured float-right">
				<?php
					$args = array(
						'posts_per_page' => 4,
						'post__not_in' => $already_shown,
					);
					$secondary_leads = new WP_Query( $args );
				?>
				<?php if ( $secondary_leads->have_posts() ):
							echo '<ul>';
						while( $secondary_leads->have_posts() ): $secondary_leads->the_post();
						$already_shown[] = get_the_id();
						?>
						<li id="post-<?php the_id(); ?>" <?php post_class(); ?>>
							<?php if ( has_post_thumbnail() ) {
								echo '<a href="' . get_permalink() . '">';								
								the_post_thumbnail( 'thumbnail', array( 'class' => 'float-right' ) );
								echo '</a>';
							}
							?>
							<h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						</li>
						<?php
						endwhile;
							echo '</ul>';
					  endif;?>
				</div>
			</div>
			
			<div class="right-col float-right ona11-sponsors">
			
				<h4>ONA is sponsored by:</h4>
				<a href="<?php echo get_site_url( null, '/sponsors-exhibitors/' ); ?>">
				<img src="<?php bloginfo( 'template_directory' ); ?>/images/tier1_sponsor_logos.jpg" width="252px" height="248px" />
				</a>
			</div>
			
			<div class="clear-both">
			
		</div>
		
		<div class="home-row featured-sessions-row">			
			
			<?php
				$args = array(
					'post_type' => 'ona11_session',
					'posts_per_page' => 4,
				);
				$featured_sessions = new WP_Query( $args );
			?>
			<h3 class="section-title">Featured Sessions</h3>
			<?php if ( $featured_sessions->have_posts() ): ?>
			<ul class="featured-sessions float-right">
			<?php while ( $featured_sessions->have_posts() ): $featured_sessions->the_post(); ?>
				<li>
					<?php
					$start_timestamp = get_post_meta( get_the_id(), '_ona11_start_timestamp', true );					
					if ( $start_timestamp )
						$session_when = date( 'l, g:i a', $start_timestamp );
					else
						$session_when = 'Session start time coming soon';

					$session_location = wp_get_post_terms( get_the_id(), 'ona11_locations' );
					if ( count( $session_location ) ) {
						$session_where = '<a href="' . get_term_link( $session_location[0] ) . '">' . esc_html( $session_location[0]->name ) . '</a>';
						if ( $session_location[0]->parent ) {
							$parent_location = get_term_by( 'id', $session_location[0]->parent, 'ona11_locations' );
							$session_where .= ', <a href="' . get_term_link( $parent_location ) . '">' . esc_html( $parent_location->name ) . '</a>';
						}
					} else {
						$session_where = 'Location tbd';
					}
					
					$session_type_tax = wp_get_object_terms( get_the_id(), 'ona11_session_types' );	
					if ( count( $session_type_tax ) )
						echo '<h5 class="session-track blue-background">' . esc_html( $session_type_tax[0]->name ) . '</h5>';
					?>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<div class="session-meta session-when"><span class="label">When:</span> <?php echo $session_when; ?></div>
					<div class="session-meta session-where"><span class="label">Where:</span> <?php echo $session_where; ?></div>
				</li>
			<?php endwhile; ?>
			</ul>
			<?php endif; ?>
			
			<div class="clear-both"></div>
			
		</div>
		
		<div class="home-row">
			
			<div class="left-col float-left ona11-sponsors">
				
				<h4>Sponsored content:</h4>
				<a href="http://news.yahoo.com/">
				<img src="<?php bloginfo( 'template_directory' ); ?>/images/yahoo_news_ona_250x250.png" width="250px" height="250px" />
				</a>
			</div>
			
			<div class="right-col float-right ona11-latest-stories">
				<h3 class="section-title">Latest Stories</h3>
			<?php
				$args = array(
					'posts_per_page' => 6,
					'post__not_in' => $already_shown,
				);
				$latest_stories = new WP_Query( $args );
				
				if ( $latest_stories->have_posts() ):
				while ( $latest_stories->have_posts() ): $latest_stories->the_post();
			?>
				<div id="post-<?php the_id(); ?>" <?php post_class(); ?>>
					<?php if ( has_post_thumbnail() ) {
						echo '<a href="' . get_permalink() . '">';
						the_post_thumbnail( 'thumbnail', array( 'class' => 'float-right' ) );
						echo '</a>';
					}
					?>					
					<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<div class="entry-meta"><span class="entry-author">By <?php ona11_author_posts_link(); ?></span> &mdash; <span class="entry-timestamp"><?php ona11_timestamp( 'long', false ); ?></span></div>

					<div class="entry-excerpt">
						<?php the_excerpt() ?>
					</div>
				</div>
			<?php
				endwhile;
				endif;
			?>
			</div>
			
			<div class="clear-both"></div>
			
		</div>
				
	</div>
	
</div>
	
<?php get_footer(); ?>