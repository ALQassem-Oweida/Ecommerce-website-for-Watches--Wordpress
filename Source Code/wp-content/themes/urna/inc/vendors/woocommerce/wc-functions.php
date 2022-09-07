<?php

if (!class_exists('WooCommerce')) {
    return;
}

// class cart Postion
if (! function_exists('urna_tbay_body_classes_config_woocommerce')) {
    function urna_tbay_body_classes_config_woocommerce($classes)
    {
        $class  =  (is_cart() && urna_tbay_get_config('ajax_update_quantity', false)) ? 'tbay-ajax-update-quantity' : '';

        $full   = urna_check_full_width();

        $class  = urna_add_cssclass($full['class'], $class);

        $type   = apply_filters('urna_woo_config_product_layout', 10, 2);

        $class  = urna_add_cssclass('layout-product-'. $type, $class);

        if (is_product_category()) {
            $class  = urna_add_cssclass('tbay-product-category', $class);
        }

        if (is_cart() && WC()->cart->is_empty()) {
            $class = urna_add_cssclass('empty-cart', $class);
        }

        if (class_exists('Woo_Variation_Swatches')) {
            if (!(class_exists('Woo_Variation_Swatches_Pro') && function_exists('wvs_pro_archive_variation_template'))) {
                $class = urna_add_cssclass('tbay-variation-free', $class);
            }
        }

        
        $classes[] = trim($class);

        return $classes;
    }
    add_filter('body_class', 'urna_tbay_body_classes_config_woocommerce');
}

if (! function_exists('urna_check_full_width')) {
    function urna_check_full_width()
    {
        $setting = array();

        $setting['active'] = false;
        $setting['class']  = '';


        //add full width product archives page
        if (is_product_category() || is_product_tag() || is_product_taxonomy() || is_shop()) {
            $setting['class'] =  (apply_filters('urna_woo_width_product_archives', 10, 2)) ? ' body-full-width' : '';

            $setting['active'] =  apply_filters('urna_woo_width_product_archives', 10, 2);
        }

        if (is_product()) {
            $setting['class'] =  (apply_filters('urna_woo_width_product_single', 10, 2)) ? ' body-full-width' : '';

            $setting['active'] =  apply_filters('urna_woo_width_product_single', 10, 2);
        }

        return $setting;
    }
}

// add to cart modal box
if (!function_exists('urna_tbay_woocommerce_add_to_cart_modal')) {
    function urna_tbay_woocommerce_add_to_cart_modal()
    {
        if (is_account_page() || is_checkout() || (function_exists('is_vendor_dashboard') && is_vendor_dashboard())) {
            return;
        } ?>
    <div id="tbay-cart-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-body-content"></div>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
}


// cart modal
if (!function_exists('urna_tbay_woocommerce_cart_modal')) {
    function urna_tbay_woocommerce_cart_modal()
    {
        wc_get_template('content-product-cart-modal.php', array( 'product_id' => (int)$_GET['product_id'], 'product_qty' => (int)$_GET['product_qty'] ));
        die;
    }
}

// Cart Position
if (!function_exists('urna_tbay_woocommerce_cart_position')) {
    function urna_tbay_woocommerce_cart_position()
    {
        if (wp_is_mobile()) {
            return 'right';
        }

        $position_array = array("popup", "left", "right", "no-popup");

        $position = urna_tbay_get_config('woo_mini_cart_position', 'popup');

        $position = (isset($_GET['ajax_cart'])) ? $_GET['ajax_cart'] : $position;

        $position =  (!in_array($position, $position_array)) ? urna_tbay_get_config('woo_mini_cart_position', 'popup') : $position;

        return $position;
    }
    add_filter('urna_cart_position', 'urna_tbay_woocommerce_cart_position', 10, 1);
}


if (!function_exists('urna_tbay_get_woocommerce_mini_cart')) {
    function urna_tbay_get_woocommerce_mini_cart($args = array())
    {
        $args = wp_parse_args(
            $args,
            array(
                'icon_array'     => array(
                    'has_svg'       => false,
                    'iconClass'     => 'linear-icon-cart',
                ),
                'show_title_mini_cart'          => '',
                'title_mini_cart'               => esc_html__('Shopping cart', 'urna'),
                'title_dropdown_mini_cart'      => esc_html__('Shopping cart', 'urna'),
                'price_mini_cart'               => '',
                'active_elementor_minicart'     => false,
            )
        );

        $position = apply_filters('urna_cart_position', 10, 2);
 
        $mark = '';
        if (!empty($position)) {
            $mark = '-';
        }

        wc_get_template('cart/mini-cart-button'.$mark.$position.'.php', array('args' => $args)) ;
    }
}

  
// class cart Postion
if (! function_exists('urna_tbay_body_classes_cart_postion')) {
    function urna_tbay_body_classes_cart_postion($classes)
    {
        $position = apply_filters('urna_cart_position', 10, 2);

        $class = (isset($_GET['ajax_cart'])) ? 'ajax_cart_'.$_GET['ajax_cart'] : 'ajax_cart_'.$position;

        $classes[] = trim($class);

        return $classes;
    }
    add_filter('body_class', 'urna_tbay_body_classes_cart_postion');
}


add_action('wp_ajax_urna_add_to_cart_product', 'urna_tbay_woocommerce_cart_modal');
add_action('wp_ajax_nopriv_urna_add_to_cart_product', 'urna_tbay_woocommerce_cart_modal');
add_action('wp_footer', 'urna_tbay_woocommerce_add_to_cart_modal');


/*get category by id array*/
if (!function_exists('urna_tbay_get_category_by_id')) {
    function urna_tbay_get_category_by_id($categories_id = array())
    {
        $categories = array();

        if (!is_array($categories_id)) {
            return $categories;
        }

        foreach ($categories_id as $key => $value) {
            if (!empty(get_term_by('id', $value, 'product_cat'))) {
                $categories[$key] = get_term_by('id', $value, 'product_cat')->slug;
            }
        }

        return $categories;
    }
}
 
if (!function_exists('urna_tbay_get_products')) {
    function urna_tbay_get_products($categories = array(), $product_type = 'featured_product', $paged = 1, $post_per_page = -1, $orderby = '', $order = '', $offset  = 0)
    {
        global $woocommerce;
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $post_per_page,
            'post_status' => 'publish',
            'paged' => $paged,
            'orderby'   => $orderby,
            'order' => $order,
            'offset' => $offset,
            'meta_query'     => WC()->query->get_meta_query(),
            'tax_query'      => WC()->query->get_tax_query(),
        );

        if (isset($args['orderby'])) {
            if ('price' == $args['orderby']) {
                $args = array_merge($args, array(
                    'meta_key'  => '_price',
                    'orderby'   => 'meta_value_num'
                ));
            }
            if ('featured' == $args['orderby']) {
                $args = array_merge($args, array(
                    'meta_key'  => '_featured',
                    'orderby'   => 'meta_value'
                ));
            }
            if ('sku' == $args['orderby']) {
                $args = array_merge($args, array(
                    'meta_key'  => '_sku',
                    'orderby'   => 'meta_value'
                ));
            }
        }

        if (!empty($categories) && is_array($categories)) {
            $args['tax_query']    = array(
                array(
                    'taxonomy'      => 'product_cat',
                    'field'         => 'slug',
                    'terms'         => $categories,
                    'operator'      => 'IN'
                )
            );
        }

        switch ($product_type) {
            case 'best_selling':
                $args['meta_key']='total_sales';
                $args['orderby']='meta_value_num';
                $args['ignore_sticky_posts']   = 1;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;
            case 'featured_product':
                $args['ignore_sticky_posts']    = 1;
                $args['meta_query']             = array();
                $args['meta_query'][]           = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][]           = $woocommerce->query->visibility_meta_query();
                $args['tax_query'][]              = array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN'
                    )
                );
                
                break;
            case 'top_rate':
                $args['meta_key']       ='_wc_average_rating';
                $args['orderby']        ='meta_value_num';
                $args['order']          ='DESC';
                $args['meta_query']     = array();
                $args['meta_query'][]   = WC()->query->get_meta_query();
                $args['tax_query'][]    = WC()->query->get_tax_query();
                break;

            case 'recent_product':
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;
            case 'random_product':
                $args['orderby']    = 'rand';
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;
            case 'deals':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $args['meta_query'][] =  array(
                    'relation' => 'AND',
                    array(
                        'relation' => 'OR',
                        array(
                            'key'           => '_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                        array(
                            'key'           => '_min_variation_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                    ),
                    array(
                        'key'           => '_sale_price_dates_to',
                        'value'         => time(),
                        'compare'       => '>',
                        'type'          => 'numeric'
                    ),
                );
                break;
            case 'on_sale':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                break;
        }

        if( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $args['meta_query'][] =  array(
                'relation' => 'AND',
                array(
                    'key' => '_stock_status',
                    'value' => 'instock',
                    'compare' => '=',
                )
            );
        }

        $args['tax_query'][] = array(
            'relation' => 'AND',
            array(
               'taxonomy' =>   'product_visibility',
                'field'    =>   'slug',
                'terms'    =>   array('exclude-from-search', 'exclude-from-catalog'),
                'operator' =>   'NOT IN',
            )
        );
        
        return new WP_Query($args);
    }
}

