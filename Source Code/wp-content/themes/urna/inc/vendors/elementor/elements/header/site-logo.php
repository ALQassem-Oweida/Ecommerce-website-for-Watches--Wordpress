<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Widget_Image')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Urna_Element_Site_Logo extends Urna_Elementor_Widget_Image
{
    public function get_name()
    {
        return 'tbay-site-logo';
    }

    public function get_title()
    {
        return esc_html__('Urna Site Logo', 'urna');
    }

    public function get_keywords()
    {
        return [ 'header', 'logo' ];
    } 
    
    public function get_icon()
    {
        return 'eicon-site-logo';
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
            'section_general',
            [
                'label' => esc_html__('General', 'urna'),
            ]
        );
        $this->add_control(
            'logo_select',
            [
                'label' => esc_html__('Image from', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default' => 'global_logo',
                'options' => [
                    'global_logo' => esc_html__('Global Logo', 'urna'),
                    'customize' => esc_html__('Custom Logo', 'urna'),
                ]
            ]
        );

        $this->add_control(
            'image_logo',
            [
                'label' => esc_html__('Choose Image', 'urna'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'logo_select' => 'customize'
                ],
            ]
        );
        
        $this->end_controls_section();
        

        parent::register_controls();
        $this->remove_control('image');
        $this->remove_control('section_style_image');
        $this->remove_control('caption_source');
        $this->update_control(
            'image_size',
            [
                'default' => 'full',
                'condition' => [
                    'logo_select' => 'customize'
                ],
            ]
        );

        $this->update_control(
            'link_to',
            [
                'default' => 'home',
                'options' => [
                    'none' => esc_html__('None', 'urna'),
                    'home' => esc_html__('Home Page', 'urna'),
                    'custom' => esc_html__('Custom URL', 'urna'),
                ],
            ]
        );
 

        $this->update_control(
            'link',
            [
                'placeholder' => site_url(),
            ]
        );
        $this->register_style_logo();
    }

    /**
     * Get default image logo source.
     *
     * Retrieve the source of the placeholder image.
     *
     * @since 1.0.0
     * @access public
     * @static
     *
     * @return string The source of the default placeholder image used by Elementor.
     */
    public function register_style_logo()
    {
        $this->start_controls_section(
            'section_style_logo',
            [
                'label' => esc_html__('Logo', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'width_logo',
            [
                'label' => esc_html__('Max Width', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 400,
                    ],
                    
                ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
    }
    public static function get_logo_default_image_src()
    {
        $active_theme = urna_tbay_get_theme();
        $logo_image = URNA_IMAGES .'/'.$active_theme.'/logo.png';

        /**
         * Get default image logo source.
         *
         * Filters the source of the default placeholder image used by Elementor.
         *
         * @since 1.0.0
         *
         * @param string $logo_image The source of the default placeholder image.
         */
        $logo_image = apply_filters('elementor/header/get_logo_default_image_src', $logo_image);

        return $logo_image;
    }

    protected function get_value()
    {
        $logo = urna_tbay_get_config('media-logo');

        $custom_logo_id = '';

        if (isset($logo['url']) && !empty($logo['url'])) {
            $url        = $logo['url'];
        } else {
            $url = $this->get_logo_default_image_src();
        }

        return [
            'id' => $custom_logo_id,
            'url' => $url,
        ];
    }
 
    protected function get_link_url($settings)
    {
        if ('none' === $settings['link_to']) {
            return false;
        }

        if ('home' === $settings['link_to']) {
            $settings['link']['url'] = apply_filters('wpml_home_url', site_url());

            return $settings['link'];
        }

        if ('custom' === $settings['link_to']) {
            return $settings['link'];
        }
    }

    protected function _content_template()
    {
        return;
    }
}
$widgets_manager->register_widget_type(new Urna_Element_Site_Logo());
