<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Posts_Grid')) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

class Urna_Elementor_Posts_Grid extends Urna_Elementor_Carousel_Base
{
    public function get_name()
    {
        return 'tbay-posts-grid';
    }

    public function get_title()
    {
        return esc_html__('Urna Posts Grid', 'urna');
    }

    public function get_icon()
    {
        return 'eicon-posts-grid';
    }

    public function get_keywords()
    {
        return [ 'post-grid', 'blog', 'post' ];
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

    protected function register_controls()
    {
        $this->register_controls_heading();
        $this->register_remove_heading_element();

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'urna'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Number of posts', 'urna'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Number of posts to show ( -1 = all )', 'urna'),
                'default' => 6,
                'min'  => -1
            ]
        );


        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'urna'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label'   => esc_html__('Layout Type', 'urna'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_template_post_type(),
                'default' => 'grid',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default' => 'post_date',
                'options' => [
                    'post_date'  => esc_html__('Date', 'urna'),
                    'post_title' => esc_html__('Title', 'urna'),
                    'menu_order' => esc_html__('Menu Order', 'urna'),
                    'rand'       => esc_html__('Random', 'urna'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc' => esc_html__('ASC', 'urna'),
                    'desc' => esc_html__('DESC', 'urna'),
                ],
            ]
        );

        $this->add_control(
            'categories',
            [
                'label' => esc_html__('Categories', 'urna'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'options' => $this->get_post_categories(),
                'multiple' => true,
            ]
        );

        $this->add_control(
            'cat_operator',
            [
                'label' => esc_html__('Category Operator', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default' => 'IN',
                'options' => [
                    'IN' => esc_html__('IN', 'urna'),
                    'NOT IN' => esc_html__('NOT IN', 'urna'),
                ],
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );

        $this->register_thumbnail_controls();

        $this->end_controls_section();


        
        $this->register_design_image_controls();
        $this->register_design_content_controls();

        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type!' =>  array('grid', 'list') ]);
    }



    protected function register_thumbnail_controls()
    {
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'medium',
                'label_block' => true,
                'exclude' => [ 'custom' ],
                'prefix_class' => 'elementor-posts--thumbnail-size-',
            ]
        );
    }

    public static function get_query_args($settings)
    {
        $query_args = [
            'post_type'           => 'post',
            'orderby'             => $settings['orderby'],
            'order'               => $settings['order'],
            'ignore_sticky_posts' => 1,
            'post_status'         => 'publish', // Hide drafts/private posts for admins
        ];

        if (!empty($settings['categories'])) {
            $categories = array();
            foreach ($settings['categories'] as $category) {
                $cat = get_term_by('slug', $category, 'category');
                if (!is_wp_error($cat) && is_object($cat)) {
                    $categories[] = $cat->term_id;
                }
            }

            if ($settings['cat_operator'] == 'AND') {
                $query_args['category__and'] = $categories;
            } elseif ($settings['cat_operator'] == 'IN') {
                $query_args['category__in'] = $categories;
            } else {
                $query_args['category__not_in'] = $categories;
            }
        }

        $query_args['posts_per_page'] = $settings['limit'];

        if (is_front_page()) {
            $query_args['paged'] = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $query_args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        return $query_args;
    }

    public function query_posts()
    {
        $query_args = $this->get_query_args($this->get_settings());
        return new WP_Query($query_args);
    }


    protected function get_post_categories()
    {
        $categories = get_terms(
            array(
                'taxonomy'   => 'category',
                'hide_empty' => false,
            )
        );
        $results = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name . ' (' .$category->count .')';
            }
        }

        return $results;
    }

    protected function register_design_image_controls()
    {
        $this->start_controls_section(
            'section_image',
            [
                'label' => esc_html__('Image', 'urna'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'img_border_margin',
            [
                'label' => esc_html__('Margin', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .entry-thumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'img_border_radius',
            [
                'label' => esc_html__('Border Radius', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .entry-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->start_controls_tabs('thumbnail_effects_tabs');

        $this->start_controls_tab(
            'normal',
            [
                'label' => esc_html__('Normal', 'urna'),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'thumbnail_filters',
                'selector' => '{{WRAPPER}} .entry-thumb img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'hover',
            [
                'label' => esc_html__('Hover', 'urna'),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'thumbnail_hover_filters',
                'selector' => '{{WRAPPER}} .entry-thumb:hover .entry-thumb img',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function register_design_content_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content', 'urna'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_title_style',
            [
                'label' => esc_html__('Title', 'urna'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'post_title_color',
            [
                'label' => esc_html__('Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post .entry-title, {{WRAPPER}} .post .entry-title a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'post_title_typography',
                'selector' => '{{WRAPPER}} .post .entry-title, {{WRAPPER}} .post .entry-title a',
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'post_title_spacing',
            [
                'label' => esc_html__('Spacing', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post .entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'heading_category_style',
            [
                'label' => esc_html__('Category', 'urna'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'category_color',
            [
                'label' => esc_html__('Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post .entry-category, {{WRAPPER}} .post .entry-category a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'selector' => '{{WRAPPER}} .post .entry-category, {{WRAPPER}} .post .entry-category a',
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'category_spacing',
            [
                'label' => esc_html__('Spacing', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post .entry-category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'heading_meta_style',
            [
                'label' => esc_html__('Meta', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => esc_html__('Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .entry-meta-list, {{WRAPPER}} .entry-meta-list a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'selector' => '{{WRAPPER}} .entry-meta-list, {{WRAPPER}} .entry-meta-list a',
            ]
        );

        $this->add_responsive_control(
            'meta_spacing',
            [
                'label' => esc_html__('Spacing', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .entry-meta-list' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_excerpt_style',
            [
                'label' => esc_html__('Excerpt', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                   'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__('Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .entry-description' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .entry-description',
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'excerpt_spacing',
            [
                'label' => esc_html__('Spacing', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .entry-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'heading_readmore_style',
            [
                'label' => esc_html__('Read More', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'read_more_color',
            [
                'label' => esc_html__('Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .readmore' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'read_more_typography',
                'selector' => '{{WRAPPER}} .readmore',
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_spacing',
            [
                'label' => esc_html__('Spacing', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 150,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .readmore' => 'margin-bottom: {{SIZE}}{{UNIT}}; display: block;',
                ],
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }


    private function get_template_post_type()
    {
        $layout = urna_tbay_get_blog_layouts();
    
        return array_flip($layout);
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Posts_Grid());
