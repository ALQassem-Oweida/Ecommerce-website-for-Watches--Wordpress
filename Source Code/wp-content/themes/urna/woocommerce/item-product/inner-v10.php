<?php
global $product;

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);

remove_action('urna_tbay_after_shop_loop_item_title', 'urna_tbay_woocommerce_variable', 15);
add_action('urna_woo_before_shop_loop_item_caption', 'urna_tbay_woocommerce_variable', 5);

do_action('urna_woocommerce_before_product_block_grid');

$flash_sales 	= isset($flash_sales) ? $flash_sales : false;
$end_date 		= isset($end_date) ? $end_date : '';

$countdown_title 		= isset($countdown_title) ? $countdown_title : '';

$countdown 		= isset($countdown) ? $countdown : false;
$end_date 		= isset($end_date) ? $end_date : '';

$countdown_title 		= isset($countdown_title) ? $countdown_title : '';

$class = array();
$class_flash_sale = urna_tbay_class_flash_sale($flash_sales);
array_push($class, $class_flash_sale);

?>
<div <?php urna_tbay_product_class($class); ?> data-product-id="<?php echo esc_attr($product->get_id()); ?>">
	<div class="product-content">
		<div class="block-inner">
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
				<?php urna_tbay_item_deal_ended_flash_sale($flash_sales, $end_date); ?>
			</figure>
			<div class="group-buttons clearfix">	
				<?php do_action('woocommerce_after_shop_loop_item'); ?>

				<?php
                    urna_the_yith_wishlist();
                    urna_the_yith_compare($product->get_id());
                    urna_the_quick_view($product->get_id());
                ?>
				
	    	</div>
		</div>
		<div class="caption">
			
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

                do_action('woocommerce_after_shop_loop_item_title');

            ?>
			<?php
                do_action('urna_woo_after_shop_loop_item_caption');
            ?>
		</div>
    </div>
    <?php urna_woo_product_time_countdown($countdown, $countdown_title); ?>
    <?php urna_tbay_stock_flash_sale($flash_sales); ?>
</div>
<?php
do_action('urna_woocommerce_after_product_block_grid');
