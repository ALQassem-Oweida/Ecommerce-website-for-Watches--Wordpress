<?php
    global $woocommerce;
    $_id = urna_tbay_random_key();
    
    extract($args);
?>
<div class="tbay-topcart">
 <div id="cart-<?php echo esc_attr($_id); ?>" class="cart-dropdown cart-popup dropdown">
        <a class="dropdown-toggle mini-cart" data-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0" href="#" title="<?php esc_attr_e('View your shopping cart', 'urna'); ?>">    
			<?php  urna_tbay_minicart_button($icon_array, $show_title_mini_cart, $title_mini_cart, $price_mini_cart, $active_elementor_minicart); ?>
        </a>            
        <div class="dropdown-menu"><div class="widget_shopping_cart_content">
            <?php woocommerce_mini_cart(); ?>
        </div></div>
    </div>
</div>    