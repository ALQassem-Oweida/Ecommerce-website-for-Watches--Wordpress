<?php
/**
 * The template Image layout normal
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Urna
 * @since Urna 1.0
 */

global $product;

$sidebar_configs  		= urna_tbay_get_woocommerce_layout_configs();

$class_pull_right 		= (isset($sidebar_configs['left']) && is_active_sidebar($sidebar_configs['left']['sidebar'])) ? 'pull-right' : '';

$has_sidebar 			= ((isset($sidebar_configs['left']) && is_active_sidebar($sidebar_configs['left']['sidebar'])) || isset($sidebar_configs['right']) && is_active_sidebar($sidebar_configs['right']['sidebar'])) ? 'col-lg-9' : '';

$class_inner = trim($class_pull_right . ' '.$has_sidebar);

//check Enough number image thumbnail
$attachment_ids = $product->get_gallery_image_ids();

$class_thumbnail = (empty($attachment_ids)) ? 'no-gallery-image' : '';

?>

<div class="row">
	
	<?php if ((!empty($sidebar_configs['left']) || !empty($sidebar_configs['right'])) && $inner_sidebar == 'inner-sidebar') {
    echo '<div class="col-xs-12 '. esc_attr($class_inner) .'">';
    echo '<div class="row content">';
} ?>

		<div class="image-mains <?php echo esc_attr($class_thumbnail); ?> <?php echo (empty($sidebar_configs['left']) && empty($sidebar_configs['right'])) ? 'col-sm-6' : ''; ?>">
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
		<div class="information <?php echo (empty($sidebar_configs['left']) && empty($sidebar_configs['right'])) ? 'col-sm-6' : ''; ?>">
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



	<?php if (((!empty($sidebar_configs['left']) || !empty($sidebar_configs['right']))) && $inner_sidebar === 'inner-sidebar') {
                    echo '</div></div>';
                    get_sidebar('shop-left');
                    get_sidebar('shop-right');
                } ?>

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
