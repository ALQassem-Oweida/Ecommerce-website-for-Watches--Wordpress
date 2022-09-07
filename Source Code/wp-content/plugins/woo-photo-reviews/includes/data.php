<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOO_PHOTO_REVIEWS_DATA {
	private $params;
	private $default;
	private static $date_format;
	private static $time_format;
	/**
	 * VI_WOO_PHOTO_REVIEWS_DATA constructor.
	 * Init setting
	 */
	public function __construct() {
		self::$date_format = get_option( 'date_format', 'F d, Y' );
		self::$time_format = get_option( 'time_format', 'H:i:s' );
		global $woo_photo_reviews_settings;
		if ( ! $woo_photo_reviews_settings ) {
			$woo_photo_reviews_settings = get_option( '_wcpr_nkt_setting', array() );
		}
		$post_max      = absint(ini_get( 'post_max_size' ));
		$upload_max    = absint( ini_get( 'upload_max_filesize' ) );
		$max_allow     = $post_max > $upload_max ? $upload_max : $post_max;
		$maxsize       = $max_allow > 2 ? ( 2000 ) : ( $max_allow * 1000 );
		$this->default = array(
			'enable'                => 'on',
			'mobile'                => 'on',
			'key'                   => '',
			'photo'                 => array(
				'enable'                 => 'on',
				'maxsize'                => $maxsize,
				'maxfiles'               => 2,
				'required'               => 'off',
				'display'                => 1,
				'col_num'                => 3,
				'grid_bg'                => '',
				'grid_item_bg'           => '#f3f3f3',
				'comment_text_color'     => '#000',
				'star_color'             => '#ffb600',
				'sort'                   => array(
					'time' => 1
				),
				'rating_count'           => 'on',
				'rating_count_bar_color' => '#96588a',
				'filter'                 => array(
					'enable'                 => 'on',
					'area_border_color'      => '#e5e5e5',
					'area_bg_color'          => '',
					'button_border_color'    => '#e5e5e5',
					'button_color'           => '',
					'button_bg_color'        => '',
					'active_button_color'    => '',
					'active_button_bg_color' => '',
				),
				'custom_css'             => '',
				'review_tab_first'       => 'off',
				'gdpr'                   => 'off',
				'gdpr_message'           => 'I agree with the privacy policy',
				'overall_rating'         => 'off',
				'single_product_summary' => 'off',
				'verified'               => 'default',
				'verified_text'          => 'Verified owner',
				'verified_badge'         => 'woocommerce-photo-reviews-badge-tick',
				'verified_color'         => '#29d50b',
				'verified_size'          => '',
				'hide_name'              => 'off',
				'show_review_date'          => '1',
			),
			'coupon'                => array(
				'enable'                   => 'on',
				'require'                  => array(
					'photo'      => 'off',
					'min_rating' => 0,
					'owner'      => 'off',
					'register'   => 'off',
				),
				'form_title'               => 'Review now to get coupon!',
				'products_gene'            => array(),
				'excluded_products_gene'   => array(),
				'categories_gene'          => array(),
				'excluded_categories_gene' => array(),
				'email'                    => array(
					'subject' => 'Discount Coupon For Your Review',
					'heading' => 'Thank You For Your Review!',
					'content' => "Dear {customer_name},\nThank you so much for leaving review on my website!\nWe'd like to offer you this discount coupon as our thankfulness to you.\nCoupon code: {coupon_code}.\nDate expires: {date_expires}.\nYours sincerely!"
				),
				'coupon_select'            => 'kt_generate_coupon',
				'unique_coupon'            => array(
					'discount_type'               => 'percent',
					'coupon_amount'               => 11,
					'allow_free_shipping'         => 'no',
					'expiry_date'                 => null,
					'min_spend'                   => '',
					'max_spend'                   => '',
					'individual_use'              => 'no',
					'exclude_sale_items'          => 'no',
					'limit_per_coupon'            => 1,
					'limit_to_x_items'            => null,
					'limit_per_user'              => 0,
					'product_ids'                 => array(),
					'excluded_product_ids'        => array(),
					'product_categories'          => array(),
					'excluded_product_categories' => array(),
					'coupon_code_prefix'          => ''
				),
				'existing_coupon'          => ''
			),
			'followup_email'        => array(
				'enable'                      => 'on',
				'subject'                     => 'Review our products to get discount coupon',
				'content'                     => "Dear {customer_name},\nThank you for your recent purchase from our company.\nWe’re excited to count you as a customer. Our goal is always to provide our very best product so that our customers are happy. It\’s also our goal to continue improving. That\’s why we value your feedback.\nThank you so much for taking the time to provide us feedback and review. This feedback is appreciated and very helpful to us.\nBest regards!",
				'heading'                     => 'Review our product now',
				'amount'                      => 10,
				'unit'                        => 's',
				'products_restriction'        => array(),
				'excluded_categories'         => array(),
				'review_button_color'         => '#ffffff',
				'exclude_non_coupon_products' => 'off',
				'review_button_bg_color'      => '#88256f',
			),
			//new options-> checkbox value 1||0
			'pagination_ajax'       => '',
			'reviews_container'     => '',
			'reviews_anchor_link'   => 'reviews',
			'set_email_restriction' => 1,
			'multi_language'        => 0,
			'upload_allow'                  => array( "image/jpg" , "image/jpeg" ,"image/bmp" , "image/png", "image/webp","image/gif"),
		);

		$this->params = apply_filters( '_wcpr_nkt_setting', wp_parse_args( $woo_photo_reviews_settings, $this->default ) );
	}

	public function get_params( $name = "", $name_sub1 = "") {
		if ( ! $name ) {
			return $this->params;
		} elseif ( isset( $this->params[ $name ] ) ) {
			if ( $name_sub1 ) {
				if ( isset( $this->params[ $name ][ $name_sub1 ] ) ) {
					return apply_filters( '_wcpr_nkt_setting_' . $name . '__' . $name_sub1, $this->params[ $name ] [ $name_sub1 ] );
				} elseif ( $this->default[ $name ] [ $name_sub1 ] ) {
					return apply_filters( '_wcpr_nkt_setting_' . $name . '__' . $name_sub1, $this->default[ $name ] [ $name_sub1 ] );
				} else {
					return false;
				}
			} else {
				return apply_filters( '_wcpr_nkt_setting_' . $name, $this->params[ $name ] );

			}
		} else {
			return false;
		}
	}

	public function get_default( $name = "", $name_sub1 = '' ) {
		if ( ! $name ) {
			return $this->default;
		} elseif ( isset( $this->default[ $name ] ) ) {
			if ( $name_sub1 ) {
				if ( isset( $this->default[ $name ][ $name_sub1 ] ) ) {
					return apply_filters( '_wcpr_nkt_setting_default_' . $name . '__' . $name_sub1, $this->default[ $name ] [ $name_sub1 ] );
				} else {
					return false;
				}
			} else {
				return apply_filters( '_wcpr_nkt_setting_default_' . $name, $this->default[ $name ] );
			}
		} else {
			return false;
		}
	}
	public static function get_date_format() {
		return self::$date_format;
	}

	public static function get_time_format() {
		return self::$time_format;
	}

	public static function get_datetime_format() {
		return self::$date_format . ' ' . self::$time_format;
	}
	public static function extend_post_allowed_html() {
		return array_merge( wp_kses_allowed_html( 'post' ), array(
				'input' => array(
					'type'         => 1,
					'id'           => 1,
					'name'         => 1,
					'class'        => 1,
					'placeholder'  => 1,
					'autocomplete' => 1,
					'style'        => 1,
					'value'        => 1,
					'data-*'       => 1,
					'size'         => 1,
				),
				'form'  => array(
					'type'   => 1,
					'id'     => 1,
					'name'   => 1,
					'class'  => 1,
					'style'  => 1,
					'method' => 1,
					'action' => 1,
					'data-*' => 1,
				),
				'style'  => array(
					'id'     => 1,
					'class'  => 1,
					'type'  => 1,
				),
			)
		);
	}
}

new VI_WOO_PHOTO_REVIEWS_DATA();
