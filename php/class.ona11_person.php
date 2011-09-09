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
		//add_action( 'save_post', array( &$this, 'save_post_meta_box' ) );
		//add_action( 'edit_post', array( &$this, 'save_post_meta_box' ) );
		//add_action( 'publish_post', array( &$this, 'save_post_meta_box' ) );			
		
	}

	/**
	 * Register the custom post type for a person
	 */
	function create_post_type() {

		register_post_type( 'ona11_person',
		    array(
				'labels' => array(
		        	'name' => 'People',
					'singular_name' => 'Person',
						'add_new_item' => 'Add New Person',
						'edit_item' => 'Edit Person',
						'new_item' => 'New Person',
						'view' => 'View Person',
						'view_item' => 'View Person',
						'search_items' => 'Search People',
						'not_found' => 'No people found',
						'not_found_in_trash' => 'No people found in Trash',
				),
				'menu_position' => 8,
				'public' => true,
				'has_archive' => true,
				'rewrite' => array(
					'slug' => 'people',
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
		
	}
	
}
	
}

?>