// hooks
if (!function_exists('urna_tbay_woocommerce_enqueue_styles')) {
    function urna_tbay_woocommerce_enqueue_styles()
    {
        $suffix = (urna_tbay_get_config('minified_js', false)) ? '.min' : URNA_MIN_JS;

        wp_enqueue_script('urna-woocommerce-script', URNA_SCRIPTS . '/woocommerce' . $suffix . '.js', array( 'jquery', 'urna-script' ), URNA_THEME_VERSION, true);

        wp_register_script('jquery-onepagenav', URNA_SCRIPTS . '/jquery.onepagenav' . $suffix . '.js', array( 'jquery', 'urna-script' ), '3.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'urna_tbay_woocommerce_enqueue_styles', 50);

if (! function_exists('urna_compare_styles')) {
    add_action('wp_print_styles', 'urna_compare_styles', 200);
    function urna_compare_styles()
    {
        if (! class_exists('YITH_Woocompare')) {
            return;
        }
        $view_action = 'yith-woocompare-view-table';
        if ((! defined('DOING_AJAX') || ! DOING_AJAX) && (! isset($_REQUEST['action']) || $_REQUEST['action'] != $view_action)) {
            return;
        }
        wp_enqueue_style('linearicons');
        wp_enqueue_style('urna-template');
        wp_enqueue_style('urna-skin');
        wp_enqueue_style('urna-style');
        add_filter('body_class', 'urna_tbay_body_classes_compare');
    }
}


if (! function_exists('urna_tbay_body_classes_compare')) {
    function urna_tbay_body_classes_compare($classes)
    {
        $class = 'tbay-body-compare';

        $classes[] = trim($class);

        return $classes;
    }
}


// cart
if (!function_exists('urna_tbay_woocommerce_header_add_to_cart_fragment')) {
    function urna_tbay_woocommerce_header_add_to_cart_fragment($fragments)
    {
        $fragments['#cart .mini-cart-items'] =  sprintf(_n(' <span class="mini-cart-items"> %d  </span> ', ' <span class="mini-cart-items"> %d </span> ', WC()->cart->get_cart_contents_count(), 'urna'), WC()->cart->get_cart_contents_count());
        $fragments['#cart .mini-cart-total'] = trim(WC()->cart->get_cart_subtotal());
        return $fragments;
    }
}
add_filter('woocommerce_add_to_cart_fragments', 'urna_tbay_woocommerce_header_add_to_cart_fragment', 10, 1);

// breadcrumb for woocommerce page
if (!function_exists('urna_tbay_woocommerce_breadcrumb_defaults')) {
    function urna_tbay_woocommerce_breadcrumb_defaults($args)
    {
        global $post;

        $breadcrumb_img = urna_tbay_get_config('woo_breadcrumb_image');
        $breadcrumb_color = urna_tbay_get_config('woo_breadcrumb_color');
        $style = array();
        $img = '';

        $sidebar_configs = urna_tbay_get_woocommerce_layout_configs();


        $breadcrumbs_layout = urna_tbay_get_config('product_breadcrumb_layout', 'color');


        if (isset($_GET['breadcrumbs_layout'])) {
            $breadcrumbs_layout = $_GET['breadcrumbs_layout'];
        }

        $class_container = '';
        if (isset($sidebar_configs['container_full']) &&  $sidebar_configs['container_full']) {
            $class_container = 'container-full';
        }

        switch ($breadcrumbs_layout) {
            case 'image':
                $breadcrumbs_class = ' breadcrumbs-image';
                break;
            case 'color':
                $breadcrumbs_class = ' breadcrumbs-color';
                break;
            case 'text':
                $breadcrumbs_class = ' breadcrumbs-text';
                break;
            default:
                $breadcrumbs_class  = ' breadcrumbs-text';
        }

        if (isset($sidebar_configs['breadscrumb_class'])) {
            $breadcrumbs_class .= ' '.$sidebar_configs['breadscrumb_class'];
        }

        
        $current_page = true;

        switch ($current_page) {
            case is_shop():
                $page_id = wc_get_page_id('shop');
                break;
            case is_checkout():
            case is_order_received_page():
                $page_id = wc_get_page_id('checkout');
                break;
            case is_edit_account_page():
            case is_add_payment_method_page():
            case is_lost_password_page():
            case is_account_page():
            case is_view_order_page():
                $page_id = wc_get_page_id('myaccount');
                break;
            
            default:
                $page_id = $post->ID;
                break;
        }

        if (isset($breadcrumb_img['url']) && !empty($breadcrumb_img['url']) && $breadcrumbs_layout !=='color' && $breadcrumbs_layout !=='text') {
            $img = '<img src=" '.esc_url($breadcrumb_img['url']).'">';
        }

        if ($breadcrumb_color && $breadcrumbs_layout !== 'image') {
            $style[] = 'background-color:'.$breadcrumb_color;
        }

        $estyle = (!empty($style) && $breadcrumbs_layout !=='text') ? ' style="'.implode(";", $style).'"':"";

        $title = $nav = '';

        if ($breadcrumbs_layout == 'image') {
            if (is_product_category()) {
                $title = '<h1 class="page-title">'. single_cat_title('', false) .'</h1>';
            } else {
                $title = '<h1 class="page-title">'. get_the_title($page_id) .'</h1>';
            }
        } else {
            if (is_single()) {
                $nav = urna_woo_product_nav_icon();

                $breadcrumbs_class .= ' active-nav-icon';
            } else {
                if (urna_tbay_get_config('enable_previous_page_woo', true)) {
                    $nav .= '<a href="javascript:history.back()" class="urna-back-btn"><i class="linear-icon-arrow-left"></i><span class="text">'. esc_html__('Previous page', 'urna') .'</span></a>';
                    $breadcrumbs_class .= ' active-nav-right';
                }
            }
        }

        $args['wrap_before'] = '<section id="tbay-breadscrumb" '.$estyle.' class="tbay-breadscrumb '.esc_attr($breadcrumbs_class).'">'.$img.'<div class="container '.$class_container.'"><div class="breadscrumb-inner">'. $title .'<ol class="tbay-woocommerce-breadcrumb breadcrumb">';
        $args['wrap_after'] = '</ol>'. $nav .'</div></div></section>';

        return $args;
    }
}

// Remove default breadcrumb
add_filter('woocommerce_breadcrumb_defaults', 'urna_tbay_woocommerce_breadcrumb_defaults', 10, 1);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

add_action('urna_woo_template_main_before', 'woocommerce_breadcrumb', 20);

add_action('init', 'urna_woo_remove_wc_breadcrumb', 90);
function urna_woo_remove_wc_breadcrumb()
{
    if (!urna_tbay_get_config('show_product_breadcrumb', false)) {
        remove_action('urna_woo_template_main_before', 'woocommerce_breadcrumb', 20, 0);
    }
}

// display woocommerce modes
if (!function_exists('urna_tbay_woocommerce_display_modes')) {
    function urna_tbay_woocommerce_display_modes()
    {
        $active  = apply_filters('urna_woo_config_display_mode', 10, 2);

        if (!$active || !wc_get_loop_prop('is_paginated') || (!woocommerce_products_will_display() && !urna_woo_is_vendor_page())) {
            return;
        }
        
        $woo_mode       = urna_tbay_woocommerce_get_display_mode();

        $grid = ($woo_mode == 'grid') ? 'active' : '';
        $grid2 = ($woo_mode == 'grid2') ? 'active' : '';
        $list = ($woo_mode == 'list') ? 'active' : '';

        $archives_full  = apply_filters('urna_woo_width_product_archives', 10, 2);
        $sidebar_configs = urna_tbay_get_woocommerce_layout_configs();

        if (!urna_woo_is_vendor_page() && ($archives_full || (empty($sidebar_configs['left']['sidebar']) && empty($sidebar_configs['right']['sidebar'])))) {
            return;
        } ?>
        <div class="display-mode-warpper">
            <a href="javascript:void(0);" id="display-mode-grid" class="display-mode-btn <?php echo esc_attr($grid); ?>" title="<?php esc_attr_e('Grid', 'urna'); ?>" ><i class="linear-icon-icons"></i></a>
            <a href="javascript:void(0);" id="display-mode-grid2" class="display-mode-btn grid2 <?php echo esc_attr($grid2); ?> hidden-xs" title="<?php esc_attr_e('Grid 2', 'urna'); ?>" ><i class="linear-icon-border-all"></i></a>
            <a href="javascript:void(0);" id="display-mode-list" class="display-mode-btn list <?php echo esc_attr($list); ?>" title="<?php esc_attr_e('List', 'urna'); ?>" ><i class="linear-icon-menu2"></i></a>
        </div>

        <?php
    }
    add_action('woocommerce_before_shop_loop', 'urna_tbay_woocommerce_display_modes', 10);
}
/*Vendor Dokan page*/
if (class_exists('WeDevs_Dokan')) {
    add_action('dokan_store_profile_frame_after', 'urna_tbay_woocommerce_display_modes', 10);
    add_action('dokan_store_profile_frame_after', 'urna_dokan_get_number_of_products_of_vendor', 10);
    add_action('dokan_store_profile_frame_after', 'urna_tbay_button_filter_sidebar_mobile', 9);
}


if (!function_exists('urna_tbay_woocommerce_get_cookie_display_mode')) {
    function urna_tbay_woocommerce_get_cookie_display_mode()
    {
        $woo_mode = urna_tbay_get_config('product_display_mode', 'grid');

        if (isset($_COOKIE['urna_display_mode']) && $_COOKIE['urna_display_mode'] == 'grid') {
            $woo_mode = 'grid';
        } elseif (isset($_COOKIE['urna_display_mode']) && $_COOKIE['urna_display_mode'] == 'grid2') {
            $woo_mode = 'grid2';
        } elseif (isset($_COOKIE['urna_display_mode']) && $_COOKIE['urna_display_mode'] == 'list') {
            $woo_mode = 'list';
        }

        return $woo_mode;
    }
}

if (!function_exists('urna_tbay_woocommerce_get_display_mode')) {
    function urna_tbay_woocommerce_get_display_mode()
    {
        $woo_mode = urna_tbay_woocommerce_get_cookie_display_mode();

        if (isset($_GET['display_mode']) && $_GET['display_mode'] == 'grid') {
            $woo_mode = 'grid';
        } elseif (isset($_GET['display_mode']) && $_GET['display_mode'] == 'grid2') {
            $woo_mode = 'grid2';
        } elseif (isset($_GET['display_mode']) && $_GET['display_mode'] == 'list') {
            $woo_mode = 'list';
        }

        if (!is_shop() && !is_product_category() && !is_product_tag()) {
            $woo_mode = 'grid';
        }

        $archives_full  = apply_filters('urna_woo_width_product_archives', 10, 2);
        $sidebar_configs = urna_tbay_get_woocommerce_layout_configs();
        if ($archives_full || (empty($sidebar_configs['left']['sidebar']) && empty($sidebar_configs['right']['sidebar']))) {
            $woo_mode = 'grid';
        }

        return $woo_mode;
    }
}

/*Check not child categories*/
if (!function_exists('urna_is_check_not_child_categories')) {
    function urna_is_check_not_child_categories()
    {
        global $wp_query;

        if (is_product_category()) {
            $cat   = get_queried_object();
            $cat_id     = $cat->term_id;

            $args2 = array(
                'taxonomy'     => 'product_cat',
                'parent'       => $cat_id,
            );

            $sub_cats = get_categories($args2);
            if (!$sub_cats) {
                return true;
            }
        }

        return false;
    }
}

/*Check not product in categories*/
if (!function_exists('urna_is_check_hidden_filter')) {
    function urna_is_check_hidden_filter()
    {
        if (is_product_category()) {
            $checkchild_cat     =  urna_is_check_not_child_categories();

            if (!$checkchild_cat &&  'subcategories' === get_option('woocommerce_category_archive_display')) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('urna_tbay_filter_before')) {
    function urna_tbay_filter_before()
    {
        $notproducts =  (urna_is_check_hidden_filter()) ? ' hidden' : '';

        echo '<div class="tbay-filter'. esc_attr($notproducts) . '">';
    }
    add_action('woocommerce_before_shop_loop', 'urna_tbay_filter_before', 1);
}
if (!function_exists('urna_tbay_filter_after')) {
    function urna_tbay_filter_after()
    {
        echo '</div>';
    }
    add_action('woocommerce_before_shop_loop', 'urna_tbay_filter_after', 70);
}

/*Fix Layout Shop Descreption Width Left Rihgt*/
if (!function_exists('urna_tbay_subcategories_wraper_open')) {
    function urna_tbay_subcategories_wraper_open()
    {
        $sidebar_configs = urna_tbay_get_woocommerce_layout_configs();

        if (isset($sidebar_configs['left_descreption']) && !isset($sidebar_configs['right_descreption'])) {
            $sidebar_configs['main_descreption']['class'] .= ' pull-right';
        }

        if (isset($sidebar_configs['descreption']) &&  $sidebar_configs['descreption']) {
            echo '<div class="row">';

            echo '<div class="'.esc_attr($sidebar_configs['main_descreption']['class']).'">';
        }
    }
}
add_action('woocommerce_before_shop_loop', 'urna_tbay_subcategories_wraper_open', 41);

if (!function_exists('urna_tbay_subcategories_wraper_closed')) {
    function urna_tbay_subcategories_wraper_closed()
    {
        $sidebar_configs = urna_tbay_get_woocommerce_layout_configs();

        if (isset($sidebar_configs['descreption']) &&  $sidebar_configs['descreption']) {
            echo '</div>'; ?>
                <?php if (isset($sidebar_configs['left_descreption'])) : ?>
                    <div class="<?php echo esc_attr($sidebar_configs['left_descreption']['class']) ; ?>">
                        <aside class="sidebar sidebar-left" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
                            <?php dynamic_sidebar($sidebar_configs['left_descreption']['sidebar']); ?>
                        </aside>
                    </div>
                <?php endif; ?>

                <?php if (isset($sidebar_configs['right_descreption'])) : ?>
                    <div class="<?php echo esc_attr($sidebar_configs['right_descreption']['class']) ; ?>">
                        <aside class="sidebar sidebar-right" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
                            <?php dynamic_sidebar($sidebar_configs['right_descreption']['sidebar']); ?>
                        </aside>
                    </div>
                <?php endif; ?>

            <?php

            echo '</div>';
        }
    }
    add_action('woocommerce_after_shop_loop', 'urna_tbay_subcategories_wraper_closed', 41);
}


// Hook Product Top sidebar
if (!function_exists('urna_tbay_get_product_top_sidebar')) {
    function urna_tbay_get_product_top_sidebar()
    {
        $sidebar_configs = urna_tbay_get_woocommerce_layout_configs();

        $class_container = '';
        if (isset($sidebar_configs['container_full']) &&  $sidebar_configs['container_full']) {
            $class_container = 'container-full';
        }

        if (!is_product()  && isset($sidebar_configs['product_top_sidebar']) && $sidebar_configs['product_top_sidebar']) {
            ?>

            <?php if (is_active_sidebar('product-top-sidebar')) : ?>
                <div class="product-top-sidebar">

                    <div class="product-top-button-wrapper"> 
                        <div class="container <?php echo esc_attr($class_container); ?>">
                            <button class="button-product-top" type="submit"><?php esc_html_e('Advanced filter', 'urna'); ?><i class="fa fa-angle-down first" aria-hidden="true"></i><i class="fa fa-angle-up second" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="container <?php echo esc_attr($class_container); ?>">
                        <div class="content">
                            <?php dynamic_sidebar('product-top-sidebar'); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php
        }
    }
    add_action('urna_woo_template_main_before', 'urna_tbay_get_product_top_sidebar', 50);
}

// Number of products per page
if (!function_exists('urna_tbay_woocommerce_shop_per_page')) {
    function urna_tbay_woocommerce_shop_per_page($number)
    {
        if (isset($_GET['product_per_page']) && is_numeric($_GET['product_per_page'])) {
            $value = $_GET['product_per_page'];
        } else {
            $value = urna_tbay_get_config('number_products_per_page');
        }

        if (is_numeric($value) && $value) {
            $number = absint($value);
        }
        return $number;
    }
    add_filter('loop_shop_per_page', 'urna_tbay_woocommerce_shop_per_page');
}


// Number of products per row
if (!function_exists('urna_tbay_woocommerce_shop_columns')) {
    function urna_tbay_woocommerce_shop_columns($number)
    {
        if (isset($_GET['product_columns']) && is_numeric($_GET['product_columns'])) {
            $value = $_GET['product_columns'];
        } else {
            $value = urna_tbay_get_config('product_columns');
        }

        if (in_array($value, array(1, 2, 3, 4, 5, 6))) {
            $number = $value;
        }
        return $number;
    }
    add_filter('loop_shop_columns', 'urna_tbay_woocommerce_shop_columns');
}



// Two product thumbnail
if (!function_exists('urna_tbay_woocommerce_get_two_product_thumbnail')) {
    function urna_tbay_woocommerce_get_two_product_thumbnail()
    {
        global $product;

        $size = 'woocommerce_thumbnail';
        $placeholder = wc_get_image_size($size);
        $placeholder_width = $placeholder['width'];
        $placeholder_height = $placeholder['height'];
        $post_thumbnail_id =  $product->get_image_id();

        $output='';
        $class = 'image-no-effect';
        if (has_post_thumbnail()) {
            $attachment_ids = $product->get_gallery_image_ids();

            $class = ($attachment_ids && isset($attachment_ids[0])) ? 'attachment-shop_catalog image-effect' : $class;

            $output .= wp_get_attachment_image($post_thumbnail_id, $size, false, array('class' => $class ));
            if ($attachment_ids && isset($attachment_ids[0])) {
                $output .= wp_get_attachment_image($attachment_ids[0], $size, false,array('class' => 'image-hover' ));
            }
        } else {
            $output .= '<img src="'.wc_placeholder_img_src().'" alt="'. esc_attr__('Placeholder' , 'urna'). '" class="'. esc_attr($class) .'" width="'. esc_attr($placeholder_width) .'" height="'. esc_attr($placeholder_height) .'" />';
        }
        return trim($output);
    }
}

// Slider product thumbnail
if (!function_exists('urna_tbay_woocommerce_get_silder_product_thumbnail')) {
    function urna_tbay_woocommerce_get_silder_product_thumbnail()
    {
        global $product;

        wp_enqueue_script('slick');
        wp_enqueue_script('urna-slick');

        $size = 'woocommerce_thumbnail';
        $placeholder = wc_get_image_size($size);
        $placeholder_width = $placeholder['width'];
        $placeholder_height = $placeholder['height'];
        $post_thumbnail_id =  $product->get_image_id();

        $output='';
        $class = 'image-no-effect';

        if (has_post_thumbnail()) {
            $class = 'item-slider';

            $output .= '<div class="tbay-product-slider-gallery">';

            $output .= '<div class="gallery_item first">'.wp_get_attachment_image($post_thumbnail_id, $size, false, array('class' => $class )).'</div>';

            $attachment_ids = $product->get_gallery_image_ids();

            foreach ($attachment_ids as $attachment_id) {
                $output .= '<div class="gallery_item">'.wp_get_attachment_image($attachment_id, $size, false,array('class' => $class )).'</div>';
            }

            $output .= '</div>';
        } else {
            $output .= '<div class="gallery_item first">';
            $output .= '<img src="'.wc_placeholder_img_src().'" alt="'. esc_attr__('Placeholder' , 'urna'). '" class="'. esc_attr($class) .'" width="'. esc_attr($placeholder_width) .'" height="'. esc_attr($placeholder_height) .'" />';
            $output .= '</div>';
        }

        return trim($output);
    }
}

if (!function_exists('urna_product_block_image_class')) {
    function urna_product_block_image_class($class = '')
    {
        $images_mode   = apply_filters('urna_woo_display_image_mode', 10, 2);

        if ($images_mode !=  'slider') {
            return;
        }
        $class = ' has-slider-gallery';

        echo trim($class);
    }
}

if (!function_exists('urna_slick_carousel_product_block_image_class')) {
    function urna_slick_carousel_product_block_image_class($class = '')
    {
        $images_mode   = apply_filters('urna_woo_display_image_mode', 10, 2);

        if ($images_mode !=  'slider') {
            return;
        }
        $class = ' slick-has-slider-gallery';

        echo trim($class);
    }
}

if (!function_exists('urna_tbay_add_slider_image')) {
    function urna_tbay_add_slider_image()
    {
        if (wp_is_mobile()) {
            return;
        }

        $images_mode   = apply_filters('urna_woo_display_image_mode', 10, 2);

        if ($images_mode == 'slider') {
            echo urna_tbay_woocommerce_get_silder_product_thumbnail();
        }
    }

    add_action('urna_tbay_after_shop_loop_item_title', 'urna_tbay_add_slider_image', 10);
}

if (!function_exists('urna_tbay_product_class')) {
    function urna_tbay_product_class($class = array())
    {
        global $product;

        $class_array    = array();

        $type           = apply_filters('urna_woo_config_product_layout', 10, 2);
        $class_varible  = urna_is_product_variable_sale();

        $class    = trim(join(' ', $class));
        if (!is_array($class)) {
            $class = explode(" ", $class);
        }

        $quantity_mode = apply_filters('urna_quantity_mode', 10, 2);

        if ($quantity_mode) {
            $class_array[] = 'product-quantity-mode';
        }

        array_push($class_array, "product-block", "grid", $type, $class_varible);

        $class_array    = array_merge($class_array, $class);

        $class_array    = trim(join(' ', $class_array));

        echo 'class="' . esc_attr($class_array) . '"';
    }
}


if (!function_exists('urna_tbay_woocommerce_product_display_image_mode')) {
    function urna_tbay_woocommerce_product_display_image_mode($mode)
    {
        $mode = urna_tbay_get_config('product_display_image_mode', 'one');

        $mode = (isset($_GET['display_image_mode'])) ? $_GET['display_image_mode'] : $mode;

        if (wp_is_mobile()) {
            $mode = 'one';
        }

        return $mode;
    }
}
add_filter('urna_woo_display_image_mode', 'urna_tbay_woocommerce_product_display_image_mode');


if (!function_exists('urna_tbay_product_display_image_mode')) {
    function urna_tbay_product_display_image_mode()
    {
        $images_mode   = apply_filters('urna_woo_display_image_mode', 10, 2);

        if (wp_is_mobile()) {
            $images_mode = 'one';
        }

        switch ($images_mode) {
            case 'one':
                echo urna_tbay_woocommerce_get_one_product_thumbnail();
                break;

            case 'two':
                echo urna_tbay_woocommerce_get_two_product_thumbnail();
                break;
                
            case 'slider':
                echo '';
                break;
            
            default:
                echo urna_tbay_woocommerce_get_one_product_thumbnail();
                break;
        }
    }
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
    add_action('woocommerce_before_shop_loop_item_title', 'urna_tbay_product_display_image_mode', 10);
}

if (!function_exists('urna_tbay_woocommerce_get_one_product_thumbnail')) {
    function urna_tbay_woocommerce_get_one_product_thumbnail($size = 'woocommerce_thumbnail', $attr = array(), $placeholder = true)
    {
        global $product;
 
        if ($product->get_image_id()) {
            $image = wp_get_attachment_image($product->get_image_id(), $size, false, $attr);
        } elseif ($product->get_parent_id()) {
            $parent_product = wc_get_product($product->get_parent_id());
            if ($parent_product) {
                $image = wp_get_attachment_image($parent_product->get_image_id(), $size, false, $attr);
            }
        }

        if (!isset($image) && $placeholder) {
            $placeholder = wc_get_image_size($size);
            $placeholder_width = $placeholder['width'];
            $placeholder_height = $placeholder['height'];

            $image = '<img src="'.wc_placeholder_img_src().'" alt="'. esc_attr__('Placeholder' , 'urna'). '" width="'. esc_attr($placeholder_width) .'" height="'. esc_attr($placeholder_height) .'" />';
        }


        return $image;
    }
}


if (! function_exists('urna_has_swatch')) {
    function urna_has_swatch($id, $attr_name, $value)
    {
        $swatches = array();

        $color = $image = $button = '';
        
        $term = get_term_by('slug', $value, $attr_name);
        if (is_object($term)) {
            $color      =   sanitize_hex_color(get_term_meta($term->term_id, 'product_attribute_color', true));
            $image      =   get_term_meta($term->term_id, 'product_attribute_image', true);
            $button      =   $term->name;
        }

        if( $color != '' ) {
            $swatches['color']  = $color;
            $swatches['type']   = 'color';
        } elseif( $image != '' ) {
            $swatches['image']  = $image;
            $swatches['type']   = 'image';
        } else {
            $swatches['button'] = $button;
            $swatches['type']   = 'button';
        }

        return $swatches;
    }
}


if (! function_exists('urna_get_option_variations')) {
    function urna_get_option_variations($attribute_name, $available_variations, $option = false, $product_id = false)
    {
        $swatches_to_show = array();
        foreach ($available_variations as $key => $variation) {
            $option_variation = array();
            $attr_key = 'attribute_' . $attribute_name;
            if (! isset($variation['attributes'][$attr_key])) {
                return;
            }

            $val = $variation['attributes'][$attr_key]; // red green black ..

            if (! empty($variation['image']['thumb_src'])) {
                $option_variation = array(
                    'variation_id' => $variation['variation_id'],
                    'image_src' => $variation['image']['thumb_src'],
                    'image_srcset' => $variation['image']['srcset'],
                    'image_sizes' => $variation['image']['sizes'],
                    'is_in_stock' => $variation['is_in_stock'],
                );
            }

            // Get only one variation by attribute option value
            if ($option) {
                if ($val != $option) {
                    continue;
                } else {
                    return $option_variation;
                }
            } else {
                // Or get all variations with swatches to show by attribute name
                
                $swatch = urna_has_swatch($product_id, $attribute_name, $val);
                $swatches_to_show[$val] = array_merge($swatch, $option_variation);
            }
        }

        return $swatches_to_show;
    }
}


/**
 * ------------------------------------------------------------------------------------------------
 * Show attribute swatches list
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_swatches_list')) {
    function urna_swatches_list($attribute_name = false)
    {
        global $product;

        $id = $product->get_id();

        if (empty($id) || ! $product->is_type('variable')) {
            return false;
        }
        
        if (! $attribute_name) {
            $attribute_name = urna_get_swatches_attribute();
        }


        
        if (empty($attribute_name)) {
            return false;
        }

        $available_variations = $product->get_available_variations();

        if (empty($available_variations)) {
            return false;
        }

        $swatches_to_show = urna_get_option_variations($attribute_name, $available_variations, false, $id);


        if (empty($swatches_to_show)) {
            return false;
        }
 
        $terms = wc_get_product_terms($product->get_id(), $attribute_name, array( 'fields' => 'slugs' ));

        $swatches_to_show_tmp = $swatches_to_show;

        $swatches_to_show = array();

        foreach ($terms as $id => $slug) {
            if (!empty($swatches_to_show_tmp[$slug])) {
                $swatches_to_show[$slug] = $swatches_to_show_tmp[$slug];
            }
        }


        $out = '';
        $out .=  '<div class="tbay-swatches-wrapper"><ul data-attribute_name="attribute_'. $attribute_name .'">';

        foreach ($swatches_to_show as $key => $swatch) {
            $style = $class = '';

            $style .= '';

            $data = '';

            if (isset($swatch['image_src'])) {
                $class .= 'swatch-has-image';
                $data .= 'data-image-src="' . $swatch['image_src'] . '"';
                $data .= ' data-image-srcset="' . $swatch['image_srcset'] . '"';
                $data .= ' data-image-sizes="' . $swatch['image_sizes'] . '"';

                if (! $swatch['is_in_stock']) {
                    $class .= ' variation-out-of-stock';
                }
            }
            

            $term = get_term_by('slug', $key, $attribute_name);
            $slug   = $term->slug;

            $name = '';


            switch ($swatch['type']) {
                case 'color':
                    $style  = 'background-color:' .  $swatch['color'];
                    $class .= ' variable-item-span-color';
                    break;

                case 'image':
                    $img    = wp_get_attachment_image_src( $swatch['image'], 'woocommerce_thumbnail' );
                    $style  = 'background-image: url(' . $img['0'] . ')';
                    $class .= ' variable-item-span-image';
                    break;
                
                case 'button':
                    $name   = $swatch['button'];
                    $class .= ' variable-item-span-label';
                    break;
                
                default:
                    break;
            }


            $out .=  '<li><a href="javascript:void(0)" class="'. $class .' swatch swatch-'. strtolower($slug) .'" style="' . esc_attr($style) .'" ' . $data . '  data-toggle="tooltip" title="'. $name .'">' . $name . '</a></li>';
        }

        $out .=  '</ul></div>';

        return $out;
    }
}


if (! function_exists('urna_get_swatches_attribute')) {
    function urna_get_swatches_attribute()
    {
        $custom = get_post_meta(get_the_ID(), '_urna_attribute_select', true);

        return empty($custom) ? urna_tbay_get_config('variation_swatch') : $custom;
    }
}


if (! function_exists('urna_tbay_woocommerce_variable')) {

    /**
     * Output the variable product add to cart area.
     *
     * @subpackage  Product
     */
    function urna_tbay_woocommerce_variable()
    {
        global $product;

        $active = apply_filters('urna_enable_variation_selector', 10, 2);

        if ($product->is_type('variable')  && class_exists('Woo_Variation_Swatches') && $active) {
            ?>

            <?php echo urna_swatches_list() ?>

            <?php
        }
    }
    add_action('urna_tbay_after_shop_loop_item_title', 'urna_tbay_woocommerce_variable', 15);
}


// layout class for woo page
if (!function_exists('urna_tbay_woocommerce_content_class')) {
    function urna_tbay_woocommerce_content_class($class)
    {
        $page = 'archive';
        if (is_singular('product')) {
            $page = 'single';
        }

        if (!isset($_GET['product_'.$page.'_layout'])) {
            $class .= ' '.urna_tbay_get_config('product_'.$page.'_layout');
        } else {
            $class .= ' '.$_GET['product_'.$page.'_layout'];
        }

        return $class;
    }
}
add_filter('urna_tbay_woocommerce_content_class', 'urna_tbay_woocommerce_content_class');

// get layout configs
if (!function_exists('urna_tbay_get_woocommerce_layout_configs')) {
    function urna_tbay_get_woocommerce_layout_configs()
    {
        if (function_exists('dokan_is_store_page') && dokan_is_store_page()) {
            return;
        }
        if (!is_product()) {
            $page = 'product_archive_sidebar';
        } else {
            $page = 'product_single_sidebar';
        }

        $sidebar = urna_tbay_get_config($page);


        if (!is_singular('product')) {
            $product_archive_layout  =   (isset($_GET['product_archive_layout'])) ? $_GET['product_archive_layout'] : urna_tbay_get_config('product_archive_layout', 'shop-left');

            if (urna_woo_is_wcmp_vendor_store()) {
                $sidebar = 'wc-marketplace-store';

                if (!is_active_sidebar($sidebar)) {
                    $product_archive_layout = 'full-width';
                }
            }

            if (isset($product_archive_layout)) {
                switch ($product_archive_layout) {
                    case 'shop-left':
                        $configs['left'] = array( 'sidebar'  => $sidebar, 'class' => 'col-xs-12 col-md-12 col-lg-3'  );
                        $configs['main'] = array( 'class'    => 'col-xs-12 col-md-12 col-lg-9' );
                        break;
                    case 'shop-right':
                        $configs['right'] = array( 'sidebar' => $sidebar,  'class' => 'col-xs-12 col-md-12 col-lg-3' );
                        $configs['main'] = array( 'class'    => 'col-xs-12 col-md-12 col-lg-9' );
                        break;
                    case 'full-width':
                        $configs['main'] = array( 'class' => 'archive-full' );
                        $configs['product_top_sidebar'] = true;
                        break;
                    case 'filter-bar':
                        $configs['main'] = array( 'class' => 'archive-full' );
                        $configs['filter_bar'] = true;
                        break;
                    default:
                        $configs['main'] = array( 'class' => 'archive-full' );
                        break;
                }

                
                if ($product_archive_layout === 'shop-left' && empty($configs['left']['sidebar'])) {
                    $configs['main'] = array( 'class' => 'archive-full' );
                } elseif ($product_archive_layout === 'shop-right' && empty($configs['right']['sidebar'])) {
                    $configs['main'] = array( 'class' => 'archive-full' );
                }
            }
        } else {
            $product_single_layout  =  urna_get_single_select_layout();

            $product_single_sidebar_position    =  (isset($_GET['product_single_sidebar_position']))   ?   $_GET['product_single_sidebar_position'] :  urna_tbay_get_config('product_single_sidebar_position', 'inner-sidebar');

            $class_main = '';
            $class_sidebar = '';
            if ($product_single_layout == 'left-main' || $product_single_layout == 'main-right') {
                if ($product_single_sidebar_position == 'inner-sidebar') {
                    $class_main = 'col-xs-12 inner-sidebar';
                    $class_sidebar = 'col-xs-12 col-lg-3';
                } else {
                    $class_main = 'col-xs-12 col-lg-9 normal-sidebar';
                    $class_sidebar = 'col-xs-12 col-lg-3';

                    $sidebar = urna_tbay_get_config('product_single_sidebar_normal', 'product-single-normal');
                }
            }
            
            if (isset($product_single_layout)) {
                switch ($product_single_layout) {
                    case 'full-width-vertical':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'vertical';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'full-width-horizontal':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'horizontal';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'full-width-gallery':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'gallery';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'full-width-stick':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'stick';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'full-width-full':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'full';
                        $configs['breadscrumb']     = 'color';
                        break;
                   case 'full-width-carousel':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'carousel';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'full-width-centered':
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'centered';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'left-main':
                        $configs['left']            = array( 'sidebar' => $sidebar, 'class' => $class_sidebar );
                        $configs['main']            = array( 'class' => $class_main );
                        $configs['thumbnail']       = 'horizontal';
                        $configs['breadscrumb']     = 'color';
                        break;
                    case 'main-right':
                        $configs['right']           = array( 'sidebar' => $sidebar,  'class' => $class_sidebar );
                        $configs['main']            = array( 'class' => $class_main );
                        $configs['thumbnail']       = 'horizontal';
                        $configs['breadscrumb']     = 'color';
                        break;
                    default:
                        $configs['main']            = array( 'class' => 'archive-full' );
                        $configs['thumbnail']       = 'horizontal';
                        $configs['breadscrumb']     = 'color';
                        break;
                }

                if ($product_single_layout === 'left-main' && empty($configs['left']['sidebar'])) {
                    $configs['main']            = array( 'class' => 'archive-full' );
                    $configs['thumbnail']       = 'horizontal';
                    $configs['breadscrumb']     = 'color';
                } elseif ($product_single_layout === 'main-right' && empty($configs['right']['sidebar'])) {
                    $configs['main']            = array( 'class' => 'archive-full' );
                    $configs['thumbnail']       = 'horizontal';
                    $configs['breadscrumb']     = 'color';
                }
            }
        }

        return $configs;
    }
}

if (!function_exists('urna_class_wrapper_start')) {
    function urna_class_wrapper_start()
    {
        $configs['content']                 = 'content';
        $configs['main']                    = 'main-wrapper ';

        $sidebar_configs                    = urna_tbay_get_woocommerce_layout_configs();
        $configs['content']                 = urna_add_cssclass($configs['content'], $sidebar_configs['main']['class']);
        $product_single_sidebar_position    =  (isset($_GET['product_single_sidebar_position']))   ?   $_GET['product_single_sidebar_position'] :  urna_tbay_get_config('product_single_sidebar_position', 'inner-sidebar');
        $ajax_filter                        = apply_filters('urna_woo_ajax_filter', 10, 2);

        if (!is_product()) {
            $configs['content']  = urna_add_cssclass($configs['content'], 'archive-shop');
            $class_main         =  (isset($_GET['product_archive_layout'])) ? $_GET['product_archive_layout'] : urna_tbay_get_config('product_archive_layout', 'shop-left');
            if (!empty($sidebar_configs['left'])) {
                $configs['content']  = urna_add_cssclass($configs['content'], 'pull-right');
            }
            if ($ajax_filter) {
                $configs['main']  = urna_add_cssclass($configs['main'], 'active-ajax-filter');
            }

            $archives_full  = apply_filters('urna_woo_width_product_archives', 10, 2);
            if ($archives_full) {
                $configs['main']  = urna_add_cssclass($configs['main'], 'active-full-archive');
            }

            $configs['main']  = urna_add_cssclass($configs['main'], $class_main);
        } elseif (is_product()) {
            $configs['content']  = urna_add_cssclass($configs['content'], 'singular-shop');
            
            if (!empty($sidebar_configs['left']) && ($product_single_sidebar_position !== 'inner-sidebar')) {
                $configs['content']  = urna_add_cssclass($configs['content'], 'pull-right');
            }

            $single_full  = apply_filters('urna_woo_width_product_single', 10, 2);
            if ($single_full) {
                $configs['main']  = urna_add_cssclass($configs['main'], 'active-full-archive single-full');
            }

            $class_main         =  (isset($_GET['product_single_layout']))   ?   $_GET['product_single_layout'] :  urna_tbay_get_config('product_single_layout', 'full-width-horizontal');


            $configs['main']  = urna_add_cssclass($configs['main'], $class_main);
        }

        return $configs;
    }
}


if (!function_exists('urna_tbay_minicart')) {
    function urna_tbay_minicart()
    {
        $template = apply_filters('urna_tbay_minicart_version', '');
        get_template_part('woocommerce/cart/mini-cart-button', $template);
    }
}

/* ---------------------------------------------------------------------------
 * WooCommerce - Function get Query
 * --------------------------------------------------------------------------- */
 
 /* Fix ajax count cart */
 if (! function_exists('urna_woo_get_review_counting')) {
    function urna_woo_get_review_counting()
    {
        global $post;
        $output = array();

        for ($i=1; $i <= 5; $i++) {
            $args = array(
                'post_id'      => ($post->ID),
                'meta_query' => array(
                  array(
                    'key'   => 'rating',
                    'value' => $i
                  )
                ),
                'count' => true
            );
             $output[$i] = get_comments($args);
        }
        return $output;
    }
 }

/*Fix count ajax cart*/
add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    ob_start(); ?>

    <span class="subtotal">
        <?php echo WC()->cart->get_cart_subtotal(); ?>
    </span>


    <?php $fragments['span.subtotal']             = ob_get_clean();

    return $fragments;
});

add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    ob_start(); ?>

    <span class="mini-cart-items">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </span>

    <?php $fragments['span.mini-cart-items'] = ob_get_clean();

    return $fragments;
});

