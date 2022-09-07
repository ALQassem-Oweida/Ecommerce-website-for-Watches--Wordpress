<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Custom_Language')) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;

class Urna_Elementor_Custom_Language extends Urna_Elementor_Widget_Base
{
    public function get_name()
    {
        return 'tbay-custom-language';
    }

    public function get_title()
    {
        return esc_html__('Urna Language', 'urna');
    }

    public function get_icon()
    {
        return 'eicon-text-area';
    }

    public function get_categories()
    {
        return [ 'urna-elements', 'urna-header'];
    }

    protected function get_html_wrapper_class()
    {
        return 'w-auto elementor-widget-' . $this->get_name();
    }
       
    protected function urna_custom_language()
    {
        do_action('urna_tbay_header_custom_language');
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Style', 'urna'),
            ]
        );
        $this->add_control(
            'custom_language_size',
            [
                'label' => esc_html__('Font Size', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .list-item-wrapper a span' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_control(
            'custom_language_line_height',
            [
                'label' => esc_html__('Line Height', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .list-item-wrapper a span' => 'line-height: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_control(
            'color_text_custom_language',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .list-item-wrapper .select-button'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'hover_color_text_custom_language',
            [
                'label'     => esc_html__('Hover Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .list-item-wrapper .select-button:hover,{{WRAPPER}} .list-item-wrapper li:hover .select-button,
                    {{WRAPPER}} .list-item-wrapper .select-button:hover:after,{{WRAPPER}} .list-item-wrapper li:hover .select-button:after,
                    {{WRAPPER}} a:hover'    => 'color: {{VALUE}}',
                ],
            ]
        );
    
        $this->end_controls_section();
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Custom_Language());
