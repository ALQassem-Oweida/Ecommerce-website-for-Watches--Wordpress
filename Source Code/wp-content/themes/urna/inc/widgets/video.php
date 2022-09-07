<?php
if (!defined('URNA_CORE_ACTIVED')) {
    return;
}

class Urna_Widget_Featured_Video extends Urna_Widget
{
    public function __construct()
    {
        parent::__construct(
            // Base ID of your widget
            'urna_featured_video_widget',
            // Widget name will appear in UI
            esc_html__('Urna Featured Video', 'urna'),
             // Widget description
            array( 'description' => esc_html__('Show Featured video', 'urna'),)
        );
        $this->widgetName = 'video';
    }

    public function getTemplate()
    {
        $this->template = 'video.php';
    }

    public function widget($args, $instance)
    {
        $this->display($args, $instance);
    }

    public function form($instance)
    {
        $defaults = array(
            'title' => 'Featured Video',
            'video_link' => 'https://www.youtube.com/watch?v=sd0grLQ4voU',
            'video_name' => 'video guide',
            'video_width' =>  300
        );
        $instance = wp_parse_args((array) $instance, $defaults); ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_html__('Title:', 'urna'); ?></label>
            <br>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo  esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <p>
            <label for="<?php echo  esc_attr($this->get_field_id('video_link')); ?>"><?php echo esc_html__('Video link:', 'urna'); ?></label>
            <br>
            <input class="widefat" id="<?php echo  esc_attr($this->get_field_id('video_link')); ?>" name="<?php echo  esc_attr($this->get_field_name('video_link')); ?>" type="text" value="<?php echo esc_attr($instance['video_link']); ?>" />
            <br>
            <?php echo esc_html__('Support video from Youtube and Vimeo link. Ex: https://www.youtube.com/watch?v=sd0grLQ4voU', 'urna'); ?>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('video_name')); ?>"><?php echo esc_html__('Video name:', 'urna'); ?></label>
            <br>
            <input class="widefat" id="<?php echo  esc_attr($this->get_field_id('video_name')); ?>" name="<?php echo  esc_attr($this->get_field_name('video_name')); ?>" type="text" value="<?php echo esc_attr($instance['video_name']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('video_width')); ?>"><?php echo esc_html__('Video width:', 'urna'); ?></label>
            <br>
            <input class="widefat" id="<?php echo  esc_attr($this->get_field_id('video_width')); ?>" name="<?php echo esc_attr($this->get_field_name('video_width')); ?>" type="text" value="<?php echo esc_attr($instance['video_width']); ?>" />
        </p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['video_link'] = $new_instance['video_link'];
        $instance['video_name'] = $new_instance['video_name'];
        $instance['video_width'] = $new_instance['video_width'];
        return $instance;
    }
}
