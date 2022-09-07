<?php
if (!defined('URNA_CORE_ACTIVED')) {
    return;
}

class Urna_Widget_Recent_Comment extends Urna_Widget
{
    public function __construct()
    {
        parent::__construct(
            'urna_recent_comment',
            esc_html__('Urna Recent Comments', 'urna'),
            array( 'description' => esc_html__('Show list of recent comments', 'urna'), )
        );
        $this->widgetName = 'recent_comment';
    }

    public function getTemplate()
    {
        $this->template = 'recent-comment.php';
    }

    public function widget($args, $instance)
    {
        $this->display($args, $instance);
    }
    
    public function form($instance)
    {
        if (isset($instance[ 'title' ])) {
            $title = $instance[ 'title' ];
        } else {
            $title = esc_html__('Latest Post', 'urna');
        }

        if (isset($instance[ 'number_comment' ])) {
            $number_comment = $instance[ 'number_comment' ];
        } else {
            $number_comment = 4;
        }
        // Widget admin form?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'urna'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number_comment')); ?>"><?php esc_html_e('Num Comments:', 'urna'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number_comment')); ?>" name="<?php echo esc_attr($this->get_field_name('number_comment')); ?>" type="text" value="<?php echo  esc_attr($number_comment); ?>" />
        </p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['number_comment'] = (! empty($new_instance['number_comment'])) ? strip_tags($new_instance['number_comment']) : '';
        $instance['layout'] = (! empty($new_instance['layout'])) ? $new_instance['layout'] : 'default';
        return $instance;
    }
}
