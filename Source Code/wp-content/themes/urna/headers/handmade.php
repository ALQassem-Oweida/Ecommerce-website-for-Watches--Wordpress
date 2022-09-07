<header id="tbay-header" class="site-header hidden-md hidden-sm hidden-xs <?php echo(urna_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">
	<?php if (is_active_sidebar('banner_image')) : ?>
	<div class="topbar">
		<div class="container-fluid">
			<div class="row">
				<div class="banner-top">
					<?php dynamic_sidebar('banner_image'); ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif;?>
    <div class="header-main">
        <div class="container">
            <div class="row">

                <div class="col-md-4">
                	<!-- Canvas-menu -->
					<?php urna_tbay_get_page_templates_parts('canvas-menu-sidebar'); ?>
					<?php if (is_active_sidebar('canvas-menu-sidebar')) : ?>
						<div class="canvas-menu-sidebar">
							<?php dynamic_sidebar('canvas-menu-sidebar'); ?>
						</div>
					<?php endif;?>
					
					<?php if (is_active_sidebar('top-contact')) : ?>
						<div class="top-contact">
							<?php dynamic_sidebar('top-contact'); ?>
						</div>
					<?php endif;?>
                </div>

				<!-- //LOGO -->
				<div class="header-logo col-md-4">
					<?php
                        urna_tbay_get_page_templates_parts('logo');
                    ?> 
				</div>

				<div class="header-right col-md-4">
					<!-- My-account -->
					<?php
                        urna_tbay_get_page_templates_parts('topbar-account');
                    ?>

					<!-- Search -->
					<div class="search"> 
	                	<?php urna_tbay_get_page_templates_parts('productsearchform', 'canvas-v3'); ?>
					</div>

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
				
			    <div class="tbay-mainmenu col-md-12">
					<?php urna_tbay_get_page_templates_parts('nav'); ?>
			    </div>

	        </div>
        </div>
    </div>
    <div id="nav-cover"></div>
</header>