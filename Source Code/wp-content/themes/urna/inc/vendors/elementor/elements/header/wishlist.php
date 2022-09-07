<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Wishlist')) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;

class Urna_Elementor_Wishlist extends Urna_Elementor_Widget_Base
{
    protected $nav_menu_index = 1;

    public function get_name()
    {
        return 'tbay-wishlist';
    }

    public function get_title()
    {
        return esc_html__('Urna Wishlist', 'urna');
    }

    public function get_icon()
    {
        return 'eicon-heart';
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
                'label' => esc_html__('Wishlist', 'urna'),
            ]
        );

        $this->add_control(
            'icon_wishlist',
            [
                'label'              => esc_html__('Icon', 'urna'),
                'type'               => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'linear-icon-heart',
                    'library' => 'simple-line-icons',
                ],
            ]
        );
        $this->add_control(
            'icon_wishlist_size',
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
                    '{{WRAPPER}} .top-wishlist i, {{WRAPPER}} .top-wishlist svg' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_control(
            'show_title_wishlist',
            [
                'label'              => esc_html__('Display Title', 'urna'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control(
            'title_wishlist',
            [
                'label'              => esc_html__('Title', 'urna'),
                'type'               => Controls_Manager::TEXT,
                'default' => esc_html__('My Wishlist', 'urna'),
                'condition' => [
                    'show_title_wishlist' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'show_total_wishlist',
            [
                'label'              => esc_html__('Show Total', 'urna'),
                'type'               => Controls_Manager::SWITCHER,
                'default'            => 'yes',
            ]
        );
    
        $this->end_controls_section();
        $this->register_section_style_icon();
        $this->register_section_style_text();
        $this->register_section_style_total();
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
                    '{{WRAPPER}} .top-wishlist i'       => 'color: {{VALUE}}',
                    '{{WRAPPER}} .top-wishlist svg'     => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_icon',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist i, {{WRAPPER}} .top-wishlist svg'    => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .top-wishlist i:hover'         => 'color: {{VALUE}}',
                    '{{WRAPPER}} .top-wishlist svg:hover'       => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'hover_bg_icon',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist i:hover, {{WRAPPER}} .top-wishlist svg:hover'    => 'background-color: {{VALUE}}',
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
                'condition' => [
                    'show_title_wishlist' => 'yes'
                ]
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
                    '{{WRAPPER}} .title-wishlist'    => 'color: {{VALUE}}',
                    '{{WRAPPER}} .count-wishlist'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'margin_text_wishlist',
            [
                'label'     => esc_html__('Margin Text', 'urna'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .title-wishlist' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .title-wishlist:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .count-wishlist:hover'       => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
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
                'selector' => '{{WRAPPER}} .top-wishlist .count_wishlist',
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
                    '{{WRAPPER}} .top-wishlist .count_wishlist'    => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'bg_total',
            [
                'label'     => esc_html__('Background', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist .count_wishlist'    => 'background: {{VALUE}} !important',
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
                    '{{WRAPPER}} .top-wishlist:hover .count_wishlist'    => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'bg_total_hover',
            [
                'label'     => esc_html__('Background', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist:hover .count_wishlist'    => 'background: {{VALUE}} !important',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'position_left',
            [
                'label'     => esc_html__('Position Left', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -20,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist .count_wishlist' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
                ],
            ]
        );

        $this->add_control(
            'position_top',
            [
                'label'     => esc_html__('Position Top', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 40,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-wishlist .count_wishlist' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
    

    public function render_item_wishlist()
    {
        $this->add_render_attribute('wishlist', 'class', 'wishlist');
        $settings = $this->get_settings();
        extract($settings);
        $url_wishlist = YITH_WCWL()->get_wishlist_url();
        $count_wishlist = YITH_WCWL()->count_products(); ?>
        <a href="<?php echo esc_url($url_wishlist)?>" <?php echo trim($this->get_render_attribute_string('wishlist')); ?>>
            <?php $this->render_item_icon($icon_wishlist); ?>
           <?php if ($show_total_wishlist === 'yes') {
            ?>
                <span class="count_wishlist"><?php echo trim($count_wishlist) ?></span>
               <?php
        } ?>

           <?php if ($show_title_wishlist === 'yes' && !empty($title_wishlist) && isset($title_wishlist)) {
            ?>
                <span class="title-wishlist"><?php echo trim($title_wishlist) ?></span>
               <?php
        } ?>


            
            
        </a>
        <?php
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Wishlist());
