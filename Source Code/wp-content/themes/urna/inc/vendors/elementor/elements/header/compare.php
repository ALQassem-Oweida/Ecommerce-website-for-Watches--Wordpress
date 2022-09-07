<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Compare')) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;

class Urna_Elementor_Compare extends Urna_Elementor_Widget_Base
{
    public function get_name()
    {
        return 'tbay-compare';
    }

    public function get_title()
    {
        return esc_html__('Urna Compare', 'urna');
    }

    public function get_icon()
    {
        return 'eicon-sync';
    }

    public function get_categories()
    {
        return [ 'urna-elements', 'urna-header'];
    }

    protected function get_html_wrapper_class()
    {
        return 'w-auto elementor-widget-' . $this->get_name();
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'urna'),
            ]
        );

        $this->add_control(
            'icon_compare',
            [
                'label'              => esc_html__('Icon', 'urna'),
                'type'               => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'linear-icon-sync',
                    'library' => 'simple-line-icons',
                ],
            ]
        );
        $this->add_control(
            'show_title_compare',
            [
                'label'              => esc_html__('Display Title', 'urna'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control(
            'title_compare',
            [
                'label'              => esc_html__('Title', 'urna'),
                'type'               => Controls_Manager::TEXT,
                'default' => esc_html__('My Compare', 'urna'),
                'condition' => [
                    'show_title_compare' => 'yes'
                ]
            ]
        );
    
        $this->end_controls_section();
        $this->register_section_style_icon();
        $this->register_section_style_text();
    }

    private function register_section_style_icon()
    {
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Style Icon', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_compare_size',
            [
                'label' => esc_html__('Font Size Icon', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .element-btn-compare i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_style_icon');

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
            ]
        );
        $this->add_control(
            'color_icon',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-btn-compare i'    => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
            ]
        );
        $this->add_control(
            'hover_color_icon',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-btn-compare i:hover'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    private function register_section_style_text()
    {
        $this->start_controls_section(
            'section_style_text',
            [
                'label' => esc_html__('Style Text', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'compare_text_typography',
                'selector' => '{{WRAPPER}} .title-compare',
            ]
        );

        $this->add_responsive_control(
            'compare_text_margin',
            [
                'label' => esc_html__('Margin', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .title-compare' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_style_text');

        $this->start_controls_tab(
            'tab_text_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
            ]
        );
        $this->add_control(
            'color_text',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title-compare'    => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_text_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
            ]
        );
        $this->add_control(
            'hover_color_text',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title-compare:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    

    public function render_item_compare()
    {
        $settings = $this->get_settings();
        extract($settings);
        if (!class_exists('YITH_Woocompare')) {
            return;
        }

        global $yith_woocompare;

        $url_compare = 'javascript:void(0)';
        if ($yith_woocompare->is_frontend()) {
            $url_compare = $yith_woocompare->obj->view_table_url();
        }

        $this->add_render_attribute(
            'compare',
            [
                'class' => [ 'compare', 'added', 'element-btn-compare' ],
                'rel'   => 'nofollow',
                'href'  => $url_compare,
            ]
        ); ?>
        <div class="element-yith-compare product">
            <a <?php echo trim($this->get_render_attribute_string('compare')); ?>>
                <?php $this->render_item_icon($icon_compare); ?>
                <?php $this->render_item_title(); ?>
            </a>
        </div>
        <?php
    }

    private function render_item_title()
    {
        $settings = $this->get_settings();
        extract($settings);

        if ($show_title_compare !== 'yes' || !isset($title_compare) || empty($title_compare)) {
            return;
        } ?>
        <span class="title-compare"><?php echo trim($title_compare) ?></span>
        <?php
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Compare());
