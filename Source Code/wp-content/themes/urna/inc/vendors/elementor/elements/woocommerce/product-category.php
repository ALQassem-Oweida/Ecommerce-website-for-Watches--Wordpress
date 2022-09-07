<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Product_Category')) {
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
class Urna_Elementor_Product_Category extends Urna_Elementor_Carousel_Base
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
        return 'tbay-product-category';
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
        return esc_html__('Urna Product Category', 'urna');
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
        return [ 'woocommerce-elements', 'product', 'products', 'category' ];
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
        $this->add_control(
            'feature_image',
            [
                'label'     => esc_html__('Feature Image', 'urna'),
                'type'      => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'urna'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->register_woocommerce_order();
        $this->register_woocommerce_layout_type();

        $categories = $this->get_product_categories();

        $this->add_control(
            'category',
            [
                'label'     => esc_html__('Category', 'urna'),
                'type'      => Controls_Manager::SELECT,
                'default'   => array_keys($categories)[0],
                'options'   => $categories,
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
    
    public function render_item_image($settings)
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $image_id           = $settings['feature_image']['id'];
        if (empty($image_id)) {
            return;
        }

        $category = get_term_by('slug', $category, 'product_cat');
        $url_category =  get_term_link($category); ?>
            <div class="product-category-image tbay-addon-banner">
                <a href="<?php echo esc_url($url_category)?>" class="category-link">
                    <?php echo wp_get_attachment_image($image_id, 'full'); ?>
                </a>
            </div>
        <?php
    }
    public function render_item_button()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $category = get_term_by('slug', $category, 'product_cat');
        $url_category =  get_term_link($category);
        if (isset($text_button) && !empty($text_button)) {?>
            <a href="<?php echo esc_url($url_category)?>" class="show-all"><?php echo trim($text_button) ?>
                <?php
                    $this->render_item_icon($icon_button);
                ?>
                
            </a>
            <?php
        }
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Product_Category());
