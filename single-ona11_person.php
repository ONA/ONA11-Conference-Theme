<?php get_header(); ?>

<div class="main">
	
	<div class="wrap">
	
	<?php get_sidebar( 'single_person' ); ?>	

	<div class="content">
		
		<?php get_template_part( 'loop', 'single_person' ); ?>
		
	</div>
	
	<div class="clear-both"></div>
	
	</div>
	
</div>

<?php get_footer(); ?>