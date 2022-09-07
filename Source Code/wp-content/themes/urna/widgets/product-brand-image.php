<?php

if (!class_exists('WooCommerce')) {
    return;
}

global $product;

$current_product_id = $product->get_id();

if (!is_product()) {
    return;
}

$product_brands = get_the_terms($current_product_id, 'yith_product_brand');

?>

<?php if (isset($product_brands) && is_array($product_brands)) : ?>
<div class="tbay-widget-yith-banner-image">


	<?php foreach ($product_brands as $term) {
    $thumbnail_id = absint(yith_wcbr_get_term_meta($term->term_id, 'thumbnail_id', true));

    if ($thumbnail_id) {
        $image = wp_get_attachment_image($thumbnail_id, 'full');

        if ($image) {
            echo sprintf('<a href="%s" class="brand-item">%s</a>', get_term_link($term), $image);
        }
    }
}
    ?>

</div>

<?php endif; ?>
