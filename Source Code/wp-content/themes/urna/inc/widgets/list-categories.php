<?php

if (!defined('URNA_CORE_ACTIVED')) {
    return;
}

class Urna_Widget_List_Categories extends Urna_Widget
{
    public function __construct()
    {
        parent::__construct(
            'urna_list_categories',
            esc_html__('Urna Woo List Categories', 'urna'),
            array( 'description' => esc_html__('Show list categories', 'urna'), )
        );
        $this->widgetName = 'list_categories';
    }

    public function getTemplate()
    {
        $this->template = 'list-categories.php';
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
            $title = esc_html__('Title', 'urna');
        }
        
        if (isset($instance[ 'sub_title' ])) {
            $sub_title = $instance[ 'sub_title' ];
        } else {
            $sub_title = esc_html__('Sub Title', 'urna');
        }
        
 
        if (isset($instance[ 'numbers' ])) {
            $numbers = $instance[ 'numbers' ];
        } else {
            $numbers = 4;
        }

        if (isset($instance[ 'columns' ])) {
            $columns = $instance[ 'columns' ];
        } else {
            $columns = 4;
        }

        if (isset($instance[ 'columns_desktop' ])) {
            $columns_desktop = $instance[ 'columns_desktop' ];
        } else {
            $columns_desktop = 4;
        }

        if (isset($instance[ 'columns_destsmall' ])) {
            $columns_destsmall = $instance[ 'columns_destsmall' ];
        } else {
            $columns_destsmall = 3;
        }

        if (isset($instance[ 'columns_tablet' ])) {
            $columns_tablet = $instance[ 'columns_tablet' ];
        } else {
            $columns_tablet = 2;
        }

        if (isset($instance[ 'columns_mobile' ])) {
            $columns_mobile = $instance[ 'columns_mobile' ];
        } else {
            $columns_mobile = 1;
        }

        $allcolumns = array(
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            6 => 6
        );


        // Widget admin form?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'urna'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>        
        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('sub_title')); ?>"><?php esc_html_e('Sub Title:', 'urna'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('sub_title')); ?>" name="<?php echo esc_attr($this->get_field_name('sub_title')); ?>" type="text" value="<?php echo esc_attr($sub_title); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('numbers')); ?>"><?php esc_html_e('Number of categories to show:', 'urna'); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('numbers')); ?>" name="<?php echo esc_attr($this->get_field_name('numbers')); ?>" type="text" value="<?php echo  esc_attr($numbers); ?>" 
        </p>        

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('columns')); ?>"><?php esc_html_e('Columns:', 'urna'); ?></label>


            <?php if (!empty($allcolumns)) :  ?>

            <select id="<?php echo esc_attr($this->get_field_id('columns')); ?>" name="<?php echo esc_attr($this->get_field_name('columns')); ?>">
                <?php

                foreach ($allcolumns as $key => $column) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr($column),
                        ($column == $columns) ? 'selected="selected"' : '',
                        esc_html($key)
                    );
                } ?>
            </select>

            <?php else: ?>

                <?php echo esc_html__('No choose columns product found ', 'urna'); ?>

            <?php endif; ?>

        </p>          

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('columns_desktop')); ?>"><?php esc_html_e('Columns screen desktop:', 'urna'); ?></label>


            <?php if (!empty($allcolumns)) :  ?>

            <select id="<?php echo esc_attr($this->get_field_id('columns_desktop')); ?>" name="<?php echo esc_attr($this->get_field_name('columns_desktop')); ?>">
                <?php

                foreach ($allcolumns as $key => $column) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr($column),
                        ($column == $columns_desktop) ? 'selected="selected"' : '',
                        esc_html($key)
                    );
                } ?>
            </select>

            <?php else: ?>

                <?php echo esc_html__('No choose columns desktop product found ', 'urna'); ?>

            <?php endif; ?>

        </p>  

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('columns_destsmall')); ?>"><?php esc_html_e('Columns screen desktop small:', 'urna'); ?></label>


            <?php if (!empty($allcolumns)) :  ?>

            <select id="<?php echo esc_attr($this->get_field_id('columns_destsmall')); ?>" name="<?php echo esc_attr($this->get_field_name('columns_destsmall')); ?>">
                <?php

                foreach ($allcolumns as $key => $column) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr($column),
                        ($column == $columns_destsmall) ? 'selected="selected"' : '',
                        esc_html($key)
                    );
                } ?>
            </select>

            <?php else: ?>

                <?php echo esc_html__('No choose columns desktop small product found ', 'urna'); ?>

            <?php endif; ?>

        </p>   

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('columns_tablet')); ?>"><?php esc_html_e('Columns screen tablet:', 'urna'); ?></label>


            <?php if (!empty($allcolumns)) :  ?>

            <select id="<?php echo esc_attr($this->get_field_id('columns_tablet')); ?>" name="<?php echo esc_attr($this->get_field_name('columns_tablet')); ?>">
                <?php

                foreach ($allcolumns as $key => $column) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr($column),
                        ($column == $columns_tablet) ? 'selected="selected"' : '',
                        esc_html($key)
                    );
                } ?>
            </select>

            <?php else: ?>

                <?php echo esc_html__('No choose columns table product found ', 'urna'); ?>

            <?php endif; ?>

        </p>           

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('columns_mobile')); ?>"><?php esc_html_e('Columns screen mobile:', 'urna'); ?></label>


            <?php if (!empty($allcolumns)) :  ?>

            <select id="<?php echo esc_attr($this->get_field_id('columns_mobile')); ?>" name="<?php echo esc_attr($this->get_field_name('columns_mobile')); ?>">
                <?php

                foreach ($allcolumns as $key => $column) {
                    printf(
                        '<option value="%s" %s>%s</option>',
                        esc_attr($column),
                        ($column == $columns_mobile) ? 'selected="selected"' : '',
                        esc_html($key)
                    );
                } ?>
            </select>

            <?php else: ?>

                <?php echo esc_html__('No choose columns table product found ', 'urna'); ?>

            <?php endif; ?>

        </p>   


<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title']      = (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        
        $instance['sub_title']      = (! empty($new_instance['sub_title'])) ? strip_tags($new_instance['sub_title']) : '';

        $instance['numbers']    = (! empty($new_instance['numbers'])) ? strip_tags($new_instance['numbers']) : '';

        $instance['columns']    = (! empty($new_instance['columns'])) ? strip_tags($new_instance['columns']) : '';

        $instance['columns_desktop']    = (! empty($new_instance['columns_desktop'])) ? strip_tags($new_instance['columns_desktop']) : '';

        $instance['columns_destsmall']    = (! empty($new_instance['columns_destsmall'])) ? strip_tags($new_instance['columns_destsmall']) : '';

        $instance['columns_tablet']    = (! empty($new_instance['columns_tablet'])) ? strip_tags($new_instance['columns_tablet']) : '';

        $instance['columns_mobile']    = (! empty($new_instance['columns_mobile'])) ? strip_tags($new_instance['columns_mobile']) : '';


        return $instance;
    }
}
