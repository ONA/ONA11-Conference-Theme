<?php get_header() ?>

	<div class="main">
		
		<div class="wrap">
			
		<?php get_sidebar(); ?>			
		
		<div class="content">

			<h2 class="page-title"><?php _e( 'Tag Archives:', 'sandbox' ) ?> <span><?php single_tag_title() ?></span></h2>

			<?php get_template_part( 'loop', 'index' ); ?>

		</div><!-- #content -->
		</div>
	</div><!-- #container -->

<?php get_footer() ?>