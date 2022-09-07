<?php
    $location = 'mobile-menu';
    $tbay_location  = '';
    if (has_nav_menu($location)) {
        $tbay_location = $location;
    }

    $menu_attribute         = '';
    $menu_title             = urna_tbay_get_config('menu_mobile_title', 'Menu mobile');

    $search_items           = urna_tbay_get_config('menu_mobile_search_items', 'Search for products');
    $menu_search_category   = urna_tbay_get_config('enable_menu_mobile_search_category', false);

    $menu_third             = urna_tbay_get_config('enable_menu_third', false);
    $menu_third_id          =  urna_tbay_get_config('menu_mobile_third_select');

    $search_enable          = urna_tbay_get_config('enable_menu_mobile_search', false);
    $menu_counters          = urna_tbay_get_config('enable_menu_mobile_counters', false);

    $menu_second            = urna_tbay_get_config('enable_menu_second', false);

    $enable_search_menu = false;
    if ($search_enable ||  $menu_third) {
        $enable_search_menu = true;
    }


    $menu_mobile_themes            = urna_tbay_get_config('menu_mobile_themes', 'light');
    $menu_attribute                .= 'data-themes="' . $menu_mobile_themes . '" ';

    /*Socials*/
    $enable_menu_social           = urna_tbay_get_config('enable_menu_social', false);
    if ($enable_menu_social) {
        $social_slides            = urna_tbay_get_config('menu_social_slides');


        $social_array = array();

        if (count($social_slides) == 1 && empty($social_slides['0']['title']) && empty($social_slides['0']['url'])) {
            $menu_attribute           .= 'data-enablesocial="false" ';
        } else {
            $menu_attribute           .= 'data-enablesocial="' . $enable_menu_social . '" ';
            foreach ($social_slides as $index => $val) {
                $social_array[$index]['icon']     =   $val['title'];
                $social_array[$index]['url']      =   $val['url'];
            }

            $social_json = str_replace('"', "'", json_encode($social_array));

            $menu_attribute         .= 'data-socialjsons="' . $social_json . '" ';
        }
    }

    /*tabs icon*/
    if ($menu_second) {
        $menu_second_id         =  urna_tbay_get_config('menu_mobile_second_select');

        $menu_tab_one           = urna_tbay_get_config('menu_mobile_tab_one', 'Menu');
        $menu_tab_one_icon      = urna_tbay_get_config('menu_mobile_tab_one_icon', 'fa fa-bars');

        $menu_tab_second        = urna_tbay_get_config('menu_mobile_tab_scond', 'Categories');
        $menu_tab_second_icon   = urna_tbay_get_config('menu_mobile_tab_second_icon', 'fa fa-th');


        $menu_attribute         .= 'data-enabletabs="' . $menu_second . '" ';


        $menu_attribute         .= 'data-tabone="' . $menu_tab_one . '" ';
        $menu_attribute         .= 'data-taboneicon="' . $menu_tab_one_icon . '" ';

        $menu_attribute         .= 'data-tabsecond="' . $menu_tab_second . '" ';
        $menu_attribute         .= 'data-tabsecondicon="' . $menu_tab_second_icon . '" ';
    }

    /*Effect */
    $enable_effects            = urna_tbay_get_config('enable_menu_mobile_effects', false);
    $menu_attribute           .= 'data-enableeffects="' . $enable_effects . '" ';

    if ($enable_effects) {
        $effects_panels        =  urna_tbay_get_config('menu_mobile_effects_panels', '');
        $effects_listitems     =  urna_tbay_get_config('menu_mobile_effects_listitems', '');

        $menu_attribute         .= 'data-effectspanels="' . $effects_panels . '" ';
        $menu_attribute         .= 'data-effectslistitems="' . $effects_listitems . '" ';
    }


    $menu_attribute         .= 'data-counters="' . $menu_counters . '" ';
    $menu_attribute         .= 'data-title="' . $menu_title . '" ';
    $menu_attribute         .= 'data-enablesearch="' . $enable_search_menu . '" ';

    $menu_one_id    =  urna_tbay_get_config('menu_mobile_one_select');

?>
  
<div id="tbay-mobile-smartmenu" <?php echo trim($menu_attribute); ?> class="tbay-mmenu hidden-lg hidden-md"> 

    <?php if ($enable_search_menu) : ?>
        <div id="mm-searchfield" class="mm-searchfield__input">

            <?php if ($search_enable) : ?>
            <div class="mobile-menu-search">
                <?php
                    urna_tbay_get_page_templates_parts('device/productsearchform', 'mobileinmenu');
                ?>
            </div>
            <?php endif; ?>

            <?php if (isset($menu_third) && $menu_third) : ?>
            <div class="mmenu-account">
                <?php 
                    $args_third = array(
                        'menu'          => $menu_third_id,
                        'fallback_cb'   => '__return_empty_string',
                    );

                    $menu_third_name = $menu_third_id;
                    if( !empty($menu_third_id) ) {
                        $menu_third_obj = wp_get_nav_menu_object($menu_third_id);
                        $menu_third_name = $menu_third_obj->slug;
                    }

                    $args_third['container_id']       =   'mobile-menu-third-mmenu';
                    $args_third['items_wrap']         =   '<ul id="%1$s" class="%2$s" data-id="'. $menu_third_name .'">%3$s</ul>';
                    $args_third['menu_id']            =   'main-mobile-third-mmenu-wrapper';
                    $args_third['walker']             =   new Urna_Tbay_mmenu_menu();
               

                    wp_nav_menu($args_third);
                ?>
            </div>
            <?php endif; ?>

        </div>

    <?php endif; ?>

    <div class="tbay-offcanvas-body">

        <nav id="tbay-mobile-menu-navbar" class="menu navbar navbar-offcanvas navbar-static">
        <?php
            $args = array( 
                'fallback_cb' => '__return_empty_string'
            );

            if ( empty($menu_one_id) ) {
                $locations  = get_nav_menu_locations();
                $menu_id    = $locations[ $tbay_location ] ;
                $menu_obj   = wp_get_nav_menu_object( $menu_id );

                $args['theme_location']     = $tbay_location;
            } else {
                $menu_obj = wp_get_nav_menu_object($menu_one_id);

                $args['menu']               = $menu_one_id;
            }

            $menu_name = urna_get_transliterate($menu_obj->slug);

            $args['container_id']       =   'main-mobile-menu-mmenu';
            $args['items_wrap']         =   '<ul id="%1$s" class="%2$s" data-id="'. $menu_name .'">%3$s</ul>';
            $args['menu_id']            =   'main-mobile-menu-mmenu-wrapper';
            $args['walker']             =   new Urna_Tbay_mmenu_menu();

            wp_nav_menu($args);

            if( isset($menu_second) && $menu_second ) {

                $args_second = array(
                    'menu'    => $menu_second_id,
                );

                $menu_second_name = $menu_second_id;
                if( !empty($menu_second_id) ) {
                    $menu_second_obj = wp_get_nav_menu_object($menu_second_id);
                    $menu_second_name = $menu_second_obj->slug;
                }

                $args_second['container_id']       =   'mobile-menu-second-mmenu';
                $args_second['menu_id']            =   'main-mobile-second-mmenu-wrapper';
                $args_second['items_wrap']         =   '<ul id="%1$s" class="%2$s" data-id="'. $menu_second_name .'">%3$s</ul>';
                $args_second['walker']             =   new Urna_Tbay_mmenu_menu();


                wp_nav_menu($args_second);

            }


            ?>
        </nav>


    </div>
</div>