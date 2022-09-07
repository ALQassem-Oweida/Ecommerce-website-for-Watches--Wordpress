<?php

if (isset($attr_row) && !empty($attr_row)) {
    $cat 			= get_term_by('slug', $tab['category'], 'product_cat');
    $category_id 	= $cat->term_taxonomy_id;

    if ($tab['cat_style'] === 'icon') {
        $cat_id = '';
        $iconClass      = $tab['iconClass'];
    } else {
        $cat_id 		= (isset($tab['images']['id']) && !empty($tab['images']['id'])) ? $tab['images']['id'] : '';
    }
} else {
    $category_id    =  $tab['category'];
    $cat_id         =   (isset($tab['images']) && !empty($tab['images'])) ? $tab['images'] : '';
    $cat            =   get_term_by('id', $tab['category'], 'product_cat');
    $iconClass      = (!empty($tab['icon'])) ? $tab['icon'] : '';
}

if (isset($cat) && $cat) {
    $cat_name       =   $cat->name;
    $cat_slug       =   $cat->slug;
    $cat_link       =   get_term_link($cat->slug, 'product_cat');
} else {
    $cat_name       =  esc_html__('Shop', 'urna');
    $cat_link       =   get_permalink(wc_get_page_id('shop'));
}

if (isset($tab['check_custom_link']) &&  $tab['check_custom_link'] == 'yes') {
    if (isset($attr_row) && !empty($tab['custom_link']['url'])) {
        $cat_link = $tab['custom_link']['url'];
    } else {
        $cat_link = $tab['custom_link'];
    }
}

$have_icon = (isset($iconClass) && $iconClass) ? 'cat-icon' : 'cat-img';

$cat_count      =   urna_get_product_count_of_category($category_id);

?>
<div class="item-cat <?php echo esc_attr($have_icon); ?>">
<?php if (isset($cat_id) && !empty($cat_id)) : ?>
    <a href="<?php echo esc_url($cat_link); ?>">
        <?php echo wp_get_attachment_image($cat_id, 'full'); ?>
    </a>

<?php elseif (!empty($iconClass)): ?>

    <a href="<?php echo esc_url($cat_link); ?>"><i class="<?php echo esc_attr($iconClass); ?>"></i></a>

<?php endif; ?>
    <div class="content">
        <a href="<?php echo esc_url($cat_link); ?>" class="cat-name"><?php echo trim($cat_name); ?></a>

        <?php if ((isset($shop_now) && $shop_now == 'yes')) { ?>
            <div class="cat-hover">
                <?php if ($count_item == 'yes') { ?>
                    <span class="count-item"><?php echo trim($cat_count).' '. apply_filters('urna_tbay_categories_count_item', esc_html__('items', 'urna')); ?></span>
                <?php } ?>
                <a href="<?php echo esc_url($cat_link); ?>" class="shop-now"><?php echo trim($shop_now_text); ?></a>
            </div>
            <?php } else { ?>
            <?php if ($count_item == 'yes') { ?>
                <span class="count-item"><?php echo trim($cat_count).' '.apply_filters('urna_tbay_categories_count_item', esc_html__('items', 'urna')); ?></span>
            <?php } ?>      
        <?php } ?>
   </div>
</div>