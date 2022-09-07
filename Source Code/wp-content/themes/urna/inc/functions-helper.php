<?php if (! defined('URNA_THEME_DIR')) {
    exit('No direct script access allowed');
}

if (! function_exists('urna_tbay_body_classes')) {
    function urna_tbay_body_classes($classes)
    {
        global $post;
        if (is_page() && is_object($post)) {
            $class = get_post_meta($post->ID, 'tbay_page_extra_class', true);
            if (!empty($class)) {
                $classes[] = trim($class);
            }
        }
        if (urna_tbay_get_config('preload')) {
            $classes[] = 'tbay-body-loader';
        }

        if (urna_tbay_is_home_page()) {
            $classes[] = 'tbay-homepage-demo';
        }

        $get_header = urna_tbay_get_config('active_theme');
        if (empty($get_header)) {
            $classes[] = 'tbay-body-default';
        }

        $classes[] = 'skin-'.urna_tbay_get_theme();

        return $classes;
    }
    add_filter('body_class', 'urna_tbay_body_classes');
}


if (! function_exists('urna_tbay_body_home_classes')) {
    function urna_tbay_body_home_classes($classes)
    {
        global $post;
        if (is_page() && is_object($post)) {
            $slug = get_queried_object()->post_name;
            if (!empty($slug)) {
                $classes[] = trim($slug);
            }
        }

        if (is_front_page()) {
            $class = 'tbay-home';
            if (!empty($class)) {
                $classes[] = trim($class);
            }
        }

        return $classes;
    }
    add_filter('body_class', 'urna_tbay_body_home_classes');
}

if (! function_exists('urna_tbay_get_shortcode_regex')) {
    function urna_tbay_get_shortcode_regex($tagregexp = '')
    {
        // WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
        // Also, see shortcode_unautop() and shortcode.js.
        return
            '\\['                                // Opening bracket
            . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
            . "($tagregexp)"                     // 2: Shortcode name
            . '(?![\\w-])'                       // Not followed by word character or hyphen
            . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
            . '[^\\]\\/]*'                   // Not a closing bracket or forward slash
            . '(?:'
            . '\\/(?!\\])'               // A forward slash not followed by a closing bracket
            . '[^\\]\\/]*'               // Not a closing bracket or forward slash
            . ')*?'
            . ')'
            . '(?:'
            . '(\\/)'                        // 4: Self closing tag ...
            . '\\]'                          // ... and closing bracket
            . '|'
            . '\\]'                          // Closing bracket
            . '(?:'
            . '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
            . '[^\\[]*+'             // Not an opening bracket
            . '(?:'
            . '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
            . '[^\\[]*+'         // Not an opening bracket
            . ')*+'
            . ')'
            . '\\[\\/\\2\\]'             // Closing shortcode tag
            . ')?'
            . ')'
            . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
    }
}

if (! function_exists('urna_tbay_tagregexp')) {
    function urna_tbay_tagregexp()
    {
        return apply_filters('urna_tbay_custom_tagregexp', 'video|audio|playlist|video-playlist|embed|urna_tbay_media');
    }
}


if (! function_exists('urna_tbay_text_line')) {
    function urna_tbay_text_line($str)
    {
        return trim(preg_replace("/('|\"|\r?\n)/", '', $str));
    }
}

if (!function_exists('urna_tbay_get_themes')) {
    function urna_tbay_get_themes()
    {
        $themes = array();
        $path   = get_template_directory() . '/css/skins/';
        
        if (is_dir($path)) {
            $folders = scandir($path);
            $excludes = array('.', '..', '.svn');
            foreach ($folders as $folder) {
                if (!in_array($folder, $excludes) && is_dir($path . $folder)) {
                    $theme = array(
                        $folder => array(
                            'title' => $folder,
                            'alt'   => $folder,
                            'img'   => get_template_directory_uri() . '/inc/assets/images/active_theme/'.$folder.'.jpg'
                        ),
                    );
                    $themes = array_merge($themes, $theme);
                }
            }
        }
        return $themes;
    }
}

if (!function_exists('urna_tbay_get_theme')) {
    function urna_tbay_get_theme()
    {
        if (isset($_GET['skin']) && !empty($_GET['skin'])) {
            return $_GET['skin'];
        }

        return urna_tbay_get_global_config('active_theme', 'furniture');
    }
}

if (!function_exists('urna_tbay_get_part_theme')) {
    function urna_tbay_get_part_theme()
    {
        $active_theme  = urna_tbay_get_global_config('active_theme', 'fashion');
        $active_theme  = 'themes/'.$active_theme;

        return $active_theme;
    }
}

if (!function_exists('urna_tbay_get_footer_layouts')) {
    function urna_tbay_get_footer_layouts()
    {
        $footers = array( '' => esc_html__('Default', 'urna'));
        $args = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'post_type'        => 'tbay_footer',
            'post_status'      => 'publish',
            'suppress_filters' => 0
        );
        $posts = get_posts($args);
        foreach ($posts as $post) {
            $footers[$post->post_name] = $post->post_title;
        }
        return $footers;
    }
}

if (!function_exists('urna_tbay_get_footer_layout')) {
    function urna_tbay_get_footer_layout()
    {
        if (is_page()) {
            global $post;
            $footer = '';
            if (is_object($post) && isset($post->ID)) {
                $footer = get_post_meta($post->ID, 'tbay_page_footer_type', true);
                if ($footer == 'global' ||  $footer == '') {
                    return urna_tbay_get_config('footer_type', '');
                }
            }
            return $footer;
        }
        return urna_tbay_get_config('footer_type', '');
    }
    add_filter('urna_tbay_get_footer_layout', 'urna_tbay_get_footer_layout');
}

if (!function_exists('urna_tbay_blog_content_class')) {
    function urna_tbay_blog_content_class($class)
    {
        $page = 'archive';
        if (is_singular('post')) {
            $page = 'single';
        }
        if (urna_tbay_get_config('blog_'.$page.'_fullwidth')) {
            return 'container-fluid';
        }
        return $class;
    }
}
add_filter('urna_tbay_blog_content_class', 'urna_tbay_blog_content_class', 1, 1);

