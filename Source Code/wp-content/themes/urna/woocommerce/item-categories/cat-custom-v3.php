<?php

if (isset($tab['type']) && ($tab['type'] !== 'none')) {
    vc_icon_element_fonts_enqueue($tab['type']);
    $type = $tab['type'];
    $iconClass = isset($tab{'icon_' . $type }) ? esc_attr($tab{'icon_' . $type }) : 'fa fa-adjust';
}

$have_icon = (isset($iconClass) && $iconClass) ? 'cat-icon' : 'cat-img';

if (isset($attr_row) && !empty($attr_row)) {
    $cat 			= get_term_by('slug', $tab['category'], 'product_cat');
    $category_id 	= $cat->term_taxonomy_id;
    $cat_id 		= (isset($tab['images']['id']) && !empty($tab['images']['id'])) ? $tab['images']['id'] : '';
} else {
    $category_id    =  $tab['category'];
    $cat_id         =   (isset($tab['images']) && !empty($tab['images'])) ? $tab['images'] : '';
    $cat            =   get_term_by('id', $tab['category'], 'product_cat');
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

$cat_count      =   urna_get_product_count_of_category($category_id);
?>
<div class="item-cat <?php echo esc_attr($have_icon); ?>">

    <div class="content-img">

        

            <?php if ((isset($shop_now) && $shop_now == 'yes')) : ?>
                <div class="content">
                    <div class="cat-hover">
                        <?php if ($count_item == 'yes') { ?>
                            <span class="count-item"><?php echo trim($cat_count).' '.apply_filters('urna_tbay_categories_count_item', esc_html__('items', 'urna')); ?></span>
                        <?php } ?>
                        <a href="<?php echo esc_url($cat_link); ?>" class="shop-now"><?php echo trim($shop_now_text); ?></a>
                    </div>
                </div>
               
            <?php else: ?>
                <?php if ($count_item == 'yes') { ?>
                    <span class="count-item"><?php echo trim($cat_count).' '.apply_filters('urna_tbay_categories_count_item', esc_html__('items', 'urna')); ?></span>
                <?php } ?>
    
            <?php endif; ?>
       

        <?php if (isset($cat_id) && !empty($cat_id)): ?>
            <a href="<?php echo esc_url($cat_link); ?>">
                <?php echo wp_get_attachment_image($cat_id, 'full'); ?>
            </a>
        <?php endif; ?>

    </div>

    <?php

        if (!empty($tab['nav_menu'])) :

        $menu_id = $tab['nav_menu'];
    ?>
        <div class="item-menu">
            <a href="<?php echo esc_url($cat_link); ?>" class="cat-name"><?php echo trim($cat_name); ?></a>
            <?php
                urna_get_custom_menu($menu_id);
            ?>
        </div>

    <?php endif; ?>

</div>