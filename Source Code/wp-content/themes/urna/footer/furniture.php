<?php

$footer 	= apply_filters('urna_tbay_get_footer_layout', 'default');
$copyright 	= urna_tbay_get_config('copyright_text', '');

?>

	</div><!-- .site-content -->
	<?php if (urna_tbay_active_newsletter_sidebar()) : ?>
		<div id="newsletter-popup" class="newsletter-popup">
			<?php dynamic_sidebar('newsletter-popup'); ?>
		</div>
	<?php endif; ?>
	
	<?php if (!empty($footer)): ?>
		
		<?php urna_tbay_display_footer_builder($footer); ?>

	<?php else: ?>
		<footer id="tbay-footer" class="tbay-footer">
			<?php if (is_active_sidebar('footer')) : ?>
				<div class="footer">
					<div class="container">
						<div class="row">
							<?php dynamic_sidebar('footer'); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if (!empty($copyright)) : ?>
				<div class="tbay-copyright">
					<div class="container">
						<div class="copyright-content">
							<div class="text-copyright text-center">
							
								<?php echo trim($copyright); ?>

							</div> 
						</div>
					</div>
				</div>

			<?php else: ?>
				<div class="tbay-copyright">
					<div class="container">
						<div class="copyright-content">
							<div class="text-copyright text-center">
							<?php
                                    $allowed_html_array = array( 'a' => array('href' => array() ) );
                                    echo wp_kses(__('Copyright &copy; 2021 - urna. All Rights Reserved. <br/> Powered by <a href="//thembay.com">ThemBay</a>', 'urna'), $allowed_html_array);
                                
                            ?>

							</div> 
						</div>
					</div>
				</div>

			<?php endif; ?>	 
		</footer>
		
	<?php endif; ?>
	
	<?php

    $_id = urna_tbay_random_key();

    ?>

	<?php
    if (urna_tbay_get_config('back_to_top')) { ?>
		<div class="tbay-to-top">
			<a href="javascript:void(0);" id="back-to-top">
				<i class="linear-icon-chevron-up"></i>
			</a>
		</div>
	<?php
    }
    ?>

	<?php
    if (urna_tbay_get_config('mobile_back_to_top')) { ?>
		<div class="tbay-to-top-mobile tbay-to-top">

			<div class="more-to-top">
			
				<a href="javascript:void(0);" id="back-to-top-mobile">
					<i class="linear-icon-chevron-up"></i>
				</a>
				
			</div>
		</div>
		
		
	<?php
    }
    ?>
	
	

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>

