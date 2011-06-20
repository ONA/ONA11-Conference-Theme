<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ) ?></title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" />
<?php wp_head() // For plugins ?>
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />

<script type="text/javascript" src="http://use.typekit.com/fey8mly.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/twitter.js"></script>

</head>

<body class="<?php sandbox_body_class() ?>">

<div id="wrapper" class="hfeed">

	<div id="header">
<div class="center">
<a href="<?php bloginfo('home') ?>/" title="<?php echo wp_specialchars( get_bloginfo('name'), 1 ) ?>" rel="home"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/header.jpg"></a>
</div><!-- .center -->
	</div><!--  #header -->

<div id="menu">
<div class="center">
<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
<div class="ona-logo-menu"><a href="http://journalists.org/"><img src="http://ona11.journalists.org/wp-content/uploads/bg-ona-logo.gif" class="ona-logo-menu"></a></div><!-- .ona-logo-menu -->
</div><!-- .center -->
</div><!-- #menu -->