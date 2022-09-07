<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Custom_Menu')) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

class Urna_Elementor_Custom_Menu extends Urna_Elementor_Widget_Base
{
    protected $nav_menu_index = 1;

    public function get_name()
    {
        return 'tbay-custom-menu';
    }

    public function get_title()
    {
        return esc_html__('Urna Custom Menu', 'urna');
    }

    protected function get_html_wrapper_class()
    {
        return 'vc_wp_custommenu elementor-widget-' . $this->get_name();
    }

    public function get_icon()
    {
        return 'eicon-nav-menu';
    }

    public function on_export($element)
    {
        unset($element['settings']['menu']);

        return $element;
    }

    protected function get_nav_menu_index()
    {
        return $this->nav_menu_index++;
    }

    protected function register_controls()
    {
        $this->register_controls_heading();
        $this->register_remove_heading_element();

        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('General', 'urna'),
            ]
        );

        $menus = $this->get_available_menus();

        if (!empty($menus)) {
            $this->add_control(
                'menu',
                [
                    'label'        => esc_html__('Menu', 'urna'),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => $menus,
                    'default'      => array_keys($menus)[0],
                    'save_default' => true,
                    'separator'    => 'after',
                    'description'  => sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'urna'), admin_url('nav-menus.php')),
                ]
            );
        } else {
            $this->add_control(
                'menu',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'urna'), admin_url('nav-menus.php?action=edit&menu=0')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }

        
        $this->add_control(
            'menu_style_horizontal',
            [
                'label'        => esc_html__('Menu style horizontal', 'urna'),
                'type'         => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'urna'),
                'label_on'  => esc_html__('On', 'urna'),
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-none > ul' => 'display: flex;',
                ],
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'              => esc_html__('Layout Menu', 'urna'),
                'type'               => Controls_Manager::HIDDEN,
                'default'            => 'none',
            ]
        );
        
        $this->end_controls_section();
        $this->remove_control('heading_subtitle');
        $this->register_section_style_custom_menu_item();
        $this->register_section_style_custom_menu_content();
    }

    private function register_section_style_custom_menu_item()
    {
        $this->start_controls_section(
            'section_style_custom_menu_item',
            [
                'label' => esc_html__('Menu Item', 'urna'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'menu_item_typography',
                'selector' => '{{WRAPPER}} .tbay-none >ul > li> a',
            ]
        );

        $this->start_controls_tabs('tabs_menu_item_style');

        $this->start_controls_tab(
            'tab_menu_item_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
            ]
        );

        $this->add_control(
            'color_menu_item',
            [
                'label'     => esc_html__('Text Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-none >ul > li> a'=> 'color: {{VALUE}} !important',
                    1
                ],
            ]
        );

        $this->add_control(
            'bg_menu_item',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-none >ul > li,
                    {{WRAPPER}} .tbay-none >ul > li'    => 'background-color: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_menu_item_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
            ]
        );

        $this->add_control(
            'color_menu_item_hover',
            [
                'label'     => esc_html__('Text Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-none >ul > li.active > a,
                    {{WRAPPER}} .tbay-none >ul > li > a:hover'    => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'bg_menu_item_hover',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-none >ul > li:hover,
                    {{WRAPPER}} .tbay-none >ul > li.active'    => 'background-color: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->add_responsive_control(
            'align_menu_item',
            [
                'label' => esc_html__('Align', 'urna'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'urna'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'urna'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'urna'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-none >ul' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'menu_style_horizontal' => '',
                ]
            ]
        );
       
        $this->add_responsive_control(
            'align_menu_item_horizontal',
            [
                'label' => esc_html__('Align', 'urna'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'urna'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'urna'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'urna'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-none >ul' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'menu_style_horizontal' => 'yes',
                ]
            ]
        );
        

        $this->add_responsive_control(
            'padding_menu_item',
            [
                'label' => esc_html__('Padding', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-none >ul >li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'no_padding_menu_item_first_item',
            [
                'label'        => esc_html__('No Padding-Left First Item', 'urna'),
                'type'         => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'urna'),
                'label_on'  => esc_html__('On', 'urna'),
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-none > ul >li:first-child' => 'padding-left: 0',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'menu_item_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tbay-none >ul >li+li',
            ]
        );
        $this->add_responsive_control(
            'margin_menu_item',
            [
                'label' => esc_html__('Margin', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-none >ul >li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function register_section_style_custom_menu_content()
    {
        $this->start_controls_section(
            'section_style_custom_menu_content',
            [
                'label' => esc_html__('Menu Content', 'urna'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_menu_content_style');

        $this->start_controls_tab(
            'tab_menu_content_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
            ]
        );

        $this->add_control(
            'bg_menu_content',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-none'    => 'background-color: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_menu_content_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
            ]
        );

        $this->add_control(
            'bg_menu_content_hover',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-none:hover'    => 'background-color: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'padding_menu_content',
            [
                'label' => esc_html__('Padding', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-none' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin_menu_content',
            [
                'label' => esc_html__('Margin', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-none' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render_custom_menu_element_heading()
    {
        $heading_title = $heading_title_tag = $heading_subtitle = '';
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (!empty($heading_title)) : ?>
            <<?php echo trim($heading_title_tag); ?> class="tbay-addon-title">
               <?php echo trim($heading_title); ?>  
            </<?php echo trim($heading_title_tag); ?>>
        <?php endif;
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Custom_Menu());
