<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( empty( $settings ) ) {
	return;
}
$image_class      = array('wcpr-filter-button wcpr-filter-button-images');
$image_class[]    = $query_image ? 'wcpr-active' : '';
$verified_class   = array(  'wcpr-filter-button' );
$verified_class[] = $settings->get_params( 'photo', 'verified' ) == 'badge' ? $settings->get_params( 'photo', 'verified_badge' ) :  'wcpr-filter-button-verified';
$verified_class[] = $query_verified ? 'wcpr-active' : '';
$image_link    = ( $query_image ? remove_query_arg( array( 'image', 'offset', 'cpage' ), $product_link1 ) :
		add_query_arg( array( 'image' => true ), remove_query_arg( array( 'page', 'offset', 'cpage' ), $product_link1 ) ) ) . $anchor_link;
$verified_link = ( $query_verified ? remove_query_arg( array( 'verified', 'offset', 'cpage' ), $product_link1 ) :
		add_query_arg( array( 'verified' => true ), remove_query_arg( array( 'page', 'offset', 'cpage' ), $product_link1 ) ) ) . $anchor_link;
$all_stars_url = $query_rating ? $product_link1 : $product_link;
$all_stars_url = remove_query_arg( array( 'rating' ), remove_query_arg( array( 'page' ), $all_stars_url ) ) . $anchor_link;
$rating_wrap_class = array('wcpr-filter-button-wrap wcpr-filter-button wcpr-active');
?>
<div class="wcpr-filter-container" style="display: none;">
    <a data-filter_type="image" class="<?php echo esc_attr( trim( implode( ' ', $image_class ) ) ); ?>" rel="nofollow" href="<?php echo esc_url( $image_link ); ?>">
		<?php esc_html_e( 'With images', 'woo-photo-reviews' ); ?>
        (<span class="wcpr-filter-button-count"><?php echo esc_html( $count_images ); ?></span>)
    </a>
    <a data-filter_type="verified" class="<?php echo esc_attr( trim( implode( ' ', $verified_class ) ) ); ?>" rel="nofollow" href="<?php echo esc_url( $verified_link ); ?>">
		<?php esc_html_e( 'Verified', 'woo-photo-reviews' ); ?>
        (<span class="wcpr-filter-button-count"><?php echo esc_html( $count_verified ); ?></span>)
    </a>
    <div class="<?php echo esc_attr( trim( implode( ' ', $rating_wrap_class ) ) ); ?>">
		<span class="wcpr-filter-rating-placeholder">
            <?php
            if ( $query_rating > 0 && $query_rating < 6 ) {
	            echo sprintf( _n( '%s star', '%s stars', $query_rating, 'woo-photo-reviews' ), $query_rating );
	            echo sprintf( '(<span class="wcpr-filter-button-count">%s</span>)',
		            $star_counts[$query_rating] ??  VI_WOO_PHOTO_REVIEWS_Frontend_Frontend::stars_count( $query_rating, $product_id ) );
            } else {
	            esc_html_e( 'All stars', 'woo-photo-reviews' );
	            echo sprintf( '(<span class="wcpr-filter-button-count">%s</span>)',  $count_reviews );
            }
            ?>
		</span>
        <ul class="wcpr-filter-button-ul">
            <li class="wcpr-filter-button-li">
                <?php
                $all_star_class = array('wcpr-filter-button') ;
                $all_star_class[] = $query_rating ? '' : 'wcpr-active' ;
                $all_star_class =implode(' ', $all_star_class );
                ?>
                <a data-filter_type="all" class="<?php echo esc_attr( trim( $all_star_class) ); ?>"
                   href="<?php echo esc_url( $all_stars_url ) ?>">
					<?php
					esc_html_e( 'All stars', 'woo-photo-reviews' );
					printf( '(<span class="wcpr-filter-button-count">%s</span>)',  $count_reviews );
					?>
                </a>
				<?php
				for ( $i = 5; $i > 0; $i -- ) {
				    $new_star_class=array( 'wcpr-filter-button');
				    $new_star_class[]=( $query_rating && $query_rating == $i ) ?'wcpr-active' : '';
					$filter_rating_url = $query_rating ?   $product_link :$product_link1;
					printf( '<li class="wcpr-filter-button-li"><a data-filter_type="%s" class="%s" rel="nofollow" href="%s">%s(<span class="wcpr-filter-button-count">%s</span>)</a></li>',
						 $i, esc_attr( trim(  implode(' ',$new_star_class) ) ),
						( ( ( $query_rating && $query_rating == $i ) ? esc_url( remove_query_arg( array( 'rating', 'offset', 'cpage' ), $filter_rating_url ) ) :
                                add_query_arg( array( 'rating' => $i ), remove_query_arg( array( 'page', 'offset', 'cpage' ), $filter_rating_url ) ) )  . $anchor_link ),
						sprintf( _n( '%s star', '%s stars', $i, 'woo-photo-reviews' ), $i ),
						$star_counts[$i] ?? VI_WOO_PHOTO_REVIEWS_Frontend_Frontend::stars_count( $i, $product_id )
					);
				}
				?>
            </li>
        </ul>
    </div>
</div>
