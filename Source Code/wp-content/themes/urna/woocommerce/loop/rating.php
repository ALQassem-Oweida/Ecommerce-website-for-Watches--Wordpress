<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

global $product;

if (! wc_review_ratings_enabled()) {
    return;
}
$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();

if (empty($review_count)) {
    $review_count = 0;
}

?>

<div class="rating <?php echo  (empty($review_count)) ? 'no-rate' : '';?>">
	<?php if ($rating_html = wc_get_rating_html($product->get_average_rating())) { ?>
		<?php echo trim($rating_html); ?>
		<div class="count"><span><?php echo  trim($review_count); ?></span></div>
	<?php } else { ?>
	<div class="star-rating">
	</div>
	<div class="count"><?php echo  trim($review_count); ?></div>
	<?php } ?>
</div>