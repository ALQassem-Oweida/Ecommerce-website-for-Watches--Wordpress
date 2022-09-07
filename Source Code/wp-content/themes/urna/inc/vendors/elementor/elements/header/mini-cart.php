<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Mini_Cart')) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;

class Urna_Elementor_Mini_Cart extends Urna_Elementor_Widget_Base
{
    protected $nav_menu_index = 1;

    public function get_name()
    {
        return 'tbay-mini-cart';
    }

    public function get_title()
    {
        return esc_html__('Urna Mini Cart', 'urna');
    }

    public function get_icon()
    {
        return 'eicon-cart-medium';
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
                'label' => esc_html__('Mini Cart', 'urna'),
            ]
        );

        $this->add_control(
            'heading_mini_cart',
            [
                'label' => esc_html__('Mini Cart', 'urna'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'icon_mini_cart',
            [
                'label'              => esc_html__('Icon', 'urna'),
                'type'               => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'linear-icon-cart',
                    'library' => 'simple-line-icons',
                ],
            ]
        );
        $this->add_control(
            'icon_mini_cart_size',
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
                    '{{WRAPPER}} .cart-dropdown .cart-icon i,
                    {{WRAPPER}} .cart-dropdown .cart-icon svg' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_control(
            'show_title_mini_cart',
            [
                'label'              => esc_html__('Display Title "Mini-Cart"', 'urna'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => ''
            ]
        );
        $this->add_control(
            'title_mini_cart',
            [
                'label'              => esc_html__('"Mini-Cart" Title', 'urna'),
                'type'               => Controls_Manager::TEXT,
                'default'            => esc_html__('Shopping cart', 'urna'),
                'condition'          => [
                    'show_title_mini_cart' => 'yes'
                ]
            ]
        );
        
        $this->add_control(
            'price_mini_cart',
            [
                'label'              => esc_html__('Show "Mini-Cart" Price', 'urna'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => '',
                'separator'    => 'after',
            ]
        );


        $this->end_controls_section();
        $this->register_section_style_icon();
        $this->register_section_style_text();
        $this->register_section_style_total();
        $this->register_section_style_popup_cart();
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
                    '{{WRAPPER}} .cart-dropdown .cart-icon'    => 'color: {{VALUE}}',
                    '{{WRAPPER}} .cart-dropdown .cart-icon svg'    => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_icon',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-dropdown .cart-icon'    => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .cart-dropdown:hover .cart-icon'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'hover_bg_icon',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-dropdown:hover .cart-icon'    => 'background-color: {{VALUE}}',
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
                    'show_title_mini_cart' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'margin_text_cart',
            [
                'label'     => esc_html__('Margin Text Cart', 'urna'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .cart-dropdown .text-cart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .cart-dropdown .text-cart'    => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .cart-dropdown .text-cart:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function register_section_style_popup_cart()
    {
        $this->start_controls_section(
            'section_style_popup_cart',
            [
                'label' => esc_html__('Style Popup', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'enabel_popup_cart_left_to_right',
            [
                'label' => esc_html__('Enabel content "Left to Right"', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'popup-cart-ltr-',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'popup_cart_position_top',
            [
                'label'     => esc_html__('Position Top', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-cart .dropdown-menu' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'color_close_popup',
            [
                'label'     => esc_html__('Color Close Popup', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-topcart .offcanvas-close' => 'color: {{VALUE}}',
                ],
            ]
        );
        
       
        $this->end_controls_section();
    }
    private function register_section_style_total()
    {
        $this->start_controls_section(
            'section_style_total',
            [
                'label' => esc_html__('Style Total', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'style_number_typography',
                'selector' => '{{WRAPPER}} .cart-icon span.mini-cart-items',
            ]
        );

        $this->start_controls_tabs('tabs_style_number');

        $this->start_controls_tab(
            'tab_number_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
            ]
        );
        $this->add_control(
            'color_number',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-icon span.mini-cart-items'    => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'bg_total',
            [
                'label'     => esc_html__('Background', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-icon span.mini-cart-items'    => 'background: {{VALUE}} !important',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_number_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
            ]
        );

        $this->add_control(
            'color_number_hover',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-icon:hover span.mini-cart-items'    => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'bg_total_hover',
            [
                'label'     => esc_html__('Background', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .cart-icon:hover span.mini-cart-items'    => 'background: {{VALUE}} !important',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render_woocommerce_mini_cart()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $icon_array = [];
        if ('svg' === $icon_mini_cart['library']) {
            $icon_array['has_svg'] = true;
            $icon_array['svg'] = $this->get_item_icon_svg($icon_mini_cart);
        } else {
            $icon_array['iconClass'] = $icon_mini_cart['value'];
            $icon_array['has_svg'] = false;
        }

        $args = [
            'show_title_mini_cart'           => $show_title_mini_cart,
            'title_mini_cart'                => $title_mini_cart,
            'price_mini_cart'                => $price_mini_cart,
            'active_elementor_minicart'      => true,
            'icon_array'                     => $icon_array,
        ];
        
        urna_tbay_get_woocommerce_mini_cart($args);
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Mini_Cart());
