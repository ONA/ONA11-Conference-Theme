<?php

define( 'ONA11_VERSION', '1.0' );

require_once( 'php/class.ona11_session.php' );
require_once( 'php/class.ona11_person.php' );

if ( !class_exists( 'ona11' ) ) {
	
class ona11
{
	
	var $theme_taxonomies = array();
	var $options_group = 'ona11_';
	var $options_group_name = 'ona11_options';
	var $settings_page = 'ona11_settings';
	
	function __construct() {
		
		$this->session = new ona11_session();
		$this->person = new ona11_person();
				
		add_action( 'after_setup_theme', array( &$this, 'enqueue_resources' ) );
		add_action( 'after_setup_theme', array( &$this, 'register_custom_taxonomies' ) );
		add_action( 'after_setup_theme', array( &$this, 'associate_post_types' ) );
		
		if ( !is_admin() ) {
			require_once( 'php/template_tags.php' );
			add_action( 'wp_head', 'ona11_head_title' );
			add_action( 'wp_head', array( &$this, 'wp_head' ) );			
		}
		
	}
	
	/**
	 * Enqueue any resources we need
	 */
	function enqueue_resources() {
		if ( !is_admin() ) {
			wp_enqueue_style( 'ona11_primary_css', get_bloginfo('stylesheet_url'), false, ONA11_VERSION );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'ona11', get_bloginfo( 'template_directory' ) . '/js/ona11.js', array( 'jquery' ), ONA11_VERSION );
			wp_enqueue_script( 'ona11_twitter', get_bloginfo( 'template_directory' ) . '/js/twitter.js', array( 'jquery' ), ONA11_VERSION );
		} else {
			wp_enqueue_style( 'ona_admin_css', get_bloginfo( 'template_url' ) . '/css/admin.css', false, ONA11_VERSION, 'all' );
		}
	}
	
	/**
	 * Register the custom taxonomies we're using
	 */
	function register_custom_taxonomies() {
		
		// Register the Locations taxonomy
		$args = array(
			'label' => 'Locations',
			'labels' => array(
				'name' => 'Locations',
				'singular_name' => 'Location',
			),
			'hierarchical' => true,
			'show_tagcloud' => false,
			'rewrite' => array(
				'slug' => 'locations',
				'hierarchical' => true,
			),
		);

		$post_types = array(
			'post',
			'ona11_session',
		);
		register_taxonomy( 'ona11_locations', $post_types, $args );
		$this->theme_taxonomies[] = 'ona11_locations';
		
		// Register the Locations taxonomy
		$args = array(
			'label' => 'Session Types',
			'labels' => array(
				'name' => 'Session Types',
				'singular_name' => 'Session Type',
				'search_items' => 'Search Session Types',
				'all_items' => 'All Session Types',
				'parent_item' => 'Parent Session Type',
				'parent_item_colon' => 'Parent Session Type:',
				'edit_item' => 'Edit Session Type',
				'update_item' => 'Update Session Type',
				'add_new_item' => 'Add New Session Type',
				'new_item_name' => 'New Session Type',
				'menu_name' => 'Session Types',
			),
			'hierarchical' => true,
			'show_tagcloud' => false,
			'rewrite' => array(
				'slug' => 'session-type',
				'hierarchical' => true,
			),
		);

		$post_types = array(
			'post',
			'ona11_session',
		);
		register_taxonomy( 'ona11_session_types', $post_types, $args );
		$this->theme_taxonomies[] = 'ona11_session_types';		
		
	}
	
	function associate_post_types() {
		if ( !function_exists( 'p2p_register_connection_type' ) )
	        return;

		// Writers should be able to associate posts with sessions
	    p2p_register_connection_type( array( 
			'from' => 'post',
	        'to' => 'ona11_session'
	    ) );
	
		// Sessions should be able to have speakers
		p2p_register_connection_type( array( 
			'from' => 'ona11_session',
	        'to' => 'ona11_person'
	    ) );
		
	}
	
	/**
	 * Other resources to add to the head
	 */
	function wp_head() {
		echo '<script type="text/javascript" src="http://use.typekit.com/fey8mly.js"></script>';
		echo '<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
	}
	
}	
	
}

global $ona11;
$ona11 = new ona11();

// Produces a list of pages in the header without whitespace
function sandbox_globalnav() {
	if ( $menu = str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages('title_li=&sort_column=menu_order&echo=0') ) )
		$menu = '<ul>' . $menu . '</ul>';
	$menu = '<div id="menu">' . $menu . "</div>\n";
	echo apply_filters( 'globalnav_menu', $menu ); // Filter to override default globalnav: globalnav_menu
}

// Adds custom menu support
function register_my_menus() {
  register_nav_menus(
    array('header-menu' => __( 'Header Menu' ) )
  );
}

add_action( 'init', 'register_my_menus' );

// Define the num val for 'alt' classes (in post DIV and comment LI)
$sandbox_post_alt = 1;

