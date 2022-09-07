<?php
/**
 * Header manager for Thembay Elementor
 *
 * @package    tbay-elementor
 * @author     Team Thembays <thembayteam@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  2015-2016 Thembay Elementor
 */
 
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Tbay_PostType_Header {

  	public static function init() {
    	add_action( 'init', array( __CLASS__, 'register_post_type' ) );
    	add_action( 'init', array( __CLASS__, 'register_header_vc' ) );
    	add_action( 'admin_init', array( __CLASS__, 'add_role_caps' ) );
  	}

  	public static function register_post_type() {
	    $labels = array(
			'name'                  => __( 'Urna Header Elementor', 'urna-core' ),
			'singular_name'         => __( 'Header', 'urna-core' ),
			'add_new'               => __( 'Add New Header', 'urna-core' ),
			'add_new_item'          => __( 'Add New Header', 'urna-core' ),
			'edit_item'             => __( 'Edit Header', 'urna-core' ),
			'new_item'              => __( 'New Header', 'urna-core' ),
			'all_items'             => __( 'All Header ', 'urna-core' ),
			'view_item'             => __( 'View Header', 'urna-core' ),
			'search_items'          => __( 'Search Header', 'urna-core' ),
			'not_found'             => __( 'No Headers found', 'urna-core' ),
			'not_found_in_trash'    => __( 'No Headers found in Trash', 'urna-core' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Urna Header Elementor', 'urna-core' ),
	    );

	    $type = 'tbay_header';

	    register_post_type( $type,
	      	array(
		        'labels'            => apply_filters( 'tbay_postype_header_labels' , $labels ),
		        'supports'          => array( 'title', 'editor' ),
		        'public'            => true,
		        'has_archive'       => false,
		        'menu_icon' 		=> 'dashicons-welcome-widgets-menus',
		        'menu_position'     => 49,
				'capability_type'   => array($type,'{$type}s'),
				'map_meta_cap'      => true,	      	
			)
	    );

  	}

  	public static function add_role_caps() {
 
		 // Add the roles you'd like to administer the custom post types
		 $roles = array('administrator');

		 $type  = 'tbay_header';
		 
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
 

  	public static function register_header_vc() {
	    $options = get_option('wpb_js_content_types');
	    if ( is_array($options) && !in_array('tbay_header', $options) ) {
	      	$options[] = 'tbay_header';
	      	update_option( 'wpb_js_content_types', $options );
	    }
  	}
  
}

Tbay_PostType_Header::init();