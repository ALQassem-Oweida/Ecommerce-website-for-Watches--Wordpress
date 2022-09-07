<?php

get_header();
$sidebar_configs = urna_tbay_get_page_layout_configs();

urna_tbay_render_breadcrumbs();

if (isset($sidebar_configs['left']) && !isset($sidebar_configs['right'])) {
    $sidebar_configs['main']['class'] .= ' pull-right';
}

?>

<section id="main-container" class="<?php echo apply_filters('urna_tbay_page_content_class', 'container');?> inner">
		
		<div id="main-content" class="main-page <?php echo esc_attr($sidebar_configs['main']['class']); ?>">
			<div id="main" class="site-main">

				<?php
                    urna_tbay_render_title();
                ?>

				<?php
                // Start the loop.
                while (have_posts()) : the_post();
                
                    // Include the page content template.
                    the_content();
 
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;

                // End the loop.
                endwhile;
                ?>
			</div><!-- .site-main -->

		</div><!-- .content-area -->
		
		<?php if (isset($sidebar_configs['left']) && is_active_sidebar($sidebar_configs['left']['sidebar']) && !isset($sidebar_configs['right'])) : ?>
			<div class="<?php echo esc_attr($sidebar_configs['left']['class']) ;?>">
			  	<aside class="sidebar sidebar-left" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
			   		<?php dynamic_sidebar($sidebar_configs['left']['sidebar']); ?>
			  	</aside>
			</div>
		<?php endif; ?>
		
		<?php if (isset($sidebar_configs['right']) && is_active_sidebar($sidebar_configs['right']['sidebar'])) : ?>
			<div class="<?php echo esc_attr($sidebar_configs['right']['class']) ;?>">
			  	<aside class="sidebar sidebar-right" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
			   		<?php dynamic_sidebar($sidebar_configs['right']['sidebar']); ?>
			  	</aside>
			</div>
		<?php endif; ?>
		
</section>
<?php get_footer(); ?>