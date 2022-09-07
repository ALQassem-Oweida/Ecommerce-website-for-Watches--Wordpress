<?php
    global $woocommerce;
?>
<div class="tbay-dropdown-cart sidebar-left">
	<div class="dropdown-content">
		<div class="widget-header-cart">
			<h3 class="widget-title heading-title"><?php esc_html_e('Shopping cart', 'urna'); ?></h3>
			<a href="javascript:;" class="offcanvas-close"><i class="linear-icon-cross"></i></a>
		</div>
		<div class="widget_shopping_cart_content">
	    <?php woocommerce_mini_cart(); ?>
		</div>
	</div>
</div>