<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Search_Form')) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;

class Urna_Elementor_Search_Form extends Urna_Elementor_Widget_Base
{
    protected $nav_menu_index = 1;

    public function get_name()
    {
        return 'tbay-search-form';
    }

    public function get_title()
    {
        return esc_html__('Urna Search Form', 'urna');
    }
    
    public function get_icon()
    {
        return 'eicon-search';
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
                'label' => esc_html__('Search Form', 'urna'),
            ]
        );


       
        $this->_register_form_search();
        $this->_register_button_search();
        $this->_register_category_search();

        $this->add_control(
            'advanced_show_result',
            [
                'label' => esc_html__('Show Result', 'urna'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'show_image_search',
            [
                'label'   => esc_html__('Show Image of Search Result', 'urna'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_price_search',
            [
                'label'              => esc_html__('Show Price of Search Result', 'urna'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();
        $this->register_section_style_icon_click();
        $this->register_section_style_search_form();
    }

    protected function register_section_style_search_form()
    {
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Style Search Form', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'search_form_line_height',
            [
                'label' => esc_html__('Line Height', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .tbay-search,
                    {{WRAPPER}} .tbay-search-form .select-category,{{WRAPPER}} .tbay-search-form .button-search:not(.icon)' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tbay-search-form .select-category,{{WRAPPER}} .tbay-search-form .button-search:not(.icon),
                    {{WRAPPER}} .tbay-preloader,{{WRAPPER}} .tbay-search-form .button-search:not(.icon) i,{{WRAPPER}} .tbay-search-form .SumoSelect' => 'line-height: {{SIZE}}{{UNIT}}'
                ],
            ]
        );
        $this->add_responsive_control(
            'search_form_width',
            [
                'label' => esc_html__('Width', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 300,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 50,
                        'max' => 100,
                    ]
                ],
                'size_units' => [ 'px' ,'%'],
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .form-group .input-group,
                    {{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'border_style_tbay_search_form',
            [
                'label' => esc_html__('Border Type', 'urna'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'urna'),
                    'solid' => esc_html__('Solid', 'urna'),
                    'double' => esc_html__('Double', 'urna'),
                    'dotted' => esc_html__('Dotted', 'urna'),
                    'dashed' => esc_html__('Dashed', 'urna'),
                    'groove' => esc_html__('Groove', 'urna'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .form-group .input-group' => 'border-style: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'border_width_tbay_search_form',
            [
                'label' => esc_html__('Width', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],

                'selectors'  => [
                    '{{WRAPPER}} .tbay-search-form .form-group .input-group' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .SumoSelect.open>.optWrapper,{{WRAPPER}} .autocomplete-suggestions' => 'margin-top: {{BOTTOM}}{{UNIT}};'
                ],
                'condition' => [
                    'border_style_tbay_search_form!' => '',
                ],
            ]
        );
        $this->add_control(
            'border_color_tbay_search_form',
            [
                'label' => esc_html__('Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .form-group .input-group' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'border_style_tbay_search_form!' => '',
                ],
            ]
        );
        
        $this->add_control(
            'border_radius_tbay_search_form',
            [
                'label'     => esc_html__('Border Radius Search Form', 'urna'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-search-form .form-group .input-group' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tbay-search-form .select-category.input-group-addon,{{WRAPPER}} .tbay-search-form .select-category .CaptionCont' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tbay-search-form .button-group,{{WRAPPER}} .tbay-search-form .button-search:not(.icon)' => 'border-radius: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0 ;',
                ],
            ]
        );

        $this->add_control(
            'advanced_categories_search_style',
            [
                'label' => esc_html__('Categories Search', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
                'condition' => [
                    'enable_categories_search' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'bg_category_search',
            [
                'label'     => esc_html__('Background', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .select-category .CaptionCont'    => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'color_category_search',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .select-category .CaptionCont'    => 'color: {{VALUE}}',
                ],
            ]
        );
        
        
        $this->add_control(
            'advanced_btn_search_style',
            [
                'label' => esc_html__('Button Search', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );
        $this->add_control(
            'padding_btn',
            [
                'label'     => esc_html__('Padding Button Search', 'urna'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-search-form .button-search:not(.icon)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'bg_btn',
            [
                'label'     => esc_html__('Background Button', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .button-search:not(.icon),
                    {{WRAPPER}} .tbay-search-form .tbay-loading .button-group,
                    {{WRAPPER}} .tbay-search-form .button-group'    => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'bg_btn_hover',
            [
                'label'     => esc_html__('Background Button Hover', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .button-search:not(.icon):hover'    => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'color_icon_btn',
            [
                'label'     => esc_html__('Color Icon Button', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .button-search i,{{WRAPPER}} .tbay-search-form .button-group:before'    => 'color: {{VALUE}}',
                    '{{WRAPPER}} .button-search svg'    => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'color_icon_btn_hover',
            [
                'label'     => esc_html__('Color Icon Button Hover', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .button-search i:hover'    => 'color: {{VALUE}}',
                    '{{WRAPPER}} .button-search svg:hover'    => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'color_text_btn',
            [
                'label'     => esc_html__('Color Text Button', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .button-search .text'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'color_text_btn_hover',
            [
                'label'     => esc_html__('Color Text Button Hover', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .button-search text:hover'    => 'color: {{VALUE}}',
                ],
            ]
        );
       
        $this->add_control(
            'advanced_input_search_style',
            [
                'label' => esc_html__('Input Search', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );
        $this->add_control(
            'bg_input',
            [
                'label'     => esc_html__('Color Input Search', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .tbay-search'    => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'input_search_padding',
            [
                'label'      => esc_html__('Padding', 'urna'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-search-form .tbay-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function register_section_style_icon_click()
    {
        $this->start_controls_section(
            'section_style_icon_click',
            [
                'label' => esc_html__('Style Icon Click', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'search_style' => ['canvas', 'canvas-v2', 'popup']
                ],
            ]
        );

        $this->add_control(
            'style_icon_click_size',
            [
                'label' => esc_html__('Font Size Icon', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                    ],
                ],
                'condition' => [
                    'search_style' => ['canvas', 'canvas-v2', 'popup']
                ],
                'selectors' => [
                    '{{WRAPPER}} .search-icon-click i, {{WRAPPER}} .search-icon-click svg' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_icon_click');

        $this->start_controls_tab(
            'tab_icon_click_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
                'condition' => [
                    'search_style' => ['canvas', 'canvas-v2', 'popup']
                ],
            ]
        );
        $this->add_control(
            'icon_click_color',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'search_style' => ['canvas', 'canvas-v2', 'popup']
                ],
                'selectors' => [
                    '{{WRAPPER}} .search-icon-click i'    => 'color: {{VALUE}}',
                    '{{WRAPPER}} .search-icon-click svg'    => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_click_bg',
            [
                'label'     => esc_html__('Background', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'search_style' => ['canvas', 'canvas-v2', 'popup']
                ],
                'selectors' => [
                    '{{WRAPPER}} .search-icon-click'    => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_click_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
                'condition' => [
                    'search_style' => ['canvas', 'canvas-v2', 'popup']
                ],
            ]
        );
        $this->add_control(
            'icon_click_color_hover',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'search_style' => ['canvas', 'canvas-v2', 'popup']
                ],
                'selectors' => [
                    '{{WRAPPER}} .search-icon-click i:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .search-icon-click svg:hover' => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'icon_click_bg_hover',
            [
                'label'     => esc_html__('Background', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'search_style' => ['canvas', 'canvas-v2', 'popup']
                ],
                'selectors' => [
                    '{{WRAPPER}} .search-icon-click:hover'    => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function _register_form_search()
    {
        $this->add_control(
            'advanced_type_search',
            [
                'label' => esc_html__('Form', 'urna'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'search_style',
            [
                'label'              => esc_html__('Search Style', 'urna'),
                'type'               => Controls_Manager::SELECT,
                'default' => 'full',
                'options' => [
                    'full'  => esc_html__('Full', 'urna'),
                    'popup'  => esc_html__('Popup', 'urna'),
                    'canvas'  => esc_html__('Canvas v1', 'urna'),
                    'canvas-v2'  => esc_html__('Canvas v2', 'urna'),
                ]
            ]
        );

        $this->_register_form_search_click();

        $this->add_control(
            'search_type',
            [
                'label'              => esc_html__('Search Result', 'urna'),
                'type'               => Controls_Manager::SELECT,
                'default' => 'product',
                'options' => [
                    'product'  => esc_html__('Product', 'urna'),
                    'post'  => esc_html__('Blog', 'urna')
                ]
            ]
        );

        
        $this->add_control(
            'autocomplete_search',
            [
                'label'              => esc_html__('Auto-complete Search', 'urna'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'placeholder_text',
            [
                'label'              => esc_html__('Placeholder Text', 'urna'),
                'type'               => Controls_Manager::TEXT,
                'default'            => esc_html__('Search for products...', 'urna'),
            ]
        );
        $this->add_control(
            'vali_input_search',
            [
                'label'              => esc_html__('Text Validate Input Search', 'urna'),
                'type'               => Controls_Manager::TEXT,
                'default'            => esc_html__('Enter at least 2 characters', 'urna'),
            ]
        );
        $this->add_control(
            'min_characters_search',
            [
                'label'              => esc_html__('Search Min Characters', 'urna'),
                'type'               => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 6,
                        'step' => 1,
                    ],
                    
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
            ]
        );
        $this->add_control(
            'search_max_number_results',
            [
                'label'              => esc_html__('Max Number of Search Results', 'urna'),
                'type'               => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 2,
                        'max' => 10,
                        'step' => 1,
                    ],
                    
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
            ]
        );
    }

    protected function _register_form_search_click()
    {
        $this->add_control(
            'search_form_heading_click',
            [
                'label' => esc_html__('Icon Click', 'urna'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'search_style' => ['canvas', 'canvas-v2', 'popup']
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'icon_button_click',
            [
                'label'              => esc_html__('Icon', 'urna'),
                'type'               => Controls_Manager::ICONS,
                'condition' => [
                    'search_style' => ['canvas', 'canvas-v2', 'popup']
                ],
                'separator' => 'after',
                'default' => [
                    'value'   => 'linear-icon-magnifier',
                    'library' => 'simple-line-icons',
                ],
            ]
        );
    }

    protected function _register_button_search()
    {
        $this->add_control(
            'advanced_button_search',
            [
                'label' => esc_html__('Button Search', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );
        $this->add_control(
            'text_button_search',
            [
                'label'              => esc_html__('Button Search Text', 'urna'),
                'type'               => Controls_Manager::TEXT,
                'default' => 'Search',
            ]
        );
        $this->add_control(
            'icon_button_search',
            [
                'label'              => esc_html__('Button Search Icon', 'urna'),
                'type'               => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'linear-icon-magnifier',
                    'library' => 'simple-line-icons',
                ],
            ]
        );
        $this->add_control(
            'icon_button_search_size',
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
                    '{{WRAPPER}} .button-search i,
                    {{WRAPPER}} .button-search svg' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
    }

    protected function _register_category_search()
    {
        $this->add_control(
            'advanced_categories_search',
            [
                'label'         => esc_html__('Categories Search', 'urna'),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
            ]
        );
        $this->add_control(
            'enable_categories_search',
            [
                'label'              => esc_html__('Enable Search in Categories', 'urna'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'text_categories_search',
            [
                'label'              => esc_html__('Search in Categories Text', 'urna'),
                'type'               => Controls_Manager::TEXT,
                'default'            =>  esc_html__('All Categories', 'urna'),
                'condition' => [
                    'enable_categories_search' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'count_categories_search',
            [
                'label'              => esc_html__('Show count in Categories', 'urna'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'enable_categories_search' => 'yes'
                ]
            ]
        );
    }
    public function get_script_depends()
    {
        return ['jquery-sumoselect'];
    }
    public function get_style_depends()
    {
        return ['sumoselect'];
    }
    
    public function render_search_form_full()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);


        switch ($search_style) {
            case 'full':
                $this->render_search_form();
                break;

            case 'popup':
                $this->render_search_form_popup();
                break;

            case 'canvas':
                $this->render_search_form_canvas();
                break;
            
            case 'canvas-v2':
                $this->render_search_form_canvas_v2();
                break;
            
            default:
                $this->render_search_form();
                break;
        }
    }

    private function render_search_form_canvas()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        $_id = urna_tbay_random_key();
        $class_active_ajax = (urna_switcher_to_boolean($autocomplete_search)) ? 'urna-ajax-search' : '';

        $this->add_render_attribute(
            'search_form',
            [
                'class' => [
                    $class_active_ajax,
                    'searchform'
                ],
                'data-thumbnail' => urna_switcher_to_boolean($show_image_search),
                'data-appendto' => '.search-results-'.$_id,
                'data-price' => urna_switcher_to_boolean($show_price_search),
                'data-minChars' => $min_characters_search['size'],
                'data-post-type' => $search_type,
                'data-count' => $search_max_number_results['size'],
            ]
        ); ?>
            <div id="tbay-search-form-canvas" class="tbay-search-form">
                <button type="button" class="btn-search-icon search-open icon search-icon-click">
                    <?php $this->render_item_icon($icon_button_click) ?>
                </button>

                <div class="sidebar-canvas-search">

                    <div class="sidebar-content">
                        <button type="button" class="btn-search-close">
                            <i class="linear-icon-cross2"></i>
                        </button>
                        <form action="<?php echo esc_url(home_url('/')); ?>" method="get" <?php echo trim($this->get_render_attribute_string('search_form')); ?> >
                            <div class="form-group">
                                <div class="input-group">
                                    <?php if ($enable_categories_search === 'yes'): ?>
                                        <div class="select-category input-group-addon">
                                            <?php if (class_exists('WooCommerce') && $search_type === 'product') :
                                                $args = array(
                                                    'show_option_none'   => $text_categories_search,
                                                    'show_count' => urna_switcher_to_boolean($count_categories_search),
                                                    'hierarchical' => true,
                                                    'id' => 'product-cat-'.$_id,
                                                    'show_uncategorized' => 0,
                                                    'option_none_value' => apply_filters('urna_search_option_none_value', '')
                                                ); ?> 
                                            <?php wc_product_dropdown_categories($args); ?>
                                            
                                            <?php elseif ($search_type === 'post'):
                                                $args = array(
                                                    'show_option_all' => $text_categories_search,
                                                    'show_count' => urna_switcher_to_boolean($count_categories_search),
                                                    'hierarchical' => true,
                                                    'show_uncategorized' => 0,
                                                    'name' => 'category',
                                                    'id' => 'blog-cat-'.$_id,
                                                    'class' => 'postform dropdown_product_cat',
                                                    'option_none_value' => apply_filters('urna_search_option_none_value', '')
                                                ); ?>
                                                <?php wp_dropdown_categories($args); ?>
                                            <?php endif; ?>

                                        </div>
                                    <?php endif; ?>
                                        <input data-style="right" type="text" placeholder="<?php echo esc_attr($placeholder_text); ?>" name="s" required oninvalid="this.setCustomValidity('<?php echo esc_attr($vali_input_search) ?>')" oninput="setCustomValidity('')" class="tbay-search form-control input-sm"/>

                                        <div class="search-results-wrapper">
                                            <div class="urna-search-results search-results-<?php echo esc_attr($_id); ?>" ></div>
                                        </div>
                                        <div class="button-group input-group-addon">
                                            <button type="submit" class="button-search btn btn-sm icon">
                                                <?php $this->render_item_icon($icon_button_search) ?>
                                                <?php if (!empty($text_button_search) && isset($text_button_search)) {
                                                    ?>
                                                        <span class="text"><?php echo trim($text_button_search); ?></span>
                                                    <?php
                                                } ?>
                                            </button>
                                            <div class="tbay-preloader"></div>
                                        </div>

                                        <input type="hidden" name="post_type" value="<?php echo esc_attr($search_type); ?>" class="post_type" />
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    }

    private function render_search_form_canvas_v2()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        $_id = urna_tbay_random_key();
        $class_active_ajax = (urna_switcher_to_boolean($autocomplete_search)) ? 'urna-ajax-search' : '';

        $this->add_render_attribute(
            'search_form',
            [
                'class' => [
                    $class_active_ajax,
                    'searchform'
                ],
                'data-thumbnail' => urna_switcher_to_boolean($show_image_search),
                'data-appendto' => '.search-results-'.$_id,
                'data-price' => urna_switcher_to_boolean($show_price_search),
                'data-minChars' => $min_characters_search['size'],
                'data-post-type' => $search_type,
                'data-count' => $search_max_number_results['size'],
            ]
        ); ?>
            <div id="tbay-search-form-canvas" class="tbay-search-form v2">
                <button type="button" class="btn-search-icon search-open icon search-icon-click">
                    <?php $this->render_item_icon($icon_button_click) ?>
                </button>

                <div class="sidebar-canvas-search">

                    <div class="sidebar-content">
                        <button type="button" class="btn-search-close">
                            <i class="linear-icon-cross2"></i>
                        </button>
                        <form action="<?php echo esc_url(home_url('/')); ?>" method="get" <?php echo trim($this->get_render_attribute_string('search_form')); ?> >
                            <div class="form-group">
                                <div class="input-group">
                                    <?php if ($enable_categories_search === 'yes'): ?>
                                        <div class="select-category input-group-addon">
                                            <?php if (class_exists('WooCommerce') && $search_type === 'product') :
                                                $args = array(
                                                    'show_option_none'   => $text_categories_search,
                                                    'show_count' => urna_switcher_to_boolean($count_categories_search),
                                                    'hierarchical' => true,
                                                    'id' => 'product-cat-'.$_id,
                                                    'show_uncategorized' => 0,
                                                    'option_none_value' => apply_filters('urna_search_option_none_value', '')
                                                ); ?> 
                                            <?php wc_product_dropdown_categories($args); ?>
                                            
                                            <?php elseif ($search_type === 'post'):
                                                $args = array(
                                                    'show_option_all' => $text_categories_search,
                                                    'show_count' => urna_switcher_to_boolean($count_categories_search),
                                                    'hierarchical' => true,
                                                    'show_uncategorized' => 0,
                                                    'name' => 'category',
                                                    'id' => 'blog-cat-'.$_id,
                                                    'class' => 'postform dropdown_product_cat',
                                                    'option_none_value' => apply_filters('urna_search_option_none_value', '')
                                                ); ?>
                                                <?php wp_dropdown_categories($args); ?>
                                            <?php endif; ?>

                                        </div>
                                    <?php endif; ?>
                                        <input data-style="right" type="text" placeholder="<?php echo esc_attr($placeholder_text); ?>" name="s" required oninvalid="this.setCustomValidity('<?php echo esc_attr($vali_input_search) ?>')" oninput="setCustomValidity('')" class="tbay-search form-control input-sm"/>

                                        <div class="search-results-wrapper">
                                            <div class="urna-search-results search-results-<?php echo esc_attr($_id); ?>" ></div>
                                        </div>
                                        <div class="button-group input-group-addon">
                                            <button type="submit" class="button-search btn btn-sm icon">
                                                <?php $this->render_item_icon($icon_button_search) ?>
                                                <?php if (!empty($text_button_search) && isset($text_button_search)) {
                                                    ?>
                                                        <span class="text"><?php echo trim($text_button_search); ?></span>
                                                    <?php
                                                } ?>
                                            </button>
                                            <div class="tbay-preloader"></div>
                                        </div>

                                        <input type="hidden" name="post_type" value="<?php echo esc_attr($search_type); ?>" class="post_type" />
                                </div>
                                
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        <?php
    }

    private function render_search_form_popup()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $_id = urna_tbay_random_key(); ?>
        <div id="search-form-modal-<?php echo esc_attr($_id); ?>" class="search-modal">
            <button type="button" class="btn-search-totop search-icon-click" data-toggle="modal" data-target="#searchformshow-<?php echo esc_attr($_id); ?>">
                <?php $this->render_item_icon($icon_button_click) ?>
            </button>
        </div>

        <div class="modal fade search-form-modal" id="searchformshow-<?php echo esc_attr($_id); ?>" tabindex="-1" role="dialog" aria-labelledby="searchformlable-<?php echo esc_attr($_id); ?>">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="linear-icon-cross2"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                    <?php $this->render_search_form(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    private function render_search_form()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        $_id = urna_tbay_random_key();
        $class_active_ajax = (urna_switcher_to_boolean($autocomplete_search)) ? 'urna-ajax-search' : '';

        $this->add_render_attribute(
            'search_form',
            [
                'class' => [
                    $class_active_ajax,
                    'searchform'
                ],
                'data-thumbnail' => urna_switcher_to_boolean($show_image_search),
                'data-appendto' => '.search-results-'.$_id,
                'data-price' => urna_switcher_to_boolean($show_price_search),
                'data-minChars' => $min_characters_search['size'],
                'data-post-type' => $search_type,
                'data-count' => $search_max_number_results['size'],
            ]
        ); ?>
            <div class="tbay-search-form">
                <form action="<?php echo esc_url(home_url('/')); ?>" method="get" <?php echo trim($this->get_render_attribute_string('search_form')); ?> >
                    <div class="form-group">
                        <div class="input-group">
                            <?php if ($enable_categories_search === 'yes'): ?>
                                <div class="select-category input-group-addon">
                                    <?php if (class_exists('WooCommerce') && $search_type === 'product') :
                                        $args = array(
                                            'show_option_none'   => $text_categories_search,
                                            'show_count' => urna_switcher_to_boolean($count_categories_search),
                                            'hierarchical' => true,
                                            'id' => 'product-cat-'.$_id,
                                            'show_uncategorized' => 0,
                                            'option_none_value' => apply_filters('urna_search_option_none_value', '')
                                        ); ?> 
                                    <?php wc_product_dropdown_categories($args); ?>
                                    
                                    <?php elseif ($search_type === 'post'):
                                        $args = array(
                                            'show_option_all' => $text_categories_search,
                                            'show_count' => urna_switcher_to_boolean($count_categories_search),
                                            'hierarchical' => true,
                                            'show_uncategorized' => 0,
                                            'name' => 'category',
                                            'id' => 'blog-cat-'.$_id,
                                            'class' => 'postform dropdown_product_cat',
                                            'option_none_value' => apply_filters('urna_search_option_none_value', '')
                                        ); ?>
                                        <?php wp_dropdown_categories($args); ?>
                                    <?php endif; ?>

                                </div>
                            <?php endif; ?>
                                <input data-style="right" type="text" placeholder="<?php echo esc_attr($placeholder_text); ?>" name="s" required oninvalid="this.setCustomValidity('<?php echo esc_attr($vali_input_search) ?>')" oninput="setCustomValidity('')" class="tbay-search form-control input-sm"/>

                                <div class="search-results-wrapper">
                                    <div class="urna-search-results search-results-<?php echo esc_attr($_id); ?>" ></div>
                                </div>
                                <div class="button-group input-group-addon">
                                    <button type="submit" class="button-search btn btn-sm">
                                        <?php $this->render_item_icon($icon_button_search) ?>
                                        <?php if (!empty($text_button_search) && isset($text_button_search)) {
                                            ?>
                                                <span class="text"><?php echo trim($text_button_search); ?></span>
                                            <?php
                                        } ?>
                                    </button>
                                    <div class="tbay-preloader"></div>
                                </div>

                                <input type="hidden" name="post_type" value="<?php echo esc_attr($search_type); ?>" class="post_type" />
                        </div>
                        
                    </div>
                </form>
            </div>
        <?php
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Search_Form());