add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    ob_start(); ?>

    <span class="mini-cart-items-fixed">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </span>

    <?php $fragments['span.mini-cart-items-fixed'] = ob_get_clean();

    return $fragments;
});

add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    ob_start(); ?>

    <span class="mini-cart-items cart-mobile">
        <?php echo sprintf('%d', WC()->cart->cart_contents_count); ?>
    </span>

    <?php $fragments['span.cart-mobile'] = ob_get_clean();

    return $fragments;
});
/*End count ajax cart*/

// Remove product in the cart using ajax
if (! function_exists('urna_ajax_product_remove')) {
    function urna_ajax_product_remove()
    {
        // Get mini cart
        ob_start();

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            if ($cart_item['product_id'] == $_POST['product_id'] && $cart_item_key == $_POST['cart_item_key']) {
                WC()->cart->remove_cart_item($cart_item_key);
            }
        }

        WC()->cart->calculate_totals();
        WC()->cart->maybe_set_cart_cookies();

        woocommerce_mini_cart();

        $mini_cart = ob_get_clean();

        // Fragments and mini cart are returned
        $data = array(
            'fragments' => apply_filters(
                'woocommerce_add_to_cart_fragments',
                array(
                    'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
                )
            ),
            'cart_hash' => apply_filters('woocommerce_cart_hash', WC()->cart->get_cart_for_session() ? md5(json_encode(WC()->cart->get_cart_for_session())) : '', WC()->cart->get_cart_for_session())
        );

        wp_send_json($data);

        die();
    }
    add_action('wp_ajax_product_remove', 'urna_ajax_product_remove');
    add_action('wp_ajax_nopriv_product_remove', 'urna_ajax_product_remove');
}

/* ---------------------------------------------------------------------------
 * WooCommerce - Function Load more ajax
 * --------------------------------------------------------------------------- */
