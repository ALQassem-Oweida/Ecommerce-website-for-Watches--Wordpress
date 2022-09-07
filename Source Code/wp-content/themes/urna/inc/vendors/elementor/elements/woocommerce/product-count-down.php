<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Product_CountDown')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Urna_Elementor_Product_CountDown extends Urna_Elementor_Carousel_Base
{
    public function get_name()
    {
        return 'tbay-product-count-down';
    }

    public function get_title()
    {
        return esc_html__('Urna Product CountDown', 'urna');
    }

    public function get_categories()
    {
        return [ 'urna-elements', 'woocommerce-elements'];
    }

    public function get_icon()
    {
        return 'eicon-countdown';
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
        return [ 'slick', 'urna-slick', 'jquery-countdowntimer' ];
    }

    public function get_keywords()
    {
        return [ 'woocommerce-elements', 'product', 'products', 'countdown'];
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

        
        $this->add_control(
            'countdown_title',
            [
                'label' => esc_html__('Title Date', 'urna'),
                'default' => esc_html__('Deal ends in:', 'urna'),
                'type' => Controls_Manager::TEXT,
            ]
        );


        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'urna'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'options'   => array(
                    'grid'          => 'Grid',
                    'carousel'      => 'Carousel',
                ),
                'default'   => 'grid'
            ]
        );
 
        $products = $this->get_available_products_countdown();
        
        if (!empty($products)) {
            $this->add_control(
                'products',
                [
                    'label'        => esc_html__('Products', 'urna'),
                    'type'         => Controls_Manager::SELECT2,
                    'options'      => $products,
                    'default'      => array_keys($products)[0],
                    'multiple'     => true,
                    'save_default' => true,
                    'label_block'  => true,
                    'description'  => esc_html__('Only search for products by the countdown', 'urna'),
                   
                ]
            );
        } else {
            $this->add_control(
                'html_products',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('You do not have any discount products. <br>Go to the <strong><a href="%s" target="_blank">Products screen</a></strong> to create one.', 'urna'), admin_url('edit.php?post_type=product')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                   
                ]
            );
        }

        $this->register_new_options_skin_kitchen();

        $this->end_controls_section();
        
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type!' =>  array('grid', 'list') ]);
    }

    protected function register_new_options_skin_kitchen()
    {
        $skin = urna_tbay_get_theme();
        if ($skin !== 'kitchen') {
            return;
        }

        $this->add_control(
            'heading_banner',
            [
                'label' => esc_html__('Banner', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_banner',
            [
                'label'     => esc_html__('Display Show Banner?', 'urna'),
                'description'     => esc_html__('Show/hidden Show banner', 'urna'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'banners',
            [
                'label' => esc_html__('Banner', 'urna'),
                'type' => Controls_Manager::GALLERY,
                'condition' => [
                    'show_banner' => 'yes'
                ],
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        
        $this->add_control(
            'banner_link',
            [
                'label' => esc_html__('External link', 'urna'),
                'type' => Controls_Manager::URL,
                'condition' => [
                    'show_banner' => 'yes'
                ],
                'placeholder' => esc_html__('https://your-link.com', 'urna'),
            ]
        );

        $this->add_control(
            'heading_menu',
            [
                'label' => esc_html__('Menu', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'show_menu',
            [
                'label'     => esc_html__('Display Show Menu?', 'urna'),
                'description'     => esc_html__('Show/hidden show menu', 'urna'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $menus = $this->get_available_menus();

        if (!empty($menus)) {
            $this->add_control(
                'nav_menu',
                [
                    'label'        => esc_html__('Menu', 'urna'),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => $menus,
                    'default'      => array_keys($menus)[0],
                    'save_default' => true,
                    'separator'    => 'after',
                    'condition' => [
                        'show_menu' => 'yes'
                    ],
                    'description'  => sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'urna'), admin_url('nav-menus.php')),
                ]
            );
        } else {
            $this->add_control(
                'nav_menu',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'urna'), admin_url('nav-menus.php?action=edit&menu=0')),
                    'separator'       => 'after',
                    'condition' => [
                        'show_menu' => 'yes'
                    ],
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }
    }

    public function render_content_banner_count_down()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        if (!isset($show_banner) || $show_banner !== 'yes') {
            return;
        }

        

        if (!empty($banner_link['url'])) {
            $this->add_render_attribute('banner_link', 'href', $banner_link['url']);

            if ($banner_link['is_external'] === 'on') {
                $this->add_render_attribute('banner_link', 'target', '_blank');
            }
            if ($banner_link['nofollow'] === 'on') {
                $this->add_render_attribute('banner_link', 'rel', 'nofollow');
            }
        }

        if (is_array($banners) || is_object($banners)) : ?>
            <?php if (isset($banner_link) && !empty($banner_link)) : ?>
                <div class="img-banner col-sm-6 col-md-8 col-lg-3 clearfix">
                    <a <?php echo trim($this->get_render_attribute_string('banner_link')); ?>>
                        <?php
                            foreach ($banners as $i => $banner) {
                                if (!empty($banner['id'])) {
                                    echo wp_get_attachment_image($banner['id'], 'full', false);
                                }
                            } ?>
                    </a>
                </div>
            <?php else : ?>
                <div class="img-banner col-sm-6 col-md-8 col-lg-3 clearfix">
                    <?php
                        foreach ($banners as $i => $banner) {
                            if (!empty($banner['id'])) {
                                echo wp_get_attachment_image($banner['id'], 'full', false);
                            }
                        } ?>
                </div>
            <?php endif; ?>
        <?php endif;
    }

    public function render_content_menu_count_down()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (!isset($show_menu)) {
            return;
        }

        if ($show_menu === 'yes' && !empty($nav_menu)) : ?>

            <div class="custom-menu-wrapper col-sm-6 col-md-4 col-lg-3">
                <?php
                    $menu_id = $nav_menu;
        urna_get_custom_menu($menu_id); ?>
            </div>

        <?php endif;
    }

    public function render_content_product_count_down()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        $ids = ${'products'};
        if (!is_array($ids)) {
            $atts['ids'] = $ids;
        } else {
            if (count($ids) === 0) {
                echo '<div class="not-product-count-down">'. esc_html__('Please select the show product', 'urna')  .'</div>';
                return;
            }

            $atts['ids'] = implode(',', $ids);
        }

        $type = 'products';

        $shortcode = new WC_Shortcode_Products($atts, $type);
        $args = $shortcode->get_query_args();

        $loop = new WP_Query($args);

        if (!$loop->have_posts()) {
            return;
        }

        $countdown = true;

        if ($layout_type === 'carousel') {
            $this->add_render_attribute('row', 'class', ['products', 'rows-'.$rows]);
        }

        $attr_row = $this->get_render_attribute_string('row');

        wc_get_template('layout-products/'. $layout_type .'.php', array( 'loop' => $loop, 'countdown' => $countdown,'countdown_title' => $countdown_title, 'layout_type' => $layout_type,'attr_row' => $attr_row));
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Product_CountDown());
