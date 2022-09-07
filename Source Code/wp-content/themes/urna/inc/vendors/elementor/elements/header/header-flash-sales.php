<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Header_Flash_Sales')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class Urna_Elementor_Header_Flash_Sales extends Urna_Elementor_Widget_Base
{
    public function get_name()
    {
        return 'tbay-header-flash-sales';
    }

    public function get_title()
    {
        return esc_html__('Urna Product Flash Sales Header', 'urna');
    }

    public function get_categories()
    {
        return [ 'urna-elements', 'urna-header'];
    }

    public function get_icon()
    {
        return 'eicon-flash';
    }

    protected function get_html_wrapper_class()
    {
        return 'w-auto elementor-widget-' . $this->get_name();
    }

    /**
     * Retrieve the list of scripts the image carousel widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends()
    {
        return ['slick', 'urna-custom-slick', 'jquery-countdowntimer'];
    }

    public function get_keywords()
    {
        return [ 'woocommerce-elements', 'product', 'products', 'Flash Sales', 'Flash' ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__('General', 'urna'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->register_control_header();

        $this->end_controls_section();
        $this->register_section_style();
    }

    private function register_control_header()
    {
        $prefix = 'header_';
        $this->add_control(
            $prefix .'advanced',
            [
                'label' => esc_html__('Header', 'urna'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            $prefix .'display_type',
            [
                'label' => esc_html__('Display type', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text' => esc_html__('Text', 'urna'),
                    'image' => esc_html__('Image', 'urna')
                ]
            ]
        );

        $this->add_control(
            $prefix .'icon',
            [
                'label'     => esc_html__('Icon', 'urna'),
                'type'      => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'zmdi zmdi-flash',
                    'library' => 'material-design-iconic',
                ],
                'conditions' => [
                    'relation' => 'AND',
                    'terms' => [
                        [
                            'name' => $prefix .'display_type',
                            'operator' => '===',
                            'value' => 'text',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            $prefix .'text',
            [
                'label'     => esc_html__('Text', 'urna'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('Flash Sale', 'urna'),
                'conditions' => [
                    'relation' => 'AND',
                    'terms' => [
                        [
                            'name' => $prefix .'display_type',
                            'operator' => '===',
                            'value' => 'text',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            $prefix .'image',
            [
                'label'     => esc_html__('Image', 'urna'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'conditions' => [
                    'relation' => 'AND',
                    'terms' => [
                        [
                            'name' => $prefix .'display_type',
                            'operator' => '===',
                            'value' => 'image',
                        ],
                    ],
                ],
            ]
        );

        $pages = $this->get_available_pages();

        if (!empty($pages)) {
            $this->add_control(
                $prefix .'page',
                [
                    'label'        => esc_html__('Select Page', 'urna'),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => $pages,
                    'default'      => array_keys($pages)[0],
                    'save_default' => true,
                    'separator'    => 'after',
                ]
            );
        } else {
            $this->add_control(
                $prefix .'page',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no pages in your site.</strong><br>Go to the <a href="%s" target="_blank">pages screen</a> to create one.', 'urna'), admin_url('edit.php?post_type=page')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }
    }

    private function register_section_style()
    {
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'style_icon',
            [
                'label' => esc_html__('Icon', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'style_icon_size',
            [
                'label' => esc_html__('Font Size Icon', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 8,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .flash-sale i, {{WRAPPER}} .flash-sale svg' => 'font-size: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .flash-sale i'      => 'color: {{VALUE}}',
                    '{{WRAPPER}} .flash-sale svg'    => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_icon',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .flash-sale i, {{WRAPPER}} .flash-sale svg'    => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .flash-sale:hover i'      => 'color: {{VALUE}}',
                    '{{WRAPPER}} .flash-sale:hover svg'    => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'hover_bg_icon',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .flash-sale:hover i, {{WRAPPER}} .flash-sale:hover svg'    => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'style_text',
            [
                'label' => esc_html__('Text', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .tbay-addon-header-flash-sales .flash-sale span',
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
                    '{{WRAPPER}} .flash-sale span'    => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .flash-sale:hover span'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }


    public function render_content_header()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (!empty($header_page)) {
            $link = get_permalink($header_page);
        }


        if ($header_display_type === 'text') {
            $this->render_content_header_text($link);
        } else {
            $this->render_content_header_image($link);
        }
    }

    private function render_content_header_text($link)
    {
        $settings = $this->get_settings_for_display();
        extract($settings); ?>
        <a class="flash-sale" href="<?php echo esc_url($link); ?>" title="<?php echo esc_attr($header_text); ?>">
            <?php $this->render_item_icon($header_icon); ?>
            <span><?php echo trim($header_text); ?></span>
        </a>
        
        <?php
    }

    private function render_content_header_image($link)
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        $image_id           = $header_image['id'];

        echo '<a class="flash-sale" href="'. esc_url($link) .'">'. wp_get_attachment_image($image_id, 'full') .'</a>';
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Header_Flash_Sales());
