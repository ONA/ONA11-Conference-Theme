<?php get_header(); ?>

<div class="main">
	
	<div class="wrap">
		
	<?php get_sidebar(); ?>		
	
	<div class="content">
		
		<?php get_template_part( 'loop', 'single' ); ?>
		
		<div id="nav-below" class="navigation">
			<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&laquo;</span> %title' ) ?></div>
			<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">&raquo;</span>' ) ?></div>
		</div>

		<?php comments_template(); ?>

	</div><!-- #content -->
	
	</div>
	
	</div><!-- #container -->
	
<?php get_footer(); ?>