<?php if (has_nav_menu('primary')) : ?>
        <?php 
            $tbay_location = 'primary';
            $locations  = get_nav_menu_locations();
            $menu_id    = $locations[ $tbay_location ] ;
            $menu_obj   = wp_get_nav_menu_object( $menu_id );
            $menu_name = urna_get_transliterate($menu_obj->slug);
        ?>
        <nav data-duration="400" class="menu hidden-xs hidden-sm tbay-megamenu slide animate navbar">
        <?php   
            $args = array(
                'theme_location' => $tbay_location,
                'container_class' => 'collapse navbar-collapse',
                'menu_class' => 'nav navbar-nav megamenu',
                'fallback_cb' => '__return_empty_string',
                'menu_id' => 'primary-menu',
                'walker' => new urna_Tbay_Nav_Menu(),
                'items_wrap'  => '<ul id="%1$s" class="%2$s" data-id="'. $menu_name .'">%3$s</ul>'
            );
            wp_nav_menu($args);
        ?>
        </nav>
<?php endif; ?>