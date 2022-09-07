<?php

if (!class_exists('WeDevs_Dokan')) {
    return;
}

if (class_exists('YITH_WooCommerce_Question_Answer')) {
    global $YWQA;
    add_filter('woocommerce_product_tabs', array( $YWQA, 'show_question_answer_tab' ), 5);
}



/*Get title My Account in top bar mobile*/
if (! function_exists('urna_tbay_wc_dokan_get_title_mobile')) {
    function urna_tbay_wc_dokan_get_title_mobile($title = '')
    {
        if (dokan_is_store_page()) {
            $store_user     = dokan()->vendor->get(get_query_var('author'));
            $title          = $store_user->get_shop_name();
        }

        return $title;
    }
    add_filter('urna_get_filter_title_mobile', 'urna_tbay_wc_dokan_get_title_mobile');
}

if (! function_exists('urna_tbay_register_vendor_dokan_popup')) {
    function urna_tbay_register_vendor_dokan_popup()
    {
        $outputs = '<div class="vendor-register">';
        $outputs .= sprintf(__('Are you a vendor? <a href="%s">Register here.</a>', 'urna'), get_permalink(get_option('woocommerce_myaccount_page_id')));
        $outputs .= '</div>';
        echo trim($outputs);
    }
    add_action('urna_custom_woocommerce_register_form_end', 'urna_tbay_register_vendor_dokan_popup', 5);
}

if (!function_exists('urna_dokan_price_kses')) {
    function urna_dokan_price_kses()
    {
        $array = array(
            'span' => array(
                'data-product-id' => array(),
                'class' => array(),
            ),
            'ins' => array(),
            'del' => array(),
        );

        return $array;
    }
    add_filter('dokan_price_kses', 'urna_dokan_price_kses', 100, 2);
}

if (!function_exists('urna_dokan_vendor_name')) {
    function urna_dokan_vendor_name()
    {
        $active = urna_tbay_get_config('show_vendor_name', true);

        if (!$active && !is_singular('product')) {
            return;
        }

        global $product;
        $author_id = get_post_field('post_author', $product->get_id());
        $author    = get_user_by('id', $author_id);
        if (empty($author)) {
            return;
        }

        $shop_info = get_user_meta($author_id, 'dokan_profile_settings', true);
        $shop_name = $author->display_name;
        if ($shop_info && isset($shop_info['store_name']) && $shop_info['store_name']) {
            $shop_name = $shop_info['store_name'];
        }

        $sold_by_text = apply_filters('vendor_sold_by_text', esc_html__('Sold by:', 'urna')); ?>
        <div class="sold-by-meta sold-dokan">
            <span class="sold-by-label"><?php echo trim($sold_by_text); ?> </span>
            <a href="<?php echo esc_url(dokan_get_store_url($author_id)); ?>"><?php echo esc_html($shop_name); ?></a>
        </div>

        <?php
    }

    add_action('woocommerce_after_shop_loop_item_title', 'urna_dokan_vendor_name', 0);
    add_action('woocommerce_single_product_summary', 'urna_dokan_vendor_name', 5);
}

// Number of products per row
if (!function_exists('urna_dokan_set_columns_more_from_seller_tab')) {
    function urna_dokan_set_columns_more_from_seller_tab($number)
    {
        if (isset($_GET['seller_tab_columns']) && is_numeric($_GET['seller_tab_columns'])) {
            $value = $_GET['seller_tab_columns'];
        } else {
            $value = urna_tbay_get_config('seller_tab_columns');
        }

        if (in_array($value, array(1, 2, 3, 4, 5, 6))) {
            $number = $value;
        }
        return $number;
    }
}

if (!function_exists('urna_dokan_set_per_page_more_from_seller_tab')) {
    function urna_dokan_set_per_page_more_from_seller_tab($number)
    {
        if (isset($_GET['seller_tab_per_page']) && is_numeric($_GET['seller_tab_per_page'])) {
            $value = $_GET['seller_tab_per_page'];
        } else {
            $value = urna_tbay_get_config('seller_tab_per_page');
        }

        if (is_numeric($value) && $value) {
            $number = absint($value);
        }
        return $number;
    }
    add_filter('urna_dokan_set_per_page_seller_tab', 'urna_dokan_set_per_page_more_from_seller_tab', 10, 1);
}

/**
 * Set More products from seller tab
 *
 * on Single Product Page
 *
 * @since 2.5
 * @param array $tabs
 * @return int
 */
