<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Newsletter')) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;

class Urna_Elementor_Newsletter extends Urna_Elementor_Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve icon box widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'tbay-newsletter';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Urna newsletter', 'urna');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-mail';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {
        $this->register_controls_heading();
        $this->register_remove_heading_element();

        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__('General', 'urna'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'mailchip_align',
            [
                'label'     => esc_html__('Alignment Form', 'urna'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start'   => [
                        'title' => esc_html__('Left', 'urna'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'urna'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'flex-end'  => [
                        'title' => esc_html__('Right', 'urna'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'separator' => 'after',
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-newsletter' => 'justify-content: {{VALUE}}; flex-direction: row;',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'heading_width',
            [
                'label'      => esc_html__('Heading Width', 'urna'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 900,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-addon-newsletter .tbay-addon-title' => 'width: {{SIZE}}{{UNIT}}; flex: unset;',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_width',
            [
                'label'      => esc_html__('Form Width', 'urna'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 900,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'separator' => 'after',
                'selectors'  => [
                    '{{WRAPPER}} .tbay-addon-newsletter .tbay-addon-content' => 'width: {{SIZE}}{{UNIT}}; flex: unset;',
                ],
            ]
        );


        $this->add_responsive_control(
            'form_style_block',
            [
                'label'        => esc_html__('Form Style Block', 'urna'),
                'type'         => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'urna'),
                'label_on'  => esc_html__('On', 'urna'),
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-newsletter .input-group' => 'display: flex; flex-direction: column;',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_style_inline',
            [
                'label'        => esc_html__('Form Style Inline', 'urna'),
                'type'         => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'urna'),
                'label_on'  => esc_html__('On', 'urna'),
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-newsletter .input-group' => 'display: flex; flex-direction: row;',
                ],
            ]
        );

        $this->add_control(
            'heading_button',
            [
                'label' => esc_html__('Button', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'text_hide',
            [
                'label'     => esc_html__('Show/Hide text', 'urna'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'none'  => [
                        'title' => esc_html__('Hide', 'urna'),
                        'icon'  => 'linear-icon-eye-crossed',
                    ],
                    'inline-flex'   => [
                        'title' => esc_html__('Show', 'urna'),
                        'icon'  => 'linear-icon-eye',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-newsletter button span' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_hide',
            [
                'label'     => esc_html__('Show/Hide icon', 'urna'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'none'  => [
                        'title' => esc_html__('Hide', 'urna'),
                        'icon'  => 'linear-icon-eye-crossed',
                    ],
                    'inline-flex'   => [
                        'title' => esc_html__('Show', 'urna'),
                        'icon'  => 'linear-icon-eye',
                    ],
                ],
                'separator' => 'after',
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-newsletter i' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->register_style_mailchip_email();
        $this->register_style_mailchip_button();
        $this->register_update_title_styles();
        $this->register_update_sub_title_styles();
    }

    private function register_style_mailchip_email()
    {
        //Email
        $this->start_controls_section(
            'mailchip_style_email',
            [
                'label' => esc_html__('Email', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        

        $this->add_responsive_control(
            'width_email',
            [
                'label'      => esc_html__('Width', 'urna'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 900,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-addon-newsletter input[type="email"]' => 'width: {{SIZE}}{{UNIT}}; flex: unset;',
                ],
            ]
        );

        $this->add_responsive_control(
            'mailchip_style_email_height',
            [
                'label'      => esc_html__('Height', 'urna'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-addon-newsletter input[type="email"]' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'mailchip_style_email_typography',
                'selector' => '{{WRAPPER}} .tbay-addon-newsletter input[type="email"]',
            ]
        );

        $this->add_control(
            'mailchip_style_email_color',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-newsletter input[type="email"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mailchip_style_email_placeholder_color',
            [
                'label'     => esc_html__('Placeholder Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-newsletter ::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tbay-addon-newsletter ::-moz-placeholder'          => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tbay-addon-newsletter ::-ms-input-placeholder'     => 'color: {{VALUE}};',
                ],
            ]
        );

        
        $this->add_control(
            'mailchip_style_email_background',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-newsletter input[type="email"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mailchip_style_email_align_input',
            [
                'label'     => esc_html__('Alignment', 'urna'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'urna'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'urna'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'urna'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-newsletter input[type="email"]' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'mailchip_style_email_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tbay-addon-newsletter input[type="email"]',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'mailchip_style_email_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'urna'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-addon-newsletter input[type="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mailchip_style_email_padding',
            [
                'label'      => esc_html__('Padding', 'urna'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-addon-newsletter input[type="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mailchip_style_email_margin',
            [
                'label'      => esc_html__('Margin', 'urna'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-addon-newsletter input[type="email"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function register_style_mailchip_button()
    {
        //Button
        $this->start_controls_section(
            'mailchip_style_button',
            [
                'label' => esc_html__('Button', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        
        $this->add_responsive_control(
            'mailchip_style_button_width',
            [
                'label'      => esc_html__('Buton width', 'urna'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-addon-newsletter button[type="submit"]' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mailchip_style_button_height',
            [
                'label'      => esc_html__('Buton Height', 'urna'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-addon-newsletter button[type="submit"]' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'mailchip_style_button_typography',
                'selector' => '{{WRAPPER}} .tbay-addon-newsletter button[type="submit"]',
            ]
        );

                
        $this->add_responsive_control(
            'mailchip_style_button_align_input',
            [
                'label'     => esc_html__('Alignment', 'urna'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'urna'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'urna'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'urna'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-newsletter button[type="submit"]' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'mailchip_style_tab_button_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
            ]
        );

        $this->add_control(
            'mailchip_style_button_color',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-newsletter button[type="submit"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mailchip_style_button_bacground',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-newsletter button[type="submit"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mailchip_style_tab_button_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
            ]
        );

        $this->add_control(
            'mailchip_style_button_color_hover',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-newsletter button[type="submit"]:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mailchip_style_button_bacground_hover',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-newsletter button[type="submit"]:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'mailchip_style_border_button',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tbay-addon-newsletter button[type="submit"]',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'mailchip_style_button_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'urna'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-addon-newsletter button[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mailchip_style_button_padding',
            [
                'label'      => esc_html__('Padding', 'urna'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-addon-newsletter button[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mailchip_style_button_margin',
            [
                'label'      => esc_html__('Margin', 'urna'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-addon-newsletter button[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mailchip_style_heading_button_icon',
            [
                'label' => esc_html__('Icon', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_responsive_control(
            'mailchip_style_icon_font_size',
            [
                'label'      => esc_html__('Font-size Icon', 'urna'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 8,
                        'max' => 60,
                    ],
                ],
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}}  .tbay-addon-newsletter i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mailchip_style_icon_margin',
            [
                'label'      => esc_html__('Margin Icon', 'urna'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-addon-newsletter i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function register_update_title_styles()
    {
        $this->update_control(
            'heading_title_color',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->update_control(
            'heading_title_color_hover',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        
        $this->update_responsive_control(
            'heading_title_typography_font_size',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->update_control(
            'heading_title_typography_font_family',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'font-family: "{{VALUE}}";',
                ],
            ]
        );

        $this->update_control(
            'heading_title_typography_font_weight',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'font-weight: {{VALUE}};',
                ],
            ]
        );

        $this->update_control(
            'heading_title_typography_text_transform',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'text-transform: {{VALUE}};',
                ],
            ]
        );

        $this->update_control(
            'heading_title_typography_font_style',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'font-style: {{VALUE}};',
                ],
            ]
        );

        $this->update_control(
            'heading_title_typography_text_decoration',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'text-decoration: {{VALUE}};',
                ],
            ]
        );

        $this->update_responsive_control(
            'heading_title_typography_line_height',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'line-height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        
        $this->update_control(
            'heading_title_typography_letter_spacing',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'letter-spacing: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->update_control(
            'heading_title_margin',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }

    private function register_update_sub_title_styles()
    {
        $this->update_control(
            'heading_sub_title_color',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->update_control(
            'heading_sub_title_color_hover',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        
        $this->update_responsive_control(
            'heading_sub_title_typography_font_size',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->update_control(
            'heading_sub_title_typography_font_family',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'font-family: "{{VALUE}}";',
                ],
            ]
        );

        $this->update_control(
            'heading_sub_title_typography_font_weight',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'font-weight: {{VALUE}};',
                ],
            ]
        );

        $this->update_control(
            'heading_sub_title_typography_text_transform',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'text-transform: {{VALUE}};',
                ],
            ]
        );

        $this->update_control(
            'heading_sub_title_typography_font_style',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'font-style: {{VALUE}};',
                ],
            ]
        );

        $this->update_control(
            'heading_sub_title_typography_text_decoration',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'text-decoration: {{VALUE}};',
                ],
            ]
        );

        $this->update_responsive_control(
            'heading_sub_title_typography_line_height',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'line-height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        
        $this->update_control(
            'heading_sub_title_typography_letter_spacing',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'letter-spacing: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->update_control(
            'heading_sub_title_margin',
            [
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Newsletter());
