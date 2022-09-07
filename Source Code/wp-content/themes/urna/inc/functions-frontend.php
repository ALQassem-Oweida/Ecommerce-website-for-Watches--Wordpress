<?php

if (! function_exists('urna_tbay_category')) {
    function urna_tbay_category($post)
    {
        // format
        $post_format = get_post_format();
        $header_class = $post_format ? '' : 'border-left';
        echo '<span class="category "> ';
        $cat = wp_get_post_categories($post->ID);
        $k   = count($cat);
        foreach ($cat as $c) {
            $categories = get_category($c);
            $k -= 1;
            if ($k == 0) {
                echo '<a href="' . esc_url(get_category_link($categories->term_id)) . '" class="categories-name"><i class="fa fa-bar-chart"></i>' . esc_html($categories->name) . '</a>';
            } else {
                echo '<a href="' . esc_url(get_category_link($categories->term_id)) . '" class="categories-name"><i class="fa fa-bar-chart"></i>' . esc_html($categories->name) . ', </a>';
            }
        }
        echo '</span>';
    }
}

if (! function_exists('urna_tbay_center_meta')) {
    function urna_tbay_center_meta($post)
    {
        // format
        $post_format = get_post_format();
        $id = get_the_author_meta('ID');
        echo '<div class="entry-meta">';
        the_title('<h4 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h4>');
        
        echo "<div class='entry-create'>";
        echo "<span class='entry-date'>". get_the_date('M d, Y').'</span>';
        "<span class='author'>". esc_html_e('/ By ', 'urna');
        the_author_posts_link() .'</span>';
        echo '</div>';
        echo '</div>';
    }
}



if (! function_exists('urna_tbay_full_top_meta')) {
    function urna_tbay_full_top_meta($post)
    {
        // format
        $post_format = get_post_format();
        $header_class = $post_format ? '' : 'border-left';
        echo '<header class="entry-header-top ' . esc_attr($header_class) . '">';
        if (!is_single()) {
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        }
        // details
        $id = get_the_author_meta('ID');
        echo '<span class="entry-profile"><span class="col"><span class="entry-author-link"><strong>' . esc_html__('By:', 'urna') . '</strong><span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url($id)) . '" rel="author">' . get_the_author() . '</a></span></span><span class="entry-date"><strong>'. esc_html__('Posted: ', 'urna') .'</strong>' . esc_html(get_the_date('M jS, Y')) . '</span></span></span>';
        // comments
        echo '<span class="entry-categories"><strong>'. esc_html__('In:', 'urna') .'</strong> ';
        $cat = wp_get_post_categories($post->ID);
        $k   = count($cat);
        foreach ($cat as $c) {
            $categories = get_category($c);
            $k -= 1;
            if ($k == 0) {
                echo '<a href="' . esc_url(get_category_link($categories->term_id)) . '" class="categories-name">' . esc_html($categories->name) . '</a>';
            } else {
                echo '<a href="' . esc_url(get_category_link($categories->term_id)) . '" class="categories-name">' . esc_html($categories->name) . ', </a>';
            }
        }
        echo '</span>';
        if (! is_search()) {
            if (! post_password_required() && (comments_open() || get_comments_number())) {
                echo '<span class="entry-comments-link">';
                comments_popup_link('0', '1', '%');
                echo '</span>';
            }
        }
        echo '</header>';
    }
}

if (! function_exists('urna_tbay_post_tags')) {
    function urna_tbay_post_tags()
    {
        $posttags = get_the_tags();
        if ($posttags) {
            echo '<div class="tagcloud"><span class="meta-title">'.esc_html__('Tags: ', 'urna').'</span>';
            
            $size = count($posttags);
            foreach ($posttags as $tag) {
                echo '<a href="' . get_tag_link($tag->term_id) . '">';
                echo trim($tag->name);
                echo '</a>';
            }
            echo '</div>';
        }
    }
    add_action('urna_tbay_post_bottom', 'urna_tbay_post_tags', 10);
}
if (! function_exists('urna_tbay_post_info_author')) {
    function urna_tbay_post_info_author()
    {
        $author_id = urna_tbay_get_id_author_post();

        if (defined('URNA_CORE_ACTIVED') && URNA_CORE_ACTIVED) {
            ?>
		<div class="author-info">
			<div class="avarta">
				<?php echo get_avatar($author_id, 90); ?>
			</div>
			<div class="content">
				<h4 class="name"><?php echo get_the_author(); ?></h4>
				<p><?php the_author_meta('description', $author_id) ?></p>
				<a href="<?php echo get_author_posts_url($author_id); ?>" class="all-post"><?php esc_html_e('all author posts', 'urna'); ?></a>
			</div>
		<?php
        }
    }
    add_action('urna_tbay_post_bottom', 'urna_tbay_post_info_author', 20);
}

if (! function_exists('urna_tbay_post_share_box')) {
    function urna_tbay_post_share_box()
    {
        if( !urna_tbay_get_config('enable_code_share', false) || !urna_tbay_get_config('show_blog_social_share') ) return;

            ?>
            <?php if( urna_tbay_get_config('select_share_type') == 'custom' ) : ?>
                <div class="tbay-post-share">
                    <?php  
                        $image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
                        urna_custom_share_code( get_the_title(), get_permalink(), $image );
                    ?>
                </div>
            <?php else: ?>
                <div class="tbay-post-share">
                    <div class="addthis_inline_share_toolbox"></div>
                </div>
            <?php endif; ?>
          <?php
    }
}

