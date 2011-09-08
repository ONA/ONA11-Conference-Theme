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
		
		add_action( 'init', array( &$this, 'create_post_type' ) );
		
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
					'editor',
					'comments',
					'excerpt',
					'thumbnail',
					'revisions',
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
		
		add_meta_box( 'ona11-session', 'Session Information', array( &$this, 'post_meta_box' ), 'ona11_session', 'normal', 'high');
		add_meta_box( 'ona11-session-date-time-location', 'Date, Time &amp; Location', array( &$this, 'date_time_location_meta_box' ), 'ona11_session', 'side', 'high');
		
	}
	
	function date_time_location_meta_box() {
		global $post;
		
		$time_format = 'm/d/y g:i A';
		$start_timestamp = get_post_meta( $post->ID, '_ona11_start_timestamp', true );
		$start_time = ( $start_timestamp ) ? date( $time_format, $start_timestamp ) : '';
			
		$end_timestamp = get_post_meta( $post->ID, '_ona11_end_timestamp', true );
		$end_time = ( $end_timestamp ) ? date( $time_format, $end_timestamp ) : '';
		
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
			
			<div class="clear-both"></div>
		</div>
		</div>
		<?
	}
	
	/**
	 * Session information metabox
	 */
	function post_meta_box() {
		global $post;

		$session_active = get_post_meta( $post->ID, '_ona11_session_active', true );
		if ( $session_active != 'off' )
			$session_active = 'on';	
		
		?>
		
		<div class="inner">
			
			<div class="session-active-wrap option-item">
				<div class="line-item">
					<label for="ona11-session-active">This session is:</label>
					<select id="ona11-session-active" name="ona11-session-active">
						<option value="on"<?php if ( $session_active == 'on' ) { echo ' selected="selected"'; } ?>>Active, and should be visible across the site</option>
						<option value="off"<?php if ( $session_active == 'off' ) { echo ' selected="selected"'; } ?>>Inactive, and should be hidden</option>
					</select>
				</div>
			</div>
			
			<div class="presenters-wrap option-item hide-if-no-js">
			
			<h4>Presenters(s)</h4>
					
				<p>tk</p>
				<div class="clear-both"></div>
			
			</div><!-- END .instructors-wrap -->
				
			
			<div class="location option-item">
				
				<h4>Location</h4>
				
				<?php
					/* $args = array(
						'hide_empty' => false,
						'taxonomy' => 'cunyjcamp_locations',
						'name' => 'cunyjcamp-locations[]',
						'id' => 'cunyjcamp-locations',
						'hierarchical' => true,
						'depth' => 2,
						'class' => 'term-selector',
						'selected' => $event_location,
						'echo' => true,
					);
					wp_dropdown_categories( $args ); */
				?>
				<p>Tk</p>
				
				<div class="clear-both"></div>
				
			</div>
			
			<input type="hidden" id="ona11-session-nonce" name="ona11-session-nonce" value="<?php echo wp_create_nonce('ona11-session-nonce'); ?>" />
			
		</div><!-- END .inner -->
		
		<?php
		
	} // END post_meta_box()
	
	/**
	 * Save the data from our metaboxes
	 */
	function save_post_meta_box( $post_id ) {
		global $post, $ona11;
		
		if ( !isset( $_POST['ona11-session-nonce'] ) || !wp_verify_nonce( $_POST['ona11-session-nonce'], 'ona11-session-nonce' ) )
			return $post_id; 
		
		if ( wp_is_post_revision( $post ) || wp_is_post_autosave( $post ) )
			return $post_id;
			
		$session_active = $_POST['ona11-session-active'];
		if ( $session_active != 'off' )
			$session_active = 'on';
		update_post_meta( $post_id, '_ona11_session_active', $session_active );
		
		$start_timestamp = strtotime( $_POST['ona11-start'] );
		update_post_meta( $post_id, '_ona11_start_timestamp', $start_timestamp );
		
		$end_timestamp = strtotime( $_POST['ona11-end'] );
		update_post_meta( $post_id, '_ona11_end_timestamp', $end_timestamp );			
		
	}
	
} // END class ona11_session
	
} // END if ( !class_exists( 'ona11_session' ) )

?>