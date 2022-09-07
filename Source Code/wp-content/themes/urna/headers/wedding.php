<header id="tbay-header" class="site-header hidden-md hidden-sm hidden-xs <?php echo(urna_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">

    <div class="header-main">
        <div class="container">
            <div class="row">
				<!-- LOGO -->
                <div class="header-logo col-md-2">
					<?php urna_tbay_get_page_templates_parts('logo'); ?>
				</div>
				
				<!-- //MENU -->
				<div class="tbay-mainmenu col-md-8">
					<?php
                        urna_tbay_get_page_templates_parts('nav');
                    ?> 
				</div>

				<div class="header-right col-md-2">
					<!-- Search -->
					<div class="search"> 
	                	<?php urna_tbay_get_page_templates_parts('productsearchform', 'canvas'); ?>
					</div>

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

    <div id="nav-cover"></div>
</header>