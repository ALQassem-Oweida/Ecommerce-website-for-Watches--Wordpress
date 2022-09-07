<?php
/**
 * mentor post type
 *
 * @package    urna-core
 * @author     TbayTheme <tbaythemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  30/04/2019 TbayTheme
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Tbay_PostType_CustomTab{

	/**
	 * init action and filter data to define resource post type
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_action( 'init', array( __CLASS__, 'definition_taxonomy' ) );
		add_action( 'admin_init', array( __CLASS__, 'add_role_caps' ) );	
	}
	/**
	 *
	 */
	public static function definition() {
		
		$labels = array(
			'name'                  => __( 'Urna Custom Tabs', 'urna-core' ),
			'singular_name'         => __( 'Custom Tab', 'urna-core' ),
			'add_new'               => __( 'Add New Custom Tab', 'urna-core' ),
			'add_new_item'          => __( 'Add New Custom Tab', 'urna-core' ),
			'edit_item'             => __( 'Edit Custom Tab', 'urna-core' ),
			'new_item'              => __( 'New Custom Tab', 'urna-core' ),
			'all_items'             => __( 'All Custom Tabs', 'urna-core' ),
			'view_item'             => __( 'View Custom Tab', 'urna-core' ),
			'search_items'          => __( 'Search Custom Tab', 'urna-core' ),
			'not_found'             => __( 'No Custom Tabs found', 'urna-core' ),
			'not_found_in_trash'    => __( 'No Custom Tabs found in Trash', 'urna-core' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Urna Custom Tabs', 'urna-core' ),
		);

		$labels = apply_filters( 'tbay_postype_custom_labels' , $labels );


		$type = 'tbay_customtab';
		register_post_type( 'tbay_customtab',
			array(
				'labels'            => $labels,
				'supports'          => array( 'title', 'editor' ),
				'public'            => true,
				'has_archive'       => false,
				'menu_icon' 		=> 'dashicons-grid-view',
				'menu_position'     => 54,
				'show_in_menu'  	=> true,
				'capability_type'   => array($type,'{$type}s'),
				'map_meta_cap'      => true,

			)
		);
	}

	public static function add_role_caps() { 
 
		 // Add the roles you'd like to administer the custom post types
		 $roles = array('administrator');

		 $type  = 'tbay_customtab';
		 
		 // Loop through each role and assign capabilities
		 foreach($roles as $the_role) { 

		    $role = get_role($the_role);
		 
			$role->add_cap( 'read' );
			$role->add_cap( 'read_{$type}');
			$role->add_cap( 'read_private_{$type}s' );
			$role->add_cap( 'edit_{$type}' );
			$role->add_cap( 'edit_{$type}s' );
			$role->add_cap( 'edit_others_{$type}s' );
			$role->add_cap( 'edit_published_{$type}s' );
			$role->add_cap( 'publish_{$type}s' );
			$role->add_cap( 'delete_others_{$type}s' );
			$role->add_cap( 'delete_private_{$type}s' ); 
			$role->add_cap( 'delete_published_{$type}s' );
		 }
	}

	public static function definition_taxonomy() {
		$labels = array(
			'name'              => __( 'Custom Tab Categories', 'urna-core' ),
			'singular_name'     => __( 'Custom Tab Category', 'urna-core' ),
			'search_items'      => __( 'Search Custom Tab Categories', 'urna-core' ),
			'all_items'         => __( 'All Custom Tab Categories', 'urna-core' ),
			'parent_item'       => __( 'Parent Custom Tab Category', 'urna-core' ),
			'parent_item_colon' => __( 'Parent Custom Tab Category:', 'urna-core' ),
			'edit_item'         => __( 'Edit Custom Tab Category', 'urna-core' ),
			'update_item'       => __( 'Update Custom Tab Category', 'urna-core' ),
			'add_new_item'      => __( 'Add New Custom Tab Category', 'urna-core' ),
			'new_item_name'     => __( 'New Custom Tab Category', 'urna-core' ),
			'menu_name'         => __( 'Custom Tab Categories', 'urna-core' ),
		);

		register_taxonomy( 'tbay_CustomTab_category', 'tbay_CustomTab', array(
			'labels'            => apply_filters( 'urna_core_taxomony_CustomTab_category_labels', $labels ),
			'hierarchical'      => true,
			'query_var'         => 'Custom Tab-category',
			'rewrite'           => array( 'slug' => __( 'Custom Tab-category', 'urna-core' ) ),
			'public'            => true,
			'show_ui'           => true,
		) );
	}
}

Tbay_PostType_CustomTab::init();