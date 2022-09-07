<?php

class Urna_Merlin_Local
{
    public function import_files_wpb_vc_local()
    {
        // https://demosamples.thembay.com/urna/urna.zip

        $import_files[] = array(
            'import_file_name'           => esc_html__('Demo Import', 'urna'),
            'home'                       => 'home',
            'local_import_file'          	 => get_theme_file_path('/sample-data/data.xml'),
            'local_import_widget_file'     => get_theme_file_path('/sample-data/widgets.wie'),
            'local_import_redux'         => array(
                array(
                    'file_path'   => get_theme_file_path('/sample-data/redux_options.json'),
                    'option_name' => 'urna_tbay_theme_options',
                ),
            ),
            'rev_sliders'                => array(
                get_theme_file_path('/sample-data/revslider/furniture.zip'),
            ),
            'import_preview_image_url'   => get_theme_file_uri('/sample-data/screenshot.jpg'),
            'import_notice'              => esc_html__('After you import this demo, you will have to setup the slider separately.', 'urna'),
            'preview_url'                => 'https://urnawp.com/',
        );

        return $import_files;
    }
}