if (function_exists('dokan_set_more_from_seller_tab') &&  !function_exists('urna_dokan_set_more_from_seller_tab')) {
    function urna_dokan_set_more_from_seller_tab($tabs)
    {
        if (check_more_seller_product_tab()) {
            $tabs['more_seller_product'] = array(
                'title'     => esc_html__('More Products', 'urna'),
                'priority'  => 99,
                'callback'  => 'urna_dokan_get_more_products_from_seller',
            );
        }

        return $tabs;
    }
    remove_action('woocommerce_product_tabs', 'dokan_set_more_from_seller_tab', 10);
    add_action('woocommerce_product_tabs', 'urna_dokan_set_more_from_seller_tab', 10);
}

if (!function_exists('urna_dokan_get_more_products_from_seller')) {
    function urna_dokan_get_more_products_from_seller($seller_id = 0, $posts_per_page = 6)
    {
        global $product, $post;

        if ($seller_id == 0) {
            $seller_id = $post->post_author;
        }

        if (! abs($posts_per_page)) {
            $posts_per_page = apply_filters('urna_dokan_set_per_page_seller_tab', 4);
        }

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => $posts_per_page,
            'orderby'        => 'rand',
            'post__not_in'   => array( $post->ID ),
            'author'         => $seller_id,
        );

        $products = new WP_Query($args);

        if ($products->have_posts()) {
            add_filter('loop_shop_columns', 'urna_dokan_set_columns_more_from_seller_tab', 10, 1);
            woocommerce_product_loop_start();

            while ($products->have_posts()) {
                $products->the_post();
                wc_get_template_part('content', 'product');
            }

            woocommerce_product_loop_end();
        } else {
            esc_html_e('No product has been found!', 'urna');
        }

        wp_reset_postdata();
    }
}


if (!function_exists('urna_dokan_get_number_of_products_of_vendor')) {
    function urna_dokan_get_number_of_products_of_vendor()
    {
        if (!urna_woo_is_vendor_page()) {
            return;
        }

        $author_id = get_post_field('post_author', get_the_id());
        $author    = get_user_by('id', $author_id);
        if (empty($author)) {
            return;
        }

        $vendor          = dokan()->vendor->get($author_id);
        $vendor_products = $vendor->get_products();

        $total = $vendor_products->found_posts;

        $per_page   = intval(get_query_var('posts_per_page'));
        $current    = (get_query_var('paged')) ? intval(get_query_var('paged')) : 1;

        echo '<p class="woocommerce-result-count result-vendor">';

        if ($total <= $per_page || -1 === $per_page) {
            /* translators: %d: total results */
            printf(_n('Showing the single result', 'Showing all %d results', $total, 'urna'), $total);
        } else {
            $first = ($per_page * $current) - $per_page + 1;
            $last  = min($total, $per_page * $current);
            /* translators: 1: first result 2: last result 3: total results */
            printf(_nx('Showing the single result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'urna'), $first, $last, $total);
        }

        echo '</p>';
    }
    add_action('woocommerce_before_shop_loop', 'urna_dokan_get_number_of_products_of_vendor', 20);
}

//Add filter in mobile
if (!function_exists('urna_dokan_filter_mobile_content')) {
    function urna_dokan_filter_mobile_content()
    {
        if (!urna_woo_is_vendor_page()) {
            return;
        }

        if (is_active_sidebar('sidebar-mobile')) {
            ?>

            <div class="filter-mobile">
                <div class="content">
                    <h3 class="heading-title"><?php echo esc_html__('Product Filter', 'urna'); ?></h3>
                    <a href="javascript:;" class="close"><i class="linear-icon-cross2"></i></a>
                    <div class="sidebar">
                        <?php dynamic_sidebar('sidebar-mobile'); ?>
                    </div>
                </div>
            </div>

            <?php
        }
    }
    add_action('urna_woo_template_main_before', 'urna_dokan_filter_mobile_content', 40);
}

if (! function_exists('urna_dokan_description')) {
    function urna_dokan_description($description)
    {
        if (!urna_woo_is_vendor_page()) {
            return $description;
        }

        $store_user = get_userdata(get_query_var('author'));
        $store_info   = dokan_get_store_info($store_user->ID);

        if (! empty($store_info['vendor_biography'])) {
            $description = $store_info['vendor_biography'];
        }

        return $description;
    }
    add_filter('the_content', 'urna_dokan_description', 10, 1);
}


if (! function_exists('tbay_get_sidebar_dokan')) {
    function tbay_get_sidebar_dokan()
    {
        $sidebar = array();
        $sidebar['id'] =  urna_tbay_get_config('product_archive_sidebar');
        return $sidebar;
    }
}
