<?php

$columns 		= isset($columns) ? $columns : 4;

$only_image 	= isset($only_image) ? $only_image : false;

if ($only_image) {
    $product_item = 'content-recent-viewed';
} else {
    $product_item = 'content-products';
}

$screen_desktop          	=      isset($screen_desktop) ? $screen_desktop : 4;
$screen_desktopsmall     	=      isset($screen_desktopsmall) ? $screen_desktopsmall : 3;
$screen_tablet           	=      isset($screen_tablet) ? $screen_tablet : 3;
$screen_landscape_mobile    =      isset($screen_landscape_mobile) ? $screen_landscape_mobile : 2;
$screen_mobile           	=      isset($screen_mobile) ? $screen_mobile : 1;

if (isset($attr_row) && !empty($attr_row)) {
    $class = 'products products-grid';
} else {
    $data_responsive  = urna_tbay_checK_data_responsive_grid($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);
    $class = ($columns <= 1) ? 'w-products-list' : 'recently-viewed recently-grid';
}
 
?>
<div class="<?php echo esc_attr($class); ?>">

	<?php if (isset($attr_row) && !empty($attr_row)) : ?>
	<div <?php echo trim($attr_row); ?>>
	<?php else : ?>
	<div class="row <?php echo esc_attr($layout_type); ?>" <?php echo trim($data_responsive); ?>>
	<?php endif; ?>

		<?php while ($loop->have_posts()) : $loop->the_post(); global $product; ?>

			<?php 
				$post_object = get_post( get_the_ID() );
				setup_postdata( $GLOBALS['post'] =& $post_object );
				
				wc_get_template($product_item .'.php', array('screen_desktop' => $screen_desktop,'screen_desktopsmall' => $screen_desktopsmall,'screen_tablet' => $screen_tablet,'screen_mobile' => $screen_mobile)); 
			?>

		<?php endwhile; ?>
	</div>
</div>

<?php wp_reset_postdata(); ?>