<?php get_header(); ?>

	<div class="main">
		
		<div class="wrap">
			
		<?php get_sidebar(); ?>			
			
		<div class="content">
			
			<h2 class="page-title"><?php _e( 'Search Results for:', 'sandbox' ) ?><?php the_search_query() ?></h2>			

			<?php get_template_part( 'loop', 'index' ); ?>

		</div><!-- #content -->
		
		</div>
		
	</div><!-- #container -->

<?php get_footer() ?>