// layout class for woo page
if (!function_exists('urna_tbay_post_content_class')) {
    function urna_tbay_post_content_class($class)
    {
        $page = 'archive';
        if (is_singular('post')) {
            $page = 'single';

            if (!isset($_GET['blog_'.$page.'_layout'])) {
                $class .= ' '.urna_tbay_get_config('blog_'.$page.'_layout');
            } else {
                $class .= ' '.$_GET['blog_'.$page.'_layout'];
            }
        } else {
            if (!isset($_GET['blog_'.$page.'_layout'])) {
                $class .= ' '.urna_tbay_get_config('blog_'.$page.'_layout');
            } else {
                $class .= ' '.$_GET['blog_'.$page.'_layout'];
            }
        }
        return $class;
    }
}
add_filter('urna_tbay_post_content_class', 'urna_tbay_post_content_class');

if (!function_exists('urna_tbay_page_content_class')) {
    function urna_tbay_page_content_class($class)
    {
        global $post;
        $fullwidth = get_post_meta($post->ID, 'tbay_page_fullwidth', true);
        if (!$fullwidth || $fullwidth == 'no') {
            return $class;
        }
        return 'container-fluid';
    }
}
add_filter('urna_tbay_page_content_class', 'urna_tbay_page_content_class', 1, 1);

if (!function_exists('urna_tbay_get_page_layout_configs')) {
    function urna_tbay_get_page_layout_configs()
    {
        global $post;
        if (isset($post->ID)) {
            $left = get_post_meta($post->ID, 'tbay_page_left_sidebar', true);
            $right = get_post_meta($post->ID, 'tbay_page_right_sidebar', true);

            switch (get_post_meta($post->ID, 'tbay_page_layout', true)) {
                case 'left-main':
                    $configs['left'] = array( 'sidebar' => $left, 'class' => 'col-xs-12 col-md-12 col-lg-3'  );
                    $configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-9' );
                    break;
                case 'main-right':
                    $configs['right'] = array( 'sidebar' => $right,  'class' => 'col-xs-12 col-md-12 col-lg-3' );
                    $configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-9' );
                    break;
                case 'main':
                    $configs['main'] = array( 'class' => 'clearfix' );
                    break;
                case 'left-main-right':
                    $configs['left'] = array( 'sidebar' => $left,  'class' => 'col-xs-12 col-md-12 col-lg-3'  );
                    $configs['right'] = array( 'sidebar' => $right, 'class' => 'col-xs-12 col-md-12 col-lg-3' );
                    $configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-6' );
                    break;
                default:
                    $configs['main'] = array( 'class' => 'clearfix' );
                    break;
            }

            return $configs;
        }
    }
}

if (! function_exists('urna_tbay_get_first_url_from_string')) {
    function urna_tbay_get_first_url_from_string($string)
    {
        $pattern = "/^\b(?:(?:https?|ftp):\/\/)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
        preg_match($pattern, $string, $link);

        return (! empty($link[0])) ? $link[0] : false;
    }
}

/*Check in home page*/
if (!function_exists('urna_tbay_is_home_page')) {
    function urna_tbay_is_home_page()
    {
        $is_home = false;

        if (is_home() || is_front_page() || is_page('home-1')) {
            $is_home = true;
        }

        return $is_home;
    }
}

if (!function_exists('urna_tbay_get_link_attributes')) {
    function urna_tbay_get_link_attributes($string)
    {
        preg_match('/<a href="(.*?)">/i', $string, $atts);

        return (! empty($atts[1])) ? $atts[1] : '';
    }
}

if (!function_exists('urna_tbay_post_media')) {
    function urna_tbay_post_media($content)
    {
        $is_video = (get_post_format() == 'video') ? true : false;
        $media = urna_tbay_get_first_url_from_string($content);
        if (! empty($media)) {
            global $wp_embed;
            $content = do_shortcode($wp_embed->run_shortcode('[embed]' . $media . '[/embed]'));
        } else {
            $pattern = urna_tbay_get_shortcode_regex(urna_tbay_tagregexp());
            preg_match('/' . $pattern . '/s', $content, $media);
            if (! empty($media[2])) {
                if ($media[2] == 'embed') {
                    global $wp_embed;
                    $content = do_shortcode($wp_embed->run_shortcode($media[0]));
                } else {
                    $content = do_shortcode($media[0]);
                }
            }
        }
        if (! empty($media)) {
            $output = '<div class="entry-media">';
            $output .= ($is_video) ? '<div class="pro-fluid"><div class="pro-fluid-inner">' : '';
            $output .= $content;
            $output .= ($is_video) ? '</div></div>' : '';
            $output .= '</div>';

            return $output;
        }

        return false;
    }
}

if (!function_exists('urna_tbay_post_gallery')) {
    function urna_tbay_post_gallery($content)
    {
        $pattern = urna_tbay_get_shortcode_regex('gallery');
        preg_match('/' . $pattern . '/s', $content, $media);
        if (! empty($media[2])) {
            return '<div class="entry-gallery">' . do_shortcode($media[0]) . '<hr class="pro-clear" /></div>';
        }

        return false;
    }
}