if (! function_exists('urna_tbay_post_format_link_helper')) {
    function urna_tbay_post_format_link_helper($content = null, $title = null, $post = null)
    {
        if (! $content) {
            $post = get_post($post);
            $title = $post->post_title;
            $content = $post->post_content;
        }
        $link = urna_tbay_get_first_url_from_string($content);
        if (! empty($link)) {
            $title = '<a href="' . esc_url($link) . '" rel="bookmark">' . $title . '</a>';
            $content = str_replace($link, '', $content);
        } else {
            $pattern = '/^\<a[^>](.*?)>(.*?)<\/a>/i';
            preg_match($pattern, $content, $link);
            if (! empty($link[0]) && ! empty($link[2])) {
                $title = $link[0];
                $content = str_replace($link[0], '', $content);
            } elseif (! empty($link[0]) && ! empty($link[1])) {
                $atts = shortcode_parse_atts($link[1]);
                $target = (! empty($atts['target'])) ? $atts['target'] : '_self';
                $title = (! empty($atts['title'])) ? $atts['title'] : $title;
                $title = '<a href="' . esc_url($atts['href']) . '" rel="bookmark" target="' . $target . '">' . $title . '</a>';
                $content = str_replace($link[0], '', $content);
            } else {
                $title = '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $title . '</a>';
            }
        }
        $out['title'] = '<h2 class="entry-title">' . $title . '</h2>';
        $out['content'] = $content;

        return $out;
    }
}


if (! function_exists('urna_tbay_breadcrumbs')) {
    function urna_tbay_breadcrumbs()
    {
        $delimiter = ' / ';
        $home = esc_html__('Home', 'urna');
        $before = '<li class="active">';
        $after = '</li>';
        $title = '';
        if (!is_home() && !is_front_page() || is_paged()) {
            echo '<ol class="breadcrumb">';

            global $post;
            $homeLink = esc_url(home_url());
            echo '<li><a href="' . esc_url($homeLink) . '" class="active">' . esc_html($home) . '</a> ' . esc_html($delimiter) . '</li> ';

            if (is_category()) {
                global $wp_query;
                $cat_obj = $wp_query->get_queried_object();
                $thisCat = $cat_obj->term_id;
                $thisCat = get_category($thisCat);
                $parentCat = get_category($thisCat->parent);
                if ($thisCat->parent != 0) {
                    echo(get_category_parents($parentCat, true, ' ' . $delimiter . ' '));
                }
                echo trim($before) . esc_html__('blog', 'urna') . $after;
            } elseif (is_day()) {
                echo '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li> ' . esc_html($delimiter) . ' ';
                echo '<li><a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . get_the_time('F') . '</a></li> ' . esc_html($delimiter) . ' ';
                echo trim($before) . get_the_time('d') . $after;
            } elseif (is_month()) {
                echo '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li> ' . esc_html($delimiter) . ' ';
                echo trim($before) . get_the_time('F') . $after;
            } elseif (is_year()) {
                echo trim($before) . get_the_time('Y') . $after;
            } elseif (is_single()  && !is_attachment()) {
                if (get_post_type() != 'post') {
                    $delimiter = '';
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    echo '<li><a href="' . esc_url($homeLink) . '/' . $slug['slug'] . '/">' . esc_html($post_type->labels->singular_name) . '</a></li> ' . esc_html($delimiter) . ' ';
                } else {
                    $delimiter = '';
                    $cat = get_the_category();
                    $cat = $cat[0];
                    echo '<li>'.get_category_parents($cat, true, ' ' . $delimiter . ' ').'</li>';
                }
            } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
                $post_type = get_post_type_object(get_post_type());
                if (is_object($post_type)) {
                    echo trim($before) . esc_html($post_type->labels->singular_name) . $after;
                }
            } elseif (is_attachment()) {
                $parent = get_post($post->post_parent);
                $cat = get_the_category($parent->ID);
                if (isset($cat) && !empty($cat)) {
                    $cat = $cat[0];
                    echo get_category_parents($cat, true, ' ' . $delimiter . ' ');
                }
                echo '<li><a href="' . esc_url(get_permalink($parent->ID)) . '">' . esc_html($parent->post_title) . '</a></li> ' . esc_html($delimiter) . ' ';
                echo trim($before) . get_the_title() . $after;
            } elseif (is_page() && !$post->post_parent) {
                echo trim($before) . esc_html__('Page', 'urna') . $after;
            } elseif (is_page() && $post->post_parent) {
                $parent_id  = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . get_the_title($page->ID) . '</a></li>';
                    $parent_id  = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb) {
                    echo trim($crumb) . ' ' . $delimiter . ' ';
                }
                echo trim($before) . esc_html__('Page', 'urna') . $after;
            } elseif (is_search()) {
                echo trim($before) . esc_html__('Search', 'urna') . $after;
            } elseif (is_tag()) {
                echo trim($before) . esc_html__('Tags', 'urna') . $after;
            } elseif (is_author()) {
                global $author;
                $userdata = get_userdata($author);
                echo trim($before) . esc_html__('Author', 'urna'). $after;
            } elseif (is_404()) {
                echo trim($before) . esc_html__('Error 404', 'urna') . $after;
            }

            echo '</ol>';
        }
    }
}

