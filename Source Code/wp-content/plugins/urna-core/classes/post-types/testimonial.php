<?php
/**
 * Testimonial manager for Urna Core
 *
 * @package    urna-core
 * @author     Team Thembays <tbaythemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  2015-2016 Urna Core
 */
 
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Tbay_PostType_Testimonial {

  	public static function init() {
    	add_action( 'init', array( __CLASS__, 'register_post_type' ) );
    	add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
    	add_action( 'admin_init', array( __CLASS__, 'add_role_caps' ) );
  	}

  	public static function register_post_type() {
	    $labels = array(
			'name'                  => __( 'Urna Testimonial', 'urna-core' ),
			'singular_name'         => __( 'Testimonial', 'urna-core' ),
			'add_new'               => __( 'Add New Testimonial', 'urna-core' ),
			'add_new_item'          => __( 'Add New Testimonial', 'urna-core' ),
			'edit_item'             => __( 'Edit Testimonial', 'urna-core' ),
			'new_item'              => __( 'New Testimonial', 'urna-core' ),
			'all_items'             => __( 'All Testimonials', 'urna-core' ),
			'view_item'             => __( 'View Testimonial', 'urna-core' ),
			'search_items'          => __( 'Search Testimonial', 'urna-core' ),
			'not_found'             => __( 'No Testimonials found', 'urna-core' ),
			'not_found_in_trash'    => __( 'No Testimonials found in Trash', 'urna-core' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Urna Testimonials', 'urna-core' ),
	    );

	    $type = 'tbay_testimonial';
	    register_post_type( $type,
	      	array(
		        'labels'            => apply_filters( 'tbay_postype_testimonial_labels' , $labels ),
		        'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		        'public'            => true,
		        'has_archive'       => false,
		        'menu_icon' 		=> 'dashicons-testimonial',
		        'menu_position'     => 53,
				'capability_type'   => array($type,'{$type}s'),
				'map_meta_cap'      => true,
	      	)
	    );

  	}

  	public static function add_role_caps() {
 
		 // Add the roles you'd like to administer the custom post types
		 $roles = array('administrator');

		 $type  = 'tbay_testimonial';
		 
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
		$prefix = 'tbay_testimonial_';
	    
	    $metaboxes[ $prefix . 'settings' ] = array(
			'id'                        => $prefix . 'settings',
			'title'                     => __( 'Testimonial Information', 'urna-core' ),
			'object_types'              => array( 'tbay_testimonial' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_fields()
		);

	    return $metaboxes;
	}

	public static function metaboxes_fields() {
		$prefix = 'tbay_testimonial_';
	
		$fields =  array(
			array(
	            'name' => __( 'Job', 'urna-core' ),
	            'id'   => "{$prefix}job",
	            'type' => 'text',
	            'description' => __('Enter Job example CEO, CTO','urna-core')
          	), 
			array(
				'name' => __( 'Testimonial Link', 'urna-core' ),
				'id'   => $prefix."link",
				'type' => 'text'
			)
		);  
		
		return apply_filters( 'urna_core_postype_tbay_testimonial_metaboxes_fields' , $fields );
	}
}

Tbay_PostType_Testimonial::init();