if (!function_exists('urna_tbay_random_key')) {
    function urna_tbay_random_key($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $return = '';
        for ($i = 0; $i < $length; $i++) {
            $return .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $return;
    }
}

if (!function_exists('urna_tbay_substring')) {
    function urna_tbay_substring($string, $limit, $afterlimit = '[...]')
    {
        if (empty($string)) {
            return $string;
        }
        $string = explode(' ', strip_tags($string), $limit);

        if (count($string) >= $limit) {
            array_pop($string);
            $string = implode(" ", $string) .' '. $afterlimit;
        } else {
            $string = implode(" ", $string);
        }
        $string = preg_replace('`[[^]]*]`', '', $string);
        return strip_shortcodes($string);
    }
}

if (!function_exists('urna_tbay_subschars')) {
    function urna_tbay_subschars($string, $limit, $afterlimit='...')
    {
        if (strlen($string) > $limit) {
            $string = substr($string, 0, $limit);
        } else {
            $afterlimit = '';
        }
        return $string . $afterlimit;
    }
}


/*Urna get template parts*/
if (!function_exists('urna_tbay_get_page_templates_parts')) {
    function urna_tbay_get_page_templates_parts($slug = 'logo', $name = null)
    {
        return get_template_part('page-templates/parts/'.$slug.'', $name);
    }
}

/*testimonials*/
if (!function_exists('urna_tbay_get_testimonials_layouts')) {
    function urna_tbay_get_testimonials_layouts()
    {
        $testimonials = array();
        $files = glob(get_template_directory() . '/vc_templates/testimonial/testimonial.php');
        if (!empty($files)) {
            foreach ($files as $file) {
                $testi = str_replace("testimonial", '', str_replace('.php', '', basename($file)));
                $testimonials[$testi] = $testi;
            }
        }

        return $testimonials;
    }
}

/*Blog*/
if (!function_exists('urna_tbay_get_blog_layouts')) {
    function urna_tbay_get_blog_layouts()
    {
        $blogs = array(
            esc_html__('Grid', 'urna') => 'grid',
            esc_html__('Vertical', 'urna') => 'vertical',
        );
        $files = glob(get_template_directory() . '/vc_templates/post/carousel/_single_*.php');
        if (!empty($files)) {
            foreach ($files as $file) {
                $str = str_replace("_single_", '', str_replace('.php', '', basename($file)));
                $blogs[$str] = $str;
            }
        }

        return $blogs;
    }
}

// Number of blog per row
if (!function_exists('urna_tbay_blog_loop_columns')) {
    function urna_tbay_blog_loop_columns($number)
    {
        $sidebar_configs = urna_tbay_get_blog_layout_configs();

        $columns 	= urna_tbay_get_config('blog_columns');

        if (isset($_GET['blog_columns']) && is_numeric($_GET['blog_columns'])) {
            $value = $_GET['blog_columns'];
        } elseif (empty($columns) && isset($sidebar_configs['columns'])) {
            $value = 	$sidebar_configs['columns'];
        } else {
            $value = $columns;
        }

        if (in_array($value, array(1, 2, 3, 4, 5, 6))) {
            $number = $value;
        }
        return $number;
    }
}
add_filter('loop_blog_columns', 'urna_tbay_blog_loop_columns');

/*Check style blog image full*/
if (!function_exists('urna_tbay_blog_image_sizes_full')) {
    function urna_tbay_blog_image_sizes_full()
    {
        $style = false;
        $sidebar_configs = urna_tbay_get_blog_layout_configs();

        if (!is_singular('post')) {
            if (isset($sidebar_configs['image_sizes']) && $sidebar_configs['image_sizes'] == 'full') :
                   $style = true;
            endif;
        }

        return  $style;
    }
}


// Number of post per page
if (!function_exists('urna_tbay_loop_post_per_page')) {
    function urna_tbay_loop_post_per_page($number)
    {
        if (isset($_GET['posts_per_page']) && is_numeric($_GET['posts_per_page'])) {
            $value = $_GET['posts_per_page'];
        } else {
            $value = get_option('posts_per_page');
        }

        if (is_numeric($value) && $value) {
            $number = absint($value);
        }
        
        return $number;
    }
    add_filter('loop_post_per_page', 'urna_tbay_loop_post_per_page');
}

if (!function_exists('urna_tbay_posts_per_page')) {
    function urna_tbay_posts_per_page($wp_query)
    {
        if (is_admin() || ! $wp_query->is_main_query()) {
            return;
        }

        $value = apply_filters('loop_post_per_page', 6);

        if (isset($value) && is_category()) {
            $wp_query->query_vars['posts_per_page'] = $value;
        }
        return $wp_query;
    }
    add_action('pre_get_posts', 'urna_tbay_posts_per_page');
}

if (!function_exists('urna_tbay_share_js')) {
    function urna_tbay_share_js()
    {
        if( !urna_tbay_get_config('enable_code_share',false) || urna_tbay_get_config('select_share_type') == 'custom' ) return;
        
        if ( is_single() ) {
            echo urna_tbay_get_config('code_share');
        }
    }
    add_action('wp_head', 'urna_tbay_share_js');
} 


/*Post Views*/
if (!function_exists('urna_set_post_views')) {
    function urna_set_post_views($postID)
    {
        $count_key = 'urna_post_views_count';
        $count 		 = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            $count = 1;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '1');
        } else {
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

if (!function_exists('urna_track_post_views')) {
    function urna_track_post_views($post_id)
    {
        if (!is_single()) {
            return;
        }
        if (empty($post_id)) {
            global $post;
            $post_id = $post->ID;
        }
        urna_set_post_views($post_id);
    }
    add_action('wp_head', 'urna_track_post_views');
}

if (!function_exists('urna_get_post_views')) {
    function urna_get_post_views($postID, $text = '')
    {
        $count_key = 'urna_post_views_count';
        $count = get_post_meta($postID, $count_key, true);

        if ($count == '') {
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0";
        }
        return $count.$text;
    }
}

/*Get Preloader*/
if (! function_exists('urna_get_select_preloader')) {
    add_action('wp_body_open', 'urna_get_select_preloader', 10);
    function urna_get_select_preloader()
    {
        $enable_preload = urna_tbay_get_global_config('preload', false);

        if (!$enable_preload) {
            return;
        }

        $preloader 	= urna_tbay_get_global_config('select_preloader', 'loader1');
        $media 		= urna_tbay_get_global_config('media-preloader');
        
        if (isset($preloader)) {
            switch ($preloader) {
                case 'loader1':
                    ?>
	                <div class="tbay-page-loader">
					  	<div id="loader"></div>
					  	<div class="loader-section section-left"></div>
					  	<div class="loader-section section-right"></div>
					</div>
	    			<?php
                    break;

                case 'loader2':
                    ?>
					<div class="tbay-page-loader">
					    <div class="tbay-loader tbay-loader-two">
					    	<span></span>
					    	<span></span>
					    	<span></span>
					    	<span></span>
					    </div>
					</div>
	    			<?php
                    break;
                case 'loader3':
                    ?>
					<div class="tbay-page-loader">
					    <div class="tbay-loader tbay-loader-three">
					    	<span></span>
					    	<span></span>
					    	<span></span>
					    	<span></span>
					    	<span></span>
					    </div>
					</div>
	    			<?php
                    break;
                case 'loader4':
                    ?>
					<div class="tbay-page-loader">
					    <div class="tbay-loader tbay-loader-four"> <span class="spinner-cube spinner-cube1"></span> <span class="spinner-cube spinner-cube2"></span> <span class="spinner-cube spinner-cube3"></span> <span class="spinner-cube spinner-cube4"></span> <span class="spinner-cube spinner-cube5"></span> <span class="spinner-cube spinner-cube6"></span> <span class="spinner-cube spinner-cube7"></span> <span class="spinner-cube spinner-cube8"></span> <span class="spinner-cube spinner-cube9"></span> </div>
					</div>
	    			<?php
                    break;
                case 'loader5':
                    ?>
					<div class="tbay-page-loader">
					    <div class="tbay-loader tbay-loader-five"> <span class="spinner-cube-1 spinner-cube"></span> <span class="spinner-cube-2 spinner-cube"></span> <span class="spinner-cube-4 spinner-cube"></span> <span class="spinner-cube-3 spinner-cube"></span> </div>
					</div>
	    			<?php
                    break;
                case 'loader6':
                    ?>
					<div class="tbay-page-loader">
					    <div class="tbay-loader tbay-loader-six"> <span class=" spinner-cube-1 spinner-cube"></span> <span class=" spinner-cube-2 spinner-cube"></span> </div>
					</div>
	    			<?php
                    break;

                case 'custom_image':
                    ?>
					<div class="tbay-page-loader loader-img">
						<?php if (isset($media['url']) && !empty($media['url'])): ?>
					   		<img alt="<?php echo (!empty($media['alt'])) ? esc_attr($media['alt']) : ''; ?>" src="<?php echo esc_url($media['url']); ?>">
						<?php endif; ?>
					</div>
	    			<?php
                    break;
                    
                default:
                    ?>
	    			<div class="tbay-page-loader">
					  	<div id="loader"></div>
					  	<div class="loader-section section-left"></div>
					  	<div class="loader-section section-right"></div>
					</div>
	    			<?php
                    break;
            }
        }
    }
}

if (!function_exists('urna_gallery_atts')) {
    add_filter('shortcode_atts_gallery', 'urna_gallery_atts', 10, 3);
    
    /* Change attributes of wp gallery to modify image sizes for your needs */
    function urna_gallery_atts($output, $pairs, $atts)
    {
        if (isset($atts['columns']) && $atts['columns'] == 1) {
            //if gallery has one column, use large size
            $output['size'] = 'full';
        } elseif (isset($atts['columns']) && $atts['columns'] >= 2 && $atts['columns'] <= 4) {
            //if gallery has between two and four columns, use medium size
            $output['size'] = 'full';
        } else {
            //if gallery has more than four columns, use thumbnail size
            $output['size'] = 'full';
        }
    
        return $output;
    }
}

if (!function_exists('urna_get_custom_menu')) {

    
    /* Change attributes of wp gallery to modify image sizes for your needs */
    function urna_get_custom_menu($menu_id)
    {
        $_id = urna_tbay_random_key();

        $args = array(
            'menu'              => $menu_id,
            'container_class'   => 'nav',
            'menu_class'        => 'menu',
            'fallback_cb'       => '__return_empty_string',
            'before'            => '',
            'after'             => '',
            'echo'              => true,
            'menu_id'           => 'menu-'.$menu_id.'-'.$_id
        );

        $output = wp_nav_menu($args);

    
        return $output;
    }
}

/*Set excerpt show enable default*/
if (! function_exists('urna_tbay_edit_post_show_excerpt')) {
    function urna_tbay_edit_post_show_excerpt()
    {
        $user = wp_get_current_user();
        $unchecked = get_user_meta($user->ID, 'metaboxhidden_post', true);
        if (is_array($unchecked)) {
            $key = array_search('postexcerpt', $unchecked);
            if (false !== $key) {
                array_splice($unchecked, $key, 1);
                update_user_meta($user->ID, 'metaboxhidden_post', $unchecked);
            }
        }
    }
    add_action('admin_init', 'urna_tbay_edit_post_show_excerpt', 10);
}

if (! function_exists('urna_texttrim')) {
    function urna_texttrim($str)
    {
        return trim(preg_replace("/('|\"|\r?\n)/", '', $str));
    }
}

if (!function_exists('urna_tbay_VideoUrlType')) {
    function urna_tbay_VideoUrlType($url)
    {
        $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
        $has_match_youtube = preg_match($yt_rx, $url, $yt_matches);


        $vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/';
        $has_match_vimeo = preg_match($vm_rx, $url, $vm_matches);


        //Then we want the video id which is:
        if ($has_match_youtube) {
            $video_id = $yt_matches[5];
            $type = 'youtube';
        } elseif ($has_match_vimeo) {
            $video_id = $vm_matches[5];
            $type = 'vimeo';
        } else {
            $video_id = 0;
            $type = 'none';
        }


        $data['video_id'] = $video_id;
        $data['video_type'] = $type;

        return $data;
    }
}


/*Get query*/
if (!function_exists('urna_tbay_get_boolean_query_var')) {
    function urna_tbay_get_boolean_query_var($config)
    {
        $active = urna_tbay_get_config($config, true);

        $active = (isset($_GET[$config])) ? $_GET[$config] : $active;

        return (boolean)$active;
    }
}

if (!function_exists('urna_tbay_archive_blog_size_image')) {
    function urna_tbay_archive_blog_size_image()
    {
        $blog_size = urna_tbay_get_config('blog_image_sizes', 'medium');

        $blog_size = (isset($_GET['blog_image_sizes'])) ? $_GET['blog_image_sizes'] : $blog_size;

        return $blog_size;
    }
}
add_filter('urna_archive_blog_size_image', 'urna_tbay_archive_blog_size_image');

if (!function_exists('urna_tbay_archive_image_position')) {
    function urna_tbay_archive_image_position()
    {
        $position = urna_tbay_get_config('image_position', 'top');

        $position = (isset($_GET['image_position'])) ? $_GET['image_position'] : $position;

        return $position;
    }
}
add_filter('urna_archive_image_position', 'urna_tbay_archive_image_position');

if (!function_exists('urna_tbay_categories_blog_type')) {
    function urna_tbay_categories_blog_type()
    {
        $type = urna_tbay_get_config('categories_type', 'type-1');

        $type = (isset($_GET['categories_type'])) ? $_GET['categories_type'] : $type;

        return $type;
    }
}

if (!function_exists('urna_tbay_autocomplete_search')) {
    function urna_tbay_autocomplete_search()
    {
        if (urna_tbay_get_global_config('autocomplete_search', true)) {
            add_action('wp_ajax_urna_autocomplete_search', 'urna_tbay_autocomplete_suggestions');
            add_action('wp_ajax_nopriv_urna_autocomplete_search', 'urna_tbay_autocomplete_suggestions');
        }
    }
}
add_action('init', 'urna_tbay_autocomplete_search');

// cart Postion
if (!function_exists('urna_tbay_header_mobile_position')) {
    function urna_tbay_header_mobile_position()
    {
        $position = urna_tbay_get_config('header_mobile', 'v1');

        $position = (isset($_GET['header_mobile'])) ? $_GET['header_mobile'] : $position;

        return $position;
    }
    add_filter('urna_header_mobile_position', 'urna_tbay_header_mobile_position');
}

if (!function_exists('urna_tbay_offcanvas_smart_menu')) {
    function urna_tbay_offcanvas_smart_menu()
    {
        urna_tbay_get_page_templates_parts('device/offcanvas-smartmenu');
    }
    add_action('urna_before_theme_header', 'urna_tbay_offcanvas_smart_menu', 10);
}

if (!function_exists('urna_tbay_the_topbar_mobile')) {
    function urna_tbay_the_topbar_mobile()
    {
        $position = apply_filters('urna_header_mobile_position', 10, 2);

        urna_tbay_get_page_templates_parts('device/topbar-mobile', $position);
    }
    add_action('urna_before_theme_header', 'urna_tbay_the_topbar_mobile', 20);
}

if (!function_exists('urna_tbay_custom_form_login')) {
    function urna_tbay_custom_form_login()
    {
        if (defined('URNA_WOOCOMMERCE_ACTIVED') && URNA_WOOCOMMERCE_ACTIVED && !urna_catalog_mode_active()) {
            wc_get_template_part('myaccount/custom-form-login');
        }
    }
    add_action('urna_before_theme_header', 'urna_tbay_custom_form_login', 30);
}

if (!function_exists('urna_tbay_footer_mobile')) {
    function urna_tbay_footer_mobile()
    {
        if (urna_active_mobile_footer_icon()) {
            urna_tbay_get_page_templates_parts('device/footer-mobile');
        }
    }
    add_action('urna_before_theme_header', 'urna_tbay_footer_mobile', 40);
}

if (! function_exists('urna_active_mobile_footer_icon')) {
    function urna_active_mobile_footer_icon()
    {
        $active = urna_tbay_get_config('mobile_footer_icon', true);

        if ($active) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('urna_tbay_autocomplete_suggestions')) {
    function urna_tbay_autocomplete_suggestions()
    {
        check_ajax_referer('search_nonce', 'security');
        
        $args = array(
            'post_status'         => 'publish',
            'orderby'         	  => 'relevance',
            'posts_per_page'      => -1,
            'ignore_sticky_posts' => 1,
            'suppress_filters'    => 0,
        );

        if (! empty($_REQUEST['query'])) {
            $search_keyword = $_REQUEST['query'];
            $args['s'] = sanitize_text_field($_REQUEST['query']);
        }

        if (! empty($_REQUEST['search_in'])) {
            $options = $_REQUEST['search_in'];
        }

        if ($options === 'all') {
            $args_sku      = array(
                'post_type'        => 'product',
                'posts_per_page'   => -1,
                'meta_query'       => array(
                    array(
                        'key'     => '_sku',
                        'value'   => trim($search_keyword),
                        'compare' => 'like',
                    ),
                ),
                'suppress_filters' => 0,
            );

            $args_variation_sku = array(
                'post_type'        => 'product_variation',
                'posts_per_page'   => -1,
                'meta_query'       => array(
                    array(
                        'key'     => '_sku',
                        'value'   => trim($search_keyword),
                        'compare' => 'like',
                    ),
                ),
                'suppress_filters' => 0,
            );
        }

        if (! empty($_REQUEST['post_type'])) {
            $post_type = strip_tags($_REQUEST['post_type']);
        }

        if (isset($_REQUEST['post_type']) && $_REQUEST['post_type'] !== 'post' && class_exists('WooCommerce')) {
            $args['meta_query'] = WC()->query->get_meta_query();
            $args['tax_query'] 	= WC()->query->get_tax_query();
        }

        if (! empty($_REQUEST['number'])) {
            $number 	= (int) $_REQUEST['number'];
        }

        if (isset($_REQUEST['post_type']) && $_REQUEST['post_type'] != 'all') {
            $args['post_type'] = strip_tags($_REQUEST['post_type']);
        }


        if (isset($_REQUEST['product_cat']) && !empty($_REQUEST['product_cat'])) {
            if ($args['post_type'] == 'product') {
                $args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => strip_tags($_REQUEST['product_cat'])
                ) );


                if (version_compare(WC()->version, '2.7.0', '<')) {
                    $args['meta_query'] = array(
                        array(
                            'key'     => '_visibility',
                            'value'   => array( 'search', 'visible' ),
                            'compare' => 'IN'
                        ),
                    );
                } else {
                    $product_visibility_term_ids = wc_get_product_visibility_term_ids();
                    $args['tax_query'][] = array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'term_taxonomy_id',
                        'terms'    => $product_visibility_term_ids['exclude-from-search'],
                        'operator' => 'NOT IN',
                    );
                }
            } else {
                $args['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'category',
                        'field'    => 'id',
                        'terms'    => strip_tags($_REQUEST['product_cat']),
                    ));
            }
        }

        $results = new WP_Query($args);
 
        if ($options === 'all') {
            $products_sku 			= get_posts($args_sku);
            $products_variation_sku = get_posts($args_variation_sku);
            
            $post_ids = $sku_ids = $variation_sku_ids = array();

            if ($results->have_posts()) : while ($results->have_posts()) : $results->the_post();

            $post_ids[] = get_the_ID();

            endwhile;
            endif;
            wp_reset_postdata();

            $variation_sku_ids 	= wp_list_pluck($products_variation_sku, 'ID');
            $sku_ids 			= wp_list_pluck($products_sku, 'ID');

            $post_ids   = array_merge($post_ids, $sku_ids, $variation_sku_ids);

            $results = new WP_Query(array(
                'post_type' => 'product',
                'post__in'  => $post_ids,
            ));
        }

        $suggestions = array();

        $count = $results->post_count;

        $view_all = (($count - $number) > 0) ? true : false;
        $index = 0;
        if ($results->have_posts()) {
            if ($post_type == 'product') {
                $factory = new WC_Product_Factory();
            }


            while ($results->have_posts()) {
                if ($index == $number) {
                    break;
                }

                $results->the_post();

                if ($count == 1) {
                    $result_text = esc_html__('result found with', 'urna');
                } else {
                    $result_text = esc_html__('results found with', 'urna');
                }

                if ($post_type == 'product') {
                    $product = $factory->get_product(get_the_ID());
                    $suggestions[] = array(
                        'value' => html_entity_decode(get_the_title()),
                        'link' => get_the_permalink(),
                        'price' => $product->get_price_html(),
                        'image' => $product->get_image(),
                        'result' => '<span class="count">'.$count.' </span> '. $result_text .' <span class="keywork">"'. esc_html($search_keyword).'"</span>',
                        'view_all' => $view_all,
                    );
                } else {
                    $suggestions[] = array(
                        'value' => html_entity_decode(get_the_title()),
                        'link' => get_the_permalink(),
                        'image' => get_the_post_thumbnail(null, 'medium', ''),
                        'result' => '<span class="count">'.$count.' </span> '. $result_text .' <span class="keywork">"'. esc_html($search_keyword).'"</span>',
                        'view_all' => $view_all,
                    );
                }


                $index++;
            }

            wp_reset_postdata();
        } else {
            $suggestions[] = array(
                'value' => ($post_type == 'product') ? esc_html__('No products found.', 'urna') : esc_html__('No posts...', 'urna'),
                'no_found' => true,
                'link' => '',
                'view_all' => $view_all,
            );
        }

        echo json_encode(array(
            'suggestions' => $suggestions
        ));

        die();
    }
}

