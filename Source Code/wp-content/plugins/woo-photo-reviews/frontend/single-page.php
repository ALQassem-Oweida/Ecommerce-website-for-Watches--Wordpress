<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOO_PHOTO_REVIEWS_Frontend_Single_Page {
	protected static $settings, $frontend;
	protected $is_mobile;
	protected $anchor_link, $frontend_style, $quick_view;
	public function __construct() {
		self::$settings = new VI_WOO_PHOTO_REVIEWS_DATA();
		self::$frontend = 'VI_WOO_PHOTO_REVIEWS_Frontend_Frontend';
		if ( self::$settings->get_params( 'enable' ) !== 'on' ) {
			return;
		}
		//mobile detect
		global $wcpr_detect;
		$this->is_mobile = $wcpr_detect->isMobile() && ! $wcpr_detect->isTablet();
		if ( $this->is_mobile && self::$settings->get_params( 'mobile' ) !== 'on' ) {
			return;
		}
		$this->anchor_link = '#' . self::$settings->get_params( 'reviews_anchor_link' );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );
		// display overall rating, filter and pagination
		add_action( 'wp_footer', array( $this, 'overall_rating_and_filter_html' ) );
		//output#
		$this->frontend_style = self::$settings->get_params( 'photo', 'display' );
		if ( 1 == $this->frontend_style ) {
			add_action( 'wp_list_comments_args', array( $this, 'photo_reviews' ), 999 );
		} else {
			add_action( 'woocommerce_review_after_comment_text', array( $this, 'wc_reviews' ) );
		}
		add_action( 'viwcpr_get_overall_rating_html', array( $this, 'viwcpr_get_overall_rating_html' ), 10, 1 );
		add_action( 'viwcpr_get_filters_html', array( $this, 'viwcpr_get_filters_html' ), 10, 1 );
		add_action( 'viwcpr_get_template_masonry_html', array( $this, 'viwcpr_get_template_masonry_html' ), 10, 1 );
		add_action( 'viwcpr_get_template_basic_html', array( $this, 'viwcpr_get_template_basic_html' ), 10, 1 );
	}
	public function wc_reviews($comment){
		if ( ! is_product() ) {
			return;
		}
		global $product;
		if ( ! $product || $comment->comment_parent ) {
			return;
		}
		do_action( 'viwcpr_get_template_basic_html', array(
			'settings'       => self::$settings,
			'comment'        => $comment,
			'product'        => $product
		) );
	}
	public function photo_reviews($r){
		if (  ! is_product() ) {
			return $r;
		}
		if ( 'no' === get_option( 'woocommerce_enable_reviews' ) ) {
			return $r;
		}
		global $wp_query;
		$my_comments = $wp_query->comments;
		do_action( 'viwcpr_get_template_masonry_html', array(
			'settings'          => self::$settings,
			'my_comments'       => $my_comments,
			'cols'              => self::$settings->get_params( 'photo', 'col_num' ),
		) );
		$r['echo'] = false;
		return $r;
	}
	public function overall_rating_and_filter_html(){
		if ( ! is_product() || ! is_single() ) {
			return;
		}
		global $wp_query;
		$post_id       =  $wp_query->post->ID;
		$product       = function_exists( 'wc_get_product' ) ? wc_get_product( $post_id ) : new WC_Product( $post_id );
		$product_link  = wc_clean($_SERVER['REQUEST_URI']);
		$product_link1 = $product->get_permalink();
		$product_link  = remove_query_arg( array( 'image', 'verified', 'rating' ), $product_link );
		$product_link1 = remove_query_arg( array( 'image', 'verified', 'rating' ), $product_link1 );
		$agrs          = array(
			'post_id'  => $post_id,
			'count'    => true,
			'meta_key' => 'rating',
			'status'   => 'approve'
		);
		remove_action( 'parse_comment_query', array( self::$frontend, 'parse_comment_query' ) );
		remove_action( 'parse_comment_query', array( self::$frontend, 'parse_comment_query1' ) );
		$counts_review = get_comments( $agrs );
		do_action( 'viwcpr_get_overall_rating_html', array(
			'product_id'            => $post_id,
			'average_rating'        => $product->get_average_rating(),
			'count_reviews'         => $counts_review,
			'star_counts'         => array(),
			'overall_rating_enable' => self::$settings->get_params( 'photo', 'overall_rating' ),
			'rating_count_enable'   => self::$settings->get_params( 'photo', 'rating_count' )
		) );
		add_action( 'parse_comment_query', array( self::$frontend, 'parse_comment_query' ) );
		add_action( 'parse_comment_query', array( self::$frontend, 'parse_comment_query1' ) );
		if ( 'on' === self::$settings->get_params( 'photo', 'filter' )['enable'] ) {
			$agrs1          = array(
				'post_id'  => $post_id,
				'count'    => true,
				'meta_key' => 'reviews-images',
				'status'   => 'approve'
			);
			$count_images   = get_comments( $agrs1 );
			$agrs2          = array(
				'post_id'    => $post_id,
				'count'      => true,
				'status'     => 'approve',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key'     => 'rating',
						'compare' => 'EXISTS',
					),
					array(
						'key'     => 'verified',
						'value'   => 1,
						'compare' => '=',
					),
				)
			);
			$count_verified = get_comments( $agrs2 );
			remove_action( 'parse_comment_query', array( self::$frontend, 'parse_comment_query1' ) );
			$counts_review = get_comments( $agrs );
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
			do_action( 'viwcpr_get_filters_html', array(
				'settings'       => self::$settings,
				'product_id'     => $post_id,
				'count_reviews'  => $counts_review,
				'count_images'   => $count_images,
				'count_verified' => $count_verified,
				'query_rating'   => $query_rating,
				'query_verified' => $query_verified,
				'query_image'    => $query_image,
				'product_link'   => $product_link,
				'product_link1'  => $product_link1,
				'anchor_link'    => $this->anchor_link,
			) );
			add_action( 'parse_comment_query', array( self::$frontend, 'parse_comment_query1' ) );
		}
	}
	public function quick_view(){
		if ( ! is_product() || ! is_single() ) {
			return;
		}
		if ( $this->quick_view ) {
			return;
		}
		$this->quick_view = true;
		wc_get_template( 'viwcpr-quickview-template-html.php', array(),
			'woocommerce-photo-reviews' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR,
			WOO_PHOTO_REVIEWS_TEMPLATES );
	}
	public function frontend_enqueue() {
		if ( ! is_product() || ! is_single() ) {
			return;
		}
		$suffix = WP_DEBUG ? '' : 'min.';
		wp_enqueue_style( 'woocommerce-photo-reviews-style', VI_WOO_PHOTO_REVIEWS_CSS . 'style.'.$suffix.'css', array(), VI_WOO_PHOTO_REVIEWS_VERSION );
		wp_enqueue_script( 'woocommerce-photo-reviews-script', VI_WOO_PHOTO_REVIEWS_JS . 'script.'.$suffix.'js', array( 'jquery' ), VI_WOO_PHOTO_REVIEWS_VERSION );
		wp_localize_script( 'woocommerce-photo-reviews-script', 'woocommerce_photo_reviews_params', array(
				'ajaxurl'                    => admin_url( 'admin-ajax.php' ),
				'i18n_required_rating_text'  => esc_attr__( 'Please select a rating', 'woo-photo-reviews' ),
				'i18n_required_comment_text' => esc_attr__( 'Please enter your comment', 'woo-photo-reviews' ),
				'i18n_required_name_text'    => esc_attr__( 'Please enter your name', 'woo-photo-reviews' ),
				'i18n_required_email_text'   => esc_attr__( 'Please enter your email', 'woo-photo-reviews' ),
				'warning_gdpr'               => esc_html__( 'Please agree with our term and policy.', 'woo-photo-reviews' ),
				'upload_allow'                  => self::$settings->get_params( 'upload_allow' ),
				'max_file_size'                  => self::$settings->get_params( 'photo', 'maxsize' ),
				'max_files'                  => self::$settings->get_params( 'photo', 'maxfiles' ),
				'enable_photo'               => self::$settings->get_params( 'photo', 'enable' ),
				'required_image'             => self::$settings->get_params( 'photo', 'required' ),
				'warning_required_image'     => esc_html__( 'Please upload at least one image for your review!', 'woo-photo-reviews' ),
				'warning_max_files'          => sprintf( _n( 'You can only upload maximum of %s file', 'You can only upload maximum of %s files', self::$settings->get_params( 'photo', 'maxfiles' ), 'woo-photo-reviews' ), self::$settings->get_params( 'photo', 'maxfiles' ) ),
				'warning_upload_allow'          => sprintf( esc_html__( '\'%s\' is not an allowed file type.', 'woo-photo-reviews' ),'%file_name%'),
				'warning_max_file_size'          => sprintf( esc_html__( 'The size of \'%s\' is greater than %s kB.',  'woo-photo-reviews' ),'%file_name%', self::$settings->get_params( 'photo', 'maxsize' ) ),
				'comments_container_id'      => apply_filters( 'woocommerce_photo_reviews_comments_wrap', 'comments' ),
				'nonce'                      => wp_create_nonce( 'woocommerce_photo_reviews_nonce' ),
			)
		);
		if ($this->frontend_style==1){
			wp_enqueue_style( 'wcpr-masonry-style', VI_WOO_PHOTO_REVIEWS_CSS . 'masonry.'.$suffix.'css', array(), VI_WOO_PHOTO_REVIEWS_VERSION );
			wp_enqueue_script( 'wcpr-swipebox-js', VI_WOO_PHOTO_REVIEWS_JS . 'jquery.swipebox.js', array( 'jquery' ) );
			wp_enqueue_style( 'wcpr-swipebox-css', VI_WOO_PHOTO_REVIEWS_CSS . 'swipebox.'.$suffix.'css' );
			wp_enqueue_script( 'wcpr-masonry-script', VI_WOO_PHOTO_REVIEWS_JS . 'masonry.'.$suffix.'js', array( 'jquery' ), VI_WOO_PHOTO_REVIEWS_VERSION );
			add_action( 'wp_footer', array( $this, 'quick_view' ) );
		}else{
			wp_enqueue_style( 'wcpr-rotate-font-style', VI_WOO_PHOTO_REVIEWS_CSS . 'rotate.min.css', array(), VI_WOO_PHOTO_REVIEWS_VERSION );
			wp_enqueue_style( 'wcpr-default-display-style', VI_WOO_PHOTO_REVIEWS_CSS . 'default-display-images.'.$suffix.'css', array(), VI_WOO_PHOTO_REVIEWS_VERSION );
			wp_enqueue_script( 'wcpr-default-display-script', VI_WOO_PHOTO_REVIEWS_JS . 'default-display-images.'.$suffix.'js', array( 'jquery' ), VI_WOO_PHOTO_REVIEWS_VERSION );
			$css_default = ".reviews-images-item{margin-right: 2px;padding: 0;float:left;border-radius: 3px;}.kt-reviews-image-container .kt-wc-reviews-images-wrap-wrap .reviews-images-item .review-images{float: left !important;height: 48px !important;width:auto !important;border-radius: 3px;}";
			wp_add_inline_style( 'wcpr-default-display-style', $css_default );
		}
		$css_inline = self::$settings->get_params( 'photo', 'custom_css' );
		if ( self::$settings->get_params( 'photo', 'filter' )['enable'] == 'on' ) {
			$css_inline .= ".wcpr-filter-container{";
			if ( self::$settings->get_params( 'photo', 'filter' )['area_border_color'] ) {
				$css_inline .= "border:1px solid " . self::$settings->get_params( 'photo', 'filter' )['area_border_color'] . ";";
			}
			if ( self::$settings->get_params( 'photo', 'filter' )['area_bg_color'] ) {
				$css_inline .= 'background-color:' . self::$settings->get_params( 'photo', 'filter' )['area_bg_color'] . ';';
			}
			$css_inline .= "}";
			$css_inline .= '.wcpr-filter-button{';

			if ( self::$settings->get_params( 'photo', 'filter' )['button_color'] ) {
				$css_inline .= 'color:' . self::$settings->get_params( 'photo', 'filter' )['button_color'] . ';';
			}
			if ( self::$settings->get_params( 'photo', 'filter' )['button_bg_color'] ) {
				$css_inline .= 'background-color:' . self::$settings->get_params( 'photo', 'filter' )['button_bg_color'] . ';';
			}
			if ( self::$settings->get_params( 'photo', 'filter' )['button_border_color'] ) {
				$css_inline .= 'border:1px solid ' . self::$settings->get_params( 'photo', 'filter' )['button_border_color'] . ';';
			}
			$css_inline .= "}";
		}
		if ( 'on' == self::$settings->get_params( 'photo', 'rating_count' ) ) {
			$rating_count_bar_color = self::$settings->get_params( 'photo', 'rating_count_bar_color' );
			if ( ! $rating_count_bar_color ) {
				$rating_count_bar_color = '#96588a';
			}
			$css_inline .= '.rate-percent{background-color:' . $rating_count_bar_color . ';}';
		}
		if ( self::$settings->get_params( 'photo', 'star_color' ) ) {
			$css_inline .= '.star-rating:before,.star-rating span:before,.stars a:hover:after, .stars a.active:after{color:' . self::$settings->get_params( 'photo', 'star_color' ) . ' !important;}';
		}
		wp_add_inline_style( 'woocommerce-photo-reviews-style', $css_inline );
	}

	public function viwcpr_get_template_basic_html( $arg ) {
		if ( empty( $arg ) ) {
			return;
		}
		wc_get_template( 'viwcpr-template-basic-html.php', $arg,
			'woocommerce-photo-reviews' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR,
			WOO_PHOTO_REVIEWS_TEMPLATES );
	}
	public function viwcpr_get_template_masonry_html( $arg ) {
		if ( empty( $arg ) ) {
			return;
		}
		wc_get_template( 'viwcpr-template-masonry-html.php', $arg,
			'woocommerce-photo-reviews' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR,
			WOO_PHOTO_REVIEWS_TEMPLATES );
	}
	public function viwcpr_get_filters_html( $arg ) {
		if ( empty( $arg ) ) {
			return;
		}
		wc_get_template( 'viwcpr-filters-html.php', $arg,
			'woocommerce-photo-reviews' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR,
			WOO_PHOTO_REVIEWS_TEMPLATES );
	}
	public function viwcpr_get_overall_rating_html( $arg ) {
		if ( empty( $arg ) ) {
			return;
		}
		wc_get_template( 'viwcpr-overall-rating-html.php', $arg,
			'woocommerce-photo-reviews' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR,
			WOO_PHOTO_REVIEWS_TEMPLATES );
	}
}