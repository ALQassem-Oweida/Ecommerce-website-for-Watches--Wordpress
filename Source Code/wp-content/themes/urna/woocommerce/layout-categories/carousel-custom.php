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

$countall = count($categoriestabs);

if (! (isset($shop_now) && $shop_now == 'yes')) {
    $shop_now = '';
    $shop_now_text = '';
}


$skin = urna_tbay_get_theme();
switch ($skin) {
    case 'beauty':
        $layout = 'v2';
        break;
    case 'book':
        $layout = 'v3';
        break;
    case 'women':
        $layout = 'v4';
        break;
    default:
        $layout = 'v1';
        break;
}

?>

<?php if (isset($attr_row) && !empty($attr_row)) : ?>
	<div <?php echo trim($attr_row); ?>>
<?php else : ?>
    <?php
        $attr_row      = '';
        $data_carousel = urna_tbay_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile);
        $responsive_carousel  = urna_tbay_checK_data_responsive_carousel($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);
    ?>
    <div class="owl-carousel categories rows-<?php echo esc_attr($rows_count); ?>" <?php echo trim($responsive_carousel); ?>  <?php echo trim($data_carousel); ?> >
<?php endif; ?>

    <?php
     $count = 0;
     foreach ($categoriestabs as $tab) {
         if (isset($attr_row) && isset($tab['icon']) && !empty($tab['icon']['value'])) {
             $tab['iconClass'] = $tab['icon']['value'];
         } ?> 

		<?php if ($count%$rows_count == 0) { ?> 
			<div class="item">
		<?php } ?>

            <?php wc_get_template('item-categories/cat-custom-'.$layout.'.php', array('tab'=> $tab, 'attr_row'=> $attr_row, 'count_item'=> $count_item, 'shop_now' => $shop_now,'shop_now_text' => $shop_now_text )); ?>


		<?php if ($count%$rows_count == $rows_count-1 || $count==$countall -1) { ?>
			</div>
		<?php }
         $count++; ?>
        <?php
     }

    ?>
</div> 
<?php wp_reset_postdata(); ?>