if (! function_exists('urna_tbay_render_breadcrumbs')) {
    function urna_tbay_render_breadcrumbs()
    {
        global $post;
        $show = true;
        $img = '';
        $style = array();


        $sidebar_configs = urna_tbay_get_blog_layout_configs();


        $breadcrumbs_layout = urna_tbay_get_config('blog_breadcrumb_layout', 'color');

        if (isset($post->ID) && !empty(get_post_meta($post->ID, 'tbay_page_breadcrumbs_layout', 'color'))) {
            $breadcrumbs_layout = get_post_meta($post->ID, 'tbay_page_breadcrumbs_layout', 'color');
        }

        if (isset($_GET['breadcrumbs_layout'])) {
            $breadcrumbs_layout = $_GET['breadcrumbs_layout'];
        }

        $class_container = '';
        if (isset($sidebar_configs['container_full']) &&  $sidebar_configs['container_full']) {
            $class_container = 'container-full';
        }

        switch ($breadcrumbs_layout) {
        case 'image':
            $breadcrumbs_class = ' breadcrumbs-image';
            break;
        case 'color':
            $breadcrumbs_class = ' breadcrumbs-color';
            break;
        case 'text':
            $breadcrumbs_class = ' breadcrumbs-text';
            break;
        default:
            $breadcrumbs_class  = ' breadcrumbs-image';
    }

        if (isset($sidebar_configs['breadscrumb_class'])) {
            $breadcrumbs_class .= ' '.$sidebar_configs['breadscrumb_class'];
        }
        if (is_page() && is_object($post)) {
            $show = get_post_meta($post->ID, 'tbay_page_show_breadcrumb', 'no');
        
            if (isset($show) && $show != 'yes') {
                return '';
            }

            $bgimage = get_post_meta($post->ID, 'tbay_page_breadcrumb_image', true);
            $bgcolor = get_post_meta($post->ID, 'tbay_page_breadcrumb_color', true);
            $style = array();
            if ($bgcolor && $breadcrumbs_layout !=='image' && $breadcrumbs_layout !=='text') {
                $style[] = 'background-color:'.$bgcolor;
            }
            if ($bgimage  && $breadcrumbs_layout !=='color' && $breadcrumbs_layout !=='text') {
                $img = ' <img src="'.esc_url($bgimage).'">  ';
            }
        } elseif (is_singular('post') || is_category() || is_home() || is_tag() || is_author() || is_day() || is_month() || is_year()  || is_search()) {
            $show = urna_tbay_get_config('show_blog_breadcrumb', false);

            if (!$show) {
                return '';
            }
            $breadcrumb_img = urna_tbay_get_config('blog_breadcrumb_image');

            $breadcrumb_color = urna_tbay_get_config('blog_breadcrumb_color');

            $style = array();
            if ($breadcrumb_color && $breadcrumbs_layout !=='image' && $breadcrumbs_layout !=='text') {
                $style[] = 'background-color:'.$breadcrumb_color;
            }
            if (isset($breadcrumb_img['url']) && !empty($breadcrumb_img['url']) && $breadcrumbs_layout !=='color' && $breadcrumbs_layout !=='text') {
                $img = ' <img src="'.$breadcrumb_img['url'].'">  ';
            }
        }

        $title = $nav = $title_bottom = '';


        if (is_category()) {
            $title_bottom = '<h1 class="page-title">'. single_cat_title('', false) .'</h1>';
        } elseif (is_tag()) {
            $title_bottom = '<h1 class="page-title">'. esc_html__('Posts tagged "', 'urna'). single_tag_title('', false) . '"</h1>';
        } elseif (is_day()) {
            $title_bottom = '<h1 class="page-title">'. get_the_time('d') . '</h1>';
        } elseif (is_month()) {
            $title_bottom = '<h1 class="page-title">'. get_the_time('F') . '</h1>';
        } elseif (is_year()) {
            $title_bottom = '<h1 class="page-title">'. get_the_time('Y') . '</h1>';
        } elseif (is_search()) {
            $title_bottom = '<h1 class="page-title">'. esc_html__('Search results for "', 'urna')  . get_search_query() . '"</h1>';
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            $title_bottom = '<h1 class="page-title">'. esc_html__('Articles posted by "', 'urna') . esc_html($userdata->display_name) . '"</h1>';
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            if (is_object($post_type)) {
                $title_bottom = '<h1 class="page-title">'. $post_type->labels->singular_name . '</h1>';
            }
        } elseif ((is_page() && $post->post_parent) || (is_page() && !$post->post_parent) || is_attachment()) {
            $title 			= '<h1 class="page-title">'. get_the_title() . '</h1>';
            $title_bottom 	= '';
        }

        if ($breadcrumbs_layout !== 'image') {
            if (!urna_tbay_is_home_page() && urna_tbay_get_config('enable_previous_page_post', true)) {
                $nav .= '<a href="javascript:history.back()" class="urna-back-btn"><i class="linear-icon-arrow-left"></i><span class="text">'. esc_html__('Previous page', 'urna') .'</span></a>';
                $breadcrumbs_class .= ' active-nav-right';
            }
            if (!urna_tbay_is_home_page() && isset($post->ID) && !empty(get_the_title($post->ID) && is_page())) {
                $title_bottom 		= '<h1 class="page-title">'. get_the_title($post->ID) .'</h1>';
                $title 				= '';
                $breadcrumbs_class .= ' show-title';
            }
            if (is_category() || is_author()) {
                $breadcrumbs_class .= ' show-title';
            }
            if (is_archive()) {
                $breadcrumbs_class .= ' blog';
            }
        }

        if (class_exists('WooCommerce') && (is_edit_account_page() || is_add_payment_method_page() || is_lost_password_page() || is_account_page() || is_view_order_page())) {
            $title_bottom = '';
            $breadcrumbs_class = trim(str_replace('show-title', '', $breadcrumbs_class));
        }
        $estyle = !empty($style)? ' style="'.implode(";", $style).'"':"";


        echo '<section id="tbay-breadscrumb" '. trim($estyle).' class="tbay-breadscrumb '.esc_attr($breadcrumbs_class).'">'. trim($img) .'<div class="container"><div class="breadscrumb-inner" >' . $title;
        urna_tbay_breadcrumbs();
        echo ''. $nav .'</div></div></section>';
        echo '<section id="tbay-breadscrumb-title"><div class="container">'. $title_bottom .'</div></section>';
    }
}

