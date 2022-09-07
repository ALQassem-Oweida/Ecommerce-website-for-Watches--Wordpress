<?php

global $post, $product;

//check Enough number image thumbnail
$attachment_ids = $product->get_gallery_image_ids();

$count = count($attachment_ids);

if (isset($count) && $count > 0) {
    wp_dequeue_script('flexslider');
    wp_dequeue_script('zoom');
    wp_enqueue_script('hc-sticky');
}

$sidebar_configs    = urna_tbay_get_woocommerce_layout_configs();
$images_layout      = $sidebar_configs['thumbnail'];
$is_rtl 			= (is_rtl()) ? 'yes' : 'no';

$columns           = apply_filters('woocommerce_product_thumbnails_columns', 4);
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters('woocommerce_single_product_image_gallery_classes', array(
    'woocommerce-product-gallery',
    'woocommerce-product-gallery-stick',
    'images'
));

?>

<div class="<?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>" data-columns="<?php echo esc_attr($columns); ?>" data-rtl="<?php echo esc_attr($is_rtl); ?>" data-layout=<?php echo esc_attr($images_layout); ?> style="opacity: 0; transition: opacity .25s ease-in-out;">

	<figure class="woocommerce-product-gallery__wrapper">
		<?php
        if ($product->get_image_id()) {
            $html = wc_get_gallery_image_html($post_thumbnail_id, true);
        } else {
            $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
            $html .= sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_attr__('Awaiting product image', 'urna'));
            $html .= '</div>';
        }

            
        echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
        do_action('woocommerce_product_thumbnails');
        ?>
	</figure>
    <?php 
		do_action( 'urna_woocommerce_after_product_thumbnails' );
	?>
</div>