if (! function_exists('urna_fnc_more_post_ajax')) {
    add_action('wp_ajax_nopriv_urna_more_post_ajax', 'urna_fnc_more_post_ajax');
    add_action('wp_ajax_urna_more_post_ajax', 'urna_fnc_more_post_ajax');

    function urna_fnc_more_post_ajax()
    {
        global $woocommerce_loop,$product_load_more;

        $columns                    =   (isset($_POST["columns"])) ? $_POST["columns"] : 4;
        $layout                     =   (isset($_POST["layout"])) ? $_POST["layout"] : '';
        $number                     =   (isset($_POST["number"])) ? $_POST["number"] : 8;
        $type                       =   (isset($_POST["type"])) ? $_POST["type"] : 'featured_product';
        $paged                      =   (isset($_POST["paged"])) ? $_POST["paged"] : 1;
        $category                   =   (isset($_POST["category"])) ? $_POST["category"] : '';
        $screen_desktop             =   (isset($_POST["screen_desktop"])) ? $_POST["screen_desktop"] : '';
        $screen_desktopsmall        =   (isset($_POST["screen_desktopsmall"])) ? $_POST["screen_desktopsmall"] : '';
        $screen_tablet              =   (isset($_POST["screen_tablet"])) ? $_POST["screen_tablet"] : '';
        $screen_mobile              =   (isset($_POST["screen_mobile"])) ? $_POST["screen_mobile"] : '';


        $product_item = isset($product_item) ? $product_item : 'inner';


        if (empty($category)) {
            $category = -1;
        }

        $offset         = $number*3;
        $number_load    = $columns*3;

        $woocommerce_loop['columns'] = $columns;

        $product_load_more['class'] = 'variable-load-more-'.$paged;

        if ((strpos($category, ',') !== false)) {
            $categories = explode(',', $category);
            $loop = urna_tbay_get_products($categories, $type, $paged, $number_load, '', '', $number, $offset);
        } else {
            if ($category == -1) {
                $loop = urna_tbay_get_products('', $type, $paged, $number_load, '', '', $number, $offset);
            } else {
                $loop = urna_tbay_get_products(array($category), '', $paged, $number_load, '', '', $number, $offset);
            }
        }

        $count = 0;


        if ($loop->have_posts()) :
        ob_start();

        while ($loop->have_posts()) : $loop->the_post(); ?>

                <?php

                    wc_get_template('content-products.php', array('product_item' => $product_item,'columns' => $columns,'screen_desktop' => $screen_desktop,'screen_desktopsmall' => $screen_desktopsmall,'screen_tablet' => $screen_tablet,'screen_mobile' => $screen_mobile)); ?>


                <?php $count++; ?>
            <?php endwhile; ?>
        <?php endif;

        wp_reset_postdata();

        $posts = ob_get_clean();

        if ($paged >= $loop->max_num_pages || $number_load > $loop->post_count) {
            $result['check'] = false;
        } else {
            $result['check'] = true;
        }

        $result['posts'] = $posts;
        print_r(json_encode($result));
        exit();
    }
}

if (! function_exists('urna_woocommerce_post_class')) {
    add_filter('post_class', 'urna_woocommerce_post_class', 21);
    function urna_woocommerce_post_class($classes)
    {
        if ('product' == get_post_type()) {
            $classes = array_diff($classes, array( 'first', 'last' ));
        }
        return $classes;
    }
}

if (! function_exists('urna_woocommerce_meta_query')) {
    function urna_woocommerce_meta_query($type)
    {
        $args = array();
        switch ($type) {
          
            case 'best_selling':
                $args['meta_key'] = 'total_sales';
                $args['order']    = 'DESC';
                $args['orderby']  = 'meta_value_num';
                break;

            case 'featured_product':
                $args['ignore_sticky_posts']    = 1;
                $args['meta_query']             = array();
                $args['meta_query'][]           = WC()->query->stock_status_meta_query();
                $args['meta_query'][]           = WC()->query->visibility_meta_query();
                $args['tax_query'][]              = array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN'
                    )
                );
                break;

            case 'top_rate':
                $args['meta_query']     = WC()->query->get_meta_query();
                $args['tax_query']      = WC()->query->get_tax_query();
                $args['meta_key']       = '_wc_average_rating';
                $args['orderby']        = 'meta_value_num';
                $args['order']          = 'DESC';
                break;

            case 'recent_product':
                $args['orderby']    = 'date';
                $args['order']      =  'DESC';
                $args['meta_query'] = WC()->query->get_meta_query();
                $args['tax_query']  = WC()->query->get_tax_query();
                break;

            case 'random_product':
                $args['orderby']        = 'rand';
                $args['meta_query']     = array();
                $args['meta_query'][]   = WC()->query->stock_status_meta_query();
                break;

            case 'on_sale':
                $args['meta_query']     = WC()->query->get_meta_query();
                $args['tax_query']      = WC()->query->get_tax_query();
                $args['post__in']       = array_merge(array( 0 ), wc_get_product_ids_on_sale());
                break;

        }

        if( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $args['meta_query'][] =  array(
                'relation' => 'AND',
                array(
                    'key' => '_stock_status',
                    'value' => 'instock',
                    'compare' => '=',
                )
            );
        }

        $args['tax_query'][] = array(
            'relation' => 'AND',
            array(
               'taxonomy' =>   'product_visibility',
                'field'    =>   'slug',
                'terms'    =>   array('exclude-from-search', 'exclude-from-catalog'),
                'operator' =>   'NOT IN',
            )
        );

        return $args;
    }
}

//Render form fillter product
if (! function_exists('urna_woocommerce_product_fillter')) {
    function urna_woocommerce_product_fillter($options, $name, $default, $class = 'level-0')
    {
        // Only show on product categories
        if (! woocommerce_products_will_display()) :
            return;
        endif; ?>
        <form method="get" class="woocommerce-fillter">
            <select name="<?php echo esc_attr($name); ?>" onchange="this.form.submit()" class="select">
                <?php $i = 0;
        foreach ($options as $key => $value) : ?>
                    <option class="<?php echo (!empty($class[$i])) ? trim($class[$i]) : ''; ?>" value="<?php echo esc_attr($key); ?>" <?php selected($key, urna_woocommerce_get_fillter($name, $default)); ?> ><?php echo trim($value); ?></option>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </select>
        <?php
            // Keep query string vars intact
            foreach ($_GET as $key => $val) :

                if ($name === $key || 'submit' === $key) :
                    continue;
        endif;
        if (is_array($val)) :
                    foreach ($val as $inner_val) :
                        ?><input type="hidden" name="<?php echo esc_attr($key); ?>[]" value="<?php echo esc_attr($inner_val); ?>" /><?php
                    endforeach; else :
                    ?><input type="hidden" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($val); ?>" /><?php
                endif;
        endforeach; ?>
        </form>
    <?php
    }
}

//get value fillter
if (! function_exists('urna_woocommerce_get_fillter')) {
    function urna_woocommerce_get_fillter($name, $default)
    {
        if (isset($_GET[$name])) :
            return $_GET[$name]; else :
            return $default;
        endif;
    }
}


//Add query product type
if (! function_exists('urna_woocommerce_product_type_query')) {
    function urna_woocommerce_product_type_query($q)
    {
        $name = 'product_type';
        $default = 'recent_products';

        $product_type = urna_woocommerce_get_fillter($name, $default);
        $args    = urna_woocommerce_meta_query($product_type);
        $queries = array('meta_key', 'orderby', 'order', 'post__in', 'tax_query', 'meta_query');
        if (function_exists('woocommerce_products_will_display') && $q->is_main_query()) :
            foreach ($queries as $query) {
                if (isset($args[$query])) {
                    $q->set($query, $args[$query]);
                }
            }
        endif;
    }
}

//Add form fillter by product type
if (! function_exists('urna_woocommerce_product_type_fillter')) {
    function urna_woocommerce_product_type_fillter()
    {
        $default = 'best_selling';
        $options = array(
            'best_selling'      => esc_html__('Best Selling', 'urna'),
            'featured_product'  => esc_html__('Featured Products', 'urna'),
            'recent_product'    => esc_html__('Recent Products', 'urna'),
            'on_sale'           => esc_html__('On Sale', 'urna'),
            'random_product'    => esc_html__('Random Products', 'urna')
        );
        $name = 'product_type';
        urna_woocommerce_product_fillter($options, $name, $default);
    }
}


//Add query product per page
if (! function_exists('urna_woocommerce_product_per_page_query')) {
    function urna_woocommerce_product_per_page_query($q)
    {
        $default            = urna_tbay_get_config('number_products_per_page');
        $product_per_page   = urna_woocommerce_get_fillter('product_per_page', $default);
        if (function_exists('woocommerce_products_will_display') && $q->is_main_query()) :
            $q->set('posts_per_page', $product_per_page);
        endif;
    }
    add_action('woocommerce_product_query', 'urna_woocommerce_product_per_page_query', 10, 2);
}

//Add form fillter by product per page
if (! function_exists('urna_woocommerce_product_per_page_fillter')) {
    function urna_woocommerce_product_per_page_fillter()
    {
        $columns = urna_tbay_get_config('product_columns', 4);
        $default = urna_tbay_get_config('number_products_per_page');
        $options= array();
        for ($i=1; $i<=5; $i++) {
            $options[$i*$columns] =  $i*$columns.' '.esc_html__(' products', 'urna');
        }
        $options['-1'] = esc_html__('All products', 'urna');
        $name = 'product_per_page';
        urna_woocommerce_product_fillter($options, $name, $default);
    }
}


//Add query product category
if (! function_exists('urna_woocommerce_product_category_query')) {
    function urna_woocommerce_product_category_query($q)
    {
        $default            = -1;
        $product_cat        = urna_woocommerce_get_fillter('product_category', $default);


        $tax_query = (array) $q->get('tax_query');

        $tax_query[] = array(
                'posts_per_page' => -1,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $product_cat
                    )
                ),
                'post_type' => 'product',
                'orderby' => 'title,'
        );


        if (function_exists('woocommerce_products_will_display') && $q->is_main_query() && $product_cat != -1) :
           $q->set('tax_query', $tax_query);
        endif;
    }
    add_action('woocommerce_product_query', 'urna_woocommerce_product_category_query', 30, 2);
}


//Add form fillter by product category
if (! function_exists('urna_woocommerce_product_category_fillter')) {
    function urna_woocommerce_product_category_fillter()
    {
        $taxonomy       = 'product_cat';
        $orderby        = 'name';
        $pad_counts     = 0;      // 1 for yes, 0 for no
        $hierarchical   = 1;      // 1 for yes, 0 for no
        $empty          = 0;
        $posts_per_page =  -1;

        $args = array(
            'taxonomy'       => $taxonomy,
            'orderby'        => $orderby,
            'posts_per_page' => $posts_per_page,
            'pad_counts'     => $pad_counts,
            'hierarchical'   => $hierarchical,
            'hide_empty'     => $empty
        );

        $all_categories = get_categories($args);

        $options = array();
        $class = array();
        $options['-1'] = esc_html__('All Categories', 'urna');
        $class[] = 'level-0';
        $default = esc_html__('All Categories', 'urna');
        foreach ($all_categories as $cat) {
            if ($cat->category_parent == 0) {
                $cat_name   =   $cat->name;
                $cat_id     =   $cat->term_id;
                $cat_slug   =   $cat->slug;
                $count      =   $cat->count;
                $level      =   0;

                $options[$cat_slug]      =  $cat_name.'('.$count.')';
                $class[]                 = 'level-'.$level;

                $taxonomy       =   'product_cat';
                $orderby        =   'name';
                $pad_counts     =   0;      // 1 for yes, 0 for no
                $hierarchical   =   1;      // 1 for yes, 0 for no
                $empty          =   0;
                $posts_per_page =  -1;


                $args2 = array(
                        'child_of'      => 0,
                        'parent'         => $cat_id,
                        'taxonomy'       => $taxonomy,
                        'orderby'        => $orderby,
                        'posts_per_page' => $posts_per_page,
                        'pad_counts'     => $pad_counts,
                        'hierarchical'   => $hierarchical,
                        'hide_empty'     => $empty
                );

                $sub_cats = get_categories($args2);


                if ($sub_cats) {
                    $level ++;

                    foreach ($sub_cats as $sub_category) {
                        $sub_cat_name               =   $sub_category->name;
                        $sub_cat_id                 =   $sub_category->term_id;
                        $sub_cat_slug               =   $sub_category->slug;
                        $sub_count                  =   $sub_category->count;
                        $class[]                    =  'level-'.$level;

                        $options[$sub_cat_slug]     =  $sub_cat_name.'('.$sub_count.')';


                        $taxonomy       =   'product_cat';
                        $orderby        =   'name';
                        $pad_counts     =   0;      // 1 for yes, 0 for no
                        $hierarchical   =   1;      // 1 for yes, 0 for no
                        $empty          =   0;
                        $posts_per_page =  -1;


                        $args2 = array(
                                'child_of'      => 0,
                                'parent'         => $sub_cat_id,
                                'taxonomy'       => $taxonomy,
                                'orderby'        => $orderby,
                                'posts_per_page' => $posts_per_page,
                                'pad_counts'     => $pad_counts,
                                'hierarchical'   => $hierarchical,
                                'hide_empty'     => $empty
                        );

                        $sub_cats = get_categories($args2);


                        if ($sub_cats) {
                            $level ++;

                            foreach ($sub_cats as $sub_category) {
                                $sub_cat_name               =   $sub_category->name;
                                $sub_cat_id                 =   $sub_category->term_id;
                                $sub_cat_slug               =   $sub_category->slug;
                                $sub_count                  =   $sub_category->count;
                                $class[]                    =  'level-'.$level;

                                $options[$sub_cat_slug]     =  $sub_cat_name.'('.$sub_count.')';
                            }
                        }
                    }
                }
            }
        }
                        
        $name = 'product_category';

        urna_woocommerce_product_fillter($options, $name, $default, $class);
    }
}




// Add hook to before shoop loop in layout filter bar
if (!function_exists('urna_tbay_layout_filter_bar')) {
    function urna_tbay_layout_filter_bar()
    {
        $sidebar_configs = urna_tbay_get_woocommerce_layout_configs();

        if (isset($sidebar_configs['filter_bar']) && $sidebar_configs['filter_bar']) {
            add_action('woocommerce_product_query', 'urna_woocommerce_product_type_query', 20, 2);
            add_action('woocommerce_before_shop_loop', 'urna_woocommerce_product_type_fillter', 25);
            add_action('woocommerce_before_shop_loop', 'urna_woocommerce_product_per_page_fillter', 30);
            add_action('woocommerce_before_shop_loop', 'urna_woocommerce_product_category_fillter', 35);
        }
    }
    add_action('init', 'urna_tbay_layout_filter_bar');
}


// Add hook to before shoop loop in layout filter bar
if (!function_exists('urna_tbay_filter_config')) {
    function urna_tbay_filter_config()
    {
        if (isset($_GET['product_type_fillter'])) {
            $product_type_fillter = $_GET['product_type_fillter'];
        } else {
            $product_type_fillter = urna_tbay_get_global_config('product_type_fillter');
        }

        if (isset($_GET['product_per_page_fillter'])) {
            $product_per_page_fillter = $_GET['product_per_page_fillter'];
        } else {
            $product_per_page_fillter = urna_tbay_get_global_config('product_per_page_fillter');
        }

        if (isset($_GET['product_category_fillter'])) {
            $product_category_fillter = $_GET['product_category_fillter'];
        } else {
            $product_category_fillter = urna_tbay_get_global_config('product_category_fillter');
        }

        if ($product_type_fillter) {
            add_action('woocommerce_product_query', 'urna_woocommerce_product_type_query', 20, 2);
            add_action('woocommerce_before_shop_loop', 'urna_woocommerce_product_type_fillter', 30);
        }

        if ($product_per_page_fillter) {
            add_action('woocommerce_before_shop_loop', 'urna_woocommerce_product_per_page_fillter', 30);
        }

        if ($product_category_fillter) {
            add_action('woocommerce_before_shop_loop', 'urna_woocommerce_product_category_fillter', 35);
        }
    }
    add_action('init', 'urna_tbay_filter_config');
}

//Add button load more in shop
if (!function_exists('urna_tbay_woocommerce_shop_load_more')) {
    function urna_tbay_woocommerce_shop_load_more()
    {
        global $wp_query;


        if ($wp_query->max_num_pages > 1) {
            ?>
           <div class="tbay-pagination-load-more">
                <a href="javascript:void(0);" data-loading-text="<?php esc_attr_e('Loading...', 'urna'); ?>" data-loadmore="true">
                    <i class="linear-icon-plus"></i>
                    <span class="text"><?php esc_html_e('Load More', 'urna'); ?></span>
                </a>
           </div>

       <?php
        }
    }
}


/* ---------------------------------------------------------------------------
 * WooCommerce - Function Load more ajax
 * --------------------------------------------------------------------------- */
if (!function_exists('urna_pagination_fnc_more_post_ajax')) {
    add_action('wp_ajax_nopriv_urna_pagination_more_post_ajax', 'urna_pagination_fnc_more_post_ajax');
    add_action('wp_ajax_urna_pagination_more_post_ajax', 'urna_pagination_fnc_more_post_ajax');

    function urna_pagination_fnc_more_post_ajax()
    {

        // prepare our arguments for the query
        $args = json_decode(stripslashes($_POST['query']), true);
        $args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
        $args['post_status'] = 'publish';

        $shown_des = true;
     
        // it is always better to use WP_Query but not here
        query_posts($args);
     
        if (have_posts()) :
     
            while (have_posts()): the_post();
     
        wc_get_template('content-product.php', array('shown_des' => $shown_des));

     
        endwhile;
     
        endif;
        die; // here we exit the script and even no wp_reset_postdata() required!
    }
}

/* ---------------------------------------------------------------------------
 * WooCommerce - Function More List Product Ajax
 * --------------------------------------------------------------------------- */
