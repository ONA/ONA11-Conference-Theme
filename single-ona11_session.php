<?php get_header(); ?>

<div class="main">
	
	<div class="wrap">
	
	<?php get_sidebar( 'single_session' ); ?>	

	<div class="content">
		
		<?php get_template_part( 'loop', 'single_session' ); ?>
		
	</div>
	
	</div>
	
</div>

<?php get_footer(); ?>