// Generates semantic classes for each comment LI element
function sandbox_comment_class( $print = true ) {
	global $comment, $post, $sandbox_comment_alt;

	// Collects the comment type (comment, trackback),
	$c = array( $comment->comment_type );

	// Counts trackbacks (t[n]) or comments (c[n])
	if ( $comment->comment_type == 'comment' ) {
		$c[] = "c$sandbox_comment_alt";
	} else {
		$c[] = "t$sandbox_comment_alt";
	}

	// If the comment author has an id (registered), then print the log in name
	if ( $comment->user_id > 0 ) {
		$user = get_userdata($comment->user_id);
		// For all registered users, 'byuser'; to specificy the registered user, 'commentauthor+[log in name]'
		$c[] = 'byuser comment-author-' . sanitize_title_with_dashes(strtolower( $user->user_login ));
		// For comment authors who are the author of the post
		if ( $comment->user_id === $post->post_author )
			$c[] = 'bypostauthor';
	}

	// If it's the other to the every, then add 'alt' class; collects time- and date-based classes
	sandbox_date_classes( mysql2date( 'U', $comment->comment_date ), $c, 'c-' );
	if ( ++$sandbox_comment_alt % 2 )
		$c[] = 'alt';

	// Separates classes with a single space, collates classes for comment LI
	$c = join( ' ', apply_filters( 'comment_class', $c ) ); // Available filter: comment_class

	// Tada again!
	return $print ? print($c) : $c;
}

// Generates time- and date-based classes for BODY, post DIVs, and comment LIs; relative to GMT (UTC)
function sandbox_date_classes( $t, &$c, $p = '' ) {
	$t = $t + ( get_option('gmt_offset') * 3600 );
	$c[] = $p . 'y' . gmdate( 'Y', $t ); // Year
	$c[] = $p . 'm' . gmdate( 'm', $t ); // Month
	$c[] = $p . 'd' . gmdate( 'd', $t ); // Day
	$c[] = $p . 'h' . gmdate( 'H', $t ); // Hour
}

// For category lists on category archives: Returns other categories except the current one (redundant)
function sandbox_cats_meow($glue) {
	$current_cat = single_cat_title( '', false );
	$separator = "\n";
	$cats = explode( $separator, get_the_category_list($separator) );
	foreach ( $cats as $i => $str ) {
		if ( strstr( $str, ">$current_cat<" ) ) {
			unset($cats[$i]);
			break;
		}
	}
	if ( empty($cats) )
		return false;

	return trim(join( $glue, $cats ));
}

// For tag lists on tag archives: Returns other tags except the current one (redundant)
function sandbox_tag_ur_it($glue) {
	$current_tag = single_tag_title( '', '',  false );
	$separator = "\n";
	$tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
	foreach ( $tags as $i => $str ) {
		if ( strstr( $str, ">$current_tag<" ) ) {
			unset($tags[$i]);
			break;
		}
	}
	if ( empty($tags) )
		return false;

	return trim(join( $glue, $tags ));
}

// Produces an avatar image with the hCard-compliant photo class
function sandbox_commenter_link() {
	$commenter = get_comment_author_link();
	if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
		$commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	} else {
		$commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	}
	$avatar_email = get_comment_author_email();
	$avatar_size = apply_filters( 'avatar_size', '32' ); // Available filter: avatar_size
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, $avatar_size ) );
	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
}

// Widget: Search; to match the Sandbox style and replace Widget plugin default
function widget_sandbox_search($args) {
	extract($args);
	$options = get_option('widget_sandbox_search');
	$title = empty($options['title']) ? __( 'Search', 'sandbox' ) : attribute_escape($options['title']);
	$button = empty($options['button']) ? __( 'Find', 'sandbox' ) : attribute_escape($options['button']);
?>
			<?php echo $before_widget ?>
				<?php echo $before_title ?><label for="s"><?php echo $title ?></label><?php echo $after_title ?>
				<form id="searchform" class="blog-search" method="get" action="<?php bloginfo('home') ?>">
					<div>
						<input id="s" name="s" type="text" class="text" value="<?php the_search_query() ?>" size="10" tabindex="1" />
						<input type="submit" class="button" value="<?php echo $button ?>" tabindex="2" />
					</div>
				</form>
			<?php echo $after_widget ?>
<?php
}

// Widget: Search; element controls for customizing text within Widget plugin
function widget_sandbox_search_control() {
	$options = $newoptions = get_option('widget_sandbox_search');
	if ( $_POST['search-submit'] ) {
		$newoptions['title'] = strip_tags(stripslashes( $_POST['search-title']));
		$newoptions['button'] = strip_tags(stripslashes( $_POST['search-button']));
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option( 'widget_sandbox_search', $options );
	}
	$title = attribute_escape($options['title']);
	$button = attribute_escape($options['button']);
?>
	<p><label for="search-title"><?php _e( 'Title:', 'sandbox' ) ?> <input class="widefat" id="search-title" name="search-title" type="text" value="<?php echo $title; ?>" /></label></p>
	<p><label for="search-button"><?php _e( 'Button Text:', 'sandbox' ) ?> <input class="widefat" id="search-button" name="search-button" type="text" value="<?php echo $button; ?>" /></label></p>
	<input type="hidden" id="search-submit" name="search-submit" value="1" />
<?php
}

