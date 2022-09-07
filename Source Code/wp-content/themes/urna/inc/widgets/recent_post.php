<?php
if (!defined('URNA_CORE_ACTIVED')) {
    return;
}

class Urna_Widget_Recent_Post extends Urna_Widget
{
    public function __construct()
    {
        parent::__construct(
            'urna_recent_post',
            esc_html__('Urna Recent Posts', 'urna'),
            array( 'description' => esc_html__('Show list of recent post', 'urna'), )
        );
        $this->widgetName = 'recent_post';
    }
 
    public function getTemplate()
    {
        $this->template = 'recent-post.php';
    }

    public function widget($args, $instance)
    {
        $this->display($args, $instance);
    }
    
    public function form($instance)
    {
        $defaults = array(
            'title' => 'Latest Post',
            'layout' => 'default' ,
            'number_post' => '4',
            'post_type' => 'post'
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'urna'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('post_type')); ?>">
                <?php echo esc_html__('Type:', 'urna'); ?>
            </label>
            <br>
            <select id="<?php echo esc_attr($this->get_field_id('post_type')); ?>" name="<?php echo esc_attr($this->get_field_name('post_type')); ?>">
                <?php foreach (get_post_types(array('public' => true)) as $key => $value) { ?>
                    <?php if ($key!='attachment' && $key!='product') { ?>
                    <option value="<?php echo esc_attr($key); ?>" <?php selected($instance['post_type'], $key); ?> ><?php echo esc_html($value); ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number_post')); ?>"><?php esc_html_e('Num Posts:', 'urna'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number_post')); ?>" name="<?php echo esc_attr($this->get_field_name('number_post')); ?>" type="text" value="<?php echo esc_attr($instance['number_post']); ?>" />
        </p>  

<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['post_type'] = $new_instance['post_type'];
        $instance['number_post'] = (! empty($new_instance['number_post'])) ? strip_tags($new_instance['number_post']) : '';
        return $instance;
    }
}
