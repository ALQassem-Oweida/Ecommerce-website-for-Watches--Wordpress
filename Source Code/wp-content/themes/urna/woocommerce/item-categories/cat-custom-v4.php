<?php

$description        =   (isset($tab['description'])) ? $tab['description'] : '';

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
<div class="item-cat item-cat-v4">

    <div class="content-img">

        <?php if (isset($cat_id) && !empty($cat_id)): ?>
            <div class="cat-img">
                <a href="<?php echo esc_url($cat_link); ?>">
                    <?php echo wp_get_attachment_image($cat_id, 'full'); ?>
                </a>
            </div>
        <?php endif; ?>

        <div class="content">

            <?php if (isset($cat) && $cat) : ?>
                <a href="<?php echo esc_url($cat_link); ?>" class="cat-name"><?php echo trim($cat_name); ?></a>
            <?php else: ?>
                <a href="<?php echo esc_url($cat_link); ?>" class="cat-name"><?php esc_html_e('All', 'urna') ?></a>
            <?php endif; ?>

            <?php if (!empty($description)) : ?>
                <div class="cat-description">
                    <?php echo trim($description); ?>
                </div>
            <?php endif; ?>

            <?php if ((isset($shop_now) && $shop_now == 'yes')) : ?>
                <a href="<?php echo esc_url($cat_link); ?>" class="shop-now"><?php echo trim($shop_now_text); ?></a>
            <?php endif; ?>
        </div>



    </div>

</div>