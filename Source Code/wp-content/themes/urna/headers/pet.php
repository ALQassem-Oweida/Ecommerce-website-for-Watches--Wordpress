<header id="tbay-header" class="site-header hidden-md hidden-sm hidden-xs <?php echo(urna_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">
	<div class="header-main">
		<div class="container">
			<div class="row">
				<div class="col-md-3 header-logo">
					<?php
                        urna_tbay_get_page_templates_parts('logo');
                    ?> 
				</div>
				<div class="col-md-6 header-search">
					<div class="search-full">
	                	<?php urna_tbay_get_page_templates_parts('productsearchform'); ?>
					</div>
					
				</div>
				<div class="col-md-3 header-right">
					<?php
                        urna_tbay_get_page_templates_parts('topbar-account');
                    ?>
					<!-- Cart -->
                	<?php if (!urna_catalog_mode_active() && defined('URNA_WOOCOMMERCE_ACTIVED') && URNA_WOOCOMMERCE_ACTIVED): ?>
					<div class="top-cart hidden-xs">
						<?php urna_tbay_get_woocommerce_mini_cart(); ?>
					</div>
					<?php endif; ?>
					<div>
						<?php if (has_nav_menu('track-order')): ?>
							<?php urna_tbay_get_page_templates_parts('nav', 'track'); ?>
						<?php endif; ?>
						<!-- Compare -->
						<?php urna_yith_compare_header(); ?>
					</div>	
				</div>
			</div>
			
		</div>
	</div>

    <div class="header-mainmenu">
        <div class="container">
	        <div class="row">
				<div class="col-md-2 header-left">
					<?php urna_tbay_get_page_templates_parts('category-menu-canvas'); ?>
				</div>
			    <div class="tbay-mainmenu col-md-8">
					<?php urna_tbay_get_page_templates_parts('nav'); ?>
			    </div>

			    <?php if (function_exists('urna_tbay_wc_the_recently_viewed')) : ?>
			    <div class="col-md-2 recent-view ">
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