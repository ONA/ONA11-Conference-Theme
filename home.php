<?php
	get_header();
	// Variable to store the IDs of posts already shown
	$already_shown = array();
?>
		
<div class="main">
			
	<div class="wrap">
		
		<div class="content full-width">
		
		<div class="home-row">
			
			<div class="left-col float-left ona11-featured-stories">
				<div class="ona11-main-featured float-left">
				<?php
					if ( function_exists( 'z_get_zone' ) && $featured_stories_zone = z_get_zone( 'featured-stories' ) ) {
						$featured_stories = z_get_posts_in_zone( $featured_stories_zone );
					} else {
						$args = array(
							'post_type' => 'post',
							'numberposts' => 5,
							'post__not_in' => $already_shown,
						);
						$featured_stories = get_posts( $args );
					}
				?>
				<?php if ( count( $featured_stories ) ):
						foreach( $featured_stories as $key => $post ):
							if ( $key >= 1 )
								continue;
							setup_postdata( $post );
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
						endforeach;
						wp_reset_query();
					  endif;?>
				</div>
				
				<div class="ona11-secondary-featured float-right">
				<?php if ( count( $featured_stories ) ):
							echo '<ul>';
						foreach( $featured_stories as $key => $post ): setup_postdata( $post );
						if ( $key < 1 || $key >= 5 )
							continue;
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
						endforeach;
							echo '</ul>';
							wp_reset_query();
					  endif;?>
				</div>
			</div>
			
			<div class="right-col float-right ona11-sponsors">
			
				<h4>ONA is sponsored by:</h4>
				<a href="<?php echo get_site_url( null, '/sponsors-exhibitors/' ); ?>">
				<img src="<?php bloginfo( 'template_directory' ); ?>/images/tier1_sponsor_logos.jpg" width="252px" height="248px" />
				</a>
				<p class="more"><a href="<?php echo get_site_url( null, '/sponsors-exhibitors/' ); ?>"><?php _e( 'See all sponsors &#0187;' ); ?></a></p>
			</div>
			
			<div class="clear-both">
			
		</div>
		
		<?php
			if ( function_exists( 'z_get_zone' ) && $featured_sessions_zone = z_get_zone( 'featured-sessions' ) ) {
				$args = array(
					'post_type' => 'ona11_session',
					'posts_per_page' => 4,					
				);
				$featured_sessions = z_get_posts_in_zone( $featured_sessions_zone );
			} else {
				$args = array(
					'post_type' => 'ona11_session',
					'numberposts' => 4,
				);
				$featured_sessions = get_posts( $args );
			}
		?>
		<?php if ( count( $featured_sessions ) ): ?>		
		<div class="home-row featured-sessions-row">			
		
			<h3 class="section-title">Featured Sessions</h3>
			<ul class="featured-sessions float-right">
			<?php foreach( $featured_sessions as $post ) : setup_postdata( $post ); ?>
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
					<div class="session-meta session-when"><span class="label float-left">When:</span> <span class="session-meta-text"><?php echo $session_when; ?></span></div>
					<div class="session-meta session-where"><span class="label float-left">Where:</span> <span class="session-meta-text"><?php echo $session_where; ?></span></div>
					<?php if ( ona11_p2p_enabled() ):
						$args = array(
						    'post_type' => 'ona11_person',
						    'connected_from' => get_the_id()
						);
						$presenters = new WP_Query( $args );
						if ( $presenters->have_posts() ) :
						?>
						<div class="session-meta session-who"><span class="label float-left"><?php _e( 'Who' ); ?>:</span>
						
						<?php
						$all_presenters = '';
						while ( $presenters->have_posts() ) {
							$presenters->the_post();
 							if ( has_post_thumbnail() ) {
 								$all_presenters .= get_the_post_thumbnail( get_the_id(), 'small-square', array( 'class' => 'post-thumbnail mini-avatar' ) );
							}
							$all_presenters .= '<a href="' . get_permalink() . '">' . get_the_title() . '</a>, ';
						} ?>
						<span class="session-meta-text"><?php echo rtrim( $all_presenters, ', ' ); ?></span>
						</div>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
			</ul>
			
			<div class="clear-both"></div>
			
		</div>
		<?php endif; ?>		
		
		<div class="home-row">
			
			<div class="sidebar float-left">
			
				<div class="left-col ona11-sponsors widget">
				
					<h4>Sponsored content:</h4>
					<a href="http://news.yahoo.com/">
					<img src="<?php bloginfo( 'template_directory' ); ?>/images/yahoo_news_ona_250x250.png" width="250px" height="250px" />
					</a>
				</div>
				
				<?php dynamic_sidebar( 'home' ); ?>
			
			</div>
			
			<div class="right-col float-right ona11-latest-stories">
				<h3 class="section-title">Latest Updates</h3>
			<?php
				$args = array(
					'posts_per_page' => 6,
					'post__not_in' => $already_shown,
				);
				$latest_stories = new WP_Query( $args );
				
				if ( $latest_stories->have_posts() ):
				while ( $latest_stories->have_posts() ): $latest_stories->the_post();
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
							$sessions_text = '&mdash; <span class="entry-session">Session: ';
							foreach( $associated_posts as $associated_post ) {
								$sessions_text .= '<a href="' . get_permalink( $associated_post->ID ) . '">' . get_the_title( $associated_post->ID ) . '</a>, ';
							}
							$sessions_text = rtrim( $sessions_text, ', ' ) . '</span>';
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
					<?php if ( in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>
					<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3>
					<?php endif; ?>

					<?php if ( in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>		
					<div class="entry-meta"><span class="entry-author">By <?php ona11_author_posts_link(); ?></span> &mdash; <span class="entry-timestamp"><?php ona11_timestamp( 'long', false ); ?></span>
						<?php if ( $sessions_text ) echo $sessions_text; ?>
					</div>
					<?php endif; ?>		
					
					<?php if ( in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>
					<div class="entry-excerpt">
						<?php the_excerpt() ?>
					</div>
					<?php else: ?>
					<div class="entry-content">
						<?php the_content() ?>
					</div>
					<?php endif; ?>

					<?php if ( !in_array( $post_format, array( 'gallery', 'standard' ) ) ): ?>		
					<div class="entry-meta"><span class="entry-author">By <?php ona11_author_posts_link(); ?></span> &mdash; <a href="<?php the_permalink(); ?>"><?php echo ucfirst( $post_format ); ?></a> &mdash; <span class="entry-timestamp"><?php ona11_timestamp( 'long', false ); ?></span>
						<?php if ( $sessions_text ) echo $sessions_text; ?>	
					</div>
					<?php endif; ?>
									
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
	
</div>
	
<?php get_footer(); ?>