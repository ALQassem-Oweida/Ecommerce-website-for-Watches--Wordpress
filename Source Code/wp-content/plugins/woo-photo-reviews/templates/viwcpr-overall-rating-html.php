<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (!$product_id ){
	return;
}
if ($overall_rating_enable !=='on' && $rating_count_enable !=='on'){
	return;
}
?>
<div class="wcpr-overall-rating-and-rating-count" style="display: none;">
	<?php
	if ($overall_rating_enable==='on'){
		?>
		<div class="wcpr-overall-rating">
			<h2>
				<?php
				echo apply_filters( 'woocommerce_photo_reviews_overall_rating_text', esc_html__( 'Customer reviews', 'woo-photo-reviews' ), wc_get_product($product_id) );
                ?>
			</h2>
			<div class="wcpr-overall-rating-main">
				<div class="wcpr-overall-rating-left">
					<span class="wcpr-overall-rating-left-average">
						<?php echo wp_kses_post( number_format( $average_rating, 2 )); ?>
					</span>
				</div>
				<div class="wcpr-overall-rating-right">
					<div class="wcpr-overall-rating-right-star">
						<?php echo wc_get_rating_html( $average_rating); ?>
					</div>
					<div class="wcpr-overall-rating-right-total">
						<?php
						printf( _n( 'Based on %s review', 'Based on %s reviews', $count_reviews, 'woo-photo-reviews' ), $count_reviews, 'woo-photo-reviews' );
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	if ($rating_count_enable==='on'){
		?>
		<div class="wcpr-stars-count">
			<?php
			for ($i = 5; $i > 0; $i--){
				$rate = 0;
				$star_count ='';
				if ($count_reviews){
					$star_count =$star_counts[$i] ?? VI_WOO_PHOTO_REVIEWS_Frontend_Frontend::stars_count($i,$product_id);
					$rate = ( 100 * ( $star_count / $count_reviews ) );
				}
				?>
				<div class="wcpr-row">
					<div class="wcpr-col-number"><?php echo esc_html($i); ?></div>
					<div class="wcpr-col-star"><?php echo wp_kses(wc_get_rating_html( $i ),VI_WOO_PHOTO_REVIEWS_DATA::extend_post_allowed_html()); ?></div>
					<div class="wcpr-col-process">
						<div class="rate-percent-bg">
							<div class="rate-percent" style="width: <?php echo esc_attr($rate); ?>%;"></div>
							<div class="rate-percent-bg-1"><?php echo esc_html(round( $rate ).'%')?></div>
						</div>
					</div>
					<div class="wcpr-col-rank-count"><?php echo esc_html($star_count); ?></div>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
	?>
</div>
