<?php
extract($args);
extract($instance);
$title = apply_filters('widget_title', $instance['title']);

if ($title) {
    echo trim($before_title)  . trim($title) . $after_title;
}
?>

<div class="contact-info">
<?php
foreach ($params as $key => $value) :
    if ($instance[$key]) :
        switch ($key) {
            case 'skype':
                ?>
                <p class="<?php echo esc_attr($key) ?>"><?php echo trim($value) ?>: <?php echo trim($instance[$key]); ?></p>
                <?php
                break;
            case 'title':
            case 'email':
                ?>
                    <p class="<?php echo esc_attr($key) ?>"><?php echo trim($value) ?>: <a href="mailto:<?php echo sanitize_email($instance['email']); ?>"><?php if ($instance[$key]) {
                    echo trim($instance[$key]);
                } else {
                    echo trim($instance[$key]);
                } ?></a></p>
                <?php
                break;
            case 'website':
                ?>
                    <p class="<?php echo esc_attr($key) ?>"><?php echo trim($value) ?> <a href="<?php echo esc_url($instance['website']); ?>"><?php if ($instance[$key]) {
                    echo trim($instance[$key]);
                } else {
                    echo trim($instance[$key]);
                } ?></a></p>
                <?php
            break;
            case 'company':
                ?>
                    <div class="<?php echo esc_attr($key) ?>">
                        <p class="desc"><?php echo esc_html__('head Office', 'urna') ?> </p>
                        <a href="<?php echo esc_url($instance['company']); ?>"><?php if ($instance[$key]) {
                    echo trim($instance[$key]);
                } else {
                    echo trim($instance[$key]);
                } ?></a>
                    </div>
                <?php
                break;

            case 'phone':
                ?>  <div class="phone-number">
                    <p class="desc"><?php echo esc_html__('Phone Number', 'urna'); ?></p>
                    <p><?php if ($instance[$key]) {
                    echo trim($instance[$key]);
                } else {
                    echo trim($instance[$key]);
                } ?></p>
                <?php
                break;

            case 'mobile':
                ?>
                    <p><?php if ($instance[$key]) {
                    echo trim($instance[$key]);
                } else {
                    echo trim($instance[$key]);
                } ?></p>
                    </div>
                <?php
                break;

            default: ?>
                <p class="<?php echo esc_attr($key) ?>"><?php echo trim($instance[$key]); ?></p>
    <?php }
    endif;
endforeach; ?>
</div>