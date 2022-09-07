<header id="tbay-header" class="site-header hidden-md hidden-sm hidden-xs <?php echo(urna_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">

    <div class="header-main">
        <div class="container">
            <div class="row">
				<!-- LOGO -->
                <div class="header-logo col-lg-2">
					<?php urna_tbay_get_page_templates_parts('logo'); ?>
				</div>
				
				<!-- //MENU -->
				<div class="tbay-mainmenu col-lg-6">
					<?php
                        urna_tbay_get_page_templates_parts('nav');
                    ?> 
				</div>

				<div class="header-right col-lg-4">
					<!-- My-account -->
					<?php
                        urna_tbay_get_page_templates_parts('topbar-account');
                    ?>
					<!-- Cart -->
					<?php if (!urna_catalog_mode_active() && defined('URNA_WOOCOMMERCE_ACTIVED') && URNA_WOOCOMMERCE_ACTIVED): ?>
					<div class="top-cart hidden-xs">
						<?php urna_tbay_get_woocommerce_mini_cart(); ?>
					</div>
					<?php endif; ?>
					<!-- Search -->
					<div class="search"> 
	                	<?php urna_tbay_get_page_templates_parts('productsearchform'); ?>
					</div>
				</div>
				
            </div>
        </div>
    </div>

    <div id="nav-cover"></div>
</header>