if (!function_exists('urna_add_cssclass')) {
    function urna_add_cssclass($add, $class)
    {
        $class = empty($class) ? $add : $class .= ' ' . $add;
        return $class;
    }
}



/*Fix woocomce don't active*/
if (!function_exists('urna_tbay_get_variation_swatchs')) {
    function urna_tbay_get_variation_swatchs()
    {
        $swatchs = array( '' => esc_html__('None', 'urna'));

        if (!(defined('URNA_WOOCOMMERCE_ACTIVED') && URNA_WOOCOMMERCE_ACTIVED)) {
            return $swatchs;
        }

        global $wc_product_attributes;
        // Array of defined attribute taxonomies.
        $attribute_taxonomies = wc_get_attribute_taxonomies();

        if (! empty($attribute_taxonomies)) {
            foreach ($attribute_taxonomies as $key => $tax) {
                $attribute_taxonomy_name = wc_attribute_taxonomy_name($tax->attribute_name);
                $label                   = $tax->attribute_label ? $tax->attribute_label : $tax->attribute_name;

                $swatchs[$attribute_taxonomy_name] = $label;
            }
        }

        return $swatchs;
    }
}

if (!function_exists('urna_tbay_get_custom_tab_layouts')) {
    function urna_tbay_get_custom_tab_layouts()
    {
        $tabs = array( '' => 'None');

        if (!(defined('URNA_WOOCOMMERCE_ACTIVED') && URNA_WOOCOMMERCE_ACTIVED)) {
            return $tabs;
        }
        $args = array(
      'posts_per_page'   => -1,
      'offset'           => 0,
      'orderby'          => 'date',
      'order'            => 'DESC',
      'post_type'        => 'tbay_customtab',
      'post_status'      => 'publish',
      'suppress_filters' => 0,
    );
        $posts = get_posts($args);
        foreach ($posts as $post) {
            $tabs[$post->post_name] = $post->post_title;
        }
        return $tabs;
    }
}

