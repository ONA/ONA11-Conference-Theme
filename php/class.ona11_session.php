<?php
/**
 * class ona11_session
 * Handles session custom post type for the ONA11 theme
 * @author danielbachhuber
 */

if ( !class_exists( 'ona11_session' ) ) {
	
class ona11_session
{
	
	/**
	 * Load the class for the custom post type
	 */
	function __construct() {
		
		add_action( 'after_setup_theme', array( &$this, 'create_post_type' ) );
		
		// Load necessary scripts and stylesheets
		add_action( 'admin_enqueue_scripts', array( &$this, 'add_admin_resources' ) );
		
		// Set up metabox and related actions
		add_action( 'admin_menu', array( &$this, 'add_post_meta_boxes' ) );
		add_action( 'save_post', array( &$this, 'save_post_meta_box' ) );
		add_action( 'edit_post', array( &$this, 'save_post_meta_box' ) );
		add_action( 'publish_post', array( &$this, 'save_post_meta_box' ) );			
		
	}

	/**
	 * Register the custom post type for sessions
	 */
	function create_post_type() {

		register_post_type( 'ona11_session',
		    array(
				'labels' => array(
		        	'name' => 'Sessions',
					'singular_name' => 'Session',
						'add_new_item' => 'Add New Session',
						'edit_item' => 'Edit Session',
						'new_item' => 'New Session',
						'view' => 'View Session',
						'view_item' => 'View Session',
						'search_items' => 'Search Sessions',
						'not_found' => 'No sessions found',
						'not_found_in_trash' => 'No sessions found in Trash',
						'parent' => 'Parent Session'
				),
				'menu_position' => 6,
				'public' => true,
				'has_archive' => true,
				'rewrite' => array(
					'slug' => 'sessions',
					'feeds' => false,
					'with_front' => true
				),
				'supports' => array(
					'title',
					'comments',
					'thumbnail',
				),
		    )
		);
		
	} // END create_post_type
	
	/**
	 * Load scripts and styles that we need for the custom post type
	 */
	function add_admin_resources() {
		global $pagenow;
		
		// Only load scripts and styles on relevant pages in the WordPress admin
		if ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) {
			wp_enqueue_script( 'jquery_selectlist', get_bloginfo( 'template_url' ) . '/js/jquery.selectlist.js', array( 'jquery' ), ONA11_VERSION );
			wp_enqueue_script( 'ona11_jquery_ui_custom_js', get_bloginfo( 'template_url' ) . '/js/jquery-ui-1.8.13.custom.min.js', array( 'jquery', 'jquery-ui-core' ), ONA11_VERSION );
			wp_enqueue_script( 'ona11_jquery_timepicker_js', get_bloginfo( 'template_url' ) . '/js/jquery-ui-timepicker.0.9.5.js', array( 'jquery', 'jquery-ui-core', 'ona11_jquery_ui_custom_js' ), ONA11_VERSION );
			wp_enqueue_script( 'ona11_session_admin_js', get_bloginfo( 'template_url' ) . '/js/session_admin.js', array( 'jquery', 'jquery_selectlist' ), ONA11_VERSION );			
			wp_enqueue_style( 'ona11_session_admin_css', get_bloginfo( 'template_url' ) . '/css/session_admin.css', false, ONA11_VERSION, 'all' );
			wp_enqueue_style( 'ona11_jquery_ui_custom_css', get_bloginfo( 'template_url' ) . '/css/jquery-ui-1.8.13.custom.css', false, ONA11_VERSION, 'all' );			
		}
		
	}
	
	/**
	 * Add our post meta boxes to the theme
	 */
	function add_post_meta_boxes() {
		
		add_meta_box( 'ona11-session-information', 'Session Information', array( &$this, 'session_information_meta_box' ), 'ona11_session', 'normal', 'high');
		add_meta_box( 'ona11-session-date-time-location', 'Session Date, Time &amp; Location', array( &$this, 'date_time_location_meta_box' ), 'ona11_session', 'side', 'default');				
		remove_meta_box( 'ona11_locationsdiv', 'ona11_session', 'side' );
		
		if ( function_exists( 'p2p_register_connection_type' ) )
			add_meta_box( 'ona11-session-associated-posts', 'Associations', array( &$this, 'associated_posts_meta_box' ), 'ona11_session', 'side', 'default');		
		
	}
	
	function date_time_location_meta_box() {
		global $post;
		
		$time_format = 'm/d/y g:i A';
		$start_timestamp = get_post_meta( $post->ID, '_ona11_start_timestamp', true );
		$start_time = ( $start_timestamp ) ? date( $time_format, $start_timestamp ) : '';
			
		$end_timestamp = get_post_meta( $post->ID, '_ona11_end_timestamp', true );
		$end_time = ( $end_timestamp ) ? date( $time_format, $end_timestamp ) : '';
		
		$location_tax = wp_get_object_terms( $post->ID, 'ona11_locations', array( 'fields' => 'ids' ) );
		$location = ( !empty( $location_tax ) ) ? (int)$location_tax[0] : 0;
		
		?>
		<div class="inner">
			
		<div class="date-time-wrap option-item hide-if-no-js">
			
			<div class="line-item">
			<div class="pick-date">
				<label for="ona11-start" class="primary-label">Start<span class="required">*</span>:</label>
				<input id="ona11-start" name="ona11-start" class="ona11-date-picker" size="25" value="<?php echo esc_attr( $start_time ); ?>" />
			</div>
			</div><!-- END .line-item -->
			
			<div class="line-item">
			<div class="pick-date">
				<label for="ona11-end" class="primary-label">End<span class="required">*</span>:</label>
				<input id="ona11-end" name="ona11-end" class="ona11-date-picker" size="25" value="<?php echo esc_attr( $end_time ); ?>" />
			</div>
			</div><!-- END .line-item -->
			
			<div class="line-item pick-location">
				<label for="ona11-location">Location:</label>
				<?php
					$args = array(
						'name' => 'ona11-location',
						'taxonomy' => 'ona11_locations',
						'hide_if_empty' => true,
						'echo' => false,
						'hide_empty' => false,
						'hierarchical' => true,
						'show_option_none' => '-- Pick a Location --',
						'selected' => $location,
					);
					echo ( $location_dropdown = wp_dropdown_categories( $args ) ) ? $location_dropdown : 'Please register locations';
				?>
			</div>
			
			<div class="clear-both"></div>
		</div>
		</div>
		<?
	}
	
	/**
	 * Session information metabox
	 */
	function session_information_meta_box() {
		global $post;
		
		// post_content and post_excerpt are included in the post object
		
		$hashtag = get_post_meta( $post->ID, '_ona11_hashtag', true );
		
		?>
		
		<div class="inner">
			
			<div class="option-item">
				<h4>Full Description<span class="required">*</span>:</h4>
				<textarea id="content" name="content" rows="6" cols="60"><?php esc_html_e( $post->post_content ); ?></textarea>
				<p class="description">Basic HTML is allowed. This extended description appears on the single session page and can be as long as you'd like.</p>
			</div>
			
			<div class="option-item">
				<h4>Short Description:</h4>
				<textarea id="excerpt" name="excerpt" rows="2" cols="60"><?php esc_html_e( $post->post_excerpt ); ?></textarea>
				<p class="description">Basic HTML is allowed. If filled out, this short description will appear on pages other than the single session page. One to two sentences is a great length.</p>
			</div>
			
			<div class="session-active-wrap option-item">
				<h4>Details</h4>
				
				<div class="line-item">
					<label for="ona11-hashtag">Hashtag:</label>
					<input type="text" id="ona11-hashtag" name="ona11-hashtag" size="30" value="<?php esc_attr_e( $hashtag ); ?>" />
				</div>

			</div>
			
			<input type="hidden" id="ona11-session-nonce" name="ona11-session-nonce" value="<?php echo wp_create_nonce('ona11-session-nonce'); ?>" />
			
		</div><!-- END .inner -->
		
		<?php
		
	}
	
	/**
	 * Show posts that have been associated to this session
	 */
	function associated_posts_meta_box() {
		global $post, $wpdb;
		
		$query = $wpdb->prepare( "SELECT p2p_from FROM $wpdb->p2p WHERE p2p_to=$post->ID;" );
		$results = $wpdb->get_results( $query );
		
		echo "<p>Posts associated with this session:</p>";
		
		if ( count( $results ) ) {
			$post_ids = array();
			foreach( $results as $result )
				$post_ids[] = $result->p2p_from;
			$results_str = implode( ', ', $post_ids );
			$query = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE ID in(%s);", $results_str );
			$posts = $wpdb->get_results( $query );
			echo '<ul class="show-list">';
			foreach( $posts as $post ) {
				echo '<li><strong>' . esc_html( $post->post_title ) . '</strong>';
				echo ' <a href="' . get_edit_post_link( $post->ID ) . '">Edit</a> |';
				echo ' <a target="_blank" href="' . get_permalink( $post->ID ) . '">View</a>';				
				echo '</li>';
			}
			echo '</ul>';
		} else {
			?>
			<div class="message info">No posts have been associated with this session yet</div>
			<?php
		}
	}
	
	/**
	 * Save the data from our metaboxes
	 */
	function save_post_meta_box( $post_id ) {
		global $post, $ona11, $wpdb;
		
		if ( !isset( $_POST['ona11-session-nonce'] ) || !wp_verify_nonce( $_POST['ona11-session-nonce'], 'ona11-session-nonce' ) )
			return $post_id; 
		
		if ( wp_is_post_revision( $post ) || wp_is_post_autosave( $post ) )
			return $post_id;
			
		// Date, Time & Location settings to save
		$start_timestamp = strtotime( $_POST['ona11-start'] );
		update_post_meta( $post_id, '_ona11_start_timestamp', $start_timestamp );
		
		$end_timestamp = strtotime( $_POST['ona11-end'] );
		update_post_meta( $post_id, '_ona11_end_timestamp', $end_timestamp );
		
		$location = (int)$_POST['ona11-location'];
		wp_set_object_terms( $post_id, $location, 'ona11_locations' );		
		
		$hashtag = sanitize_title( $_POST['ona11-hashtag'] );
		update_post_meta( $post_id, '_ona11_hashtag', $hashtag );
		
	}
	
} // END class ona11_session
	
} // END if ( !class_exists( 'ona11_session' ) )

?>