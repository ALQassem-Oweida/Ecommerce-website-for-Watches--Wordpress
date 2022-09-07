<?php


$iconClass = '';

$columns = isset($columns) ? $columns : 4;

$count = 0;

$layout = 'v1';

?>
<?php
    foreach ($tagstabs as $tab) {
        $tag            =   get_term_by('id', $tab['tag'], 'product_tag');
        $tag_count      =   urna_get_product_count_of_tags($tab['tag']);


        if (isset($tab['images']) && $tab['images']) {
            $tag_id 		= 	$tab['images'];
        }

        $iconClass = (!empty($tab['icon'])) ? $tab['icon'] : '';

        if (isset($tag) && $tag) {
            $tag_name 		= 	$tag->name;
            $tag_slug 		= 	$tag->slug;
            $tag_link 		= 	get_term_link($tag->slug, 'product_tag');
        } else {
            $tag_name = esc_html__('Shop', 'urna');
            $tag_link 		= 	get_permalink(wc_get_page_id('shop'));
        }

        if (isset($tab['check_custom_link']) &&  $tab['check_custom_link'] == 'yes' && isset($tab['custom_link']) && !empty($tab['custom_link'])) {
            $tag_link = $tab['custom_link'];
        } ?> 

			<div class="item">

                <?php wc_get_template('item-tag/tag-custom-'.$layout.'.php', array('tab'=> $tab, 'count_item'=> $count_item, 'iconClass'=> $iconClass, 'tag_name'=> $tag_name, 'tag_link'=> $tag_link, 'tag_count'=> $tag_count )); ?>

			</div>
		<?php
        $count++; ?>
        <?php
    }
?>

<?php wp_reset_postdata(); ?>