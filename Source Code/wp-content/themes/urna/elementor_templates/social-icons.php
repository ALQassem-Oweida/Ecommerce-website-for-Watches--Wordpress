<?php
/**
 * Templates Name: Social Icons
 * Widget: Social Icons
 */
$styles = '';
extract($settings);

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$this->add_render_attribute('wrapper', 'class', ['tbay-addon-social']);

$this->settings_layout();

$settings = $this->get_settings_for_display();

?>
<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>

    <?php $this->render_element_heading(); ?>

    <div class="tbay-addon-content">
        <ul class="social list-inline <?php echo esc_attr($styles);?>">
        <?php
            foreach ($settings['social_icon_list'] as $index => $item) {
                $this->social_icon_item($index, $item);
            }
        ?></ul>
    </div>
</div>