if (!function_exists('urna_list_post_ajax_fnc_more_post_ajax')) {
    add_action('wp_ajax_nopriv_urna_list_post_ajax', 'urna_list_post_ajax_fnc_more_post_ajax');
    add_action('wp_ajax_urna_list_post_ajax', 'urna_list_post_ajax_fnc_more_post_ajax');

    function urna_list_post_ajax_fnc_more_post_ajax()
    {
        
        // prepare our arguments for the query
        $args = json_decode(stripslashes($_POST['query']), true);
     
        $args['post_status'] = 'publish';

        // it is always better to use WP_Query but not here
        query_posts($args);



        $list = 'list';
     
        if (have_posts()) :
     
            while (have_posts()): the_post();
     
        wc_get_template('content-product.php', array('list' => $list));

     
        endwhile;
     
        endif;
        die; // here we exit the script and even no wp_reset_postdata() required!
    }
}

/* ---------------------------------------------------------------------------
 * WooCommerce - Function More Grid Product Ajax
 * --------------------------------------------------------------------------- */
if (!function_exists('urna_grid_post_ajax_fnc_more_post_ajax')) {
    add_action('wp_ajax_nopriv_urna_grid_post_ajax', 'urna_grid_post_ajax_fnc_more_post_ajax');
    add_action('wp_ajax_urna_grid_post_ajax', 'urna_grid_post_ajax_fnc_more_post_ajax');

    function urna_grid_post_ajax_fnc_more_post_ajax()
    {

        // prepare our arguments for the query
        $args = json_decode(stripslashes($_POST['query']), true);
     
        $args['post_status'] = 'publish';

        // it is always better to use WP_Query but not here
        query_posts($args);

        $list = 'grid';
      
        if (have_posts()) :
     
            while (have_posts()): the_post();
     
        wc_get_template('content-product.php', array('list' => $list));

     
        endwhile;
     
        endif;
        die; // here we exit the script and even no wp_reset_postdata() required!
    }
}


/**
 *
 * Code used to change the price order in WooCommerce
 *
 * */
if (!function_exists('urna_woocommerce_price_html')) {
    function urna_woocommerce_price_html($price, $product)
    {
        return preg_replace('@(<del.*>.*?</del>).*?(<ins>.*?</ins>)@misx', '$2 $1', $price);
    }

    add_filter('woocommerce_format_sale_price', 'urna_woocommerce_price_html', 100, 2);
}
/*Hook page checkout */

// Mobile add to cart message html
if (! function_exists('urna_tbay_add_to_cart_message_html_mobile')) {
    function urna_tbay_add_to_cart_message_html_mobile($message)
    {
        if (isset($_REQUEST['urna_buy_now']) && $_REQUEST['urna_buy_now'] == true) {
            return __return_empty_string();
        } else {
            return $message;
        }
    }
    add_filter('wc_add_to_cart_message_html', 'urna_tbay_add_to_cart_message_html_mobile');
}

