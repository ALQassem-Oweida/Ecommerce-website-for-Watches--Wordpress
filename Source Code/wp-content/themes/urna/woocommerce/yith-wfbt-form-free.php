<?php
/**
 * Form template
 *
 * @author YITH
 * @package YITH WooCommerce Frequently Bought Together
 * @version 1.0.4
 */

global $product;


$index  = 0;
$thumbs = $checks = '';
$total  = 0;

if (! isset($products)) {
    return;
}
/**
 * @type $product WC_Product
 */
// set query
$url        = ! is_null($product) ? $product->get_permalink() : '';
$url        = add_query_arg('action', 'yith_bought_together', $url);
$url        = wp_nonce_url($url, 'yith_bought_together');
$is_wc_30   = version_compare(WC()->version, '3.0.0', '>=');

foreach ($products as $current_product) {
    /**
     * @type $current_product WC_Product
     */
    // get correct id if product is variation
    $current_product_is_variation   = $current_product->is_type('variation');
    if ($is_wc_30) {
        $current_product_id = $current_product->get_id();
    } else {
        $current_product_id = $current_product->is_type('variation') ? $current_product->variation_id : $current_product->id;
    }

    $current_product_price          = function_exists('wc_get_price_to_display') ? wc_get_price_to_display($current_product) : $current_product->get_display_price();
    $current_product_link           = $current_product->get_permalink();
    $current_product_image          = $current_product->get_image('yith_wfbt_image_size');
    $current_product_title          = $current_product->get_title();

    if ($index > 0) {
        $thumbs .= '<li class="image_plus image_plus_' . $index . '" data-rel="offeringID_' . $index . '"><i class="linear-icon-plus"></i></li>';
    }
    $thumbs .= '<li class="image-td" data-rel="offeringID_' . $index . '"><a href="' . $current_product_link . '">' . $current_product_image . '</a>';
    $thumbs .= '<div class="caption"><span class="name"><a href="' . $current_product_link . '">' . $current_product_title . '</a></span><span class="price">' . $current_product->get_price_html() . '</span></div></li>';

    ob_start(); ?>
    <li class="yith-wfbt-item">
        <label for="offeringID_<?php echo esc_attr($index); ?>">

            <input type="hidden" name="offeringID[]" id="offeringID_<?php echo esc_attr($index); ?>" class="active" value="<?php echo esc_attr($current_product_id); ?>" />

            <span class="product-name"><?php echo ! $index ? '<span>'. esc_html__('This item', 'urna') . ': </span>' . $current_product_title : $current_product_title; ?></span>

            <?php

            if ($current_product_is_variation) {
                $attributes = $current_product->get_variation_attributes();
                $variations = array();

                foreach ($attributes as $key => $attribute) {
                    $key = str_replace('attribute_', '', $key);

                    $terms = get_terms(array(
                        'taxonomy' =>  sanitize_title($key),
                        'menu_order' => 'ASC',
                        'hide_empty' => false
                    ));

                    foreach ($terms as $term) {
                        if (! is_object($term) || ! in_array($term->slug, array( $attribute ))) {
                            continue;
                        }
                        $variations[] = $term->name;
                    }
                }

                if (! empty($variations)) {
                    echo '<span class="product-attributes"> &ndash; ' . implode(', ', $variations) . '</span>';
                }
            } ?>

        </label>
    </li>
    <?php
    $checks .= ob_get_clean();
    // increment total
    $total += floatval($current_product_price);

    // increment index
    $index++;
}

if ($index < 2) {
    return; // exit if only available product is current
}

// set button label
$label       = get_option('yith-wfbt-button-label');
$label_total = get_option('yith-wfbt-total-label');
$title       = get_option('yith-wfbt-form-title');

?>

<div class="yith-wfbt-section tbay-addon woocommerce">
    <?php if ($title != '') {
    echo '<h3 class="tbay-addon-title">' . esc_html($title) . '</h3>';
}
    ?>

    <form class="yith-wfbt-form" method="post" action="<?php echo esc_url($url) ?>">

        <div class="yith-wfbt-images">
            <ul>
                <?php echo trim($thumbs); ?>
            </ul>
        </div>

        <ul class="yith-wfbt-items free">
            <?php echo trim($checks); ?>
        </ul>
        <div class="yith-wfbt-submit-block">
            <div class="price_text">
                <span class="total_price_label">
                    <?php echo esc_html($label_total) ?>:
                </span>
                <span class="total_price" data-total="<?php echo esc_attr($total); ?>">
                    <?php echo wc_price($total) ?>
                </span>
            </div>
            <input type="submit" class="yith-wfbt-submit-button-remove button" value="<?php echo esc_attr($label); ?>">
        </div>
    </form>
</div>