<?php

$columns = $screen_desktop = $screen_desktopsmall = $screen_tablet = $screen_landscape_mobile = $screen_mobile = $rows = $nav_type = $pagi_type = $loop_type = $auto_type = $autospeed_type = $disable_mobile = $el_class = $css = $css_animation = $disable_mobile = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
$_id = urna_tbay_random_key();

if (isset($categoriestabs) && !empty($categoriestabs)):
    $categoriestabs = (array) vc_param_group_parse_atts($categoriestabs);

$i = 0;

$responsive = urna_tbay_checK_data_responsive($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);

$cat_array = array();
$args = array(
    'type' => 'post',
    'child_of' => 0,
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => false,
    'hierarchical' => 1,
    'taxonomy' => 'product_cat'
);

$categories = get_categories($args);
urna_tbay_get_category_childs($categories, 0, 0, $cat_array);

$cat_array_id   = array();
foreach ($cat_array as $key => $value) {
    $cat_array_id[]   = $value;
}

$cat_operator		= 'IN';

$show_des = (isset($show_des)) ? $show_des : false ;

$css = isset($atts['css']) ? $atts['css'] : '';
$el_class = isset($atts['el_class']) ? $atts['el_class'] : '';

$class_to_filter = 'tbay-addon tbay-addon-products tbay-addon-categoriestabs has-banner tbay-addon-'. $layout_type .'';

if( $ajax_tabs === 'yes' ) { 
    $class_to_filter    .= ' tbay-product-categories-tabs-ajax ajax-active';
    $cat_operator		= 'IN';

    $data_carousel = array();
    if( $layout_type === 'carousel' ) {
        $data_carousel = array(
            'nav_type'          => $nav_type,
            'pagi_type'         => $pagi_type,
            'loop_type'         => $loop_type,
            'auto_type'         => $auto_type,
            'autospeed_type'    => $autospeed_type,
            'disable_mobile'    => $disable_mobile,
            'rows'              => $rows,
        );
    }

    $json = array(
        'product_type'                  => $type_product,
        'cat_operator'                  => $cat_operator,
        'limit'                         => $number,
        'responsive'                    => $responsive, 
        'columns'                       => $columns, 
        'layout_type'                   => $layout_type,
        'show_des'                      => $show_des,
        'data_carousel'                 => $data_carousel,
    ); 

    $encoded_settings  = wp_json_encode( $json );

    $tabs_data = 'data-atts="'. esc_attr( $encoded_settings ) .'"';
} else {
    $tabs_data = '';
}

$class_to_filter .= vc_shortcode_custom_css_class($css, ' ') . $this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

