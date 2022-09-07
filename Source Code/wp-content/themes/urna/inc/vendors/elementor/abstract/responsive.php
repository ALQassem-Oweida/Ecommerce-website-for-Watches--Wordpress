<?php
if (!defined('ABSPATH') || function_exists('Urna_Elementor_Responsive_Base')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

abstract class Urna_Elementor_Responsive_Base extends Urna_Elementor_Widget_Base
{
    public function get_name()
    {
        return 'urna-responsive';
    }

    /**
     * @since 2.1.0
     * @access private
     */
    public function get_columns()
    {
        $value = apply_filters('urna_admin_elementor_columns', [
           1 => 1,
           2 => 2,
           3 => 3,
           4 => 4,
           5 => 5,
           6 => 6,
           7 => 7,
           8 => 8
        ]);

        return $value;
    }

    protected function add_control_responsive($condition = array())
    {
        $this->start_controls_section(
            'section_responsive',
            [
                'label' => esc_html__('Responsive Settings', 'urna'),
                'type' => Controls_Manager::SECTION,
                'condition' => $condition,
            ]
        );
   

        $this->add_responsive_control(
            'column',
            [
                'label'     => esc_html__('Columns', 'urna'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 4,
                'options'   => $this->get_columns(),
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => 4,
                'tablet_default' => 3,
                'mobile_default' => 2,
            ]
        );

        $this->add_control(
            'col_desktop',
            [
                'label'     => esc_html__('Columns desktop', 'urna'),
                'description' => esc_html__('Column apply when the width is between 1200px and 1600px', 'urna'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 4,
                'options'   => $this->get_columns(),
            ]
        );

        $this->add_control(
            'col_desktopsmall',
            [
                'label'     => esc_html__('Columns desktopsmall', 'urna'),
                'description' => esc_html__('Column apply when the width is between 992px and 1199px', 'urna'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 2,
                'options'   => $this->get_columns(),
            ]
        );
 
        $this->add_control(
            'col_landscape',
            [
                'label'     => esc_html__('Columns mobile landscape', 'urna'),
                'description' => esc_html__('Column apply when the width is between 576px and 767px', 'urna'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 2,
                'options'   => $this->get_columns(),
            ]
        );

        $this->end_controls_section();
    }

    protected function settings_responsive($settings)
    {

        /*Add class reponsive grid*/
        $this->add_render_attribute(
            'row',
            [
                'class' => [ 'row', 'grid' ],
                'data-xlgdesktop' =>  $settings['column'],
                'data-desktop' =>  $settings['col_desktop'],
                'data-desktopsmall' =>  $settings['col_desktopsmall'],
            ]
        );

        $column_tablet = ( !empty($settings['column_tablet']) ) ? $settings['column_tablet'] : 3;
        $column_mobile = ( !empty($settings['column_mobile']) ) ? $settings['column_mobile'] : 2;

        $this->add_render_attribute('row', 'data-tablet', $column_tablet);
        $this->add_render_attribute('row', 'data-landscape', $settings['col_landscape']);
        $this->add_render_attribute('row', 'data-mobile', $column_mobile);
    }
}
