<?php

if (!class_exists('WCMp')) {
    return;
}


if (!function_exists('urna_wc_marketplace_widgets_init')) {
    function urna_wc_marketplace_widgets_init()
    {
        register_sidebar(array(
            'name'          => esc_html__('WC Marketplace Store Sidebar ', 'urna'),
            'id'            => 'wc-marketplace-store',
            'description'   => esc_html__('Add widgets here to appear in your site.', 'urna'),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }
    add_action('widgets_init', 'urna_wc_marketplace_widgets_init');
}

if (! function_exists('urna_tbay_regiter_vendor_wcmp_popup')) {
    function urna_tbay_regiter_vendor_wcmp_popup()
    {
        if (!wcmp_vendor_registration_page_id()) {
            return;
        }

        $outputs = '<div class="vendor-register">';
        $outputs .= sprintf(__('Are you a vendor? <a href="%s">Register here.</a>', 'urna'), get_permalink(get_option('wcmp_product_vendor_registration_page_id')));
        $outputs .= '</div>';
        echo trim($outputs);
    }
    add_action('urna_custom_woocommerce_register_form_end', 'urna_tbay_regiter_vendor_wcmp_popup', 5);
}

if (! function_exists('urna_wcmp_woo_remove_product_tabs')) {
    add_filter('woocommerce_product_tabs', 'urna_wcmp_woo_remove_product_tabs', 98);
    function urna_wcmp_woo_remove_product_tabs($tabs)
    {
        unset($tabs['questions']);

        return $tabs;
    }
}


if (!function_exists('urna_wcmp_vendor_name')) {
    function urna_wcmp_vendor_name()
    {
        $active = urna_tbay_get_config('show_vendor_name', true);

        if (!$active) {
            return;
        }

        if ('Enable' !== get_wcmp_vendor_settings('sold_by_catalog', 'general')) {
            return;
        }

        global $product;
        $product_id = $product->get_id();

        $vendor = get_wcmp_product_vendors($product_id);

        if (empty($vendor)) {
            return;
        }

        $sold_by_text = apply_filters('vendor_sold_by_text', esc_html__('Sold by:', 'urna')); ?> 

        <div class="sold-by-meta sold-wcmp">
            <span class="sold-by-label"><?php echo trim($sold_by_text); ?> </span>
            <a href="<?php echo esc_url($vendor->permalink); ?>"><?php echo esc_html($vendor->user_data->display_name); ?></a>
        </div>

        <?php
    }
    add_filter('wcmp_sold_by_text_after_products_shop_page', '__return_false');
    add_action('woocommerce_after_shop_loop_item_title', 'urna_wcmp_vendor_name', 0);
    add_action('woocommerce_single_product_summary', 'urna_wcmp_vendor_name', 5);
}

/*Get title My Account in top bar mobile*/
if (! function_exists('urna_tbay_wcmp_get_title_mobile')) {
    function urna_tbay_wcmp_get_title_mobile($title = '')
    {
        if (urna_woo_is_vendor_page()) {
            $vendor_id  = get_queried_object()->term_id;
            $vendor     = get_wcmp_vendor_by_term($vendor_id);

            $title          = $vendor->page_title;
        }

        return $title;
    }
    add_filter('urna_get_filter_title_mobile', 'urna_tbay_wcmp_get_title_mobile');
}

if (! function_exists('urna_product_archive_fix_description')) {
    function urna_product_archive_fix_description($content)
    {
        global $WCMp;
        if (is_tax($WCMp->taxonomy->taxonomy_name)) {
            // Get vendor ID
            $vendor_id = get_queried_object()->term_id;
            // Get vendor info
            $vendor = get_wcmp_vendor_by_term($vendor_id);
            if ($vendor) {
                $description = $vendor->description;

                return $description;
            }
        } else {
            return $content;
        }
    }
    add_filter('the_content', 'urna_product_archive_fix_description', 10, 1);
}

/*Fix WCMP 3.7*/
if ( !function_exists('urna_wcmp_load_default_vendor_store') ) {
    function urna_wcmp_load_default_vendor_store() {
        return true;
    }
    add_filter( 'wcmp_load_default_vendor_store', 'urna_wcmp_load_default_vendor_store', 10, 1 );
}

if ( !function_exists('urna_wcmp_store_sidebar_args') ) {
    function urna_wcmp_store_sidebar_args() {
        $sidebars = array(
            'name'          => esc_html__( 'WC Marketplace Store Sidebar ', 'urna' ),
            'id'            => 'wc-marketplace-store',
            'description'   => esc_html__( 'Add widgets here to appear in your site.', 'urna' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ); 

        return $sidebars;
    }
    add_filter( 'wcmp_store_sidebar_args', 'urna_wcmp_store_sidebar_args', 10, 1 );
}
/*End fix WCMP 3.7*/