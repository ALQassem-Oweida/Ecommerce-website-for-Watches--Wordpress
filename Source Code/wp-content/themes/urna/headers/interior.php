<header id="tbay-header" class="site-header hidden-md hidden-sm hidden-xs <?php echo(urna_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">

    <div class="header-main">
        <div class="container-fluid">
            <div class="row">

                <div class="header-logo col-md-2">
                	<!-- //LOGO -->
                	<?php urna_tbay_get_page_templates_parts('logo'); ?> 
                </div>

				<div class="header-mainmenu col-md-6">
					<div class="tbay-mainmenu">
						<?php urna_tbay_get_page_templates_parts('nav'); ?>
				    </div>
				</div>

				<div class="header-right col-md-2">
					<!-- Search -->
					<div class="search"> 
	                	<?php urna_tbay_get_page_templates_parts('productsearchform', 'canvas'); ?>
					</div>

					<!-- My-account -->
					<?php urna_tbay_get_page_templates_parts('topbar-account'); ?>

					<?php if (!urna_catalog_mode_active() && defined('URNA_WOOCOMMERCE_ACTIVED') && URNA_WOOCOMMERCE_ACTIVED): ?>
						<!-- Cart -->
						<div class="top-cart hidden-xs">
							<?php urna_tbay_get_woocommerce_mini_cart(); ?>
						</div>
					<?php endif; ?>

				</div>
				<div class="col-md-2">
					<!-- Canvas-menu -->
					<?php urna_tbay_get_page_templates_parts('canvas-menu-sidebar', 'v2'); ?>
					<?php if (is_active_sidebar('canvas-menu-sidebar')) : ?>
						<div class="canvas-menu-sidebar">
							<?php dynamic_sidebar('canvas-menu-sidebar'); ?>
						</div>
					<?php endif;?>
				</div>
				
            </div>
        </div>
    </div>
    <div id="nav-cover"></div>
</header>