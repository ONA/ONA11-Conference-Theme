<?php
/**
 * class ona11_quote
 * Handles quote custom post type for the ONA11 theme
 * @author danielbachhuber
 */

if ( !class_exists( 'ona11_quote' ) ) {
	
class ona11_quote
{
	
	/**
	 * Load the class for the custom post type
	 */
	function __construct() {
		
		add_action( 'after_setup_theme', array( &$this, 'create_post_type' ) );

		// Set up metabox and related actions
		add_action( 'admin_menu', array( &$this, 'add_post_meta_boxes' ) );		
		
	}

	/**
	 * Register the custom post type for a person
	 */
	function create_post_type() {

		register_post_type( 'ona11_quote',
		    array(
				'labels' => array(
		        	'name' => 'Quotes',
						'singular_name' => 'Quote',
						'add_new_item' => 'Add New Quote',
						'edit_item' => 'Edit Quote',
						'new_item' => 'New Quote',
						'view' => 'View Quote',
						'view_item' => 'View Quote',
						'search_items' => 'Search Quotes',
						'not_found' => 'No quotes found',
						'not_found_in_trash' => 'No quotes found in Trash',
				),
				'menu_position' => 9,
				'public' => true,
				'has_archive' => true,
				'rewrite' => array(
					'slug' => 'quotes',
					'feeds' => false,
					'with_front' => true
				),
				'supports' => array(
					'thumbnail',
				),
		    )
		);
		
	}
	
	/**
	 * Add our post meta boxes to the theme
	 */
	function add_post_meta_boxes() {
		add_meta_box( 'ona11-quote', 'Quote', array( &$this, 'post_meta_box' ), 'ona11_quote', 'normal', 'high' );
		add_meta_box( 'ona11-instructions', 'Instructions', array( &$this, 'instructions_meta_box' ), 'ona11_quote', 'normal', 'default' );		
	}
	
	/**
	 * Session information metabox
	 */
	function post_meta_box() {
		global $post;
		// post_content is included in the post object
		?>
		<h4>What was the notable quote?</h4>
			<textarea id="content" name="content" rows="8" cols="60"><?php esc_html_e( $post->post_content ); ?></textarea>
			<p class="description">Basic HTML is allowed, and no quotation marks are necessary.</p>
		<?php
	}
	
	function instructions_meta_box() {
		?>
		
		<p>To publish a quote, you'll want to:</p>
		<ol>
			<li>Enter the quote in the box above. Feel free to include links and other HTML formatting; no quotation marks are necessary.</li>
			<li>Associate the quote with one or more session using the meta box to the right. This will ensure the quote is pulled into appropriate places in the theme.</li</li>
			<li>Associate the quote with one or more people using the meta box to the right. This will ensure the quote is pulled into appropriate places in the theme.</li>
			<li>Hit publish!</li>
		</ol>
		
		<?php
	}
	
}
	
}

?>