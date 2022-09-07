<?php
if (!defined('URNA_CORE_ACTIVED')) {
    return;
}

class Urna_Widget_Popular_Post extends Urna_Widget
{
    public function __construct()
    {
        parent::__construct(
            'urna_popular_post',
            esc_html__('Urna Popular Posts', 'urna'),
            array( 'description' => esc_html__('Show list of popular posts', 'urna'), )
        );
        $this->widgetName = 'popular_post';
    }
 
    public function getTemplate()
    {
        $this->template = 'popular-post.php';
    }

    public function widget($args, $instance)
    {
        $this->display($args, $instance);
    }
    
    public function form($instance)
    {
        $defaults = array(
            'title' => 'Popular Posts',
            'layout' => 'default' ,
            'number_post' => '4',
            'post_type' => 'post'
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form

        if (isset($instance[ 'styles' ])) {
            $styles = $instance[ 'styles' ];
        } else {
            $styles = 1;
        } ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'urna'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
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

        $instance['styles']    = (! empty($new_instance['styles'])) ? strip_tags($new_instance['styles']) : '';
        return $instance;
    }
}
