<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Urna_Elementor_Search_Canvas') ) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;


class Urna_Elementor_Search_Canvas extends Urna_Elementor_Widget_Base {

    protected $nav_menu_index = 1;

    public function get_name() {
        return 'tbay-search-canvas'; 
    }

    public function get_title() {
        return esc_html__('urna Search Canvas', 'urna');
    }
    
    public function get_icon() {
        return 'eicon-search';
    }

    protected function get_html_wrapper_class() {
        return 'w-auto elementor-widget-' . $this->get_name();
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'urna'),
            ]
        ); 
        $this->_register_form_canvas();
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
                'condition' => [
                    'search_type' => 'product',
                ]
            ]
        );
        $this->end_controls_section();
        $this->register_style_search_canvas();
    }
    protected function _register_form_canvas() {
        $this->add_control(
            'advanced_type_search',
            [
                'label' => esc_html__('Form', 'urna'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'search_type',
            [
                'label'              => esc_html__('Search Result', 'urna'),
                'type'               => Controls_Manager::SELECT,
                'default' => 'product',
                'options' => [
                    'product'  => esc_html__('Product','urna'),
                    'post'  => esc_html__('Blog','urna')
                ]
            ]
        );

        
        $this->add_control(
            'autocomplete_search',
            [
                'label'              => esc_html__('Auto-complete Search', 'urna'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => true,
            ]
        );
        $this->add_control(
            'placeholder_text',
            [
                'label'              => esc_html__('Placeholder Text', 'urna'),
                'type'               => Controls_Manager::TEXT,
                'default' => esc_html__('Search for products...','urna'),
            ]
        );
        $this->add_control(
            'vali_input_search',
            [
                'label'              => esc_html__('Text Validate Input Search', 'urna'),
                'type'               => Controls_Manager::TEXT,
                'default' => esc_html__('Enter at least 2 characters','urna'),
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

    protected function _register_button_search() {
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
            ]
        );
        $this->add_control(
            'icon_button_search',
            [
                'label'              => esc_html__('Button Search Icon', 'urna'),
                'type'               => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'icon-magnifier',
                    'library' => 'simple-line-icons',
                ],
            ]
        );
       
    }

    protected function _register_category_search() {
        $this->add_control(
            'advanced_categories_search',
            [
                'label' => esc_html__('Categories Search', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
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
                'default' => esc_html__('All Categories','urna'),
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
                'default' => true,
                'condition' => [
                    'enable_categories_search' => 'yes'
                ]
            ]
        );
    }

    protected function register_style_search_canvas() {
        $this->start_controls_section(
            'section_style_search_canvas',
            [
                'label' => esc_html__('General', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'heading_icon_search',
            [
                'label' => esc_html__( 'Icon', 'urna' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'icon_search_size',
            [
                'label' => esc_html__('Font Size', 'urna'),
                'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
					],
                ],
                'default' => [
                    'size' => 24,
                    'unit' => 'px',
                ],
				'selectors' => [
                    '{{WRAPPER}} .btn-search-icon > i,
                    {{WRAPPER}} .btn-search-icon > svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'padding_search',
            [
                'label'     => esc_html__('Padding Icon Search', 'urna'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .btn-search-icon > i,
                    {{WRAPPER}} .btn-search-icon > svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );   
        $this->add_control(
            'color_icon_search',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon > i'      => 'color: {{VALUE}}',
                    '{{WRAPPER}} .btn-search-icon > svg'    => 'fill: {{VALUE}}',
                ],
            ]
        );   
        $this->add_control(
            'hover_color_icon_search',
            [
                'label'     => esc_html__('Color Hover', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon > i:hover'        => 'color: {{VALUE}}',
                    '{{WRAPPER}} .btn-search-icon > svg:hover'      => 'fill: {{VALUE}}',
                ],
            ]
        );   

        $this->add_control(
            'bg_icon_search',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon > i,
                    {{WRAPPER}} .btn-search-icon > svg'    => 'background-color: {{VALUE}}',
                ],
            ]
        );
       
        $this->add_control(
            'hover_bg_icon_search',
            [
                'label'     => esc_html__('Background Hover', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon > i:hover,
                    {{WRAPPER}} .btn-search-icon > svg:hover'    => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'heading_text',
            [
                'label' => esc_html__( 'Text', 'urna' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'text_search_size',
            [
                'label' => esc_html__('Font Size', 'urna'),
                'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 80,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn-search-icon > .text' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'text_search_line_height',
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
					'{{WRAPPER}} .btn-search-icon > .text' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'color_text_search',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon > .text'    => 'color: {{VALUE}}',
                ],
            ]
        );   
        $this->add_control(
            'hover_color_text_search',
            [
                'label'     => esc_html__('Color Hover', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-search-icon > .text:hover'    => 'color: {{VALUE}}',
                ],
            ]
        ); 
        $this->end_controls_section();
    }

    public function get_script_depends() {
        return ['jquery-sumoselect'];
    }
    public function get_style_depends() {
        return ['sumoselect'];
    }
    
    public function render_search_canvas() {
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        $_id = urna_tbay_random_key();

        $class_active_ajax = urna_switcher_to_boolean($autocomplete_search) ? 'urna-ajax-search' : '';

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
        );
        ?>
            <div id="tbay-search-form-canvas" data-id="" class="tbay-search-form">
                <button type="button" class="btn-search-icon search-open">
                    <?php $this->render_item_icon($icon_button_search) ?>
                    <?php if(!empty($text_button_search) && isset($text_button_search) ) {
                        ?>
                            <span class="text"><?php echo trim($text_button_search); ?></span>
                        <?php
                    } ?>
                </button>
                <div class="sidebar-canvas-search">
                    <div class="sidebar-content">
                        <button type="button" class="btn-search-close">
                                <i class="zmdi zmdi-close"></i>
                        </button>
                        <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" <?php echo trim($this->get_render_attribute_string( 'search_form' )); ?> >
                            <div class="form-group">
                                <div class="input-group">

                                <input data-style="right" type="text" placeholder="<?php echo esc_attr($placeholder_text); ?>" name="s" required oninvalid="this.setCustomValidity('<?php echo esc_attr($vali_input_search) ?>')" oninput="setCustomValidity('')" class="tbay-search form-control input-sm"/>
                                <div class="search-results-wrapper">
                                    <div class="urna-search-results search-results-<?php echo esc_attr( $_id );?>" ></div>
                                </div>

                                <div class="button-group input-group-addon">
                                    <button type="submit" class="button-search btn btn-sm>">
                                        <?php $this->render_item_icon($icon_button_search) ?>
                                    </button>
                                    <div class="tbay-preloader"></div>
                                </div>
                                    <?php if ( $enable_categories_search === 'yes' ): ?>
                                        <div class="select-category input-group-addon">
                                            <span class="category-title"><?php esc_html_e( 'Search in:', 'urna' ) ?></span>
                                            <?php if ( class_exists( 'WooCommerce' ) && $search_type === 'product' ) :
                                                $args = array(
                                                    'show_option_none'   => $text_categories_search,
                                                    'show_count' => $count_categories_search,
                                                    'hierarchical' => true,
                                                    'id' => 'product-cat-'.$_id,
                                                    'show_uncategorized' => 0
                                                );
                                            ?> 
                                            <?php wc_product_dropdown_categories( $args ); ?>
                                            
                                            <?php elseif ( $search_type === 'post' ):
                                                $args = array(
                                                    'show_option_all' => $text_categories_search,
                                                    'show_count' => $count_categories_search,
                                                    'hierarchical' => true,
                                                    'show_uncategorized' => 0,
                                                    'name' => 'category',
                                                    'id' => 'blog-cat-'.$_id,
                                                    'class' => 'postform dropdown_product_cat',
                                                );
                                            ?>
                                                <?php wp_dropdown_categories( $args ); ?>
                                            <?php endif; ?>

                                        </div>
                                    <?php endif; ?>

                                        <input type="hidden" name="post_type" value="<?php echo esc_attr($search_type); ?>" class="post_type" />
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
    }

}
$widgets_manager->register_widget_type(new Urna_Elementor_Search_Canvas());

