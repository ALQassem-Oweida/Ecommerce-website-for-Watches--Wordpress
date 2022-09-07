<?php
/**
 * The template Image layout gallery
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Urna
 * @since Urna 1.0
 */

global $product;

//check Enough number image thumbnail
$attachment_ids = $product->get_gallery_image_ids();
$count 					= count($attachment_ids);

$class_thumbnail 		= '';
if (empty($attachment_ids) || $count < 2) {
    $class_thumbnail 	= 'no-gallery-image';
}
?>

<div class="row">
	<div class="image-mains <?php echo esc_attr($class_thumbnail); ?> col-md-6 col-lg-6">
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
	<div class="col-md-1 hidden-sm hidden-xs"></div>
	<div class="information col-md-6 col-lg-5">
		<div class="summary entry-summary ">

			<?php
                /**
                 * woocommerce_single_product_summary hook
                 *
                 * @hooked woocommerce_template_single_title - 5
                 * @hooked woocommerce_template_single_rating - 10
                 * @hooked woocommerce_template_single_price - 10
                 * @hooked woocommerce_template_single_excerpt - 20
                 * @hooked woocommerce_template_single_add_to_cart - 30
                 * @hooked woocommerce_template_single_meta - 40
                 * @hooked woocommerce_template_single_sharing - 50
                 */
                do_action('woocommerce_single_product_summary');
            ?>

		</div><!-- .summary -->
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
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
    add_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 0);
    do_action('woocommerce_after_single_product_summary');
?>