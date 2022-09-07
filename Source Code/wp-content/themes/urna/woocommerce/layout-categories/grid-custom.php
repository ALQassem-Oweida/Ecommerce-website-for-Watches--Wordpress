<?php

$columns = isset($columns) ? $columns : 4;

if (! (isset($shop_now) && $shop_now == 'yes')) {
    $shop_now = '';
    $shop_now_text = '';
}

$count = 0;

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

if (!isset($attr_row)) {
    $attr_row = '';
}

?>
<?php
    foreach ($categoriestabs as $tab) {
        ?> 

			<div class="item">

                <?php if (isset($attr_row) && isset($tab['icon']) && !empty($tab['icon']['value'])) {
            $tab['iconClass'] = $tab['icon']['value'];
        } ?>

               <?php wc_get_template('item-categories/cat-custom-'.$layout.'.php', array('tab'=> $tab, 'attr_row'=> $attr_row, 'count_item'=> $count_item, 'shop_now' => $shop_now,'shop_now_text' => $shop_now_text )); ?>

			</div>
		<?php
        $count++; ?>
        <?php
    }
?>

<?php wp_reset_postdata(); ?>