<?php
if (!function_exists('urna_settings_layout_section_advanced')) {
    function urna_settings_layout_section_advanced($widget, $args)
    {
        $widget->update_control(
            'space_between_widgets',
            [
                'default' => [
                    'size' => '0',
                ],
                'description' => esc_html__('Sets the default space between widgets (Default: 0)', 'urna'),
            ]
        );
        $widget->update_control(
            'page_title_selector',
            [
                'default' => 'h1.page-title',
                'placeholder' => 'h1.page-title',
                'description' => esc_html__('Elementor lets you hide the page title. This works for themes that have "h1.page-title" selector. If your theme\'s selector is different, please enter it above.', 'urna'),
            ]
        );
    }

    add_action('elementor/element/kit/section_settings-layout/before_section_end', 'urna_settings_layout_section_advanced', 10, 2);
}
