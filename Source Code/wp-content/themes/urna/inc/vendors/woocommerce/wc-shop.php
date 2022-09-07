<?php

if (!class_exists('WooCommerce')) {
    return;
}

/*SHOP WOO*/

/**
 * Display category image on category archive
 */
if (! function_exists('urna_woocommerce_category_image')) {
    add_action('woocommerce_archive_description', 'urna_woocommerce_category_image', 2);
    function urna_woocommerce_category_image()
    {
        if (is_product_category() && !is_search()) {
            global $wp_query;
            $cat = $wp_query->get_queried_object();
            $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
            $image = wp_get_attachment_url($thumbnail_id);
            if ($image) {
                echo '<img src="' . esc_url($image) . '" alt="' . esc_attr($cat->name) . '" />';
            }
        }
    }
}

if (! function_exists('urna_woocommerce_product_top_archive')) {
    add_action('woocommerce_before_main_content', 'urna_woocommerce_product_top_archive', 10);
    function urna_woocommerce_product_top_archive()
    {
        if (!is_product() && !is_search()) {
            $active = apply_filters('urna_sidebar_top_archive', 10, 2);
            $active = (is_search()) ? false : $active;
            $sidebar_id = 'product-top-archive';

            if ($active && is_active_sidebar($sidebar_id)) { ?> 
                <aside id="sidebar-top-archive" class="sidebar top-archive-content">
                <?php dynamic_sidebar($sidebar_id); ?>
            </aside>
            <?php }
        }
    }
}

if (! function_exists('urna_woocommerce_remove_des_image')) {
    add_action('woocommerce_before_main_content', 'urna_woocommerce_remove_des_image', 20);
    function urna_woocommerce_remove_des_image()
    {
        $active = apply_filters('urna_woo_pro_des_image', 10, 2);

        if (!$active) {
            remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
            remove_action('woocommerce_archive_description', 'woocommerce_product_archive_description', 10);
            remove_action('woocommerce_archive_description', 'urna_woocommerce_category_image', 2);
        }
    }
}

if (! function_exists('urna_woocommerce_remove_title_product_archives')) {
    add_filter('woocommerce_show_page_title', 'urna_woocommerce_remove_title_product_archives');
    function urna_woocommerce_remove_title_product_archives()
    {
        $active = apply_filters('urna_woo_title_product_archives', 10, 2);

        $active = (is_search()) ? true : $active;

        return $active;
    }
}

if (! function_exists('urna_woocommerce_ajax_filter_button')) {
    function urna_woocommerce_ajax_filter_button()
    {
        $active = apply_filters('urna_woo_ajax_filter', 10, 2);

        if (!$active) {
            return;
        } ?>
            <div id="tbay-ajax-filter-btn" class="tbay-ajax-filter-btn hidden-xs hidden-sm">
                <button class="btn">
                    <i class="linear-icon-equalizer filter-icon"></i><?php esc_html_e('Filter', 'urna'); ?>
                    <i class="linear-icon-chevron-down"></i>
                </button>
            </div>
        <?php
    }

    add_action('woocommerce_before_shop_loop', 'urna_woocommerce_ajax_filter_button', 20);
}

if (! function_exists('urna_woocommerce_ajax_filter_sidebar')) {
    function urna_woocommerce_ajax_filter_sidebar()
    {
        $active = apply_filters('urna_woo_ajax_filter', 10, 2);

        if (!$active) {
            return;
        } ?>
            <div id="tbay-ajax-filter-sidebar" class="ajax-filter-sidebar">
                <?php echo do_shortcode('[woof]'); ?>
            </div>
        <?php
    }
}
