<?php
/**
 * The template Image layout centered
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Urna
 * @since Urna 1.0
 */

do_action('urna_woocommerce_before_single_product_centered');
?>

<div class="row single-sticky">

	<div class="col-md-3 summary-left">
		<?php
            /**
             * urna_woocommerce_single_product_summary_left hook
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             */
            add_action('urna_woocommerce_single_product_summary_left', 'woocommerce_template_single_title', 5);
            add_action('urna_woocommerce_single_product_summary_left', 'woocommerce_template_single_rating', 10);
            add_action('urna_woocommerce_single_product_summary_left', 'woocommerce_template_single_price', 15);
            add_action('urna_woocommerce_single_product_summary_left', 'woocommerce_template_single_excerpt', 20);
            do_action('urna_woocommerce_single_product_summary_left');
        ?>
	</div>				

	<div class="image-mains-center col-md-5">
		<div class="image-mains">
			<?php
                /**
                 * woocommerce_before_single_product_summary hook
                 *
                 * @hooked woocommerce_show_product_sale_flash - 10
                 * @hooked woocommerce_show_product_images - 20
                 */
                do_action('woocommerce_before_single_product_summary');
            ?>
		</div>
	</div>		

	<div class="col-md-4 summary-right">
		<?php
            /**
             * urna_woocommerce_single_product_summary_right hook
             *
             * @hooked woocommerce_template_single_add_to_cart - 5
             * @hooked woocommerce_template_single_meta - 10
             * @hooked woocommerce_template_single_sharing - 10
             */
            add_action('urna_woocommerce_single_product_summary_right', 'woocommerce_template_single_add_to_cart', 5);
            add_action('urna_woocommerce_single_product_summary_right', 'woocommerce_template_single_meta', 10);
            add_action('urna_woocommerce_single_product_summary_right', 'woocommerce_template_single_sharing', 15);
            do_action('urna_woocommerce_single_product_summary_right');
        ?>
	</div>

</div>	

<?php
    /**
     * woocommerce_after_single_product_summary hook
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action('woocommerce_after_single_product_summary');
?>