<header id="tbay-header" class="site-header hidden-md hidden-sm hidden-xs <?php echo(urna_tbay_get_config('keep_header', false) ? 'main-sticky-header' : ''); ?>">
  	<div class="header-main">
	    <div class="container">
	      	<div class="row">
					<!-- LOGO -->
		        <div class="header-logo col-md-3 col-lg-2">
					<?php
                        urna_tbay_get_page_templates_parts('logo');
                    ?> 
		        </div>

				<div class="header-search col-md-6 col-lg-7">
					<?php if (has_nav_menu('nav-category-menu')): ?>
					<?php urna_tbay_get_page_templates_parts('category', 'menu-canvas'); ?>
					<?php endif; ?>
					<div class="search-full">
	                	<?php urna_tbay_get_page_templates_parts('productsearchform'); ?>
					</div>
				</div>

				<div class="header-right col-md-3">

					<!-- Account -->
		        	<?php
                        urna_tbay_get_page_templates_parts('topbar-account');
                    ?>

                	<!-- Compare -->
                	<?php urna_yith_compare_header(); ?>

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

				</div>
	    	</div>
	    </div>
  	</div>
	  	<div class="header-mainmenu">
	      	<div class="container">
			    <div class="row">
					
				    <div class="tbay-mainmenu col-md-8 col-lg-9">
						<?php urna_tbay_get_page_templates_parts('nav'); ?>
				    </div>

				    <?php if (function_exists('urna_tbay_wc_the_recently_viewed')) : ?>
				    <div class="col-md-4 col-lg-3 recent-view">
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