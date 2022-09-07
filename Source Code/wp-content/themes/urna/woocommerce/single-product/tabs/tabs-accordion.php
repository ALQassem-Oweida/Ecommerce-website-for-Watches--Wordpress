<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (!empty($product_tabs)) : $selectIds = '#collapse-tab-0'; ?>

    <div class="wc-tabs-wrapper" id="woocommerce-tabs" data-ride="carousel">
        <div class="panel-group accordion-group" id="accordion" role="tablist" aria-multiselectable="true">
            <?php $i = 0;
            foreach ($product_tabs as $key => $product_tab): $in = ($i == 0) ? 'in' : '';
                $arrow = ($i == 0) ? 'minus' : 'plus';
                $expanded = ($i == 0) ? true : false;
                $i++; ?>
                <div class="panel">
                    <div class="tabs-title" role="tab" id="tbay-wc-tab-<?php echo esc_attr($key); ?>">
                        <a role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapse-tab-<?php echo esc_attr($i); ?>" aria-expanded="true"
                           aria-controls="collapse-tab-<?php echo esc_attr($i); ?>">
                            <?php echo apply_filters('woocommerce_product_' . $key . '_tab_title', esc_html($product_tab['title']), $key); ?>
                            <i class="linear-icon-<?php echo esc_attr($arrow); ?>-square icons"></i> </a>
                    </div>
                    <div id="collapse-tab-<?php echo esc_attr($i); ?>"
                         class="panel-collapse collapse <?php echo esc_attr($in); ?>" role="tabpanel"
                         aria-labelledby="tbay-wc-tab-<?php echo esc_attr($key); ?>">
                        <div class="entry-content"><?php call_user_func($product_tab['callback'], $key, $product_tab); ?></div>
                    </div>
                </div>
                <?php $selectIds .= ',#collapse-tab-' . $i; endforeach ?>
        </div>

		   <?php do_action('woocommerce_product_after_tabs'); ?>
    </div>

    <script type="text/javascript">
        jQuery(function ($) {
            var selectIds = $('<?php echo trim($selectIds); ?>');
            selectIds.on('show.bs.collapse hidden.bs.collapse', function (e) {
                $(this).prev().find('.icons').toggleClass('linear-icon-minus-square linear-icon-plus-square');
            })
        });
    </script>


<?php endif; ?>
