<?php get_header() ?>

	<div class="wrap">
		
		<div class="main">
			
		<?php get_sidebar(); ?>			
		
		<?php get_template_part( 'loop', 'page' ); ?>
		
		</div>
		
	</div><!-- #container -->
<?php get_footer() ?>