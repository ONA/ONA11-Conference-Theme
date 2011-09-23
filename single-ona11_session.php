<?php get_header(); ?>

<div class="main">
	
	<div class="wrap">
	
	<?php get_sidebar( 'single_session' ); ?>	

	<div class="content">
		
		<?php get_template_part( 'loop', 'single_session' ); ?>
		
		<?php get_template_part( 'loop', 'session_updates' ); ?>
		
	</div>
	
	</div>
	
</div>

<?php get_footer(); ?>