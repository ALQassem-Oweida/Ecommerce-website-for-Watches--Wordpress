<?php 

$enable_ajax_canvas_menu     = 	urna_tbay_get_config('enable_ajax_canvas_menu', false);

$active_ajax_canvas_menu     = false;
$data_attr = '';
if( $enable_ajax_canvas_menu ) {
    $layout         = 'vertical';

    $data_wrapper = wp_json_encode( [
        'layout' => $layout,
    ] );

    $data_attr = 'data-wrapper="'. esc_attr($data_wrapper) .'"';

    $active_ajax_canvas_menu = true;
} 

$tbay_location = 'primary';
$locations  = get_nav_menu_locations();
$menu_id    = $locations[ $tbay_location ] ;
$menu_obj   = wp_get_nav_menu_object( $menu_id );
$menu_name  = urna_get_transliterate($menu_obj->slug);
?>
<div id="tbay-offcanvas-main" class="tbay-offcanvas-main verticle-menu hidden-md" <?php echo trim($data_attr); ?>> 
    <div class="tbay-offcanvas-body">
        <div class="offcanvas-head">
        	<h3><?php echo esc_html_e('Menu', 'urna'); ?></h3>
            <a href="javascript:void(0);" class="btn-toggle-canvas" data-toggle="offcanvas"><i class="linear-icon-cross2"></i></a>
        </div>

        <?php if (has_nav_menu('primary')) : ?>
	        <nav data-duration="400" class="menu hidden-xs hidden-sm tbay-megamenu slide animate navbar" data-id="<?php echo esc_attr($menu_name); ?>">
	        <?php
                if( !$active_ajax_canvas_menu ) {
                    $args = array(
                        'theme_location' => 'primary',
                        'container_class' => 'collapse navbar-collapse',
                        'menu_class' => 'nav navbar-nav',
                        'fallback_cb' => '__return_empty_string',
                        'menu_id' => 'primary-menu',
                        'items_wrap'        => '<ul id="%1$s" class="%2$s" data-id="'. $menu_name .'">%3$s</ul>',
                        'walker' => new urna_Tbay_Nav_Menu()
                    );
                    wp_nav_menu($args);
                }
            ?>
	        </nav>
		<?php endif; ?>

    </div>
</div>