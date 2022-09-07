<?php
$product_item = isset($product_item) ? $product_item : 'list';
?>
<ul class="tbay-w-products-list">
	<?php while ($loop->have_posts()) : $loop->the_post(); global $product; ?>
		<?php 
			$post_object = get_post( get_the_ID() );
			setup_postdata( $GLOBALS['post'] =& $post_object );
			
			wc_get_template_part('item-product/'.$product_item); 
		?>
	<?php endwhile; ?>
</ul>
<?php wp_reset_postdata(); ?>