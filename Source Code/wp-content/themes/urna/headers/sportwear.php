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
					<!-- track-order -->
					<?php if (has_nav_menu('track-order')): ?>

			    		<?php urna_tbay_get_page_templates_parts('nav', 'track'); ?>
			    		
			    	<?php endif; ?>
		    		
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
        <div class="container">
            <div class="row">
				<!-- //LOGO -->
                <div class="header-logo col-md-3">

                    <?php
                        urna_tbay_get_page_templates_parts('logo');
                    ?> 
                </div>
				
				<div class="header-search col-md-6">

					<div class="search-full"> 
	                	<?php urna_tbay_get_page_templates_parts('productsearchform'); ?>
					</div>

				</div>

				<div class="header-right col-md-3">
					<!-- My-account -->
					<?php
                        urna_tbay_get_page_templates_parts('topbar-account');
                    ?>
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
				
			    <div class="tbay-mainmenu col-md-8">
					
					<?php urna_tbay_get_page_templates_parts('nav'); ?>
			    </div>
			    <div class="nav-right col-md-4">
			    <?php
                    do_action('urna_tbay_header_custom_language_wpml');
                    
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
                </div>
		    	
	        </div>
        </div>
    </div>

    <div id="nav-cover"></div>
</header>