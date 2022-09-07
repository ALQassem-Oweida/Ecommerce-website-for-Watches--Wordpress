<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 5.2.0
 */


global $woocommerce;
$_id = urna_tbay_random_key();
?>

<?php do_action('woocommerce_before_mini_cart'); ?>
<div class="mini_cart_content">
	<div class="mini_cart_inner">
		<div class="mcart-border">
			<?php if (sizeof(WC()->cart->get_cart()) > 0) : ?>
				<ul class="cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">
					<?php
                      do_action('woocommerce_before_mini_cart_contents');

                    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                        $_product     = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        $product_id   = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                            $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                            $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_gallery_thumbnail'), $cart_item, $cart_item_key);
                            $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key); ?>
							<li id="mcitem-<?php echo esc_attr($_id); ?>-<?php echo esc_attr($cart_item_key); ?>">
								<div class="product-image">
									<?php if (empty($product_permalink)) : ?>
										<?php echo trim($thumbnail); ?>
									<?php else : ?>
										<a class="image" href="<?php echo esc_url($product_permalink); ?>">
										<?php echo trim($thumbnail); ?>
										</a>
									<?php endif; ?>
								</div>	
								<div class="product-details">
							
									<?php if (empty($product_permalink)) : ?>
										<span class="product-name"><?php echo wp_kses_post($product_name); ?></span>
									<?php else: ?>
										<a class="product-name" href="<?php echo esc_url($product_permalink); ?>"><span><?php echo wp_kses_post($product_name); ?></span></a>
									<?php endif; ?>
									

									<div class="group">
										<?php echo wc_get_formatted_cart_item_data($cart_item); ?>
										<div class="group-content">
											<?php echo apply_filters('woocommerce_widget_cart_item_quantity', sprintf('%s', $product_price), $cart_item, $cart_item_key); ?>
											<?php 
												if (urna_tbay_get_config('show_mini_cart_qty', false)) {
													if ($_product->is_sold_individually()) :
														$product_quantity = sprintf('<input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key); else :
														$product_quantity = woocommerce_quantity_input(
															array(
																'input_name'   => 'cart[' . $cart_item_key . '][qty]',
																'input_value'  => $cart_item['quantity'],
																'max_value'    => $_product->get_max_purchase_quantity(),
																'min_value'    => '0',
																'product_name' => $product_name
															),
															$_product,
															false
														);
													endif;

													echo '<span class="quantity-wrap">' . apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item) . '</span>'; // PHPCS: XSS ok.
												} else {
													?>
													<span class="quantity">
														(x<?php echo apply_filters('woocommerce_widget_cart_item_quantity', sprintf('%s', $cart_item['quantity']), $cart_item, $cart_item_key); ?>)
													</span>
													<?php
												}
											?>
										</div>
									</div>
									<?php echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-product_sku="%s" data-cart_item_key="%s"><i class="linear-icon-trash2"></i></a>',
                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                esc_attr__('Remove this item', 'urna'),
                                esc_attr($product_id),
                                esc_attr($_product->get_sku()),
                                esc_attr($cart_item_key)
                            ), $cart_item_key); ?>
								</div>
							</li>
							<?php
                        }
                    }

                      do_action('woocommerce_mini_cart_contents');
                    ?>
				</ul><!-- end product list -->
			<?php else: ?>
				<ul class="cart_empty <?php echo esc_attr($args['list_class']); ?>">
					<li><span><?php esc_html_e('Empty cart.', 'urna'); ?></span></li>
					<li class="total"><a class="button wc-continue" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>"><?php esc_html_e('Continue Shopping', 'urna') ?><i class="linear-icon-arrow-right"></i></a></li>
				</ul>
			<?php endif; ?>

			<?php if (sizeof(WC()->cart->get_cart()) > 0) : ?>
				<div class="group-button">

					<p class="total">
						<?php
                        /**
                         * Woocommerce_widget_shopping_cart_total hook.
                         *
                         * @hooked woocommerce_widget_shopping_cart_subtotal - 10
                         */
                        do_action('woocommerce_widget_shopping_cart_total');
                        ?>
					</p>

					<?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>

					<p class="buttons">
						<a href="<?php echo esc_url(wc_get_checkout_url());?>" class="button checkout"><?php esc_html_e('Checkout', 'urna'); ?></a>
						<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="button view-cart"><?php esc_html_e('View Cart', 'urna'); ?></a>
							
					</p>
				</div>
			<?php endif; ?>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<?php do_action('woocommerce_after_mini_cart'); ?>