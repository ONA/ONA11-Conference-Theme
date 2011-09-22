<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="Latest Posts" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />

	<?php
		/**
		 * Stylesheets and Javascript is enqueued in functions.php
		 */
	?>

	<?php wp_head(); ?>
	
</head>

<body <?php body_class(); ?>>

<div class="primary-navigation">
	<div class="wrap">
	<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
	<div class="ona-logo-menu float-right"><a href="http://journalists.org/"><img src="<?php bloginfo('template_directory'); ?>/images/bg-ona-logo.gif" /></a></div>
	</div><!-- .center -->
</div><!-- #menu -->

<div id="wrapper">

	<div class="header">
		<div class="wrap">
			<?php if ( is_home() ): ?>
			<a href="<?php bloginfo('url') ?>/"><img height="331px" src="<?php bloginfo('template_directory'); ?>/images/header_h927.jpg" /></a>
			<?php else: ?>
			<a href="<?php bloginfo('url') ?>/"><img height="150px" src="<?php bloginfo('template_directory'); ?>/images/header_small_h930.png" /></a>	
			<?php endif; ?>
		</div>
	</div><!--	#header -->