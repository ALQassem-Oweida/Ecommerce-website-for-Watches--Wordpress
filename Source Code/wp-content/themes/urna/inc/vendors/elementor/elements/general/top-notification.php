<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Top_Notification')) {
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
class Urna_Elementor_Top_Notification extends Urna_Elementor_Carousel_Base
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
        return 'tbay-top-notification';
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
        return esc_html__('Urna Top Notification', 'urna');
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
        return 'eicon-star-o';
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
        return [ 'slick', 'urna-slick' ];
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
            'section_general',
            [
                'label' => esc_html__('General', 'urna'),
            ]
        );

        $repeater = $this->register_notifications_repeater();

        $this->add_control(
            'notifications',
            [
                'label' => esc_html__('Item', 'urna'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'urna'),
                'type'      => Controls_Manager::HIDDEN,
                'default'   => 'carousel',
            ]
        );

        $this->end_controls_section();

        $this->add_control_carousel();
    }

    protected function register_notifications_repeater()
    {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'urna'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('Free Shipping on all orders. We offer free shipping for all orders, regardless of the total amount of the order.', 'urna'),
            ]
        );

        return $repeater;
    }

    protected function render_item($item)
    {
        extract($item);

        if (isset($description) && !empty($description)) {
            echo '<div class="item"><span class="des text-center">'. trim($description) .'</span></div>';
        }
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Top_Notification());
