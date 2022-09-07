<?php
global $product;

$type = apply_filters('urna_woo_config_product_layout', 10, 2);
?>
<div class="product-block list list-<?php echo esc_attr($type); ?>" data-product-id="<?php echo esc_attr($product->get_id()); ?>">

	<?php
        /**
        * urna_woocommerce_before_shop_list_item hook
        *
        * @hooked urna_tbay_woocommerce_list_variable_swatches_pro - 5
        */
        do_action('urna_woocommerce_before_shop_list_item');
    ?>

	<div class="row">
			<div class="block-inner col-xs-5 col-sm-4">
				<figure class="image <?php urna_product_block_image_class(); ?>">
					<a title="<?php the_title_attribute(); ?>" href="<?php echo the_permalink(); ?>" class="product-image">
						<?php
                            /**
                            * woocommerce_before_shop_loop_item_title hook
                            *
                            * @hooked woocommerce_show_product_loop_sale_flash - 10
                            * @hooked woocommerce_template_loop_product_thumbnail - 10
                            */
                            do_action('woocommerce_before_shop_loop_item_title');
                        ?>
					</a>

					<?php
                        /**
                        * urna_tbay_after_shop_loop_item_title hook
                        *
                        * @hooked urna_tbay_add_slider_image - 10
                        * @hooked urna_tbay_woocommerce_variable - 15
                        */
                        do_action('urna_tbay_after_shop_loop_item_title');
                    ?>
				</figure>
			</div>
			<div class="caption col-xs-7 col-sm-8">
				<?php
                    do_action('urna_woo_before_shop_loop_item_caption');
                ?>
				<?php urna_the_product_name(); ?>

				<?php
                    /**
                    * woocommerce_after_shop_loop_item_title hook
                    *
                    * @hooked woocommerce_template_loop_rating - 5
                    * @hooked woocommerce_template_loop_price - 10
                    */
                    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
                    add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);
                    do_action('woocommerce_after_shop_loop_item_title');
                ?>

				<div class="woocommerce-product-details__short-description">
	           		<?php echo get_the_excerpt(); ?>
	           	</div>

				<div class="group-buttons clearfix">	
					<?php do_action('woocommerce_after_shop_loop_item'); ?>

					<?php
                        urna_the_yith_wishlist();
                        urna_the_quick_view($product->get_id());
                        urna_the_yith_compare($product->get_id());
                    ?>

				<?php
                    if (class_exists('Woo_Variation_Swatches_Pro')) {
                        remove_action('urna_woo_after_shop_loop_item_caption', 'wvs_pro_archive_variation_template', 10);
                    }
                    do_action('urna_woo_after_shop_loop_item_caption');
                ?>
			    </div>

		</div>
	</div>

	<?php
        do_action('urna_woocommerce_after_shop_list_item');
    ?>
</div>


