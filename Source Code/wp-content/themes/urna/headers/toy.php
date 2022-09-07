<header id="tbay-header" class="site-header hidden-md hidden-sm hidden-xs <?php echo(urna_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">
	<div class="top-bar">
		<div class="container">
			<div class="row">
				<div class="col-md-7">
					<?php if (is_active_sidebar('top-contact')) : ?>
						<div class="top-contact">
							<?php dynamic_sidebar('top-contact'); ?>
						</div>
					<?php endif;?>
				</div>
				<div class="col-md-5 header-right">
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
					<!-- order-tracking -->
					<div class ="track-order">
						<?php if (has_nav_menu('track-order')): ?>
							<?php urna_tbay_get_page_templates_parts('nav', 'track'); ?>
						<?php endif; ?>
					</div>

					<!-- Wishlist -->
					<?php
                        urna_tbay_get_page_templates_parts('wishlist');
                    ?>
				</div>
			</div>
		</div>
	</div>
    <div class="header-main">
        <div class="container">
            <div class="row">
                <div class="header-logo col-md-2">
					<?php urna_tbay_get_page_templates_parts('logo'); ?>
                </div>
				<!-- //LOGO -->
				<div class="tbay-mainmenu col-md-6">
					<?php
                        urna_tbay_get_page_templates_parts('nav');
                    ?> 
				</div>
				<div class="header-right col-md-4">
					<!-- Search -->
					<div class="search"> 
	                	<?php urna_tbay_get_page_templates_parts('productsearchform'); ?>
					</div>
					<!-- My-account -->
					<?php
                        urna_tbay_get_page_templates_parts('topbar-account');
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

    <div id="nav-cover"></div>
</header>