/*Get title mobile in top bar mobile*/
if (! function_exists('urna_tbay_get_title_mobile')) {
    function urna_tbay_get_title_mobile($title = '')
    {
        if (is_search()) {
            $title = esc_html__('Search results for', 'urna') . ' "' . get_search_query() . '"';
        } elseif (is_tag()) {
            $title = esc_html__('Posts tagged "', 'urna'). single_tag_title('', false) . '"';
        } elseif (is_category()) {
            $title = single_cat_title('', false);
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            $title = esc_html__('Articles posted by ', 'urna') . $userdata->display_name;
        } elseif (is_404()) {
            $title = esc_html__('Error 404', 'urna');
        } elseif (is_category()) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0) {
                echo(get_category_parents($parentCat, true, ' ' . $delimiter . ' '));
            }
            $title = single_cat_title('', false);
        } elseif (is_day()) {
            $title = get_the_time('d');
        } elseif (is_month()) {
            $title = get_the_time('F');
        } elseif (is_year()) {
            $title = get_the_time('Y');
        } elseif (is_single()  && !is_attachment()) {
            $title = get_the_title();
        } else {
            $title = get_the_title();
        }

        return $title;
    }
    add_filter('urna_get_filter_title_mobile', 'urna_tbay_get_title_mobile');
}


