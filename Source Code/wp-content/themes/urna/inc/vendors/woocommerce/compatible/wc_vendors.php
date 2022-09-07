<?php

if (!class_exists('WC_Vendors')) {
    return;
}

if (! function_exists('urna_tbay_wcv_vendor_shop')) {
    remove_action('woocommerce_after_shop_loop_item', array( 'WCV_Vendor_Shop', 'template_loop_sold_by' ), 9);
    function urna_tbay_wcv_vendor_shop()
    {
        if (! wc_string_to_bool(get_option('wcvendors_display_label_sold_by_enable', 'no'))) {
            return;
        }

        global $product;

        $vendor_id         = WCV_Vendors::get_vendor_from_product($product->get_id());
        $sold_by_label     = get_option('wcvendors_label_sold_by');
        $sold_by_separator = get_option('wcvendors_label_sold_by_separator');
        $sold_by           = WCV_Vendors::is_vendor($vendor_id)
            ? sprintf('<a href="%s">%s</a>', WCV_Vendors::get_vendor_shop_page($vendor_id), WCV_Vendors::get_vendor_sold_by($vendor_id))
            : get_bloginfo('name'); ?>
		<small class="wcvendors_sold_by_in_loop"><?php echo apply_filters('wcvendors_sold_by_in_loop', $sold_by_label); ?><?php echo apply_filters('wcvendors_sold_by_separator_in_loop', $sold_by_separator); ?><?php echo trim($sold_by); ?>
		</small><br/>
		<?php
    }
    add_action('woocommerce_after_shop_loop_item_title', 'urna_tbay_wcv_vendor_shop', 10);
}
