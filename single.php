<?php get_header(); ?>

<div class="main">
	
	<div class="wrap">
		
	<?php get_sidebar(); ?>		
	
	<div class="content">
		
		<?php get_template_part( 'loop', 'single' ); ?>
		
		<div id="nav-below" class="navigation align-center">
			<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&laquo;</span> Previous' ) ?></span>
			<span class="nav-next"><?php next_post_link( '%link', 'Next <span class="meta-nav">&raquo;</span>' ) ?></span>
		</div>

		<?php comments_template(); ?>

	</div><!-- #content -->
	
	</div>
	
	</div><!-- #container -->
	
<?php get_footer(); ?>