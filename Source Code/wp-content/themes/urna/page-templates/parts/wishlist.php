<?php

    $icon 			= urna_tbay_get_config('woo_wishlist_icon', 'linear-icon-heart');

    $enable_text 	= urna_tbay_get_config('enable_woo_wishlist_text', true);
    $text 			= urna_tbay_get_config('woo_wishlist_text', esc_html__('My Wishlist', 'urna'));

?>

<?php if (class_exists('YITH_WCWL')) { ?>
<div class="top-wishlist">
	<a class="text-skin wishlist-icon" href="<?php $wishlist_url = YITH_WCWL()->get_wishlist_url(); echo esc_url($wishlist_url); ?>">
	<?php if (!empty($icon)) : ?>
		<i class="<?php echo esc_attr($icon); ?>"></i>
	<?php endif; ?>
	<span class="count_wishlist"><?php $wishlist_count = YITH_WCWL()->count_products(); echo esc_html($wishlist_count); ?></span>
	<?php
        if (isset($enable_text) && $enable_text) {
            echo '<span class="text">'. trim($text) . '</span>';
        }
    ?>
	</a>
</div>
<?php } ?>