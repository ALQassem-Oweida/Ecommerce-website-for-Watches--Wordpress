<?php

/**
 * Class VI_WOO_PHOTO_REVIEWS_Frontend_Frontend
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOO_PHOTO_REVIEWS_Frontend_Frontend {
	protected $settings;
	protected $comments;
	protected $new_review_id;
	protected static $is_ajax, $rating,$image,$verified;
	protected $characters_array;
	protected $anchor_link;

	public function __construct() {

		$this->settings = new VI_WOO_PHOTO_REVIEWS_DATA();
		$this->anchor_link = '#' . $this->settings->get_params( 'reviews_anchor_link' );
		add_action( 'edit_comment', array( $this, 'coupon_for_not_logged_in' ), 10, 1 );
		add_action( 'wp_set_comment_status', array( $this, 'coupon_for_not_logged_in' ), 10, 1 );
		add_action( 'wpr_schedule_email', array( $this, 'send_schedule_email' ), 10, 7 );
		if ( $this->settings->get_params( 'enable' ) !== 'on' ) {
			return;
		}
		add_action( 'comment_form_before', array( $this, 'notify_coupon_sent' ) );
		add_filter( 'wp_list_comments_args', array( $this, 'remove_default_reviews' ) );
		add_action( 'comment_form_top', array( $this, 'add_form_description' ), 20 );
		if ( 'off' == $this->settings->get_params( 'coupon', 'require' )['photo'] &&
             'yes' == get_option( 'woocommerce_enable_coupons' )
             && 'on' == $this->settings->get_params( 'coupon', 'enable' ) ) {
			add_action( 'comment_post', array( $this, 'send_coupon_after_reviews' ), 10, 2 );
		}
		//mobile detect
		global $wcpr_detect;
		if ( $wcpr_detect->isMobile() && ! $wcpr_detect->isTablet() && $this->settings->get_params( 'mobile' ) !== 'on' ) {
			return;
		}
		//add enctype attribute to form
		add_action( 'comment_form_before', array( $this, 'add_form_enctype_start' ) );
		add_action( 'comment_form_after', array( $this, 'add_form_enctype_end' ) );
		//input#1-add image field
		add_filter( 'woocommerce_product_review_comment_form_args', array( $this, 'add_comment_field' ), 999, 1 );
		//input#2-handle image field
		add_filter( 'preprocess_comment', array( $this, 'check_review_image' ), 10, 1 );
		//output#
		add_filter( 'comments_template_query_args', array( $this, 'sort_reviews' ) );
		/**/
		add_action( 'comment_post', array( $this, 'fix_get_comment_link' ) );
		if ( 'on' == $this->settings->get_params( 'photo', 'filter' )['enable'] ) {
			add_action( 'parse_comment_query', array( __CLASS__, 'parse_comment_query' ) );
			add_action( 'parse_comment_query', array( __CLASS__, 'parse_comment_query1' ) );
		}
		if ( 'on' === $this->settings->get_params( 'followup_email', 'enable' ) ) {
			add_action( 'woocommerce_order_status_completed', array( $this, 'follow_up_email' ) );
		}
	}

	public function fix_get_comment_link() {
		add_filter( 'get_comment_link', array( $this, 'get_comment_link' ), 10, 4 );
	}

	public function get_comment_link( $link, $comment, $args, $cpage ) {
		global $wp_rewrite;
		$sort = $this->settings->get_params( 'photo', 'sort' )['time'];
		if ( ( $sort == 1 ) ) {
			$link  = get_permalink( $comment->comment_post_ID );
			$cpage = 1;
			if ( get_option( 'page_comments' ) ) {
				if ( $wp_rewrite->using_permalinks() ) {
					if ( $cpage ) {
						$link = trailingslashit( $link ) . $wp_rewrite->comments_pagination_base . '-' . $cpage;
					}

					$link = user_trailingslashit( $link, 'comment' );
				} elseif ( $cpage ) {
					$link = add_query_arg( 'cpage', $cpage, $link );
				}
			}

			if ( $wp_rewrite->using_permalinks() ) {
				$link = user_trailingslashit( $link, 'comment' );
			}

			$link = $link . '#comment-' . $comment->comment_ID;
		}

		return $link;
	}

	public function remove_default_reviews( $r ) {
		if ( ! $this->settings->get_params( 'pagination_ajax' ) || self::$is_ajax ) {
			return $r;
		}
		if ( ! is_product() ) {
			return $r;
		}
		$r['echo'] = false;

		return $r;
	}

	public function reduce_image_sizes( $sizes ) {
		$reduce_array = apply_filters( 'woocommerce_photo_reviews_reduce_array', array(
			'thumbnail',
			'wcpr-photo-reviews',
			'medium'
		) );
		foreach ( $sizes as $k => $size ) {
			if ( in_array( $size, $reduce_array ) ) {
				continue;
			}
			unset( $sizes[ $k ] );
		}

		return $sizes;
	}

	public function add_form_description() {
		if ( ! is_product() || ! is_single() ) {
			return;
		}
		if ( 'on' == $this->settings->get_params( 'coupon', 'enable' ) ) {
			printf( '<div class="wcpr-form-description">%s</div>',wp_kses_post($this->settings->get_params( 'coupon', 'form_title' )));
		}
	}



	public function end_ob() {
		if ( ! is_product() || ! is_single() ) {
			return;
		}
		global $wp_query;
		$post_id       = $wp_query->post->ID;
		$product       = function_exists( 'wc_get_product' ) ? wc_get_product( $post_id ) : new WC_Product( $post_id );
		$product_link  = wc_clean($_SERVER['REQUEST_URI']);
		$product_link1 = $product->get_permalink();
		$product_link  = remove_query_arg( array( 'image', 'verified', 'rating' ), $product_link );
		$product_link1 = remove_query_arg( array( 'image', 'verified', 'rating' ), $product_link1 );
		$agrs3         = array(
			'post_id'  => $post_id,
			'count'    => true,
			'meta_key' => 'rating',
			'status'   => 'approve'
		);
		remove_action( 'parse_comment_query', array( $this, 'parse_comment_query' ) );
		remove_action( 'parse_comment_query', array( $this, 'parse_comment_query1' ) );
		$counts3 = get_comments( $agrs3 );
		add_action( 'parse_comment_query', array( $this, 'parse_comment_query' ) );
		add_action( 'parse_comment_query', array( $this, 'parse_comment_query1' ) );
		$filter = '';
		//review count
		$filter .= '<div class="wcpr-overall-rating-and-rating-count" style="display: none;">';
		if ( 'on' == $this->settings->get_params( 'photo', 'overall_rating' ) ) {
			$filter .= '<div class="wcpr-overall-rating">';
			$filter .= '<h2>' . esc_html__( 'Customer reviews', 'woo-photo-reviews' ) . '</h2>';
			$filter .= '<div class="wcpr-overall-rating-main"><div class="wcpr-overall-rating-left"><span class="wcpr-overall-rating-left-average">' . round( $product->get_average_rating(), 2 ) . '</span>';
			$filter .= '</div><div class="wcpr-overall-rating-right"><div class="wcpr-overall-rating-right-star">' . wc_get_rating_html( $product->get_average_rating() ) . '</div><div class="wcpr-overall-rating-right-total">' . sprintf( _n( 'Based on %s review', 'Based on %s reviews', $counts3, 'woo-photo-reviews' ), $counts3, 'woo-photo-reviews' ) . '</div></div></div></div>';
		}
		if ( 'on' == $this->settings->get_params( 'photo', 'rating_count' ) ) {
			remove_action( 'parse_comment_query', array( $this, 'parse_comment_query' ) );
			remove_action( 'parse_comment_query', array( $this, 'parse_comment_query1' ) );
			$agrs        = array(
				'post_id'  => $post_id,
				'count'    => true,
				'meta_key' => 'rating',
				'status'   => 'approve'
			);
			$counts      = get_comments( $agrs );
			$filter      .= '<div class="wcpr-stars-count">';
			$star_counts = array();
			for ( $i = 1; $i < 6; $i ++ ) {
				$star_counts[ $i ] = $this->stars_count( $i, $post_id );
			}
			for ( $i = 5; $i > 0; $i -- ) {
				$rate = 0;
				if ( $counts > 0 ) {
					$rate = ( 100 * ( $star_counts[ $i ] / $counts ) );
				}
				$filter .= '<div class="wcpr-row"><div class="wcpr-col-number">' . $i . '</div>';
				$filter .= '<div class="wcpr-col-star">' . wc_get_rating_html( $i ) . '</div>';
				$filter .= '<div class="wcpr-col-process"><div class="rate-percent-bg"><div class="rate-percent"  style="width:' . $rate . '%;"></div><div class="rate-percent-bg-1">' . round( $rate ) . ' %</div></div></div>';
				$filter .= '<div class="wcpr-col-rank-count">' . $star_counts[ $i ] . '</div></div>';
			}
			$filter .= '</div>';
			add_action( 'parse_comment_query', array( $this, 'parse_comment_query' ) );
			add_action( 'parse_comment_query', array( $this, 'parse_comment_query1' ) );
		}
		$filter .= '</div>';
		//                review filter
		//contain images
		if ( 'on' == $this->settings->get_params( 'photo', 'filter' )['enable'] ) {
			$agrs1   = array(
				'post_id'  => $post_id,
				'count'    => true,
				'meta_key' => 'reviews-images',
				'status'   => 'approve'
			);
			$counts1 = get_comments( $agrs1 );

			$agrs2   = array(
				'post_id'    => $post_id,
				'count'      => true,
				'status'     => 'approve',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key'     => 'rating',
						'compare' => 'EXISTING',
					),
					array(
						'key'     => 'verified',
						'value'   => 1,
						'compare' => '=',
					),
				),
			);
			$counts2 = get_comments( $agrs2 );
			remove_action( 'parse_comment_query', array( $this, 'parse_comment_query1' ) );
			$query_image    = isset( $_GET['image'] ) ? sanitize_text_field($_GET['image']) : '';
			$query_verified = isset( $_GET['verified'] ) ? sanitize_text_field($_GET['verified']) : '';
			$query_rating   = isset( $_GET['rating'] ) ? sanitize_text_field($_GET['rating']) : '';

			if ( $query_image ) {
				$product_link  = add_query_arg( array( 'image' => true ), $product_link );
				$product_link1 = add_query_arg( array( 'image' => true ), $product_link1 );
			}
			if ( $query_verified ) {
				$product_link  = add_query_arg( array( 'verified' => true ), $product_link );
				$product_link1 = add_query_arg( array( 'verified' => true ), $product_link1 );
			}
			if ( $query_rating ) {
				$product_link  = add_query_arg( array( 'rating' => $query_rating ), $product_link );
				$product_link1 = add_query_arg( array( 'rating' => $query_rating ), $product_link1 );
			}
			$filter .= '<div class="wcpr-filter-container" style="display: none;">';
			$filter .= '<a class="wcpr-filter-button wcpr-filter-button-images ' . ( $query_image ? 'wcpr-active' : '' ) . '" rel="nofollow" href="' . ( $query_image ? esc_url( remove_query_arg( array(
					'image',
					'offset',
					'cpage'
				), $product_link1 ) ) : esc_url( add_query_arg( array( 'image' => true ), remove_query_arg( array(
					'page',
					'offset',
					'cpage'
				), $product_link1 ) ) ) ) . $this->anchor_link . '">' . esc_html__( 'With images', 'woo-photo-reviews' ) . '(' . $counts1 . ')</a>';
			$filter .= '<a class="wcpr-filter-button ';
			if ( $this->settings->get_params( 'photo', 'verified' ) == 'badge' ) {
				$filter .= $this->settings->get_params( 'photo', 'verified_badge' );
			} else {
				$filter .= 'wcpr-filter-button-verified';
			}
			$filter .= ( $query_verified ? ' wcpr-active' : '' ) . '" rel="nofollow" href="' . ( $query_verified ? esc_url( remove_query_arg( array(
					'verified',
					'offset',
					'cpage'
				), $product_link1 ) ) : esc_url( add_query_arg( array( 'verified' => true ), remove_query_arg( array(
					'page',
					'offset',
					'cpage'
				), $product_link1 ) ) ) ) . $this->anchor_link . '">' . esc_html__( 'Verified', 'woo-photo-reviews' ) . '(' . $counts2 . ')</a>';
			$filter .= '<span class="wcpr-filter-button-wrap wcpr-filter-button wcpr-active">';
			if ( $query_rating > 0 && $query_rating < 6 ) {
				$filter .= sprintf( _n( '%s star', '%s stars', $query_rating, 'woo-photo-reviews' ), $query_rating );
				$filter .= '(' . $this->stars_count( $query_rating, $post_id ) . ')';
			} else {
				$filter .= esc_html__( 'All stars', 'woo-photo-reviews' );
				$filter .= '(' . $counts3 . ')';
			}
			$all_stars_url = $query_rating ? $product_link1 : $product_link;
			$filter        .= '<ul class="wcpr-filter-button-ul">';
			$filter        .= '<li class="wcpr-filter-button-li"><a class="wcpr-filter-button ' . ( $query_rating ? '' : 'wcpr-active' ) . '" rel="nofollow" href="' . esc_url( remove_query_arg( array( 'rating' ), remove_query_arg( array( 'page' ), $all_stars_url ) ) ) . $this->anchor_link . '">';
			$filter        .= esc_html__( 'All stars', 'woo-photo-reviews' );
			$filter        .= '(' . $counts3 . ')';
			for ( $i = 5; $i > 0; $i -- ) {
				$filter_rating_url = $i == $query_rating ? $product_link : $product_link1;
				$filter            .= '<li class="wcpr-filter-button-li"><a class="wcpr-filter-button ' . ( ( $query_rating && $query_rating == $i ) ? 'wcpr-active' : '' ) . '" rel="nofollow" href="' . ( ( $query_rating && $query_rating == $i ) ? esc_url( remove_query_arg( array(
						'rating',
						'offset',
						'cpage'
					), $filter_rating_url ) ) : esc_url( add_query_arg( array( 'rating' => $i ), remove_query_arg( array(
						'page',
						'offset',
						'cpage'
					), $filter_rating_url ) ) ) ) . $this->anchor_link . '">';
				$filter            .= sprintf( _n( '%s star', '%s stars', $i, 'woo-photo-reviews' ), $i );
				$filter            .= '(' . $this->stars_count( $i, $post_id ) . ')</a></li>';
			}
			$filter .= '</ul>';
			$filter .= '</span>';
			$filter .= '</div>';
			add_action( 'parse_comment_query', array( $this, 'parse_comment_query1' ) );
		}
		echo wp_kses_post($filter);
	}

	public function add_form_enctype_start() {
		if ( ! is_product() || ! is_single() ) {
			return;
		}
		ob_start();
	}

	public function add_form_enctype_end() {
		if ( ! is_product() || ! is_single() ) {
			return;
		}
		$v = ob_get_clean();
		$v = str_replace( '<form', '<form enctype="multipart/form-data"', $v );
		print( $v );
	}

	public function sort_reviews( $comment_args ) {
		if (self::$is_ajax ) {
			die;
		}
		$comment_args['orderby'] = 'comment_date_gmt';
		if ( $this->settings->get_params( 'photo', 'sort' )['time'] == 1 ) {
			$comment_args['order'] = 'DESC';
		} else {
			$comment_args['order'] = 'ASC';
		}

		return $comment_args;
	}

	public function filter_reviews( $comment_args ) {
		$rating = 0;
		if ( isset( $_GET['rating'] ) ) {
			switch ( intval(sanitize_text_field($_GET['rating'])) ) {
				case 1:
				case 2:
				case 3:
				case 4:
				case 5:
					$rating = sanitize_text_field($_GET['rating']);
					break;
				default:
					$rating = 0;
			}
		}
		$image    = isset( $_GET['image'] ) ? sanitize_text_field( $_GET['image'] ) : "";
		$verified = isset( $_GET['verified'] ) ? sanitize_text_field( $_GET['verified'] ) : "";
		if ( $rating ) {
			$comment_args += [ 'meta_key' => 'rating', 'meta_value' => $rating ];
		} elseif ( $image == 'true' ) {
			$comment_args += [ 'meta_key' => 'reviews-images' ];
		} elseif ( $verified == 'true' ) {
			$comment_args += [ 'meta_key' => 'verified', 'meta_value' => 1 ];
		}

		return $comment_args;
	}


	public function follow_up_email( $order_id ) {
		$date_format = VI_WOO_PHOTO_REVIEWS_DATA::get_date_format();
		$order       = wc_get_order( $order_id );
		if ( $order ) {
			$date_create   = $order->get_date_created()->date_i18n( $date_format );
			$date_complete = $order->get_date_completed()->date_i18n( $date_format );
			$items         = $order->get_items();
			$products      = array();

			foreach ( $items as $item ) {
				$product_id = $item->get_product_id();
				$products[] = $product_id;
			}
			$products = array_unique( $products );
			if ( count( $products ) ) {
				$user_email    = $order->get_billing_email();
				$customer_name = $order->get_billing_first_name();
				$t_amount      = $this->settings->get_params( 'followup_email', 'amount' );
				$t_unit        = $this->settings->get_params( 'followup_email', 'unit' );
				switch ( $t_unit ) {
					case 's':
						$t = $t_amount;
						break;
					case 'm':
						$t = $t_amount * 60;
						break;
					case 'h':
						$t = $t_amount * 3600;
						break;
					case 'd':
						$t = $t_amount * 86400;
						break;
					default:
						$t = 0;
				}
				$user_id = $order->get_user_id();
				if ( ! $user_id ) {
					$user = get_user_by( 'email', $user_email );
					if ( $user ) {
						$user_id = $user->ID;
					}
				}

				$time = time() + $t;
				if ( $user_id ) {
					$user_reviewed_products = get_user_meta( $user_id, 'wcpr_user_reviewed_product', false );
					if ( ! count( $user_reviewed_products ) ) {
						/*this user did not review any products*/
						$schedule = wp_schedule_single_event(
							$time, 'wpr_schedule_email', array(
								$user_email,
								$customer_name,
								$products,
								$order_id,
								$time,
								$date_create,
								$date_complete,
							)
						);
						if ( $schedule !== false ) {
							update_post_meta( $order_id, '_wcpr_review_reminder', array(
								'status'   => 'pending',
								'time'     => $time,
								'products' => $products,
							) );
						}

					} else {
						/*only send review reminder if there are products in the order that this user did not review*/
						$not_reviewed_products = array_diff( $products, $user_reviewed_products );
						if ( count( $not_reviewed_products ) ) {
							$schedule = wp_schedule_single_event(
								$time, 'wpr_schedule_email', array(
									$user_email,
									$customer_name,
									$not_reviewed_products,
									$order_id,
									$time,
									$date_create,
									$date_complete,
								)
							);
							if ( $schedule !== false ) {
								update_post_meta( $order_id, '_wcpr_review_reminder', array(
									'status'   => 'pending',
									'time'     => $time,
									'products' => $not_reviewed_products,
								) );
							}
						}
					}
				} else {
					$sents = array();
					foreach ( $products as $p ) {
						$args     = array(
							'post_type'    => 'product',
							'type'         => 'review',
							'author_email' => $user_email,
							'post_id'      => $p,
							'meta_query'   => array(
								'relation' => 'AND',
								array(
									'key'     => 'id_import_reviews_from_ali',
									'compare' => 'NOT EXISTS'
								),
							)
						);
						$comments = get_comments( $args );
						if ( ! count( $comments ) ) {
							$sents[] = $p;
						}
					}
					if ( count( $sents ) ) {
						$schedule = wp_schedule_single_event(
							$time, 'wpr_schedule_email', array(
								$user_email,
								$customer_name,
								$sents,
								$order_id,
								$time,
								$date_create,
								$date_complete,
							)
						);
						if ( $schedule !== false ) {
							update_post_meta( $order_id, '_wcpr_review_reminder', array(
								'status'   => 'pending',
								'time'     => $time,
								'products' => $sents,
							) );
						}
					}
				}

			}
		}
	}

	public function send_schedule_email( $user_email, $customer_name, $products, $order_id, $time, $date_create, $date_complete ) {
		if ( count( $products ) ) {
			$order = wc_get_order( $order_id );
			if ( ! $order ) {
				return;
			}

			$content = nl2br( stripslashes( $this->settings->get_params( 'followup_email', 'content' ) ) );
			$content = str_replace( '{customer_name}', $customer_name, $content );
			$content = str_replace( '{order_id}', $order_id, $content );
			$content = str_replace( '{date_create}', $date_create, $content );
			$content = str_replace( '{date_complete}', $date_complete, $content );
			$content = str_replace( '{site_title}', get_bloginfo( 'name' ), $content );
			$content .= '<table style="width: 100%;">';
			foreach ( $products as $p ) {
				$product = wc_get_product( $p );
				if ( $product ) {
					$product_image = wp_get_attachment_thumb_url( $product->get_image_id() );
					$product_url   = $product->get_permalink() . $this->anchor_link;

					$product_title = $product->get_title();
					$product_price = $product->get_price_html();
					ob_start();
					?>
                    <tr>
                        <td style="text-align: center;">
                            <a target="_blank" href="<?php echo esc_url($product_url) ?>">
                                <img style="width: 150px;"
                                     src="<?php echo esc_url($product_image) ?>"
                                     alt="<?php echo esc_attr($product_title) ?>">
                            </a>
                        </td>
                        <td>
                            <p>
                                <a target="_blank" href="<?php echo esc_url($product_url) ?>"><?php echo wp_kses_post($product_title) ?></a>
                            </p>
                            <p><?php echo wp_kses($product_price, VI_WOO_PHOTO_REVIEWS_DATA::extend_post_allowed_html()) ?></p>
                            <a target="_blank"
                               style="text-align: center;padding: 10px;text-decoration: none;font-weight: 800;
                                       background-color:<?php echo esc_attr($this->settings->get_params( 'followup_email', 'review_button_bg_color') ); ?>;
                                       color:<?php echo esc_attr($this->settings->get_params( 'followup_email', 'review_button_color' )) ?>;"
                               href="<?php echo esc_url($product_url) ?>"><?php esc_html_e( 'Review Now', 'woo-photo-reviews' ) ?>
                            </a>
                        </td>
                    </tr>
					<?php
					$content .= ob_get_clean();
				}
			}
			$content       .= '</table>';
			$subject       = stripslashes( $this->settings->get_params( 'followup_email', 'subject' ) );
			$email_heading = $this->settings->get_params( 'followup_email', 'heading' );
			$mailer        = WC()->mailer();
			$email         = new WC_Email();
			$content       = $email->style_inline( $mailer->wrap_message( $email_heading, $content ) );
			$headers = "Content-Type: text/html\r\nReply-to: {$email->get_from_name()} <{$email->get_from_address()}>\r\n";
			$email->send( $user_email, $subject, $content, $headers, array() );
			update_post_meta( $order_id, '_wcpr_review_reminder', array(
				'status'   => 'sent',
				'time'     => $time,
				'products' => $products,
			) );
		}
	}

	protected function rand() {
		if ( $this->characters_array === null ) {
			$this->characters_array = array_merge( range( 0, 9 ), range( 'a', 'z' ) );
		}
		$rand = rand( 0, count( $this->characters_array ) - 1 );

		return $this->characters_array[ $rand ];
	}

	protected function create_code() {
		$code = '';
		for ( $i = 0; $i < 6; $i ++ ) {
			$code .= $this->rand();
		}
		$args      = array(
			'post_type'      => 'shop_coupon',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'title'          => $code
		);
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			wp_reset_postdata();
			$code = $this->create_code();
		}
		wp_reset_postdata();

		return $code;
	}

	public function generate_coupon() {
		if ( $this->settings->get_params( 'coupon', 'coupon_select' ) === 'kt_generate_coupon' ) {
			$coupon_generate = $this->settings->get_params( 'coupon', 'unique_coupon' );
			$code            = $this->create_code();
			$coupon          = new WC_Coupon( $code );
			$today           = strtotime( date( 'Ymd' ) );
			$date_expires    = ( $coupon_generate['expiry_date'] ) ? ( ( $coupon_generate['expiry_date'] + 1 ) * 86400 + $today ) : '';
			$coupon->set_amount( $coupon_generate['coupon_amount'] );
			$coupon->set_date_expires( $date_expires );
			$coupon->set_discount_type( $coupon_generate['discount_type'] );
			$coupon->set_individual_use( $coupon_generate['individual_use'] == 'yes' ? 1 : 0 );
			if ( $coupon_generate['product_ids'] ) {
				$coupon->set_product_ids( $coupon_generate['product_ids'] );
			}
			if ( $coupon_generate['excluded_product_ids'] ) {
				$coupon->set_excluded_product_ids( $coupon_generate['excluded_product_ids'] );
			}
			$coupon->set_usage_limit( $coupon_generate['limit_per_coupon'] );
			$coupon->set_usage_limit_per_user( $coupon_generate['limit_per_user'] );
			$coupon->set_limit_usage_to_x_items( $coupon_generate['limit_to_x_items'] );
			$coupon->set_free_shipping( $coupon_generate['allow_free_shipping'] == 'yes' ? 1 : 0 );
			$coupon->set_product_categories( $coupon_generate['product_categories'] );
			$coupon->set_excluded_product_categories( $coupon_generate['excluded_product_categories'] );
			$coupon->set_exclude_sale_items( $coupon_generate['exclude_sale_items'] == 'yes' ? 1 : 0 );
			$coupon->set_minimum_amount( $coupon_generate['min_spend'] );
			$coupon->set_maximum_amount( $coupon_generate['max_spend'] );
			$coupon->save();
			$code = $coupon->get_code();
			update_post_meta( $coupon->get_id(), 'kt_unique_coupon', 'yes' );
		} else {
			$coupon = new WC_Coupon( $this->settings->get_params( 'coupon', 'existing_coupon' ) );
			$code   = $coupon->get_code();
			if ( $coupon->get_usage_limit() > 0 && $coupon->get_usage_count() >= $coupon->get_usage_limit() ) {
				return false;
			}
			if ( $coupon->get_date_expires() && time() > $coupon->get_date_expires()->getTimestamp() ) {
				return false;
			}
		}

		return $code;
	}

	public function send_coupon_after_reviews( $comment_id, $commentdata ) {
		$comment = get_comment( $comment_id );
		if ( ! get_comment_meta( $comment_id, 'rating', true ) ) {
			return;
		}
		$product_id = $comment->comment_post_ID;
		if ( $this->settings->get_params( 'coupon', 'require' )['min_rating'] ) {
			if ( get_comment_meta( $comment_id, 'rating', true ) < $this->settings->get_params( 'coupon', 'require' )['min_rating'] ) {
				return;
			}
		}
		$user_email    = $comment->comment_author_email;
		$customer_name = $comment->comment_author;
		$user_id       = $comment->user_id;
		if ( $this->settings->get_params( 'coupon', 'require' )['owner'] == 'on' && 1 != get_comment_meta( $comment_id, 'verified', true ) ) {
			$verified = false;
			if ( 'product' === get_post_type( $product_id ) ) {
				$verified = wc_customer_bought_product( $user_email, $user_id, $product_id );
			}
			if ( ! $verified ) {
				return;
			}
		}

		if ( $comment->comment_approved != 1 ) {
			update_comment_meta( $comment_id, 'coupon_for_reviews', "0" );

			return;
		}

		if ( ! $user_id ) {
			$user = get_user_by( 'email', $user_email );
			if ( $user ) {
				$user_id = $user->ID;
			}
		}
		if ( $user_id ) {
			$user_coupon = get_user_meta( $user_id, 'wcpr_user_reviewed_product', false );
			if ( ! count( $user_coupon ) ) {
				$code = $this->generate_coupon();

				if ( $code ) {
					$c = new WC_Coupon( $code );
					add_user_meta( $user_id, 'wcpr_user_reviewed_product', $product_id );
					$er = $c->get_email_restrictions();
					if ( $this->settings->get_params( 'set_email_restriction' ) && ! in_array( $user_email, $er ) ) {
						$er[] = $user_email;
						$c->set_email_restrictions( $er );
						$c->save();
					}
					$coupon_code  = $c->get_code();
					$date_expires = $c->get_date_expires();
					$this->send_email( $user_email, $customer_name, $coupon_code, $date_expires );
					update_comment_meta( $comment_id, 'coupon_email', 'sent', true );
				}

			} elseif ( ! in_array( $product_id, $user_coupon ) ) {
				$code = $this->generate_coupon();

				if ( $code ) {
					$c = new WC_Coupon( $code );
					add_user_meta( $user_id, 'wcpr_user_reviewed_product', $product_id );
					$er = $c->get_email_restrictions();
					if ( $this->settings->get_params( 'set_email_restriction' ) && ! in_array( $user_email, $er ) ) {
						$er[] = $user_email;
						$c->set_email_restrictions( $er );
						$c->save();
					}
					$coupon_code  = $c->get_code();
					$date_expires = $c->get_date_expires();
					$this->send_email( $user_email, $customer_name, $coupon_code, $date_expires );
					update_comment_meta( $comment_id, 'coupon_email', 'sent', true );
				}
			}
		} else {
			$args     = array(
				'post_type'    => 'product',
				'type'         => 'review',
				'author_email' => $user_email,
				'post_id'      => $product_id,
				'meta_query'   => array(
					'relation' => 'AND',
					array(
						'key'     => 'id_import_reviews_from_ali',
						'compare' => 'NOT EXISTS'
					),
					array(
						'key'     => 'coupon_email',
						'compare' => 'EXISTS'
					),
				)
			);
			$comments = get_comments( $args );
			if ( ! count( $comments ) ) {
				$code = $this->generate_coupon();

				if ( $code ) {
					$c  = new WC_Coupon( $code );
					$er = $c->get_email_restrictions();
					if ( $this->settings->get_params( 'set_email_restriction' ) && ! in_array( $user_email, $er ) ) {
						$er[] = $user_email;
						$c->set_email_restrictions( $er );
						$c->save();
					}
					$coupon_code  = $c->get_code();
					$date_expires = $c->get_date_expires();
					$this->send_email( $user_email, $customer_name, $coupon_code, $date_expires );
					update_comment_meta( $comment_id, 'coupon_email', 'sent', true );
				}
			}
		}
	}

	public function coupon_for_not_logged_in( $comment_id ) {
		if ( "0" === get_comment_meta( $comment_id, 'coupon_for_reviews', true ) ) {
			$comment = get_comment( $comment_id );
			if ( $comment->comment_approved != 1 ) {
				return;
			}
			if ( get_comment_meta( $comment_id, 'coupon_email', true ) ) {
				return;
			}
			$product_id = $comment->comment_post_ID;

			if ( $this->settings->get_params( 'coupon', 'require' )['min_rating'] ) {
				if ( ! get_comment_meta( $comment_id, 'rating', true ) || get_comment_meta( $comment_id, 'rating', true ) < $this->settings->get_params( 'coupon', 'require' )['min_rating'] ) {
					return;
				}
			}
			if ( $this->settings->get_params( 'coupon', 'require' )['owner'] == 'on' && 1 != get_comment_meta( $comment_id, 'verified', true ) ) {
				return;
			}
			if ( 'on' == $this->settings->get_params( 'coupon', 'require' )['photo'] && ! get_comment_meta( $comment_id, 'reviews-images', true ) ) {
				return;
			}
			$user_email    = $comment->comment_author_email;
			$customer_name = $comment->comment_author;
			$user_id       = $comment->user_id;
			if ( ! $user_id ) {
				$user = get_user_by( 'email', $user_email );
				if ( $user ) {
					$user_id = $user->ID;
				}
			}
			if ( $user_id ) {
				$user_coupon = get_user_meta( $user_id, 'wcpr_user_reviewed_product', false );
				if ( ! $user_coupon || ! count( $user_coupon ) ) {
					$code = $this->generate_coupon();
					if ( $code ) {
						$c  = new WC_Coupon( $code );
						$er = $c->get_email_restrictions();
						if ( $this->settings->get_params( 'set_email_restriction' ) && ! in_array( $user_email, $er ) ) {
							$er[] = $user_email;
							$c->set_email_restrictions( $er );
							$c->save();
						}
						$coupon_code  = $c->get_code();
						$date_expires = $c->get_date_expires();
						$this->send_email( $user_email, $customer_name, $coupon_code, $date_expires );
						add_user_meta( $user_id, 'wcpr_user_reviewed_product', $product_id );
						update_comment_meta( $comment_id, 'coupon_email', 'sent', true );
						update_comment_meta( $comment_id, 'coupon_for_reviews', 1 );
					}

				} elseif ( ! in_array( $product_id, $user_coupon ) ) {
					$code = $this->generate_coupon();

					if ( $code ) {
						$c = new WC_Coupon( $code );
						add_user_meta( $user_id, 'wcpr_user_reviewed_product', $product_id );
						$er = $c->get_email_restrictions();
						if ( $this->settings->get_params( 'set_email_restriction' ) && ! in_array( $user_email, $er ) ) {
							$er[] = $user_email;
							$c->set_email_restrictions( $er );
							$c->save();
						}
						$coupon_code  = $c->get_code();
						$date_expires = $c->get_date_expires();
						$this->send_email( $user_email, $customer_name, $coupon_code, $date_expires );
						update_comment_meta( $comment_id, 'coupon_email', 'sent', true );
						update_comment_meta( $comment_id, 'coupon_for_reviews', 1 );
					}
				}
			} else {
				$args     = array(
					'post_type'    => 'product',
					'type'         => 'review',
					'author_email' => $user_email,
					'post_id'      => $product_id,
					'meta_query'   => array(
						'relation' => 'AND',
						array(
							'key'     => 'id_import_reviews_from_ali',
							'compare' => 'NOT EXISTS'
						),
						array(
							'key'     => 'coupon_email',
							'compare' => 'EXISTS'
						),
					)
				);
				$comments = get_comments( $args );
				if ( ! count( $comments ) ) {
					$code = $this->generate_coupon();

					if ( $code ) {
						$c  = new WC_Coupon( $code );
						$er = $c->get_email_restrictions();
						if ( $this->settings->get_params( 'set_email_restriction' ) && ! in_array( $user_email, $er ) ) {
							$er[] = $user_email;
							$c->set_email_restrictions( $er );
							$c->save();
						}
						$coupon_code  = $c->get_code();
						$date_expires = $c->get_date_expires();
						$this->send_email( $user_email, $customer_name, $coupon_code, $date_expires );
						update_comment_meta( $comment_id, 'coupon_email', 'sent', true );
						update_comment_meta( $comment_id, 'coupon_for_reviews', 1 );
					}
				}
			}

		}
	}

	public function send_email( $user_email, $customer_name, $coupon_code, $date_expires ) {
		$date_format   = VI_WOO_PHOTO_REVIEWS_DATA::get_date_format();
		$email_temp    = $this->settings->get_params( 'coupon', 'email' );
		$content       = nl2br( stripslashes( $email_temp['content'] ) );
		$content       = str_replace( '{customer_name}', $customer_name, $content );
		$content       = str_replace( '{coupon_code}', '<span style="font-size: x-large;">' . strtoupper( $coupon_code ) . '</span>', $content );
		$content       = str_replace( '{date_expires}', empty( $date_expires ) ? esc_html__( 'never expires', 'woo-photo-reviews' ) : date_i18n( $date_format, strtotime( $date_expires ) ), $content );
		$subject       = stripslashes( $email_temp['subject'] );
		$mailer        = WC()->mailer();
		$email_heading = isset( $email_temp['heading'] ) ? $email_temp['heading'] : esc_html__( 'Thank You For Your Review!', 'woo-photo-reviews' );
		$email         = new WC_Email();
		$content       = $email->style_inline( $mailer->wrap_message( $email_heading, $content ) );
		$headers = "Content-Type: text/html\r\nReply-to: {$email->get_from_name()} <{$email->get_from_address()}>\r\n";
		$email->send( $user_email, $subject, $content, $headers, array() );
	}

	//add field upload image
	public function add_comment_field( $comment_form ) {
		$comment_field                 = wc_get_template_html(
			'viwcpr-comment-field-html.php',
			array(
				'comment_form' => $comment_form,
				'settings'     =>  $this->settings,
			),
			'woocommerce-photo-reviews' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR,
			WOO_PHOTO_REVIEWS_TEMPLATES
		);
		$comment_form['comment_field'] .= $comment_field ;
		add_action( 'comment_form', array( $this, 'add_image_upload_nonce' ) );

		return $comment_form;
	}

	//add wp_nonce_field(for image field)
	public function add_image_upload_nonce() {
		wp_nonce_field( 'wcpr_image_upload', 'wcpr_image_upload_nonce' );
	}


	public function notify_coupon_sent( $a ) {
		global $wp_query;
		$my_comments = get_comments( $wp_query->comments );
		foreach ( $my_comments as $my_comment ) {
			if ( $my_comment->user_id > 0 && $my_comment->user_id == get_current_user_id() ) {
				if ( 'sent' === get_comment_meta( $my_comment->comment_ID, 'coupon_email', true ) ) {
					?>
                    <div class="woocommerce-message">
                        <p><?php esc_html_e( 'Thank you for reviewing our product. A coupon code has been sent to your email address. Please check your mailbox for more details.', 'woo-photo-reviews' ); ?></p>
                    </div>
					<?php
					update_comment_meta( $my_comment->comment_ID, 'coupon_email', 'notified' );
					break;
				}
			}
		}

		return $a;
	}



	public function check_review_image( $comment ) {
		$comment_type = isset( $comment['comment_type'] ) ? $comment['comment_type'] : '';
		if ( ! is_admin() && isset( $_POST['comment_post_ID'], $comment['comment_type'] ) && 'product' === get_post_type( absint( wc_clean($_POST['comment_post_ID']) ) ) && ( '' === $comment_type || 'comment' === $comment_type ) ) {
			$comment_type = $comment['comment_type'] = 'review';
		}
		$link = !empty($comment['comment_post_ID'] )?get_permalink( $comment['comment_post_ID'] ) :home_url();
		if ( $comment_type !== 'review' ) {
			return $comment;
		}
		if ( ! isset( $_POST['wcpr_image_upload_nonce'] ) || ! wp_verify_nonce( wc_clean($_POST['wcpr_image_upload_nonce']), 'wcpr_image_upload' ) ) {
			return $comment;
		}
		if ( ( 'on' == $this->settings->get_params( 'photo', 'gdpr' ) ) && empty($_POST['wcpr_gdpr_checkbox'] )) {
			wc_add_notice( esc_html__( 'Please agree with the GDPR policy!', 'woo-photo-reviews' ) , 'error' );
			do_action( 'woocommerce_set_cart_cookies',  true );
			wp_safe_redirect($link);
			exit;
		}
		$tmp_name = villatheme_array_flatten(wc_clean($_FILES['wcpr_image_upload']['tmp_name'] ?? array()), false);
		if ( (!isset( $_FILES['wcpr_image_upload'] ) || empty($tmp_name)  ) && 'on' === $this->settings->get_params( 'photo', 'required' ) ) {
			wc_add_notice( esc_html__( 'Photo is required.', 'woo-photo-reviews' ) , 'error' );
			do_action( 'woocommerce_set_cart_cookies',  true );
			wp_safe_redirect($link);
			exit;
		}
		if (empty($tmp_name) && 'on' !== $this->settings->get_params( 'photo', 'required' )){
			return $comment;
		}
		$maxsize_allowed = $this->settings->get_params( 'photo', 'maxsize' );
		$max_file_up     = 2;
		$names = villatheme_array_flatten(wc_clean($_FILES['wcpr_image_upload']['name'] ?? array()));
		$sizes =array_map('intval',villatheme_array_flatten(wc_clean($_FILES['wcpr_image_upload']['size'] ?? array())));
		$types = villatheme_array_flatten(wc_clean($_FILES['wcpr_image_upload']['type'] ?? array()));
		$errors = array_unique(array_map('intval',villatheme_array_flatten(wc_clean($_FILES['wcpr_image_upload']['error'] ?? array()), false)));
		if (!empty($errors) && !in_array(UPLOAD_ERR_NO_FILE, $errors)){
			wc_add_notice( sprintf(esc_html__( 'There was an error uploading files: %s', 'woo-photo-reviews' ),implode(',',$errors) ), 'error' );
			do_action( 'woocommerce_set_cart_cookies',  true );
			wp_safe_redirect($link);
			exit;
		}
		if (empty($names) && 'on' === $this->settings->get_params( 'photo', 'required' )){
			wc_add_notice( esc_html__( 'Photo is required.', 'woo-photo-reviews' ) , 'error' );
			do_action( 'woocommerce_set_cart_cookies',  true );
			wp_safe_redirect($link);
			exit;
		}
		if (count($names) > $max_file_up){
			wc_add_notice( sprintf(esc_html__( 'Maximum number of files allowed is: %s.', 'woo-photo-reviews' ),$max_file_up) , 'error' );
			do_action( 'woocommerce_set_cart_cookies',  true );
			wp_safe_redirect($link);
			exit;
		}
		$upload_allow = $this->settings->get_params('upload_allow');
		foreach ($types as $type){
			if ( !in_array($type,$upload_allow) ) {
				wc_add_notice( esc_html__( 'Only JPG, JPEG, BMP, PNG, WEBP and GIF are allowed.', 'woocommerce-photo-reviews' ) , 'error' );
				do_action( 'woocommerce_set_cart_cookies',  true );
				wp_safe_redirect($link);
				exit;
			}
		}
		$file_type_pattern ='/[^\?]+\.(jpg|JPG|jpeg|JPEG|jpe|JPE|gif|GIF|png|PNG|bmp|BMP|webp|WEBP)/';
		foreach ($names as $name){
			if ($name && !preg_match( $file_type_pattern, $name)){
				wc_add_notice( esc_html__( 'Only JPG, JPEG, BMP, PNG, WEBP and GIF are allowed.', 'woocommerce-photo-reviews' ) , 'error' );
				do_action( 'woocommerce_set_cart_cookies',  true );
				wp_safe_redirect($link);
			}
		}
		foreach ($sizes as $size){
			if (!$size){
				wc_add_notice( esc_html__( 'File\'s too large!', 'woocommerce-photo-reviews' ) , 'error' );
				do_action( 'woocommerce_set_cart_cookies',  true );
				wp_safe_redirect($link);
				exit;
			}
			if ( $size > ( $maxsize_allowed * 1024 ) ) {
				wc_add_notice( sprintf(esc_html__( 'Max size allowed: %skB.', 'woocommerce-photo-reviews' ),$maxsize_allowed) , 'error' );
				do_action( 'woocommerce_set_cart_cookies',  true );
				wp_safe_redirect($link);
				exit;
			}
		}
		add_action( 'comment_post', array( $this, 'add_review_image' ) );
		if ( 'on' == $this->settings->get_params( 'coupon', 'require' )['photo'] && 'yes' == get_option( 'woocommerce_enable_coupons' ) && 'on' == $this->settings->get_params( 'coupon', 'enable' ) ) {
			add_action( 'comment_post', array( $this, 'send_coupon_after_reviews' ), 10, 2 );
		}
		return $comment;
	}

	public function add_review_image( $comment_id ) {
		add_filter( 'intermediate_image_sizes', array( $this, 'reduce_image_sizes' ) );

		$post_id = get_comment( $comment_id )->comment_post_ID;
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
		$files  = $_FILES["wcpr_image_upload"];// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		$img_id = array();
		if ( is_array( $files['name'][0] ) ) {
			foreach ( $files['name'] as $key => $value ) {
				if ( $files['name'][ $key ][0] ) {
					$file                   = array(
						'name'     => apply_filters( 'woocommerce_photo_reviews_image_file_name', $files['name'][ $key ][0], $comment_id, $post_id ),
						'type'     => $files['type'][ $key ][0],
						'tmp_name' => $files['tmp_name'][ $key ][0],
						'error'    => $files['error'][ $key ][0],
						'size'     => $files['size'][ $key ][0]
					);
					$_FILES ["upload_file"] = $file;
					$attachment_id          = media_handle_upload( "upload_file", $post_id );
					if ( is_wp_error( $attachment_id ) ) {
						wc_add_notice(  $attachment_id->get_error_message() , 'error' );
						do_action( 'woocommerce_set_cart_cookies',  true );
						wp_safe_redirect(!$post_id ?get_permalink( $post_id ) :home_url());
						exit;
//						wp_die( $attachment_id->get_error_message() );
					} else {
						$img_id[] = $attachment_id;
					}
				}
			}
		} else {
			foreach ( $files['name'] as $key => $value ) {
				if ( $files['name'][ $key ] ) {
					$file                   = array(
						'name'     => apply_filters( 'woocommerce_photo_reviews_image_file_name', $files['name'][ $key ], $comment_id, $post_id ),
						'type'     => $files['type'][ $key ],
						'tmp_name' => $files['tmp_name'][ $key ],
						'error'    => $files['error'][ $key ],
						'size'     => $files['size'][ $key ]
					);
					$_FILES ["upload_file"] = $file;
					$attachment_id          = media_handle_upload( "upload_file", $post_id );
					if ( is_wp_error( $attachment_id ) ) {
						wc_add_notice(  $attachment_id->get_error_message() , 'error' );
						do_action( 'woocommerce_set_cart_cookies',  true );
						wp_safe_redirect(!$post_id ?get_permalink( $post_id ) :home_url());
						exit;
//						wp_die( $attachment_id->get_error_message() );
					} else {
						$img_id[] = $attachment_id;
					}
				}
			}
		}
		remove_filter( 'intermediate_image_sizes', array( $this, 'reduce_image_sizes' ) );

		update_comment_meta( $comment_id, 'reviews-images', $img_id );
		update_comment_meta( $comment_id, 'gdpr_agree', 1 );
	}


	public static function parse_comment_query( $vars ) {
		if ( ! self::$is_ajax && ! is_product() ) {
			return;
		}
		global $wcpr_shortcode_count;
		if ( $wcpr_shortcode_count === true ) {
			return;
		}
		if ( self::$is_ajax ) {
			$image    = self::$image;
			$verified = self::$verified;
		} else {
			$image    = isset( $_GET['image'] ) ? sanitize_text_field($_GET['image']) : "";
			$verified = isset( $_GET['verified'] ) ? sanitize_text_field($_GET['verified']) : "";
		}


		if ( $vars->query_vars['meta_query'] ) {
			$vars->query_vars['meta_query']['relation'] = 'AND';
			if ( $image ) {
				$vars->query_vars['meta_query'][] = array(
					'key'     => 'reviews-images',
					'compare' => 'EXISTS'
				);
			}
			if ( $verified ) {
				$vars->query_vars['meta_query'][] = array(
					'key'     => 'verified',
					'value'   => 1,
					'compare' => '='
				);
			}

		} else {
			$custom = array(
				'relation' => 'AND'
			);

			if ( $image ) {
				$custom[] = array(
					'key'     => 'reviews-images',
					'compare' => 'EXISTS'
				);
			}
			if ( $verified ) {
				$custom[] = array(
					'key'     => 'verified',
					'value'   => 1,
					'compare' => '='
				);
			}
			$vars->query_vars['meta_query'] = $custom;

		}
	}

	public static function parse_comment_query1( $vars ) {
		if ( ! self::$is_ajax && ! is_product() ) {
			return;
		}
		global $wcpr_shortcode_count;
		if ( $wcpr_shortcode_count === true ) {
			return;
		}
		$rating = 0;
		if ( self::$is_ajax ) {
			$rating = self::$rating;
		} else {
			if ( isset( $_GET['rating'] ) ) {
				switch ((int) sanitize_text_field($_GET['rating']) ) {
					case 1:
					case 2:
					case 3:
					case 4:
					case 5:
						$rating = sanitize_text_field($_GET['rating']);
						break;
					default:
						$rating = 0;
				}
			}
		}

		if ( $rating ) {
			if ( $vars->query_vars['meta_query'] ) {
				$vars->query_vars['meta_query']['relation'] = 'AND';
				$vars->query_vars['meta_query'][]           = array(
					'key'     => 'rating',
					'value'   => $rating,
					'compare' => '='
				);

			} else {
				$custom                         = array(
					'relation' => 'AND'
				);
				$custom[]                       = array(
					'key'     => 'rating',
					'value'   => $rating,
					'compare' => '='
				);
				$vars->query_vars['meta_query'] = $custom;

			}
		}
	}
	public static function stars_count( $star, $post_id ) {
		$agrs   = array(
			'post_id'    => $post_id,
			'count'      => true,
			'status'     => 'approve',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key'     => 'rating',
					'value'   => $star,
					'compare' => '='
				)
			)
		);
		$return = get_comments( $agrs );

		return $return;
	}
}
