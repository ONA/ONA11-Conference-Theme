<?php get_header(); ?>

<div class="main">
	
	<div class="wrap">
	
	<?php get_sidebar( 'single_session' ); ?>	

	<div class="content">
		
		<?php get_template_part( 'loop', 'single_session' ); ?>
		
		<?php if ( ona11_p2p_enabled() ): ?>
		<?php get_template_part( 'loop', 'session_updates' ); ?>
		<?php endif; ?>
	</div>
	
	</div>
	
</div>

<?php get_footer(); ?>