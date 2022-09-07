<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Brands')) {
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
class Urna_Elementor_Brands extends Urna_Elementor_Carousel_Base
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
        return 'tbay-brands';
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
        return esc_html__('Urna Brands', 'urna');
    }

    public function get_script_depends()
    {
        return [ 'slick', 'urna-slick' ];
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
        return 'eicon-meta-data';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
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
        $this->add_control(
            'brands_align',
            [
                'label' => esc_html__('Align', 'urna'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'urna'),
                        'icon' => 'fas fa-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'urna'),
                        'icon' => 'fas fa-align-center'
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'urna'),
                        'icon' => 'fas fa-align-right'
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item .inner,.tbay-element-brands .row.grid > div' => 'justify-content: {{VALUE}} !important; display: flex; width: 100%;',
                ]
            ]
        );

        $repeater = $this->register_brands_repeater();
        $this->add_control(
            'brands',
            [
                'label' => esc_html__('Brand Items', 'urna'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls()
            ]
        );

        $this->register_control_viewall();

        $this->end_controls_section();

        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);

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

    /**
     * @since 2.1.0
     * @access private
     */
    private function get_max_columns()
    {
        $value = apply_filters('urna_admin_elementor_brands_columns', [
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
        ]);

        return $value;
    }

    protected function register_control_viewall()
    {
        $this->add_control(
            'enable_readmore',
            [
                'label' => esc_html__('Enable Button "Read More" ', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'separator'    => 'before',
                'default' => '',
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

        if (!isset($enable_readmore) || $enable_readmore !== 'yes' || empty($readmore_link['url'])) {
            return;
        }

        $this->add_link_attributes('show_all', $readmore_link);
        $this->add_render_attribute('show_all', 'class', 'show-all');

        echo '<a '. trim($this->get_render_attribute_string('show_all')) .' >'. trim($readmore_text) .'</a>';
    }

    protected function register_brands_repeater()
    {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'brand_image',
            [
                'label' => esc_html__('Choose Image', 'urna'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'brand_link',
            [
                'label' => esc_html__('Link to', 'urna'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'urna'),
            ]
        );

        return $repeater;
    }

    protected function render_item($item)
    {
        extract($item); ?> 
        <div class="inner"> 
           <?php
                $image_id           = $brand_image['id'];
        $link               = $brand_link['url'];
        $is_external        = $brand_link['is_external'];
        $nofollow           = $brand_link['nofollow'];

        $attribute = '';
        if ($is_external === 'on') {
            $attribute .= ' target="_blank"';
        }

        if ($nofollow === 'on') {
            $attribute .= ' rel="nofollow"';
        } ?>

           <?php if (isset($link) && !empty($link)) : ?>
                <a href="<?php echo esc_url($link); ?>" <?php echo trim($attribute); ?>>
                    <?php echo wp_get_attachment_image($image_id, 'full'); ?>
                </a>
            <?php else: ?>
                <?php echo wp_get_attachment_image($image_id, 'full'); ?>
            <?php endif; ?>

        </div>
        <?php
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Brands());