if (! function_exists('urna_tbay_render_title')) {
    function urna_tbay_render_title()
    {
        global $post;
         
        if (is_page() && is_object($post)) {
            $show = get_post_meta($post->ID, 'tbay_page_show_breadcrumb', 'no');

            if (!$show) {
                echo '<header class="entry-header"><h1 class="entry-title">'. get_the_title($post->ID) .'</h1></header>';
            }
        }
    }
}

if (!function_exists('urna_tbay_print_style_footer')) {
    function urna_tbay_print_style_footer()
    {
        $footer = urna_tbay_get_footer_layout();
        if ($footer) {
            $args = array(
                'name'        => $footer,
                'post_type'   => 'tbay_footer',
                'post_status' => 'publish',
                'numberposts' => 1
            );
            $posts = get_posts($args);
            foreach ($posts as $post) {
                return get_post_meta($post->ID, '_wpb_shortcodes_custom_css', true);
            }
        }
    }
    add_action('wp_head', 'urna_tbay_print_style_footer', 18);
}

if (!function_exists('urna_tbay_print_style_megamenu')) {
    function urna_tbay_print_style_megamenu()
    {
        $args = array(
                'post_type'   => 'tbay_megamenu',
                'post_status' => 'publish',
                'posts_per_page'      => -1,
            );
        $posts = get_posts($args);
 
        $custom_cs = '';
        foreach ($posts as $post) {
            $custom_cs .= get_post_meta($post->ID, '_wpb_shortcodes_custom_css', true);
        }

        return $custom_cs;
    }
}

if (!function_exists('urna_tbay_print_style_customtab')) {
    function urna_tbay_print_style_customtab()
    {
        $name = urna_tbay_get_config('custom_tab_type', '');

        if (!empty($name)) {
            $args = array(
                'name'        => $name,
                'post_type'   => 'tbay_customtab',
                'post_status' => 'publish',
                'numberposts' => 1
            );
            $posts = get_posts($args);

            foreach ($posts as $post) {
                return get_post_meta($post->ID, '_wpb_shortcodes_custom_css', true);
            }
        }
    }
}


if (!function_exists('urna_tbay_print_vc_style')) {
    function urna_tbay_print_vc_style()
    {
        $vc_style = '';
        $footer_style = urna_tbay_print_style_footer();
        if (!empty($footer_style)) {
            $vc_style .= $footer_style;
        }
        
        $megamenu_style = urna_tbay_print_style_megamenu();
        if (!empty($megamenu_style)) {
            $vc_style .= $megamenu_style;
        }

        $customtab = urna_tbay_print_style_customtab();
        if (!empty($customtab)) {
            $vc_style .= $customtab;
        }

        return $vc_style;
    }
}



if (! function_exists('urna_tbay_paging_nav')) {
    function urna_tbay_paging_nav()
    {
        global $wp_query, $wp_rewrite;

        if ($wp_query->max_num_pages < 2) {
            return;
        }

        $paged        = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
        $pagenum_link = html_entity_decode(get_pagenum_link());
        $query_args   = array();
        $url_parts    = explode('?', $pagenum_link);

        if (isset($url_parts[1])) {
            wp_parse_str($url_parts[1], $query_args);
        }

        $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
        $pagenum_link = trailingslashit($pagenum_link) . '%_%';

        $format  = $wp_rewrite->using_index_permalinks() && ! strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';

        // Set up paginated links.
        $links = paginate_links(array(
            'base'     => $pagenum_link,
            'format'   => $format,
            'total'    => $wp_query->max_num_pages,
            'current'  => $paged,
            'mid_size' => 1,
            'add_args' => array_map('urlencode', $query_args),
            'prev_text' => '<i class="linear-icon-arrow-left"></i>',
            'next_text' => '<i class="linear-icon-arrow-right"></i>'
        ));

        if ($links) :

        ?>
		<nav class="navigation paging-navigation">
			<h1 class="screen-reader-text hidden"><?php esc_html_e('Posts navigation', 'urna'); ?></h1>
			<div class="tbay-pagination">
				<?php echo trim($links); ?>
			</div><!-- .pagination -->
		</nav><!-- .navigation -->
		<?php
        endif;
    }
}


