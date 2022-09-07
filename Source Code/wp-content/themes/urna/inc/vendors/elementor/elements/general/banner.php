<?php

if (! defined('ABSPATH') || function_exists('Urna_Elementor_Banner')) {
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
class Urna_Elementor_Banner extends Urna_Elementor_Widget_Base
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
        return 'tbay-banner';
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
        return esc_html__('Urna Banner', 'urna');
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
        return 'eicon-banner';
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'urna'),
            ]
        );
        $this->register_image_controls();
        $this->add_control(
            'add_link',
            [
                'label' => esc_html__('Add Link', 'urna'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->register_title_controls();
        $this->end_controls_section();
        $this->add_control_link();
    }

    protected function register_image_controls()
    {
        $this->add_control(
            'banner_image',
            [
                'label' => esc_html__('Choose Image', 'urna'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ]
            ]
        );
    }

    protected function register_title_controls()
    {
        $this->add_control(
            'banner_title',
            [
                'label' => esc_html__('Title', 'urna'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'banner_sub_title',
            [
                'label' => esc_html__('Sub Title', 'urna'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'banner_desc',
            [
                'label' => esc_html__('Description', 'urna'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
    }

    
    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function add_control_link()
    {
        $this->start_controls_section(
            'section_link_options',
            [
                'label' => esc_html__('Add Link Option', 'urna'),
                'type'  => Controls_Manager::SECTION,
                'condition' => array(
                    'add_link' => 'yes',
                ),
            ]
        );
        $this->add_control(
            'banner_link',
            [
                'label' => esc_html__('Link to', 'urna'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => 'https://your-link.com',
                ],
                'placeholder' => esc_html__('https://your-link.com', 'urna'),
            ]
        );
        $this->add_control(
            'style_link',
            [
                'label' => esc_html__('Style Link', 'urna'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'button' => esc_html__('Button', 'urna'),
                    'icon' => esc_html__('Icon', 'urna'),
                    'none' => esc_html__('None', 'urna')
                ],
                'default' => 'none',
            ]
        );
        $this->add_control(
            'style_button',
            [
                'label' => esc_html__('Text Button', 'urna'),
                'type' => Controls_Manager::TEXT,
                'condition' => array(
                    'style_link' => 'button',
                ),
            ]
        );
        $this->add_control(
            'style_icon',
            [
                'label' => esc_html__('Choose Icon', 'urna'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'tb-icon tb-icon-plus',
                    'library' => 'tbay-custom',
                ],
                'condition' => array(
                    'style_link' => 'icon',
                ),
            ]
        );
        
        $this->end_controls_section();
    }

    protected function render_item_description()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (empty($banner_desc)) {
            return;
        }

        echo '<p class="tbay-addon-description">'. trim($banner_desc) .'</p>';
    }

    protected function render_item_image()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $id            = $banner_image['id'];
        
        if (empty($id)) {
            return;
        }
        
        echo '<div class="image">' .wp_get_attachment_image($id, 'full'). '</div>';
    }

    protected function render_item_content()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if ($add_link !== 'yes') {
            return;
        }

        
        if (isset($banner_link['url']) && !empty($banner_link['url'])) {
            $this->add_render_attribute('link', 'href', $banner_link['url']);

            if ($banner_link['is_external'] === 'on') {
                $this->add_render_attribute('link', 'target', '_blank');
            }
    
            if ($banner_link['nofollow'] === 'on') {
                $this->add_render_attribute('link', 'rel', 'nofollow');
            }
        }

        $link_attribute = $this->get_render_attribute_string('link');

        switch ($style_link) {
            case 'icon':
                $this->render_item_style_icon($link_attribute);
                break;
            case 'button':
                $this->render_item_style_button($link_attribute);
                break;
            case 'none':
                $this->render_item_style_none($link_attribute);
                break;
            default:
                $this->render_item_style_none($link_attribute);
                break;
        }
    }

    private function render_item_style_icon($link_attribute)
    {
        $settings = $this->get_settings_for_display();
        extract($settings); ?>
        <a <?php echo trim($link_attribute) ?> class="icon">
            <?php $this->render_item_icon($style_icon); ?>
        </a>
        <?php
    }

    private function render_item_style_button($link_attribute)
    {
        $settings = $this->get_settings_for_display();
        extract($settings); ?>
        <a <?php echo trim($link_attribute) ?> class="button">
            <?php echo trim($style_button) ?>
        </a>
        <?php
    }

    private function render_item_style_none($link_attribute)
    {
        ?>
        <a <?php echo trim($link_attribute); ?> class="icon"></a>
        <?php
    }
   

    protected function render_banner_element_heading()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (!empty($banner_title) || !empty($banner_sub_title)) {
            ?>
            <h3 class="tbay-addon-title">
                <?php if (!empty($banner_title) && isset($banner_title)) : ?>
                    <div class="title"><?php echo trim($banner_title); ?></div>
                <?php endif; ?>

                <?php if (!empty($banner_sub_title) && isset($banner_sub_title)) : ?>
                    <div class="subtitle"><?php echo trim($banner_sub_title); ?></div>
                <?php endif; ?>
            </h3>
            
        <?php
        }
    }
}
$widgets_manager->register_widget_type(new Urna_Elementor_Banner());
