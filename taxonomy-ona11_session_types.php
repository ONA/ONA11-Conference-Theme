<?php get_header(); ?>

<div class="main">
	
	<div class="wrap">
		
	<?php get_sidebar( 'archive_session' ); ?>
		
	<div class="content">				
		
	<?php get_template_part( 'loop', 'archive_session' ); ?>
	
	</div>
	
	</div>

</div>

<?php get_footer(); ?>