if (! function_exists('urna_tbay_post_nav')) {
    function urna_tbay_post_nav()
    {
        // Don't print empty markup if there's nowhere to navigate.
        $previous = (is_attachment()) ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
        $next     = get_adjacent_post(false, '', false);

        if (! $next && ! $previous) {
            return;
        } ?>
		<nav class="navigation post-navigation">
			<h3 class="screen-reader-text"><?php esc_html_e('Post navigation', 'urna'); ?></h3>
			<div class="nav-links clearfix">
				<?php
                if (is_attachment()) :
                    previous_post_link('%link', '<div class="col-lg-6"><span class="meta-nav">'. esc_html__('Published In', 'urna').'</span></div>'); else :
                    previous_post_link('%link', '<div class="pull-left"><span class="meta-nav">'. esc_html__('Previous Post', 'urna').'</span></div>');
        next_post_link('%link', '<div class="pull-right"><span class="meta-nav">' . esc_html__('Next Post', 'urna').'</span><span></span></div>');
        endif; ?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
    }
}

if (!function_exists('urna_tbay_pagination')) {
    function urna_tbay_pagination($per_page, $total, $max_num_pages = '')
    {
        global $wp_query, $wp_rewrite; ?>
        <div class="tbay-pagination">
        	<?php
            $prev = esc_html__('Previous', 'urna');
        $next = esc_html__('Next', 'urna');
        $pages = $max_num_pages;
        $args = array('class'=>'pull-left');

        $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
        if (empty($pages)) {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }
        $pagination = array(
                'base' => @add_query_arg('paged', '%#%'),
                'format' => '',
                'total' => $pages,
                'current' => $current,
                'prev_text' => $prev,
                'next_text' => $next,
                'type' => 'array'
            );

        if ($wp_rewrite->using_permalinks()) {
            $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged');
        }
            
        if (isset($_GET['s'])) {
            $cq = $_GET['s'];
            $sq = str_replace(" ", "+", $cq);
        }
            
        if (!empty($wp_query->query_vars['s'])) {
            $pagination['add_args'] = array( 's' => $sq);
        }
        $paginations = paginate_links($pagination);
        if (!empty($paginations)) {
            echo '<ul class="pagination '.esc_attr($args["class"]).'">';
            foreach ($paginations as $key => $pg) {
                echo '<li>'. esc_html($pg) .'</li>';
            }
            echo '</ul>';
        } ?>
            
        </div>
    <?php
    }
}

if (!function_exists('urna_tbay_get_post_galleries')) {
    function urna_tbay_get_post_galleries($size='full')
    {
        $ids = get_post_meta(get_the_ID(), 'tbay_post_gallery_files');

        $output = array();

        if (!empty($ids)) {
            $id = $ids[0];

            if (is_array($id) || is_object($id)) {
                foreach ($id as $id_img => $link_img) {
                    $image = wp_get_attachment_image_src($id_img, $size);
                    $output[] = $image[0];
                }
            }
        }
        
        return $output;
    }
}

if (!function_exists('urna_tbay_comment_form')) {
    function urna_tbay_comment_form($arg, $class = 'btn-primary btn-outline ')
    {
        global $post;
        if ('open' == $post->comment_status) {
            ob_start();
            comment_form($arg);
            $form = ob_get_clean(); ?>
	      	<div class="commentform reset-button-default">
		    	<?php
                  echo str_replace('id="submit"', 'id="submit"', $form); ?>
	      	</div>
	      	<?php
        }
    }
}

if (!function_exists('urna_tbay_list_comment')) {
    function urna_tbay_list_comment($comment, $args, $depth)
    {
        if (is_file(get_template_directory().'/list_comments.php')) {
            require get_template_directory().'/list_comments.php';
        }
    }
}

if (!function_exists('urna_tbay_get_header_layouts')) {
    function urna_tbay_get_header_layouts()
    {
        $headers = array();
        $args = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'post_type'        => 'tbay_header',
            'post_status'      => 'publish',
            'suppress_filters' => 0
        );
        $posts = get_posts($args);
        foreach ($posts as $post) {
            $headers[$post->post_name] = $post->post_title;
        }
        return $headers;
    }
}

if (!function_exists('urna_tbay_get_header_layout')) {
    function urna_tbay_get_header_layout()
    {
        return urna_tbay_get_config('header_type', 'default');
    }
    add_filter('urna_tbay_get_header_layout', 'urna_tbay_get_header_layout');
}

if (!function_exists('urna_tbay_display_header_builder')) {
    function urna_tbay_display_header_builder()
    {
        echo urna_get_display_header_builder();
    }
}

