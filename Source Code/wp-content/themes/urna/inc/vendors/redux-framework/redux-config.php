<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if (defined('URNA_CORE_ACTIVED') && !URNA_CORE_ACTIVED) {
    return;
}

if (!class_exists('Urna_Redux_Framework_Config')) {
    class Urna_Redux_Framework_Config
    {
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;
        public $output;
        public $default_color;
        public $default_fonts;

        public function __construct()
        {
            if (!class_exists('ReduxFramework')) {
                return;
            }

            add_action('init', array($this, 'initSettings'), 10);
        }

        public function redux_output()
        {
            $this->output = require_once(get_parent_theme_file_path(URNA_INC . '/skins/'.urna_tbay_get_theme().'/output.php'));
        }

        public function redux_default_color()
        {
            $this->default_color = urna_tbay_default_theme_primary_color();
        }
        public function redux_default_fonts()
        {
            $this->default_fonts = urna_tbay_default_theme_primary_fonts();
        }

        public function initSettings()
        {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            //Create output
            $this->redux_output();

            //Create default color all skins
            $this->redux_default_color();

            //Create default font all skins
            $this->redux_default_fonts();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        public function urna_select_header() {
            $skin = urna_tbay_get_theme(); 
            $header_layouts = urna_tbay_get_header_layouts();
            if ($skin !== 'home-landing') {
                $value = array(
                    array(
                        'id'       => 'select-header-page',
                        'type'     => 'button_set',
                        'title'    => esc_html__('Select Header Page', 'urna'),
                        'subtitle' => esc_html__('Currently, we only support the Header Builder Elementor', 'urna'),
                        'options'  => array(
                            'builder' => 'Header builder',
                            'default' => 'Header default',
                        ),
                        'default'  => 'default'
                    ),
                    array(
                        'id' => 'header_type',
                        'type' => 'select',
                        'title' => esc_html__('Select Header Layout', 'urna'),
                        'options' => $header_layouts,
                        'required' => array('select-header-page','=','builder'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'media-logo',
                        'type' => 'media',
                        'title' => esc_html__('Upload Logo', 'urna'),
                        'required' => array('select-header-page','=','default'),
                        'subtitle' => esc_html__('Image File (.png or .gif)', 'urna'),
                    ),
                    array(
                        'id'        => 'logo_img_width',
                        'type'      => 'slider',
                        'title'     => esc_html__('Maximum Logo Width (px)', 'urna'),
                        'required' => array('select-header-page','=','default'),
                        "default"   => 160,
                        "min"       => 100,
                        "step"      => 1,
                        "max"       => 600,
                    ),
                    array(
                        'id'             => 'logo_padding',
                        'type'           => 'spacing',
                        'mode'           => 'padding',
                        'units'          => array('px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Logo Padding', 'urna'),
                        'required' => array('select-header-page','=','default'),
                        'desc'           => esc_html__('Add more spacing around logo.', 'urna'),
                        'default'            => array(
                            'padding-top'     => '',
                            'padding-right'   => '',
                            'padding-bottom'  => '',
                            'padding-left'    => '',
                            'units'          => 'px',
                        ),
                    ),
                    array(
                        'id' => 'keep_header',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Sticky Headers', 'urna'),
                        'required' => array('select-header-page','=','default'),
                        'subtitle' => esc_html__('Fixed header on a webpage when scrolling down and moving about a site', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide',
                        'required' => array(
                            array('select-header-page','=','default'),
                            array('active_theme','=','furniture')
                        )
                    ),
                    array(
                        'id' => 'enable_flash_sale',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Flash Sale', 'urna'),
                        'required' => array(
                            array('select-header-page','=','default'),
                            array('active_theme','=','furniture')
                        ),
                        'default' => false
                    ),
                    array(
                        'id' => 'media_flash_sale',
                        'type' => 'media',
                        'title' => esc_html__('Upload Image Flash Sale', 'urna'),
                        'required' => array(
                            array('select-header-page','=','default'),
                            array('enable_flash_sale','equals', true)
                        ),
                        'subtitle' => esc_html__('Image File (.png or .gif)', 'urna'),
                    ),
                    array(
                        'id'       => 'flash_sale_select',
                        'type'     => 'select',
                        'data'     => 'pages',
                        'title'    => esc_html__('Page Flash Sales', 'urna'),
                        'subtitle' => esc_html__('Link to page Flash Sales', 'urna'),
                        'required' => array(
                            array('select-header-page','=','default'),
                            array('enable_flash_sale','equals', true)
                        )
                    ),
                    array(
                        'id' => 'enable_ajax_toggle_menu',
                        'type' => 'switch', 
                        'title' => esc_html__('Enable Ajax Toggle Menu', 'urna'),
                        'required' => array(
                            array('select-header-page','=','default'),
                        ),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_ajax_canvas_menu',
                        'type' => 'switch', 
                        'title' => esc_html__('Enable Ajax Canvas Menu', 'urna'),
                        'required' => array(
                            array('select-header-page','=','default'),
                        ),
                        'default' => false
                    ),
                );
            } else {
                $value = array(
                    array (
                        'id' => 'header_type',
                        'type' => 'select',
                        'title' => esc_html__('Select Header Layout', 'urna'),
                        'options' => $header_layouts,
                        'default' => ''
                    )
                ); 
            }
            return $value;
        }

        public function setSections()
        {
            global $wp_registered_sidebars;
            $sidebars = array();

            $output = $this->output;

            $default_color = $this->default_color;
            
            $default_fonts = $this->default_fonts;

            if (!empty($wp_registered_sidebars)) {
                foreach ($wp_registered_sidebars as $sidebar) {
                    $sidebars[$sidebar['id']] = $sidebar['name'];
                }
            }
            $columns = array(
                ''  => esc_html__('Default', 'urna'),
                '1' => esc_html__('1 Column', 'urna'),
                '2' => esc_html__('2 Columns', 'urna'),
                '3' => esc_html__('3 Columns', 'urna'),
                '4' => esc_html__('4 Columns', 'urna'),
                '5' => esc_html__('5 Columns', 'urna'),
                '6' => esc_html__('6 Columns', 'urna')
            );

            $blog_image_size = array(
                'thumbnail'         => esc_html__('Thumbnail', 'urna'),
                'medium'            => esc_html__('Medium', 'urna'),
                'large'             => esc_html__('Large', 'urna'),
                'full'              => esc_html__('Full', 'urna'),
            );

          
            // General Settings Tab
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-settings',
                'title' => esc_html__('General', 'urna'),
                'fields' => array(
                    array(
                        'id'        => 'active_theme',
                        'type'      => 'image_select',
                        'compiler'  => true,
                        'class'     => 'image-large active_skins',
                        'title'     => esc_html__('Activated Skin', 'urna'),
                        'options'   => urna_tbay_get_themes(),
                        'default'   => 'furniture'
                    ),
                    
                    array(
                        'id'        => 'preload',
                        'type'      => 'switch',
                        'title'     => esc_html__('Preload Website', 'urna'),
                        'default'   => false
                    ),
                    array(
                        'id' => 'select_preloader',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Select Preloader', 'urna'),
                        'subtitle' => esc_html__('Choose a Preloader for your website.', 'urna'),
                        'required'  => array('preload','=',true),
                        'options' => array(
                            'loader1' => array(
                                'title' => esc_html__('Loader 1', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/preloader/loader1.png'
                            ),
                            'loader2' => array(
                                'title' => esc_html__('Loader 2', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/preloader/loader2.png'
                            ),
                            'loader3' => array(
                                'title' => esc_html__('Loader 3', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/preloader/loader3.png'
                            ),
                            'loader4' => array(
                                'title' => esc_html__('Loader 4', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/preloader/loader4.png'
                            ),
                            'loader5' => array(
                                'title' => esc_html__('Loader 5', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/preloader/loader5.png'
                            ),
                            'loader6' => array(
                                'title' => esc_html__('Loader 6', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/preloader/loader6.png'
                            ),
                            'custom_image' => array(
                                'title' => esc_html__('Custom image', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/preloader/custom_image.png'
                            ),
                        ),
                        'default' => 'loader1'
                    ),
                    array(
                        'id' => 'media-preloader',
                        'type' => 'media',
                        'required' => array('select_preloader','=', 'custom_image'),
                        'title' => esc_html__('Upload preloader image', 'urna'),
                        'subtitle' => esc_html__('Image File (.gif)', 'urna'),
                        'desc' =>   sprintf(wp_kses(__('You can download some the Gif images <a target="_blank" href="%1$s">here</a>.', 'urna'), array(  'a' => array( 'href' => array(), 'target' => array() ) )), 'https://loading.io/'),
                    ),
                    array(
                        'id'            => 'config_media',
                        'type'          => 'switch',
                        'title'         => esc_html__('Enable Config Image Size', 'urna'),
                        'subtitle'      => esc_html__('Config image size in WooCommerce and Media Setting', 'urna'),
                        'default'       => false
                    ),
                    array(
                        'id' => 'ajax_dropdown_megamenu',
                        'type' => 'switch',
                        'title' => esc_html__('Enable "Ajax Dropdown" Mega Menu', 'urna'),
                        'default' => false,
                    ),
                )
            );
            // Header
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-view-web',
                'title' => esc_html__('Header', 'urna'),
            );

            // Header
            $this->sections[] = array(
                'title' => esc_html__('Header Configuration', 'urna'),
                'subsection' => true,
                'fields' => $this-> urna_select_header(),
            );

            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Search Form', 'urna'),
                'fields' => array(
                    array(
                        'id'=>'show_searchform',
                        'type' => 'switch',
                        'title' => esc_html__('Search Form', 'urna'),
                        'required' => array('select-header-page','=','default'),
                        'default' => true
                    ),
                    array(
                        'id'=>'search_type',
                        'type' => 'button_set',
                        'title' => esc_html__('Search Result', 'urna'),
                        'required' => array('show_searchform','equals',true),
                        'options' => array(
                            'post' => esc_html__('Post', 'urna'),
                            'product' => esc_html__('Product', 'urna')
                        ),
                        'default' => 'product'
                    ),
                    array(
                        'id'=> 'search_in_options',
                        'type' => 'radio',
                        'title' => esc_html__('Search In', 'urna'),
                        'required' => array('search_type', 'equals', 'product'),
                        'options' => array(
                            'only_title' => esc_html__('Only Title', 'urna'),
                            'all' => esc_html__('All (Title, Content, Sku)', 'urna'),
                        ),
                        'default' => 'only_title'
                    ),
                    array(
                        'id' => 'autocomplete_search',
                        'type' => 'switch',
                        'title' => esc_html__('Auto-complete Search?', 'urna'),
                        'required' => array('show_searchform','equals',true),
                        'default' => 1
                    ),
                    array(
                        'id'       => 'search_placeholder',
                        'type'     => 'text',
                        'required' => array('show_searchform','equals',true),
                        'title'    => esc_html__('Placeholder Text', 'urna'),
                        'default'  => esc_html__('I&rsquo;m shopping for...', 'urna'),
                    ),
                    array(
                        'id'=>'search_category',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Search in Categories', 'urna'),
                        'required' => array(array('search_type', 'equals', array('post', 'product')), array('autocomplete_search', '=', '1') ),
                        'default' => false,
                    ),
                    array(
                        'id'       => 'search_count_categories',
                        'type'     => 'switch',
                        'required' => array('search_category','=',true),
                        'title'    => esc_html__('Show count in Categories', 'urna'),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'search_text_categories',
                        'type'     => 'text',
                        'required' => array('search_category','=',true),
                        'title'    => esc_html__('Search in Categories Text', 'urna'),
                        'default'  => esc_html__('All categories', 'urna'),
                    ),
                    array(
                        'id' => 'show_search_product_image',
                        'type' => 'switch',
                        'title' => esc_html__('Show Image of Search Result', 'urna'),
                        'required' => array('autocomplete_search', '=', '1'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'show_search_product_price',
                        'type' => 'switch',
                        'title' => esc_html__('Show Price of Search Result', 'urna'),
                        'required' => array(array('autocomplete_search', '=', '1'), array('search_type', '=', 'product')),
                        'default' => true
                    ),
                    array(
                        'id'=>'button_search',
                        'type' => 'button_set',
                        'required' => array('show_searchform','equals',true),
                        'title' => esc_html__('Button Search', 'urna'),
                        'default' => 'icon',
                        'options' => array(
                            'all' => esc_html__('All', 'urna'),
                            'text' => esc_html__('Text', 'urna'),
                            'icon' => esc_html__('Icon', 'urna')
                        ),
                    ),
                    array(
                        'id'       => 'button_search_text',
                        'type'     => 'text',
                        'required' => array('show_searchform','equals',true),
                        'title'    => esc_html__('Button Search Text', 'urna'),
                        'default'  => esc_html__('Search', 'urna'),
                        'required' => array('button_search', '!=', 'icon'),
                    ),
                    array(
                        'id'       => 'button_search_icon',
                        'type'     => 'text',
                        'title'    => esc_html__('Button Search Icon', 'urna'),
                        'default'  => esc_html__('Search', 'urna'),
                        'required' => array('button_search', '!=', 'text'),
                        'desc'     => esc_html__('Enter icon name of font: awesome, simplelineicons, linearicons', 'urna') . '</br>' . '<a href="//docs.thembay.com/urna/" target="_blank">How to use?</a>',
                        'default'  => 'linear-icon-magnifier',
                    ),
                    array(
                        'id' => 'search_min_chars',
                        'type'  => 'slider',
                        'title' => esc_html__('Search Min Characters', 'urna'),
                        'required' => array('autocomplete_search', '=', '1'),
                        'default' => 2,
                        'min'   => 1,
                        'step'  => 1,
                        'max'   => 6,
                    ),
                    array(
                        'id' => 'search_max_number_results',
                         'type'  => 'slider',
                        'title' => esc_html__('Max Number of Search Results', 'urna'),
                        'desc'  => esc_html__('Number of search results in desktop', 'urna'),
                        'required' => array('autocomplete_search', '=', '1'),
                        'default' => 5,
                        'min'   => 2,
                        'step'  => 1,
                        'max'   => 10,
                    ),
                )
            );

            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Login', 'urna'),
                'fields' => array(
                    array(
                        'id'=>'show_login',
                        'type' => 'switch',
                        'title' => esc_html__('Show login', 'urna'),
                        'required' => array('select-header-page','=','default'),
                        'default' => true
                    ),
                    array(
                        'id'=>'show_login_popup',
                        'type' => 'switch',
                        'title' => esc_html__('Show login popup', 'urna'),
                        'required' => array('show_login','=', true),
                        'default' => true
                    ),
                    array(
                        'id'       => 'menu_after_login',
                        'type'     => 'select',
                        'data'     => 'menus',
                        'required' => array('show_login','=', true),
                        'title'    => esc_html__('Select Login Menu', 'urna'),
                        'desc'     => esc_html__('Select the menu that appears after login.', 'urna'),
                        'default' => 73
                    ),
                )
            );
            //Wishlist settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Wishlist', 'urna'),
                'fields' => array(
                    array(
                        'id'       => 'woo_wishlist_icon',
                        'type'     => 'text',
                        'title'    => esc_html__('Wishlist Icon', 'urna'),
                        'required' => array('select-header-page','=','default'),
                        'desc'       => esc_html__('Enter icon name of fonts: ', 'urna') . '<a href="//fontawesome.com/v4.7.0/" target="_blank">Awesome</a> , <a href="//fonts.thembay.com/simple-line-icons//" target="_blank">simplelineicons</a>, <a href="//fonts.thembay.com/linearicons/" target="_blank">linearicons</a>',
                        'default'  => 'linear-icon-heart',
                    ),
                    array(
                        'id'        => 'enable_woo_wishlist_text',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show "Wishlist" Title', 'urna'),
                        'required' => array('select-header-page','=','default'),
                        'default'   => false
                    ),
                    array(
                        'id'       => 'woo_wishlist_text',
                        'type'     => 'text',
                        'title'    => esc_html__('Custom "Wishlist" Title', 'urna'),
                        'required' => array('enable_woo_wishlist_text','=', true),
                        'default'  => esc_html__('My Wishlist', 'urna'),
                    ),
                )
            );
            // Footer
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-border-bottom',
                'title' => esc_html__('Footer', 'urna'),
                'fields' => array(
                    array(
                        'id' => 'footer_type',
                        'type' => 'select',
                        'title' => esc_html__('Select Footer Layout', 'urna'),
                        'options' => urna_tbay_get_footer_layouts(),
                        'default' => 'footer-2'
                    ),
                    array(
                        'id' => 'copyright_text',
                        'type' => 'editor',
                        'title' => esc_html__('Copyright Text', 'urna'),
                        'default' => '<p>Copyright  &#64; 2018 Urna Designed by ThemBay. All Rights Reserved.</p>',
                        'required' => array('footer_type','=','')
                    ),
                    array(
                        'id' => 'back_to_top',
                        'type' => 'switch',
                        'title' => esc_html__('Enable "Back to Top" Button', 'urna'),
                        'default' => true,
                    ),
                )
            );



            // Mobile
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-smartphone-iphone',
                'title' => esc_html__('Mobile', 'urna'),
            );

            // Mobile Header settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Header', 'urna'),
                'fields' => array(
                    array(
                        'id'       => 'header_mobile',
                        'type'     => 'image_select',
                        'title'    => esc_html__('Select Header Layout', 'urna'),
                        'class'     => 'image-two',
                        'options'  => array(
                            'v1' => array(
                                'title' => 'Header v1',
                                'img' => URNA_ASSETS_IMAGES . '/mobile/mobile_header_v1.jpg',
                            ),
                        ),
                        'default' => 'v1',
                    ),
                    array(
                        'id' => 'mobile_header_search',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Search on Header', 'urna'),
                        'required' => array('header_mobile','=', 'v1'),
                        'default' => false
                    ),
                    array(
                        'id' => 'mobile-logo',
                        'type' => 'media',
                        'title' => esc_html__('Upload Logo', 'urna'),
                        'subtitle' => esc_html__('Image File (.png or .gif)', 'urna'),
                    ),
                    array(
                        'id'        => 'logo_img_width_mobile',
                        'type'      => 'slider',
                        'title'     => esc_html__('Logo maximum width (px)', 'urna'),
                        "default"   => 69,
                        "min"       => 50,
                        "step"      => 1,
                        "max"       => 600,
                    ),
                    array(
                        'id'             => 'logo_mobile_padding',
                        'type'           => 'spacing',
                        'mode'           => 'padding',
                        'units'          => array('px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Logo Padding', 'urna'),
                        'desc'           => esc_html__('Add more spacing around logo.', 'urna'),
                        'default'            => array(
                            'padding-top'     => '',
                            'padding-right'   => '',
                            'padding-bottom'  => '',
                            'padding-left'    => '',
                            'units'          => 'px',
                        ),
                    ),
                    array(
                        'id'        => 'always_display_logo',
                        'type'      => 'switch',
                        'title'     => esc_html__('Always Display Logo', 'urna'),
                        'subtitle'      => esc_html__('Logo displays on all pages (page title is disabled)', 'urna'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'menu_mobile_all_page',
                        'type'      => 'switch',
                        'title'     => esc_html__('Always Display Menu', 'urna'),
                        'subtitle'      => esc_html__('Menu displays on all pages (Button Back is disabled)', 'urna'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'hidden_header_el_pro_mobile',
                        'type'      => 'switch',
                        'title'     => esc_html__('Hide Header Elementor Pro', 'urna'),
                        'subtitle'  => esc_html__('Hide Header Elementor Pro on mobile', 'urna'),
                        'default'   => true
                    ),
                )
            );

            // Mobile Footer settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Footer', 'urna'),
                'fields' => array(
                    array(
                        'id' => 'mobile_footer',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Desktop Footer', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'mobile_back_to_top',
                        'type' => 'switch',
                        'title' => esc_html__('Enable "Back to Top" Button', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'mobile_footer_icon',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Mobile Footer', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'mobile_footer_account',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Popup Login Mobile', 'urna'),
                        'required' => array('mobile_footer_icon','=', true),
                        'default' => true
                    ),
                    array(
                        'id' => 'mobile_footer_menu_order',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Menu Order', 'urna'),
                        'required' => array('mobile_footer_icon','=', true),
                        'default' => true
                    ),
                    array(
                        'id'       => 'mobile_footer_menu_order_title',
                        'type'     => 'text',
                        'title'    => esc_html__('Menu Order Title', 'urna'),
                        'required' => array('mobile_footer_menu_order','=', true),
                        'default'  => esc_html__('Order', 'urna'),
                    ),
                    array(
                        'id'       => 'mobile_footer_menu_order_icon',
                        'type'     => 'text',
                        'title'    => esc_html__('Menu Order Icon', 'urna'),
                        'required' => array('mobile_footer_menu_order','=', true),
                        'desc'       => sprintf(
                            wp_kses(
                                __('Enter icon name of fonts: <a href="%s" target="_blank">Awesome</a> and <a href="%s" target="_blank">Materialdesigniconic</a> and <a href="%s" target="_blank">Simplelineicons</a> and <a href="%s" target="_blank">Linearicons</a> .  <a href="%s" target="_blank">How to use?</a> ', 'urna'),
                                array(
                                    'a' => array( 'href' => array() ),
                                )
                            ),
                            '//fontawesome.com/v4.7.0/icons/',
                            '//zavoloklom.github.io/material-design-iconic-font/icons.html',
                            '//fonts.thembay.com/simple-line-icons',
                            '//fonts.thembay.com/linearicons/',
                            '//docs.thembay.com/urna/'
                        ),
                        'default'  => 'linear-icon-pencil4',
                    ),
                    array(
                        'id'       => 'mobile_footer_menu_order_page',
                        'type'     => 'select',
                        'data'     => 'pages',
                        'required' => array('mobile_footer_menu_order','=', true),
                        'title'    => esc_html__('Select Link Page Order Tracking', 'urna'),
                    ),
                )
            );

            // Mobile Search settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Search', 'urna'),
                'fields' => array(
                    array(
                        'id'       => 'mobile_search_placeholder',
                        'type'     => 'text',
                        'title'    => esc_html__('Placeholder', 'urna'),
                        'default'  => esc_html__('Search for products...', 'urna'),
                    ),
                    array(
                        'id' => 'enable_mobile_search_category',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Search in Categories', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'mobile_search_max_number_results',
                        'type'  => 'slider',
                        'title' => esc_html__('Number of Search Results', 'urna'),
                        'desc'  => esc_html__('Max number of results show in Mobile', 'urna'),
                        'default' => 5,
                        'min'   => 2,
                        'step'  => 1,
                        'max'   => 20,
                    ),
                )
            );


            // Menu mobile settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Menu Mobile', 'urna'),
                'fields' => array(
                     array(
                        'id' => 'menu_mobile_themes',
                        'type' => 'button_set',
                        'title' => esc_html__('Display Mode', 'urna'),
                        'options' => array(
                            'theme-light'       => esc_html__('Light', 'urna'),
                            'theme-dark'        => esc_html__('Dark', 'urna'),
                        ),
                        'default' => 'theme-light'
                    ),
                    array(
                        'id' => 'enable_menu_mobile_effects',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Effects', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'menu_mobile_effects_panels',
                        'type' => 'select',
                        'title' => esc_html__('Panels Effect', 'urna'),
                        'required' => array('enable_menu_mobile_effects','=', true),
                        'options' => array(
                            'fx-panels-none'            => esc_html__('No effect', 'urna'),
                            'fx-panels-slide-0'         => esc_html__('Slide 0', 'urna'),
                            'no-effect'                 => esc_html__('Slide 30', 'urna'),
                            'fx-panels-slide-100'       => esc_html__('Slide 100', 'urna'),
                            'fx-panels-slide-up'        => esc_html__('Slide uo', 'urna'),
                            'fx-panels-zoom'            => esc_html__('Zoom', 'urna'),
                        ),
                        'default' => 'no-effect'
                    ),
                    array(
                        'id' => 'menu_mobile_effects_listitems',
                        'type' => 'select',
                        'title' => esc_html__('List Items Effect', 'urna'),
                        'required' => array('enable_menu_mobile_effects','=', true),
                        'options' => array(
                            'no-effect'                          => esc_html__('No effect', 'urna'),
                            'fx-listitems-drop'         => esc_html__('Drop', 'urna'),
                            'fx-listitems-fade'         => esc_html__('Fade', 'urna'),
                            'fx-listitems-slide'        => esc_html__('slide', 'urna'),
                        ),
                        'default' => 'fx-listitems-fade'
                    ),
                    array(
                        'id'       => 'menu_mobile_title',
                        'type'     => 'text',
                        'title'    => esc_html__('Menu Title Text', 'urna'),
                        'default'  => esc_html__('Menu', 'urna'),
                    ),
                    array(
                        'id' => 'enable_menu_mobile_search',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Product Search', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_menu_third',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Top Menu', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id'       => 'menu_mobile_third_select',
                        'type'     => 'select',
                        'data'     => 'menus',
                        'title'    => esc_html__('Select Top Menu', 'urna'),
                        'required' => array('enable_menu_third','=', true),
                        'desc'     => esc_html__('Select the menu you want to display.', 'urna'),
                        'default' => 129
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                    array(
                        'id' => 'enable_menu_mobile_counters',
                        'type' => 'switch',
                        'title' => esc_html__('Main Menu Item Counter', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_menu_social',
                        'type' => 'switch',
                        'title' => esc_html__('Menu Social', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id'          => 'menu_social_slides',
                        'type'        => 'slides',
                        'title'       => esc_html__('Config Icon', 'urna'),
                        'desc'        => esc_html__('This social will store all slides values into a multidimensional array to use into a foreach loop.', 'urna'),
                        'class' => 'remove-upload-slides',
                        'show' => array(
                            'title' => true,
                            'description' => false,
                            'url' => true,
                        ),
                        'required' => array('enable_menu_social','=', true),
                        'placeholder'   => array(
                            'title'      => esc_html__('Enter icon name', 'urna'),
                            'url'       => esc_html__('Link icon', 'urna'),
                        ),
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'menu_mobile_one_select',
                        'type'     => 'select',
                        'data'     => 'menus',
                        'title'    => esc_html__('Main Menu (Tab 01)', 'urna'),
                        'subtitle' => '<em>'.esc_html__('Tab 1 menu option', 'urna').'</em>',
                        'desc'     => esc_html__('Select the menu you want to display.', 'urna'),
                        'default' => 69
                    ),
                    array(
                        'id'       => 'menu_mobile_tab_one',
                        'type'     => 'text',
                        'title'    => esc_html__('Tab 01 Title', 'urna'),
                        'required' => array('enable_menu_second','=', true),
                        'default'  => esc_html__('Menu', 'urna'),
                    ),
                    array(
                        'id'       => 'menu_mobile_tab_one_icon',
                        'type'     => 'text',
                        'title'    => esc_html__('Tab 01 Icon', 'urna'),
                        'required' => array('enable_menu_second','=', true),
                        'desc'       => esc_html__('Enter icon name of fonts: ', 'urna') . '<a href="//fontawesome.com/v4.7.0/" target="_blank">Awesome</a> , <a href="//fonts.thembay.com/simple-line-icons//" target="_blank">simplelineicons</a>, <a href="//fonts.thembay.com/linearicons/" target="_blank">linearicons</a>',
                        'default'  => 'fa fa-bars',
                    ),
                    array(
                        'id' => 'enable_menu_second',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Tab 02', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id'       => 'menu_mobile_tab_scond',
                        'type'     => 'text',
                        'title'    => esc_html__('Tab 02 Title', 'urna'),
                        'required' => array('enable_menu_second','=', true),
                        'default'  => esc_html__('Categories', 'urna'),
                    ),
                    array(
                        'id'       => 'menu_mobile_second_select',
                        'type'     => 'select',
                        'data'     => 'menus',
                        'title'    => esc_html__('Tab 02 Menu Option', 'urna'),
                        'required' => array('enable_menu_second','=', true),
                        'desc'     => esc_html__('Select the menu you want to display.', 'urna'),
                        'default' => 54
                    ),
                    array(
                        'id'       => 'menu_mobile_tab_second_icon',
                        'type'     => 'text',
                        'title'    => esc_html__('Tab 02 Icon', 'urna'),
                        'required' => array('enable_menu_second','=', true),
                        'desc'       => esc_html__('Enter icon name of fonts: ', 'urna') . '<a href="//fontawesome.com/v4.7.0/" target="_blank">Awesome</a> , <a href="//fonts.thembay.com/simple-line-icons//" target="_blank">simplelineicons</a>, <a href="//fonts.thembay.com/linearicons/" target="_blank">linearicons</a>',
                        'default'  => 'icons icon-grid',
                    ),
                )
            );
        

            // Mobile Woocommerce settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Mobile WooCommerce', 'urna'),
                'fields' => array(
                    array(
                        'id' => 'mobile_product_number',
                        'type' => 'image_select',
                        'title' => esc_html__('Product Column in Shop page', 'urna'),
                        'options' => array(
                            'one' => array(
                                'title' => esc_html__('One Column', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/mobile/one_column.jpg'
                            ),
                            'two' => array(
                                'title' => esc_html__('Two Columns', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/mobile/two_columns.jpg'
                            ),
                        ),
                        'default' => 'two'
                    ),
                    array(
                        'id' => 'enable_custom_label_sale',
                        'type' => 'switch',
                        'title' => esc_html__('Custom style "Label Sale" in mobile', 'urna'),
                        'required' => array('active_theme','!=','toy'),
                        'default' => false
                    ),
                    array(
                        'id'        => 'line_height_label_sale',
                        'type'      => 'slider',
                        'title'     => esc_html__('Line Height of "Label Sale"', 'urna'),
                        'required'  => array('enable_custom_label_sale','=', true),
                        'min'       => 10,
                        'max'       => 50,
                        'step'      => 1,
                        'default'   => 33
                    ),
                    array(
                        'id'        => 'min_width_label_sale',
                        'type'      => 'slider',
                        'title'     => esc_html__('Min Width of "Label Sale"', 'urna'),
                        'required'  => array('enable_custom_label_sale','=', true),
                        'min'       => 10,
                        'max'       => 50,
                        'step'      => 1,
                        'default'   => 33
                    ),
                    array(
                        'id' => 'enable_add_cart_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show "Add to Cart" Button', 'urna'),
                        'subtitle' => esc_html__('On Home and page Shop', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_wishlist_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show "Wishlist" Button', 'urna'),
                        'subtitle' => esc_html__('Enable or disable in Home and Shop page', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_one_name_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show Full Product Name', 'urna'),
                        'subtitle' => esc_html__('Enable or disable in Home and Shop page', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_quantity_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show Quantity', 'urna'),
                        'subtitle' => esc_html__('On Page Single Product', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'mobile_form_cart_style',
                        'type' => 'select',
                        'title' => esc_html__('Add To Cart Form Type', 'urna'),
                        'subtitle' => esc_html__('On Page Single Product', 'urna'),
                        'options' => array(
                            'default' => esc_html__('Default', 'urna'),
                            'popup' => esc_html__('Popup', 'urna')
                        ),
                        'default' => 'default'
                    ),
                    array(
                        'id' => 'enable_tabs_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show Sidebar Tabs', 'urna'),
                        'subtitle' => esc_html__('On Page Single Product', 'urna'),
                        'default' => true
                    ),
                )
            );

            // Style
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-format-color-text',
                'title' => esc_html__('Style', 'urna'),
            );

            $this->sections[] = $this->sections_color_main( $default_color );

            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Typography', 'urna'),
                'fields' => array(
                    array(
                        'id' => 'show_typography',
                        'type' => 'switch',
                        'title' => esc_html__('Edit Typography', 'urna'),
                        'default' => false
                    ),
                    array(
                        'title'    => esc_html__('Font Source', 'urna'),
                        'id'       => 'font_source',
                        'type'     => 'radio',
                        'required' => array('show_typography','=', true),
                        'options'  => array(
                            '1' => 'Standard + Google Webfonts',
                            '2' => 'Google Custom',
                            '3' => 'Custom Fonts'
                        ),
                        'default' => '1'
                    ),
                    array(
                        'id'=>'font_google_code',
                        'type' => 'text',
                        'title' => esc_html__('Google Link', 'urna'),
                        'subtitle' => '<em>'.esc_html__('Paste the provided Google Code', 'urna').'</em>',
                        'default' => '',
                        'desc' => esc_html__('e.g.: https://fonts.googleapis.com/css?family=Open+Sans', 'urna'),
                        'required' => array('font_source','=','2')
                    ),

                    array(
                        'id' => 'main_custom_font_info',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;">'. sprintf(
                            '%1$s <a href="%2$s">%3$s</a>',
                            esc_html__('Video guide custom font in ', 'urna'),
                            esc_url('https://www.youtube.com/watch?v=ljXAxueAQUc'),
                            esc_html__('here', 'urna')
                        ) .'</h3>',
                        'required' => array('font_source','=','3')
                    ),

                    array(
                        'id' => 'main_font_info',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;"> '.esc_html__('Main Font', 'urna').'</h3>',
                        'required' => array('show_typography','=', true),
                    ),

                    // Standard + Google Webfonts
                    array(
                        'title' => esc_html__('Font Face', 'urna'),
                        'id' => 'main_font',
                        'type' => 'typography',
                        'line-height' => false,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => false,
                        'all_styles'=> true,
                        'font-size' => false,
                        'color' => false,
                        'default' => array(
                            'font-family' => '',
                            'subsets' => '',
                        ),
                        'required' => array(
                            array('font_source','=','1'),
                            array('show_typography','=', true)
                        )
                    ),
                    
                    // Google Custom
                    array(
                        'title' => esc_html__('Google Font Face', 'urna'),
                        'subtitle' => '<em>'.esc_html__('Enter your Google Font Name for the theme\'s Main Typography', 'urna').'</em>',
                        'desc' => esc_html__('e.g.: &#39;Open Sans&#39;, sans-serif', 'urna'),
                        'id' => 'main_google_font_face',
                        'type' => 'text',
                        'default' => '',
                        'required' => array(
                            array('font_source','=','2'),
                            array('show_typography','=', true)
                        )
                    ),

                    // main Custom fonts
                    array(
                        'title' => esc_html__('Main custom Font Face', 'urna'),
                        'subtitle' => '<em>'.esc_html__('Enter your Custom Font Name for the theme\'s Main Typography', 'urna').'</em>',
                        'desc' => esc_html__('e.g.: &#39;Open Sans&#39;, sans-serif', 'urna'),
                        'id' => 'main_custom_font_face',
                        'type' => 'text',
                        'default' => '',
                        'required' => array(
                            array('font_source','=','3'),
                            array('show_typography','=', true)
                        )
                    ),

                    array(
                        'id' => 'secondary_font_info',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;"> '. esc_html__(' Secondary Font', 'urna').'</h3>',
                        'required' => array(
                            array('show_typography','=', true),
                            array('show_typography','=', $default_fonts['font_second_enable'])
                        )
                    ),
                    
                    // Standard + Google Webfonts
                    array(
                        'title' => esc_html__('Font Face', 'urna'),
                        'id' => 'secondary_font',
                        'type' => 'typography',
                        'line-height' => false,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => false,
                        'all_styles'=> true,
                        'font-size' => false,
                        'color' => false,
                        'default' => array(
                            'font-family' => '',
                            'subsets' => '',
                        ),
                        'required' => array(
                            array('font_source','=','1'),
                            array('show_typography','=', true),
                            array('show_typography','=', $default_fonts['font_second_enable'])
                        )
                        
                    ),
                    
                    // Google Custom
                    array(
                        'title' => esc_html__('Google Font Face', 'urna'),
                        'subtitle' => '<em>'. esc_html__('Enter your Google Font Name for the theme\'s Secondary Typography', 'urna').'</em>',
                        'desc' => esc_html__('e.g.: &#39;Open Sans&#39;, sans-serif', 'urna'),
                        'id' => 'secondary_google_font_face',
                        'type' => 'text',
                        'default' => '',
                        'required' => array(
                            array('font_source','=','2'),
                            array('show_typography','=', true),
                            array('show_typography','=', $default_fonts['font_second_enable'])
                        )
                    ),

                    // Main Custom fonts
                    array(
                        'title' => esc_html__('Main Custom Font Face', 'urna'),
                        'subtitle' => '<em>'. esc_html__('Enter your Custom Font Name for the theme\'s Secondary Typography', 'urna').'</em>',
                        'desc' => esc_html__('e.g.: &#39;Open Sans&#39;, sans-serif', 'urna'),
                        'id' => 'secondary_custom_font_face',
                        'type' => 'text',
                        'default' => '',
                        'required' => array(
                            array('font_source','=','3'),
                            array('show_typography','=', true),
                            array('show_typography','=', $default_fonts['font_second_enable'])
                        )
                    ),
                )
            );

            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Header', 'urna'),
                'fields' => array(
                    array(
                        'id'=>'header_bg',
                        'type' => 'color',
                        'output' => $output['header_bg'],
                        'title' => esc_html__('Background', 'urna'),
                        'transparent' => false,
                        'default' => ''
                    ),
                    array(
                        'title' => esc_html__('Text Color', 'urna'),
                        'id' => 'header_text_color',
                        'output' => $output['header_text_color'],
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color', 'urna'),
                        'id' => 'header_link_color',
                        'output' => $output['header_link_color'],
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color Hover,Active', 'urna'),
                        'id' => 'header_link_color_active',
                        'output' => $output['header_link_color_active'],
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                )
            );

            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Top Bar', 'urna'),
                'fields' => array(
                    array(
                        'id'=>'topbar_bg',
                        'type' => 'color',
                        'output' => $output['topbar_bg'],
                        'title' => esc_html__('Background', 'urna'),
                        'transparent' => false,
                        'required' =>  array('active_theme','=',array('furniture','toy','technology-v1','technology-v2','fashion','fashion-v2','sportwear','beauty','kitchen','book','marketplace-v2')),
                        'default' => ''
                    ),
                    array(
                        'title' => esc_html__('Text Color', 'urna'),
                        'id' => 'topbar_text_color',
                        'type' => 'color',
                        'output' => $output['topbar_text_color'],
                        'transparent' => false,
                        'required' =>  array('active_theme','=',array('furniture','toy','technology-v1','technology-v2','fashion','fashion-v2','sportwear','beauty','kitchen','book','marketplace-v2')),
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color', 'urna'),
                        'id' => 'topbar_link_color',
                        'output' => $output['topbar_link_color'],
                        'type' => 'color',
                        'transparent' => false,
                        'required' =>  array('active_theme','=',array('furniture','toy','technology-v1','technology-v2','fashion','fashion-v2','sportwear','beauty','kitchen','book','marketplace-v2')),
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color Hover', 'urna'),
                        'id' => 'topbar_link_color_hover',
                        'output' => $output['topbar_link_color_hover'],
                        'type' => 'color',
                        'transparent' => false,
                        'required' =>  array('active_theme','=',array('furniture','toy','technology-v1','technology-v2','fashion','fashion-v2','sportwear','beauty','kitchen','book','marketplace-v2')),
                        'default' => '',
                    ),
                )
            );

            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Main Menu', 'urna'),
                'fields' => array(
                    array(
                        'id'=>'main_menu_bg',
                        'type' => 'color',
                        'output' => $output['main_menu_bg'],
                        'title' => esc_html__('Background', 'urna'),
                        'transparent' => false,
                        'required' =>  array('active_theme','!=',array('technology-v3')),
                        'default' => ''
                    ),
                    array(
                        'title' => esc_html__('Link Color', 'urna'),
                        'id' => 'main_menu_link_color',
                        'output' => $output['main_menu_link_color'],
                        'type' => 'color',
                        'transparent' => false,
                        'required' =>  array('active_theme','!=',array('technology-v3')),
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color Active', 'urna'),
                        'id' => 'main_menu_link_color_active',
                        'output' => $output['main_menu_link_color_active'],
                        'type' => 'color',
                        'transparent' => false,
                        'required' =>  array('active_theme','!=',array('technology-v3')),
                        'default' => '',
                    ),
                )
            );

            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Footer', 'urna'),
                'fields' => array(
                    array(
                        'id'=>'footer_bg',
                        'output' => $output['footer_bg'],
                        'type' => 'color',
                        'title' => esc_html__('Background', 'urna'),
                        'transparent' => false,
                        'default' => ''
                    ),
                    array(
                        'title' => esc_html__('Heading Color', 'urna'),
                        'id' => 'footer_heading_color',
                        'output' => $output['footer_heading_color'],
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Text Color', 'urna'),
                        'id' => 'footer_text_color',
                        'output' => $output['footer_text_color'],
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color', 'urna'),
                        'id' => 'footer_link_color',
                        'output' => $output['footer_link_color'],
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color Hover', 'urna'),
                        'id' => 'footer_link_color_hover',
                        'output' => $output['footer_link_color_hover'],
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                )
            );
            
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Copyright', 'urna'),
                'fields' => array(
                    array(
                        'id'=>'copyright_bg',
                        'output' => $output['copyright_bg'],
                        'type' => 'color',
                        'title' => esc_html__('Background', 'urna'),
                        'transparent' => false,
                        'required' =>  array('active_theme','!=',array('bag')),
                        'default' => ''
                    ),
                    array(
                        'title' => esc_html__('Text Color', 'urna'),
                        'id' => 'copyright_text_color',
                        'output' => $output['copyright_text_color'],
                        'type' => 'color',
                        'transparent' => false,
                        'required' =>  array('active_theme','!=',array('bag')),
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color', 'urna'),
                        'id' => 'copyright_link_color',
                        'output' => $output['copyright_link_color'],
                        'type' => 'color',
                        'transparent' => false,
                        'required' =>  array('active_theme','!=',array('bag')),
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Link Color Hover', 'urna'),
                        'id' => 'copyright_link_color_hover',
                        'output' => $output['copyright_link_color_hover'],
                        'type' => 'color',
                        'transparent' => false,
                        'required' =>  array('active_theme','!=',array('bag')),
                        'default' => '',
                    ),
                )
            );


            // WooCommerce
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-shopping-cart',
                'title' => esc_html__('WooCommerce', 'urna'),
                'fields' => array(
                    array(
                        'title'    => esc_html__('Label Sale Format', 'urna'),
                        'id'       => 'sale_tags',
                        'type'     => 'radio',
                        'options'  => array(
                            'Sale!' => esc_html__('Sale!', 'urna'),
                            'Save {percent-diff}%' => esc_html__('Save {percent-diff}% (e.g "Save 50%")', 'urna'),
                            'Save {symbol}{price-diff}' => esc_html__('Save {symbol}{price-diff} (e.g "Save $50")', 'urna'),
                            'custom' => esc_html__('Custom Format (e.g -50%, -$50)', 'urna')
                        ),
                        'default' => 'custom'
                    ),
                    array(
                        'id'        => 'sale_tag_custom',
                        'type'      => 'text',
                        'title'     => esc_html__('Custom Format', 'urna'),
                        'desc'      => esc_html__('{price-diff} inserts the dollar amount off.', 'urna'). '</br>'.
                                       esc_html__('{percent-diff} inserts the percent reduction (rounded).', 'urna'). '</br>'.
                                       esc_html__('{symbol} inserts the Default currency symbol.', 'urna'),
                        'required'  => array('sale_tags','=', 'custom'),
                        'default'   => '-{percent-diff}%'
                    ),
                    array(
                        'id' => 'enable_label_featured',
                        'type' => 'switch',
                        'title' => esc_html__('Enable "Featured" Label', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id'        => 'custom_label_featured',
                        'type'      => 'text',
                        'title'     => esc_html__('"Featured Label" Custom Text', 'urna'),
                        'required'  => array('enable_label_featured','=', true),
                        'default'   => esc_html__('Hot', 'urna')
                    ),
                    array(
                        'id'             => 'sale_border_radius',
                        'type'           => 'spacing',
                        'mode'           => 'padding',
                        'units'          => array( 'em', 'px', '%' ),
                        'units_extended' => 'false',
                        'required' => array('active_theme','!=','toy'),
                        'title'          => esc_html__('Label Border Radius', 'urna'),
                        'default'            => array(
                            'padding-top'     => '50%',
                            'padding-right'   => '50%',
                            'padding-bottom'  => '50%',
                            'padding-left'    => '50%',
                            'units'          => '%',
                        ),
                    ),
                    
                    array(
                        'id' => 'enable_brand',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Brand Name', 'urna'),
                        'subtitle' => esc_html__('Enable/Disable brand name on HomePage and Shop Page', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                    array(
                        'id' => 'product_layout_style',
                        'type' => 'image_select',
                        'title' => esc_html__('Product Styles', 'urna'),
                        'options' => array(
                            'v1' => array(
                                'title' => esc_html__('Default', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v01.gif'
                            ),
                            'v2' => array(
                                'title' => esc_html__('Layout 02', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v02.gif'
                            ),
                            'v3' => array(
                                'title' => esc_html__('Layout 03', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v03.gif'
                            ),
                            'v4' => array(
                                'title' => esc_html__('Layout 04', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v04.gif'
                            ),
                            'v5' => array(
                                'title' => esc_html__('Layout 05', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v05.gif'
                            ),
                            'v6' => array(
                                'title' => esc_html__('Layout 06', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v06.gif'
                            ),
                            'v7' => array(
                                'title' => esc_html__('Layout 07', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v07.gif'
                            ),
                            'v8' => array(
                                'title' => esc_html__('Layout 08', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v08.gif'
                            ),
                            'v9' => array(
                                'title' => esc_html__('Layout 09', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v09.gif'
                            ),
                            'v10' => array(
                                'title' => esc_html__('Layout 10', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v10.gif'
                            ),
                            'v11' => array(
                                'title' => esc_html__('Layout 11', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v11.gif'
                            ),
                            'v12' => array(
                                'title' => esc_html__('Layout 12', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v12.gif'
                            ),
                            'v13' => array(
                                'title' => esc_html__('Layout 13', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v13.gif'
                            ),
                            'v14' => array(
                                'title' => esc_html__('Layout 14', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v14.gif'
                            ),
                            'v15' => array(
                                'title' => esc_html__('Layout 15', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v15.gif'
                            ),
                            'v16' => array(
                                'title' => esc_html__('Layout 16', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_hover/hover-v16.gif'
                            ),
                        ),
                        'default' => 'v1'
                    ),
                    array(
                        'id' => 'product_display_image_mode',
                        'type' => 'image_select',
                        'title' => esc_html__('Product Image Display Mode', 'urna'),
                        'options' => array(
                            'one' => array(
                                'title' => esc_html__('Single Image', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/image_mode/single-image.png'
                            ),
                            'two' => array(
                                'title' => esc_html__('Double Images (Hover)', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/image_mode/display-hover.gif'
                            ),
                            'slider' => array(
                                'title' => esc_html__('Images (carousel)', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/image_mode/display-carousel.gif'
                            ),
                        ),
                        'default' => 'slider'
                    ),
                    array(
                        'id' => 'enable_quickview',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Quick View', 'urna'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'enable_woocommerce_catalog_mode',
                        'type' => 'switch',
                        'title' => esc_html__('Show WooCommerce Catalog Mode', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_woocommerce_quantity_mode',
                        'type' => 'switch',
                        'title' => esc_html__('Enable WooCommerce Quantity Mode', 'urna'),
                        'required' => array('product_layout_style','=',array('v4','v15')),
                        'subtitle' => esc_html__('Enable/Disable show quantity on Home Page and Shop Page', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'ajax_update_quantity',
                        'type' => 'switch',
                        'title' => esc_html__('Quantity Ajax Auto-update', 'urna'),
                        'subtitle' => esc_html__('Enable/Disable quantity ajax auto-update on page Cart', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_variation_swatch',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Product Variation Swatch', 'urna'),
                        'subtitle' => esc_html__('Enable/Disable Product Variation Swatch on HomePage and Shop page', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'variation_swatch',
                        'type' => 'select',
                        'title' => esc_html__('Product Attribute', 'urna'),
                        'options' => urna_tbay_get_variation_swatchs(),
                        'default' => ''
                    ),
                )
            );

            // woocommerce Breadcrumb settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Mini Cart', 'urna'),
                'fields' => array(
                     array(
                        'id' => 'woo_mini_cart_position',
                        'type' => 'select',
                        'title' => esc_html__('Mini-Cart Position', 'urna'),
                        'options' => array(
                            'left'       => esc_html__('Left', 'urna'),
                            'right'      => esc_html__('Right', 'urna'),
                            'popup'      => esc_html__('Popup', 'urna'),
                            'no-popup'   => esc_html__('None Popup', 'urna')
                        ),
                        'default' => 'popup'
                    ),
                    array(
                        'id' => 'show_mini_cart_qty',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Quantity on Mini-Cart', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id'       => 'woo_mini_cart_icon',
                        'required' => array('select-header-page','=','default'),
                        'type'     => 'text',
                        'title'    => esc_html__('Mini-Cart Icon', 'urna'),
                        'desc'       => esc_html__('Enter icon name of fonts: ', 'urna') . '<a href="//fontawesome.com/v4.7.0/" target="_blank">Awesome</a> , <a href="//fonts.thembay.com/simple-line-icons//" target="_blank">simplelineicons</a>, <a href="//fonts.thembay.com/linearicons/" target="_blank">linearicons</a>',
                        'default'  => 'linear-icon-cart',
                    ),
                    array(
                        'id'        => 'enable_woo_mini_cart_text',
                        'required' => array('select-header-page','=','default'),
                        'type'      => 'switch',
                        'title'     => esc_html__('Show "Mini-Cart" Title', 'urna'),
                        'default'   => true,
                        'required' => array(
                            array('active_theme','!=','kidfashion'),
                            array('active_theme','!=','underwear'),
                            array('select-header-page','=','default')
                        )
                    ),
                    array(
                        'id'       => 'woo_mini_cart_text',
                        'type'     => 'text',
                        'title'    => esc_html__('Custom "Mini-Cart" Title', 'urna'),
                        'required' => array('enable_woo_mini_cart_text','=', true),
                        'default'  => esc_html__('Shopping cart', 'urna'),
                    ),
                    array(
                        'id'        => 'enable_woo_mini_cart_price',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show "Mini-Cart" Price', 'urna'),
                        'default'   => true,
                        'required' => array(
                            array('active_theme','!=','kidfashion'),
                            array('active_theme','!=','underwear'),
                            array('select-header-page','=','default')
                        )
                    ),
                )
            );

            // woocommerce Breadcrumb settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Breadcrumb', 'urna'),
                'fields' => array(
                    array(
                        'id' => 'show_product_breadcrumb',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Breadcrumb', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'product_breadcrumb_layout',
                        'type' => 'image_select',
                        'class'     => 'image-two',
                        'compiler' => true,
                        'title' => esc_html__('Breadcrumb Layout', 'urna'),
                        'required' => array('show_product_breadcrumb','=',1),
                        'options' => array(
                            'image' => array(
                                'title' => esc_html__('Background Image', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/breadcrumbs/image.jpg'
                            ),
                            'color' => array(
                                'title' => esc_html__('Background color', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/breadcrumbs/color.jpg'
                            ),
                            'text'=> array(
                                'title' => esc_html__('Text Only', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/breadcrumbs/text_only.jpg'
                            ),
                        ),
                        'default' => 'color'
                    ),
                    array(
                        'title' => esc_html__('Breadcrumb Background Color', 'urna'),
                        'subtitle' => '<em>'.esc_html__('The Breadcrumb background color of the site.', 'urna').'</em>',
                        'id' => 'woo_breadcrumb_color',
                        'required' => array('product_breadcrumb_layout','=',array('default','color')),
                        'type' => 'color',
                        'default' => '#f4f9fc',
                        'transparent' => false,
                    ),
                    array(
                        'id' => 'woo_breadcrumb_image',
                        'type' => 'media',
                        'title' => esc_html__('Breadcrumb Background', 'urna'),
                        'subtitle' => esc_html__('Upload a .jpg or .png image that will be your Breadcrumb.', 'urna'),
                        'required' => array('product_breadcrumb_layout','=','image'),
                        'default'  => array(
                            'url'=> URNA_IMAGES .'/breadcrumbs-woo.jpg'
                        ),
                    ),
                    array(
                        'id' => 'enable_previous_page_woo',
                        'type' => 'switch',
                        'title' => esc_html__('Previous page', 'urna'),
                        'default' => true
                    ),
                )
            );

            // WooCommerce Archive settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Shop', 'urna'),
                'fields' => array(
                    array(
                        'id' => 'product_archive_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Shop Layout', 'urna'),
                        'options' => array(
                            'shop-left' => array(
                                'title' => esc_html__('Left Sidebar', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_archives/shop_left_sidebar.jpg'
                            ),
                            'shop-right' => array(
                                'title' => esc_html__('Right Sidebar', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_archives/shop_right_sidebar.jpg'
                            ),
                            'full-width' => array(
                                'title' => esc_html__('No Sidebar', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_archives/shop_no_sidebar.jpg'
                            ),
                        ),
                        'default' => 'shop-left'
                    ),
                    array(
                        'id' => 'product_archive_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Sidebar', 'urna'),
                        'options' => $sidebars,
                        'default' => 'product-archive'
                    ),
                    array(
                        'id' => 'show_product_top_archive',
                        'type' => 'switch',
                        'title' => esc_html__('Show sidebar Top Archive product', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'product_archive_fullwidth',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Full Width Layout', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_display_mode',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Products Display Mode', 'urna'),
                        'subtitle' => esc_html__('Enable/Disable Display Mode', 'urna'),
                        'required' => array('product_archive_fullwidth', '=', false),
                        'default' => true
                    ),
                    array(
                        'id' => 'product_display_mode',
                        'type' => 'button_set',
                        'title' => esc_html__('Products Display Mode', 'urna'),
                        'required' => array('enable_display_mode','=',1),
                        'options' => array(
                            'grid' => esc_html__('Grid', 'urna'),
                            'grid2' => esc_html__('Grid 02 Columns', 'urna'),
                            'list' => esc_html__('List', 'urna')
                        ),
                        'default' => 'grid'
                    ),
                    array(
                        'id' => 'ajax_filter',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Ajax Filter', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'title_product_archives',
                        'type' => 'switch',
                        'title' => esc_html__('Show Title of Categories', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'pro_des_image_product_archives',
                        'type' => 'switch',
                        'title' => esc_html__('Show Description, Image of Categories', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'number_products_per_page',
                        'type' => 'slider',
                        'title' => esc_html__('Number of Products Per Page', 'urna'),
                        'default' => 12,
                        'min' => 1,
                        'step' => 1,
                        'max' => 100,
                    ),
                    array(
                        'id' => 'product_columns',
                        'type' => 'select',
                        'title' => esc_html__('Product Columns', 'urna'),
                        'options' => $columns,
                        'default' => 3
                    ),
                    array(
                        'id' => 'product_pagination_style',
                        'type' => 'select',
                        'title' => esc_html__('Product Pagination Style', 'urna'),
                        'options' => array(
                            'number' => esc_html__('Pagination Number', 'urna'),
                            'loadmore'  => esc_html__('Load More Button', 'urna'),
                        ),
                        'default' => 'number'
                    ),
                    array(
                        'id' => 'product_type_fillter',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Shop by Product Type', 'urna'),
                        'default' => 0
                    ),
                    array(
                        'id' => 'product_per_page_fillter',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Number of Product', 'urna'),
                        'default' => 0
                    ),
                    array(
                        'id' => 'product_category_fillter',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Shop by Categories', 'urna'),
                        'default' => 0
                    ),
                )
            );
            // Product Page
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Single Product', 'urna'),
                'fields' => array(
                    array(
                        'id' => 'product_single_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Select Single Product Layout', 'urna'),
                        'options' => array(
                            'full-width-vertical' => array(
                                'title' => esc_html__('Image Vertical', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_single/verical_thumbnail.jpg'
                            ),
                            'full-width-horizontal' => array(
                                'title' => esc_html__('Image Horizontal', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_single/horizontal_thumbnail.jpg'
                            ),
                            'full-width-stick' => array(
                                'title' => esc_html__('Image Stick', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_single/image_sticky.jpg'
                            ),
                            'full-width-gallery' => array(
                                'title' => esc_html__('Image gallery', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_single/image_gallery.jpg'
                            ),
                            'full-width-carousel' => array(
                                'title' => esc_html__('Image Carousel', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_single/image_carousel.jpg'
                            ),
                            'full-width-full' => array(
                                'title' => esc_html__('Image Full Width', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_single/full_width.jpg'
                            ),
                            'full-width-centered' => array(
                                'title' => esc_html__('Image Centered', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_single/image_centered.jpg'
                            ),
                            'left-main' => array(
                                'title' => esc_html__('Left - Main Sidebar', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_single/left_main_sidebar.jpg'
                            ),
                            'main-right' => array(
                                'title' => esc_html__('Main - Right Sidebar', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_single/main_right_sidebar.jpg'
                            ),
                        ),
                        'default' => 'full-width-horizontal'
                    ),
                    array(
                        'id' => 'product_single_sidebar_position',
                        'type' => 'image_select',
                        'required' => array('product_single_layout','=', array('left-main', 'main-right') ),
                        'title' => esc_html__('Single Product Layout Mode', 'urna'),
                         'options' => array(
                            'inner-sidebar' => array(
                                'title' => esc_html__('Inner Sidebar', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_single/inner_sidebar.jpg'
                            ),
                            'sidebar' => array(
                                'title' => esc_html__('Normal Sidebar', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/product_single/normal_sidebar.jpg'
                            ),
                        ),
                        'default' => 'inner-sidebar'
                    ),
                    array(
                        'id' => 'product_single_sidebar',
                        'type' => 'select',
                        'required' => array(
                            array('product_single_layout','=', array('left-main', 'main-right') ),
                            array('product_single_sidebar_position','=', array('inner-sidebar') )
                        ),
                        'title' => esc_html__('Single Product Inner Sidebar', 'urna'),
                         'options' => $sidebars,
                        'default' => 'product-sidebar'
                    ),
                    array(
                        'id' => 'product_single_sidebar_normal',
                        'type' => 'select',
                        'required' => array(
                            array('product_single_layout','=', array('left-main', 'main-right') ),
                            array('product_single_sidebar_position','=', array('sidebar') )
                        ),
                        'title' => esc_html__('Single Product Normal Sidebar', 'urna'),
                         'options' => $sidebars,
                        'default' => 'product-single-normal'
                    ),
                )
            );


            // Product Page
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Single Product Advanced Options', 'urna'),
                'fields' => array(
                   array(
                        'id' => 'product_single_fullwidth',
                        'type' => 'switch',
                        'title' => esc_html__('Show Full Width', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_total_sales',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Total Sales', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_buy_now',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Buy Now', 'urna'),
                        'default' => false
                    ),
                    array(
                        'title' => esc_html__('Background', 'urna'),
                        'subtitle' => esc_html__('Background button Buy Now', 'urna'),
                        'id' => 'bg_buy_now',
                        'required' => array('enable_buy_now','=',true),
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '',
                    ),
                    array(
                        'id' => 'redirect_buy_now',
                        'required' => array('enable_buy_now','=',true),
                        'type' => 'button_set',
                        'title' => esc_html__('Redirect to page after Buy Now', 'urna'),
                        'options' => array(
                                'cart'          => 'Page Cart',
                                'checkout'      => 'Page CheckOut',
                        ),
                        'default' => 'cart'
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                    array(
                        'id' => 'style_single_tabs_style',
                        'type' => 'button_set',
                        'title' => esc_html__('Tab Mode', 'urna'),
                        'options' => array(
                                'tabs'          => 'Tabs',
                                'accordion'        => 'Accordion',
                        ),
                        'default' => 'tabs'
                    ),
                    array(
                        'id' => 'enable_custom_tab',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Custom Tab', 'urna'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'custom_tab_type',
                        'type' => 'select',
                        'required' => array('enable_custom_tab','=',1),
                        'title' => esc_html__('Select Custom Tab', 'urna'),
                        'options' => urna_tbay_get_custom_tab_layouts(),
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                    array(
                        'id' => 'enable_size_guide',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Size Guide', 'urna'),
                        'default' => 1
                    ),
                    array(
                        'id'       => 'size_guide_title',
                        'type'     => 'text',
                        'title'    => esc_html__('Size Guide Title', 'urna'),
                        'required' => array('enable_size_guide','=', true),
                        'default'  => esc_html__('Size chart', 'urna'),
                    ),
                    array(
                        'id'       => 'size_guide_icon',
                        'type'     => 'text',
                        'title'    => esc_html__('Size Guide Icon', 'urna'),
                        'required' => array('enable_size_guide','=', true),
                        'desc'       => esc_html__('Enter icon name of fonts: ', 'urna') . '<a href="//fontawesome.com/v4.7.0/" target="_blank">Awesome</a> , <a href="//fonts.thembay.com/simple-line-icons//" target="_blank">simplelineicons</a>, <a href="//fonts.thembay.com/linearicons/" target="_blank">linearicons</a>',
                        'default'  => 'linear-icon-rulers',
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                   array(
                        'id' => 'show_product_nav',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Product Navigator', 'urna'),
                        'default' => true
                    ),
                   array(
                        'id' => 'product_nav_display_mode',
                        'type' => 'button_set',
                        'title' => esc_html__('Product Navigator Display Mode', 'urna'),
                        'required' => array('show_product_nav','=',1),
                        'options' => array(
                            'icon' => esc_html__('Icon', 'urna'),
                            'image' => esc_html__('Image', 'urna')
                        ),
                        'default' => 'icon'
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                    array(
                        'id' => 'enable_sticky_menu_bar',
                        'type' => 'switch',
                        'title' => esc_html__('Sticky Menu Bar', 'urna'),
                        'subtitle' => esc_html__('Enable/disable Sticky Menu Bar', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_zoom_image',
                        'type' => 'switch',
                        'title' => esc_html__('Zoom inner image', 'urna'),
                        'subtitle' => esc_html__('Enable/disable Zoom inner Image', 'urna'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_product_social_share',
                        'type' => 'switch',
                        'title' => esc_html__('Social Share', 'urna'),
                        'subtitle' => esc_html__('Enable/disable Social Share', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_product_review_tab',
                        'type' => 'switch',
                        'title' => esc_html__('Product Review Tab', 'urna'),
                        'subtitle' => esc_html__('Enable/disable Review Tab', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_product_releated',
                        'type' => 'switch',
                        'title' => esc_html__('Products Releated', 'urna'),
                        'subtitle' => esc_html__('Enable/disable Products Releated', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_product_upsells',
                        'type' => 'switch',
                        'title' => esc_html__('Products upsells', 'urna'),
                        'subtitle' => esc_html__('Enable/disable Products upsells', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_product_countdown',
                        'type' => 'switch',
                        'title' => esc_html__('Products Countdown', 'urna'),
                        'subtitle' => esc_html__('Enable/disable Products Countdown', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'number_product_thumbnail',
                        'type'  => 'slider',
                        'title' => esc_html__('Number Images Thumbnail to show', 'urna'),
                        'default' => 4,
                        'min'   => 2,
                        'step'  => 1,
                        'max'   => 5,
                    ),
                    array(
                        'id' => 'number_product_releated',
                        'type' => 'slider',
                        'title' => esc_html__('Number of related products to show', 'urna'),
                        'default' => 8,
                        'min' => 1,
                        'step' => 1,
                        'max' => 20,
                    ),
                    array(
                        'id' => 'releated_product_columns',
                        'type' => 'select',
                        'title' => esc_html__('Releated Products Columns', 'urna'),
                        'options' => $columns,
                        'default' => 4
                    ),
                    array(
                        'id'       => 'html_before_add_to_cart_btn',
                        'type'     => 'textarea',
                        'title'    => esc_html__('HTML before Add To Cart button (Global)', 'urna'),
                        'desc'     => esc_html__('Enter HTML and shortcodes that will show before Add to cart selections.', 'urna'),
                    ),
                    array(
                        'id'       => 'html_after_add_to_cart_btn',
                        'type'     => 'textarea',
                        'title'    => esc_html__('HTML after Add To Cart button (Global)', 'urna'),
                        'desc'     => esc_html__('Enter HTML and shortcodes that will show after Add to cart button.', 'urna'),
                    ),
                )

            );
            // Recent View Product
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Recently Viewed Products', 'urna'),
                'fields' => array(
                    array(
                        'id'=>'show_recentview',
                        'type' => 'switch',
                        'title' => esc_html__('Show Recently View', 'urna'),
                        'default' => true,
                    ),
                    array(
                        'id'       => 'title_recentview',
                        'type'     => 'text',
                        'required' => array('show_recentview','equals',true),
                        'title'    => esc_html__('Custom Title', 'urna'),
                        'default'  => esc_html__('Recent Viewed', 'urna'),
                        'required' => array('show_recentview','equals', true),
                    ),
                    array(
                        'id'       => 'recentview_icon',
                        'type'     => 'text',
                        'title'    => esc_html__('Recently Viewed Icon', 'urna'),
                        'required' => array('show_recentview','equals',true),
                        'desc'       => esc_html__('Enter icon name of fonts: ', 'urna') . '<a href="//fontawesome.com/v4.7.0/" target="_blank">Awesome</a> , <a href="//fonts.thembay.com/simple-line-icons//" target="_blank">simplelineicons</a>, <a href="//fonts.thembay.com/linearicons/" target="_blank">linearicons</a>',
                        'default'  => 'linear-icon-history',
                    ),
                    array(
                        'id' => 'max_products_recentview',
                        'type'  => 'slider',
                        'title' => esc_html__('Number of Display Products', 'urna'),
                        'desc'  => esc_html__('Max products of results show in Desktop', 'urna'),
                        'required' => array('show_recentview','equals',true),
                        'default' => 8,
                        'min'   => 8,
                        'step'  => 1,
                        'max'   => 16,
                    ),
                    array(
                        'id'       => 'empty_text_recentview',
                        'type'     => 'text',
                        'required' => array('show_recentview','equals',true),
                        'title'    => esc_html__('Empty Result - Custo Paragraph', 'urna'),
                        'default'  => esc_html__('You have no recently viewed item.', 'urna'),
                    ),
                    array(
                        'id'=>'show_recentview_viewall',
                        'type' => 'switch',
                        'title' => esc_html__('Show Button "View All"', 'urna'),
                        'required' => array('show_recentview','equals', true),
                        'default' => true,
                    ),
                    array(
                        'id'       => 'recentview_viewall_text',
                        'type'     => 'text',
                        'title'    => esc_html__('Button "View All" Custom Text', 'urna'),
                        'required' => array('show_recentview_viewall','equals',true),
                        'default'  => esc_html__('View All', 'urna'),
                    ),
                    array(
                        'id'       => 'recentview_select_pages',
                        'type'     => 'select',
                        'data'     => 'pages',
                        'title'    => esc_html__('Select Link Page To Button "View All"', 'urna'),
                        'required' => array('show_recentview_viewall','equals', true),
                    ),

                )

            );

            // woocommerce Menu Account settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Account', 'urna'),
                'fields' => array(
                    array(
                        'id' => 'show_woocommerce_password_strength',
                        'type' => 'switch',
                        'title' => esc_html__('Show Password Strength Meter', 'urna'),
                        'default' => true
                    ),
                )
            );

            // woocommerce Checkout page settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Checkout', 'urna'),
                'fields' => array(
                    array(
                        'id' => 'show_checkout_image',
                        'type' => 'switch',
                        'title' => esc_html__('Show Image', 'urna'),
                        'subtitle'  => esc_html__('Show image on page Checkout and Order Item Details', 'urna'),
                        'default' => true
                    ),
                )
            );

            // woocommerce Multi-vendor settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Multi-vendor', 'urna'),
                'fields' => array(
                    array(
                        'id' => 'show_vendor_name',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Vendor Name', 'urna'),
                        'subtitle' => esc_html__('Enable/Disable Vendor Name on HomePage and Shop page', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                    array(
                        'id' => 'seller_tab_per_page',
                        'type' => 'slider',
                        'title' => esc_html__('Dokan Number of Products Seller Tab', 'urna'),
                        'default' => 4,
                        'min' => 1,
                        'step' => 1,
                        'max' => 10,
                    ),
                    array(
                        'id' => 'seller_tab_columns',
                        'type' => 'select',
                        'title' => esc_html__('Dokan Product Columns Seller Tab', 'urna'),
                        'options' => $columns,
                        'default' => 4
                    ),
                )
            );

            // Blog settings
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-border-color',
                'title' => esc_html__('Blog', 'urna'),
                'fields' => array(
                    array(
                        'id' => 'show_blog_breadcrumb',
                        'type' => 'switch',
                        'title' => esc_html__('Breadcrumb', 'urna'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'blog_breadcrumb_layout',
                        'type' => 'image_select',
                        'class'     => 'image-two',
                        'compiler' => true,
                        'title' => esc_html__('Select Breadcrumb Blog Layout', 'urna'),
                        'required' => array('show_blog_breadcrumb','=',1),
                        'options' => array(
                            'image' => array(
                                'title' => esc_html__('Background Image', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/breadcrumbs/image.jpg'
                            ),
                            'color' => array(
                                'title' => esc_html__('Background color', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/breadcrumbs/color.jpg'
                            ),
                            'text'=> array(
                                'title' => esc_html__('Text Only', 'urna'),
                                'img'   => URNA_ASSETS_IMAGES . '/breadcrumbs/text_only.jpg'
                            ),
                        ),
                        'default' => 'color'
                    ),
                    array(
                        'title' => esc_html__('Breadcrumb Background Color', 'urna'),
                        'id' => 'blog_breadcrumb_color',
                        'type' => 'color',
                        'default' => '#fafafa',
                        'transparent' => false,
                        'required' => array('blog_breadcrumb_layout','=',array('default','color')),
                    ),
                    array(
                        'id' => 'blog_breadcrumb_image',
                        'type' => 'media',
                        'title' => esc_html__('Breadcrumb Background Image', 'urna'),
                        'subtitle' => esc_html__('Image File (.png or .jpg)', 'urna'),
                        'default'  => array(
                            'url'=> URNA_IMAGES .'/breadcrumbs-blog.jpg'
                        ),
                        'required' => array('blog_breadcrumb_layout','=','image'),
                    ),
                    array(
                        'id' => 'enable_previous_page_post',
                        'type' => 'switch',
                        'title' => esc_html__('Previous page', 'urna'),
                        'subtitle' => esc_html__('Enable Previous Page Button', 'urna'),
                        'default' => true
                    ),
                )
            );

            // Archive Blogs settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Blog Article', 'urna'),
                'fields' => array(
                    array(
                        'id' => 'blog_archive_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Blog Layout', 'urna'),
                        'options' => array(
                            'main' => array(
                                'title' => esc_html__('Articles', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/blog_archives/blog_no_sidebar.jpg'
                            ),
                            'left-main' => array(
                                'title' => esc_html__('Articles - Left Sidebar', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/blog_archives/blog_left_sidebar.jpg'
                            ),
                            'main-right' => array(
                                'title' => esc_html__('Articles - Right Sidebar', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/blog_archives/blog_right_sidebar.jpg'
                            ),
                        ),
                        'default' => 'main-right'
                    ),
                    array(
                        'id' => 'blog_archive_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Blog Archive Sidebar', 'urna'),
                        'options' => $sidebars,
                        'default' => 'blog-archive-sidebar'
                    ),
                    array(
                        'id' => 'blog_columns',
                        'type' => 'select',
                        'title' => esc_html__('Post Column', 'urna'),
                        'options' => $columns,
                        'default' => '2'
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                    array(
                        'id' => 'image_position',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Post Image Position', 'urna'),
                        'options' => array(
                            'top' => array(
                                'title' => esc_html__('Top', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/blog_archives/image_top.jpg'
                            ),
                            'left' => array(
                                'title' => esc_html__('Left', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/blog_archives/image_left.jpg'
                            ),
                        ),
                        'default' => 'top'
                    ),
                    array(
                        'id' => 'blog_image_sizes',
                        'type' => 'select',
                        'title' => esc_html__('Post Image Size', 'urna'),
                        'options' => $blog_image_size,
                        'default' => 'full'
                    ),
                    array(
                        'id' => 'blog_title_above',
                        'type' => 'switch',
                        'title' => esc_html__('Title Above Meta', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_date',
                        'type' => 'switch',
                        'title' => esc_html__('Date', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_author',
                        'type' => 'switch',
                        'title' => esc_html__('Author', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_categories',
                        'type' => 'switch',
                        'title' => esc_html__('Categories', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_categories_above_image',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Name of Category above Image', 'urna'),
                        'required' => array('enable_categories', '=', true),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_comment',
                        'type' => 'switch',
                        'title' => esc_html__('Comment', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_short_descriptions',
                        'type' => 'switch',
                        'title' => esc_html__('Short descriptions', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_readmore',
                        'type' => 'switch',
                        'title' => esc_html__('Read More', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id' => 'text_readmore',
                        'type' => 'text',
                        'title' => esc_html__('Button "Read more" Custom Text', 'urna'),
                        'required' => array('enable_readmore', '=', true),
                        'default' => 'Continue Reading',
                    ),
                )
            );

            // Single Blogs settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Blog Post', 'urna'),
                'fields' => array(
                    
                    array(
                        'id' => 'blog_single_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Blog Single Layout', 'urna'),
                        'options' => array(
                            'main' => array(
                                'title' => esc_html__('Main Only', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/single _post/main.jpg'
                            ),
                            'left-main' => array(
                                'title' => esc_html__('Left - Main Sidebar', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/single _post/left_sidebar.jpg'
                            ),
                            'main-right' => array(
                                'title' => esc_html__('Main - Right Sidebar', 'urna'),
                                'img' => URNA_ASSETS_IMAGES . '/single _post/right_sidebar.jpg'
                            ),
                        ),
                        'default' => 'main-right'
                    ),
                    array(
                        'id' => 'blog_single_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Single Blog Sidebar', 'urna'),
                        'options'   => $sidebars,
                        'default'   => 'blog-single-sidebar'
                    ),
                    array(
                        'id' => 'show_blog_social_share',
                        'type' => 'switch',
                        'title' => esc_html__('Show Social Share', 'urna'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'show_blog_releated',
                        'type' => 'switch',
                        'title' => esc_html__('Show Related Posts', 'urna'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'number_blog_releated',
                        'type' => 'slider',
                        'title' => esc_html__('Number of Related Posts', 'urna'),
                        'required' => array('show_blog_releated', '=', '1'),
                        'default' => 4,
                        'min' => 1,
                        'step' => 1,
                        'max' => 20,
                    ),
                    array(
                        'id' => 'releated_blog_columns',
                        'type' => 'select',
                        'title' => esc_html__('Columns of Related Posts', 'urna'),
                        'required' => array('show_blog_releated', '=', '1'),
                        'options' => $columns,
                        'default' => 2
                    ),

                )
            );

            // Page 404 settings
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-search-replace',
                'title' => esc_html__('Page 404', 'urna'),
                'fields' => array(
                    array(
                        'id'       => 'contact_select',
                        'type'     => 'select',
                        'data'     => 'pages',
                        'title'    => esc_html__('Select Page', 'urna'),
                    ),
                )
            );

            // Social Media
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-share',
                'title' => esc_html__('Social Share', 'urna'),
                'fields' => array(
                    array(
                        'id' => 'enable_code_share',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Code Share', 'urna'),
                        'default' => true
                    ),
                    array(
                        'id'       => 'select_share_type',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Please select a sharing type', 'urna' ),
                        'required'  => array('enable_code_share','=', true),
                        'options'  => array(
                            'custom' => 'TB Share',
                            'addthis' => 'Add This',
                        ),
                        'default'  => 'addthis'
                    ),
                    array(
                        'id'        =>'code_share',
                        'type'      => 'textarea',
                        'required'  => array('select_share_type','=', 'addthis'),
                        'title'     => esc_html__('"Addthis" Your Code', 'urna'), 
                        'desc'      => esc_html__('You get your code share in https://www.addthis.com', 'urna'),
                        'validate'  => 'html_custom',
                        'default'   => '<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59f2a47d2f1aaba2"></script>'
                    ),
                    array(
                        'id'       => 'sortable_sharing',
                        'type'     => 'sortable',
                        'mode'     => 'checkbox',
                        'title'    => esc_html__( 'Sortable Sharing', 'urna' ),
                        'required'  => array('select_share_type','=', 'custom'),
                        'options'  => array(
                            'facebook'      => 'Facebook',
                            'twitter'       => 'Twitter',
                            'linkedin'      => 'Linkedin',
                            'pinterest'     => 'Pinterest',
                            'whatsapp'      => 'Whatsapp',
                            'email'         => 'Email',
                        ),
                        'default'   => array(
                            'facebook'  => true,
                            'twitter'   => true,
                            'linkedin'  => true,
                            'pinterest' => false,
                            'whatsapp'  => false,
                            'email'     => true,
                        )
                    ),
                )
            );

            // Performance
            $this->sections[] = array(
                'icon' => 'el-icon-cog',
                'title' => esc_html__('Performance', 'urna'),
            );
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Performance', 'urna'),
                'fields' => array(
                    array(
                        'id'       => 'minified_js',
                        'type'     => 'switch',
                        'title'    => esc_html__('Include minified JS', 'urna'),
                        'subtitle' => esc_html__('Minified version of functions.js and device.js file will be loaded', 'urna'),
                        'default' => true
                    ),
                )
            );

            // Custom Code
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-code-setting',
                'title' => esc_html__('Custom CSS/JS', 'urna'),
            );

            // Css Custom Code
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Custom CSS', 'urna'),
                'fields' => array(
                    array(
                        'title' => esc_html__('Global Custom CSS', 'urna'),
                        'id' => 'custom_css',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array(
                        'title' => esc_html__('Custom CSS for desktop', 'urna'),
                        'id' => 'css_desktop',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array(
                        'title' => esc_html__('Custom CSS for tablet', 'urna'),
                        'id' => 'css_tablet',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array(
                        'title' => esc_html__('Custom CSS for mobile landscape', 'urna'),
                        'id' => 'css_wide_mobile',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array(
                        'title' => esc_html__('Custom CSS for mobile', 'urna'),
                        'id' => 'css_mobile',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                )
            );

            // Js Custom Code
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Custom Js', 'urna'),
                'fields' => array(
                    array(
                        'title' => esc_html__('Header JavaScript Code', 'urna'),
                        'subtitle' => '<em>'.esc_html__('Paste your custom JS code here. The code will be added to the header of your site.', 'urna').'<em>',
                        'id' => 'header_js',
                        'type' => 'ace_editor',
                        'mode' => 'javascript',
                    ),
                    
                    array(
                        'title' => esc_html__('Footer JavaScript Code', 'urna'),
                        'subtitle' => '<em>'.esc_html__('Here is the place to paste your Google Analytics code or any other JS code you might want to add to be loaded in the footer of your website.', 'urna').'<em>',
                        'id' => 'footer_js',
                        'type' => 'ace_editor',
                        'mode' => 'javascript',
                    ),
                )
            );



            $this->sections[] = array(
                'title' => esc_html__('Import / Export', 'urna'),
                'desc' => esc_html__('Import and Export your Redux Framework settings from file, text or URL.', 'urna'),
                'icon' => 'zmdi zmdi-download',
                'fields' => array(
                    array(
                        'id' => 'opt-import-export',
                        'type' => 'import_export',
                        'title' => 'Import Export',
                        'subtitle' => 'Save and restore your Redux options',
                        'full_width' => false,
                    ),
                ),
            );

            $this->sections[] = array(
                'type' => 'divide',
            );
        }

        public function sections_color_main( $default_color ) {

            $fields = array(
                array(
                    'id'        => 'boby_bg',
                    'type'      => 'background',
                    'output'    => array( 'body' ),
                    'title'     => esc_html__('Body Background', 'urna'),
                    'subtitle'  => esc_html__('Body background with image, color, etc.', 'urna'),
                ),
                array(
                    'title' => esc_html__('Theme Main Color', 'urna'),
                    'id' => 'main_color',
                    'type' => 'color',
                    'transparent' => false,
                    'default' => $default_color['main_color'],
                ),
            );


            if( !empty($default_color['enable_main_color_second']) ) {
                $second = array(
                    array(
                        'title' => esc_html__('Theme Main Color Second', 'urna'),
                        'subtitle' => '<em>'.esc_html__('The main color second of the site.', 'urna').'</em>',
                        'id' => 'main_color_second',
                        'type' => 'color',
                        'transparent' => false,
                        'required' => array('active_theme','=',array('furniture','technology-v1','technology-v2','technology-v3','fashion','fashion-v2','organic','jewelry','beauty','book','marketplace-v1','marketplace-v2','toy')),
                        'default' => $default_color['main_color_second'],
                    ),
                );

                $fields = array_merge( $fields, $second );
            }

            if (!empty($default_color['enable_main_color_third'])) {
                $third = array(
                    array(
                        'title' => esc_html__('Theme Main Color third', 'urna'),
                        'subtitle' => '<em>'.esc_html__('The main color third of the site.', 'urna').'</em>',
                        'id' => 'main_color_third',
                        'type' => 'color',
                        'transparent' => false,
                        'required' => array('active_theme','=',array('toy')),
                        'default' => $default_color['main_color_third'],
                    ),
                );

                $fields = array_merge( $fields, $third );
            }

            $output_arr = array(
                'title' => esc_html__('Main', 'urna'),
                'subsection' => true,
                'fields' => $fields
            );

            return $output_arr;
        }


        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
         
        /**
     * Custom function for the callback validation referenced above
     * */
        
         
        public function setArguments()
        {
            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'urna_tbay_theme_options',
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'),
                // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'),
                // Version that appears at the top of your panel
                'menu_type' => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true,
                // Show the sections below the admin menu item or not
                'menu_title' => esc_html__('Urna Options', 'urna'),
                'page_title' => esc_html__('Urna Options', 'urna'),

                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '',
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly' => false,
                // Must be defined to add google fonts to the typography module
                'async_typography' => false,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar' => true,
                // Show the panel pages on the admin bar
                'admin_bar_icon' => 'urna-admin-icon',
                // Choose an icon for the admin bar menu
                'admin_bar_priority' => 50,
                // Choose an priority for the admin bar menu
                'global_variable' => 'urna_options',
                // Set a different name for your global variable other than the opt_name
                'dev_mode' => false,
                'forced_dev_mode_off' => false,
                // Show the time the page took to load, etc
                'update_notice' => true,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer' => true,
                // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority' => 61,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon' => URNA_ASSETS_IMAGES . '/admin/theme-admin-icon-small.jpg',
                // Specify a custom URL to an icon
                'last_tab' => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options',
                // Page slug used to denote the panel
                'save_defaults' => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show' => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info' => false,
                // REMOVE

                // HINTS
                'hints' => array(
                    'icon' => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color' => 'lightgray',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'light',
                        'shadow' => true,
                        'rounded' => false,
                        'style' => '',
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'mouseover',
                        ),
                        'hide' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'click mouseleave',
                        ),
                    ),
                )
            );
            
            $this->args['intro_text'] = '';

            // Add content after the form.
            $this->args['footer_text'] = '';
            return $this->args;
            
            if (! function_exists('redux_validate_callback_function')) {
                function redux_validate_callback_function($field, $value, $existing_value)
                {
                    $error   = false;
                    $warning = false;

                    //do your validation
                    if ($value == 1) {
                        $error = true;
                        $value = $existing_value;
                    } elseif ($value == 2) {
                        $warning = true;
                        $value   = $existing_value;
                    }

                    $return['value'] = $value;

                    if ($error == true) {
                        $field['msg']    = 'your custom error message';
                        $return['error'] = $field;
                    }

                    if ($warning == true) {
                        $field['msg']      = 'your custom warning message';
                        $return['warning'] = $field;
                    }

                    return $return;
                }
            }
        }
    }

    global $reduxConfig;
    $reduxConfig = new Urna_Redux_Framework_Config();
}
