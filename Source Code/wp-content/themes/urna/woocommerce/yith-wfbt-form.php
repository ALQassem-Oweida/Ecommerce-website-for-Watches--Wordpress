<?php

if (!(defined('YITH_WFBT_PREMIUM') && YITH_WFBT_PREMIUM)) {
    wc_get_template('yith-wfbt-form-free.php', array('products'=> $products ));
} else {
    /**
     * Form template
     *
     * @author Yithemes
     * @package YITH WooCommerce Frequently Bought Together Premium
     * @version 1.3.0
     */

    if (empty($product)) {
        global $product;
    }

    if (! isset($products)) {
        return;
    }
    /**
     * @type $product WC_Product
     */
    // set query
    $url        = ! is_null($product) ? $product->get_permalink() : '';
    $url        = add_query_arg('action', 'yith_bought_together', $url);
    $url        = wp_nonce_url($url, 'yith_bought_together');
    $is_wc_30   = version_compare(WC()->version, '3.0.0', '>='); ?>

	<div class="yith-wfbt-section tbay-addon woocommerce">
		<?php if ($title != '') {
        echo '<h3 class="tbay-addon-title">' . esc_html($title) . '</h3>';
    }

    if (! empty($additional_text)) {
        echo trim($additional_text);
    } ?>

		<form class="yith-wfbt-form" method="post" action="<?php echo esc_url($url) ?>">

	        <?php if (! $show_unchecked) : ?>
	            <div class="yith-wfbt-images">
	            	<ul>
                    <?php $i = 0;
    foreach ($products as $product) :

                        $product_id = $product->get_id();

    if (in_array($product->get_id(), $unchecked)) {
        continue;
    } ?>

                        <?php if ($i > 0) : ?>
                            <li class="image_plus image_plus_<?php echo esc_attr($i); ?>" data-rel="offeringID_<?php echo esc_attr($i); ?>"><i class="linear-icon-plus"></i></li>
                        <?php endif; ?>
                        <li class="image-td" data-rel="offeringID_<?php echo esc_attr($i); ?>">
                        	<div class="content">
	                            <a href="<?php echo esc_url($product->get_permalink()); ?>">
	                                <?php echo trim($product->get_image('yith_wfbt_image_size')); ?>
	                            </a>
	                            <div class="caption">
			                        <span class="name">
			                        	<?php if ($product_id != $main_product_id) { ?>
		                            	<a href="<?php echo esc_url($product->get_permalink()); ?>"><?php echo trim($product->get_title()); ?></a>
				                        <?php } else {
        echo sprintf('%1$s', $product->get_title());
    } ?>
			                        </span>
			                        <span class="price"><?php echo trim($product->get_price_html()); ?></span>
	                            </div>
	                        </div>
                        </li>
                    <?php $i++;
    endforeach; ?>
                	</ul>
			        <ul class="yith-wfbt-items">
			            <?php $j = 0;
    foreach ($products as $product) :
                            $product_id = $product->get_id(); ?>
			                <li class="yith-wfbt-item">
			                    <label for="offeringID_<?php echo esc_attr($j); ?>">
			                        <input type="checkbox" name="offeringID[]" id="offeringID_<?php echo esc_attr($j); ?>" class="active" value="<?php echo esc_attr($product_id); ?>" <?php echo (! in_array($product_id, $unchecked) && ! $show_unchecked) ? 'checked="checked"' : '' ?>>
			                        <i class="linear-icon-check-square"></i>
			                        <?php if ($product_id != $main_product_id) : ?>
			                            <a href="<?php echo esc_url($product->get_permalink()); ?>">
			                        <?php endif ?>

			                        <span class="product-name">
							            <?php echo(($product_id == $main_product_id) ? '<span>'. esc_html__('This item', 'urna') . ': &nbsp;</span>' : '') . sprintf('%1$s <span class="att">%2$s</span>', $product->get_title(), wc_get_formatted_variation($product, true)); ?>
			                        </span>

			                        <?php if ($product_id != $main_product_id) : ?>
			                            </a>
			                        <?php endif; ?>

			                    </label>
			                </li>
			            <?php $j++;
    endforeach; ?>
					</ul>
					<?php if (! $is_empty) : ?>
			            <div class="yith-wfbt-submit-block">
			                <div class="price_text">
			                    <span class="total_price_label">
			                        <?php echo esc_html($label_total) ?>:
			                    </span>
			                    <span class="total_price">
			                        <?php echo trim($total); ?>
			                    </span>
			                </div>

			                <input type="submit" class="yith-wfbt-submit-button-remove button" value="<?php echo esc_attr($label); ?>">
			            </div>
			        <?php endif; ?>
	            </div>

	        <?php endif; ?>

	        <input type="hidden" name="yith-wfbt-main-product" value="<?php echo esc_attr($main_product_id); ?>" >
		</form>
	</div>
<?php
}?>
