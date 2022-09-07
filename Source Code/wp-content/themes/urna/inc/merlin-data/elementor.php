<?php

class Urna_Merlin_Elementor
{
    public function import_files_elementor()
    {
        $prefix_name = 'Elementor';
        $prefix 	 = 'elementor';

        $skins = array(
            'bag',
            'beauty',
            'bike',
            'book',
            'fashion-v1',
            'fashion-v2',
            'fashion-v3',
            'glass',
            'home-landing',
            'handmade',
            'interior',
            'jewelry',
            'kidfashion',
            'kitchen',
            'men',
            'minimal',
            'organic',
            'pet',
            'sportwear',
            'technology-v1',
            'technology-v2',
            'technology-v3',
            'toy',
            'women',
            'home-landing'
        );

        foreach ($skins as $key => $value) {
            $group_label_end 	=  ($key === end($skins)) ? 'yes' : 'no';

            $import_files[] = array(
                'import_file_name'           => ucfirst($value),
                'home'                       => 'home',
                'import_file_url'          	 => "https://demosamples.thembay.com/urna/${prefix}/${value}/data.xml",
                'import_widget_file_url'     => "https://demosamples.thembay.com/urna/${prefix}/${value}/widgets.wie",
                'import_redux'         => array(
                    array(
                        'file_url'   => "https://demosamples.thembay.com/urna/${prefix}/${value}/redux_options.json",
                        'option_name' => 'urna_tbay_theme_options',
                    ),
                ),
                'rev_sliders'           =>  array(
                    "https://demosamples.thembay.com/urna/${prefix}/${value}/revslider/${value}.zip",
                ),
                'import_preview_image_url'   => "https://demosamples.thembay.com/urna/${prefix}/${value}/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'urna'),
                'preview_url'                => 'https://elementor.urnawp.com/'. $value,
                'group_label_end'            => $group_label_end,
            );
        }

        /**Skin Vendor**/
        $import_vendor = array(
            array(
                'import_file_name'           => 'Furniture',
                'home'                       => 'home',
                'import_file_url'          	 => "https://demosamples.thembay.com/urna/${prefix}/furniture/data.xml",
                'import_widget_file_url'     => "https://demosamples.thembay.com/urna/${prefix}/furniture/widgets.wie",
                'import_redux'         => array(
                    array(
                        'file_url'   => "https://demosamples.thembay.com/urna/${prefix}/furniture/redux_options.json",
                        'option_name' => 'urna_tbay_theme_options',
                    ),
                ),
                'rev_sliders'           =>  array(
                    "https://demosamples.thembay.com/urna/${prefix}/furniture/revslider/furniture.zip",
                ),
                'import_preview_image_url'   => "https://demosamples.thembay.com/urna/${prefix}/furniture/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'urna'),
                'preview_url'                => 'https://elementor.urnawp.com/',
                'group_label_start'  		 => 'yes',
                'group_label_name'           => $prefix_name,
            ),
            array(
                'import_file_name'           => 'Marketplace 01 - Dokan',
                'home'                       => 'home',
                'import_file_url'          	 => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v1/data.xml",
                'import_widget_file_url'     => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v1/widgets.wie",
                'import_redux'         => array(
                    array(
                        'file_url'   => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v1/redux_options.json",
                        'option_name' => 'urna_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => array(
                    "https://demosamples.thembay.com/urna/${prefix}/marketplace-v1/revslider/Marketplace-v1.zip",
                    "https://demosamples.thembay.com/urna/${prefix}/marketplace-v1/revslider/slide-vendor.zip",
                ),
                'import_preview_image_url'   => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v1/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'urna'),
                'preview_url'                => 'https://elementor-marketplaces.urnawp.com/demo1-dokan/',
            ),
            array(
                'import_file_name'           => 'Marketplace 02 - WC Marketplace',
                'home'                       => 'home',
                'import_file_url'          	 => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v2/data.xml",
                'import_widget_file_url'     => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v2/widgets.wie",
                'import_redux'         => array(
                    array(
                        'file_url'   => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v2/redux_options.json",
                        'option_name' => 'urna_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => array(
                    "https://demosamples.thembay.com/urna/${prefix}/marketplace-v2/revslider/Marketplace-v2.zip",
                    "https://demosamples.thembay.com/urna/${prefix}/marketplace-v2/revslider/slide-vendor.zip",
                ),
                'import_preview_image_url'   => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v2/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'urna'),
                'preview_url'                => 'https://elementor-marketplaces.urnawp.com/demo2-wcmp/',
            ),
            array(
                'import_file_name'           => 'Marketplace 03 - WCFM',
                'home'                       => 'home',
                'import_file_url'          	 => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v3/data.xml",
                'import_widget_file_url'     => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v3/widgets.wie",
                'import_redux'         => array(
                    array(
                        'file_url'   => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v3/redux_options.json",
                        'option_name' => 'urna_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => array(
                    "https://demosamples.thembay.com/urna/${prefix}/marketplace-v3/revslider/auto-part.zip",
                    "https://demosamples.thembay.com/urna/${prefix}/marketplace-v3/revslider/slide-vendor.zip",
                ),
                'import_preview_image_url'   => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v3/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'urna'),
                'preview_url'                => 'https://elementor-marketplaces.urnawp.com/demo3-wcfm/',
            ),
            array(
                'import_file_name'           => 'Marketplace 04 - WC Vendors',
                'home'                       => 'home',
                'import_file_url'          	 => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v4/data.xml",
                'import_widget_file_url'     => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v4/widgets.wie",
                'import_redux'         => array(
                    array(
                        'file_url'   => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v4/redux_options.json",
                        'option_name' => 'urna_tbay_theme_options',
                    ),
                ),
                'rev_sliders'                => array(
                    "https://demosamples.thembay.com/urna/${prefix}/marketplace-v4/revslider/Marketplace-v1.zip",
                    "https://demosamples.thembay.com/urna/${prefix}/marketplace-v4/revslider/slide-vendor.zip",
                ),
                'import_preview_image_url'   => "https://demosamples.thembay.com/urna/${prefix}/marketplace-v4/screenshot.jpg",
                'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'urna'),
                'preview_url'                => 'https://elementor-marketplaces.urnawp.com/demo4-wcvendors/',
            )
        );
        
        return array_merge($import_vendor, $import_files);
    }
}
