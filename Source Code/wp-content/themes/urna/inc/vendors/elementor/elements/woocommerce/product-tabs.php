<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Product_Tabs')) {
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
class Urna_Elementor_Product_Tabs extends Urna_Elementor_Carousel_Base
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
        return 'tbay-product-tabs';
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
        return esc_html__('Urna Product Tabs', 'urna');
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
        return 'eicon-tabs';
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
        return [ 'woocommerce-elements', 'product', 'products', 'tabs' ];
    }

    protected function register_controls()
    {
        $this->register_controls_heading();
        $this->register_remove_heading_element();

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('Product Tabs', 'urna'),
            ]
        );
        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Number of products ( -1 = all )', 'urna'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
                'min'  => -1
            ]
        );
        $this->register_woocommerce_layout_type();
        $this->register_woocommerce_categories_operator();

        $this->add_control(
            'ajax_tabs',
            [
                'label' => esc_html__( 'Ajax Product Tabs', 'urna' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => esc_html__( 'Show/hidden Ajax Product Tabs', 'urna' ), 
            ]
        );

        $this->register_controls_product_tabs();
        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'urna'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => $this->get_woo_order_by(),
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default' => 'asc',
                'options' => $this->get_woo_order(),
            ]
        );
        $this->register_button();
        $this->register_display_description_skin_technology_v2();
        $this->end_controls_section();
        $this->add_control_responsive(['layout_type!' => 'list']);
        $this->add_control_carousel(['layout_type' => [ 'carousel', 'carousel-special', 'special' ]]);
    }

    public function register_controls_product_tabs()
    {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'product_tabs_title',
            [
                'label' => esc_html__('Title', 'urna'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'product_tabs',
            [
                'label' => esc_html__('Show Tabs', 'urna'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_product_type(),
                'default' => 'newest',
            ]
        );
        $this->add_control(
            'list_product_tabs',
            [
                'label' => esc_html__('Tab Item', 'urna'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => $this->register_set_product_tabs_default(),
                'title_field' => '{{{ product_tabs_title }}}',
            ]
        );
    }

    private function register_set_product_tabs_default()
    {
        $defaults = [
            [
                'product_tabs_title'    => esc_html__('Newest', 'urna'),
                'product_tabs'          => 'newest',
            ],
            [
                'product_tabs_title' => esc_html__('On Sale', 'urna'),
                'product_tabs'       => 'on_sale',
            ],
            [
                'product_tabs_title' => esc_html__('Best Selling', 'urna'),
                'product_tabs'       => 'best_selling',
            ],
        ];

        return $defaults;
    }

    public function render_product_tabs($product_tabs, $key_id, $random_id, $title, $active)
    {
        ?>
            <li class="<?php echo esc_attr($active); ?>">
                <a href="#<?php echo esc_attr($product_tabs.'-'.$random_id .'-'.$key_id); ?>" data-value="<?php echo esc_attr($product_tabs); ?>"  data-toggle="tab" data-title="<?php echo esc_attr($title); ?>" ><?php echo trim($title)?></a> 
            </li>

       <?php
    }
    public function render_content_tab($product_tabs)
    {
        $settings = $this->get_settings_for_display();
        $rows = 1;
        extract($settings);
        
        $show_des = (isset($show_des) && $show_des === 'yes') ? true : false;

        $this->add_render_attribute('row', 'class', $this->get_name_template());

        $product_type = $product_tabs;

        /** Get Query Products */
        $loop = urna_get_query_products($categories, $cat_operator, $product_type, $limit, $orderby, $order);

        if ($layout_type === 'carousel') {
            $this->add_render_attribute('row', 'class', [ 'products', 'rows-'.$rows ]);
        }

        $attr_row = $this->get_render_attribute_string('row');

        wc_get_template('layout-products/'. $layout_type .'.php', array( 'loop' => $loop, 'attr_row' => $attr_row, 'layout_type' => $layout_type, 'rows' => $rows, 'show_des' => $show_des ));
    }

    public function render_product_tabs_content($list_product_tabs, $random_id)
    {   
        $settings = $this->get_settings_for_display();
        extract($settings);
        ?>
        <div class="tbay-addon-content tab-content woocommerce">
            <?php $_count = 0;?>
            <?php foreach ($list_product_tabs as $index => $key) {
                    $tab_active = ($_count==0)? 'active active-content current':'';
                    $product_tabs = $key['product_tabs'];

                    $tab_class_key = $this->get_repeater_setting_key( 'tab_class', 'gridwrapper', $index );

                    if ($layout_type == 'carousel' || $layout_type == 'carousel-special') {
                        $this->add_render_attribute( $tab_class_key, [
                            'class' => [ 'grid-wrapper' ],
                        ] ); 
                    } else { 
                        $this->add_render_attribute( $tab_class_key, [
                            'class' => ['grid-wrapper', 'products-grid'],
                        ] ); 
                    }
                    ?>
                    <div class="tab-pane animated fadeIn <?php echo esc_attr($tab_active); ?>" id="<?php echo esc_attr($key['product_tabs']).'-'.$random_id .'-'.$key['_id']; ?>">
                        <div <?php echo trim($this->get_render_attribute_string($tab_class_key)); ?>>
                        <?php
                        if( $_count === 0 || $settings['ajax_tabs'] !== 'yes' ) {
                            $this->render_content_tab($product_tabs);
                        }

                        $_count++;
                        ?>
                        </div>
                    </div>
                    <?php
                }
            ?> 
        </div>
        <?php
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

        if (!isset($show_more)) {
            return;
        }

        if (!$show_more) {
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
$widgets_manager->register_widget_type(new Urna_Elementor_Product_Tabs());
