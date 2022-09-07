<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Products')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Urna_Elementor_Products extends Urna_Elementor_Carousel_Base
{
    public function get_name()
    {
        return 'tbay-products';
    }

    public function get_title()
    {
        return esc_html__('Urna Products', 'urna');
    }

    public function get_categories()
    {
        return [ 'urna-elements', 'woocommerce-elements'];
    }

    public function get_icon()
    {
        return 'eicon-products';
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

    public function get_keywords()
    {
        return [ 'woocommerce-elements', 'product', 'products' ];
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
            'advanced',
            [
                'label' => esc_html__('Advanced', 'urna'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->register_woocommerce_layout_type();

        $this->register_woocommerce_order();

        $this->register_woocommerce_categories_operator();

        $this->add_control(
            'product_type',
            [
                'label' => esc_html__('Product Type', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default' => 'newest',
                'options' => $this->get_product_type(),
            ]
        );

        $this->register_button();
        $this->register_display_description_skin_technology_v2();

        $this->end_controls_section();
        $this->add_control_responsive(['layout_type!' => 'list']);
        $this->add_control_carousel(['layout_type' => [ 'carousel', 'carousel-special', 'special' ]]);
    }

    protected function register_button()
    {
        $this->add_control(
            'show_more',
            [
                'label'     => esc_html__('Display Show More', 'urna'),
                'type'      => Controls_Manager::SWITCHER,
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
    public function render_item_button($category = '')
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        if ($show_more !== 'yes') {
            return;
        }
        
        if (!empty($category) && !is_array($category)) {
            $category       = get_term_by('slug', $category, 'product_cat');
            $url_category   = get_term_link($category->term_id, 'product_cat');
        } else {
            $url_category =  get_permalink(wc_get_page_id('shop'));
        }
        
        if (isset($text_button) && !empty($text_button)) {?>

            <a href="<?php echo esc_url($url_category)?>" class="show-all">
                <?php echo '<span class="text">'.trim($text_button) .'</span>'; ?>
            </a>
            <?php
        }
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Products());
