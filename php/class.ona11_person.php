<?php
/**
 * class ona11_person
 * Handles person custom post type for the ONA11 theme
 * @author danielbachhuber
 */

if ( !class_exists( 'ona11_person' ) ) {
	
class ona11_person
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
	 * Register the custom post type for a person
	 */
	function create_post_type() {

		register_post_type( 'ona11_person',
		    array(
				'labels' => array(
		        	'name' => 'Presenter',
					'singular_name' => 'Presenter',
						'add_new_item' => 'Add New Presenter',
						'edit_item' => 'Edit Presenter',
						'new_item' => 'New Presenter',
						'view' => 'View Presenter',
						'view_item' => 'View Presenter',
						'search_items' => 'Search Presenters',
						'not_found' => 'No presenters found',
						'not_found_in_trash' => 'No presenters found in Trash',
				),
				'menu_position' => 8,
				'public' => true,
				'has_archive' => true,
				'rewrite' => array(
					'slug' => 'presenters',
					'feeds' => false,
					'with_front' => true
				),
				'supports' => array(
					'title',
					'thumbnail',
				),
		    )
		);
		
	}
	
	/**
	 * Load scripts and styles that we need for the custom post type
	 */
	function add_admin_resources() {
		global $pagenow;
		
		
	}
	
	/**
	 * Add our post meta boxes to the theme
	 */
	function add_post_meta_boxes() {
		
		add_meta_box( 'ona11-person-information', 'Presenter Information', array( &$this, 'person_information_meta_box' ), 'ona11_person', 'normal', 'high');
		
		if ( function_exists( 'p2p_register_connection_type' ) )
			add_meta_box( 'ona11-person-associated-posts', 'Associations', array( &$this, 'associated_posts_meta_box' ), 'ona11_person', 'side', 'default');		
		
	}
	
	/**
	 * Person information metabox
	 */
	function person_information_meta_box() {
		global $post;
		
		// post_content are included in the post object
		
		$title = get_post_meta( $post->ID, '_ona11_person_title', true );
		$organization = get_post_meta( $post->ID, '_ona11_person_organization', true );	
		$twitter = get_post_meta( $post->ID, '_ona11_person_twitter', true );				
		
		?>
		
		<div class="inner">
			
			<div class="option-item">
				<h4>Title</h4>
				<input type="text" size="40" id="ona11-person-title" name="ona11-person-title" value="<?php echo $title; ?>" />
				<p class="description">No HTML is allowed.</p>
			</div>
			
			<div class="option-item">
				<h4>Organization</h4>
				<input type="text" size="40" id="ona11-person-organization" name="ona11-person-organization" value="<?php esc_html_e( $organization ); ?>" />
				<p class="description">Links are allowed but optional.</p>
			</div>
			
			<div class="option-item">
				<h4>Twitter Username</h4>
				<input type="text" size="40" id="ona11-person-twitter" name="ona11-person-twitter" value="<?php echo $twitter; ?>" />
				<p class="description">Just the username, no URL.</p>
			</div>			
			
			<div class="option-item">
				<h4>Full Biography<span class="required">*</span></h4>
				<textarea id="content" name="content" rows="8" cols="60"><?php esc_html_e( $post->post_content ); ?></textarea>
				<p class="description">Basic HTML is allowed. This extended bio appears on the single and all presenters pages.</p>
			</div>
			
			<input type="hidden" id="ona11-person-nonce" name="ona11-person-nonce" value="<?php echo wp_create_nonce('ona11-person-nonce'); ?>" />
			
		</div><!-- END .inner -->
		
		<?php
		
	}
	
	/**
	 * Show sessions that have been associated to this person
	 */
	function associated_posts_meta_box() {
		global $post, $wpdb;
		
		$query = $wpdb->prepare( "SELECT p2p_from FROM $wpdb->p2p WHERE p2p_to=$post->ID;" );
		$results = $wpdb->get_results( $query );
		
		echo "<p>Content associated with this person:</p>";
		
		if ( count( $results ) ) {
			$post_ids = array();
			foreach( $results as $result )
				$post_ids[] = $result->p2p_from;
			$results_str = implode( ', ', $post_ids );
			$query = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE ID in(%s);", $results_str );
			$associated_posts = $wpdb->get_results( $query );
			echo '<ul class="show-list">';
			foreach( $associated_posts as $associated_post ) {
				echo '<li><strong>' . esc_html( $associated_post->post_title ) . '</strong>';
				echo ' <a href="' . get_edit_post_link( $associated_post->ID ) . '">Edit</a> |';
				echo ' <a target="_blank" href="' . get_permalink( $associated_post->ID ) . '">View</a>';				
				echo '</li>';
			}
			echo '</ul>';
		} else {
			?>
			<div class="message info">No content has been associated with this person yet</div>
			<?php
		}
	}
	
	/**
	 * Save the data from our metaboxes
	 */
	function save_post_meta_box( $post_id ) {
		global $post, $ona11, $wpdb;
		
		if ( !isset( $_POST['ona11-person-nonce'] ) || !wp_verify_nonce( $_POST['ona11-person-nonce'], 'ona11-person-nonce' ) )
			return $post_id; 
		
		if ( wp_is_post_revision( $post ) || wp_is_post_autosave( $post ) )
			return $post_id;

		// Save our metabox data
		
		$title = strip_tags( $_POST['ona11-person-title'] );
		update_post_meta( $post_id, '_ona11_person_title', $title );
		
		$organization = strip_tags( $_POST['ona11-person-organization'], '<a>' );
		update_post_meta( $post_id, '_ona11_person_organization', $organization );	
		
		$twitter = sanitize_key( $_POST['ona11-person-twitter'] );
		update_post_meta( $post_id, '_ona11_person_twitter', $twitter );			
		
	}
	
}
	
}

?>