<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-end.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$sidebar_configs  					= urna_tbay_get_woocommerce_layout_configs();

$product_single_sidebar_position    =  (isset($_GET['product_single_sidebar_position']))   ?   $_GET['product_single_sidebar_position'] :  urna_tbay_get_config('product_single_sidebar_position', 'inner-sidebar');
?>
				</div><!-- .content -->
				
				<?php if (!is_product() || (is_product() && (!empty($sidebar_configs['left']) || !empty($sidebar_configs['right'])) && $product_single_sidebar_position !== 'inner-sidebar')) {
    get_sidebar('shop-left');
    get_sidebar('shop-right');
} ?>
				
			</div> <!-- .row -->
	</div> <!-- container -->
</div> <!-- main wrapper-->