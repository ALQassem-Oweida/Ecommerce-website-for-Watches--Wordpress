<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Custom_Image_List_Categories')) {
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
class Urna_Elementor_Custom_Image_List_Categories extends Urna_Elementor_Carousel_Base
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
        return 'tbay-custom-image-list-categories';
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
        return esc_html__('Urna Custom Image List Categories', 'urna');
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
        return [ 'woocommerce-elements', 'custom-image-list-categories' ];
    }

    protected function register_controls()
    {
        $this->register_controls_heading();
        $this->register_remove_heading_element();

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('Custom Image List Categories', 'urna'),
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
                'label'     => esc_html__('Layout Type', 'urna'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'urna'),
                    'carousel'  => esc_html__('Carousel', 'urna'),
                ],
            ]
        );

        $repeater = $this->register_category_repeater();
        $this->add_control(
            'categoriestabs',
            [
                'label'         => esc_html__('List Categories Items', 'urna'),
                'type'          => Controls_Manager::REPEATER,
                'separator'     => 'after',
                'fields'        => $repeater->get_controls(),
            ]
        );

        $this->register_display_shop_now_skins();
 
        $this->register_display_count();
        $this->register_button();

        $this->register_new_options_skin_minimal();

        $this->end_controls_section();
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
        $this->remove_control('rows');
        $this->remove_control_skin_book();

        $this->register_content_item_styles();
    }

    protected function register_content_item_styles()
    {
        $this->start_controls_section(
            'section_item_style',
            [
                'label' => esc_html__('List Category Style', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'style_item_icon_size',
            [
                'label' => esc_html__('Font Size Icon', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 120,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .item-cat i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .cat-icon > svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'style_item_icon_padding',
            [
                'label' => esc_html__('Padding Size Icon', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .item-cat i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'style_item_content_margin',
            [
                'label' => esc_html__('Margin Content', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .item-cat' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'style_item_content_padding',
            [
                'label' => esc_html__('Padding Content', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .item-cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function register_category_repeater()
    {
        $repeater = new \Elementor\Repeater();

        $categories = $this->get_product_categories();
        $repeater->add_control(
            'category',
            [
                'label' => esc_html__('Choose category', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default'   => array_keys($categories)[0],
                'options'   => $categories,
            ]
        );

        $this->register_cat_new_options_repeater($repeater);

        $repeater->add_control(
            'images',
            [
                'label' => esc_html__('Choose Image', 'urna'),
                'type' => Controls_Manager::MEDIA,
                'condition'   => [
                    'cat_style' => 'images',
                ],
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
  

        $repeater->add_control(
            'check_custom_link',
            [
                'label' => esc_html__('Show Custom Link', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );

        $repeater->add_control(
            'custom_link',
            [
                'label' => esc_html__('Custom Link', 'urna'),
                'type' => Controls_Manager::URL,
                'condition' => [
                    'check_custom_link' => 'yes'
                ],
                'placeholder' => esc_html__('https://your-link.com', 'urna'),
            ]
        );

        $this->register_category_repeater_women($repeater);
        $this->register_category_repeater_beauty($repeater);

        return $repeater;
    }

    protected function register_cat_new_options_repeater($repeater)
    {
        $skin = urna_tbay_get_theme();

        $array_skins = array(
            'beauty',
            'book',
            'women'
        );

        if (!in_array($skin, $array_skins, true)) {
            $repeater->add_control(
                'cat_style',
                [
                    'label' => esc_html__('Choose Style', 'urna'),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'images' => [
                            'title' => esc_html__('Image', 'urna'),
                            'icon' => 'fa fa-image',
                        ],
                        'icon' => [
                            'title' => esc_html__('Icon', 'urna'),
                            'icon' => 'fa fa-info',
                        ],
                    ],
                    'default' => 'images',
                ]
            );

            $repeater->add_control(
                'icon',
                [
                    'label'       => esc_html__('Icon Button', 'urna'),
                    'type'        => Controls_Manager::ICONS,
                    'label_block' => true,
                    'default'     => [
                        'value'   => 'fas fa-info',
                        'library' => 'fa-solid',
                    ],
                    'condition'   => [
                        'cat_style'   => 'icon',
                    ]
                ]
            );
        } else {
            $repeater->add_control(
                'cat_style',
                [
                    'label' => esc_html__('Choose Style', 'urna'),
                    'type' => Controls_Manager::HIDDEN,
                    'default' => 'images',
                ]
            );
        }



        return $repeater;
    }

    protected function register_new_options_skin_minimal()
    {
        $skin = urna_tbay_get_theme();

        if ($skin !== 'minimal') {
            return;
        }

        $this->remove_control('count_item');
    }

    protected function register_category_repeater_women($repeater)
    {
        $skin = urna_tbay_get_theme();

        if ($skin !== 'women') {
            return $repeater;
        }

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'urna'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        return $repeater;
    }

    protected function register_category_repeater_beauty($repeater)
    {
        $skin = urna_tbay_get_theme();

        if ($skin !== 'beauty' && $skin !== 'book') {
            return $repeater;
        }

        $menus = $this->get_available_menus();

        if (!empty($menus)) {
            $repeater->add_control(
                'nav_menu',
                [
                    'label'        => esc_html__('Menu', 'urna'),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => $menus,
                    'default'      => array_keys($menus)[0],
                    'save_default' => true,
                    'separator'    => 'after',
                    'description'  => sprintf(__('Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'urna'), admin_url('nav-menus.php')),
                ]
            );
        } else {
            $repeater->add_control(
                'nav_menu',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'urna'), admin_url('nav-menus.php?action=edit&menu=0')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }

        return $repeater;
    }

    protected function remove_control_skin_book()
    {
        $skin = urna_tbay_get_theme();
        if ($skin !== 'book') {
            return;
        }

        $this->remove_control('count_item');
    }

    protected function register_display_count()
    {
        $this->add_control(
            'count_item',
            [
                'label'     => esc_html__('Show Count Category', 'urna'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
    }

    protected function register_display_shop_now_skins()
    {
        $skin = urna_tbay_get_theme();

        $array_skins = array(
            'women',
            'minimal',
            'sportwear'
        );
        if (!in_array($skin, $array_skins, true)) {
            return;
        }

        $this->add_control(
            'shop_now',
            [
                'label'         => esc_html__('Display Shop Now?', 'urna'),
                'description'   => esc_html__('Show/hidden Shop Now in each category', 'urna'),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes'
            ]
        );
        $this->add_control(
            'shop_now_text',
            [
                'label'     => esc_html__('Text Button Shop Now', 'urna'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('Shop Now', 'urna'),
                'condition' => [
                    'shop_now' => 'yes'
                ]
            ]
        );
    }

    protected function register_button()
    {
        $this->add_control(
            'show_more',
            [
                'label'     => esc_html__('Display Show More', 'urna'),
                'type'      => Controls_Manager::SWITCHER,
                'separator'    => 'before',
                'default' => 'no'
            ]
        );
        $this->add_control(
            'text_button',
            [
                'label'     => esc_html__('Text Button', 'urna'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('show more', 'urna'),
                'condition' => [
                    'show_more' => 'yes'
                ]
            ]
        );
    }

    public function render_item_button()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (!isset($show_more)) {
            return;
        }

        if (!$show_more) {
            return;
        }

        $url_category =  get_permalink(wc_get_page_id('shop'));
        if (isset($text_button) && !empty($text_button)) {?>
            <a href="<?php echo esc_url($url_category)?>" class="show-all">
                <?php echo '<span class="text">'.trim($text_button) .'</span>'; ?>
            </a>
            <?php
        }
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Custom_Image_List_Categories());
