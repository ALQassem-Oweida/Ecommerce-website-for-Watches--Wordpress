<?php
/**
* ------------------------------------------------------------------------------------------------
* Urna products element map
* ------------------------------------------------------------------------------------------------
*/

if (!function_exists('urna_vc_map_tbay_productstabs')) {
    function urna_vc_map_tbay_productstabs()
    {
        $producttabs = array(
            array( 'recent_product', esc_html__('New Arrivals', 'urna') ),
            array( 'featured_product', esc_html__('Featured Products', 'urna') ),
            array( 'best_selling', esc_html__('BestSeller Products', 'urna') ),
            array( 'top_rate', esc_html__('TopRated Products', 'urna') ),
            array( 'on_sale', esc_html__('On Sale Products', 'urna') )
        );
        $layouts = array(
            'Grid'=>'grid',
            'Carousel'=>'carousel',
            'Vertical'=>'vertical'
        );

        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => esc_html__('Title', 'urna'),
                "param_name" => "title",
                "value" => ''
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
                'type' => 'autocomplete',
                'heading' => esc_html__('Categories', 'urna'),
                'value' => '',
                'param_name' => 'categories',
                "admin_label" => true,
                'description' => esc_html__('Choose categories if you want show products of them', 'urna'),
                'settings' => array(
                    'multiple' => true,
                    'min_length' => 1,
                    'unique_values' => true,
                    'display_inline' => true,
                    'delay' => 500,
                    'auto_focus' => true,
                ),

            ),
            array(
                "type" => "sorted_list",
                "heading" => esc_html__('Show Tab', 'urna'),
                "param_name" => "producttabs",
                "description" => esc_html__('Control teasers look. Enable blocks and place them in desired order.', 'urna'),
                "value" => "recent_product",
                "options" => $producttabs
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__('Layout Type', 'urna'),
                "param_name" => "layout_type",
                "value" => $layouts
            ),
            array(
                "type"          => "checkbox",
                "heading"       => esc_html__('Show Ajax Product Tabs?', 'urna'),
                "description"   => esc_html__('Show/hidden Ajax Product Tabs', 'urna'),
                "param_name"    => "ajax_tabs",
                "std"           => "",
                "value"         => array(
                                    esc_html__('Yes', 'urna') =>'yes' ),
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__('Number of products to show', 'urna'),
                "param_name" => "number",
                'std' => '4',
                "value" => '4'
            ),
        );

        $responsive     = apply_filters('urna_vc_map_param_responsive', array());
        $carousel 		= apply_filters('urna_vc_map_param_carousel', array());
        $last_params 	= apply_filters('urna_vc_map_param_last_params', array());

        $params = array_merge($params, $carousel, $responsive, $last_params);

        vc_map(array(
            "name" => esc_html__('Urna Products Tabs', 'urna'),
            "base" => "tbay_productstabs",
            "icon" 	   	  => "vc-icon-urna",
            'description'	=> esc_html__('Display BestSeller, TopRated ... Products In tabs', 'urna'),
            "class" => "",
            "category" => esc_html__('Urna Woocommerce', 'urna'),
            "params" => $params
        ));
    }
    add_action('vc_before_init', 'urna_vc_map_tbay_productstabs');
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_tbay_productstabs extends WPBakeryShortCode
    {
        public function getListQuery($atts)
        {
            $this->atts  = $atts;
            $list_query = array();
            $types = isset($this->atts['producttabs']) ? explode(',', $this->atts['producttabs']) : array();
            foreach ($types as $type) {
                $list_query[$type] = $this->getTabTitle($type);
            }
            return $list_query;
        }

        public function getTabTitle($type)
        {
            switch ($type) {
                case 'recent_product':
                    return array('title' => esc_html__('New Arrivals', 'urna'), 'title_tab'=>esc_html__('New Arrivals', 'urna'));
                case 'featured_product':
                    return array('title' => esc_html__('Featured', 'urna'), 'title_tab'=>esc_html__('Featured', 'urna'));
                case 'top_rate':
                    return array('title' => esc_html__('Top Rated', 'urna'), 'title_tab'=>esc_html__('Top Rated', 'urna'));
                case 'best_selling':
                    return array('title' => esc_html__('Best Seller', 'urna'), 'title_tab'=>esc_html__('Best Seller', 'urna'));
                case 'on_sale':
                    return array('title' => esc_html__('On Sale', 'urna'), 'title_tab'=>esc_html__('On Sale', 'urna'));
            }
        }
    }
}
