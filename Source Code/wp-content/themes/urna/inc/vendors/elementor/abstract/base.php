<?php
if (!defined('ABSPATH') || function_exists('Urna_Elementor_Widget_Base')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

abstract class Urna_Elementor_Widget_Base extends Elementor\Widget_Base
{
    public function get_name_template()
    {
        return str_replace('tbay-', '', $this->get_name());
    }

    public function get_categories()
    {
        return [ 'urna-elements' ];
    }
    
    public function get_name()
    {
        return 'urna-base';
    }

    /**
     * Get view template
     *
     * @param string $tpl_name
     */
    protected function get_view_template($tpl_slug, $tpl_name, $settings = [])
    {
        $located   = '';
        $templates = [];
        

        if (! $settings) {
            $settings = $this->get_settings_for_display();
        }

        if (!empty($tpl_name)) {
            $tpl_name  = trim(str_replace('.php', '', $tpl_name), DIRECTORY_SEPARATOR);
            $templates[] = 'elementor_templates/' . $tpl_slug . '-' . $tpl_name . '.php';
            $templates[] = 'elementor_templates/' . $tpl_slug . '/' . $tpl_name . '.php';
        }

        $templates[] = 'elementor_templates/' . $tpl_slug . '.php';
 
        foreach ($templates as $template) {
            if (file_exists(URNA_THEMEROOT . '/' . $template)) {
                $located = URNA_THEMEROOT . '/' . $template;
                break;
            } else {
                $located = false;
            }
        }

        if ($located) {
            include $located;
        } else {
            echo sprintf(__('Failed to load template with slug "%s" and name "%s".', 'urna'), $tpl_slug, $tpl_name);
        }
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('wrapper', 'class', ['tbay-element', 'tbay-addon', 'tbay-addon-'. $this->get_name_template()]);

        $this->get_view_template($this->get_name_template(), '', $settings);
    }
    
    protected function register_controls_heading($condition = array())
    {
        $this->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__('Heading', 'urna'),
                'condition' => $condition,
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
                    '{{WRAPPER}} .tbay-addon-title' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .description' => 'text-align: {{VALUE}};',
                ],
            ]
        );
     

        $this->add_control(
            'heading_title',
            [
                'label' => esc_html__('Title', 'urna'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'heading_title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'urna'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'heading_subtitle',
            [
                'label' => esc_html__('Sub Title', 'urna'),
                'type' => Controls_Manager::TEXT,
            ]
        );


        $this->add_control(
            'heading_description',
            [
                'label' => esc_html__('Description', 'urna'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
     
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_heading',
            [
                'label' => esc_html__('Heading', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );
        $this->register_title_styles();
        $this->register_sub_title_styles();
        $this->register_description_styles();
        $this->register_content_styles();
        $this->end_controls_section();
    }

    protected function register_remove_heading_element()
    {
        $this->remove_control('heading_description');
        $this->remove_control('styles');
    }

    private function register_content_styles()
    {
        $this->add_control(
            'heading_stylecontent',
            [
                'label' => esc_html__('Content', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'heading_style_margin',
            [
                'label' => esc_html__('Margin', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon .tbay-addon-title,{{WRAPPER}} .tbay-addon .tbay-addon-nav-menu .tbay-addon-title, #tbay-main-content {{WRAPPER}} .tbay-addon .tbay-addon-nav-menu .tbay-addon-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_style_padding',
            [
                'label' => esc_html__('Padding', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon .tbay-addon-title,{{WRAPPER}} .tbay-addon .tbay-addon-nav-menu .tbay-addon-title, #tbay-main-content {{WRAPPER}} .tbay-addon .tbay-addon-nav-menu .tbay-addon-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_style_bg',
            [
                'label' => esc_html__('Background', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon .tbay-addon-title,{{WRAPPER}} .tbay-addon .tbay-addon-nav-menu .tbay-addon-title, #tbay-main-content {{WRAPPER}} .tbay-addon .tbay-addon-nav-menu .tbay-addon-title' => 'background: {{VALUE}};',
                ],
            ]
        );
    }
    private function register_title_styles()
    {
        $this->add_control(
            'heading_styletitle',
            [
                'label' => esc_html__('Title', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('heading_title_colors');

        $this->start_controls_tab(
            'heading_title_colors_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
            ]
        );

        $this->add_control(
            'heading_title_color',
            [
                'label' => esc_html__('Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon .tbay-addon-title .title,{{WRAPPER}} .tbay-addon .tbay-addon-nav-menu .tbay-addon-title, #tbay-main-content {{WRAPPER}} .tbay-addon .tbay-addon-nav-menu .tbay-addon-title' => 'color: {{VALUE}} !important;',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'heading_title_colors_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
            ]
        );

        $this->add_control(
            'heading_title_color_hover',
            [
                'label' => esc_html__('Hover Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon .tbay-addon-title .title:hover,{{WRAPPER}} .tbay-addon .tbay-addon-nav-menu .tbay-addon-title:hover, #tbay-main-content {{WRAPPER}} .tbay-addon .tbay-addon-nav-menu .tbay-addon-title' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_title_typography',
                'selector' => '{{WRAPPER}} .tbay-addon .tbay-addon-title .title,{{WRAPPER}} .tbay-addon .tbay-addon-nav-menu .tbay-addon-title, #tbay-main-content {{WRAPPER}} .tbay-addon .tbay-addon-nav-menu .tbay-addon-title',
            ]
        );

        $this->add_responsive_control(
            'heading_title_margin',
            [
                'label' => esc_html__('Margin', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon .tbay-addon-title .title,{{WRAPPER}} .tbay-addon .tbay-addon-nav-menu .tbay-addon-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }

    private function register_sub_title_styles()
    {
        $this->add_control(
            'heading_stylesubtitle',
            [
                'label' => esc_html__('Sub title', 'urna'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'heading_subtitle!' => ''
                ],
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('heading_subtitle_colors');

        $this->start_controls_tab(
            'heading_subtitle_colors_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
                'condition' => [
                    'heading_subtitle!' => ''
                ],
            ]
        );

        $this->add_control(
            'heading_subtitle_color',
            [
                'label' => esc_html__('Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'heading_subtitle!' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon .tbay-addon-title .subtitle' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'heading_subtitle_colors_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
                'condition' => [
                    'heading_subtitle!' => ''
                ],
            ]
        );

        $this->add_control(
            'heading_subtitle_color_hover',
            [
                'label' => esc_html__('Hover Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'heading_subtitle!' => ''
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon .tbay-addon-title .subtitle:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_subtitle_typography',
                'condition' => [
                    'heading_subtitle!' => ''
                ],
                'selector' => '{{WRAPPER}} .tbay-addon .tbay-addon-title .subtitle',
            ]
        );

        $this->add_responsive_control(
            'heading_subtitle_margin',
            [
                'label' => esc_html__('Margin', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon .tbay-addon-title .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'heading_subtitle!' => ''
                ],
            ]
        );
    }

    private function register_description_styles()
    {
        $this->add_control(
            'heading_style_description',
            [
                'label' => esc_html__('Description', 'urna'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'heading_description!' => ''
                ],
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('heading_description_colors');

        $this->start_controls_tab(
            'heading_description_colors_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
                'condition' => [
                    'heading_description!' => ''
                ],
            ]
        );

        $this->add_control(
            'heading_description_color',
            [
                'label' => esc_html__('Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'heading_description!' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon.tbay-addon-text-heading .description' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'heading_description_colors_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
                'condition' => [
                    'heading_description!' => ''
                ],
            ]
        );

        $this->add_control(
            'heading_description_color_hover',
            [
                'label' => esc_html__('Hover Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'heading_description!' => ''
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon.tbay-addon-text-heading .description:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_description_typography',
                'condition' => [
                    'heading_description!' => ''
                ],
                'selector' => '{{WRAPPER}} .tbay-addon.tbay-addon-text-heading .description',
            ]
        );

        $this->add_responsive_control(
            'heading_description_margin',
            [
                'label' => esc_html__('Margin', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-addon.tbay-addon-text-heading .description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'heading_description!' => ''
                ],
            ]
        );
    }

    protected function get_available_pages()
    {
        $pages = get_pages();

        $options = [];

        foreach ($pages as $page) {
            $options[$page->ID] = $page->post_title;
        }

        return $options;
    }

    protected function get_available_on_sale_products()
    {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1
        );

        $product_ids_on_sale    = wc_get_product_ids_on_sale();
        $product_ids_on_sale[]  = 0;
        $args['post__in'] = $product_ids_on_sale;
        $loop = new WP_Query($args);

        $options = [];
        if ($loop->have_posts()): while ($loop->have_posts()): $loop->the_post();

        $options[get_the_ID()] = get_the_title();


        endwhile;
        endif;
        wp_reset_postdata();

        return $options;
    }

    protected function get_available_products_countdown()
    {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1
        );

        $product_ids_on_sale    = wc_get_product_ids_on_sale();
        $product_ids_on_sale[]  = 0;
        $args['post__in'] = $product_ids_on_sale;
        $loop = new WP_Query($args);

        $options = [];
        $time_sale = false;
        if ($loop->have_posts()): while ($loop->have_posts()): $loop->the_post();

        global $product;
        $time_sale = get_post_meta($product->get_id(), '_sale_price_dates_to', true);

        if ($time_sale) {
            $options[$product->get_id()] = $product->get_title();
        }

        endwhile;
        endif;
        wp_reset_postdata();

        return $options;
    }


    protected function get_available_menus()
    {
        if (urna_wpml_is_activated()) {
            return $this->get_available_menus_wpml();
        } else {
            return $this->get_available_menus_default();
        }
    }

    protected function get_available_menus_default()
    {
        $menus = wp_get_nav_menus();
        $options = [];

        if ($menus) {
            foreach ($menus as $menu) {
                $options[$menu->slug] = $menu->name;
            }
        }

        return $options;
    }

    protected function get_available_menus_wpml()
    {
        global $sitepress;
        $menus = wp_get_nav_menus();

        $options = [];

        $current_lang = apply_filters('wpml_current_language', null);
        ;
        if ($menus) {
            foreach ($menus as $menu) {
                $menu_details = $sitepress->get_element_language_details($menu->term_taxonomy_id, 'tax_nav_menu');
                if (isset($menu_details->language_code) && $menu_details->language_code === $current_lang) {
                    $options[ $menu->slug ] = $menu->name;
                }
            }
        }

        return $options;
    }
    
    public function render_element_heading($class = '')
    {
        $heading_description = $heading_title = $heading_title_tag = $heading_subtitle = '';
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (!empty($heading_subtitle) || !empty($heading_title)) : ?>
			<<?php echo trim($heading_title_tag); ?> class="tbay-addon-title <?php echo esc_attr($class); ?>">
				<?php if (!empty($heading_title)) : ?>
					<span class="title"><?php echo trim($heading_title); ?></span>
				<?php endif; ?>	    	
				<?php if (!empty($heading_subtitle)) : ?>
					<span class="subtitle"><?php echo trim($heading_subtitle); ?></span>
				<?php endif; ?>
			</<?php echo trim($heading_title_tag); ?>>
		<?php endif;

        if (!empty($heading_description)) : ?>
            <div class="description"><?php echo trim($heading_description); ?></div>
        <?php endif;
    }

    protected function get_product_type()
    {
        $type = [
            'newest' => esc_html__('Newest Products', 'urna'),
            'on_sale' => esc_html__('On Sale Products', 'urna'),
            'best_selling' => esc_html__('Best Selling', 'urna'),
            'top_rated' => esc_html__('Top Rated', 'urna'),
            'featured' => esc_html__('Featured Product', 'urna'),
            'random_product' => esc_html__('Random Product', 'urna'),
        ];

        return apply_filters('urna_woocommerce_product_type', $type);
    }

    protected function get_title_product_type($key)
    {
        $array = $this->get_product_type();

        return $array[$key];
    }

    protected function get_product_categories($number = '')
    {
        $args = array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        );
        if ($number === 0) {
            return;
        }
        if (!empty($number) && $number !== -1) {
            $args['number'] = $number;
        }
       

        $category = get_terms($args);
        $results = array();
        if (!is_wp_error($category)) {
            foreach ($category as $category) {
                $results[urna_get_transliterate($category->slug)] = $category->name.' ('.$category->count.') ';
            }
        }
        return $results;
    }

    protected function get_cat_operator()
    {
        $operator = [
            'IN' => esc_html__('IN', 'urna'),
            'NOT IN' => esc_html__('NOT IN', 'urna'),
        ];

        return apply_filters('urna_woocommerce_cat_operator', $operator);
    }

    protected function get_woo_order_by()
    {
        $oder_by = [
            'date' => esc_html__('Date', 'urna'),
            'title' => esc_html__('Title', 'urna'),
            'id' => esc_html__('ID', 'urna'),
            'price' => esc_html__('Price', 'urna'),
            'popularity' => esc_html__('Popularity', 'urna'),
            'rating' => esc_html__('Rating', 'urna'),
            'rand' => esc_html__('Random', 'urna'),
            'menu_order' => esc_html__('Menu Order', 'urna'),
        ];

        return apply_filters('urna_woocommerce_oder_by', $oder_by);
    }

    protected function get_woo_order()
    {
        $order = [
            'asc' => esc_html__('ASC', 'urna'),
            'desc' => esc_html__('DESC', 'urna'),
        ];

        return apply_filters('urna_woocommerce_order', $order);
    }

    protected function register_woocommerce_layout_type()
    {
        $layouts = array(
            'grid'          => 'Grid',
            'carousel'      => 'Carousel',
            'vertical'      => 'Vertical'
        );

        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'urna'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => $layouts,
            ]
        );
    }

    protected function register_woocommerce_order()
    {
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => $this->get_woo_order_by(),
                'conditions' => [
                    'relation' => 'AND',
                    'terms' => [
                        [
                            'name' => 'product_type',
                            'operator' => '!==',
                            'value' => 'top_rated',
                        ],
                        [
                            'name' => 'product_type',
                            'operator' => '!==',
                            'value' => 'random_product',
                        ],
                        [
                            'name' => 'product_type',
                            'operator' => '!==',
                            'value' => 'best_selling',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default' => 'asc',
                'options' => $this->get_woo_order(),
                'conditions' => [
                    'relation' => 'AND',
                    'terms' => [
                        [
                            'name' => 'product_type',
                            'operator' => '!==',
                            'value' => 'top_rated',
                        ],
                        [
                            'name' => 'product_type',
                            'operator' => '!==',
                            'value' => 'random_product',
                        ],
                        [
                            'name' => 'product_type',
                            'operator' => '!==',
                            'value' => 'best_selling',
                        ],
                    ],
                ],
            ]
        );
    }

    protected function register_woocommerce_categories_operator()
    {
        $categories = $this->get_product_categories();

        $this->add_control(
            'categories',
            [
                'label' => esc_html__('Categories', 'urna'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'default'   => array_keys($categories)[0],
                'options'   => $categories,
                'multiple' => true,
            ]
        );

        $this->add_control(
            'cat_operator',
            [
                'label' => esc_html__('Category Operator', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default' => 'IN',
                'options' => $this->get_cat_operator(),
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );
    }

    protected function get_woocommerce_tags()
    {
        $tags = array();
        
        $args = array(
            'order' => 'ASC',
        );

        $product_tags = get_terms('product_tag', $args);

        foreach ($product_tags as $key => $tag) {
            $tags[$tag->slug] = $tag->name . ' (' .$tag->count .')';
        }

        return $tags;
    }
    public function settings_layout()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (!isset($layout_type)) {
            return;
        }

        $this->add_render_attribute('row', 'class', $this->get_name_template());

        if (isset($rows) && !empty($rows)) {
            $this->add_render_attribute('row', 'class', 'rows-'. $rows);

            if ($rows != 1) {
                $this->add_render_attribute('row', 'class', 'row-no-one');
            }
        }

        if ($layout_type === 'carousel') {
            $this->settings_carousel($settings);
        } else {
            $this->settings_responsive($settings);
        }
    }
    
    protected function get_widget_field_img($image)
    {
        $image_id   = $image['id'];
        $img  = '';

        if (!empty($image_id)) {
            $img = wp_get_attachment_image($image_id, 'full');
        } elseif (!empty($image['url'])) {
            $img = '<img src="'. $image['url'] .'">';
        }

        return $img;
    }
    protected function get_name_tab_by_slug($tab_slug)
    {
        switch ($tab_slug) {
            case 'newest':
                $tab_name = esc_html__('New Arrivals', 'urna');
                break;
            case 'featured':
                $tab_name = esc_html__('Featured Products', 'urna');
                break;
            case 'best_selling':
                $tab_name = esc_html__('Best Seller', 'urna');
                break;
            case 'top_rated':
                $tab_name = esc_html__('Top Rated', 'urna');
                break;
            case 'on_sale':
                $tab_name = esc_html__('On Sale', 'urna');
                break;
            
            default:
                $tab_name = esc_html__('New Arrivals', 'urna');
                break;
        }
        return $tab_name;
    }

    protected function get_id_cat_product_by_slug($slug)
    {
        $category   = get_term_by('slug', $slug, 'product_cat');
        $id   = $category->term_id;

        return $id;
    }

    protected function get_products_category_childs($categories, $id_parent, $level, &$dropdown)
    {
        foreach ($categories as $key => $category) {
            if ($category->category_parent == $id_parent) {
                $dropdown = array_merge($dropdown, array( str_repeat("- ", $level) . $category->name . ' (' .$category->count .')' => $category->term_id ));
                unset($categories[$key]);
                $this->get_products_category_childs($categories, $category->term_id, $level + 1, $dropdown);
            }
        }
    }

    protected function render_controls_tab($tab_id)
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        $i = 0; ?>
        <ul role="tablist" class="nav nav-tabs">
            <?php foreach ($categoriestabs as $tab) : ?>

            <?php

                if (isset($show_catname_tabs) && $show_catname_tabs == 'yes') {
                    $category   = get_term_by('slug', $tab['category'], 'product_cat');
                    $tab_name   = $category->name;
                } else {
                    $tab_slug = (isset($tab['product_type'])) ? $tab['product_type'] : '';
                    
                    if (!empty($tab['title'])) {
                        $tab_name = $tab['title'];
                    } else {
                        $tab_name = $this->get_name_tab_by_slug($tab_slug);
                    }
                } ?> 
            <?php
                $li_class = ($i == 0 ? ' class="active"' : ''); ?>
            <li <?php echo trim($li_class); ?>>
                <a href="#tab-<?php echo esc_attr($tab_id); ?>-<?php echo esc_attr($i); ?>" data-toggle="tab">
                    <?php echo esc_html($tab_name); ?>
                </a>
            </li>

            <?php $i++;
        endforeach; ?>
        </ul>
        <?php
    }

    
    public function render_layout_products_tab($tab)
    {
        $product_type = $category = $cat_operator  = $limit = $orderby = $order = '';
        $rows = 1;
        extract($tab);

        $settings = $this->get_settings_for_display();
        extract($settings);

        $loop = urna_get_query_products($category, $cat_operator, $product_type, $limit, $orderby, $order);
    
        $attr_row = $this->get_render_attribute_string('row');
 
        $active_theme = urna_tbay_get_part_theme();

        wc_get_template('layout-products/'. $active_theme .'/'. $layout_type .'.php', array( 'loop' => $loop, 'attr_row' => $attr_row, 'rows' => $rows));
    }


    protected $nav_menu_index = 1;

    protected function get_nav_menu_index()
    {
        return $this->nav_menu_index++;
    }

    
    protected function render_item_icon($selected_icon)
    {
        $settings = $this->get_settings_for_display();

        if (! isset($selected_icon['icon']) && ! Icons_Manager::is_migration_allowed()) {
            // add old default
            $selected_icon['icon'] = 'fa fa-star';
        }
        $has_icon = ! empty($selected_icon['icon']);

        if ($has_icon) {
            $this->add_render_attribute('i', 'class', $selected_icon['icon']);
            $this->add_render_attribute('i', 'aria-hidden', 'true');
        }
        
        if (! $has_icon && ! empty($selected_icon['value'])) {
            $has_icon = true;
        }
        
        if (! empty($selected_icon['value'])) {
            $this->add_render_attribute('i', 'class', $selected_icon['value']);
            $this->add_render_attribute('i', 'aria-hidden', 'true');
        }

        $migrated = isset($settings['__fa4_migrated']['selected_icon']);
        $is_new = empty($settings['icon']) && Icons_Manager::is_migration_allowed();

        Icons_Manager::enqueue_shim();

        if (!$has_icon) {
            return;
        }

        if ($is_new || $migrated) :
            Icons_Manager::render_icon($selected_icon, [ 'aria-hidden' => 'true' ]); else : ?>
            <i class="<?php echo esc_attr($settings['icon']); ?>" aria-hidden="true"></i>
        <?php endif;
    }

    protected function register_display_description_skin_technology_v2()
    {
        $skin = urna_tbay_get_theme();

        $type = apply_filters('urna_woo_config_product_layout', 10, 2);

        if ($type !== 'v5') {
            return;
        }

        if ($skin !== 'technology-v2') {
            return;
        }

        $this->add_control(
            'show_des',
            [
                'label'         => esc_html__('Show Short Description', 'urna'),
                'description'   => esc_html__('Only displayed in product style 5 on theme options', 'urna'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes'
            ]
        );
    }

    protected function render_content_menu($menu_id)
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $available_menus = $this->get_available_menus();

        if (!$available_menus) {
            return;
        }
        
        $_id = urna_tbay_random_key();

        $args = [
            'echo'        => false,
            'menu'        => $menu_id,
            'container_class' => 'collapse navbar-collapse',
            'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $_id,
            'walker'      => new Urna_Tbay_Nav_Menu(),
            'fallback_cb' => '__return_empty_string',
            'container'   => '',
        ];

        $args['menu_class']     = 'elementor-nav-menu menu';


        // General Menu.
        $menu_html = wp_nav_menu($args);

        $this->add_render_attribute('main-menu', 'class', [
            'elementor-nav-menu--main',
            'elementor-nav-menu__container'
        ]); ?>
        <div class="tab-menu-wrapper">
            <nav <?php echo trim($this->get_render_attribute_string('main-menu')); ?>><?php echo trim($menu_html); ?></nav>
        </div>
        <?php
    }

    protected function get_item_icon_svg($selected_icon)
    {
        if (! isset($selected_icon['value']['id'])) {
            return '';
        }

        return Svg_Handler::get_inline_svg($selected_icon['value']['id']);
    }
}
