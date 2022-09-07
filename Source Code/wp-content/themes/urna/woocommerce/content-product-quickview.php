<div id="tbay-quick-view-modal" class="singular-shop">
    <?php  do_action('urna_before_quick_view_product_summary'); ?>
    <div id="product-<?php the_ID(); ?>" <?php post_class('product '); ?>>
    	<div id="tbay-quick-view-content" class="woocommerce single-product details-product">
            <div class="image-mains product">
                <?php 
                    /**
                     * woocommerce_before_single_product_summary hook
                     *
                     * @hooked woocommerce_show_product_images - 20
                     */
                    do_action( 'woocommerce_before_single_product_summary' );
                ?>  
            </div>
            <div class="summary entry-summary">
                <div class="information">
                <?php do_action('woocommerce_before_single_product'); ?>
                <?php
                    /**
                     * Hook: woocommerce_single_product_summary.
                     *
                     * @hooked woocommerce_template_single_title - 5
                     * @hooked woocommerce_template_single_rating - 10
                     * @hooked woocommerce_template_single_price - 10
                     * @hooked woocommerce_template_single_excerpt - 20
                     * @hooked woocommerce_template_single_add_to_cart - 30
                     * @hooked woocommerce_template_single_meta - 40
                     * @hooked woocommerce_template_single_sharing - 50
                     * @hooked WC_Structured_Data::generate_product_data() - 60
                     */
                    remove_action('woocommerce_single_product_summary', 'urna_woo_product_single_time_countdown', 28);
                    do_action('woocommerce_single_product_summary');
                    add_action('woocommerce_single_product_summary', 'urna_woo_product_single_time_countdown', 28);
                ?>
                </div>
            </div>
    	</div>
    </div>
    <?php  do_action('urna_after_quick_view_product_summary'); ?>
</div>

