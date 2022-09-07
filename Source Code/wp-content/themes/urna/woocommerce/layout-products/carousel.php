<?php

wp_enqueue_script('slick');
wp_enqueue_script('urna-slick');

$type = apply_filters('urna_woo_config_product_layout', 10, 2);
$inner = 'inner-'.$type;
$product_item = isset($product_item) ? $product_item : $inner;

$columns 		= isset($columns) ? $columns : 4;
$show_des 		= isset($show_des) ? $show_des : false;
$countdown 		= isset($countdown) ? $countdown : false;
$flash_sales 	= isset($flash_sales) ? $flash_sales : false;
$end_date 		= isset($end_date) ? $end_date : '';

$countdown_title 		= isset($countdown_title) ? $countdown_title : '';

$rows_count 	= isset($rows) ? $rows : 1;
$data_auto		= (!empty($data_auto)) ? $data_auto : 'no';
$data_loop		= (!empty($data_loop)) ? $data_loop : 'no';
$data_autospeed	= (!empty($data_autospeed)) ? $data_autospeed : 500;


$screen_desktop          	=      isset($screen_desktop) ? $screen_desktop : 4;
$screen_desktopsmall     	=      isset($screen_desktopsmall) ? $screen_desktopsmall : 3;
$screen_tablet           	=      isset($screen_tablet) ? $screen_tablet : 3;
$screen_landscape_mobile    =      isset($screen_landscape_mobile) ? $screen_landscape_mobile : 2;
$screen_mobile           	=      isset($screen_mobile) ? $screen_mobile : 1;

$classes = array('products-grid', 'product');
?>
<?php if (isset($attr_row) && !empty($attr_row)) : ?>
	<div <?php echo trim($attr_row); ?>>
<?php else :

	if( isset($responsive) && !empty($responsive) ) {
		$screen_desktop 			= $responsive['desktop'];
		$screen_desktopsmall 		= $responsive['desktopsmall'];
		$screen_tablet 				= $responsive['tablet'];
		$screen_landscape_mobile 	= $responsive['landscape'];
		$screen_mobile 				= $responsive['mobile'];
	}

	if( isset($data_carousel) && !empty($data_carousel) ) {
		$nav_type 				= $data_carousel['nav_type'];
		$pagi_type 				= $data_carousel['pagi_type'];
		$loop_type 				= $data_carousel['loop_type'];
		$auto_type 				= $data_carousel['auto_type'];
		$autospeed_type 		= $data_carousel['autospeed_type'];
		$disable_mobile 		= $data_carousel['disable_mobile'];
		$rows 					= $data_carousel['rows'];

		$rows_count 	= isset($rows) ? $rows : 1;
	}

    $data_carousel = urna_tbay_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile);
    $responsive_carousel  = urna_tbay_checK_data_responsive_carousel($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);
    $class_item = ($rows_count != 1) ? 'row-no-one' : '';
    ?>
	<div class="owl-carousel scroll-init products rows-<?php echo esc_attr($rows_count); ?> <?php echo esc_attr($class_item); ?> <?php urna_slick_carousel_product_block_image_class(); ?>" <?php echo trim($responsive_carousel); ?>  <?php echo trim($data_carousel); ?>>
<?php endif; ?>

    <?php while ($loop->have_posts()): $loop->the_post(); global $product; ?>
		
		<div class="item">
			<div <?php wc_product_class( $classes, $loop->get_id() ); ?>>
	            <?php 
					$post_object = get_post( get_the_ID() );
					setup_postdata( $GLOBALS['post'] =& $post_object );
					
					wc_get_template('item-product/'.$product_item.'.php', array('show_des' => $show_des, 'countdown' => $countdown, 'countdown_title' => $countdown_title, 'flash_sales' => $flash_sales, 'end_date' => $end_date )); 
				?>
	        </div>
	
		</div>
		
    <?php endwhile; ?>
</div> 
<?php wp_reset_postdata(); ?>