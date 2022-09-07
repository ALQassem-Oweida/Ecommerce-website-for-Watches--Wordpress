<?php
/**
 * Brand manager for Urna Core
 *
 * @package    urna-core
 * @author     Team Thembays <tbaythemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  2015-2016 Urna Core
 */
 
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Tbay_PostType_Brand {

  	public static function init() {
    	add_action( 'init', array( __CLASS__, 'register_post_type' ) );
    	add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
    	add_action( 'admin_init', array( __CLASS__, 'add_role_caps' ) );
  	}

  	public static function register_post_type() {
	    $labels = array(
			'name'                  => __( 'Urna Brand', 'urna-core' ),
			'singular_name'         => __( 'Brand', 'urna-core' ),
			'add_new'               => __( 'Add New Brand', 'urna-core' ),
			'add_new_item'          => __( 'Add New Brand', 'urna-core' ),
			'edit_item'             => __( 'Edit Brand', 'urna-core' ),
			'new_item'              => __( 'New Brand', 'urna-core' ),
			'all_items'             => __( 'All Brands', 'urna-core' ),
			'view_item'             => __( 'View Brand', 'urna-core' ),
			'search_items'          => __( 'Search Brand', 'urna-core' ),
			'not_found'             => __( 'No Brands found', 'urna-core' ),
			'not_found_in_trash'    => __( 'No Brands found in Trash', 'urna-core' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Urna Brands', 'urna-core' ),
	    );

	    $type = 'tbay_brand';

	    register_post_type( $type,
	      	array(
		        'labels'            => apply_filters( 'tbay_postype_brand_labels' , $labels ),
		        'supports'          => array( 'title', 'thumbnail' ),
		        'public'            => true,
		        'has_archive'       => false,
		        'menu_icon' 		=> 'dashicons-clipboard',
		        'menu_position'     => 52,
				'capability_type'   => array($type,'{$type}s'),
				'map_meta_cap'      => true,
	      	)
	    );

  	}

  	public static function add_role_caps() {
 
		 // Add the roles you'd like to administer the custom post types
		 $roles = array('administrator');

		 $type  = 'tbay_brand';
		 
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
  	
  	public static function metaboxes(array $metaboxes){
		$prefix = 'tbay_brand_';
	    
	    $metaboxes[ $prefix . 'settings' ] = array(
			'id'                        => $prefix . 'settings',
			'title'                     => __( 'Brand Information', 'urna-core' ),
			'object_types'              => array( 'tbay_brand' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_fields()
		);

	    return $metaboxes;
	}

	public static function metaboxes_fields() {
		$prefix = 'tbay_brand_';
	
		$fields =  array(
			array(
				'name' => __( 'Brand Link', 'urna-core' ),
				'id'   => $prefix."link",
				'type' => 'text'
			)
		);  
		
		return apply_filters( 'urna_core_postype_tbay_brand_metaboxes_fields' , $fields );
	}
}

Tbay_PostType_Brand::init();