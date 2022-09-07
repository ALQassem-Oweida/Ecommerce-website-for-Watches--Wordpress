<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Products_Banner_Menu')) {
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
class Urna_Elementor_Products_Banner_Menu extends Urna_Elementor_Carousel_Base
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
        return 'tbay-products-banner-menu';
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
        return esc_html__('Products Banner Menu', 'urna');
    }

    public function get_categories()
    {
        return [ 'urna-elements', 'woocommerce-elements'];
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
        return 'eicon-product-categories';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    public function get_script_depends()
    {
        return [ 'slick', 'urna-slick' ];
    }

    public function get_keywords()
    {
        return [ 'woocommerce-elements', 'products', 'category', 'banner', 'menu' ];
    }

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
            'limit',
            [
                'label' => esc_html__('Number of products', 'urna'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Number of products to show ( -1 = all )', 'urna'),
                'default' => 6,
                'min'  => -1
            ]
        );

        $this->register_config_banners();

        $this->register_config_menu();
        $this->register_show_all();

        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );
        $this->register_woocommerce_order();
        $this->register_woocommerce_layout_type();

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
            'product_type',
            [
                'label' => esc_html__('Product Type', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default' => 'newest',
                'options' => $this->get_product_type(),
            ]
        );

        $this->end_controls_section();
        $this->add_control_responsive(['layout_type!' => 'list']);
        $this->add_control_carousel(['layout_type' => [ 'carousel', 'carousel-special', 'special' ]]);
    }

    protected function register_config_banners()
    {
        $this->add_control(
            'show_banner',
            [
                'label' => esc_html__('Show Banner', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
 
        $this->add_control(
            'banner_positions',
            [
                'label' => esc_html__('Positions Banner', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default'   => 'left',
                'condition' => [
                    'show_banner' => 'yes'
                ],
                'options'   => [
                    'left'      => esc_html__('Left', 'urna'),
                    'right'     => esc_html__('Right', 'urna'),
                ],
            ]
        );

        $this->add_control(
            'attach_image',
            [
                'label'     => esc_html__('Banner', 'urna'),
                'type'      => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'show_banner' => 'yes'
                ],
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_control(
            'banner_link',
            [
                'label' => esc_html__('Custom Link', 'urna'),
                'type' => Controls_Manager::URL,
                'condition' => [
                    'show_banner' => 'yes'
                ],
                'placeholder' => esc_html__('https://your-link.com', 'urna'),
            ]
        );
    }

    protected function register_config_menu()
    {
        $this->add_control(
            'show_menu',
            [
                'label' => esc_html__('Show Menu', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'separator'    => 'before',
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'menu_positions',
            [
                'label' => esc_html__('Positions Menu', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default'   => 'top',
                'options'   => [
                    'top'      => esc_html__('Top', 'urna'),
                    'bottom'     => esc_html__('Bottom', 'urna'),
                ],
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
                    'condition' => [
                        'show_menu' => 'yes'
                    ],
                    'separator'    => 'after',
                    'description'  => sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'urna'), admin_url('nav-menus.php')),
                ]
            );
        } else {
            $this->add_control(
                'nav_menu',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'condition' => [
                        'show_menu' => 'yes'
                    ],
                    'raw'             => sprintf(__('<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'urna'), admin_url('nav-menus.php?action=edit&menu=0')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }
    }

    protected function register_show_all()
    {
        $this->add_control(
            'show_all',
            [
                'label' => esc_html__('Show "Read More"', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'text_button',
            [
                'label'     => esc_html__('Text Button', 'urna'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('Show All', 'urna'),
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );
    }

    public function render_item_menu()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        if (!isset($show_menu) || $show_menu !== 'yes') {
            return;
        } ?>
        <div class="custom-menu-wrapper hidden-xs">
            <?php
                $menu_id = $nav_menu;
        urna_get_custom_menu($menu_id); ?>
        </div>
        <?php
    }

    public function render_item_show_all()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        if (!isset($show_all) || $show_all !== 'yes') {
            return;
        }

        if (!empty($categories) && is_array($categories) && count($categories) === 1) {
            $url  = get_term_link($categories['0'], 'product_cat');
        } else {
            $url = get_permalink(wc_get_page_id('shop'));
        }

        $this->add_render_attribute('show_all', 'class', ['show-all']);
        $this->add_render_attribute('show_all', 'href', [$url]);

        echo '<a '. trim($this->get_render_attribute_string('show_all')) .'>'. trim($text_button) .'</a>';
    }
    
    public function render_item_banner()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        if (!isset($show_banner) || $show_banner !== 'yes') {
            return;
        }

        if (! empty($banner_link['url'])) {
            $this->add_link_attributes('banner_link', $banner_link);
        }

        $image_id = $attach_image['id'];
        
        if (empty($image_id)) {
            return;
        } ?>
        <div class="hidden-sm hidden-xs banner">
            <?php if (!empty($banner_link['url'])) : ?>
                <div class="img-banner">
                    <a <?php echo trim($this->get_render_attribute_string('banner_link')); ?> >
                        <?php $this->render_item_banner_img($image_id); ?>
                    </a>
                </div>
            <?php else : ?>
                <div class="img-banner">
                    <?php $this->render_item_banner_img($image_id); ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    private function render_item_banner_img($image_id)
    {
        echo  wp_get_attachment_image($image_id, 'full');
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Products_Banner_Menu());
