<?php


defined('ABSPATH') || exit;


?>

<div class="product-item">
	<a title="<?php the_title_attribute(); ?>" href="<?php echo the_permalink(); ?>" class="product-image">
		<?php
            echo woocommerce_get_product_thumbnail();
        ?>
	</a>
</div>