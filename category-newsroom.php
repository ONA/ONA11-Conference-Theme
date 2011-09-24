<?php get_header(); ?>

<div class="main">
	
	<div class="wrap">
	
	<div class="content full-width">
	
	<?php
		$args = array(
			'posts_per_page' => -1,
			'order' => 'ASC',
			'category_name' => 'newsroom',
		);
		$newsroom_posts = new WP_Query( $args );
	?>
	<?php if ( $newsroom_posts->have_posts() ): ?>
		<h2>Newsroom Coverage</h2>
		<?php $queried_object = get_queried_object(); ?>
		<?php if ( $queried_object->description ): ?>
		<div class="term-description">
		<?php echo wpautop( $queried_object->description ); ?>	
		</div>
		<?php endif; ?>
		<div class="newsroom-updates">
	<?php while( $newsroom_posts->have_posts() ): $newsroom_posts->the_post(); ?>
	<?php	
		$post_format = get_post_format();
		if ( !$post_format )
			$post_format = 'standard';
?>
	<div id="post-<?php the_id(); ?>" <?php post_class(); ?>>	
		<?php if ( has_post_thumbnail() ) {
			echo '<a href="' . get_permalink() . '">';
			the_post_thumbnail( 'medium' );
			echo '</a>';
		}
		?>				
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
		
	<?php endwhile; ?>
	
		</div>
	
	<?php endif; ?>
	
	<div class="clear-left"></div>
	
	</div>
	
	</div>
	
</div>

<?php get_footer(); ?>