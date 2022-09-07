<?php

$iconClass = '';

wp_enqueue_script('slick');
wp_enqueue_script('urna-slick');

$columns = isset($columns) ? $columns : 4;
$rows_count = isset($rows) ? $rows : 1;


$screen_desktop             =      isset($screen_desktop) ? $screen_desktop : 4;
$screen_desktopsmall        =      isset($screen_desktopsmall) ? $screen_desktopsmall : 3;
$screen_tablet              =      isset($screen_tablet) ? $screen_tablet : 3;
$screen_landscape_mobile    =      isset($screen_landscape_mobile) ? $screen_landscape_mobile : 2;
$screen_mobile              =      isset($screen_mobile) ? $screen_mobile : 1;

$disable_mobile          =      isset($disable_mobile) ? $disable_mobile : '';

$countall = count($tagstabs);

$data_carousel = urna_tbay_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile);
$responsive_carousel  = urna_tbay_checK_data_responsive_carousel($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);

$layout = 'v1';
?>
<div class="owl-carousel tags" <?php echo trim($responsive_carousel); ?>  <?php echo trim($data_carousel); ?> >
    <?php
     $count = 0;
     foreach ($tagstabs as $tab) {
         $tag 		    = 	get_term_by('id', $tab['tag'], 'product_tag');
         $tag_count      =   urna_get_product_count_of_tags($tab['tag']);

         if (isset($tag) && $tag) {
             $tag_name 		= 	$tag->name;
             $tag_slug 		= 	$tag->slug;
             $tag_link 		= 	get_term_link($tag->slug, 'product_tag');
         } else {
             $tag_name = esc_html__('Shop', 'urna');
             $tag_link 		= 	get_permalink(wc_get_page_id('shop'));
         }

         $iconClass = (!empty($tab['icon'])) ? $tab['icon'] : '';

         if (isset($tab['check_custom_link']) &&  $tab['check_custom_link'] == 'yes' && isset($tab['custom_link']) && !empty($tab['custom_link'])) {
             $tag_link = $tab['custom_link'];
         } ?> 

		<?php if ($count%$rows_count == 0) { ?> 
			<div class="item"> 
		<?php } ?>
 
            <?php wc_get_template('item-tag/tag-custom-'.$layout.'.php', array('tab'=> $tab, 'count_item'=> $count_item, 'iconClass'=> $iconClass, 'tag_name'=> $tag_name, 'tag_link'=> $tag_link, 'tag_count'=> $tag_count )); ?>



		<?php if ($count%$rows_count == $rows_count-1 || $count==$countall -1) { ?>
			</div>
		<?php }
         $count++; ?>
        <?php
     }

    ?>
</div> 
<?php wp_reset_postdata(); ?>