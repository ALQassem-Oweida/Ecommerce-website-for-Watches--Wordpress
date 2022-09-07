<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Product_Categories_Tabs')) {
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
class Urna_Elementor_Product_Categories_Tabs extends Urna_Elementor_Carousel_Base
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
        return 'tbay-product-categories-tabs';
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
        return esc_html__('Urna Product Categories Tabs', 'urna');
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
        return 'eicon-product-tabs';
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
        return [ 'woocommerce-elements', 'product-categories' ];
    }

    protected function register_controls()
    {
        $this->register_controls_heading();
        $this->register_remove_heading_element();
        
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('Product Categories', 'urna'),
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Number of products', 'urna'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Number of products to show ( -1 = all )', 'urna'),
                'default' => 6,
                'min'  => -1,
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
        $this->add_control(
            'product_type',
            [
                'label'   => esc_html__('Product Type', 'urna'),
                'type'     => Controls_Manager::SELECT,
                'options' => $this->get_product_type(),
                'default' => 'newest'
            ]
        );
        $this->register_woocommerce_layout_type();

        
        $this->add_control(
            'ajax_tabs',
            [
                'label' => esc_html__( 'Ajax Categories Tabs', 'urna' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => esc_html__( 'Show/hidden Ajax Categories Tabs', 'urna' ), 
            ]
        );

        $repeater = $this->register_category_repeater();

        $this->add_control(
            'categories',
            [
                'label' => esc_html__('Categories', 'urna'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->register_view_all();

        $this->register_display_description_skin_technology_v2();

        $this->end_controls_section();
        $this->add_control_responsive(['layout_type!' => 'list']);
        $this->add_control_carousel(['layout_type' => [ 'carousel', 'carousel-special', 'special' ]]);
    }

    protected function register_category_repeater()
    {
        $repeater = new \Elementor\Repeater();

        $categories = $this->get_product_categories();
        $repeater->add_control(
            'category',
            [
                'label'     => esc_html__('Category', 'urna'),
                'type'      => Controls_Manager::SELECT,
                'default'   => array_keys($categories)[0],
                'options'   => $categories,
            ]
        );

        $repeater->add_control(
            'category_type',
            [
                'label' => esc_html__('Display Type', 'urna'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'icon',
                'options' => [
                    'icon' => [
                        'title' => esc_html__('Icon', 'urna'),
                        'icon' => 'fa fa-info',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'urna'),
                        'icon' => 'fa fa-image',
                    ],
                ],
                'default' => 'icon',
            ]
        );

        $repeater->add_control(
            'category_icon',
            [
                'label'     => esc_html__('Select icon', 'urna'),
                'type'      => Controls_Manager::ICONS,
                'condition' => [
                    'category_type' => 'icon'
                ]
            ]
        );

        $repeater->add_control(
            'category_image',
            [
                'label' => esc_html__('Choose Image', 'urna'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'category_type' => 'image'
                ]
            ]
        );
        $repeater->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'full',
                'separator' => 'none',
                'condition' => [
                    'category_type' => 'image'
                ]
            ]
        );


        return $repeater;
    }

    protected function register_view_all()
    {
        $this->add_control(
            'show_view_all',
            [
                'label'     => esc_html__('Display View All', 'urna'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control(
            'view_all_text',
            [
                'label'     => esc_html__('Text Button', 'urna'),
                'type'      => Controls_Manager::TEXT,
                'default' => esc_html__('View All', 'urna'),
                'condition' => [
                    'show_view_all' => 'yes'
                ]
            ]
        );
    }
   
    public function render_tabs_title($categories, $random_id)
    {
        $settings = $this->get_settings_for_display();
        $product_type = $cat_operator  = $limit = $orderby = $order = '';
        extract($settings);

        if ($ajax_tabs === 'yes') {
            $this->add_render_attribute('row', 'class', ['products']);
            $attr_row = $this->get_render_attribute_string('row'); 

            $show_des = (isset($show_des) && $show_des === 'yes') ? true : false;
            $json = array(
                'product_type'                  => $product_type,
                'cat_operator'                  => $cat_operator,
                'limit'                         => $limit,
                'orderby'                       => $orderby, 
                'order'                         => $order,
                'attr_row'                      => $attr_row, 
                'layout_type'                   => $layout_type,
                'show_des'                      => $show_des,
                'rows'                          => $rows,  
            ); 

            $encoded_settings  = wp_json_encode( $json );

            $tabs_data = 'data-atts="'. esc_attr( $encoded_settings ) .'"';
        } else {
            $tabs_data = '';
        }
        ?>
        <ul class="product-categories-tabs-title tabs-list nav nav-tabs" <?php echo trim($tabs_data); ?>>
            <?php $_count = 0; ?>
            <?php foreach ( $categories as $item ) : ?>
                <?php $this->render_product_tab($item, $_count, $random_id); ?>
                <?php $_count++; ?>
            <?php endforeach; ?>
        </ul>
       <?php
    }

    public function render_product_tab($item, $_count, $random_id) {
        
        ?>
        <?php 
            $active = ($_count == 0) ? 'active' : '';
            $category = get_term_by( 'slug', $item['category'], 'product_cat' );

            if( !empty($category->name) ) {
                $title = $category->name;
            } else {
                $title = '';
            } 
        ?>   
        <li class="<?php echo esc_attr($active); ?>">
            <a data-value="<?php echo esc_attr($item['category']); ?>" href="#<?php echo esc_attr($item['category'].'-'. $random_id); ?>" data-toggle="tab" aria-controls="<?php echo esc_attr($item['category'].'-'. $random_id); ?>"><?php $this->render_item_type($item); ?><?php echo trim($title);?></a>
        </li>

       <?php
    }

    public function render_product_tabs_content($categories, $random_id)
    {
        $settings = $this->get_settings_for_display();
        ?>
            <div class="tbay-addon-inner"> 
                <div class="tbay-addon-content tab-content">
                 <?php
                    $_count = 0;
                    foreach ($categories as $item) {
                        $tab_active = ($_count == 0) ? ' active active-content current' : '';
                        ?>
                            <div class="tab-pane animated fadeIn <?php echo esc_attr($tab_active); ?>" id="<?php echo esc_attr($item['category']).'-'.$random_id; ?>">
                            <?php 
                                if( $_count === 0 || $settings['ajax_tabs'] !== 'yes' ) {
                                    $this->render_content_tab($item['category']);
                                }
                                $_count++; 
                            ?>
                            <?php $this->render_item_btn_view_all($item); ?>
                        </div>
                        <?php
                    } ?>
                </div>
            </div>
        <?php
    }
    private function render_content_tab($item)
    {
        $settings = $this->get_settings_for_display();
        $cat_operator = $product_type = $limit = $orderby = $order = '';
        $rows = 1;
        extract($settings);

        $show_des = (isset($show_des) && $show_des === 'yes') ? true : false;
        
        /** Get Query Products */
        $loop = urna_get_query_products($item, $cat_operator, $product_type, $limit, $orderby, $order);

        if ($layout_type === 'carousel') {
            $this->add_render_attribute('row', 'class', ['products', 'rows-'.$rows ]);
        }

        $attr_row = $this->get_render_attribute_string('row'); ?>
        
        <?php wc_get_template('layout-products/'. $layout_type .'.php', array( 'loop' => $loop, 'attr_row' => $attr_row, 'layout_type' => $layout_type, 'rows' => $rows, 'show_des' => $show_des )); ?>
        <?php
    }

    private function render_item_type($item)
    {
        $type = $item['category_type'];

        if ($type === 'icon') {
            $this->render_item_icon($item['category_icon']);
        } elseif ($type === 'image') {
            $image_id = $item['category_image']['id'];
            if (isset($image_id) && !empty($image_id)) {
                echo  wp_get_attachment_image($image_id, $item['thumbnail_size']);
            }
        }
    }
    
    public function render_item_btn_view_all($item)
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if ($show_view_all !== 'yes') {
            return;
        }

        $category = get_term_by('slug', $item['category'], 'product_cat');
        $url_category =  get_term_link($category);

        if (isset($view_all_text) && !empty($view_all_text)) {?>
            <a href="<?php echo esc_url($url_category)?>" class="show-all"><?php echo trim($view_all_text) ?></a>
            <?php
        }
    }

    public function on_import($element)
    {
        return Elementor\Icons_Manager::on_import_migration($element, 'icon', 'category_icon', true);
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Product_Categories_Tabs());
