<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( empty( $my_comments ) || ! is_array( $my_comments ) || empty( $settings ) ) {
	return;
}
global $product;
$grid_class='';
if (isset($cols)) {
	$grid_class = array(
		 'wcpr-grid',
		'wcpr-masonry-' . $cols . '-col',
	);
}
$product_title    = $product->get_title() . ' photo review';
if ($grid_class){
    echo sprintf('<div class="%s">',esc_attr( trim( implode( ' ', $grid_class ) ) ) );
}
foreach ( $my_comments as $v ) {
	if ( $v->comment_parent ) {
		continue;
	}
	$comment = $v;
	if ( $product ) {
		$comment_children = $comment->get_children();
		$rating           = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
		echo sprintf( '<div id="comment-%s" class="wcpr-grid-item"><div class="wcpr-content">', $comment->comment_ID );
		do_action( 'woocommerce_photo_reviews_masonry_item_top', $comment, $product );
		$img_post_ids = get_comment_meta( $v->comment_ID, 'reviews-images', true );
		if ( is_array( $img_post_ids ) && count( $img_post_ids ) > 0 ) {
			?>
            <div class="reviews-images-container">
                <div class="reviews-images-wrap-left">
					<?php
					if ( count( $img_post_ids ) > 1 ) {
						foreach ( $img_post_ids as $img_post_ids_k => $img_post_id ) {
							if ( ! wc_is_valid_url( $img_post_id ) ) {
								$image_data     = wp_get_attachment_metadata( $img_post_id );
								$alt            = get_post_meta( $img_post_id, '_wp_attachment_image_alt', true );
								$image_alt      = $alt ? $alt : $product_title;
								$data_image_src = wp_get_attachment_image_url( $img_post_id, 'full' );
								$thumb          = wp_get_attachment_thumb_url( $img_post_id );
								if (strpos($data_image_src,'.gif') ){
									$href = $data_image_src;
								}else {
									$href = ( isset( $image_data['sizes']['wcpr-photo-reviews'] ) ? wp_get_attachment_image_url( $img_post_id, 'wcpr-photo-reviews' ) : ( isset( $image_data['sizes']['medium_large'] ) ? wp_get_attachment_image_url( $img_post_id, 'medium_large' ) : ( isset( $image_data['sizes']['medium'] ) ? wp_get_attachment_image_url( $img_post_id, 'medium' ) : $data_image_src ) ) );
								}
								printf('<div class="reviews-images-wrap"><a data-image_index="%s" data-image_src="%s" data-image_caption="" rel="nofollow" href="%s"><img class="reviews-images" src="%s" alt="%s"/></a></div>',
									esc_attr( $img_post_ids_k ),esc_attr( $data_image_src ),esc_url( apply_filters( 'woocommerce_photo_reviews_masonry_thumbnail_main', $href, $img_post_id ) ),
									esc_url( $thumb ),esc_attr( $image_alt ));
							}else{
								printf( '<div class="reviews-images-wrap"><a data-image_index="%s" href="%s"><img class="reviews-images" src="%s" alt="%s"></a></div>',
									 esc_attr( $img_post_ids_k ), esc_attr( $img_post_id ),esc_url( $img_post_id ),esc_attr( $product_title )
								);
							}
						}
					}
					?>
                </div>
				<?php
				$clones     = $img_post_ids;
				$first_ele  = array_shift( $clones );
				if (! wc_is_valid_url( $first_ele )){
					$image_data        = wp_get_attachment_metadata( $first_ele );
					$alt               = get_post_meta( $first_ele, '_wp_attachment_image_alt', true );
					$image_alt         = $alt ? $alt : $product_title;
					$data_original_src = wp_get_attachment_url( $first_ele );
					$src        = $data_original_src;
					$img_width         = $image_data['width'] ?? '';
					$img_height        = $image_data['height'] ?? '';
					$img_type = ( isset( $image_data['sizes']['wcpr-photo-reviews'] ) ? 'wcpr-photo-reviews' : ( isset( $image_data['sizes']['medium_large'] ) ? 'medium_large' : ( isset( $image_data['sizes']['medium'] ) ? 'medium': '' ) ) );
					if (!strpos($data_original_src,'.gif')  && $img_type ) {
						$src        = wp_get_attachment_image_url( $first_ele, $img_type );
						$img_width  = $image_data['sizes'][ $img_type ]['width'] ?? '';
						$img_height = $image_data['sizes'][ $img_type ]['height'] ?? '';
					}
					printf('<div class="reviews-images-wrap-right"><img class="reviews-images" data-original_src="%s" src="%s" alt="%s"  width="%s" height="%s"></div>',
						esc_attr( $data_original_src ),esc_url( apply_filters( 'woocommerce_photo_reviews_masonry_thumbnail_main', $src, $first_ele ) ),
                        esc_attr( $image_alt ),esc_attr( $img_width ),esc_attr( $img_height ));
				}else{
					printf('<div class="reviews-images-wrap-right"><img class="reviews-images" src="%s" alt="%s"></div>',
						esc_url( $first_ele ),esc_attr( $product_title ) );
				}
				if ( count( $img_post_ids ) > 1 ) {
					printf('<div class="images-qty">+%s</div>',count( $img_post_ids ) - 1 );
				}
				?>
            </div>
			<?php
		}
		do_action( 'woocommerce_photo_reviews_masonry_item_before_main_content', $comment, $product );
		printf( '<div class="review-content-container">' );
		if ( '0' === $v->comment_approved ){
			printf('<p class="meta"><em class="woocommerce-review__awaiting-approval">%s</em></p>',esc_html__( 'Your review is awaiting approval', 'woo-photo-reviews' ));
		}else{
			?>
            <div class="review-content-container-top">
                <div class="wcpr-comment-author">
		            <?php
		            comment_author( $comment );
		            if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && 1 == get_comment_meta( $comment->comment_ID, 'verified', true ) ) {
			            printf( '<em class="woocommerce-review__verified verified woocommerce-photo-reviews-verified wcpr-icon-badge"></em>');
		            }
		            ?>
                </div>
                <div class="wcpr-review-rating">
		            <?php
		            if ( $rating > 0 ) {
			            echo wc_get_rating_html( $rating );
		            }
		            if ( $settings->get_params( 'photo', 'show_review_date' ) ) {
			            ?>
                        <div class="wcpr-review-date">
				            <?php
				            $review_date_format = VI_WOO_PHOTO_REVIEWS_DATA::get_date_format();
				            comment_date( $review_date_format, $comment )
				            ?>
                        </div>
			            <?php
		            }
		            ?>
                </div>
            </div>
			<?php
		}
		?>
        <div class="wcpr-review-content"><?php echo wp_kses(ucfirst( $v->comment_content ),VI_WOO_PHOTO_REVIEWS_DATA::extend_post_allowed_html()); ?></div>
		<?php
		if (is_array( $comment_children ) && count( $comment_children ) ){
			?>
            <div class="wcpr-comment-children">
                <div class="wcpr-comment-children-content">
					<?php
					foreach ( $comment_children as $comment_child ) {
						?>
                        <div class="wcpr-comment-child">
                            <div class="wcpr-comment-child-author">
								<?php
								ob_start();
								esc_html_e( 'Reply from ', 'woo-photo-reviews' );
								?>
                                <span class="wcpr-comment-child-author-name"><?php comment_author( $comment_child ); ?></span>:
								<?php
								$comment_child_author = ob_get_clean();
								$comment_child_author = apply_filters( 'woocommerce_photo_reviews_reply_author_html', $comment_child_author, $comment_child );
								echo wp_kses_post($comment_child_author);
								?>
                            </div>
                            <div class="wcpr-comment-child-content">
	                            <?php echo wp_kses(ucfirst( $comment_child->comment_content ),VI_WOO_PHOTO_REVIEWS_DATA::extend_post_allowed_html()); ?>
                            </div>
                        </div>
						<?php
					}
					?>
                </div>
            </div>
			<?php
		}
		printf( '</div></div></div>' );
	}
}
if ($grid_class){
   printf('</div>' );
}
?>
