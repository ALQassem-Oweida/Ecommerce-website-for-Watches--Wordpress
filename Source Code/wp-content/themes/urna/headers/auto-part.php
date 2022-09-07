<header id="tbay-header" class="site-header hidden-md hidden-sm hidden-xs <?php echo(urna_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">
    <div class="header-main">
        <div class="container">
            <div class="row">
				<!-- //LOGO -->
                <div class="header-logo col-md-2">
                    <?php
                        urna_tbay_get_page_templates_parts('logo');
                    ?> 
                </div>
				<div class="header-search col-md-6 col-xlg-7">
					<div class="search-full">
	                	<?php urna_tbay_get_page_templates_parts('productsearchform'); ?>
					</div>
				</div>
				<div class="header-right col-md-4 col-xlg-3">
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
					<!-- Account -->
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
				<div class="col-md-3 col-lg-2">
					<?php urna_tbay_get_page_templates_parts('category-menu-canvas'); ?>
				</div>
			    <div class="tbay-mainmenu col-md-6 col-xlg-7">
					<?php urna_tbay_get_page_templates_parts('nav'); ?>
			    </div>
				<div class="header-right col-md-3 col-lg-4 col-xlg-3">
					<div class="recent-view">
						<?php if (function_exists('urna_tbay_wc_the_recently_viewed')) : ?>
							<?php
                                urna_tbay_wc_the_recently_viewed();
                            ?>
						<?php endif; ?>
					</div>
					<div class ="track-order">
						<?php if (has_nav_menu('track-order')): ?>
							<?php urna_tbay_get_page_templates_parts('nav', 'track'); ?>
						<?php endif; ?>
					</div>
				</div>
	        </div>
        </div>
    </div>
    <div id="nav-cover"></div>
</header>