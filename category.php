<?php get_header() ?>

	<div class="main">
		
		<div class="wrap">
			
		<?php get_sidebar(); ?>			
		
		<div class="content">

			<h2 class="page-title"><?php single_cat_title() ?></h2>
			<?php if ( $queried_object->description ): ?>
			<div class="term-description">
			<?php echo wpautop( $queried_object->description ); ?>	
			</div>
			<?php endif; ?>

			<?php get_template_part( 'loop', 'index' ); ?>

		</div><!-- #content -->

		</div>

	</div><!-- #container -->
<?php get_footer() ?>