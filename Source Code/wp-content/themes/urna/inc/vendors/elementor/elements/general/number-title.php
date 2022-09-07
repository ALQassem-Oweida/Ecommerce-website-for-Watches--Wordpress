<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Number_Title')) {
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
class Urna_Elementor_Number_Title extends Urna_Elementor_Widget_Base
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
        return 'tbay-number-title';
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
        return esc_html__('Urna Number Title', 'urna');
    }

    public function get_keywords()
    {
        return ['number', 'title', 'text'];
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
        return 'eicon-t-letter';
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

        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__('General', 'urna'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'number_title',
            [
                'label' => esc_html__('Number Title', 'urna'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__('Alignment', 'urna'),
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
                    '{{WRAPPER}} .tbay-addon-number-title' => 'text-align: {{VALUE}};',
                ], 
            ]
        );

        $this->end_controls_section();
    }

    public function get_number_title() {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if ( !empty($number_title) && isset($number_title) ) {
            ?>
                <span class="number-title-heading"><?php echo trim($number_title); ?> </span>
            <?php
        }

    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Number_Title());
