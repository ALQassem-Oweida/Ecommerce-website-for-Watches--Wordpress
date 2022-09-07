<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Features')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Urna_Elementor_Features extends Urna_Elementor_Carousel_Base
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
        return 'tbay-features';
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
        return esc_html__('Urna Features', 'urna');
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
        return 'eicon-star-o';
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
            'styles',
            [
                'label'     => esc_html__('Choose style', 'urna'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'style-1',
                'options'   => [
                    'style-1'            => esc_html__('Style 1', 'urna'),
                    'style-2'            => esc_html__('Style 2', 'urna'),
                    'style-3'            => esc_html__('Style 3', 'urna'),
                ],
            ]
        );

        $features = $this->register_features_repeater();

        $this->add_control(
            'features',
            [
                'label' => esc_html__('Feature Item', 'urna'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $features->get_controls(),
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'urna'),
                'type'      => Controls_Manager::HIDDEN,
                'default'   => 'grid',
            ]
        );

        $this->end_controls_section();

        $this->add_control_responsive();

        $this->register_controls_item_style();
    }

    protected function register_features_repeater()
    {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'feature_title',
            [
                'label' => esc_html__('Title', 'urna'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        
        $repeater->add_control(
            'feature_desc',
            [
                'label' => esc_html__('Description', 'urna'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
        
        $repeater->add_control(
            'feature_type',
            [
                'label' => esc_html__('Display Type', 'urna'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'icon',
                'options' => [
                    'image' => [
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
            'selected_icon',
            [
                'label' => esc_html__('Choose Icon', 'urna'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'linear-icon-gift',
                    'library' => 'linear-icon',
                ],
                'condition' => [
                    'feature_type' => 'icon'
                ]
            ]
        );
        $repeater->add_control(
            'type_image',
            [
                'label' => esc_html__('Choose Image', 'urna'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'feature_type' => 'image'
                ]
            ]
        );

        return $repeater;
    }

    private function register_controls_item_style_icon()
    {
        $this->add_control(
            'heading_feature_icon',
            [
                'label' => esc_html__('Icon', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('feature_icon_tabs');

        $this->start_controls_tab(
            'feature_icon_tab_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
            ]
        );

        $this->add_control(
            'feature_icon_color',
            [
                'label' => esc_html__('Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .icon-inner i' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'feature_icon_tab_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
            ]
        );

        $this->add_control(
            'feature_icon_color_hover',
            [
                'label' => esc_html__('Hover Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                   '{{WRAPPER}} .icon-inner:hover i' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'feature_icon_font',
            [
                'label' => esc_html__('Font size Icon', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon-inner i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'feature_icon_spacing',
            [
                'label' => esc_html__('Margin Icon', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .icon-inner i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }

    private function register_controls_item_style_title()
    {
        $this->add_control(
            'heading_feature_title',
            [
                'label' => esc_html__('Title', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'feature_title_typography',
                'selector' => '{{WRAPPER}} .feature-box .ourservice-heading',
            ]
        );

        $this->start_controls_tabs('feature_title_tabs');

        $this->start_controls_tab(
            'feature_title_tab_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
            ]
        );

        $this->add_control(
            'feature_title_color',
            [
                'label' => esc_html__('Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .feature-box .ourservice-heading' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'feature_title_tab_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
            ]
        );

        $this->add_control(
            'feature_title_color_hover',
            [
                'label' => esc_html__('Hover Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                   '{{WRAPPER}} .feature-box:hover .ourservice-heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'feature_title_margin',
            [
                'label' => esc_html__('Margin', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .feature-box .ourservice-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }

    private function register_controls_item_style_description()
    {
        $this->add_control(
            'heading_feature_desc',
            [
                'label' => esc_html__('Description', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'feature_desc_typography',
                'selector' => '{{WRAPPER}} .feature-box .description',
            ]
        );

        $this->start_controls_tabs('feature_desc_tabs');

        $this->start_controls_tab(
            'feature_desc_tab_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
            ]
        );

        $this->add_control(
            'feature_desc_color',
            [
                'label' => esc_html__('Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .feature-box .description' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'feature_desc_tab_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
            ]
        );

        $this->add_control(
            'feature_desc_color_hover',
            [
                'label' => esc_html__('Hover Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .feature-box:hover .description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'feature_desc_margin',
            [
                'label' => esc_html__('Margin', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .feature-box .description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }

    private function register_controls_item_style_general()
    {
        $this->add_control(
            'heading_feature_item',
            [
                'label' => esc_html__('Item', 'urna'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'feature_align',
            [
                'label' => esc_html__('Align', 'urna'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'urna'),
                        'icon' => 'fas fa-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'urna'),
                        'icon' => 'fas fa-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'urna'),
                        'icon' => 'fas fa-align-right'
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .feature-box .inner' => 'text-align: {{VALUE}} !important',
                ]
            ]
        );

        $this->add_responsive_control(
            'feature_item_margin',
            [
                'label' => esc_html__('Margin', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .feature-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        
        $this->add_responsive_control(
            'feature_item_padding',
            [
                'label' => esc_html__('Padding', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .feature-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_item_features',
            [
                'label' => esc_html__('Border Item Features', 'urna'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'prefix_class' => 'border-item-features-',
                'condition' => [
                    'styles' => 'style-1'
                ]
            ]
        );
        $this->add_control(
            'border_item_features_color',
            [
                'label' => esc_html__('Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.border-item-features-yes .feature-box' => 'border-color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'condition' => [
                    'border_item_features' => 'yes'
                ]
            ]
        );
    }

    protected function register_controls_item_style()
    {
        $this->start_controls_section(
            'section_item_style',
            [
                'label' => esc_html__('Style Item', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->register_controls_item_style_general();
        $this->register_controls_item_style_title();
        $this->register_controls_item_style_description();
        $this->register_controls_item_style_icon();

        $this->end_controls_section();
    }

    protected function render_item($item)
    {
        extract($item); ?> 
        <div class="inner"> 
            <?php
                $this->render_item_fbox($feature_type, $type_image, $selected_icon);
        $this->render_item_content($feature_title, $feature_desc); ?>
        </div>
        <?php
    }
    public function render_item_content($feature_title, $feature_desc)
    {
        ?>
            <div class="fbox-content">
                <?php
                if (isset($feature_title) && !empty($feature_title)) {
                    ;
                } ?>
                    <h3 class="ourservice-heading">
                        <?php echo trim($feature_title) ?>
                    </h3>
                <?php
                if (isset($feature_desc) && !empty($feature_desc)) {
                    ;
                } ?>
                    <p class="description">
                        <?php echo trim($feature_desc) ?>
                    </p>
                <?php
                ?>
            </div>
        <?php
    }
    
    public function render_item_fbox($feature_type, $type_image, $selected_icon)
    {
        $image_id = $type_image['id'];

        $fbox_class = '';
        $fbox_class .= 'fbox-'.$feature_type; ?>
        <div class="<?php echo esc_attr($fbox_class); ?>">
            <?php if (isset($selected_icon['value']) && !empty($selected_icon['value'])): ?>
                <div class="icon-inner"><?php $this->render_item_icon($selected_icon) ?></div>
            <?php elseif (isset($image_id) && !empty($image_id)): ?>
                <div class="image-inner">
                    <?php echo wp_get_attachment_image($image_id, 'full', false); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php
    }
    
    public function on_import($element)
    {
        return Icons_Manager::on_import_migration($element, 'icon', 'selected_icon', true);
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Features());
