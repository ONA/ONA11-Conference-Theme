<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ) ?></title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />

	<?php
		/**
		 * Stylesheets and Javascript is enqueued in functions.php
		 */
	?>

	<?php wp_head(); ?>
	
</head>

<body <?php body_class(); ?>>

<div id="wrapper">

	<div id="header">
		<div class="center">
			<a href="<?php bloginfo('home') ?>/">
				<img src="<?php bloginfo('template_directory'); ?>/images/header_h927.jpg">
			</a>
		</div><!-- .center -->
	</div><!--	#header -->

<div id="menu">
	<div class="center">
		<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
		<div class="ona-logo-menu float-right"><a href="http://journalists.org/"><img src="<?php bloginfo('template_directory'); ?>/images/bg-ona-logo.gif"></a></div>
	</div><!-- .center -->
</div><!-- #menu -->