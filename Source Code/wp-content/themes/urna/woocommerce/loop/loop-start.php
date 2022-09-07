<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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

$columns				= apply_filters('loop_shop_columns', 4);
$screen_desktop			= apply_filters('loop_shop_columns', 4);
switch ($columns) {
    case '6':
        $screen_desktopsmall 	= 5;
        break;
    case '5':
        $screen_desktopsmall 	= 4;
        break;
    default:
        $screen_desktopsmall	= $columns;
        break;
}
$screen_tablet 			= 3;
$screen_mobile 			= 2;

$data_responsive = ' data-xlgdesktop='. $columns .'';

$data_responsive .= ' data-desktop='. $screen_desktop .'';

$data_responsive .= ' data-desktopsmall='. $screen_desktopsmall .'';

$data_responsive .= ' data-tablet='. $screen_tablet .'';

$data_responsive .= ' data-mobile='. $screen_mobile .'';

$woo_mode = urna_tbay_woocommerce_get_display_mode();

switch ($woo_mode) {
    case 'grid':
        $mode = 'grid';
        break;
    case 'grid2':
        $mode = 'grid grid2';
        break;
    case 'list':
        $mode = 'list';
        break;
    
    default:
        $mode = 'grid';
        break;
}


wp_enqueue_style('sumoselect');
wp_enqueue_script('jquery-sumoselect');

urna_woocommerce_ajax_filter_sidebar(); ?>
<div class="display-products products products-<?php echo esc_attr($mode); ?>"><div class="row" <?php echo esc_attr($data_responsive); ?>>
