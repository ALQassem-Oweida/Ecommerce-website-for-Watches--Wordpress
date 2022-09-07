<header id="tbay-header" class="site-header hidden-md hidden-sm hidden-xs <?php echo(urna_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">
	<div class="topbar">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					
					<?php if (is_active_sidebar('top-contact')) : ?>
						<div class="top-contact">
							<?php dynamic_sidebar('top-contact'); ?>
						</div>
					<?php endif;?>
				</div>
				<div class="col-md-9 topbar-right">
					<?php
                        urna_tbay_get_page_templates_parts('topbar-account');
                    ?>
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

                        do_action('urna_tbay_header_custom_language_wpml');
                    ?> 
                    
					<?php if (has_nav_menu('track-order')): ?>

			    		<?php urna_tbay_get_page_templates_parts('nav', 'track'); ?>
			    		
			    	<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
    <div class="header-main">
        <div class="container">
            <div class="row">
				<!-- //LOGO -->
                <div class="header-logo col-md-3">

                    <?php
                        urna_tbay_get_page_templates_parts('logo');
                        urna_tbay_get_page_templates_parts('flash-sale');
                    ?> 
                </div>
				
				<div class="header-search col-md-6">

					<div class="search-full">
	                	<?php urna_tbay_get_page_templates_parts('productsearchform'); ?>
					</div>

				</div>

				<div class="header-right col-md-3">
                	<!-- Compare -->
                	<?php urna_yith_compare_header(); ?>
                	
					<!-- Wishlist -->
					<?php
                        urna_tbay_get_page_templates_parts('wishlist');
                    ?>
                    
					<?php if (!urna_catalog_mode_active() && defined('URNA_WOOCOMMERCE_ACTIVED') && URNA_WOOCOMMERCE_ACTIVED): ?>
					<!-- Cart -->
					<div class="top-cart hidden-xs">
						<?php urna_tbay_get_woocommerce_mini_cart(); ?>
					</div>
					<?php endif; ?>

				</div>
				
            </div>
        </div>
    </div>
    <div class="header-mainmenu">
        <div class="container">
	        <div class="row">
				
			    <div class="tbay-mainmenu col-md-9 col-lg-10">
					
					<?php urna_tbay_get_page_templates_parts('nav'); ?>

			    </div>


			    <?php if (function_exists('urna_tbay_wc_the_recently_viewed')) : ?>
			    <div class="col-md-3 col-lg-2 recent-view">
				    <?php
                        urna_tbay_wc_the_recently_viewed();
                    ?>
			    </div>
			    <?php endif; ?>

	        </div>
        </div>
    </div>

    <div id="nav-cover"></div>
</header>