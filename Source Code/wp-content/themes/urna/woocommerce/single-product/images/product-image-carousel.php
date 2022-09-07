<?php

global $product;

wp_dequeue_style('photoswipe-ui-default');
wp_dequeue_style('photoswipe');
wp_enqueue_script('slick');
wp_enqueue_script('urna-slick');

$attachment_ids = $product->get_gallery_image_ids();
$count = count($attachment_ids);
$post_thumbnail_id = $product->get_image_id();

?>
<div class="images">
	
	<?php

        if ($product->get_image_id()) {
            $image_link       = wp_get_attachment_url(get_post_thumbnail_id());

            // tbay FOR SLIDER
            $html  = '<section class="slider tbay-slider-for" data-number="3">';
            
            $html .= '<div class="zoom"><img alt="'.  esc_attr__('Awaiting product image', 'urna') .'" src="'. esc_url($image_link) .'" /><a href="'. esc_url($image_link) .'" class="tbay-popup lightbox-gallery"></a></div>';
            
            foreach ($attachment_ids as $attachment_id) {
                $imgfull_src = wp_get_attachment_image_src($attachment_id, 'full');
                $html .= '<div class="zoom"><img alt="'.  esc_attr__('Awaiting product image', 'urna') .'" src="'. esc_url($imgfull_src[0]) .'" /><a href="'. esc_url($imgfull_src[0]) .'" class="tbay-popup lightbox-gallery"></a></div>';
            }
            
            $html .= '</section>';
        } else {
            $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
            $html .= sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_attr__('Awaiting product image', 'urna'));
            $html .= '</div>';
        }


        echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
    ?>
</div>