?>

    <div class="<?php echo esc_attr($css_class); ?>">
        <div class="tabs-container tab-heading <?php echo (isset($title) && $title) ? 'has-title' : ''; ?>">
            <?php if ((isset($subtitle) && $subtitle) || (isset($title) && $title)): ?>
            <h3 class="tbay-addon-title">
                    <?php if (isset($title) && $title): ?>
                        <span><?php echo trim($title); ?></span>
                    <?php endif; ?>
                    <?php if (isset($subtitle) && $subtitle): ?>
                        <span class="subtitle"><?php echo trim($subtitle); ?></span>
                    <?php endif; ?>
                </h3>
            <?php endif; ?>
            <ul role="tablist" class="product-categories-tabs-title tabs-list nav nav-tabs" <?php echo trim($tabs_data); ?>>
                <?php foreach ($categoriestabs as $tab) : ?>

                    <?php

                    if (!in_array($tab['category'], $cat_array_id)) {
                        $cat_category    = esc_html__('all-categories', 'urna');
                        $cat_name        = esc_html__('All', 'urna');
                        $slug            = '';
                    } else {
                        $cat_category    = $tab['category'];
                        $category        = get_term_by('id', $cat_category, 'product_cat');
                        $cat_name        = $category->name;
                        $slug            = urna_get_transliterate($category->slug);
                    }

                    ?> 

 
                    <?php
                        $tabactive = ($i == 0) ? 'active' : '';
                    ?>
                    <li class="<?php echo esc_attr($tabactive); ?>">
                        <a href="#tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($i); ?>" data-toggle="tab" data-value="<?php echo esc_attr($slug); ?>">
                            <?php echo esc_html($cat_name); ?>
                        </a>
                    </li>

                <?php $i++; endforeach; ?>
            </ul>
        </div>
        
        <div class="tbay-addon-content woocommerce">
            
            <div class="tbay-addon-inner">
                <div class="tbay-addon-content tab-content">
                    <?php $_count = 0; foreach ($categoriestabs as $tab) : ?>


                        <?php

                        if (!in_array($tab['category'], $cat_array_id)) {
                            $cat_category    = esc_html__('all-categories', 'urna');
                            $link            = get_permalink(wc_get_page_id('shop'));

                            $loop      = urna_get_query_products('', $cat_operator, $type_product, $number);
                        } else {
                            $category   = get_term_by('id', $tab['category'], 'product_cat');
                            $cat_category = $category->slug;
                            $link       = get_term_link($category->term_id, 'product_cat');

                            $loop      = urna_get_query_products($cat_category, $cat_operator, $type_product, $number);
                        }
                        $banner_positions = (isset($tab['banner_positions'])) ? $tab['banner_positions'] : '';

                        $tab_active = ($_count == 0) ? ' active active-content current' : '';
                        ?>

                        <div id="tab-<?php echo esc_attr($_id);?>-<?php echo esc_attr($_count); ?>" class="tab-pane animated fadeIn <?php echo esc_attr($tab_active); ?> <?php echo isset($tab['banner']) ? esc_attr($banner_positions) : ''; ?>">
                            <?php if (isset($tab['banner'])) { ?>
                                <div class="pull-<?php echo (isset($banner_positions)) ? esc_attr($banner_positions) : ''; ?> hidden-sm hidden-xs tab-banner">


                                    <?php
                                        $banner         = (isset($tab['banner'])) ? $tab['banner'] : '';
                                        $banner_link    = (isset($tab['banner_link'])) ? $tab['banner_link'] : '';
                                        $img            = (isset($tab['banner'])) ? wp_get_attachment_image_src($tab['banner'], 'full') : '';

                                    ?>

                                    <?php if (!empty($img) && isset($img[0])): ?>
                                        <?php if (isset($banner_link) && !empty($banner_link)) : ?>
                                            <div class="img-banner">
                                                <a href="<?php echo esc_url($banner_link); ?>" class="vc_single_image-wrapper">
                                                    <?php echo wp_get_attachment_image($tab['banner'], 'full'); ?>
                                                </a>
                                            </div>
                                        <?php else : ?>
                                            <div class="img-banner">
                                                <?php echo wp_get_attachment_image($tab['banner'], 'full'); ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </div>
                            <?php } ?>

                            <?php if( $_count === 0 || $ajax_tabs !== 'yes' ) : ?>

							<?php wc_get_template('layout-products/'.$layout_type.'.php', array( 'layout_type' => $layout_type, 'loop' => $loop, 'loop_type' => $loop_type, 'show_des' => $show_des, 'auto_type' => $auto_type, 'autospeed_type' => $autospeed_type, 'columns' => $columns, 'rows' => $rows, 'pagi_type' => $pagi_type, 'nav_type' => $nav_type,'responsive_type' => $responsive_type, 'screen_desktop' => $responsive['desktop'], 'screen_desktopsmall' => $responsive['desktopsmall'], 'screen_tablet' => $responsive['tablet'], 'screen_landscape_mobile' => $responsive['landscape'], 'screen_mobile' => $responsive['mobile'], 'number' => $number, 'disable_mobile' => $disable_mobile )); ?>

                            <?php endif; ?>

                        </div>

                    <?php $_count++; endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>