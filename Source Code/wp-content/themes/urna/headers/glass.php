<header id="tbay-header" class="site-header hidden-md hidden-sm hidden-xs <?php echo(urna_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">

    <div class="header-main">
        <div class="container">
            <div class="row">
				<!-- Search -->
				<div class="search col-md-4"> 
                	<?php urna_tbay_get_page_templates_parts('productsearchform'); ?>
				</div>

				<!-- LOGO -->
                <div class="header-logo col-md-4">
					<?php urna_tbay_get_page_templates_parts('logo'); ?>
				</div>

				<div class="header-right col-md-4">
					
					<!-- My-account -->
					<?php
                        urna_tbay_get_page_templates_parts('topbar-account');
                    ?>

					<!-- Wishlist -->
					<?php
                        urna_tbay_get_page_templates_parts('wishlist');
                    ?>
					
					<!-- Cart -->
					<?php if (!urna_catalog_mode_active() && defined('URNA_WOOCOMMERCE_ACTIVED') && URNA_WOOCOMMERCE_ACTIVED): ?>
					<div class="top-cart hidden-xs">
						<?php urna_tbay_get_woocommerce_mini_cart(); ?>
					</div>
					<?php endif; ?>

					<!-- Canvas-menu -->
					<?php urna_tbay_get_page_templates_parts('canvas-menu-sidebar'); ?>
					
				</div>
				
            </div>
        </div>
    </div>
	<div class="main-menu">
		<div class="container">
			<div class="row">
				<!-- //MENU -->
				<div class="tbay-mainmenu">
					<?php
                        urna_tbay_get_page_templates_parts('nav');
                    ?> 
				</div>
			</div>
		</div>
	</div>
	
    <div id="nav-cover"></div>
</header>