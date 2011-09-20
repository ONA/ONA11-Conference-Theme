<?php get_header() ?>

	<div class="main">
		
		<div class="wrap">
			
		<?php get_sidebar(); ?>			
		
		<div class="content">

			<h2 class="page-title"><?php single_cat_title() ?></h2>
			<?php $categorydesc = category_description(); if ( !empty($categorydesc) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>

			<?php get_template_part( 'loop', 'archive' ); ?>

		</div><!-- #content -->

		</div>

	</div><!-- #container -->
<?php get_footer() ?>