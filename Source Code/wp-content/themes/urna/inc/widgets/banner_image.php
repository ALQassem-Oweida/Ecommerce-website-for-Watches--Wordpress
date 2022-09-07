<?php

if (!defined('URNA_CORE_ACTIVED')) {
    return;
}

class Urna_Widget_Banner_Image extends Urna_Widget
{
    public function __construct()
    {
        parent::__construct(
            'urna_banner_image',
            esc_html__('Urna Banner Image', 'urna'),
            array( 'description' => esc_html__('Show banner image', 'urna'), )
        );
        $this->widgetName = 'banner_image';

        add_action('admin_enqueue_scripts', array($this, 'scripts'));
    }

    public function scripts()
    {
        wp_enqueue_script('tbay-upload-image', URNA_CORE_URL . 'assets/upload.js', array( 'jquery', 'wp-pointer' ), URNA_CORE_VERSION, true);
    }

    public function getTemplate()
    {
        $this->template = 'banner-image.php';
    }

    public function widget($args, $instance)
    {
        $this->display($args, $instance);
    }
    
    public function form($instance)
    {
        $defaults = array(
            'title' => '',
            'alt' => '',
            'url' => '#',
            'banner_image' => '',
            'description' => ''
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'urna'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        
        <label for="<?php echo esc_attr($this->get_field_id('banner_image')); ?>"><?php esc_html_e('Image:', 'urna'); ?></label>
        <div class="screenshot">
            <?php if (isset($instance['banner_image']) && $instance['banner_image']) { ?>
                <img src="<?php echo esc_url($instance['banner_image']); ?>">
            <?php } ?>
        </div>
        <input class="widefat upload_image" id="<?php echo esc_attr($this->get_field_id('banner_image')); ?>" name="<?php echo esc_attr($this->get_field_name('banner_image')); ?>" type="hidden" value="<?php echo esc_attr($instance['banner_image']); ?>" />
        <div class="upload_image_action">
            <input type="button" class="button add-image" value="Add">
            <input type="button" class="button remove-image" value="Remove">
        </div>
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('alt')); ?>"><?php esc_html_e('Alt:', 'urna'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('alt')); ?>" name="<?php echo esc_attr($this->get_field_name('alt')); ?>" type="text" value="<?php echo esc_attr($instance['alt']); ?>" />
        </p>        

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('url')); ?>"><?php echo esc_html__('Link banner:', 'urna'); ?></label>
            <br>
            <input class="widefat" id="<?php echo  esc_attr($this->get_field_id('url')); ?>" name="<?php echo esc_attr($this->get_field_name('url')); ?>" type="text" value="<?php echo esc_attr($instance['url']); ?>" />
        </p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['alt'] = (! empty($new_instance['alt'])) ? strip_tags($new_instance['alt']) : '';
        $instance['url'] = (! empty($new_instance['url'])) ? strip_tags($new_instance['url']) : '';
        $instance['banner_image'] = (! empty($new_instance['banner_image'])) ? strip_tags($new_instance['banner_image']) : '';
        return $instance;
    }
}
