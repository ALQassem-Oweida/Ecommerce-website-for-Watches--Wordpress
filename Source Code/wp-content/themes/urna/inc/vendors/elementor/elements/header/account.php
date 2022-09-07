<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Account')) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;

class Urna_Elementor_Account extends Urna_Elementor_Widget_Base
{
    protected $nav_menu_index = 1;

    public function get_name()
    {
        return 'tbay-account';
    }

    public function get_title()
    {
        return esc_html__('Urna Account', 'urna');
    }

    public function get_icon()
    {
        return 'eicon-user-circle-o';
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
            'section_layout',
            [
                'label' => esc_html__('Account', 'urna'),
            ]
        );

        $this->add_control(
            'icon_account',
            [
                'label'              => esc_html__('Icon', 'urna'),
                'type'               => Controls_Manager::ICONS,
                'default' => [
                    'value' =>   'linear-icon-user',
                    'library' => 'simple-line-icons',
                ],
            ]
        );
        
        $this->add_control(
            'show_text_account',
            [
                'label'              => esc_html__('Display Text Account', 'urna'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control(
            'text_before',
            [
                'label'              => esc_html__('Text Before Login', 'urna'),
                'type'               => Controls_Manager::TEXT,
                'condition'          => [
                    'show_text_account' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'text_after',
            [
                'label'              => esc_html__('Text After Login', 'urna'),
                'type'               => Controls_Manager::TEXT,
                'condition'          => [
                    'show_text_account' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'show_sub_account',
            [
                'label'              => esc_html__('Display Sub Menu', 'urna'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $menus = $this->get_available_menus();

        if (!empty($menus)) {
            $this->add_control(
                'sub_menu_account',
                [
                    'label'        => esc_html__('Choose Menu', 'urna'),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => $menus,
                    'default'      => array_keys($menus)[0],
                    'save_default' => true,
                    'separator'    => 'after',
                    'condition'    => [
                        'show_sub_account'  => 'yes'
                    ],
                    'description'  => sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'urna'), admin_url('nav-menus.php')),
                ]
            );
        } else {
            $this->add_control(
                'sub_menu_account',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'urna'), admin_url('nav-menus.php?action=edit&menu=0')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }
        $this->add_control(
            'show_popup_login',
            [
                'label'              => esc_html__('Display Popup Login', 'urna'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();
        $this->register_section_style_icon();
        $this->register_section_style_text();
    }
    protected function register_section_style_icon()
    {
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Style Icon', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'icon_account_size',
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
                    '{{WRAPPER}} .tbay-login a i,
                    {{WRAPPER}} .tbay-login a svg' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_control(
            'padding_icon_account',
            [
                'label'     => esc_html__('Padding Icon Account', 'urna'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-login a i,
                    {{WRAPPER}} .tbay-login a svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .tbay-login a i'      => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tbay-login a svg'    => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_icon',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-login a i,
                    {{WRAPPER}} .tbay-login a svg'    => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .tbay-login a i:hover'      => 'color: {{VALUE}}',
                    '{{WRAPPER}} .tbay-login a svg:hover'    => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'hover_bg_icon',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-login a i:hover,
                    {{WRAPPER}} .tbay-login a svg:hover'    => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function register_section_style_text()
    {
        $this->start_controls_section(
            'section_style_text',
            [
                'label' => esc_html__('Style Text', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_text_account' => 'yes',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_account_typography',
                'selector' => '{{WRAPPER}} .tbay-login > a span',
            ]
        );

        $this->add_responsive_control(
            'text_account_margin',
            [
                'label' => esc_html__('Margin', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-login > a span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .text-account'    => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .text-account:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function is_user_logged_in()
    {
        $user = wp_get_current_user();

        return $user->exists();
    }
    
    protected function get_nav_menu_index()
    {
        return $this->nav_menu_index++;
    }

    public function check_login($show_text_account, $text_after, $text_before)
    {
        if (!empty($text_after)) {
            $title = $text_after;
        } else {
            $title = esc_html__('Hi', 'urna');
        }
        if (is_user_logged_in()) {
            $current_user 	= wp_get_current_user();
            $name = $current_user->display_name;
            $name = $title .' '.$name;
        } else {
            if (!empty($text_before)) {
                $name = $text_before;
            } else {
                $name = esc_html__('Login Or Register', 'urna');
            }
        }

        if ($show_text_account === 'yes') {
            ?><span class="text-account"> <?php echo trim($name); ?> </span><?php
        }
    }
    public function render_item_account()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        // $name = '';
        $this->render_item_icon($icon_account);
        $this->check_login($show_text_account, $text_after, $text_before);
    }
    public function render_sub_menu()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        $args = [
            'menu'        => $sub_menu_account,
            'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id()
        ];
        $menu_html = wp_nav_menu($args);
        echo trim($menu_html);
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Account());
