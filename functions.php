<?php

define( 'ONA11_VERSION', '1.0.5' );

require_once( 'php/class.ona11_session.php' );
require_once( 'php/class.ona11_person.php' );
require_once( 'php/widgets.php' );

if ( !class_exists( 'ona11' ) ) {
	
class ona11
{
	
	var $theme_taxonomies = array();
	var $options_group = 'ona11_';
	var $options_group_name = 'ona11_options';
	var $settings_page = 'ona11_settings';
	
	var $livestreams = array(
		'keynote' => '<iframe width="560" height="340" src="http://cdn.livestream.com/embed/onlinenewsassociation?layout=4&amp;height=340&amp;width=560&amp;autoplay=false" style="border:0;outline:0" frameborder="0" scrolling="no"></iframe>',
		'track-1' => '<iframe width="560" height="340" src="http://cdn.livestream.com/embed/onlinenewsassociation?layout=4&amp;height=340&amp;width=560&amp;autoplay=false" style="border:0;outline:0" frameborder="0" scrolling="no"></iframe>',
		'track-2' => '<iframe width="560" height="340" src="http://cdn.livestream.com/embed/ona09frontendsessions?layout=4&amp;height=340&amp;width=560&amp;autoplay=false" style="border:0;outline:0" frameborder="0" scrolling="no"></iframe>',
		'track-3' => '<iframe width="560" height="340" src="http://cdn.livestream.com/embed/ona09backendsessions?layout=4&amp;height=340&amp;width=560&amp;autoplay=false" style="border:0;outline:0" frameborder="0" scrolling="no"></iframe>',
	);
	
	function __construct() {
		
		$this->session = new ona11_session();
		$this->person = new ona11_person();
		
		add_theme_support( 'post-thumbnails' );
		$formats = array(
			'gallery',
			'aside',
			'quote',
			'status',
			'image',
			'video',
			'audio',
		);
		add_theme_support( 'post-formats', $formats );
		add_image_size( 'home-featured', 400, 300, true );
		add_image_size( 'small-square', 64, 64, true );				
				
		add_action( 'after_setup_theme', array( &$this, 'register_custom_taxonomies' ) );
		add_action( 'after_setup_theme', array( &$this, 'associate_post_types' ) );
		add_action( 'after_setup_theme', array( &$this, 'register_menus' ) );
		add_action( 'after_setup_theme', array( &$this, 'register_sidebars' ) );
		add_action( 'widgets_init', array( &$this, 'action_widgets_init' ) );
		add_action( 'admin_bar_menu', array( &$this, 'action_admin_bar_menu' ), 200 );	
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_resources' ) );
		add_action( 'zoninator_pre_init', array( &$this, 'zoninator_pre_init' ) );
		add_shortcode( 'storify', array( &$this, 'storify_shortcode' ) );
		
		//add_filter( 'post_gallery', array( &$this, 'post_gallery' ) );	
		
		if ( !is_admin() ) {
			require_once( 'php/template_tags.php' );
			add_action( 'wp_head', 'ona11_head_title' );
			add_action( 'wp_head', array( &$this, 'wp_head' ) );
			add_action( 'wp_footer', array( &$this, 'wp_footer' ) );						
		}
		
	}
	
	/**
	 * Enqueue any resources we need
	 */
	function enqueue_resources() {
		if ( !is_admin() ) {
			wp_enqueue_style( 'ona11_primary_css', get_bloginfo('stylesheet_url'), false, ONA11_VERSION );
			if ( is_home() )
				wp_enqueue_style( 'ona11_home_css', get_bloginfo('template_directory') . '/css/home.css', false, ONA11_VERSION );			
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'ona11', get_bloginfo( 'template_directory' ) . '/js/ona11.js', array( 'jquery' ), ONA11_VERSION );
			wp_enqueue_script( 'ona11_twitter', get_bloginfo( 'template_directory' ) . '/js/twitter.js', array( 'jquery' ), ONA11_VERSION );
			if ( is_category( 'newsroom' ) )
				wp_enqueue_script( 'jquery-masonry', get_bloginfo( 'template_directory' ) . '/js/jquery.masonry.min.js', array( 'jquery' ), ONA11_VERSION );			
		} else {
			wp_enqueue_style( 'ona_admin_css', get_bloginfo( 'template_url' ) . '/css/admin.css', false, ONA11_VERSION, 'all' );
		}
	}
	
	/**
	 * Zoninato
	 */
	function zoninator_pre_init() {
		add_post_type_support( 'ona11_session', 'zoninator_zones' );
	}
	
	/**
	 * Register any menus we need
	 */
	function register_menus() {
		register_nav_menus(
			array('header-menu' => __( 'Header Menu' ) )
		);
	}
	
	/**
	 * Register the different sidebar zones we have
	 */
	function register_sidebars() {
		
		// Register a widget for the homepage
		$args = array(
			'name' => __( 'Home Page' ),
			'id' => 'home',
			'description' => __( 'Home Page for the ONA11 website' ),
			'before_widget' => '<div class="widget home-page">',
			'after_widget' => '</div>',
		);
		register_sidebar( $args );
		
	}
 	
	/**
	 * Register the custom widgets we have
	 */
	function action_widgets_init() {
		
		register_widget( 'ONA11_Twitter_Widget' );
		register_widget( 'ONA11_Location_Widget' );
		
	}
	
	/**
	 * Modifications to be made to the admin bar
	 */
	function action_admin_bar_menu() {
		global $wp_admin_bar;
		
		$wp_admin_bar->remove_menu( 'new-theme' );
		$wp_admin_bar->remove_menu( 'new-plugin' );
		
		if ( current_user_can( 'edit_published_posts' ) ) {
			$args = array(
				'id' => 'zoninator',
				'title' => __( 'Zoninator' ),
				'href' => add_query_arg( 'page', 'zoninator', get_admin_url( null, 'admin.php' ) ),
				'parent' => 'appearance',
			);
			$wp_admin_bar->add_menu( $args );
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
				'search_items' => 'Search Locations',
				'all_items' => 'All Locations',
				'parent_item' => 'Parent Location',
				'parent_item_colon' => 'Parent Location:',
				'edit_item' => 'Edit Location',
				'update_item' => 'Update Location',
				'add_new_item' => 'Add New Location',
				'new_item_name' => 'New Location',
				'menu_name' => 'Locations',
			),
			'hierarchical' => true,
			'show_tagcloud' => false,
			'rewrite' => array(
				'slug' => 'locations',
				'hierarchical' => true,
			),
		);

		$post_types = array(
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
	 * Storify shortcode
	 * Example: [storify url="http://storify.com/ugonnaokpalaoka/10-techier-trendier-tech-trends"]
	 */
	function storify_shortcode( $atts ) {
		extract( $atts );
		
		if ( !preg_match( '/^http\:\/\/storify\.com/', $url ) )
			return;
		
		return '<script src="' . $url . '.js"></script>';
	}
	
	/**
	 * Other resources to add to the head
	 */
	function wp_head() {
		echo '<script type="text/javascript" src="http://use.typekit.com/fey8mly.js"></script>';
		echo '<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
	}
	
	/**
	 * Load Masonry in the footer
	 */
	function wp_footer() {
		?>
		<script type="text/javascript">
		
		jQuery(document).ready(function(){
			jQuery('.newsroom-updates').masonry({
				// options
				itemSelector : '.post',
			});
		});
		
		</script>
		<?php
	}
	
	function post_gallery( $attr ) {
		global $post;
		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( !$attr['orderby'] )
				unset( $attr['orderby'] );
		}

		extract(shortcode_atts(array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post->ID,
			'itemtag'    => 'dl',
			'icontag'    => 'dt',
			'captiontag' => 'dd',
			'columns'    => 3,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => ''
		), $attr));

		$id = intval($id);
		if ( 'RAND' == $order )
			$orderby = 'none';

		if ( !empty($include) ) {
			$include = preg_replace( '/[^0-9,]+/', '', $include );
			$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( !empty($exclude) ) {
			$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
			$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		} else {
			$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		}

		if ( empty($attachments) )
			return '';

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
			return $output;
		}

		$itemtag = tag_escape($itemtag);
		$captiontag = tag_escape($captiontag);
		$columns = intval($columns);
		$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
		$float = is_rtl() ? 'right' : 'left';

		$selector = "gallery-{$instance}";

		$gallery_style = $gallery_div = '';
		if ( apply_filters( 'use_default_gallery_style', true ) )
			$gallery_style = "
			<style type='text/css'>
				#{$selector} {
					margin: auto;
				}
				#{$selector} .gallery-item {
					float: {$float};
					margin-top: 10px;
					text-align: center;
					width: {$itemwidth}%;
				}
				#{$selector} img {
					border: 2px solid #cfcfcf;
				}
				#{$selector} .gallery-caption {
					margin-left: 0;
				}
			</style>
			<!-- see gallery_shortcode() in wp-includes/media.php -->";
		$size_class = sanitize_html_class( $size );
		$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
		$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

		var_dump( 'y' );
		$i = 0;
		foreach ( $attachments as $id => $attachment ) {
			$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

			$output .= "<{$itemtag} class='gallery-item'>";
			$output .= "
				<{$icontag} class='gallery-icon'>
					$link
				</{$icontag}>";
			if ( $captiontag && trim($attachment->post_excerpt) ) {
				$output .= "
					<{$captiontag} class='wp-caption-text gallery-caption'>
					" . wptexturize($attachment->post_excerpt) . "
					</{$captiontag}>";
			}
			$output .= "</{$itemtag}>";
		}

		$output .= "
			</div>\n";
			
		return $output;
	}
	
}	
	
}

global $ona11;
$ona11 = new ona11();

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
