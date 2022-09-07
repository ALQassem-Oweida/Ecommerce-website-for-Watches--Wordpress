<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Categories_Tabs_width_Banner')) {
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
class Urna_Elementor_Categories_Tabs_width_Banner extends Urna_Elementor_Carousel_Base
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
        return 'tbay-categories-tabs-with-banner';
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
        return esc_html__('Urna Products Categories Tabs With Banner', 'urna');
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
        return [ 'woocommerce-elements', 'product-categories', 'Categories', 'banner', 'tabs' ];
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
            'heading_banner',
            [
                'label' => esc_html__('Banner', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'positions',
            [
                'label' => esc_html__('Positions Banner', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default'   => 'left',
                'options'   => [
                    'left'      => esc_html__('Left', 'urna'),
                    'right'     => esc_html__('Right', 'urna'),
                ],
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Choose Image', 'urna'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'full',
                'separator' => 'none',
            ]
        );

        $repeater->add_control(
            'enable_add_link',
            [
                'label' => esc_html__('Enable Custom Link', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        
        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('External link', 'urna'),
                'type' => Controls_Manager::URL,
                'condition'   => [
                    'enable_add_link' => 'yes',
                ],
                'placeholder' => esc_html__('https://your-link.com', 'urna'),
            ]
        );

        return $repeater;
    }
   
    public function render_product_tab($categories, $random_id)
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
            <?php
                $__count=0; ?>

            <?php foreach ($categories as $key) { ?>
                    <?php
                        $active = ($__count==0)? 'active':'';
                        
                        $category   = get_term_by('slug', $key['category'], 'product_cat');
                        $title      = $category->name;

                    ?>
                    <li class="<?php echo esc_attr($active); ?>">
                        <a data-value="<?php echo esc_attr($key['category']); ?>" href="#tab-<?php echo esc_attr($key['category'].'-'.$random_id); ?>" data-toggle="tab" data-title="<?php echo esc_attr($title);?>">
                            <?php echo trim($title);?>
                        </a>
                    </li>
                <?php $__count++; ?>
            <?php } ?>
        </ul>
        

       <?php
    }

    public function render_product_tabs_content($categories, $random_id)
    {
        ?>
            <div class="tbay-addon-inner">
                <div class="tbay-addon-content tab-content">
                 <?php
                    $_count=0;
                    foreach ($categories as $index => $key) {
                        $tab_active = ($_count == 0) ? ' active active-content current' : '';
                                
                        $this->render_content_tab($key, $tab_active, $random_id, $index, $_count);

                        $_count++;
                    } 
                ?>
                </div>
            </div>
        <?php
    }

    private function render_content_tab_banner($tab, $index, $category)
    {
        extract($tab);

        $banner_positions = (isset($positions)) ? $positions : '';
        $image_id = $image['id'];



        $item_setting_key = $this->get_repeater_setting_key('banner_link', 'tabs', $index);

        $this->add_render_attribute($item_setting_key, 'class', 'banner-link');
        if ($enable_add_link === 'yes' && !empty($link['url'])) {
            $this->add_link_attributes($item_setting_key, $link);
        } else {
            $category = get_term_by('slug', $category, 'product_cat');
           
            $url_category =  get_term_link($category);

            $this->add_render_attribute($item_setting_key, 'href', $url_category);
            $this->add_render_attribute($item_setting_key, 'target', '_blank');
        } ?>

        <?php if (!empty($image_id)) : ?>
        <div class="pull-<?php echo esc_attr($banner_positions); ?> hidden-sm hidden-xs tab-banner">
            <div class="img-banner">

                <?php if (!empty($link['url']) || $enable_add_link !== 'yes') : ?>

                    <a <?php echo trim($this->get_render_attribute_string($item_setting_key)); ?>>
                        <?php $this->render_content_tab_img($image_id, $thumbnail_size); ?>
                    </a>

                <?php else : ?>

                    <?php $this->render_content_tab_img($image_id, $thumbnail_size); ?>

                <?php endif; ?>

            </div>
        </div>
        <?php endif;
    }

    private function render_content_tab_img($image_id, $thumbnail_size)
    {
        echo  wp_get_attachment_image($image_id, $thumbnail_size);
    }

    private function render_content_tab($key, $tab_active, $random_id, $index, $_count)
    {
        $settings = $this->get_settings_for_display();
        $cat_operator = $product_type = $limit = $orderby = $order = '';
        $rows = 1;
        extract($settings);
        extract($key);

        $banner_positions = (isset($positions)) ? $positions : '';

        if ($layout_type === 'carousel') {
            $this->add_render_attribute('row', 'class', ['products', 'rows-'.$rows]);
        }

        $attr_row = $this->get_render_attribute_string('row'); ?>
        <div id="tab-<?php echo esc_attr($category).'-'.esc_attr($random_id); ?>" class="tab-pane animated fadeIn <?php echo esc_attr($tab_active); ?> <?php echo esc_attr($banner_positions); ?>">
        
        <?php $this->render_content_tab_banner($key, $index, $category); ?>
  
        <?php  
            if ($_count === 0 || $ajax_tabs !== 'yes') : 

            /** Get Query Products */
            $loop = urna_get_query_products($category, $cat_operator, $product_type, $limit, $orderby, $order);
        ?>
            <?php wc_get_template('layout-products/'. $layout_type .'.php', array( 'loop' => $loop, 'attr_row' => $attr_row, 'layout_type' => $layout_type, 'rows' => $rows )); ?>
        <?php endif; ?>

        </div>
        <?php
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Categories_Tabs_width_Banner());
