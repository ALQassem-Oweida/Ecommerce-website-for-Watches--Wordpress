<?php

wp_enqueue_script('slick');
wp_enqueue_script('urna-slick');

$columns = isset($columns) ? $columns : 4;
$rows_count = isset($rows) ? $rows : 1;


$screen_desktop          =      isset($screen_desktop) ? $screen_desktop : 4;
$screen_desktopsmall     =      isset($screen_desktopsmall) ? $screen_desktopsmall : 3;
$screen_tablet           =      isset($screen_tablet) ? $screen_tablet : 3;
$screen_landscape_mobile    =      isset($screen_landscape_mobile) ? $screen_landscape_mobile : 2;
$screen_mobile           =      isset($screen_mobile) ? $screen_mobile : 1;

$disable_mobile          =      isset($disable_mobile) ? $disable_mobile : '';

$countall = count($all_categories);
?>

<?php if (isset($attr_row) && !empty($attr_row)) : ?>
	<div <?php echo trim($attr_row); ?>>
<?php else : ?>
	<?php
        $data_carousel = urna_tbay_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile);
        $responsive_carousel  = urna_tbay_checK_data_responsive_carousel($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);
    ?>

	<div class="owl-carousel categories rows-<?php echo esc_attr($rows_count); ?>" <?php echo trim($responsive_carousel); ?>  <?php echo trim($data_carousel); ?> >
<?php endif; ?>
    <?php
     $count = 0;
     foreach ($all_categories as $cat) {
         ?> 

		<?php if ($count%$rows_count == 0) { ?> 
			<div class="item">
		<?php } ?>

				<?php wc_get_template('item-categories/cat.php', array('cat'=> $cat)); ?>

		<?php if ($count%$rows_count == ($rows_count-1) || $count == ($countall  -1)) { ?>
			</div>
		<?php }
         $count++; ?>
        <?php
     }

    ?>
</div> 
<?php wp_reset_postdata(); ?>