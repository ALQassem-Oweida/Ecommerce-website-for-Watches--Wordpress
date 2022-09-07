<?php
if (!defined('URNA_CORE_ACTIVED')) {
    return;
}

class Urna_Widget_Popup_Newsletter extends Urna_Widget
{
    public function __construct()
    {
        parent::__construct(
            'urna_popup_newsletter',
            esc_html__('Urna Popup Newsletter', 'urna'),
            array( 'description' => esc_html__('Show Popup Newsletter', 'urna'), )
        );
        $this->widgetName = 'popup_newsletter';
        add_action('admin_enqueue_scripts', array($this, 'scripts'));
    }
    
    public function scripts()
    {
        $suffix = (urna_tbay_get_config('minified_js', false)) ? '.min' : URNA_MIN_JS;
        wp_enqueue_script('tbay-upload-image', URNA_CORE_URL . 'assets/upload.js', array( 'jquery', 'wp-pointer' ), URNA_CORE_VERSION, true);
        wp_enqueue_script('urna-script-admin-js', URNA_SCRIPTS . '/admin/admin' . $suffix . '.js', array( 'jquery' ), URNA_CORE_VERSION, true);
    }

    public function getTemplate()
    {
        $this->template = 'popup-newsletter.php';
    }

    public function widget($args, $instance)
    {
        $this->display($args, $instance);
    }
    
    public function form($instance)
    {
        $list_socials = array(
            'facebook'      => 'Facebook',
            'twitter'       => 'Twitter',
            'youtube-play'  => 'Youtube',
            'pinterest'     => 'Pinterest',
            'linkedin'      => 'LinkedIn',
            'instagram'     => 'Instagram',
        );
        $defaults = array('title' => 'Newsletter', 'description' => "Put your content here", 'image' => '', 'socials' => array());
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><strong><?php esc_html_e('Title:', 'urna'); ?></strong></label>
            <input type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']) ; ?>" class="widefat" />
        </p>
                

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Description:', 'urna'); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>"  cols="20" rows="3"><?php echo trim($instance['description']) ; ?></textarea>
        </p>

        <label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php esc_html_e('Image:', 'urna'); ?></label>
        <div class="screenshot">
            <?php if (isset($instance['image']) && $instance['image']) { ?>
                <img src="<?php echo esc_url($instance['image']); ?>" style="max-width:100%">
            <?php } ?>
        </div>
        <input class="widefat upload_image" id="<?php echo esc_attr($this->get_field_id('image')); ?>" name="<?php echo esc_attr($this->get_field_name('image')); ?>" type="hidden" value="<?php echo esc_attr($instance['image']); ?>" />
        <div class="upload_image_action">
            <input type="button" class="button add-image" value="Add">
            <input type="button" class="button remove-image" value="Remove">
        </div>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('socials')); ?>"><?php esc_html_e('Select socials:', 'urna'); ?></label>
            <br>
        <?php
            foreach ($list_socials as $key => $value):
                $checked = (isset($instance['socials'][$key]['status']) && ($instance['socials'][$key]['status'])) ? 1: 0;
        $link = (isset($instance['socials'][$key]['page_url'])) ? $instance['socials'][$key]['page_url']: ''; ?>
                <p>
                <input class="checkbox" type="checkbox" <?php checked($checked, 1); ?> id="<?php echo esc_attr($key); ?>"
                    name="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr($key); ?>][status]" />
                    <label for="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr($key); ?>][status]">
                        <?php echo esc_html__('Show ', 'urna').esc_html($value); ?>
                    </label>
                <input type="hidden" name="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr($key); ?>][name]" value=<?php echo esc_attr($value); ?> />
                </p>

                <?php
                   $check_value =  ($checked)? 'block': 'none'; ?>
                <p style="display: <?php echo trim($check_value); ?>" id="<?php echo esc_attr($this->get_field_id($key)); ?>" class="text_url <?php echo esc_attr($key); ?>">
                    <label for="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr($key); ?>][page_url]">
                        <?php echo esc_html($value).' '.esc_html__('Page URL:', 'urna').' '; ?>
                    </label>
                    <input class="widefat" type="text"
                        id="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr($key); ?>][page_url]"
                        name="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr($key); ?>][page_url]"
                        value="<?php echo esc_attr($link); ?>"
                    />
                </p>
            <?php endforeach; ?>
        </p>
        
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = (! empty($new_instance['title'])) ? ($new_instance['title']) : '';
        $instance['description'] = (! empty($new_instance['description'])) ? strip_tags($new_instance['description']) : '';
        $instance['image'] = (! empty($new_instance['image'])) ? strip_tags($new_instance['image']) : '';
        $instance['socials'] = $new_instance['socials'];
        return $instance;
    }
}
