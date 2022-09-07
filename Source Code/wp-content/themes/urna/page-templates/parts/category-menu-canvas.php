<?php if (has_nav_menu('nav-category-menu')):

$open                        =   apply_filters('urna_category_inside_class', '');
$enable_ajax_toggle_menu     = 	urna_tbay_get_config('enable_ajax_toggle_menu', false);

$active_ajax_toggle_menu     = false;
$data_attr = '';
if( $enable_ajax_toggle_menu && $open !== 'open' ) {
    $open = 'ajax-active';
    
    $layout         = 'vertical';
    $type_menu      = 'toggle';
    $header_type    = 'none';

    $data_wrapper = wp_json_encode( [
        'layout' => $layout,
        'type_menu' => $type_menu,
        'header_type' => $header_type,
    ] );

    $data_attr = 'data-wrapper="'. esc_attr($data_wrapper) .'"';

    $active_ajax_toggle_menu = true;
} 

$tbay_location = 'nav-category-menu';
$locations  = get_nav_menu_locations();
$menu_id    = $locations[ $tbay_location ] ;
$menu_obj   = wp_get_nav_menu_object( $menu_id );
$menu_name  = urna_get_transliterate($menu_obj->slug);

?>
<div class="category-inside tbay-element element-menu-ajax vertical-menu <?php echo esc_attr($open); ?>" <?php echo trim($data_attr); ?>>
    <a href="javascript:void(0);" class="category-inside-title menu-click"><i class="linear-icon-menu"></i><?php echo apply_filters('urna_category_inside_title', esc_html__('All Departments', 'urna')); ?></a>
    <div class="category-inside-content"> 
        <nav class="menu" role="navigation" data-id="<?php echo esc_attr($menu_name); ?>">
            <?php
                if( !$active_ajax_toggle_menu ) {
                    $args = array(
                        'theme_location'    => $tbay_location,
                        'menu_class'        => 'tbay-menu-category tbay-vertical',
                        'fallback_cb'       => '__return_empty_string',
                        'menu_id'           => 'nav-category-menu',
                        'items_wrap'        => '<ul id="%1$s" class="%2$s" data-id="'. $menu_name .'">%3$s</ul>'
                    );
                    if (class_exists("Urna_Tbay_Custom_Nav_Menu")) {
                        $args['walker'] = new Urna_Tbay_Custom_Nav_Menu();
                    }
                    wp_nav_menu($args);
                }
            ?>
        </nav>
    </div>
</div>
<?php endif;?>