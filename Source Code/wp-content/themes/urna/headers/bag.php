<header id="tbay-header" class="site-header hidden-md hidden-sm hidden-xs <?php echo(urna_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">
	<div class="topbar">
		<div class="container">
			<div class="row">
				<div class="col-md-6 topbar-left">

					<!-- Search -->
					<div class="search"> 
	                	<?php urna_tbay_get_page_templates_parts('productsearchform'); ?>
					</div>

				</div>
				<div class="col-md-6 topbar-right">

					<!-- Canvas-menu -->
					<?php urna_tbay_get_page_templates_parts('canvas-menu-sidebar'); ?>
					<?php if (is_active_sidebar('canvas-menu-sidebar')) : ?>
						<div class="canvas-menu-sidebar">
							<?php dynamic_sidebar('canvas-menu-sidebar'); ?>
						</div>
					<?php endif;?>

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
	
					<!-- My-account -->
					<?php
                        urna_tbay_get_page_templates_parts('topbar-account');
                    ?>

				</div>
			</div>
		</div>
	</div>
    <div class="sidebar-header-main">
		<!-- LOGO -->
        <div class="header-logo">
			<?php urna_tbay_get_page_templates_parts('logo'); ?>
		</div>

		<!-- //MENU -->
		<div class="tbay-mainmenu">
			<?php
                urna_tbay_get_page_templates_parts('nav');
            ?> 
		</div>
		
		<!-- Newsletter -->
		<?php if (is_active_sidebar('top-newsletter')) : ?>
			<div class="top-newsletter">
				<?php dynamic_sidebar('top-newsletter'); ?>
			</div>
		<?php endif;?>
				
    </div>
    <div id="nav-cover"></div>
</header>