<?php
if (!defined('URNA_CORE_ACTIVED')) {
    return;
}

if (class_exists('PostRatings')) {
    class Urna_Widget_Top_Rate extends Urna_Widget
    {
        public function __construct()
        {
            parent::__construct(
                // Base ID of your widget
                'urna_top_rate_widget',
                // Widget name will appear in UI
                esc_html__('Urna Top Rate', 'urna'),
                // Widget description
                array( 'description' => esc_html__('The highest rated posts on your site', 'urna'), )
            );
            $this->widgetName = 'top_rate';
        }

        public function getTemplate()
        {
            $this->template = 'top-rate.php';
        }

        public function widget($args, $instance)
        {
            $this->display($args, $instance);
        }
        
        public function form($instance)
        {
            $defaults = array(
                'title' => 'Top Rated',
                'number' => '5',
                'sort' => 'bayesian_rating',
                'order' => 'DESC',
                'date_limit' => 0,
                'post_type' =>  'post'
            );
            $instance = wp_parse_args((array) $instance, $defaults);
            $plugin_options = PostRatings()->getOptions(); ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'urna'); ?></label>
                <br>
                <input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('post_type')); ?>"><?php esc_html_e('Get most rated:', 'urna'); ?></label>
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id('post_type')); ?>" name="<?php echo esc_attr($this->get_field_name('post_type')); ?>">
                    <?php foreach (get_post_types(array('public' => true)) as $type): ?>
                    <?php $object = get_post_type_object($type); ?>
                    <option <?php if (!in_array($type, $plugin_options['post_types'])): ?> disabled="disabled" <?php endif; ?> value="<?php echo esc_attr($type); ?>" <?php selected($type, $instance['post_type']); ?>><?php echo esc_html($object->labels->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('sort')); ?>"><?php esc_html_e('Sort by:', 'urna'); ?></label>
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id('sort')); ?>" name="<?php echo esc_attr($this->get_field_name('sort')); ?>">
                <option <?php selected('bayesian_rating', $instance['sort']); ?> value="bayesian_rating"><?php esc_html_e('Overall bayesian rating (score)', 'urna'); ?></option>
                <option <?php selected('rating', $instance['sort']); ?> value="rating"><?php esc_html_e('Average rating', 'urna'); ?></option>
                <option <?php selected('votes', $instance['sort']); ?> value="votes"><?php esc_html_e('Number of votes', 'urna'); ?></option>
                </select>
            </p>
            
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('order')); ?>_desc">
                <input id="<?php echo esc_attr($this->get_field_id('order')); ?>_desc" name="<?php echo esc_attr($this->get_field_name('order')); ?>" type="radio" value="DESC" <?php checked('DESC', $instance['order']); ?> />
                <?php esc_html_e('Descending', 'urna'); ?>
                </label>

                <label for="<?php echo esc_attr($this->get_field_id('order')); ?>_asc">
                <input id="<?php echo esc_attr($this->get_field_id('order')); ?>_asc" name="<?php echo esc_attr($this->get_field_name('order')); ?>" type="radio" value="ASC" <?php checked('ASC', $instance['order']); ?> />
                <?php esc_html_e('Ascending', 'urna'); ?>
                </label>
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('date_limit')); ?>"><?php esc_html_e('Ignore posts older than:', 'urna'); ?></label>
                <input id="<?php echo esc_attr($this->get_field_id('date_limit')); ?>" name="<?php echo esc_attr($this->get_field_name('date_limit')); ?>" type="text" value="<?php echo esc_attr($instance['date_limit']); ?>" size="3" /> <?php esc_html_e('days', 'urna'); ?>
                <br />
                <small><?php esc_html_e('(0 to ignore date)', 'urna'); ?></small>
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Limit:', 'urna'); ?></label>
                <input id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($instance['number']); ?>" size="3" />
            </p>

    <?php
        }

        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;

            $instance['title'] = $new_instance['title'];
            $instance['sort'] = $new_instance['sort'];
            $instance['order'] = $new_instance['order'];
            $instance['number'] = $new_instance['number'];
            $instance['date_limit'] = $new_instance['date_limit'];
            $instance['post_type'] = $new_instance['post_type'];
            $instance['layout'] = (! empty($new_instance['layout'])) ? $new_instance['layout'] : 'default';
            return $instance;
        }
    }
}
