<?php

if (!function_exists('urna_render_element_child_border')) {
    function urna_render_element_child_border($widget)
    {
        $settings = $widget->get_settings_for_display();
        if (!isset($settings['enable_element_child_border'])) {
            return;
        }

        if ($settings['enable_element_child_border'] === '') {
            return;
        }

        $is_dom_optimization_active = \Elementor\Plugin::$instance->experiments->is_feature_active('e_dom_optimization');
        if ($is_dom_optimization_active) {
            $widget->add_render_attribute('_widget_wrapper', 'class', 'column-element-child-border');
        } else {
            $widget->add_render_attribute('_inner_wrapper', 'class', 'column-element-child-border');
        }
    }

    add_action('elementor/frontend/column/before_render', 'urna_render_element_child_border', 10, 2);
}
