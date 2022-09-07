<?php
    $enable_fs         	= 	urna_tbay_get_config('enable_flash_sale');
    $fs         		= 	urna_tbay_get_config('media_flash_sale');
    $link       		= 	urna_tbay_get_config('flash_sale_select');
    $alt                =   esc_html__('Flash Sale', 'urna');

    if (!$enable_fs) {
        return;
    }

    $url = get_the_permalink($link);

?>

<?php if (isset($fs['url']) && !empty($fs['url'])) { ?>
    <div class="flash-sale">
        <a href="<?php echo esc_url($url); ?>">
            <?php if (isset($fs['width']) && !empty($fs['width'])) : ?>
                <img src="<?php echo esc_url($fs['url']); ?>" width="<?php echo esc_attr($fs['width']); ?>" height="<?php echo esc_attr($fs['height']); ?>" alt="<?php echo esc_attr($alt); ?>">
            <?php else: ?>
                <img src="<?php echo esc_url($fs['url']); ?>" alt="<?php echo esc_attr($alt); ?>">
            <?php endif; ?> 
        </a>
    </div>
<?php } ?>