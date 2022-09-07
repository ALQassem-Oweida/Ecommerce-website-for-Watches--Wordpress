<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Banner_Close')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Urna_Elementor_Banner_Close extends Urna_Elementor_Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'tbay-banner-close';
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
        return esc_html__('Urna Banner Close', 'urna');
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
        return 'eicon-banner';
    }

    public function get_categories()
    {
        return [ 'urna-elements', 'urna-header'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'urna'),
            ]
        );
        $this->register_image_controls();
        $this->add_control(
            'add_link',
            [
                'label' => esc_html__('Add Link', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );
        $this->add_control(
            'close_button',
            [
                'label' => esc_html__('Show Close Button', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );
        $this->end_controls_section();
        $this->add_control_link();
        $this->register_section_style();
    }

    protected function register_image_controls()
    {
        $this->add_control(
            'banner_image',
            [
                'label' => esc_html__('Choose Image', 'urna'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ]
            ]
        );
    }

    
    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function add_control_link()
    {
        $this->start_controls_section(
            'section_link_options',
            [
                'label' => esc_html__('Add Link Option', 'urna'),
                'type'  => Controls_Manager::SECTION,
                'condition' => array(
                    'add_link' => 'yes',
                ),
            ]
        );
        $this->add_control(
            'banner_link',
            [
                'label' => esc_html__('Link to', 'urna'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('https://your-link.com', 'urna'),
            ]
        );
        
        $this->end_controls_section();
    }

    protected function register_section_style()
    {
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Style Icon', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Font Size', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 14
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-banner-close .banner-remove i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_position_left',
            [
                'label'     => esc_html__('Position Right', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ 'px' ,'%'],
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-banner-close .banner-remove' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                ],
            ]
        );

        $this->add_control(
            'icon_position_top',
            [
                'label'     => esc_html__('Position Top', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ 'px' ,'%'],
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon-banner-close .banner-remove' => 'top: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .tbay-addon-banner-close .banner-remove i'    => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_text_hover',
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
                    '{{WRAPPER}} .tbay-addon-banner-close .banner-remove i:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render_item_content()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (isset($banner_link['url']) && !empty($banner_link['url'])) {
            $this->add_render_attribute('link', 'class', 'btn-link');

            $this->add_link_attributes('link', $banner_link);
        }

        $id     = $banner_image['id'];
        $_id = $this->get_id();
        if (empty($id)) {
            return;
        }
        
        if (!empty($banner_link['url'])) {
            echo '<a '.trim($this->get_render_attribute_string('link')).'>';
        }
        echo wp_get_attachment_image($id, 'full');
        if (!empty($banner_link['url'])) {
            echo '</a>';
        }
        $this->render_item_close_button($_id);
    }

    protected function render_item_close_button($_id)
    {
        $enable_btn = $this->get_settings_for_display('close_button');

        if (empty($enable_btn)) {
            return;
        }

        echo '<div class="container"><button data-id="'. esc_attr($_id) .'" id="banner-remove-'. esc_attr($_id) .'" class="banner-remove"><i class="linear-icon-cross2"></i></button></div>';
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Banner_Close());