if (!function_exists('urna_get_elementor_css_print_method')) {
    function urna_get_elementor_css_print_method()
    {
        if ('internal' !== get_option('elementor_css_print_method')) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('urna_get_display_header_builder')) {
    function urna_get_display_header_builder()
    {
        $header 	= apply_filters('urna_tbay_get_header_layout', 'default');

        $args = array(
            'name'		 => $header,
            'post_type'   => 'tbay_header',
            'post_status' => 'publish',
            'numberposts' => 1
        );
 
        $posts = get_posts($args);

        return  ( !empty($posts[0]->ID) ) ? urna_get_html_custom_post($posts[0]->ID) : '';
    }
    /*Put CSS elementor post to first */
    add_action('wp', 'urna_get_display_header_builder');
}


if (!function_exists('urna_get_display_footer_builder')) {
    function urna_get_display_footer_builder($footer)
    {
        global $footer_builder;

        $footer_builder = true;
        $args = array(
            'name'        => $footer,
            'post_type'   => 'tbay_footer',
            'post_status' => 'publish',
            'numberposts' => 1
        );

        $posts = get_posts($args);

        if( empty($posts) ) return;

        if (urna_elementor_is_activated() && Elementor\Plugin::instance()->documents->get( $posts[0]->ID )->is_built_with_elementor()) {
            $ouput = '<footer id="tbay-customize-footer" class="tbay-customize-footer">';
            $ouput .= Elementor\Plugin::instance()->frontend->get_builder_content_for_display($posts[0]->ID, urna_get_elementor_css_print_method());
            $ouput .= '</footer>';

            return $ouput;
        } else {
            $ouput = '<footer id="tbay-footer" class="tbay-footer">';
            $ouput .= '<div class="footer"><div class="container">';
            $ouput .= do_shortcode($posts[0]->post_content);
            $ouput .= '</div></div>';
            $ouput .= '</footer>';

            return $ouput;
        }

        $footer_builder = false;
    }
}

if (!function_exists('urna_tbay_display_footer_builder')) {
    function urna_tbay_display_footer_builder($footer)
    {
        echo urna_get_display_footer_builder($footer);
    }
}

if( ! function_exists( 'urna_get_html_custom_post' ) ) {
	function urna_get_html_custom_post($id) { 
        if( is_null($id) ) return;
        
        $post = get_post( $id );

        if ( urna_elementor_is_activated() && Elementor\Plugin::instance()->documents->get( $id )->is_built_with_elementor() ) {
            return Elementor\Plugin::instance()->frontend->get_builder_content_for_display($id, urna_get_elementor_css_print_method());
        } else { 
            return do_shortcode($post->post_content);
        }
	}

}

if (!function_exists('urna_tbay_get_random_blog_cat')) {
    function urna_tbay_get_random_blog_cat()
    {
        $post_category = "";
        $categories = get_the_category();

        $number = rand(0, count($categories) - 1);

        if ($categories) {
            $post_category .= '<a href="'.esc_url(get_category_link($categories[$number]->term_id)).'" title="' . esc_attr(sprintf(esc_html__("View all posts in %s", 'urna'), $categories[$number]->name)) . '">'.$categories[$number]->cat_name.'</a>';
        }

        echo trim($post_category);
    }
}

if (!function_exists('urna_tbay_get_id_author_post')) {
    function urna_tbay_get_id_author_post()
    {
        global $post;

        $author_id = $post->post_author;

        if (isset($author_id)) {
            return $author_id;
        }
    }
}


if (! function_exists('urna_body_class_mobile_footer')) {
    function urna_body_class_mobile_footer($classes)
    {
        $mobile_footer = urna_tbay_get_config('mobile_footer', true);

        if (isset($mobile_footer) && !$mobile_footer) {
            $classes[] = 'mobile-hidden-footer';
        }
        return $classes;
    }
    add_filter('body_class', 'urna_body_class_mobile_footer', 99);
}

if (! function_exists('urna_body_class_header_mobile')) {
    function urna_body_class_header_mobile($classes)
    {
        $layout = urna_tbay_get_config('header_mobile', 'center');

        if (isset($layout)) {
            $classes[] = 'header-mobile-'.$layout;
        }
        return $classes;
    }
    add_filter('body_class', 'urna_body_class_header_mobile', 99);
}

//Add div wrapper author and name in comment form
if (!function_exists('urna_tbay_comment_form_fields_open')) {
    function urna_tbay_comment_form_fields_open()
    {
        echo '<div class="comment-form-fields-wrapper">';
    }
}
if (!function_exists('urna_tbay_comment_form_fields_close')) {
    function urna_tbay_comment_form_fields_close()
    {
        echo '</div>';
    }
}
add_action('comment_form_before_fields', 'urna_tbay_comment_form_fields_open');
add_action('comment_form_after_fields', 'urna_tbay_comment_form_fields_close');

if (!function_exists('urna_the_post_category_full')) {
    function urna_the_post_category_full($has_separator = true)
    {
        $post_category = "";
        $categories = get_the_category();
        $separator = ($has_separator) ?  ',' : '';
        $output = '';
        if ($categories) {
            foreach ($categories as $category) {
                $output .= '<a href="'.esc_url(get_category_link($category->term_id)).'" title="' . esc_attr(sprintf(esc_html__('View all posts in %s', 'urna'), $category->name)) . '">'.$category->cat_name.'</a>'.$separator;
            }
            $post_category = trim($output, $separator);
        }

        echo trim($post_category);
    }
}

//Check active WPML
if (!function_exists('urna_tbay_wpml')) {
    function urna_tbay_wpml()
    {
        if (is_active_sidebar('wpml-sidebar')) {
            dynamic_sidebar('wpml-sidebar');
        }
    }

    add_action('urna_tbay_header_custom_language_wpml', 'urna_tbay_wpml', 10);
}

//Config Layout Blog
if (!function_exists('urna_tbay_get_blog_layout_configs')) {
    function urna_tbay_get_blog_layout_configs()
    {
        if (!is_singular('post')) {
            $page = 'blog_archive_sidebar';
        } else {
            $page = 'blog_single_sidebar';
        }

        $sidebar = urna_tbay_get_config($page);



        if (!is_singular('post')) {
            $blog_archive_layout =  (isset($_GET['blog_archive_layout']))  ? $_GET['blog_archive_layout'] : urna_tbay_get_config('blog_archive_layout', 'main-right');

            if (isset($blog_archive_layout)) {
                switch ($blog_archive_layout) {
                    case 'left-main':
                        $configs['left'] = array( 'sidebar' => $sidebar, 'class' => 'col-xs-12 col-md-4'  );
                        $configs['main'] = array( 'class' => 'col-md-8' );
                        break;
                    case 'main-right':
                        $configs['right'] = array( 'sidebar' => $sidebar,  'class' => 'col-xs-12 col-md-4' );
                        $configs['main'] = array( 'class' => 'col-md-8' );
                        break;
                    case 'main':
                        $configs['main'] = array( 'class' => '' );
                        break;
                    default:
                        $configs['main'] = array( 'class' => '' );
                        break;
                   }

                if ($blog_archive_layout === 'left-main' && empty($configs['left']['sidebar'])) {
                    $configs['main'] = array( 'class' => '' );
                } elseif ($blog_archive_layout === 'main-right' && empty($configs['right']['sidebar'])) {
                    $configs['main'] = array( 'class' => '' );
                }
            }
        } else {
            $blog_single_layout =	(isset($_GET['blog_single_layout'])) ? $_GET['blog_single_layout']  :  urna_tbay_get_config('blog_single_layout', 'left-main');

            if (isset($blog_single_layout)) {
                switch ($blog_single_layout) {
                        case 'left-main':
                            $configs['left'] = array( 'sidebar' => $sidebar, 'class' => 'col-xs-12 col-md-12 col-lg-4'  );
                            $configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-8' );
                            break;
                        case 'main-right':
                            $configs['right'] = array( 'sidebar' => $sidebar,  'class' => 'col-xs-12 col-md-12 col-lg-4' );
                            $configs['main'] = array( 'class' => 'col-xs-12 col-md-12 col-lg-8' );
                            break;
                        case 'main':
                            $configs['main'] = array( 'class' => 'col-xs-12 single-full' );
                            break;
                        default:
                            $configs['main'] = array( 'class' => 'col-xs-12 single-full' );
                            break;
                     }
                     

                if ($blog_single_layout === 'left-main' && empty($configs['left']['sidebar'])) {
                    $configs['main'] = array( 'class' => 'col-xs-12 single-full' );
                } elseif ($blog_single_layout === 'main-right' && empty($configs['right']['sidebar'])) {
                    $configs['main'] = array( 'class' => 'col-xs-12 single-full' );
                }
            }
        }


        return $configs;
    }
}

if (! function_exists('urna_tbay_add_bg_close_canvas_menu')) {
    function urna_tbay_add_bg_close_canvas_menu()
    {
        $sidebar_id = 'canvas-menu';
        if (!is_active_sidebar($sidebar_id) || urna_tbay_get_config('select-header-page', 'default') !== 'default') {
            return;
        }
        
        if (get_post_type() === 'tbay_footer') {
            return;
        } ?>
			<div class="bg-close-canvas-menu"></div>
 			<div class="sidebar-content-wrapper">

				<div class="sidebar-header">
					<a href="javascript:void(0);" class="close-canvas-menu"><?php esc_html_e('Close', 'urna'); ?><i class="linear-icon-cross2"></i></a>
				</div>

				<div class="sidebar-content">
					<?php dynamic_sidebar($sidebar_id); ?>
				</div>

			</div>
		<?php
    }
    add_action('wp_footer', 'urna_tbay_add_bg_close_canvas_menu');
}

if ( ! function_exists( 'urna_get_social_html' ) ) {
	function urna_get_social_html($key, $value, $title, $link, $media) {
		if( !$value ) return;

		switch ($key) {
			case 'facebook':
				$output = sprintf(
					'<a class="share-facebook urna-facebook" title="%s" href="http://www.facebook.com/sharer.php?u=%s&t=%s" target="_blank"><i class="fa fa-facebook"></i></a>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title )
				);
				break;			
			case 'twitter':
				$output = sprintf(
					'<a class="share-twitter urna-twitter" href="http://twitter.com/share?text=%s&url=%s" title="%s" target="_blank"><i class="fa fa-twitter"></i></a>',
					esc_attr( $title ),
					urlencode( $link ),
					urlencode( $title )
				);
				break;			
			case 'linkedin':
				$output = sprintf(
					'<a class="share-linkedin urna-linkedin" href="http://www.linkedin.com/shareArticle?url=%s&title=%s" title="%s" target="_blank"><i class="fa fa-linkedin"></i></a>',
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
				break;			

			case 'pinterest':
				$output = sprintf(
					'<a class="share-pinterest urna-pinterest" href="http://pinterest.com/pin/create/button?media=%s&url=%s&description=%s" title="%s" target="_blank"><i class="fa fa-pinterest-p"></i></a>',
					urlencode( $media ),
					urlencode( $link ),
					esc_attr( $title ),
					urlencode( $title )
				);
				break;			

			case 'whatsapp':
				$output = sprintf(
					'<a class="share-whatsapp urna-whatsapp" href="https://api.whatsapp.com/send?text=%s" title="%s" target="_blank"><i class="fa fa-whatsapp"></i></a>',
					urlencode( $link ),
					esc_attr( $title )
				);
				break;

			case 'email':
				$output = sprintf(
					'<a class="share-email urna-email" href="mailto:?subject=%s&body=%s" title="%s" target="_blank"><i class="fa fa-envelope-o"></i></a>',
					esc_html( $title ),
					urlencode( $link ),
					esc_attr( $title )
				);
				break;
			
			default:
				# code...
				break;
		}

		return $output;
	}
}

if ( ! function_exists( 'urna_custom_share_code' ) ) {
	function urna_custom_share_code( $title, $link, $media ) {
		if( !urna_tbay_get_config('enable_code_share', true) ) return;

		if( !is_singular( 'post') && !is_singular( 'product' ) ) return;

		$socials = urna_tbay_get_config('sortable_sharing');

		$socials_html = '';
		foreach ($socials as $key => $value) {
			$socials_html .= urna_get_social_html($key, $value, $title, $link, $media);
		}


		if ( $socials_html ) {
			$socials_html = apply_filters('urna_addons_share_link_socials', $socials_html);
			printf( '<div class="urna-social-links">%s</div>', $socials_html );
		}

	}
}


if (!function_exists('urna_switcher_to_boolean')) {
    function urna_switcher_to_boolean($var)
    {
        if ($var === 'yes') {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('urna_is_cmb2')) {
    function urna_is_cmb2()
    {
        return defined('CMB2_LOADED') ? true : false;
    }
}

if (! function_exists('urna_tbay_woocs_redraw_cart')) {
    function urna_tbay_woocs_redraw_cart()
    {
        return 0;
    }
    add_filter('woocs_redraw_cart', 'urna_tbay_woocs_redraw_cart', 10, 1);
}

if( ! function_exists('urna_load_html_dropdowns_action') ) {
	function urna_load_html_dropdowns_action() {
		$response = array(
			'status' => 'error',
			'message' => 'Can\'t load HTML blocks with AJAX',
			'data' => array(),
		);

        if( urna_vc_is_activated() ) {
            WPBMap::addAllMappedShortcodes();
        }

		if( isset( $_POST['ids'] ) && is_array( $_POST['ids'] ) ) {
			$ids = urna_clean( $_POST['ids'] );
			foreach ($ids as $id) {
				$id = (int) $id;
				$content = urna_get_html_custom_post($id);
				if( ! $content ) continue;
 
				$response['status'] = 'success';
				$response['message'] = 'At least one HTML block loaded';
				$response['data'][$id] = do_shortcode($content);
			}
		}

		echo json_encode($response);

		die();
	}
	add_action( 'wp_ajax_urna_load_html_dropdowns', 'urna_load_html_dropdowns_action' );
	add_action( 'wp_ajax_nopriv_urna_load_html_dropdowns', 'urna_load_html_dropdowns_action' );
}

if( ! function_exists('urna_load_html_click_action') ) {
	function urna_load_html_click_action() {
		$response = array(
			'status' => 'error',
			'message' => 'Can\'t load HTML blocks with AJAX',
			'data' => array(),
		);

		if( ! empty( $_POST['slug'] ) ) {
			$slug 			    = urna_clean( $_POST['slug'] );
			$layout 		    = urna_clean( $_POST['layout'] );
			$header_type 		= urna_clean( $_POST['header_type'] );

            $args = [
                'echo'        => false,
                'menu'        => $slug, 
                'container_class' => 'collapse navbar-collapse',
                'menu_id'     => $slug,
                'walker'      => new Urna_Tbay_Nav_Menu(),
                'fallback_cb' => '__return_empty_string',
                'container'   => '', 
                'items_wrap'  => '<ul id="%1$s" class="%2$s" data-id="'. $slug .'">%3$s</ul>',
            ];   

			$args['menu_class'] = urna_nav_menu_get_menu_class($layout, $header_type);


            $content = wp_nav_menu($args);     

            $response['status']     = 'success';
            $response['message']    = 'At least one HTML Menu Canvas loaded';
            $response['data']       = $content;
		}

		echo json_encode($response);

		die();
	}
	add_action( 'wp_ajax_urna_load_html_click', 'urna_load_html_click_action' );
	add_action( 'wp_ajax_nopriv_urna_load_html_click', 'urna_load_html_click_action' );
}

if( ! function_exists('urna_load_html_canvas_click_action') ) {
	function urna_load_html_canvas_click_action() {
		$response = array(
			'status' => 'error',
			'message' => 'Can\'t load HTML blocks with AJAX',
			'data' => array(),
		);

		if( ! empty( $_POST['slug'] ) ) {
			$slug 			    = urna_clean( $_POST['slug'] ); 

            $args = [
                'echo'        => false,
                'menu'        => $slug, 
                'container_class' => 'collapse navbar-collapse',
                'menu_id'     => $slug,
                'walker'      => new Urna_Tbay_Nav_Menu(),
                'fallback_cb' => '__return_empty_string',
                'container'   => '', 
                'items_wrap'  => '<ul id="%1$s" class="%2$s" data-id="'. $slug .'">%3$s</ul>',
            ];     

			$args['menu_class'] = 'nav navbar-nav';


            $content = wp_nav_menu($args);     

            $response['status']     = 'success';
            $response['message']    = 'At least one HTML Menu Canvas loaded';
            $response['data']       = $content;
		}

		echo json_encode($response);

		die();
	}
	add_action( 'wp_ajax_urna_load_html_canvas_click', 'urna_load_html_canvas_click_action' );
	add_action( 'wp_ajax_nopriv_urna_load_html_canvas_click', 'urna_load_html_canvas_click_action' );
}