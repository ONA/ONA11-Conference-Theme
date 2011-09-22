<?php get_header(); ?>

<div class="main">
	
	<div class="wrap">
		
	<?php get_sidebar( 'archive_person' ); ?>
		
	<div class="content">				
		
	<?php get_template_part( 'loop', 'archive_person' ); ?>
	
	</div>
	
	</div>

</div>

<?php get_footer(); ?>