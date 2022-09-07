<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Social_Icons')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Urna_Elementor_Social_Icons extends Urna_Elementor_Widget_Base
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
        return 'tbay-social-icons';
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
        return esc_html__('Urna Social Icons', 'urna');
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
        return 'eicon-social-icons';
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
                'label' => esc_html__('Style', 'urna'),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__('Style 1', 'urna'),
                    'style2' => esc_html__('Style 2', 'urna'),
                    'style3' => esc_html__('Style 3', 'urna'),
                ],
            ]
        );

        
        $this->add_control(
            'social_align',
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
                'condition' => array(
                    'styles' => ['style1', 'style2'],
                ),
                'selectors' => [
                    '{{WRAPPER}} ul.social' => 'justify-content: {{VALUE}} !important;',
                ]
            ]
        );
        
        $repeater = $this->register_social_repeater();
        $this->add_control(
            'social_icon_list',
            [
                'label' => esc_html__('Social Icons', 'urna'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'social_icon' => [
                            'value' => 'fab fa-facebook',
                            'library' => 'fa-brands',
                        ],
                    ],
                    [
                        'social_icon' => [
                            'value' => 'fab fa-twitter',
                            'library' => 'fa-brands',
                        ],
                    ],
                    [
                        'social_icon' => [
                            'value' => 'fab fa-youtube',
                            'library' => 'fa-brands',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__('View', 'urna'),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();
        $this->register_content_social_styles();
    }

    protected function register_social_repeater()
    {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'social_icon',
            [
                'label' => esc_html__('Icon', 'urna'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'social',
                'label_block' => true,
                'default' => [
                    'value' => 'fab fa-wordpress',
                    'library' => 'fa-brands',
                ],
                'recommended' => [
                    'fa-brands' => [
                        'android',
                        'apple',
                        'behance',
                        'bitbucket',
                        'codepen',
                        'delicious',
                        'deviantart',
                        'digg',
                        'dribbble',
                        'urna',
                        'facebook',
                        'flickr',
                        'foursquare',
                        'free-code-camp',
                        'github',
                        'gitlab',
                        'globe',
                        'houzz',
                        'instagram',
                        'jsfiddle',
                        'linkedin',
                        'medium',
                        'meetup',
                        'mixcloud',
                        'odnoklassniki',
                        'pinterest',
                        'product-hunt',
                        'reddit',
                        'shopping-cart',
                        'skype',
                        'slideshare',
                        'snapchat',
                        'soundcloud',
                        'spotify',
                        'stack-overflow',
                        'steam',
                        'stumbleupon',
                        'telegram',
                        'thumb-tack',
                        'tripadvisor',
                        'tumblr',
                        'twitch',
                        'twitter',
                        'viber',
                        'vimeo',
                        'vk',
                        'weibo',
                        'weixin',
                        'whatsapp',
                        'wordpress',
                        'xing',
                        'yelp',
                        'youtube',
                        '500px',
                    ],
                    'fa-solid' => [
                        'envelope',
                        'link',
                        'rss',
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'urna'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'default' => [
                    'is_external' => 'true',
                ],
                'placeholder' => esc_html__('https://your-link.com', 'urna'),
            ]
        );

        return $repeater;
    }

    protected function register_content_social_styles()
    {
        $this->start_controls_section(
            'section_social_style',
            [
                'label' => esc_html__('Item Social', 'urna'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('icon_colors');

        $this->start_controls_tab(
            'icon_colors_normal',
            [
                'label' => esc_html__('Normal', 'urna'),
                'styles' => [
                    '!feature_type' => 'style2'
                ]
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => esc_html__('Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} li a' => 'color: {{VALUE}};',
                ],
                'styles' => [
                    '!feature_type' => 'style2'
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_colors_hover',
            [
                'label' => esc_html__('Hover', 'urna'),
                'styles' => [
                    '!feature_type' => 'style2'
                ],
            ]
        );

        $this->add_control(
            'hover_primary_color',
            [
                'label' => esc_html__('Hover Color', 'urna'),
                'type' => Controls_Manager::COLOR,
                'styles' => [
                    '!feature_type' => 'style2'
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} li a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
 
        $this->add_responsive_control(
            'style_icon_size',
            [
                'label' => esc_html__('Font Size Icon', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .social > li a i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
         
        $this->add_responsive_control(
            'style_icon_size_width_height',
            [
                'label' => esc_html__('Width/Height Icon', 'urna'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .social > li a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .social > li a i' => ' line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'style_icon_size_margin',
            [
                'label' => esc_html__('Margin Icon', 'urna'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .social > li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();
    }

    public function social_icon_item($index, $item)
    {
        $settings = $this->get_settings_for_display();

        $migration_allowed = \Elementor\Icons_Manager::is_migration_allowed();
        $fallback_defaults = [
            'fa fa-facebook',
            'fa fa-twitter',
            'fa fa-google-plus',
        ];

        $migrated = isset($item['__fa4_migrated']['social_icon']);
        $is_new = empty($item['social']) && $migration_allowed;
        $social = '';

        // add old default
        if (empty($item['social']) && ! $migration_allowed) {
            $item['social'] = isset($fallback_defaults[ $index ]) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
        }

        if (! empty($item['social'])) {
            $social = str_replace('fa fa-', '', $item['social']);
        }

        if (($is_new || $migrated) && 'svg' !== $item['social_icon']['library']) {
            $social = explode(' ', $item['social_icon']['value'], 2);
            if (empty($social[1])) {
                $social = '';
            } else {
                $social = str_replace('fa-', '', $social[1]);
            }
        }

        $social = str_replace('icon-social-', '', $social);

        if (strpos($social, 'icon-') !== false) {
            $social = str_replace('icon-', '', $social);
        } elseif (strpos($social, 'zmdi-') !== false) {
            $social = str_replace('zmdi-', '', $social);
        }

        if ('svg' === $item['social_icon']['library']) {
            $social = '';
        }

        $link_key = 'link_' . $index;

        $this->add_render_attribute($link_key, 'href', $item['link']['url']);

        $this->add_render_attribute($link_key, 'class', $social);

        if ($item['link']['is_external']) {
            $this->add_render_attribute($link_key, 'target', '_blank');
        }

        if ($item['link']['nofollow']) {
            $this->add_render_attribute($link_key, 'rel', 'nofollow');
        } ?>
        <li><a <?php echo trim($this->get_render_attribute_string($link_key)); ?>>
            <?php $this->render_item_icon($item['social_icon']); ?>
            <?php if ($settings['styles'] === 'style3') {
            echo trim($social);
        } ?>
        </a></li>
        <?php
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Social_Icons());
