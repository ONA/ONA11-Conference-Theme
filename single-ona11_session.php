<?php get_header(); ?>

<div id="container">

	<div class="content">
		
		<?php get_template_part( 'loop', 'single_session' ); ?>
		
	</div>

	<?php get_sidebar( 'single_session' ); ?>
	
</div>

<?php get_footer(); ?>