
<?php

         $cat = get_term_by('id', $category, 'product_cat');
         if (isset($images) && $images) {
             $cat_id 		= 	$images;

             if (isset($cat) && $cat) {
                 $cat_name 		= 	$cat->name;
                 $cat_slug 		= 	$cat->slug;
                 $cat_link 		= 	get_term_link($cat->slug, 'product_cat');
                 $cat_count 		= 	$cat->count;
             } else {
                 $cat_name 		= 	esc_html__('Shop', 'urna');
                 $cat_link 		= 	get_permalink(wc_get_page_id('shop'));
                 $cat_count 		= 	urna_total_product_count(); 
             }

             $image 		   = wp_get_attachment_url($cat_id); ?> 

			<div class="item">

				<div class="item-cat">
					<?php if (!empty($image)) { ?>
						<a class="cat-img" href="<?php echo esc_url($cat_link); ?>">
                            <?php echo wp_get_attachment_image($cat_id, 'full', false, array('alt'=> $cat_name )); ?>
						</a>
					<?php } ?>

					<a class="cat-name" href="<?php echo esc_url($cat_link); ?>">
						<?php echo trim($cat_name); ?>
						<span class="count-item">(<?php echo trim($cat_count).' '.esc_html__('items', 'urna'); ?>)</span>
					</a>

				</div>

			</div>   
		<?php
         } ?>

<?php wp_reset_postdata(); ?>