if (! function_exists('urna_tbay_get_cookie')) {
    function urna_tbay_get_cookie($name = '')
    {
        $check = (isset($_COOKIE[$name]) && !empty($_COOKIE[$name])) ? (boolean)$_COOKIE[$name] : false;
        return $check;
    }
}

if (! function_exists('urna_tbay_active_newsletter_sidebar')) {
    function urna_tbay_active_newsletter_sidebar()
    {
        $active = false;

        $cookie = urna_tbay_get_cookie('hiddenmodal');

        if (!$cookie && is_active_sidebar('newsletter-popup')) {
            $active = true;
        }

        return $active;
    }
}

if (! function_exists('urna_yith_compare_header')) {
    function urna_yith_compare_header()
    {
        if (class_exists('YITH_Woocompare')) { ?>
            <?php
                global $yith_woocompare;
            ?>
            <div class="yith-compare-header product">
                <a href="<?php echo esc_url($yith_woocompare->obj->view_table_url()); ?>" class="compare added">
					<i class="linear-icon-sync"></i>
					<?php apply_filters('urna_get_text_compare', ''); ?>
                </a>
            </div>
    <?php }
    }
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
if (! function_exists('urna_pingback_header')) {
    function urna_pingback_header()
    {
        if (is_singular() && pings_open()) {
            echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
        }
    }
    add_action('wp_head', 'urna_pingback_header', 30);
}


if (! function_exists('urna_tbay_checK_data_responsive')) {
    function urna_tbay_checK_data_responsive($columns, $desktop, $desktopsmall, $tablet, $landscape_mobile, $mobile)
    {
        $data_array = array();

        $data_array['desktop']          =      isset($desktop) ? $desktop : $columns;
        $data_array['desktopsmall']     =      isset($desktopsmall) ? $desktopsmall : 3;
        $data_array['tablet']           =      isset($tablet) ? $tablet : 3;
        $data_array['landscape']        =      isset($landscape_mobile) ? $landscape_mobile : 3;
        $data_array['mobile']           =      isset($mobile) ? $mobile : 2;

        return $data_array;
    }
}

if (! function_exists('urna_tbay_checK_data_responsive_carousel')) {
    function urna_tbay_checK_data_responsive_carousel($columns, $desktop, $desktopsmall, $tablet, $landscape_mobile, $mobile)
    {
        $data_responsive = urna_tbay_checK_data_responsive($columns, $desktop, $desktopsmall, $tablet, $landscape_mobile, $mobile);

        $datas = " data-items=\"". $columns ."\"";
        $datas .= " data-desktopslick=\"". $data_responsive['desktop'] ."\"";
        $datas .= " data-desktopsmallslick=\"". $data_responsive['desktopsmall'] ."\"";
        $datas .= " data-tabletslick=\"". $data_responsive['tablet'] ."\"";
        $datas .= " data-landscapeslick=\"". $data_responsive['landscape'] ."\"";
        $datas .= " data-mobileslick=\"". $data_responsive['mobile'] ."\"";

        return $datas;
    }
}


if (! function_exists('urna_tbay_checK_data_responsive_grid')) {
    function urna_tbay_checK_data_responsive_grid($columns, $desktop, $desktopsmall, $tablet, $landscape_mobile, $mobile)
    {
        $data_responsive = urna_tbay_checK_data_responsive($columns, $desktop, $desktopsmall, $tablet, $landscape_mobile, $mobile);

        $datas  = "";
        $datas .= " data-xlgdesktop=\"" . esc_attr($columns) ."\"";
        $datas .= " data-desktop=\"" . esc_attr($data_responsive['desktop']) ."\"";
        $datas .= " data-desktopsmall=\"" . esc_attr($data_responsive['desktopsmall']) ."\"";
        $datas .= " data-tablet=\"" . esc_attr($data_responsive['tablet']) ."\"";
        $datas .= " data-landscape=\"" . esc_attr($data_responsive['landscape']) ."\"";
        $datas .= " data-mobile=\"" . esc_attr($data_responsive['mobile']) ."\"";

        return $datas;
    }
}

if (! function_exists('urna_tbay_checK_data_carousel')) {
    function urna_tbay_checK_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile)
    {
        $data_array = array();

        $data_array['rows']				= isset($rows) ? $rows : 1;
        $data_array['nav'] 				= ($nav_type == 'yes') ? 'true' : 'false';
        $data_array['pagination'] 		= ($pagi_type == 'yes') ? 'true' : 'false';
        $data_array['loop'] 			= ($loop_type == 'yes') ? 'true' : 'false';
        $data_array['auto'] 			= ($auto_type == 'yes') ? 'true' : 'false';
        $data_array['autospeed'] 		= (!empty($autospeed_type)) ? $autospeed_type : 500;
        $data_array['disable_mobile'] 	= ($disable_mobile == 'yes') ? 'true' : 'false';

        return $data_array;
    }
}

