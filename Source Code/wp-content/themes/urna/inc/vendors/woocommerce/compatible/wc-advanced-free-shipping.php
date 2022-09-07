<?php
/**
 * Compatible WooCommerce_Advanced_Free_Shipping
 * Only with one Rule "subtotal >= Rule"
 */

if ( !class_exists('WooCommerce_Advanced_Free_Shipping') ||  !function_exists('WAFS') ) return;



/**
 * Add Free_Shipping to Mini Cart
 */
if (!function_exists('urna_subtotal_free_shipping')) {
    add_action('woocommerce_widget_shopping_cart_total', 'urna_subtotal_free_shipping', 20);
    function urna_subtotal_free_shipping($return = false) {
        $content = ''; 
        
        $wafs = WAFS();


        if (!isset($wafs->was_method)) {
            $wafs->wafs_free_shipping();
        }
        
        $wafs_method = isset($wafs->was_method) ? $wafs->was_method : null;

        if (!$wafs_method || $wafs_method->hide_shipping === 'no' || $wafs_method->enabled === 'no') {
            return $content;
        }

        /**
         * Check only 1 post wafs inputed
         */
        $wafs_posts = get_posts(array(
            'posts_per_page'    => 2,
            'post_status'       => 'publish',
            'post_type'         => 'wafs'
        ));


        if (!$wafs_posts || count($wafs_posts) !== 1) {
            return $content;
        }

        /**
         * Check only 1 rule on 1 post inputed
         */
        $wafs_post = $wafs_posts[0];



        $condition_groups = get_post_meta($wafs_post->ID, '_wafs_shipping_method_conditions', true);



        if (!$condition_groups || count($condition_groups) !== 1) {
            return;
        }
        $condition_group = $condition_groups[0];
        if (!$condition_group || count($condition_group) !== 1) {
            return $content;
        }

        /**
         * Check rule is subtotal
         */
        $value = 0;
        foreach ($condition_group as $condition) {
            if ($condition['condition'] !== 'subtotal' || $condition['operator'] !== '>=' || !$condition['value']) {
                return $content;
            }

            $value = $condition['value'];
            break;
        }

        $subtotalCart = WC()->cart->subtotal;
        $spend = 0;
        
        /**
         * Check free shipping
         */
        if ($subtotalCart < $value) {
            $spend = $value - $subtotalCart;
            $per = intval(($subtotalCart/$value)*100);
            
            $content .= '<div class="tbay-total-condition-wrap tbay-active">';
            
            $content .= '<div class="tbay-total-condition" data-per="' . esc_attr($per) . '">' .
                '<span class="tbay-total-condition-hint" style="width: ' . esc_attr($per) .'%">' . esc_attr($per) . '%</span>' .
                '<div class="tbay-subtotal-condition" style="width: ' . esc_attr($per) .'%">' . esc_attr($per) . '%</div>' .
            '</div>';
            
            $allowed_html = array(
                'strong' => array(),
                'a' => array(
                    'class' => array(),
                    'href' => array(),
                    'title' => array()
                ),
                'span' => array(
                    'class' => array()
                ),
                'br' => array()
            );
            
            $content .= '<div class="tbay-total-condition-desc">' .
            sprintf(
                wp_kses(__('Spend %s more to reach <strong>FREE SHIPPING!</strong> <br /><span class="hide-in-cart">to add more products to your cart and receive free shipping for order %s.</span>', 'urna'), $allowed_html),
                wc_price($spend),
                wc_price($value)
            ) . 
            '</div>';
            
            $content .= '</div>';
        }
        /**
         * Congratulations! You've got free shipping!
         */
        else {
            $content .= '<div class="tbay-total-condition-wrap">';
            $content .= '<div class="tbay-total-condition-desc">';
            $content .= sprintf(
                esc_html__("Congratulations! You get free shipping with your order greater %s.", 'urna'),
                wc_price($value)
            );
            $content .= '</div>';
            $content .= '</div>';
        }
        
        if (!$return) {
            echo trim($content);
            
            return;
        }
        
        return $content;
    }
}


/**
 * Add Free_Shipping to Cart page
 */
if (!function_exists('urna_subtotal_free_shipping_in_cart')) {
    add_action('woocommerce_cart_actions', 'urna_subtotal_free_shipping_in_cart', 10);
    function urna_subtotal_free_shipping_in_cart()
    {
        $content = urna_subtotal_free_shipping(true);
        if ($content !== '') {
            echo '<tr class="tbay-no-border"><td colspan="6" class="tbay-subtotal_free_shipping">' . $content . '</td></tr>';
        }
    }
}