// Widget: Meta; to match the Sandbox style and replace Widget plugin default
function widget_sandbox_meta($args) {
	extract($args);
	$options = get_option('widget_meta');
	$title = empty($options['title']) ? __( 'Meta', 'sandbox' ) : attribute_escape($options['title']);
?>
			<?php echo $before_widget; ?>
				<?php echo $before_title . $title . $after_title; ?>
				<ul>
					<?php wp_register() ?>

					<li><?php wp_loginout() ?></li>
					<?php wp_meta() ?>

				</ul>
			<?php echo $after_widget; ?>
<?php
}

// Widget: RSS links; to match the Sandbox style
function widget_sandbox_rsslinks($args) {
	extract($args);
	$options = get_option('widget_sandbox_rsslinks');
	$title = empty($options['title']) ? __( 'RSS Links', 'sandbox' ) : attribute_escape($options['title']);
?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<li><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo esc_html( get_bloginfo('name'), 1 ) ?> <?php _e( 'Posts RSS feed', 'sandbox' ); ?>" rel="alternate" type="application/rss+xml"><?php _e( 'All posts', 'sandbox' ) ?></a></li>
				<li><a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo esc_html(bloginfo('name'), 1) ?> <?php _e( 'Comments RSS feed', 'sandbox' ); ?>" rel="alternate" type="application/rss+xml"><?php _e( 'All comments', 'sandbox' ) ?></a></li>
			</ul>
		<?php echo $after_widget; ?>
<?php
}

// Widget: RSS links; element controls for customizing text within Widget plugin
function widget_sandbox_rsslinks_control() {
	$options = $newoptions = get_option('widget_sandbox_rsslinks');
	if ( $_POST['rsslinks-submit'] ) {
		$newoptions['title'] = strip_tags( stripslashes( $_POST['rsslinks-title'] ) );
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option( 'widget_sandbox_rsslinks', $options );
	}
	$title = attribute_escape($options['title']);
?>
	<p><label for="rsslinks-title"><?php _e( 'Title:', 'sandbox' ) ?> <input class="widefat" id="rsslinks-title" name="rsslinks-title" type="text" value="<?php echo $title; ?>" /></label></p>
	<input type="hidden" id="rsslinks-submit" name="rsslinks-submit" value="1" />
<?php
}

// Widgets plugin: intializes the plugin after the widgets above have passed snuff
function sandbox_widgets_init() {
	if ( !function_exists('register_sidebars') )
		return;

	// Formats the Sandbox widgets, adding readability-improving whitespace
	$p = array(
		'before_widget'  =>   "\n\t\t\t" . '<li id="%1$s" class="widget %2$s">',
		'after_widget'   =>   "\n\t\t\t</li>\n",
		'before_title'   =>   "\n\t\t\t\t". '<h3 class="widgettitle">',
		'after_title'    =>   "</h3>\n"
	);

	// Table for how many? Two? This way, please.
	register_sidebars( 2, $p );

	// Finished intializing Widgets plugin, now let's load the Sandbox default widgets; first, Sandbox search widget
	$widget_ops = array(
		'classname'    =>  'widget_search',
		'description'  =>  __( "A search form for your blog (Sandbox)", "sandbox" )
	);
	wp_register_sidebar_widget( 'search', __( 'Search', 'sandbox' ), 'widget_sandbox_search', $widget_ops );
	wp_unregister_widget_control('search'); // We're being Sandbox-specific; remove WP default
	wp_register_widget_control( 'search', __( 'Search', 'sandbox' ), 'widget_sandbox_search_control' );

	// Sandbox Meta widget
	$widget_ops = array(
		'classname'    =>  'widget_meta',
		'description'  =>  __( "Log in/out and administration links (Sandbox)", "sandbox" )
	);
	wp_register_sidebar_widget( 'meta', __( 'Meta', 'sandbox' ), 'widget_sandbox_meta', $widget_ops );
	wp_unregister_widget_control('meta'); // We're being Sandbox-specific; remove WP default
	wp_register_widget_control( 'meta', __( 'Meta', 'sandbox' ), 'wp_widget_meta_control' );

	//Sandbox RSS Links widget
	$widget_ops = array(
		'classname'    =>  'widget_rss_links',
		'description'  =>  __( "RSS links for both posts and comments (Sandbox)", "sandbox" )
	);
	wp_register_sidebar_widget( 'rss_links', __( 'RSS Links', 'sandbox' ), 'widget_sandbox_rsslinks', $widget_ops );
	wp_register_widget_control( 'rss_links', __( 'RSS Links', 'sandbox' ), 'widget_sandbox_rsslinks_control' );
}

// Translate, if applicable
load_theme_textdomain('sandbox');

// Runs our code at the end to check that everything needed has loaded
add_action( 'init', 'sandbox_widgets_init' );

// Adds filters for the description/meta content in archives.php
add_filter( 'archive_meta', 'wptexturize' );
add_filter( 'archive_meta', 'convert_smilies' );
add_filter( 'archive_meta', 'convert_chars' );
add_filter( 'archive_meta', 'wpautop' );

// Remember: the Sandbox is for play.
?>