if (! function_exists('urna_tbay_data_carousel')) {
    function urna_tbay_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile)
    {
        $data_array = urna_tbay_checK_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile);

        $datas  = " data-carousel=\"owl\"";
        $datas .= " data-rows=\"" . esc_attr($data_array['rows']) ."\"";
        $datas .= " data-nav=\"" . esc_attr($data_array['nav']) ."\"";
        $datas .= " data-pagination=\"" . esc_attr($data_array['pagination']) ."\"";
        $datas .= " data-loop=\"" . esc_attr($data_array['loop']) ."\"";
        $datas .= " data-auto=\"" . esc_attr($data_array['auto']) ."\"";
         
        if ($data_array['auto'] == 'true') {
            $datas .= " data-autospeed=\"" . esc_attr($data_array['autospeed']) ."\"";
        }

        $datas .= " data-unslick=\"" . esc_attr($data_array['disable_mobile']) ."\"";

        return $datas;
    }
}

// Search In Options
if (!function_exists('urna_tbay_search_in_options')) {
    function urna_tbay_search_in_options()
    {
        $search_in = urna_tbay_get_config('search_in_options', 'only_title');

        $get_search_in = (isset($_GET['search_in_options'])) ? $_GET['search_in_options'] : $search_in;

        if (in_array($get_search_in, array('only_title', 'all'))) {
            return $get_search_in;
        } else {
            return $search_in;
        }
    }
    add_filter('urna_search_in_options', 'urna_tbay_search_in_options');
}

