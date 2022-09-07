<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Urna_Elementor_Addons
{
    public function __construct()
    {
        $this->include_control_customize_widgets();
        $this->include_render_customize_widgets();

        add_action('elementor/elements/categories_registered', array( $this, 'add_category' ));

        add_action('elementor/widgets/widgets_registered', array( $this, 'include_widgets' ));

        add_action('wp', [ $this, 'regeister_scripts_frontend' ]);

        // editor
        add_action('elementor/editor/after_register_scripts', [ $this, 'editor_after_register_scripts' ]);

        // frontend
        // Register widget scripts
        add_action('elementor/frontend/after_register_scripts', [ $this, 'frontend_after_register_scripts' ]);
        add_action('elementor/frontend/after_enqueue_scripts', [ $this, 'frontend_after_enqueue_scripts' ]);
        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_editor_icons'], 99);

    
        add_action('widgets_init', array( $this, 'register_wp_widgets' ));

        add_action('after_switch_theme', array( $this, 'add_cpt_support'), 10);
    }
   
    public function add_cpt_support()
    {
        $cpt_support = ['tbay_megamenu', 'tbay_footer', 'tbay_header', 'post', 'page', 'product'];
        update_option('elementor_cpt_support', $cpt_support);

        update_option('elementor_disable_color_schemes', 'yes');
        update_option('elementor_disable_typography_schemes', 'yes');
        update_option('elementor_container_width', '1200');
        update_option('elementor_viewport_lg', '1200');
        update_option('elementor_space_between_widgets', '0');
        update_option('elementor_load_fa4_shim', 'yes');
    }


    public function editor_after_register_scripts()
    {
        $suffix = (urna_tbay_get_config('minified_js', false)) ? '.min' : URNA_MIN_JS;

        wp_enqueue_script('waypoints', URNA_SCRIPTS . '/jquery.waypoints' . $suffix . '.js', array(), '4.0.0', true);

        /*slick jquery*/
        wp_register_script('slick', URNA_SCRIPTS . '/slick' . $suffix . '.js', array( 'jquery' ), '1.0.0', true);
        wp_register_script('urna-slick', URNA_SCRIPTS . '/custom-slick' . $suffix . '.js', array( 'jquery' ), URNA_THEME_VERSION, true);

        wp_register_script('jquery-countdowntimer', URNA_SCRIPTS . '/jquery.countdownTimer' . $suffix . '.js', array( 'jquery' ), '20150315', true);
    
        wp_enqueue_script('bootstrap', URNA_SCRIPTS . '/bootstrap' . $suffix . '.js', array( 'jquery' ), '3.3.7', true);
        wp_register_script('urna-script', URNA_SCRIPTS . '/functions' . $suffix . '.js', array('bootstrap'), URNA_THEME_VERSION, true);
    }

    public function frontend_after_enqueue_scripts()
    {
    }

    public function enqueue_editor_icons()
    {
        wp_enqueue_style('linearicons', URNA_STYLES . '/linearicons.css', array(), '1.0.0');
        wp_enqueue_style('simple-line-icons', URNA_STYLES . '/simple-line-icons.css', array(), '2.4.0');
        wp_enqueue_style('material-design-iconic-font', URNA_STYLES . '/material-design-iconic-font.css', false, '2.2.0');
        Elementor\Icons_Manager::enqueue_shim();
    }


    /**
     * @internal Used as a callback
     */
    public function frontend_after_register_scripts()
    {
        $this->editor_after_register_scripts();
    }


    public function register_wp_widgets()
    {
    }

    public function regeister_scripts_frontend()
    {
    }


    public function add_category()
    {
        Elementor\Plugin::instance()->elements_manager->add_category(
            'urna-elements',
            array(
                'title' => esc_html__('Urna Elements', 'urna'),
                'icon'  => 'fa fa-plug',
            ),
            1
        );

        Elementor\Plugin::instance()->elements_manager->add_category(
            'urna-header',
            array(
                'title' => esc_html__('Urna Header', 'urna'),
                'icon'  => 'fa fa-plug',
            ),
            1
        );
    }

    /**
     * @param $widgets_manager Elementor\Widgets_Manager
     */
    public function include_widgets($widgets_manager)
    {
        $this->include_abstract_widgets($widgets_manager);
        $this->include_general_widgets($widgets_manager);
        $this->include_header_widgets($widgets_manager);
        $this->include_woocommerce_widgets($widgets_manager);

        $this->include_skins_widgets($widgets_manager);
    }


    /**
     * Widgets General Theme
     */
    public function include_general_widgets($widgets_manager)
    {
        $elements = array(
            'video',
            'custom-menu',
            'template',
            'heading',
            'features',
            'banner',
            'brands',
            'posts-grid',
            'our-team',
            'testimonials',
            'list-menu',
            'social-icons',
        );

        if (class_exists('MC4WP_MailChimp')) {
            array_push($elements, 'newsletter');
        }


        $elements = apply_filters('urna_general_elements_array', $elements);

        foreach ($elements as $file) {
            $path   = URNA_ELEMENTOR .'/elements/general/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }

    /**
     * Widgets Header Theme
     */
    public function include_header_widgets($widgets_manager)
    {
        if (!urna_is_Woocommerce_activated()) {
            return;
        }

        $elements = array(
            'site-logo',
            'nav-menu',
            'account',
            'search-form',
            'mini-cart',
            'banner-close',
            'header-flash-sales',
            'header-recently-viewed',
            'canvas-menu-template',
        );

        if (class_exists('WOOCS_STARTER')) {
            array_push($elements, 'currency');
        }

        if (class_exists('YITH_WCWL')) {
            array_push($elements, 'wishlist');
        }

        if (class_exists('YITH_Woocompare')) {
            array_push($elements, 'compare');
        }

        if (defined('TBAY_ELEMENTOR_DEMO')) {
            array_push($elements, 'custom-language');
        }

        $elements = apply_filters('urna_header_elements_array', $elements);

        foreach ($elements as $file) {
            $path   = URNA_ELEMENTOR .'/elements/header/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }


    /**
     * Widgets WooComerce Theme
     */
    public function include_woocommerce_widgets($widgets_manager)
    {
        if (!urna_is_Woocommerce_activated()) {
            return;
        }

        $woo_elements = array(
            'products',
            'product-category',
            'product-tabs',
            'woocommerce-tags',
            'product-categories-tabs',
            'list-categories-product',
            'custom-image-list-categories',
            'product-count-down',
            'custom-image-list-tags',
            'product-recently-viewed',
            'product-flash-sales',
        );


        $woo_elements = apply_filters('urna_woocommerce_elements_array', $woo_elements);

        foreach ($woo_elements as $file) {
            $path   = URNA_ELEMENTOR .'/elements/woocommerce/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }


    /**
     * Widgets General Theme
     */
    public function include_skins_widgets($widgets_manager)
    {
        $active_theme = urna_tbay_get_theme();

        $widget_skin   = URNA_ELEMENTOR .'/elements/skins/'. $active_theme .'.php';
        if (file_exists($widget_skin)) {
            require_once $widget_skin;
        }

        if ($active_theme === 'technology-v3') {
            $path   = URNA_ELEMENTOR .'/elements/woocommerce/categories-tabs-with-banner.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }

        if ($active_theme === 'home-landing') {
            $path   = URNA_ELEMENTOR .'/elements/header/search-canvas.php';
            $path1   = URNA_ELEMENTOR .'/elements/general/number-title.php';
            if (file_exists($path)) {
                require_once $path; 
            }
            if (file_exists($path1)) {
                require_once $path1;  
            }
        }

        if ($active_theme === 'sportwear') {
            $path   = URNA_ELEMENTOR .'/elements/general/top-notification.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }

        if ($active_theme === 'book') {
            $path   = URNA_ELEMENTOR .'/elements/woocommerce/products-banner-menu.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }

    /**
     * Widgets Abstract Theme
     */
    public function include_abstract_widgets($widgets_manager)
    {
        $abstracts = array(
            'image',
            'base',
            'responsive',
            'carousel',
        );

        $abstracts = apply_filters('urna_abstract_elements_array', $abstracts);

        foreach ($abstracts as $file) {
            $path   = URNA_ELEMENTOR .'/abstract/' . $file . '.php';
            if (file_exists($path)) {
                require_once $path;
            }
        }
    }

    public function include_control_customize_widgets()
    {
        $widgets = array(
            'sticky-header',
            'column',
            'column-border',
            'section-stretch-row',
            'settings-layout',
        );

        $widgets = apply_filters('urna_customize_elements_array', $widgets);
 
        foreach ($widgets as $file) {
            $control   = URNA_ELEMENTOR .'/elements/customize/controls/' . $file . '.php';
            if (file_exists($control)) {
                require_once $control;
            }
        }
    }

    public function include_render_customize_widgets()
    {
        $widgets = array(
            'sticky-header',
            'column-border',
        );

        $widgets = apply_filters('urna_customize_elements_array', $widgets);
 
        foreach ($widgets as $file) {
            $render    = URNA_ELEMENTOR .'/elements/customize/render/' . $file . '.php';
            if (file_exists($render)) {
                require_once $render;
            }
        }
    }
}

new Urna_Elementor_Addons();
