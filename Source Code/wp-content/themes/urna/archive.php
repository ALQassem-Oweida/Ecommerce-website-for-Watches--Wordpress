<?php
get_header();

$sidebar_configs = urna_tbay_get_blog_layout_configs();

urna_tbay_render_breadcrumbs();

if (isset($sidebar_configs['left']) && !isset($sidebar_configs['right'])) {
    $sidebar_configs['main']['class'] .= ' pull-right';
}

$class_main = apply_filters('urna_tbay_post_content_class', 'container');

if (isset($sidebar_configs['container_full']) &&  $sidebar_configs['container_full']) {
    $class_main .= ' container-full';
}

$blog_columns = apply_filters('loop_blog_columns', 1);

$columns	= $blog_columns;
if (isset($blog_columns) && $blog_columns >= 3) {
    $screen_desktop 		= 3;
    $screen_desktopsmall 	= 2;
    $screen_tablet 			= 2;
} else {
    $screen_desktop 		= $blog_columns;
    $screen_desktopsmall 	= $blog_columns;
    $screen_tablet 			= $blog_columns;
}

$screen_mobile 				= 1;

$data_responsive = ' data-xlgdesktop='. $columns .'';

$data_responsive .= ' data-desktop='. $screen_desktop .'';

$data_responsive .= ' data-desktopsmall='. $screen_desktopsmall .'';

$data_responsive .= ' data-tablet='. $screen_tablet .'';

$data_responsive .= ' data-mobile='. $screen_mobile .'';

?>
<header class="page-header">
	<div class="content <?php echo esc_attr($class_main); ?>">
	<?php
    the_archive_description('<div class="taxonomy-description">', '</div>');
    ?>
	</div>
</header><!-- .page-header -->
<section id="main-container" class="main-content  <?php echo esc_attr($class_main); ?> inner">

	<?php do_action('urna_post_template_main_container_before'); ?>

	<div class="row">
		
		

		<div id="main-content" class="col-xs-12 <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
			<div id="main" class="site-main layout-blog">

				<?php do_action('urna_post_template_main_content_before'); ?>

				<div class="row grid" <?php echo esc_attr($data_responsive); ?>>
					<?php if (have_posts()) : ?>

						<?php
                        // Start the Loop.
                        while (have_posts()) : the_post();

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            ?>

							<div>
						
								<?php get_template_part('post-formats/content', get_post_format()); ?>

							</div>

							<?php
                        // End the loop.
                        endwhile;

                        // Previous/next page navigation.
                        urna_tbay_paging_nav();

                    // If no content, include the "No posts found" template.
                    else :
                        get_template_part('post-formats/content', 'none');

                    endif;
                    ?>
				</div>

				<?php do_action('urna_post_template_main_content_after'); ?>

			</div><!-- .site-main -->
		</div><!-- .content-area -->
		 
		<?php if (isset($sidebar_configs['left']) && is_active_sidebar($sidebar_configs['left']['sidebar'])) : ?>
			<div class="<?php echo esc_attr($sidebar_configs['left']['class']) ;?>">
			  	<aside class="sidebar sidebar-left" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
			   		<?php dynamic_sidebar($sidebar_configs['left']['sidebar']); ?>
			  	</aside>
			</div>
		<?php endif; ?>

		<?php if (isset($sidebar_configs['right'])  && is_active_sidebar($sidebar_configs['right']['sidebar'])) : ?>
			<div class="<?php echo esc_attr($sidebar_configs['right']['class']) ;?>">
			  	<aside class="sidebar sidebar-right" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
			   		<?php dynamic_sidebar($sidebar_configs['right']['sidebar']); ?>
			  	</aside>
			</div>
		<?php endif; ?>
		
	</div>

	<?php do_action('urna_post_template_main_container_after'); ?>
</section>
<?php get_footer(); ?>
