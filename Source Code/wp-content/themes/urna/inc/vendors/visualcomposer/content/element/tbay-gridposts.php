<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna grid posts element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_tbay_post_get_categories')) {
    function urna_tbay_post_get_categories()
    {
        $return = array( esc_html__('--- Choose a Category ---', 'urna') );

        $args = array(
            'type' => 'post',
            'child_of' => 0,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => false,
            'hierarchical' => 1,
            'taxonomy' => 'category'
        );

        $categories = get_categories($args);

        urna_tbay_get_category_post_childs($categories, 0, 0, $return);



        return $return;
    }
}

if (!function_exists('urna_tbay_get_category_post_childs')) {
    function urna_tbay_get_category_post_childs($categories, $id_parent, $level, &$dropdown)
    {
        foreach ($categories as $key => $category) {
            if ($category->category_parent == $id_parent) {
                $dropdown = array_merge($dropdown, array( str_repeat("- ", $level) . $category->name . ' (' .$category->count .')' => $category->term_id ));
                unset($categories[$key]);
                urna_tbay_get_category_post_childs($categories, $category->term_id, $level + 1, $dropdown);
            }
        }
    }
}

if (!function_exists('urna_vc_map_tbay_gridposts')) {
    function urna_vc_map_tbay_gridposts()
    {
        $categories = urna_tbay_post_get_categories();
 
        $params = array(
            array(
                'type' => 'textfield',
                "holder" => "div",
                'heading' => esc_html__('Title', 'urna'),
                'param_name' => 'title',
                'description' => esc_html__('Enter text which will be used as widget title. Leave blank if no title is needed.', 'urna'),
                "admin_label" => true
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__('Sub Title', 'urna'),
                "param_name" => "subtitle",
                "admin_label" => true
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Categories', 'urna'),
                "param_name" => "category",
                "value" => $categories,
                "admin_label" => true
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Thumbnail size', 'urna'),
                'param_name' => 'thumbsize',
                'std' => 'thumbnail',
                'description' => esc_html__('Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'urna')
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Number of post to show', 'urna'),
                "param_name" => "number",
                "value" => '6'
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Layout Type', 'urna'),
                "param_name" => "layout_type",
                "value" => urna_tbay_get_blog_layouts(),
                "admin_label" => true
            ),
            array(
                "type" 			=> "checkbox",
                "heading" 		=> esc_html__('Show Categories', 'urna'),
                "description" 	=> esc_html__('Show/hidden categories of post', 'urna'),
                "param_name" 	=> "show_category_post",
                "std"       	=> "yes",
                "value" 		=> array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
                'dependency' 	=> array(
                        'element' 	 			 => 'layout_type',
                        'value_not_equal_to' 	 => 'vertical'
                ),
            ),
            array(
                "type" 			=> "checkbox",
                "heading" 		=> esc_html__('Show Short Description', 'urna'),
                "description" 	=> esc_html__('Show/hidden short description', 'urna'),
                "param_name" 	=> "show_description_post",
                "value" 		=> array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
                'dependency' 	=> array(
                        'element' 	 			 => 'layout_type',
                        'value_not_equal_to' 	 => 'vertical'
                ),
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Number string description show', 'urna'),
                "param_name" => "description_number",
                "value" => '15',
                'dependency' 	=> array(
                        'element' 	 			 => 'layout_type',
                        'value_not_equal_to' 	 => 'vertical'
                ),
            ),

            // Data settings
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Order by', 'urna'),
                'param_name' => 'orderby',
                'value' => array(
                    esc_html__('Date', 'urna') => 'date',
                    esc_html__('Order by post ID', 'urna') => 'ID',
                    esc_html__('Author', 'urna') => 'author',
                    esc_html__('Title', 'urna') => 'title',
                    esc_html__('Last modified date', 'urna') => 'modified',
                    esc_html__('Random order', 'urna') => 'rand',
                ),
                'description' => esc_html__('Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'urna'),
                'group' => esc_html__('Data Settings', 'urna'),
                'param_holder_class' => 'vc_grid-data-type-not-ids',
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Sort order', 'urna'),
                'param_name' => 'order',
                'group' => esc_html__('Data Settings', 'urna'),
                'value' => array(
                    esc_html__('Descending', 'urna') => 'DESC',
                    esc_html__('Ascending', 'urna') => 'ASC',
                ),
                'param_holder_class' => 'vc_grid-data-type-not-ids',
                'description' => esc_html__('Select sorting order.', 'urna'),
            ),
        );

        $responsive     = apply_filters('urna_vc_map_param_responsive', array());
        $carousel 		= apply_filters('urna_vc_map_param_carousel', array());
        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());

        $params = array_merge($params, $carousel, $responsive, $last_params);

        vc_map(array(
            'name' => esc_html__('Urna Grid Posts', 'urna'),
            'base' => 'tbay_gridposts',
            "icon" 	   	  => "vc-icon-urna",
            "category" => esc_html__('Urna Elements', 'urna'),
            'description' => esc_html__('Create Post having blog styles', 'urna'),
            'params' => $params,
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_gridposts');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_gridposts extends WPBakeryShortCode
    {
    }
}
