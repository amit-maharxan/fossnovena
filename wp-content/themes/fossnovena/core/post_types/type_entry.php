<?php

class foss_entry_post_type {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'foss_entry_init' ), 0 );
	}

	/**
	 * Register the custom post type
	 */
	public function foss_entry_init() {
	    $labels = array(
	        'name'               => _x( 'Entry', 'Post type general name', 'foss_entry' ),
	        'singular_name'      => _x( 'Entry', 'Post type singular name', 'foss_entry' ),
	        'menu_name'          => _x( 'Entry', 'Admin Menu text', 'foss_entry' ),
	        'name_admin_bar'     => _x( 'Entry', 'Add New on Toolbar', 'foss_entry' ),
	        'add_new'            => __( 'Add New', 'foss_entry' ),
	        'add_new_item'       => __( 'Add Entry', 'foss_entry' ),
	        'edit_item'          => __( 'Edit Entry', 'foss_entry' ),
	        'new_item'           => __( 'New Entry', 'foss_entry' ),
	        'view_item'          => __( 'View Entry', 'foss_entry' ),
	        'all_items'          => __( 'All Entry', 'foss_entry' ),
	        'search_items'       => __( 'Search Entry', 'foss_entry' ),
	        'not_found'          => __( 'No Entry found.', 'foss_entry' ),
	        'not_found_in_trash' => __( 'No Entry found in Trash.', 'foss_entry' ),
	    );

	    $args = array(
	        'labels'             => $labels,
	        'public'             => true,
	        'publicly_queryable' => true,
	        'show_ui'            => true,
	        'show_in_menu'       => true,
	        'query_var'          => true,
	        'rewrite'            => array( 'slug' => 'entry' ),
	        'capability_type'    => 'post',
	        'has_archive'        => true,
	        'hierarchical'       => false,
	        'menu_position'      => null,
	        'supports'           => array( 'title', 'custom-fields' ),
	        'menu_icon'          => 'dashicons-marker',
	    );

	    register_post_type( 'entry', $args );
	}
	
}
new foss_entry_post_type();