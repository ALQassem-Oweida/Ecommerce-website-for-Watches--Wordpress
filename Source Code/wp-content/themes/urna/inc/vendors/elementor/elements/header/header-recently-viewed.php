<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Header_Recently_Viewed')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Urna_Elementor_Header_Recently_Viewed extends Urna_Elementor_Widget_Base
{
    public function get_name()
    {
        return 'tbay-header-recently-viewed';
    }

    public function get_title()
    {
        return esc_html__('Urna Product Recently Viewed Header', 'urna');
    }

    public function get_icon()
    {
        return 'eicon-clock';
    }

    public function get_categories()
    {
        return [ 'urna-elements', 'woocommerce-elements', 'urna-header'];
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
        return ['slick', 'urna-custom-slick'];
    }

    public function get_keywords()
    {
        return [ 'woocommerce-elements', 'products', 'Recently Viewed', 'Recently' ];
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

        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'urna'),
                'type' => Controls_Manager::HEADING,
            ]
        );

       

        $this->add_control(
            'empty',
            [
                'label' => esc_html__('Empty Result - Custom Paragraph', 'urna'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('You have no recently viewed item.', 'urna'),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );
        
        $this->register_control_icon();

        $this->add_control(
            'enable_readmore',
            [
                'label' => esc_html__('Enable Button "Read More" ', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
        $this->register_control_style_header_title();
        $this->register_control_viewall();
    }

    private function register_control_icon()
    {
        $this->add_control(
            'enable_icon',
            [
                'label' => esc_html__('Enable Icon ', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'recent_viewed_icon',
            [
                'label'        => esc_html__('Icon', 'urna'),
                'type'         => Controls_Manager::ICONS,
                'separator'    => 'after',
                'condition' => [
                    'enable_icon' => 'yes'
                ],
                'default' => [
                    'value' => 'linear-icon-history',
                    'library' => 'simple-line-icons',
                ],
            ]
        );
    }
     
    private function register_control_viewall()
    {
        $this->start_controls_section(
            'section_readmore',
            [
                'label' => esc_html__('Read More Options', 'urna'),
                'type'  => Controls_Manager::SECTION,
                'condition' => [
                    'enable_readmore' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'readmore_text',
            [
                'label' => esc_html__('Button "Read More" Custom Text', 'urna'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Read More', 'urna'),
                'label_block' => true,
            ]
        );

        $pages = $this->get_available_pages();

        if (!empty($pages)) {
            $this->add_control(
                'readmore_page',
                [
                    'label'        => esc_html__('Page', 'urna'),
                    'type'         => Controls_Manager::SELECT2,
                    'options'      => $pages,
                    'default'      => array_keys($pages)[0],
                    'save_default' => true,
                    'label_block' => true,
                    'separator'    => 'after',
                ]
            );
        } else {
            $this->add_control(
                'readmore_page',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no pages in your site.</strong><br>Go to the <a href="%s" target="_blank">pages screen</a> to create one.', 'urna'), admin_url('edit.php?post_type=page')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }
        $this->end_controls_section();
    }
 
    protected function register_control_style_header_title()
    {
        $this->start_controls_section(
            'section_style_heading_header',
            [
                'label' => esc_html__('Heading', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'heading_header_size',
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
                    '{{WRAPPER}} .urna-recent-viewed-products h3, {{WRAPPER}} .urna-recent-viewed-products h3 svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_header_line_height',
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
                    '{{WRAPPER}} .urna-recent-viewed-products h3' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_header_style_margin',
            [
                'label' => esc_html__('Margin', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .urna-recent-viewed-products h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_header_style_padding',
            [
                'label' => esc_html__('Padding', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .urna-recent-viewed-products h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_style_viewed');

        $this->start_controls_tab(
            'tab_viewed_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
            ]
        );
        $this->add_control(
            'color_viewed',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .urna-recent-viewed-products h3' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_viewed',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .urna-recent-viewed-products h3' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_viewed_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
            ]
        );
        $this->add_control(
            'hover_color_viewed',
            [
                'label'     => esc_html__('Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .urna-recent-viewed-products:hover h3,
                    {{WRAPPER}} .urna-recent-viewed-products:hover h3:after' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'hover_bg_viewed',
            [
                'label'     => esc_html__('Background Color', 'urna'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .urna-recent-viewed-products:hover h3' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }
    private function register_control_header()
    {
        $this->add_control(
            'advanced_header',
            [
                'label' => esc_html__('Header', 'urna'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'header_title',
            [
                'label' => esc_html__('Title', 'urna'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Recently Viewed', 'urna'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'header_column',
            [
                'label'     => esc_html__('Columns and max item', 'urna'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 8,
                'separator'    => 'after',
                'options'   => $this->get_max_columns(),
            ]
        );
    }

    public function get_max_columns()
    {
        $value = apply_filters('urna_admin_elementor_recently_viewed_header_columns', [
           4 => 4,
           5 => 5,
           6 => 6,
           7 => 7,
           8 => 8,
           9 => 9,
           10 => 10,
           11 => 11,
           12 => 12,
        ]);

        return $value;
    }

    private function get_recently_viewed($limit)
    {
        $args = urna_tbay_get_products_recently_viewed($limit);
        $args = apply_filters('urna_list_recently_viewed_products_args', $args);

        $products = new WP_Query($args);

        ob_start(); ?>
            <?php while ($products->have_posts()) : $products->the_post(); ?>

                <?php wc_get_template_part('content', 'recent-viewed'); ?>

            <?php endwhile; // end of the loop.?>

        <?php

        $content = ob_get_clean();

        wp_reset_postdata();

        return $content;
    }

    public function render_content_header()
    {
        $header_title = '';

        $settings = $this->get_settings_for_display();
        extract($settings);

        $content                    =  trim($this->get_recently_viewed($header_column));

        $class                      =  '';

        if (empty($content)) {
            $content = $empty;
            $class   = 'empty';
        }

        $content = (!empty($content)) ? $content : $empty;

        $this->add_render_attribute('wrapper', 'data-column', $header_column); ?>

        <h3 class="header-title">
            <?php $this->render_item_icon($recent_viewed_icon); ?>
            <?php echo trim($header_title); ?>
        </h3>
        <div class="content-view <?php echo esc_attr($class); ?>">
            <div class="list-recent">
                <?php echo trim($content); ?>
            </div>

            <?php $this->render_btn_readmore($header_column); ?>
        </div>

        <?php
    }

    private function render_btn_readmore($count)
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        $products_list              =  urna_tbay_wc_track_user_get_cookie();
        $all                        =  count($products_list);

        if (!empty($readmore_page)) {
            $link = get_permalink($readmore_page);
        }

        if ($enable_readmore && ($all > $count) && !empty($link)) : ?>
            <a class="btn-readmore" href="<?php echo esc_url($link); ?>" title="<?php esc_attr($readmore_text); ?>"><?php echo trim($readmore_text); ?></a>
        <?php endif;
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Header_Recently_Viewed());
