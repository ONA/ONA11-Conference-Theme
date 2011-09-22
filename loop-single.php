<?php if ( have_posts() ): ?>
	
<?php while ( have_posts() ): the_post(); ?>

	<div id="post-<?php the_ID() ?>" <?php post_class() ?>>
		<h2 class="entry-title"><?php the_title() ?></h2>
		
		<div class="entry-meta"><span class="entry-author">By <?php ona11_author_posts_link(); ?></span> &mdash; <span class="entry-timestamp"><?php ona11_timestamp(); ?></span></div>
		
		<div class="entry-content">
			<?php the_content() ?>
		</div>
		
		<?php if ( function_exists( 'get_coauthors' ) ): ?>
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