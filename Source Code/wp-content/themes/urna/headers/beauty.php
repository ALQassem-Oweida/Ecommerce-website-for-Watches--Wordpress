<header id="tbay-header" class="site-header hidden-md hidden-sm hidden-xs <?php echo(urna_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">
	<div class="topbar">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-2">
					<!-- LOGO -->
	                <div class="header-logo">
	                    <?php urna_tbay_get_page_templates_parts('logo'); ?> 
	                </div>

				</div>

				<div class="col-md-10 topbar-right">

					<?php
                        if (class_exists('WooCommerce') && class_exists('WOOCS')) {
                            wp_enqueue_style('sumoselect');
                            wp_enqueue_script('jquery-sumoselect'); ?>
							<div class="tbay-currency">
							<?php
                                echo do_shortcode('[woocs]'); ?>
							</div>
							<?php
                        }
                    ?>

					<!-- CUSTOM LANGUAGE -->
					<?php do_action('urna_tbay_header_custom_language_wpml'); ?>

					<!-- TRACK ORDER -->
					<?php if (has_nav_menu('track-order')): ?>
			    		<?php urna_tbay_get_page_templates_parts('nav', 'track'); ?>
		    		<?php endif; ?>

		    		<?php if (function_exists('urna_tbay_wc_the_recently_viewed')) : ?>
			    		<!-- RECENT VIEW -->
			    		<div class="recent-view">
					    	<?php urna_tbay_wc_the_recently_viewed(); ?>
				    	</div>
				    <?php endif; ?>

					<!-- TOP-CONTACT -->
					<?php if (is_active_sidebar('top-contact')) : ?>
						<div class="top-contact">
							<?php dynamic_sidebar('top-contact'); ?>
						</div>
					<?php endif;?>

					<!-- SOCIAL -->
					<?php if (is_active_sidebar('top-info')) : ?>
						<div class="top-info">
							<?php dynamic_sidebar('top-info'); ?>
						</div>
					<?php endif;?>
					
				</div>
			</div>
		</div>
	</div>
    <div class="header-main">
        <div class="container-fluid">
            <div class="row">
				
				<div class="header-left col-md-2">
					<?php if (has_nav_menu('nav-category-menu')): ?>
					<?php urna_tbay_get_page_templates_parts('category', 'menu-canvas'); ?>
					<?php endif; ?>
				</div>
	            
	            <!-- MAINMENU -->
				<div class="col-md-7 tbay-mainmenu">
					<?php urna_tbay_get_page_templates_parts('nav'); ?>
				</div>
				
				<div class="header-right col-md-3">

					<!-- SEARCH -->
					<div class="search"> 
	                	<?php urna_tbay_get_page_templates_parts('productsearchform', 'canvas-v2'); ?>
					</div>

					<!-- TOPBAR ACCOUNT -->
					<?php urna_tbay_get_page_templates_parts('topbar-account'); ?>
					<?php
                        if (class_exists('WooCommerce') && class_exists('WOOCS')) {
                            wp_enqueue_style('sumoselect');
                            wp_enqueue_script('jquery-sumoselect');
                        }
                    ?>

                	<!-- Compare -->
                	<?php urna_yith_compare_header(); ?>

					<!-- WISHLIST -->
					<?php
                        urna_tbay_get_page_templates_parts('wishlist');
                    ?>
                    
					<?php if (!urna_catalog_mode_active() && defined('URNA_WOOCOMMERCE_ACTIVED') && URNA_WOOCOMMERCE_ACTIVED): ?>

					<!-- CART -->
					<div class="top-cart hidden-xs">
						<?php urna_tbay_get_woocommerce_mini_cart(); ?>
					</div>
					<?php endif; ?>

				</div>
            </div>
        </div>
    </div>
    <div id="nav-cover"></div>
</header>