<?php
if (!function_exists('urna_tbay_page_metaboxes')) {
    function urna_tbay_page_metaboxes(array $metaboxes)
    {
        global $wp_registered_sidebars;
        $sidebars = array();

        if (!empty($wp_registered_sidebars)) {
            foreach ($wp_registered_sidebars as $sidebar) {
                $sidebars[$sidebar['id']] = $sidebar['name'];
            }
        }

        $footers = array_merge(array('global' => esc_html__('Global Setting', 'urna')), urna_tbay_get_footer_layouts());


        $prefix = 'tbay_page_';
        $fields = array(
            array(
                'name' => esc_html__('Select Layout', 'urna'),
                'id'   => $prefix.'layout',
                'type' => 'select',
                'options' => array(
                    'main' => esc_html__('Main Content Only', 'urna'),
                    'left-main' => esc_html__('Left Sidebar - Main Content', 'urna'),
                    'main-right' => esc_html__('Main Content - Right Sidebar', 'urna'),
                    'left-main-right' => esc_html__('Left Sidebar - Main Content - Right Sidebar', 'urna')
                )
            ),
            array(
                'id' => $prefix.'left_sidebar',
                'type' => 'select',
                'name' => esc_html__('Left Sidebar', 'urna'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'right_sidebar',
                'type' => 'select',
                'name' => esc_html__('Right Sidebar', 'urna'),
                'options' => $sidebars
            ),
            array(
                'id' => $prefix.'show_breadcrumb',
                'type' => 'select',
                'name' => esc_html__('Show Breadcrumb?', 'urna'),
                'options' => array(
                    'no' => esc_html__('No', 'urna'),
                    'yes' => esc_html__('Yes', 'urna')
                ),
                'default' => 'yes',
            ),
            array(
                'name' => esc_html__('Select Breadcrumbs Layout', 'urna'),
                'id'   => $prefix.'breadcrumbs_layout',
                'type' => 'select',
                'options' => array(
                    'image' => esc_html__('Background Image', 'urna'),
                    'color' => esc_html__('Background color', 'urna'),
                    'text' => esc_html__('Just text', 'urna')
                ),
                'default' => 'color',
            ),
            array(
                'id' => $prefix.'breadcrumb_color',
                'type' => 'colorpicker',
                'name' => esc_html__('Breadcrumb Background Color', 'urna')
            ),
            array(
                'id' => $prefix.'breadcrumb_image',
                'type' => 'file',
                'name' => esc_html__('Breadcrumb Background Image', 'urna')
            ),
        );

        $after_array = array(
            array(
                'id' => $prefix.'footer_type',
                'type' => 'select',
                'name' => esc_html__('Footer Layout Type', 'urna'),
                'description' => esc_html__('Choose a footer for your website.', 'urna'),
                'options' => $footers,
                'default' => 'global'
            ),
            array(
                'id' => $prefix.'extra_class',
                'type' => 'text',
                'name' => esc_html__('Extra Class', 'urna'),
                'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'urna')
            )
        );
        $fields = array_merge($fields, $after_array);
        
        $metaboxes[$prefix . 'display_setting'] = array(
            'id'                        => $prefix . 'display_setting',
            'title'                     => esc_html__('Display Settings', 'urna'),
            'object_types'              => array( 'page' ),
            'context'                   => 'normal',
            'priority'                  => 'high',
            'show_names'                => true,
            'fields'                    => $fields
        );

        return $metaboxes;
    }
}
add_filter('cmb2_meta_boxes', 'urna_tbay_page_metaboxes');

if (!function_exists('urna_tbay_cmb2_style')) {
    function urna_tbay_cmb2_style()
    {
        wp_enqueue_style('urna-cmb2-style', URNA_THEME_DIR . '/inc/vendors/cmb2/assets/style.css', array(), '1.0');
    }
}
add_action('admin_enqueue_scripts', 'urna_tbay_cmb2_style');
