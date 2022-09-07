<?php

$upload_dir = wp_upload_dir();
if (isset($upload_dir['basedir'])) {
    $theme_name = 'urna';

    $demo_import_base_dir = $upload_dir['basedir'] . '/'.$theme_name.'_import/';
    $demo_import_base_uri = $upload_dir['baseurl'] . '/'.$theme_name.'_import/';

    $page_builders = array('wpbakery', 'elementor');

    foreach ($page_builders as $key => $type) {
        ${"path_dir_" . $type} = $demo_import_base_dir . $type .'/data/';
        ${"path_uri_" . $type} = $demo_import_base_uri . $type .'/data/';

        ${"path_img_dir_" . $type} = $demo_import_base_dir . $type . '/images/';
        ${"path_img_uri_" . $type} = $demo_import_base_uri . $type . '/images/';

        if (is_dir(${"path_img_dir_" . $type})) {
            $files = glob(${"path_img_dir_" . $type} . '*.{jpg}', GLOB_BRACE);

            ${"skins_" . $type} 	= array();
            foreach ($files as $file) {
                $name =  basename($file, ".jpg");

                $str 			= explode("/images/", $file);

                $img_dir 	   	= ${"path_img_uri_" . $type}.''. $str[1];

                ${"skins_" . $type} += [$name 	=> array(
                    'skin'      	=> $img_dir,
                    'title'         => ucfirst($name),
                )];
            }
        }

        if (is_dir(${"path_dir_" . $type})) {
            ${"demo_datas_" . $type} = array();

            foreach (glob(${"path_dir_" . $type} . '*', GLOB_ONLYDIR) as $theme_dir) {
                if (is_file($theme_dir . '/data.xml')) {
                    $theme_dir_name = basename($theme_dir);
                    $demo_data_items = array();
                    $id = 0;

                    $files = glob($theme_dir . '/*', GLOB_ONLYDIR);

                    $str = explode("/data/", $theme_dir);

                    $home_dir_name = basename($theme_dir);
                    $home_uri 	   = ${"path_uri_" . $type}.'/'. $str[1];

                    ${"demo_datas_" . $type} += [$theme_dir_name => $home_uri];
                }
            }
        }
    }
}
