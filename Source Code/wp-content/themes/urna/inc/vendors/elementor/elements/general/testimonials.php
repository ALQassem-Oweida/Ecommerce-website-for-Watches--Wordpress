<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Testimonials')) {
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
class Urna_Elementor_Testimonials extends Urna_Elementor_Carousel_Base
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
        return 'tbay-testimonials';
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
        return esc_html__('Urna Testimonials', 'urna');
    }

    public function get_script_depends()
    {
        return [ 'slick', 'urna-slick' ];
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
        return 'eicon-testimonial';
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
            'section_general',
            [
                'label' => esc_html__('General', 'urna'),
            ]
        );
 
        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'urna'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'urna'),
                    'carousel'  => esc_html__('Carousel', 'urna'),
                ],
            ]
        );
        $this->add_control(
            'testimonials_align',
            [
                'label' => esc_html__('Align', 'urna'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'urna'),
                        'icon' => 'fas fa-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'urna'),
                        'icon' => 'fas fa-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'urna'),
                        'icon' => 'fas fa-align-right'
                    ],
                ],
                'prefix_class'          => 'testimonials-align-',
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item .testimonials-body'  => 'text-align: {{VALUE}} !important',
                ]
            ]
        );
        $this->add_responsive_control(
            'testimonial_padding',
            [
                'label' => esc_html__('Padding "Name"', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .name-client' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $repeater = $this->register_testimonials_repeater();

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__('Testimonials Items', 'urna'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => $this->register_set_testimonial_default(),
                'testimonials_field' => '{{{ testimonials_image }}}',
            ]
        );

        $this->end_controls_section();

        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
    }

    private function register_testimonials_repeater()
    {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'testimonial_image',
            [
                'label' => esc_html__('Choose Image', 'urna'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control(
            'testimonial_name',
            [
                'label' => esc_html__('Name', 'urna'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'testimonial_job',
            [
                'label' => esc_html__('Job', 'urna'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'testimonial_excerpt',
            [
                'label' => esc_html__('Excerpt', 'urna'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        return $repeater;
    }

    private function register_set_testimonial_default()
    {
        $defaults = [
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'testimonial_name' => esc_html__('Name 1', 'urna'),
                'testimonial_job' => esc_html__('Job 1', 'urna'),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'urna'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'testimonial_name' => esc_html__('Name 2', 'urna'),
                'testimonial_job' => esc_html__('Job 2', 'urna'),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'urna'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'testimonial_name' => esc_html__('Name 3', 'urna'),
                'testimonial_job' => esc_html__('Job 3', 'urna'),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'urna'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'testimonial_name' => esc_html__('Name 4', 'urna'),
                'testimonial_job' => esc_html__('Job 4', 'urna'),
                'testimonial_excerpt' => 'Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque',
            ],
        ];

        return $defaults;
    }

    protected function render_item($item, $layout)
    {
        extract($item);

        set_query_var('image_id', $testimonial_image['id']);
        set_query_var('image_url', $testimonial_image['url']);
        set_query_var('testimonial_name', $testimonial_name);
        set_query_var('job', $testimonial_job);
        set_query_var('description', $testimonial_excerpt);

        get_template_part('vc_templates/testimonial/testimonial-' . $layout);
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Testimonials());
