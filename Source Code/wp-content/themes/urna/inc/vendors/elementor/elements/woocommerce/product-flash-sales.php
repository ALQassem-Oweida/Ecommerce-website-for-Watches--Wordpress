<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Product_Flash_Sales')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Urna_Elementor_Product_Flash_Sales extends Urna_Elementor_Carousel_Base
{
    public function get_name()
    {
        return 'tbay-product-flash-sales';
    }

    public function get_title()
    {
        return esc_html__('Urna Product Flash Sales Main', 'urna');
    }

    public function get_categories()
    {
        return [ 'urna-elements', 'woocommerce-elements'];
    }

    public function get_icon()
    {
        return 'eicon-flash';
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
        return ['slick', 'urna-slick', 'jquery-countdowntimer'];
    }

    public function get_keywords()
    {
        return [ 'woocommerce-elements', 'product', 'products', 'Flash Sales', 'Flash' ];
    }

    protected function register_controls()
    {
        $this->register_controls_heading();
        $this->register_remove_heading_element();

        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__('General', 'urna'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->register_control_main();

        $this->register_control_viewall();

        $this->end_controls_section();

        $this->add_control_responsive();

        $this->add_control_carousel(['layout_type' => 'carousel']);
    }

    private function register_control_main()
    {
        $prefix = 'main_';
        $this->add_control(
            $prefix .'advanced',
            [
                'label' => esc_html__('Main', 'urna'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'date_title',
            [
                'label' => esc_html__('Title Date', 'urna'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Deals end in:', 'urna'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'date_title_ended',
            [
                'label' => esc_html__('Title deal ended', 'urna'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Deal ended.', 'urna'),
                'label_block' => true,
            ]
        );


        $this->add_control(
            'end_date',
            [
                'label' => esc_html__('End Date', 'urna'),
                'type' => Controls_Manager::DATE_TIME,
                'label_block' => true,
                'placeholder' => esc_html__('Choose the end time', 'urna'),
            ]
        );

        $this->add_control(
            'bg_top_flash_sale',
            [
                'label' => esc_html__('Background Top Flash Sale', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .top-flash-sale-wrapper' => 'background: {{VALUE}};',
                ],
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

        $products = $this->get_available_on_sale_products();
        
        if (!empty($products)) {
            $this->add_control(
                $prefix .'products',
                [
                    'label'        => esc_html__('Products', 'urna'),
                    'type'         => Controls_Manager::SELECT2,
                    'options'      => $products,
                    'default'      => array_keys($products)[0],
                    'multiple' => true,
                    'save_default' => true,
                    'label_block' => true,
                    'description' => esc_html__('Only search for sale products', 'urna'),
                ]
            );
        } else {
            $this->add_control(
                $prefix .'html_products',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('You do not have any discount products. <br>Go to the <strong><a href="%s" target="_blank">Products screen</a></strong> to create one.', 'urna'), admin_url('edit.php?post_type=product')),
                    'separator'       => 'after',
                    'label_block' => true,
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }
    }

    protected function register_control_viewall()
    {
        $this->add_control(
            'enable_readmore',
            [
                'label' => esc_html__('Enable Button "Read More" ', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'separator'    => 'before',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'readmore_position',
            [
                'label' => esc_html__('Position button', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default'   => 'bottom',
                'options'   => [
                    'top'      => esc_html__('Top', 'urna'),
                    'bottom'  => esc_html__('Bottom', 'urna'),
                ],
            ]
        );

        $this->add_control(
            'readmore_text',
            [
                'label' => esc_html__('Custom Text Link', 'urna'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'enable_readmore' => 'yes'
                ],
                'default' => esc_html__('Read More', 'urna'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'readmore_link',
            [
                'label' => esc_html__('Custom Link', 'urna'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'enable_readmore' => 'yes'
                ],
                'placeholder' => esc_html__('https://your-link.com', 'urna'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );
    }

    protected function render_btn_readmore()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (! empty($readmore_link['url'])) {
            $this->add_link_attributes('show_all', $readmore_link);
        }
        
        if (isset($enable_readmore) && $enable_readmore === 'yes' && !empty($readmore_link['url'])) : ?>
            <a class="show-all" <?php echo trim($this->get_render_attribute_string('show_all')); ?>><?php echo trim($readmore_text); ?></a>
        <?php endif;
    }

    public function render_content_main()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $prefix = 'main_';

        $ids = ${$prefix.'products'};


        if (count($ids) === 0) {
            echo '<div class="not-product-flash-sales">'. esc_html__('Please select the show product', 'urna')  .'</div>';
            return;
        }
        
        $args = array(
            'post_type'            => 'product',
            'ignore_sticky_posts'  => 1,
            'no_found_rows'        => 1,
            'posts_per_page'       => -1,
            'orderby'              => 'post__in',
            'post__in'             => $ids,
        );

        if (version_compare(WC()->version, '2.7.0', '<')) {
            $args[ 'meta_query' ]   = isset($args[ 'meta_query' ]) ? $args[ 'meta_query' ] : array();
            $args[ 'meta_query' ][] = WC()->query->visibility_meta_query();
        } elseif (taxonomy_exists('product_visibility')) {
            $product_visibility_term_ids = wc_get_product_visibility_term_ids();
            $args[ 'tax_query' ]         = isset($args[ 'tax_query' ]) ? $args[ 'tax_query' ] : array();
            $args[ 'tax_query' ][]       = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => is_search() ? $product_visibility_term_ids[ 'exclude-from-search' ] : $product_visibility_term_ids[ 'exclude-from-catalog' ],
                'operator' => 'NOT IN',
            );
        }

        $loop = new WP_Query($args);

        $end_date     = strtotime($end_date);
        if (!$loop->have_posts()) {
            return;
        }

        if ($layout_type === 'carousel') {
            $this->add_render_attribute('row', 'class', ['products', 'rows-'.$rows]);
        }

        $attr_row = $this->get_render_attribute_string('row');

        wc_get_template('layout-products/'. $layout_type .'.php', array( 'loop' => $loop, 'attr_row' => $attr_row , 'flash_sales' => true, 'end_date' => $end_date, 'layout_type' => $layout_type, 'rows' => $rows));
    }
    public function deal_end_class()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);


        $class_deal_ended   = '';
        $end_date           = strtotime($end_date);
        $today              = strtotime("today");
        if (!empty($end_date) &&  ($today > $end_date)) {
            $class_deal_ended = 'tbay-addon-deal-ended';
        }

        return $class_deal_ended;
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Product_Flash_Sales());