if (!function_exists('urna_elementor_is_activated')) {
    function urna_elementor_is_activated()
    {
        return function_exists('elementor_load_plugin_textdomain');
    }
}

if (!function_exists('urna_vc_is_activated')) {
    function urna_vc_is_activated()
    {
        return class_exists('Vc_Manager');
    }
}

if (!function_exists('urna_wpml_is_activated')) {
    function urna_wpml_is_activated()
    {
        return class_exists('SitePress');
    }
}

if (!function_exists('urna_is_Woocommerce_activated')) {
    function urna_is_Woocommerce_activated()
    {
        return class_exists('WooCommerce') ? true : false;
    }
}

if (!function_exists('urna_is_woo_variation_swatches_pro')) {
    function urna_is_woo_variation_swatches_pro()
    {
        return class_exists('Woo_Variation_Swatches_Pro') ? true : false;
    }
}

if (!function_exists('urna_is_ajax_popup_quick')) {
    function urna_is_ajax_popup_quick()
    {
        $active = true;

        if (urna_is_woo_variation_swatches_pro()) {
            $active = false;
        }

        return $active;
    }
}

if (!function_exists('urna_is_merlin_activated')) {
    function urna_is_merlin_activated()
    {
        return class_exists('Merlin') ? true : false;
    }
}

if (!function_exists('urna_elements_ready_slick')) {
    function urna_elements_ready_slick()
    {
        $array = [
            'brands',
            'products',
            'posts-grid',
            'our-team',
            'product-category',
            'product-tabs',
            'testimonials',
            'product-categories-tabs',
            'categories-tabs-with-banner',
            'list-categories-product',
            'custom-image-list-categories',
            'custom-image-list-tags',
            'product-flash-sales',
            'product-list-tags',
            'product-recently-viewed',
            'product-count-down',
            'top-notification',
        ];
    
        return $array;
    }
}


if (!function_exists('urna_elements_ajax_tabs')) {
    function urna_elements_ajax_tabs()
    { 
        $array = [
            'product-categories-tabs',  
            'product-tabs',
        ];

        return $array;
    }
}

if (!function_exists('urna_elements_ready_countdown_timer')) {
    function urna_elements_ready_countdown_timer()
    {
        $array = [
            'product-count-down',
            'product-flash-sales',
        ];
    
        return $array;
    }
}
 
if (!function_exists('urna_elements_ready_layzyload_image')) {
    function urna_elements_ready_layzyload_image()
    {
        $array = [
            'product-flash-sales',
            'product-count-down',
            'brands',
            'products',
            'posts-grid',
            'our-team',
            'product-category',
            'product-tabs',
            'testimonials',
            'product-categories-tabs',
            'categories-tabs-with-banner',
            'list-categories-product',
            'custom-image-list-categories',
            'product-list-tags',
            'product-count-down',
            'custom-image-list-tags',
            'product-recently-viewed',
            'product-flash-sales',
        ];
    
        return $array;
    }
}

if (!function_exists('urna_elements_ready_treeview')) {
    function urna_elements_ready_treeview()
    {
        $array = [
            'nav-menu',
        ];
    
        return $array;
    }
}

if (!function_exists('urna_rocket_lazyload_exclude_class')) {
    function urna_rocket_lazyload_exclude_class($attributes)
    {
        $attributes[] = 'class="attachment-yith-woocompare-image size-yith-woocompare-image"';
        $attributes[] = 'class="header-logo-img"';
        $attributes[] = 'class="logo-mobile-img"';
        $attributes[] = 'class="mobile-infor-img"';
        $attributes[] = 'class="wpml-ls-flag"';
        $attributes[] = 'class="review-images"';

        return $attributes;
    }
    add_filter('rocket_lazyload_excluded_attributes', 'urna_rocket_lazyload_exclude_class');
}

if (!function_exists('urna_get_mobile_form_cart_style')) {
    function urna_get_mobile_form_cart_style()
    {
        $ouput = (!empty(urna_tbay_get_config('mobile_form_cart_style', 'default'))) ? urna_tbay_get_config('mobile_form_cart_style', 'default') : 'default';
    
        return $ouput;
    }
}

// catalog mode
if (!function_exists('urna_catalog_mode_active')) {
    function urna_catalog_mode_active()
    {
        $active = urna_tbay_get_config('enable_woocommerce_catalog_mode', false);

        $active = (isset($_GET['catalog_mode'])) ? $_GET['catalog_mode'] : $active;

        return $active;
    }
}

if ( ! function_exists( 'urna_clean' ) ) {
	function urna_clean( $var ) {
		if ( is_array( $var ) ) {
			return array_map( 'urna_clean', $var );
		} else {
			return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		}
	}
}

if ( ! function_exists( 'urna_clear_transient' ) ) {
	function urna_clear_transient() {
		delete_transient( 'urna-hash-time' );
	} 
	add_action( 'wp_update_nav_menu_item', 'urna_clear_transient', 11, 1 );
}

if (! function_exists('urna_nav_menu_get_menu_class')) {
    function urna_nav_menu_get_menu_class($layout, $header_type)
    {

        if( $header_type === 'builder' ) {
            $menu_class    = 'elementor-nav-menu menu nav navbar-nav megamenu';
        } else {
            $menu_class    = 'menu tbay-menu-category tbay-vertical';
        }

		switch ($layout) {
			case 'vertical':
				$menu_class .= ' flex-column';
				break;

			case 'treeview':
				$menu_class = 'menu navbar-nav';
				break;
			
			default:
				$menu_class .= ' flex-row';
				break;
		}

		return  $menu_class;
    }
}

if (! function_exists('urna_get_transliterate')) {
    function urna_get_transliterate( $slug ) {
        $prev_locale = setlocale(LC_CTYPE, 0);
        setlocale(LC_ALL, 'C.UTF-8');

        $slug = urldecode($slug);

        if (function_exists('iconv') && defined('ICONV_IMPL') && @strcasecmp(ICONV_IMPL, 'unknown') !== 0) {
            $slug = iconv('UTF-8', 'UTF-8//TRANSLIT//IGNORE', $slug);
        }

        setlocale(LC_ALL, $prev_locale);

        return $slug;
    }
}