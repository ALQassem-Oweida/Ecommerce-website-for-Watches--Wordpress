<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Product_Recently_Viewed')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Urna_Elementor_Product_Recently_Viewed extends Urna_Elementor_Carousel_Base
{
    public function get_name()
    {
        return 'tbay-product-recently-viewed';
    }

    public function get_title()
    {
        return esc_html__('Urna Product Recently Viewed Main', 'urna');
    }

    public function get_categories()
    {
        return [ 'urna-elements', 'woocommerce-elements'];
    }

    public function get_icon()
    {
        return 'eicon-clock';
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
        return [ 'woocommerce-elements', 'product', 'products', 'Recently Viewed', 'Recently' ];
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
            'advanced',
            [
                'label' => esc_html__('Advanced', 'urna'),
                'type' => Controls_Manager::HEADING,
            ]
        );

       

        $this->add_control(
            'empty',
            [
                'label' => esc_html__('Empty Result - Custom Paragraph', 'urna'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('You have no recently viewed item.', 'urna'),
            ]
        );

        $this->register_control_main();

        $this->add_control(
            'enable_readmore',
            [
                'label' => esc_html__('Enable Button "Read More" ', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->add_control_responsive();

        $this->add_control_carousel(['layout_type' => 'carousel']);
        $this->register_control_viewall();

        $this->update_control_responsive_skins();
    }

    private function update_control_responsive_skins()
    {
        $skin = urna_tbay_get_theme();

        $array_skins = array(
            'auto-part',
            'marketplace-v1',
        );
        if (!in_array($skin, $array_skins, true)) {
            return;
        }

        $this->update_responsive_control(
            'column',
            [
                'options'   => $this->get_max_columns(),
            ]
        );

        $this->update_control(
            'col_desktop',
            [
                'options'   => $this->get_max_columns(),
            ]
        );

        $this->update_control(
            'col_desktopsmall',
            [
                'options'   => $this->get_max_columns(),
            ]
        );

        $this->update_control(
            'col_landscape',
            [
                'options'   => $this->get_max_columns(),
            ]
        );
    }

    private function register_control_main()
    {
        $this->add_control(
            'only_image',
            [
                'label' => esc_html__('Only image?', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'separator'    => 'before',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Number of products', 'urna'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Number of products to show ( -1 = all )', 'urna'),
                'default' => 8,
                'min'  => -1,
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
    }
 
    private function register_control_viewall()
    {
        $this->start_controls_section(
            'section_readmore',
            [
                'label' => esc_html__('Read More Options', 'urna'),
                'type'  => Controls_Manager::SECTION,
                'condition' => [
                    'enable_readmore' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'readmore_text',
            [
                'label' => esc_html__('Button "Read More" Custom Text', 'urna'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Read More', 'urna'),
                'label_block' => true,
            ]
        );

        $pages = $this->get_available_pages();

        if (!empty($pages)) {
            $this->add_control(
                'readmore_page',
                [
                    'label'        => esc_html__('Page', 'urna'),
                    'type'         => Controls_Manager::SELECT2,
                    'options'      => $pages,
                    'default'      => array_keys($pages)[0],
                    'save_default' => true,
                    'separator'    => 'after',
                    'label_block' => true,
                ]
            );
        } else {
            $this->add_control(
                'readmore_page',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no pages in your site.</strong><br>Go to the <a href="%s" target="_blank">pages screen</a> to create one.', 'urna'), admin_url('edit.php?post_type=page')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                    'label_block' => true,
                ]
            );
        }
        $this->end_controls_section();
    }
    
    public function get_max_columns()
    {
        $value = apply_filters('urna_admin_elementor_recently_viewed_header_columns', [
            1 => 1,
            2 => 2,
            3 => 3,
           4 => 4,
           5 => 5,
           6 => 6,
           7 => 7,
           8 => 8,
           9 => 9,
           10 => 10,
           11 => 11,
           12 => 12,
        ]);

        return $value;
    }

    private function render_empty()
    {
        $settings = $this->get_settings_for_display();
        echo '<div class="content-empty">'. trim($settings['empty']) .'</div>';
    }

    public function render_btn_readmore($count)
    {
        $settings = $this->get_settings_for_display();
        extract($settings);
        $products_list              =  urna_tbay_wc_track_user_get_cookie();
        $all                        =  count($products_list);

        if (!empty($readmore_page)) {
            $link = get_permalink($readmore_page);
        }

        if ($enable_readmore && ($all > $count) && !empty($link)) : ?>
            <div class="text-center"><a class="show-all" href="<?php echo esc_url($link); ?>" title="<?php esc_attr($readmore_text); ?>"><?php echo trim($readmore_text); ?></a></div>
        <?php endif;
    }

    public function render_content_main()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $args   = urna_tbay_get_products_recently_viewed($limit);

        $args   =  apply_filters('urna_list_recently_viewed_products_args', $args);
        $loop   = new WP_Query($args);

        if (!$loop->have_posts()) {
            $this->render_empty();
        }

        if ($layout_type === 'carousel') {
            $this->add_render_attribute('row', 'class', [ 'products', 'rows-'.$rows ]);
        }

        $attr_row = $this->get_render_attribute_string('row');

        wc_get_template('layout-products/'.$layout_type.'-recently-viewed.php', array( 'only_image' => $only_image, 'loop' => $loop, 'attr_row' => $attr_row, 'layout_type' => $layout_type, 'rows' => $rows));
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Product_Recently_Viewed());
