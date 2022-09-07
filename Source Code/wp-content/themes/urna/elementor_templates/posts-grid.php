<?php
/**
 * Templates Name: Elementor
 * Widget: Post Grid
 */
extract($settings);

if (!empty($_css_classes)) {
    $this->add_render_attribute('wrapper', 'class', $_css_classes);
}

$loop = $this->query_posts();

if (!$loop->found_posts) {
    return;
}
$this->settings_layout();
$this->add_render_attribute('item', 'class', 'item');

set_query_var('thumbsize', $thumbnail_size);
set_query_var('elementor_activate', true);

$this->add_render_attribute('wrapper', 'class', [$layout_type, 'tbay-addon-blog']);

$rows_count = isset($rows) ? $rows : 1;

if ($layout_type == 'carousel') {
    $this->add_render_attribute('row', 'class', ['posts']);
}
?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>

    <?php $this->render_element_heading(); ?>

    <div class="tbay-addon-content">

        <?php if ($layout_type !== 'carousel') {
    echo '<div class="layout-blog">';
} ?>

            <div <?php echo trim($this->get_render_attribute_string('row')); ?>>

                <?php $count = 0; while ($loop->have_posts()) : $loop->the_post(); ?>

                    <?php if (fmod($count, $rows_count) == 0) {
    echo '<div class="item">';
} ?>
                
                            <?php if (isset($layout_type) && $layout_type == 'carousel') : ?>

                                <?php get_template_part('vc_templates/post/carousel/_single_'.$layout_type); ?>

                            <?php elseif (isset($layout_type) && $layout_type == 'vertical') : ?>

                                <?php get_template_part('vc_templates/post/_vertical'); ?>

                            <?php else: ?>

                                <?php get_template_part('vc_templates/post/_single'); ?>

                            <?php endif; ?>

                    <?php if (fmod($count, $rows_count) == $rows_count-1 || $count==$loop->post_count -1) {
    echo '</div>';
} ?>

                    <?php $count++; ?>
                <?php endwhile; ?> 
            </div>

        <?php if ($layout_type !== 'carousel') {
    echo '</div>';
} ?>
    </div>
</div>

<?php wp_reset_postdata(); ?>