<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
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

$configs = urna_class_wrapper_start();

?>

	<div id="main-wrapper" class="<?php echo esc_attr($configs['main']); ?>">
		<?php do_action('urna_woo_template_main_before'); ?>

		<div id="main-container" class="container inner">
			<div class="row">
				
				<div id="main" class="<?php echo urna_wc_wrapper_class($configs['content']) ;?>"><!-- .content -->

				<?php if ((is_shop() && '' !== get_option('woocommerce_shop_page_display')) || (is_product_category() && 'subcategories' == get_option('woocommerce_category_archive_display')) || (is_product_category() && 'both' == get_option('woocommerce_category_archive_display'))) { ?>
					<ul class="all-subcategories"><?php urna_woocommerce_sub_categories(); ?></ul>
				<?php } ?>