// class product number mobile
if (! function_exists('urna_tbay_body_classes_product_number_mobile')) {
    function urna_tbay_body_classes_product_number_mobile($classes)
    {
        $columns = urna_tbay_get_config('mobile_product_number', 'two');

        if (isset($columns)) {
            $class = 'tbay-body-mobile-product-'.$columns;
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter('body_class', 'urna_tbay_body_classes_product_number_mobile');
}

// Quantity mode
if (!function_exists('urna_tbay_woocommerce_quantity_mode_active')) {
    function urna_tbay_woocommerce_quantity_mode_active($active)
    {
        $type = apply_filters('urna_woo_config_product_layout', 10, 2);
 
        if ($type !== 'v15' && !wp_is_mobile()) {
            return false;
        }

        $active = urna_tbay_get_config('enable_woocommerce_quantity_mode', false);

        $active = (isset($_GET['quantity_mode'])) ? $_GET['quantity_mode'] : $active;

        return $active;
    }
    add_filter('urna_quantity_mode', 'urna_tbay_woocommerce_quantity_mode_active', 10, 2);
}

if (! function_exists('urna_tbay_quantity_field_archive')) {
    add_action('woocommerce_after_shop_loop_item', 'urna_tbay_quantity_field_archive', 5);
    function urna_tbay_quantity_field_archive()
    {
        $active = apply_filters('urna_quantity_mode', 10, 2);
        if (!$active || urna_is_woo_variation_swatches_pro()) {
            return;
        }

        global $product;
        if ($product && $product->is_type('simple') && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually()) {
            woocommerce_quantity_input(array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ));
        }
    }
}

// class catalog mode
if (! function_exists('urna_tbay_body_classes_woocommerce_catalog_mod')) {
    function urna_tbay_body_classes_woocommerce_catalog_mod($classes)
    {
        $class = '';
        $active = urna_catalog_mode_active();
        if (isset($active) && $active) {
            $class = 'tbay-body-woocommerce-catalog-mod';
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter('body_class', 'urna_tbay_body_classes_woocommerce_catalog_mod');
}

if (!function_exists('urna_catalog_mode_single_product')) {
    function urna_catalog_mode_single_product()
    {
        $active = urna_catalog_mode_active();
        if (isset($active) && $active) {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
        }
    }
    add_action('woocommerce_before_single_product_summary', 'urna_catalog_mode_single_product', 10);
}

if (!function_exists('urna_catalog_mode_shop_loop_item')) {
    function urna_catalog_mode_shop_loop_item()
    {
        $active = urna_catalog_mode_active();
        if (isset($active) && $active) {
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
        }
    }
    add_action('woocommerce_before_shop_loop_item_title', 'urna_catalog_mode_shop_loop_item', 10);
}

if (!function_exists('urna_woocommerce_catalog_mode')) {
    function urna_woocommerce_catalog_mode()
    {
        $active = urna_catalog_mode_active();
        if (isset($active) && $active) {
            if (defined('YITH_WCQV') && YITH_WCQV) {
                remove_action('yith_wcqv_product_summary', 'woocommerce_template_single_add_to_cart', 25);
            }
        }
    }
    add_action('yith_wcqv_after_product_image_carousel', 'urna_woocommerce_catalog_mode', 10);
}

// cart modal
if (!function_exists('urna_woocommerce_catalog_mode_redirect_page')) {
    function urna_woocommerce_catalog_mode_redirect_page()
    {
        $active = urna_catalog_mode_active();
        if (isset($active) && $active) {
            $cart     = is_page(wc_get_page_id('cart'));
            $checkout = is_page(wc_get_page_id('checkout'));

            wp_reset_postdata();

            if ($cart || $checkout) {
                wp_redirect(home_url());
                exit;
            }
        }
    }

    add_action('wp', 'urna_woocommerce_catalog_mode_redirect_page');
}
/*End catalog mode*/


/*Hide Variation Selector on HomePage and Shop page*/
if (!function_exists('urna_tbay_woocommerce_enable_variation_selector')) {
    function urna_tbay_woocommerce_enable_variation_selector($active)
    {
        $active = urna_tbay_get_config('enable_variation_swatch', false);

        $active = (isset($_GET['variation-selector'])) ? $_GET['variation-selector'] : $active;

        if (class_exists('Woo_Variation_Swatches_Pro') && function_exists('wvs_pro_archive_variation_template')) {
            $active = false;
        }

        return $active;
    }
}
add_filter('urna_enable_variation_selector', 'urna_tbay_woocommerce_enable_variation_selector');

if (! function_exists('urna_tbay_body_classes_woocommerce_enable_variation_selector')) {
    function urna_tbay_body_classes_woocommerce_enable_variation_selector($classes)
    {
        $class = '';
        $active = apply_filters('urna_enable_variation_selector', 10, 2);
        if (!(isset($active) && $active)) {
            $class = 'tbay-hide-variation-selector';
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter('body_class', 'urna_tbay_body_classes_woocommerce_enable_variation_selector');
}

/*Show Add to Cart on mobile*/
if (!function_exists('urna_tbay_woocommerce_show_cart_mobile')) {
    function urna_tbay_woocommerce_show_cart_mobile($active)
    {
        $active = urna_tbay_get_config('enable_add_cart_mobile', false);

        $active = (isset($_GET['add_cart_mobile'])) ? $_GET['add_cart_mobile'] : $active;

        return $active;
    }
}
add_filter('urna_show_cart_mobile', 'urna_tbay_woocommerce_show_cart_mobile');

if (! function_exists('urna_tbay_body_classes_woocommerce_show_cart_mobile')) {
    function urna_tbay_body_classes_woocommerce_show_cart_mobile($classes)
    {
        $class = '';
        $active = apply_filters('urna_show_cart_mobile', 10, 2);
        if (isset($active) && $active) {
            $class = 'tbay-show-cart-mobile';
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter('body_class', 'urna_tbay_body_classes_woocommerce_show_cart_mobile');
}

/*Show Quantity on mobile*/
if (!function_exists('urna_tbay_woocommerce_show_quantity_mobile')) {
    function urna_tbay_woocommerce_show_quantity_mobile($active)
    {
        $active = urna_tbay_get_config('enable_quantity_mobile', false);

        $active = (isset($_GET['quantity_mobile'])) ? $_GET['quantity_mobile'] : $active;

        return $active;
    }
}
add_filter('urna_show_quantity_mobile', 'urna_tbay_woocommerce_show_quantity_mobile');

if (! function_exists('urna_tbay_body_classes_woocommerce_show_quantity_mobile')) {
    function urna_tbay_body_classes_woocommerce_show_quantity_mobile($classes)
    {
        $class = '';
        $active = apply_filters('urna_show_quantity_mobile', 10, 2);
        if (isset($active) && $active) {
            $class = 'tbay-show-quantity-mobile';
        }

        $classes[] = trim($class);

        return $classes;
    }
    add_filter('body_class', 'urna_tbay_body_classes_woocommerce_show_quantity_mobile');
}

/**
 * Remove password strength check.
 */
if (! function_exists('urna_tbay_remove_password_strength')) {
    function urna_tbay_remove_password_strength()
    {
        $active = urna_tbay_get_config('show_woocommerce_password_strength', true);

        if (isset($active) && !$active) {
            wp_dequeue_script('wc-password-strength-meter');
        }
    }
    add_action('wp_print_scripts', 'urna_tbay_remove_password_strength', 10);
}

if (defined('YITH_WCWL') && ! function_exists('urna_yith_wcwl_ajax_update_count')) {
    function urna_yith_wcwl_ajax_update_count()
    {
        $wishlist_count = YITH_WCWL()->count_products();

        wp_send_json(array(
    'count' => $wishlist_count
    ));
    }
    add_action('wp_ajax_yith_wcwl_update_wishlist_count', 'urna_yith_wcwl_ajax_update_count');
    add_action('wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'urna_yith_wcwl_ajax_update_count');
}

//Count all product 
if ( ! function_exists( 'urna_total_product_count' ) ) {
    function urna_total_product_count() {
        $args = array( 'post_type' => 'product', 'posts_per_page' => -1 );

        $products = new WP_Query( $args );

        return $products->found_posts;
    }
}

//Count product of category
if (! function_exists('urna_get_product_count_of_category')) {
    function urna_get_product_count_of_category($cat_id)
    {
        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => -1,
            'tax_query'             => array(
                array(
                    'taxonomy'      => 'product_cat',
                    'field' => 'term_id', //This is optional, as it defaults to 'term_id'
                    'terms'         => $cat_id,
                    'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                ),
                array(
                    'taxonomy'      => 'product_visibility',
                    'field'         => 'slug',
                    'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
                    'operator'      => 'NOT IN'
                )
            )
        );
        $loop = new WP_Query($args);

        return $loop->found_posts;
    }
}

if (! function_exists('urna_get_product_count_of_tags')) {
    function urna_get_product_count_of_tags($tag_id)
    {
        $args = array(
            'post_type'             => 'product',
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => -1,
            'tax_query'             => array(
                array(
                    'taxonomy'      => 'product_tag',
                    'field'         => 'term_id', //This is optional, as it defaults to 'term_id'
                    'terms'         => $tag_id,
                    'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                ),
                array(
                    'taxonomy'      => 'product_visibility',
                    'field'         => 'slug',
                    'terms'         => 'exclude-from-catalog', // Possibly 'exclude-from-search' too
                    'operator'      => 'NOT IN'
                )
            )
        );
        $loop = new WP_Query($args);

        return $loop->found_posts;
    }
}

if (!function_exists('urna_tbay_woocommerce_subcat_archives')) {
    function urna_tbay_woocommerce_subcat_archives($active)
    {
        $active = (isset($_GET['subcat'])) ? (boolean)$_GET['subcat'] : (boolean)$active;

        return $active;
    }
}
add_filter('urna_woo_subcat', 'urna_tbay_woocommerce_subcat_archives');

/*Remove filter*/
if (! function_exists('urna_woocommerce_sub_categories')) {
    /**
     * Output the start of a product loop. By default this is a UL.
     *
     * @param bool $echo Should echo?.
     * @return string
     */
    function urna_woocommerce_sub_categories($echo = true)
    {
        ob_start();

        wc_set_loop_prop('loop', 0);
        
        $loop_start = apply_filters('urna_woocommerce_sub_categories', ob_get_clean());

        if ($echo) {
            echo trim($loop_start); // WPCS: XSS ok.
        } else {
            return $loop_start;
        }
    }

    function woocommerce_maybe_show_product_subcategories($loop_html = '')
    {
        return $loop_html;
    }
}

add_filter('woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories');

if (! function_exists('urna_woocommerce_maybe_show_product_subcategories')) {
    function urna_woocommerce_maybe_show_product_subcategories($loop_html = '')
    {
        if (wc_get_loop_prop('is_shortcode') && ! WC_Template_Loader::in_content_filter()) {
            return $loop_html;
        }

        $display_type = woocommerce_get_loop_display_mode();

        // If displaying categories, append to the loop.
        if ('subcategories' === $display_type || 'both' === $display_type) {
            ob_start();
            woocommerce_output_product_categories(array(
                'parent_id' => is_product_category() ? get_queried_object_id() : 0,
            ));
            $loop_html .= ob_get_clean();

            if ('subcategories' === $display_type) {
                wc_set_loop_prop('total', 0);

                // This removes pagination and products from display for themes not using wc_get_loop_prop in their product loops.  @todo Remove in future major version.
                global $wp_query;

                if ($wp_query->is_main_query()) {
                    $wp_query->post_count    = 0;
                    $wp_query->max_num_pages = 0;
                }
            }
        }

        return $loop_html;
    }
}
add_filter('urna_woocommerce_sub_categories', 'urna_woocommerce_maybe_show_product_subcategories');

if (! function_exists('urna_is_product_variable_sale')) {
    function urna_is_product_variable_sale()
    {
        global $product;

        $class =  '';
        if ($product->is_type('variable') && $product->is_on_sale()) {
            $class = 'tbay-variable-sale';
        }
        
        return $class;
    }
}

// Sidebars
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10); // Remove Default Sidebars


if (! function_exists('urna_woo_content_class')) {
    function urna_woo_content_class($class = '')
    {
        $sidebar_configs = urna_tbay_get_woocommerce_layout_configs();

        if (!(isset($sidebar_configs['right']) && is_active_sidebar($sidebar_configs['right']['sidebar'])) && !(isset($sidebar_configs['left']) && is_active_sidebar($sidebar_configs['left']['sidebar']))) {
            $class .= ' col-xs-12';
        }
        
        return $class;
    }
}

if (! function_exists('urna_wc_wrapper_class')) {
    function urna_wc_wrapper_class($class = '')
    {
        $content_class = urna_woo_content_class($class);
        
        return apply_filters('urna_wc_wrapper_class', $content_class);
    }
}

if (!function_exists('urna_tbay_woocommerce_sidebar_top_archive')) {
    function urna_tbay_woocommerce_sidebar_top_archive($active)
    {
        $active = urna_tbay_get_config('show_product_top_archive', false);

        $active = (isset($_GET['product_top_archive'])) ? (boolean)$_GET['product_top_archive'] : (boolean)$active;

        return $active;
    }
}
add_filter('urna_sidebar_top_archive', 'urna_tbay_woocommerce_sidebar_top_archive');

if (!function_exists('urna_tbay_woocommerce_description_image_product_archives')) {
    function urna_tbay_woocommerce_description_image_product_archives($active)
    {
        $active = urna_tbay_get_config('pro_des_image_product_archives', false);

        $active = (isset($_GET['pro_des_image'])) ? (boolean)$_GET['pro_des_image'] : (boolean)$active;

        return $active;
    }
}
add_filter('urna_woo_pro_des_image', 'urna_tbay_woocommerce_description_image_product_archives');

if (!function_exists('urna_tbay_woocommerce_title_product_archives')) {
    function urna_tbay_woocommerce_title_product_archives($active)
    {
        $active = urna_tbay_get_config('title_product_archives', false);

        $active = (isset($_GET['title_product_archives'])) ? (boolean)$_GET['title_product_archives'] : (boolean)$active;

        return $active;
    }
}
add_filter('urna_woo_title_product_archives', 'urna_tbay_woocommerce_title_product_archives');


if (!function_exists('urna_tbay_woocommerce_ajax_filter_product_archives')) {
    function urna_tbay_woocommerce_ajax_filter_product_archives($active)
    {
        $active = urna_tbay_get_config('ajax_filter', false);

        $active = (isset($_GET['ajax_filter'])) ? (boolean)$_GET['ajax_filter'] : (boolean)$active;

        return $active;
    }
}
add_filter('urna_woo_ajax_filter', 'urna_tbay_woocommerce_ajax_filter_product_archives');


if (!function_exists('urna_tbay_woocommerce_config_display_modes')) {
    function urna_tbay_woocommerce_config_display_modes($active)
    {
        $active = urna_tbay_get_config('enable_display_mode', true);

        $active = (isset($_GET['enable_display_mode'])) ? (boolean)$_GET['enable_display_mode'] : (boolean)$active;

        return $active;
    }
}
add_filter('urna_woo_config_display_mode', 'urna_tbay_woocommerce_config_display_modes');


if (!function_exists('urna_tbay_woocommerce_full_width_product_archives')) {
    function urna_tbay_woocommerce_full_width_product_archives($active)
    {
        $active = urna_tbay_get_config('product_archive_fullwidth', false);

        $active = (isset($_GET['archives_full'])) ? (boolean)$_GET['archives_full'] : (boolean)$active;

        return $active;
    }
}
add_filter('urna_woo_width_product_archives', 'urna_tbay_woocommerce_full_width_product_archives');

if (!function_exists('urna_tbay_woocommerce_full_width_product_single')) {
    function urna_tbay_woocommerce_full_width_product_single($active)
    {
        $active = urna_tbay_get_config('product_single_fullwidth', false);

        $active = (isset($_GET['single_full'])) ? (boolean)$_GET['single_full'] : (boolean)$active;
        
        $product_single_layout  =   urna_get_single_select_layout();

        if ($product_single_layout == 'full-width-carousel' || $product_single_layout == 'full-width-full') {
            $active = true;
        }



        return $active;
    }
}
add_filter('urna_woo_width_product_single', 'urna_tbay_woocommerce_full_width_product_single');

if (!function_exists('urna_find_matching_product_variation')) {
    function urna_find_matching_product_variation($product, $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (strpos($key, 'attribute_') === 0) {
                continue;
            }

            unset($attributes[ $key ]);
            $attributes[ sprintf('attribute_%s', $key) ] = $value;
        }

        if (class_exists('WC_Data_Store')) {
            $data_store = WC_Data_Store::load('product');
            return $data_store->find_matching_product_variation($product, $attributes);
        } else {
            return $product->get_matching_variation($attributes);
        }
    }
}

if (! function_exists('urna_get_default_attributes')) {
    function urna_get_default_attributes($product)
    {
        if (method_exists($product, 'get_default_attributes')) {
            return $product->get_default_attributes();
        } else {
            return $product->get_variation_default_attributes();
        }
    }
}

if (! function_exists('urna_woo_show_product_loop_sale_flash')) {
    /*Change sales woo*/
    add_filter('woocommerce_sale_flash', 'urna_woo_show_product_loop_sale_flash', 10, 3);
    function urna_woo_show_product_loop_sale_flash($original, $post, $product)
    {
        $saleTag = $original;

        $format                 =  urna_tbay_get_config('sale_tags', 'custom');
        $enable_label_featured  =  urna_tbay_get_config('enable_label_featured', true);

        if ($format == 'custom') {
            $format = urna_tbay_get_config('sale_tag_custom', '-{percent-diff}%');
        }

        $priceDiff = 0;
        $percentDiff = 0;
        $regularPrice = '';
        $salePrice = $percentage = $return_content = '';

        $decimals   =  wc_get_price_decimals();
        $symbol     =  get_woocommerce_currency_symbol();

        $_product_sale   = $product->is_on_sale();
        $featured        = $product->is_featured();

        $type = apply_filters('urna_woo_config_product_layout', 10, 2);

        if ( $featured && $enable_label_featured && $type !== 'v9' && $type !== 'v11' ) {
            $return_content  = '<span class="featured">'. urna_tbay_get_config('custom_label_featured', esc_html__('Hot', 'urna')) .'</span>';
        }


        if (!empty($product) && $product->is_type('variable')) {
            $default_attributes = urna_get_default_attributes($product);
            $variation_id = urna_find_matching_product_variation($product, $default_attributes);

            if (empty($variation_id)) {
                return;
            }

            $variation      = wc_get_product($variation_id);

            $_product_sale  = $variation->is_on_sale();

            if ($_product_sale) {
                $regularPrice   = (float) get_post_meta($variation_id, '_regular_price', true);
                $salePrice      = (float) get_post_meta($variation_id, '_price', true);
            }
        } else {
            $salePrice = (float) get_post_meta($product->get_id(), '_price', true);
            $regularPrice = (float) get_post_meta($product->get_id(), '_regular_price', true);
        }


        if (!empty($regularPrice) && !empty($salePrice) && $regularPrice > $salePrice) {
            $priceDiff = $regularPrice - $salePrice;
            $percentDiff = round($priceDiff / $regularPrice * 100);
            
            $parsed = str_replace('{price-diff}', number_format((float)$priceDiff, $decimals, '.', ''), $format);
            $parsed = str_replace('{symbol}', $symbol, $parsed);
            $parsed = str_replace('{percent-diff}', $percentDiff, $parsed);
            $percentage = '<span class="saled">'. $parsed .'</span>';
        }

        if (!empty($_product_sale)) {
            $percentage .= $return_content;
        } else {
            $percentage = '<span class="saled">'. esc_html__('Sale', 'urna') . '</span>';
            $percentage .= $return_content;
        }

        echo '<span class="onsale">'. $percentage. '</span>';
    }
}

if (! function_exists('urna_woo_only_feature_product')) {
    /*Change sales woo*/
    add_action('woocommerce_before_shop_loop_item_title', 'urna_woo_only_feature_product', 10);
    function urna_woo_only_feature_product()
    { 
        global $product;

        $_product_sale          = $product->is_on_sale();
        $featured               = $product->is_featured();

        $type = apply_filters('urna_woo_config_product_layout', 10, 2);
        
        $return_content = '';
        if ($featured && (!$_product_sale || $type === 'v9' || $type === 'v11' )) {
            $enable_label_featured  =  urna_tbay_get_config('enable_label_featured', true);

            if ($featured && $enable_label_featured) {
                $return_content  .= '<span class="onsale only-featured"><span class="featured">'. urna_tbay_get_config('custom_label_featured', esc_html__('Hot', 'urna')) .'</span></span>';
            }
        } 

        echo trim($return_content);
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Compare button
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_the_yith_compare')) {
    function urna_the_yith_compare($product_id)
    {
        if (class_exists('YITH_Woocompare')) { ?>
            <?php
                $action_add = 'yith-woocompare-add-product';
                $url_args = array(
                    'action' => $action_add,
                    'id' => $product_id
                );
            ?>
            <div class="yith-compare">
                <a href="<?php echo wp_nonce_url(add_query_arg($url_args), $action_add); ?>" title="<?php esc_attr_e('Compare', 'urna'); ?>" class="compare" data-product_id="<?php echo esc_attr($product_id); ?>">
                    <span><?php esc_html_e('Compare', 'urna'); ?></span>
                </a>
            </div>
        <?php }
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * WishList button
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_the_yith_wishlist')) {
    function urna_the_yith_wishlist()
    {
        $enabled_on_loop = 'yes' == get_option('yith_wcwl_show_on_loop', 'no');

        if (!class_exists('YITH_WCWL_Shortcode') || $enabled_on_loop) {
            return;
        }

        $active         = urna_tbay_get_config('enable_wishlist_mobile', false);

        $class_mobile   = ($active) ? 'shown-mobile' : '';

        echo '<div class="button-wishlist '. esc_attr($class_mobile) .'" title="'. esc_attr__('Wishlist', 'urna') . '">'.YITH_WCWL_Shortcode::add_to_wishlist(array()).'</div>';
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Flash Sale
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_tbay_class_flash_sale')) {
    function urna_tbay_class_flash_sale($flash_sales)
    {
        global $product;

        if (isset($flash_sales) && $flash_sales) {
            $class_sale    = (!$product->is_on_sale()) ? 'tbay-not-flash-sale' : '';
            return $class_sale;
        }
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Item Deal ended Flash Sale
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_tbay_item_deal_ended_flash_sale')) {
    function urna_tbay_item_deal_ended_flash_sale($flash_sales, $end_date)
    {
        global $product;
 
        $today      = strtotime("today");

        if ($today > $end_date) {
            return;
        }

        $output = '';
        if (isset($flash_sales) && $flash_sales && !$product->is_on_sale()) {
            $output .= '<div class="item-deal-ended">';
            $output .= '<span>'. esc_html__('Deal ended', 'urna') .'</span>';
            $output .= '</div>';
        }
        echo trim($output);
    }
}


/**
 * ------------------------------------------------------------------------------------------------
 * The Count Down Flash Sale
 * ------------------------------------------------------------------------------------------------
 */

if (!function_exists('urna_tbay_countdown_flash_sale')) {
    function urna_tbay_countdown_flash_sale($time_sale = '', $date_title = '', $date_title_ended = '')
    {
        wp_enqueue_script('jquery-countdowntimer');
        $_id        = urna_tbay_random_key();

        $today      = strtotime("today");

        $day        = apply_filters('urna_tbay_countdown_flash_sale_day', esc_html__('d', 'urna'));
        $hours      = apply_filters('urna_tbay_countdown_flash_sale_hour', esc_html__('h', 'urna'));
        $mins       = apply_filters('urna_tbay_countdown_flash_sale_mins', esc_html__('m', 'urna'));
        $secs       = apply_filters('urna_tbay_countdown_flash_sale_secs', esc_html__('s', 'urna')); ?>
        <?php if (!empty($time_sale)) : ?>
            <div class="flash-sales-date">
            <?php if (($today <= $time_sale)): ?>
                    <?php if (isset($date_title) && !empty($date_title)) :  ?>
                        <div class="date-title"><?php echo trim($date_title); ?></div>
                    <?php endif; ?>
                    <div class="time">
                        <div class="tbay-countdown" id="tbay-flash-sale-<?php echo esc_attr($_id); ?>" data-time="timmer"
                             data-date="<?php echo gmdate('m', $time_sale).'-'.gmdate('d', $time_sale).'-'.gmdate('Y', $time_sale).'-'. gmdate('H', $time_sale) . '-' . gmdate('i', $time_sale) . '-' .  gmdate('s', $time_sale) ; ?>" data-days="<?php echo esc_attr($day); ?>" data-hours="<?php echo esc_attr($hours); ?>" data-mins="<?php echo esc_attr($mins); ?>" data-secs="<?php echo esc_attr($secs); ?>">
                        </div>
                    </div> 
            <?php else: ?>
                <?php if (isset($date_title_ended) && !empty($date_title_ended)) :  ?>
                    <div class="date-title"><?php echo trim($date_title_ended); ?></div>
                <?php endif; ?>
            <?php endif; ?> 
            </div> 
        <?php endif; ?> 
        <?php
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Count Down Flash Sale
 * ------------------------------------------------------------------------------------------------
 */

if (!function_exists('urna_tbay_stock_flash_sale')) {
    function urna_tbay_stock_flash_sale($flash_sales = '')
    {
        global $product;

        if ($flash_sales && $product->get_manage_stock()) : ?>
            <div class="stock-flash-sale stock">
                <?php
                $total_sales        = $product->get_total_sales();
        $stock_quantity     = $product->get_stock_quantity();
                
        $total_quantity   = (int)$total_sales + (int)$stock_quantity;

        $divi_total_quantity = ($total_quantity !== 0) ? $total_quantity : 1;

        $sold             = (int)$total_sales / (int)$divi_total_quantity;
        $percentsold      = $sold*100; ?>
                <div class="progress">
                    <div class="progress-bar active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($percentsold); ?>%">
                    </div>
                </div>
                <span class="tb-sold"><?php echo esc_html__('Sold', 'urna'); ?> : <span class="sold"><?php echo esc_html($total_sales) ?></span><span class="total">/<?php echo esc_html($total_quantity) ?></span></span>
            </div>
        <?php endif;
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Count Down Flash Sale V2
 * ------------------------------------------------------------------------------------------------
 */

if (!function_exists('urna_tbay_stock_flash_sale_v2')) {
    function urna_tbay_stock_flash_sale_v2($flash_sales = '')
    {
        global $product;
        remove_action('woocommerce_before_shop_loop_item_title', 'urna_woo_show_product_loop_outstock_flash', 20);

        if ($flash_sales && $product->get_manage_stock()) : ?>
            <div class="stock-flash-sale-v2">
              <?php
                $stock_quantity     = $product->get_stock_quantity();
        $class_only_left    = ($stock_quantity > 0) ? '' : 'out-of-stock'; ?>
                <span class="only-left <?php echo esc_attr($class_only_left); ?>">
                    <?php if ($stock_quantity > 0) {
            printf(esc_html__('only %1$s left', 'urna'), $stock_quantity);
        } else {
            esc_html_e('out of stock', 'urna');
        } ?>
                </span>

            </div>
        <?php endif;
    }
}


/**
 * ------------------------------------------------------------------------------------------------
 * QuickView button
 * ------------------------------------------------------------------------------------------------
 */
if (! function_exists('urna_the_quick_view')) {
    function urna_the_quick_view($product_id)
    {
        if (urna_tbay_get_config('enable_quickview', true)) {
            ?>
            <div class="tbay-quick-view">
                <a href="#" class="qview-button" title ="<?php esc_attr_e('Quick View', 'urna') ?>" data-effect="mfp-move-from-top" data-product_id="<?php echo esc_attr($product_id); ?>" data-toggle="modal" data-target="#tbay-quickview-modal">
                    <i class="linear-icon-eye"></i>
                    <span><?php esc_html_e('Quick View', 'urna') ?></span>
                </a>
            </div>
            <?php
        }
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Product name
 * ------------------------------------------------------------------------------------------------
 */

if (! function_exists('urna_the_product_name')) {
    function urna_the_product_name()
    {
        $active         = urna_tbay_get_config('enable_one_name_mobile', false);

        $class_mobile   = ($active) ? 'full_name' : ''; ?>
        
        <h3 class="name <?php echo esc_attr($class_mobile); ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php
    }
}

if (! function_exists('urna_quick_view_scripts')) {
    add_action('wp_enqueue_scripts', 'urna_quick_view_scripts', 101);
    function urna_quick_view_scripts()
    {
        if (!urna_tbay_get_config('enable_quickview', true)) {
            return;
        }
          
        wp_enqueue_script('slick');
        wp_enqueue_script('urna-slick');

        wp_enqueue_script('wc-add-to-cart-variation');
        wp_enqueue_script('wc-single-product');
    }
}

if (!function_exists('urna_woocommerce_quickview')) {
    function urna_woocommerce_quickview()
    {
        if (!empty($_GET['product_id'])) {
            $args = array(
                'post_type' => 'product',
                'post__in' => array($_GET['product_id'])
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                while ($query->have_posts()): $query->the_post();
                wc_get_template_part('content', 'product-quickview');
                endwhile;
            }
            wp_reset_postdata();
        }
        die;
    }
}

if (urna_tbay_get_config('enable_quickview', true)) {
    add_action('wp_ajax_urna_quickview_product', 'urna_woocommerce_quickview');
    add_action('wp_ajax_nopriv_urna_quickview_product', 'urna_woocommerce_quickview');
}

if (! function_exists('urna_furniture_add_product_description')) {
    function urna_furniture_add_product_description()
    {
        wc_get_template('single-product/short-description.php');
    }
}

if (! function_exists('urna_woocommerce_product_buttons')) {
    // Change Product Buttons
    function urna_woocommerce_product_buttons()
    {
        global $product;

        if (wp_is_mobile()) {
            return;
        } ?>
        <?php if (class_exists('YITH_WCWL') || class_exists('YITH_Woocompare')) { ?>
            <div class="group-button">
            <?php if (class_exists('YITH_WCWL')) { ?> 
                <div class="tbay-wishlist">
                   <?php urna_the_yith_wishlist(); ?>
                </div>  
            <?php } ?>
            <?php if (class_exists('YITH_Woocompare')) { ?>
                <div class="tbay-compare">
                    <?php urna_the_yith_compare($product->get_id()); ?>
                </div>
            <?php } ?>
            </div>
        <?php } ?>
        <?php
    }
    add_action('woocommerce_after_add_to_cart_button', 'urna_woocommerce_product_buttons', 20);
}

if (!function_exists('urna_woocommerce_buy_now')) {
    function urna_woocommerce_buy_now()
    {
        global $product;
        if (! intval(urna_tbay_get_config('enable_buy_now', false))) {
            return;
        }

        if ($product->get_type() == 'external') {
            return;
        }

        $class = 'tbay-buy-now button';

        if (!empty($product) && $product->is_type('variable')) {
            $default_attributes = urna_get_default_attributes($product);
            $variation_id = urna_find_matching_product_variation($product, $default_attributes);
            
            if (empty($variation_id)) {
                $class .= ' disabled';
            }
        }
 
        echo sprintf('<button class="'. $class .'">%s</button>', esc_html__('Buy Now', 'urna'));
        echo '<input type="hidden" value="0" name="urna_buy_now" />';
    }
    add_action('woocommerce_after_add_to_cart_button', 'urna_woocommerce_buy_now', 10);
}

/*Add To Cart Redirect*/
if (!function_exists('urna_woocommerce_buy_now_redirect')) {
    function urna_woocommerce_buy_now_redirect($url)
    {
        if (! isset($_REQUEST['urna_buy_now']) || $_REQUEST['urna_buy_now'] == false) {
            return $url;
        }

        if (empty($_REQUEST['quantity'])) {
            return $url;
        }

        if (is_array($_REQUEST['quantity'])) {
            $quantity_set = false;
            foreach ($_REQUEST['quantity'] as $item => $quantity) {
                if ($quantity <= 0) {
                    continue;
                }
                $quantity_set = true;
            }

            if (! $quantity_set) {
                return $url;
            }
        }

        $redirect = urna_tbay_get_config('redirect_buy_now', 'cart') ;

        switch ($redirect) {
            case 'cart':
                return wc_get_cart_url();

            case 'checkout':
                return wc_get_checkout_url();
    
            default:
                return wc_get_cart_url();
        }
    }
    add_filter('woocommerce_add_to_cart_redirect', 'urna_woocommerce_buy_now_redirect', 99);
}


if (! function_exists('urna_woocommerce_product_buttons_out_of_stock')) {
    // Change Product Buttons
    function urna_woocommerce_product_buttons_out_of_stock()
    {
        global $product;

        if ($product->is_in_stock() || $product->is_type('variable')) {
            return;
        }

        remove_action('woocommerce_after_add_to_cart_button', 'urna_woocommerce_product_buttons', 10);
        add_action('woocommerce_single_product_summary', 'urna_woocommerce_product_buttons', 30);
    }

    add_action('woocommerce_before_single_product', 'urna_woocommerce_product_buttons_out_of_stock', 10);
}

if (! function_exists('urna_woocommerce_product_buttons_mobile')) {
    // Change Product Buttons
    function urna_woocommerce_product_buttons_mobile()
    {

        if (!wp_is_mobile()) {
            return;
        } ?>
        <?php if (class_exists('YITH_WCWL') || class_exists('YITH_Woocompare') || (urna_tbay_get_config('enable_code_share', false)  && urna_tbay_get_config('enable_product_social_share', false))) { ?>
            <div class="show-mobile">
            <?php if (class_exists('YITH_WCWL')) { ?> 
                <div class="tbay-wishlist">
                   <?php urna_the_yith_wishlist(); ?>
                </div>  
            <?php } ?>


            <?php if (urna_tbay_get_config('enable_code_share', false)  && urna_tbay_get_config('enable_product_social_share', false)) {
            ?>
                  <div class="woo-share-mobile">
                    <button class="button btn-share"><i class="linear-icon-share2"></i></button> 
                    <div class="share-content">
                        <div class="content">
                            <div class="share-header">
                                <h4 class="share-title"><?php esc_html_e('Product share:', 'urna'); ?></h4>
                                <span class="share-close"><i class="linear-icon-cross"></i></span>        
                            </div>
                            <?php if( urna_tbay_get_config('select_share_type') == 'custom' ) : ?>
                                <?php  
                                    $image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                                    urna_custom_share_code( get_the_title(), get_permalink(), $image );
                                ?>
                            <?php else: ?>
                                <div class="addthis_inline_share_toolbox"></div>
                            <?php endif; ?>
                        </div>

                    </div>

                  </div>
                <?php
        }?>

            </div>
        <?php } ?>
        <?php
    }
    add_action('woocommerce_before_single_product_summary', 'urna_woocommerce_product_buttons_mobile', 30);
}

/*product time countdown*/
if (!function_exists('urna_woo_product_time_countdown')) {
    function urna_woo_product_time_countdown($countdown = false, $countdown_title = '')
    {
        global $product;

        if (!$countdown) {
            return;
        }

        wp_enqueue_script('jquery-countdowntimer');
        $time_sale = get_post_meta($product->get_id(), '_sale_price_dates_to', true);
        $_id = urna_tbay_random_key();

        $day        = apply_filters('urna_tbay_countdown_flash_sale_day', esc_html__('d', 'urna'));
        $hours      = apply_filters('urna_tbay_countdown_flash_sale_hour', esc_html__('h', 'urna'));
        $mins       = apply_filters('urna_tbay_countdown_flash_sale_mins', esc_html__('m', 'urna'));
        $secs       = apply_filters('urna_tbay_countdown_flash_sale_secs', esc_html__('s', 'urna')); ?>
        <?php if ($time_sale): ?>
            <div class="time">
                <div class="timming">
                    <?php if (isset($countdown_title) && !empty($countdown_title)) :  ?>
                    <div class="date-title"><?php echo trim($countdown_title); ?></div>
                    <?php endif; ?>
                    <div class="tbay-countdown" id="tbay-flash-sale-<?php echo esc_attr($_id); ?>" data-time="timmer" data-date="<?php echo gmdate('m', $time_sale).'-'.gmdate('d', $time_sale).'-'.gmdate('Y', $time_sale).'-'. gmdate('H', $time_sale) . '-' . gmdate('i', $time_sale) . '-' .  gmdate('s', $time_sale) ; ?>" data-days="<?php echo esc_attr($day); ?>" data-hours="<?php echo esc_attr($hours); ?>" data-mins="<?php echo esc_attr($mins); ?>" data-secs="<?php echo esc_attr($secs); ?>"></div>
                </div>
                <?php if ($product->get_manage_stock()) {?>
                <div class="stock">
                    <?php
                        $total_sales    = $product->get_total_sales();
                        $stock_quantity   = $product->get_stock_quantity();

                        if ($stock_quantity >= 0) {
                            $total_quantity   = (int)$total_sales + (int)$stock_quantity;
                            $sold         = (int)$total_sales / (int)$total_quantity;
                            $percentsold    = $sold*100;
                        }
                     ?>
                  
                    <?php if (isset($percentsold)) { ?>
                        <div class="progress">
                            <div class="progress-bar active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($percentsold); ?>%">
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($stock_quantity >= 0) { ?>
                        <span class="tb-sold"><?php echo esc_html__('Sold', 'urna'); ?> : <span class="sold"><?php echo esc_html($total_sales) ?></span><span class="total">/<?php echo esc_html($total_quantity) ?></span></span>
                    <?php } ?>
                </div>
              <?php } ?>
            </div> 
        <?php endif; ?> 
        <?php
    }
}

if (! function_exists('urna_woo_show_product_loop_outstock_flash')) {
    /*Change Out of Stock woo*/
    add_action('woocommerce_before_shop_loop_item_title', 'urna_woo_show_product_loop_outstock_flash', 20);
    function urna_woo_show_product_loop_outstock_flash($html)
    {
        global $product;
        $return_content = '';

        if ($product->is_on_sale() &&  ! $product->is_in_stock()) {
            $return_content .= '<span class="out-stock out-stock-sale"><span>'. esc_html__('Out of stock', 'urna') .'</span></span>';
        } elseif (! $product->is_in_stock()) {
            $return_content .= '<span class="out-stock"><span>' . esc_html__('Out of stock', 'urna') .'</span></span>';
        }

        echo trim($return_content);
    }
}

//Change image paypal in checkout page
if (! function_exists('urna_woo_paypal_icon')) {
    function urna_woo_paypal_icon()
    {
        return URNA_IMAGES. '/paypal.png';
    }
    add_filter('woocommerce_paypal_icon', 'urna_woo_paypal_icon');
}
 
if (class_exists('NextendSocialLogin') && !function_exists('urna_action_login_form_buttons')) {
    function urna_action_login_form_buttons()
    {
        add_action('woocommerce_login_form_end', 'NextendSocialLogin::addLoginFormButtons');

        add_action('woocommerce_register_form_end', 'NextendSocialLogin::addLoginFormButtons');
    }
    add_action('woocommerce_before_customer_login_form', 'urna_action_login_form_buttons');
    add_action('urna_woocommerce_before_customer_login_form', 'urna_action_login_form_buttons');
}

if (! function_exists('urna_get_single_select_layout')) {
    function urna_get_single_select_layout()
    {
        $custom = get_post_meta(get_the_ID(), '_urna_single_layout_select', true);

        if ( isset($_GET['product_single_layout']) ) {
            $layout = $_GET['product_single_layout'];
        } else {
            $layout = empty($custom) ? urna_tbay_get_config('product_single_layout') : $custom;
        }

        return apply_filters( 'urna_get_single_layout', $layout );
    }
}

if (! function_exists('urna_woocommerce_product_thumbnails_columns')) {
    function urna_woocommerce_product_thumbnails_columns()
    {
        $columns = urna_tbay_get_config('number_product_thumbnail', 4);

        if (isset($_GET['number_product_thumbnail']) && !empty($_GET['number_product_thumbnail']) && is_numeric($_GET['number_product_thumbnail'])) {
            $columns = $_GET['number_product_thumbnail'];
        } else {
            $columns = urna_tbay_get_config('number_product_thumbnail', 4);
        }

        return $columns;
    }
    add_filter('woocommerce_product_thumbnails_columns', 'urna_woocommerce_product_thumbnails_columns', 10, 1);
}

if (! function_exists('urna_woocommerce_config_result_count')) {
    function urna_woocommerce_config_result_count()
    {
        $pagination_style = (isset($_GET['pagination_style'])) ? $_GET['pagination_style'] : urna_tbay_get_config('product_pagination_style', 'number');

        if (isset($pagination_style) && ($pagination_style == 'loadmore')) {
            remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
        }
    }
    add_action('woocommerce_before_main_content', 'urna_woocommerce_config_result_count', 10);
}

//Add filter in mobile
if (!function_exists('urna_tbay_filter_mobile_content')) {
    function urna_tbay_filter_mobile_content()
    {
        if (!(is_product_category() || is_product_tag() || is_product_taxonomy() || is_shop())) {
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
    add_action('woocommerce_before_main_content', 'urna_tbay_filter_mobile_content', 40);
}
//Add button icon sidebar filter mobile
if (!function_exists('urna_tbay_button_filter_sidebar_mobile')) {
    function urna_tbay_button_filter_sidebar_mobile()
    {
        if (is_active_sidebar('sidebar-mobile')) {
            echo '<div class="filter"><button class="button-filter-mobile hidden-lg" type="submit"><i class="linear-icon-equalizer" aria-hidden="true"></i>'. esc_html__('Filter', 'urna') .'</button></div>';
        }
    }
    add_action('woocommerce_before_shop_loop', 'urna_tbay_button_filter_sidebar_mobile', 5);
}

/**
 * ------------------------------------------------------------------------------------------------
 * Product Style Types
 * ------------------------------------------------------------------------------------------------
 */
if (!function_exists('urna_tbay_product_layout_style')) {
    function urna_tbay_product_layout_style($type)
    {
        $type_array = array('v1', 'v2', 'v3', 'v4', 'v5', 'v6', 'v7', 'v8', 'v9', 'v10', 'v11', 'v12', 'v13', 'v14', 'v15', 'v16');
        $type = urna_tbay_get_config('product_layout_style', 'v1');

        $type = (isset($_GET['product_layout_style'])) ? $_GET['product_layout_style'] : $type;
        
        if (!in_array($type, $type_array)) {
            $type = 'v1';
        }
  
        if (apply_filters('urna_product_layout_mobile', wp_is_mobile())) {
            $type = 'v1';
        }
        

        return $type;
    }
}
add_filter('urna_woo_config_product_layout', 'urna_tbay_product_layout_style');


/**
 * ------------------------------------------------------------------------------------------------
 * Mini cart Button
 * ------------------------------------------------------------------------------------------------
 */
if (!function_exists('urna_tbay_minicart_button')) {
    function urna_tbay_minicart_button($icon, $enable_text, $text, $enable_price, $active_elementor_minicart)
    {
        global $woocommerce;

        if ($active_elementor_minicart) {
            urna_switcher_to_boolean($enable_text);
            urna_switcher_to_boolean($enable_price);
        } else {
            $active_theme = urna_tbay_get_theme();

            $icon = urna_tbay_get_config('woo_mini_cart_icon', 'linear-icon-cart');
    
            $enable_text = urna_tbay_get_config('enable_woo_mini_cart_text', true);
            $text = urna_tbay_get_config('woo_mini_cart_text', esc_html__('Shopping cart', 'urna'));
    
            $enable_price = urna_tbay_get_config('enable_woo_mini_cart_price', true);
    
            $hidden_text_cart  = array('kidfashion', 'underwear');
    
            if (in_array($active_theme, $hidden_text_cart)) {
                $enable_text = $enable_price = false;
            }
        } ?>

        <span class="cart-icon">
            <?php if ($active_elementor_minicart) : ?>
                <?php if ($icon['has_svg']) : ?>
                    <?php echo trim($icon['svg']); ?>
                <?php else: ?>
                    <i class="<?php echo esc_attr($icon['iconClass']); ?>"></i>
                <?php endif; else: ?>
                    <i class="<?php echo esc_attr($icon); ?>"></i>
                <?php ?>

            <?php endif; ?>
            <span class="mini-cart-items">
               <?php echo sprintf('%d', $woocommerce->cart->cart_contents_count); ?>
            </span>
        </span>
        <?php if ((!empty($text) && $enable_text) || $enable_price) { ?>
            <span class="text-cart">

            <?php if (!empty($text) && $enable_text) : ?>
                <span><?php echo trim($text); ?></span>
            <?php endif; ?>

            <?php if ($enable_price) : ?>
                <span class="subtotal"><?php echo WC()->cart->get_cart_subtotal();?></span>
            <?php endif; ?>

        </span>

        <?php }
    }
}

/**
 * ------------------------------------------------------------------------------------------------
 * YITH BRAND
 * ------------------------------------------------------------------------------------------------
 */
if (!function_exists('urna_brands_the_name')) {
    function urna_brands_the_name()
    {
        if (!urna_tbay_get_config('enable_brand', false)) {
            return;
        }

        $brand = '';
        if (class_exists('YITH_WCBR')) {
            global $product;

            $terms = wp_get_post_terms($product->get_id(), 'yith_product_brand');

            if ($terms && defined('YITH_WCBR') && YITH_WCBR) {
                $brand  .= '<ul class="show-brand">';

                foreach ($terms as $term) {
                    $name = $term->name;
                    $url = get_term_link($term->slug, 'yith_product_brand');

                    $brand  .= '<li><a href="'. esc_url($url) .'">'. esc_html($name) .'</a></li>';
                }

                $brand  .= '</ul>';
            }
        }

        echo  trim($brand);
    }
    add_action('urna_woo_before_shop_loop_item_caption', 'urna_brands_the_name', 10);
}

/*Get title My Account in top bar mobile*/
if (! function_exists('urna_tbay_woo_get_title_mobile')) {
    function urna_tbay_woo_get_title_mobile($title = '')
    {
        if (is_account_page() && is_user_logged_in()) {
            $current_user   =  wp_get_current_user();
            return $current_user->display_name;
        } elseif (is_product_tag()) {
            $title = esc_html__('Tagged: "', 'urna'). single_tag_title('', false) . '"';
        } elseif (is_product_category()) {
            $title = '';
            $_id = urna_tbay_random_key();
            $args = array(
                'id' => 'product-cat-'.$_id,
                'show_option_none' => '',
            );
            echo '<form method="get" class="woocommerce-fillter">';
            wc_product_dropdown_categories($args);
            echo '</form>';
        } elseif (is_shop()) {
            $post_id = wc_get_page_id('shop');
            if (isset($post_id) && !empty($post_id)) {
                $title = get_the_title($post_id);
            } else {
                $title = esc_html__('shop', 'urna');
            }
        }

        return $title;
    }
    add_filter('urna_get_filter_title_mobile', 'urna_tbay_woo_get_title_mobile');
}

/*The avatar in page my account on mobile*/
if (! function_exists('urna_tbay_woo_my_account_avatar')) {
    function urna_tbay_woo_my_account_avatar()
    {
        if (is_account_page() && is_user_logged_in() && wp_is_mobile()) {
            $current_user   =  wp_get_current_user();
            $output = '<div class="tbay-my-account-avatar">';
            $output .= '<div class="tbay-avatar">';
            $output .= get_avatar($current_user->user_email, 70, '', $current_user->display_name);
            $output .= '</div>';
            $output .= '</div>';

            echo  trim($output);
        }
    }
    add_action('woocommerce_account_navigation', 'urna_tbay_woo_my_account_avatar', 5);
}


/*The list images review*/
if (! function_exists('urna_tbay_the_list_images_review')) {
    function urna_tbay_the_list_images_review()
    {
        global $product;

        if (! is_product() || (! class_exists('VI_Woo_Photo_Reviews') && ! class_exists('VI_WooCommerce_Photo_Reviews'))) {
            return;
        }

        $product_title = $product->get_title();
        $product_single_layout  =  urna_get_single_select_layout();
        $args     = array(
            'post_type'    => 'product',
            'type'         => 'review',
            'status'       => 'approve',
            'post_id'      => $product->get_id(),
            'meta_key'     => 'reviews-images'
        );


        $comments = get_comments($args);

        if (is_array($comments) || is_object($comments)) {
            $outputs = '<div id="list-review-images">';
            $outputs .= '<h4>'. esc_html__('Images from customers:', 'urna') .'</h4>';
            $outputs .= '<ul>';
            
            $i = 0;
            foreach ($comments as $comment) {
                $comment_id     = $comment->comment_ID;
                $image_post_ids = get_comment_meta($comment_id, 'reviews-images', true);
                $content        = get_comment( $comment_id )->comment_content;
                $author         = '<span class="author">'. get_comment( $comment_id )->comment_author .'</span>';
                $rating         = intval( get_comment_meta( $comment_id, 'rating', true ) );

                if ( $rating && wc_review_ratings_enabled() ) {
                    $rating_content = wc_get_rating_html( $rating );
                } else {
                    $rating_content = '';
                } 

                $caption = '<span class="header-comment">' . $rating_content . $author . '</span><span class="title-comment">'. $content .'</span>';


                if (is_array($image_post_ids) || is_object($image_post_ids)) {
                    foreach ($image_post_ids as $image_post_id) {
                        if (! wc_is_valid_url($image_post_id)) {
                            $image_data = wp_get_attachment_metadata($image_post_id);
                            $alt        = get_post_meta($image_post_id, '_wp_attachment_image_alt', true);
                            $image_alt  = $alt ? $alt : $product_title;

                            $width 		= $image_data['width'];
                            $height 	= $image_data['height'];

                            $img_src = apply_filters('woocommerce_photo_reviews_thumbnail_photo', wp_get_attachment_thumb_url($image_post_id), $image_post_id, $comment);

                            $img_src_open = apply_filters('woocommerce_photo_reviews_large_photo', wp_get_attachment_thumb_url($image_post_id), $image_post_id, $comment);

                            $outputs .= '<li class="review-item"><a class="lightbox-gallery" data-caption="'. esc_attr($caption) .'" data-width="'. esc_attr($width) .'" data-height="'. esc_attr($height) .'"  href="'. esc_url($img_src_open) .'"><img class="review-images"
                            src="' . esc_url($img_src) .'" alt="'. apply_filters( 'woocommerce_photo_reviews_image_alt', $image_alt, $image_post_id, $comment ) .'"/></a></li>';
                            
                            $i++;
                        }
                    }
                }
            }

            $more = '';

            if ((($product_single_layout === 'left-main') || ($product_single_layout === 'main-right')) && ($i > 4)) {
                $i      = $i - 4;
                $more   = '<div class="more">'. $i .'+</div>';
            } elseif ($i > 6) {
                $i      = $i - 6;
                $more   = '<div class="more">'. $i .'+</div>';
            }

            $outputs .= $more;

            $outputs .= '</ul></div>';
        }

        if ($i === 0) {
            return;
        }

        echo trim($outputs);
    }
    add_action('woocommerce_before_single_product_summary', 'urna_tbay_the_list_images_review', 100);
}

/*The social nextend social login*/
if (! function_exists('urna_tbay_woo_social_nextend_social_login')) {
    function urna_tbay_woo_social_nextend_social_login()
    {
        if (class_exists('NextendSocialLogin')) {
            echo '<div class="social-log"><span>'. esc_html__('Or login with', 'urna') .'</span></div>';
        }
    }
    add_action('woocommerce_login_form_end', 'urna_tbay_woo_social_nextend_social_login', 10);
}
if (! function_exists('urna_tbay_woo_social_nextend_social_register')) {
    function urna_tbay_woo_social_nextend_social_register()
    {
        if (class_exists('NextendSocialLogin')) {
            echo '<div class="social-log"><span>'. esc_html__('Or connect with', 'urna') .'</span></div>';
        }
    }
    add_action('woocommerce_register_form_end', 'urna_tbay_woo_social_nextend_social_register', 10);
}

// ==========================================================
// Urna Theme
// ==========================================================
if (! function_exists('urna_gwp_affiliate_id')) {
    function urna_gwp_affiliate_id()
    {
        return 2403;
    }
    add_filter('gwp_affiliate_id', 'urna_gwp_affiliate_id');
}

if (! function_exists('urna_custom_product_get_rating_html')) {
    function urna_custom_product_get_rating_html($html, $rating, $count)
    {
        global $product;

        $output = '';

        $review_count = $product->get_review_count();

        if (empty($review_count)) {
            $review_count = 0;
        }

        $class = (empty($review_count)) ? 'no-rate' : '';

        $output .='<div class="rating '. esc_attr($class) .'">';
        $output .= $html;
        $output .= '<div class="count"><span>'. $review_count .'</span></div>';
        $output .= '</div>';

        echo trim($output);
    }
}

if (! function_exists('urna_woo_is_wcmp_vendor_store')) {
    function urna_woo_is_wcmp_vendor_store()
    {
        if (! class_exists('WCMp')) {
            return false;
        }

        global $WCMp;
        if (empty($WCMp)) {
            return false;
        }

        if (is_tax($WCMp->taxonomy->taxonomy_name)) {
            return true;
        }

        return false;
    }
}



/**
 * Check is vendor page
 *
 * @return bool
 */
if (! function_exists('urna_woo_is_vendor_page')) {
    function urna_woo_is_vendor_page()
    {
        if (function_exists('dokan_is_store_page') && dokan_is_store_page()) {
            return true;
        }

        if (class_exists('WCV_Vendors') && method_exists('WCV_Vendors', 'is_vendor_page')) {
            return WCV_Vendors::is_vendor_page();
        }

        if (urna_woo_is_wcmp_vendor_store()) {
            return true;
        }

        if (function_exists('wcfm_is_store_page') && wcfm_is_store_page()) {
            return true;
        }

        return false;
    }
}

//Add class product out of stock to body
if (! function_exists('urna_tbay_body_classes_woocommerce_product_outofstock')) {
    function urna_tbay_body_classes_woocommerce_product_outofstock($classes)
    {
        global $post;

        if (!is_object($post)) {
            return $classes;
        }

        if ($post->post_type !="product") {
            return $classes;
        }

        $product = wc_get_product($post->ID);

        if ($product->get_stock_quantity() == 0) {
            $classes[] = 'product-oos';
        }

        return $classes;
    }
    add_filter('body_class', 'urna_tbay_body_classes_woocommerce_product_outofstock');
}

if (! function_exists('urna_woocommerce_cart_item_name')) {
    function urna_woocommerce_cart_item_name($name, $cart_item, $cart_item_key)
    {
        if (!urna_tbay_get_config('show_checkout_image', false) || !is_checkout()) {
            return $name;
        }
        
        $_product       = $cart_item['data'];
        $thumbnail      = $_product->get_image('urna_photo_reviews_thumbnail_image');

        if (is_checkout()) {
            $output = $thumbnail;
            $output .= $name;
        } else {
            return $name;
        }

        return $output;
    }
    add_filter('woocommerce_cart_item_name', 'urna_woocommerce_cart_item_name', 10, 3);
}

if (! function_exists('urna_compatible_checkout_order')) {
    function urna_compatible_checkout_order()
    {
        $active = false;

        if (class_exists('WooCommerce_Germanized')) {
            $active = true;
        }

        return $active;
    }
}

if ( ! function_exists( 'urna_get_query_products' ) ) {
    function urna_get_query_products($categories = array(), $cat_operator = 'IN', $product_type = 'newest', $limit = '', $orderby = '', $order = '')
    {
        $atts = [
            'limit' => $limit,
            'orderby' => $orderby,
            'order' => $order
        ];
        
        if (!empty($categories)) {
            if (!is_array($categories)) {
                $atts['category'] = $categories;
            } else {
                $atts['category'] = implode(', ', $categories);
                $atts['cat_operator'] = $cat_operator;
            }
        }
        
        $type = 'products';

        $shortcode = new WC_Shortcode_Products($atts, $type);
        $args = $shortcode->get_query_args();
        
        $args = urna_get_attribute_query_product_type($args, $product_type);
        return new WP_Query($args);
    }
}

if ( ! function_exists( 'urna_get_attribute_query_product_type' ) ) {
    function urna_get_attribute_query_product_type($args, $product_type)
    {
        global $woocommerce;

        switch ($product_type) {
            case 'best_selling':
                $args['meta_key']   = 'total_sales';
                $args['order']      = 'DESC';
                $args['orderby']    = 'meta_value_num';
                $args['ignore_sticky_posts']   = 1;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;

            case 'featured':
            case 'featured_product':
                $args['ignore_sticky_posts']    = 1;
                $args['meta_query']             = array();
                $args['orderby']                = 'date';
                $args['order']                  = 'DESC';
                $args['meta_query'][]           = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][]           = $woocommerce->query->visibility_meta_query();
                $args['tax_query'][]              = array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN'
                    )
                );
                break;

            case 'top_rated':
            case 'top_rate':
                $args['meta_key']       = '_wc_average_rating';
                $args['orderby']        = 'meta_value_num';
                $args['order']          = 'DESC';
                break;

            case 'newest':
            case 'recent_product':
                $args['orderby']    = 'date';
                $args['order']      = 'DESC';
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;

            case 'random_product':
                $args['orderby']    = 'rand';
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;

            case 'deals':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $args['meta_query'][] =  array(
                    'relation' => 'AND',
                    array(
                        'relation' => 'OR',
                        array(
                            'key'           => '_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                        array(
                            'key'           => '_min_variation_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                    ),
                    array(
                        'key'           => '_sale_price_dates_to',
                        'value'         => time(),
                        'compare'       => '>',
                        'type'          => 'numeric'
                    ),
                );
                break;

            case 'on_sale':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                break;
        }

        if( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
            $args['meta_query'][] =  array(
                'relation' => 'AND',
                array(
                    'key' => '_stock_status',
                    'value' => 'instock',
                    'compare' => '=',
                )
            );
        }

        $args['tax_query'][] = array(
            'relation' => 'AND',
            array(
               'taxonomy' =>   'product_visibility',
                'field'    =>   'slug',
                'terms'    =>   array('exclude-from-search', 'exclude-from-catalog'),
                'operator' =>   'NOT IN',
            )
        );

        return $args;
    }
}

/** Ajax Elementor Addon urna Product Tabs **/
if ( ! function_exists( 'urna_get_products_tab_ajax' ) ) {
	function urna_get_products_tab_ajax() {
		if ( ! empty( $_POST['atts'] ) ) {
            
			$atts                   = urna_clean( $_POST['atts'] );
            $product_type           = urna_clean( $_POST['value'] );
            $atts['product_type']   = $product_type; 

			$data = urna_elementor_products_ajax_template( $atts );
			echo json_encode( $data );
			die();
		} 
	}
	add_action( 'wp_ajax_urna_get_products_tab_shortcode', 'urna_get_products_tab_ajax' );
	add_action( 'wp_ajax_nopriv_urna_get_products_tab_shortcode', 'urna_get_products_tab_ajax' );
}

/** Ajax Elementor Addon Product Categories Tabs **/
if ( ! function_exists( 'urna_get_products_categories_tab_shortcode' ) ) {
	function urna_get_products_categories_tab_shortcode() {
		if ( ! empty( $_POST['atts'] ) ) {
            
			$atts               = urna_clean( $_POST['atts'] );  
            $categories         = urna_clean( $_POST['value'] );
            $atts['categories'] = $categories;

			$data = urna_elementor_products_ajax_template( $atts );
			echo json_encode( $data );
			die();
		} 
	}
	add_action( 'wp_ajax_urna_get_products_categories_tab_shortcode', 'urna_get_products_categories_tab_shortcode' );
	add_action( 'wp_ajax_nopriv_urna_get_products_categories_tab_shortcode', 'urna_get_products_categories_tab_shortcode' );
}

if ( ! function_exists( 'urna_elementor_products_ajax_template' ) ) {
	function urna_elementor_products_ajax_template( $settings ) {
 
        $loop = $orderby = $order = $attr_row = $cat_operator = $layout_type = $data_carousel = $rows = $columns = $responsive = '';

        $show_des = false;
        extract($settings);    

        switch ($show_des) {
            case 'true':
                $show_des = true;
                break;

            case 'false':
                $show_des = false;
                break;   
        }
     
        $loop = urna_get_query_products($categories, $cat_operator, $product_type, $limit, $orderby, $order);

        if ( preg_match('/\\\\/m', $attr_row) ) {
            $attr_row = preg_replace('/\\\\/m', '', $attr_row);
        } 
		ob_start();  

        if( $loop->have_posts() ) :
            wc_get_template('layout-products/'. $layout_type .'.php', array( 'loop' => $loop, 'columns' => $columns, 'attr_row' => $attr_row, 'responsive' => $responsive, 'data_carousel' => $data_carousel, 'layout_type' => $layout_type, 'rows' => $rows, 'show_des' => $show_des ));
        endif;

        wc_reset_loop();
		wp_reset_postdata();

        return [
            'html' => ob_get_clean(),
        ];
	}
}

/*YITH Wishlist*/
if ( ! function_exists( 'urna_custom_wishlist_icon_html' ) ) {
    function urna_custom_wishlist_icon_html($html ) {
        $icon               = get_option( 'yith_wcwl_add_to_wishlist_icon' );
        $custom_icon        = get_option( 'yith_wcwl_add_to_wishlist_custom_icon' );
        if ( ( class_exists('YITH_WCWL') && apply_filters( 'tbay_yith_wcwl_remove_text', true ) ) && 'custom' === $icon && empty($custom_icon) ) {
            return '<i class="linear-icon-heart"></i>';
        } else {
            return $html;
        }
    }
    add_filter( 'yith_wcwl_add_to_wishlist_icon_html', 'urna_custom_wishlist_icon_html', 10, 1 );
}

if ( ! function_exists( 'urna_custom_add_to_wishlist_icon_html' ) ) {
    function urna_custom_add_to_wishlist_icon_html($html ) {
        $icon                       = get_option( 'yith_wcwl_added_to_wishlist_custom_icon' );
        $custom_icon          = get_option( 'yith_wcwl_added_to_wishlist_custom_icon' );
        if ( ( class_exists('YITH_WCWL') && apply_filters( 'tbay_yith_wcwl_remove_text', true ) ) && 'custom' === $icon && empty($custom_icon) ) {
            return '<i class="linear-icon-heart"></i>';
        } else {
            return $html;
        }
    }
    add_filter( 'yith_wcwl_add_to_wishlist_heading_icon_html', 'urna_custom_add_to_wishlist_icon_html', 10, 1 );
}

if ( ! function_exists( 'urna_remove_wishlist_text' ) ) {
    function urna_remove_wishlist_text( $text ) {
        if( class_exists('YITH_WCWL') && apply_filters( 'tbay_yith_wcwl_remove_text', true ) ) {
            return '';
        } else {
            return $text;
        }
    }
    add_filter('yith_wcwl_product_already_in_wishlist_text_button', 'urna_remove_wishlist_text', 10, 1);
    add_filter('yith_wcwl_product_added_to_wishlist_message_button', 'urna_remove_wishlist_text', 10, 1);
    add_filter('yith_wcwl_remove_from_wishlist_label', 'urna_remove_wishlist_text', 10, 1);
}

if ( ! function_exists( 'urna_quantity_mini_cart' ) ) {

    add_action('wp_ajax_woocommerce_urna_quantity_mini_cart', 'urna_quantity_mini_cart');
    add_action('wp_ajax_nopriv_woocommerce_urna_quantity_mini_cart', 'urna_quantity_mini_cart');
    // WC AJAX can be used for frontend ajax requests.
    add_action('wc_ajax_urna_quantity_mini_cart', 'urna_quantity_mini_cart');
    function urna_quantity_mini_cart() {
        $cart_item_key = $_REQUEST['hash'];

        // Get the array of values owned by the product we're updating
        $product_values = WC()->cart->get_cart_item($cart_item_key);

        // Get the quantity of the item in the cart
        $product_quantity = apply_filters('woocommerce_stock_amount_cart_item', apply_filters('woocommerce_stock_amount', preg_replace("/[^0-9\.]/", '', filter_var($_REQUEST['quantity'], FILTER_SANITIZE_NUMBER_INT))), $cart_item_key);

        // Update cart validation
        $passed_validation  = apply_filters('woocommerce_update_cart_validation', true, $cart_item_key, $product_values, $product_quantity);    

        // Update the quantity of the item in the cart
        if ($passed_validation) {
            WC()->cart->set_quantity($cart_item_key, $product_quantity, true);
        } 

        // Return fragments
        ob_start();
        woocommerce_mini_cart();
        $mini_cart = ob_get_clean();

        // Fragments and mini cart are returned
        $data = array(
            'fragments' => apply_filters(
                'woocommerce_add_to_cart_fragments',
                array(
                    'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
                )
            ), 
            'cart_hash' => apply_filters('woocommerce_cart_hash', WC()->cart->get_cart_for_session() ? md5(json_encode(WC()->cart->get_cart_for_session())) : '', WC()->cart->get_cart_for_session())
        );   
    
        wp_send_json($data);   

        die();
    }
}