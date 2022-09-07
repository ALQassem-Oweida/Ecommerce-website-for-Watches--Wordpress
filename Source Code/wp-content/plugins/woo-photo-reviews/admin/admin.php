<?php
/*
Class Name: VI_WOO_PHOTO_REVIEWS_Admin_Admin
Author: Andy Ha (support@villatheme.com)
Author URI: http://villatheme.com
Copyright 2018 villatheme.com. All rights reserved.
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOO_PHOTO_REVIEWS_Admin_Admin {
	protected $settings;
	protected $anchor_link;
	protected $new_review_id;
	protected $language;

	public function __construct() {
		$this->settings    = new VI_WOO_PHOTO_REVIEWS_DATA();
		$this->anchor_link = '#' . $this->settings->get_params( 'reviews_anchor_link' );
		add_action( 'admin_init', array( $this, 'update_data' ) );
		add_action( 'admin_init', array( $this, 'save_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_menu' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
//		add_action( 'wp_ajax_wcpr_search_product', array( $this, 'search_product' ) );
		add_action( 'wp_ajax_wcpr_search_coupon', array( $this, 'search_coupon' ) );
		add_action( 'wp_ajax_wcpr_search_parent_product', array( $this, 'search_parent_product' ) );
		add_action( 'wp_ajax_wcpr_search_cate', array( $this, 'search_cate' ) );
		//if a review is deleted, also delete the photos of that review
		add_action( 'delete_comment', array( $this, 'delete_reviews_image' ) );
		add_action( 'delete_attachment', array( $this, 'delete_attachment' ) );
		/*edit review image*/
		add_action( 'add_meta_boxes_comment', array( $this, 'wcpr_add_meta_box' ) );
		add_action( 'edit_comment', array( $this, 'save_comment_meta' ) );
		add_action( 'load-edit-comments.php', array( $this, 'load_photos_in_comment_list' ) );
		add_filter( "manage_product_page_product-reviews_columns", array( $this, 'add_columns' ) );
		add_action( 'manage_comments_custom_column', array( $this, 'column_callback' ), 10, 2 );
		add_action( 'woocommerce_product_reviews_table_column_wcpr_photos', array( $this, 'product_reviews_table_column_callback_wcpr_photos' ), 10, 1 );
		/*preview email*/
		add_action( 'media_buttons', array( $this, 'preview_emails_button' ) );
		add_action( 'wp_ajax_wcpr_preview_emails', array( $this, 'preview_emails_ajax' ) );
		add_action( 'admin_footer', array( $this, 'preview_emails_html' ) );
		//translation & support
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		/*add image size*/
		add_action( 'init', array( $this, 'add_image_size' ) );

		/*manage uploaded image sizes when uploading review images in backend*/
		add_filter( 'plupload_default_params', array( $this, 'plupload_default_params' ) );
		add_filter( 'intermediate_image_sizes', array( $this, 'reduce_image_sizes_for_media_upload' ) );
	}
	public function load_plugin_textdomain() {
		$locale = is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'woo-photo-reviews' );
		load_textdomain( 'woo-photo-reviews', WP_PLUGIN_DIR . "/woo-photo-reviews/languages/woo-photo-reviews-$locale.mo" );
		load_plugin_textdomain( 'woo-photo-reviews', false, basename( dirname( __FILE__ ) ) . "/languages" );
		if ( class_exists( 'VillaTheme_Support' ) ) {
			new VillaTheme_Support(
				array(
					'support'   => 'https://wordpress.org/support/plugin/woo-photo-reviews/',
					'docs'      => 'http://docs.villatheme.com/?item=woocommerce-photo-reviews',
					'review'    => 'https://wordpress.org/support/plugin/woo-photo-reviews/reviews/?rate=5#rate-response',
					'pro_url'   => 'https://1.envato.market/L3WrM',
					'css'       => VI_WOO_PHOTO_REVIEWS_CSS,
					'image'     => VI_WOO_PHOTO_REVIEWS_IMAGES,
					'slug'      => 'woo-photo-reviews',
					'menu_slug' => 'woo-photo-reviews',
					'survey_url' => 'https://script.google.com/macros/s/AKfycbzOenOVxgSekaQ3ihvT0sNRg3xbhr3KboqojBc54R01XVWQaIGKl8FnjZOobo61UU7m/exec',
					'version'   => VI_WOO_PHOTO_REVIEWS_VERSION
				)
			);
		}
	}

	public function update_data() {
		if ( ! get_transient( 'woocommerce_photo_review_update_data_version_1_1_0' ) ) {
			$args     = array(
				'post_type'  => 'product',
				'type'       => 'review',
				'status'     => 'approve',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key'     => 'id_import_reviews_from_ali',
						'compare' => 'NOT EXISTS'
					)
				)
			);
			$comments = get_comments( $args );
			if ( count( $comments ) ) {
				foreach ( $comments as $comment ) {
					$user_id    = $comment->user_id;
					$product_id = $comment->comment_post_ID;
					if ( ! $product_id ) {
						continue;
					}
					if ( ! $user_id ) {
						$user_id = get_user_by( 'email', $comment->comment_author_email );
					}
					if ( $user_id ) {
						$user_coupon = get_user_meta( $user_id, 'wcpr_user_reviewed_product', false );
						if (empty($user_coupon) || (is_array($user_coupon) && ! in_array( $product_id, $user_coupon )) ) {
							add_user_meta( $user_id, 'wcpr_user_reviewed_product', $product_id );
						}
					}
				}
			}
			set_transient( 'woocommerce_photo_review_update_data_version_1_1_0', current_time( 'timestamp' ) );
		}

	}

	public function add_image_size() {
		if ( wp_doing_ajax() ) {
			/*for adding or updating reviews in admin and downloading image while importing*/
			if ( !empty( $_POST['wcpr_adjust_image_sizes'] ) ) {
				add_image_size( 'wcpr-photo-reviews', 500, 500 );
			}
		} elseif ( is_admin() ) {
			/*for bulk download review images of imported reviews from AliExpress*/
			global $pagenow;
			if ( $pagenow === 'edit-comments.php' ) {
				add_image_size( 'wcpr-photo-reviews', 500, 500 );
				add_filter( 'intermediate_image_sizes', array( $this, 'reduce_image_sizes' ) );
			}
		} else {
			/*for frontend usage when a customer adds a review*/
			add_image_size( 'wcpr-photo-reviews', 500, 500 );
		}
	}

	/**When using wp_media to upload images for adding or updating reviews in admin, set $params['wcpr_adjust_image_sizes'] to
	 * detect and reduce image sizes for those uploading only
	 *
	 * @param $params
	 *
	 * @return mixed
	 */
	public function plupload_default_params( $params ) {
		global $pagenow;
		if ( $pagenow == 'admin.php' && isset( $_REQUEST['page'] ) && wp_unslash( sanitize_text_field( $_REQUEST['page'] ) ) === 'kt-wcpr-add-review' ) {
			$params['wcpr_adjust_image_sizes'] = 1;
		} elseif ( $pagenow == 'comment.php' && isset( $_REQUEST['action'] ) && wp_unslash( sanitize_text_field( $_REQUEST['action'] ) ) === 'editcomment' ) {
			$params['wcpr_adjust_image_sizes'] = 1;
		} elseif ( $pagenow === 'edit.php' && isset( $_GET['post_type'] ) && wp_unslash( sanitize_text_field( $_GET['post_type'] ) ) === 'product' ) {
			$params['wcpr_adjust_image_sizes'] = 1;
		}

		return $params;
	}

	public function reduce_image_sizes_for_media_upload( $sizes ) {
		if ( !empty( $_POST['wcpr_adjust_image_sizes'] ) ) {
			foreach ( $sizes as $k => $size ) {
				if ( in_array( $size, array( 'thumbnail', 'wcpr-photo-reviews', 'medium' ) ) ) {
					continue;
				}
				unset( $sizes[ $k ] );
			}
		}

		return $sizes;
	}

	public function reduce_image_sizes( $sizes ) {
		foreach ( $sizes as $k => $size ) {
			if ( in_array( $size, array( 'thumbnail', 'wcpr-photo-reviews', 'medium' ) ) ) {
				continue;
			}
			unset( $sizes[ $k ] );
		}

		return $sizes;
	}

	function preview_emails_html() {
		global $pagenow;
		$page = isset( $_REQUEST['page'] ) ? wp_unslash( sanitize_text_field( $_REQUEST['page'] ) ) : '';
		if ( $pagenow == 'admin.php' && $page === 'woo-photo-reviews' ) {
			?>
            <div class="preview-emails-html-container preview-html-hidden">
                <div class="preview-emails-html-overlay"></div>
                <div class="preview-emails-html"></div>
            </div>
			<?php
		}
	}

	public function preview_emails_button( $editor_id ) {
		global $pagenow;
		$page = isset( $_REQUEST['page'] ) ? wp_unslash( sanitize_text_field( $_REQUEST['page'] ) ) : '';
		if ( $pagenow == 'admin.php' && $page == 'woo-photo-reviews' ) {
			$editor_ids = array( 'content' );
			if ( in_array( $editor_id, $editor_ids ) ) {
				ob_start();
				?>
                <span class="button coupon-preview-emails-button"
                      data-wcpr_language="<?php echo esc_attr(str_replace( 'content', '', $editor_id )) ?>"><?php esc_html_e( 'Preview emails', 'woo-photo-reviews' ) ?></span>
				<?php
				echo wp_kses_post(ob_get_clean());
			}
			$editor_ids = array( 'follow_up_email_content' );
			if ( in_array( $editor_id, $editor_ids ) ) {
				ob_start();
				?>
                <span class="button reminder-preview-emails-button"
                      data-wcpr_language="<?php echo esc_attr(str_replace( 'follow_up_email_content', '', $editor_id )) ?>"><?php esc_html_e( 'Preview emails', 'woo-photo-reviews' ) ?></span>
				<?php
				echo wp_kses_post(ob_get_clean());
			}
		}
	}

	public function preview_emails_ajax() {
		$email_type    = isset( $_GET['email_type'] ) ? sanitize_text_field( $_GET['email_type'] ) : 'coupon';
		$date_format   = VI_WOO_PHOTO_REVIEWS_DATA::get_date_format();
		$content       = isset( $_GET['content'] ) ? wp_kses_post( wp_unslash( $_GET['content'] ) ) : '';
		$email_heading = isset( $_GET['heading'] ) ? wp_kses_post( wp_unslash( $_GET['heading'] ) ) : '';
		$customer_name = 'John';
		if ( $email_type == 'coupon' ) {
			$coupon_value = '10%';
			$coupon_code  = 'HAPPY';
			$date_expires = strtotime( '+30 days' );

			$content       = str_replace( '{customer_name}', $customer_name, $content );
			$content       = str_replace( '{coupon_code}', '<span style="font-size: x-large;">' . strtoupper( $coupon_code ) . '</span>', $content );
			$content       = str_replace( '{date_expires}', date_i18n( $date_format, $date_expires ), $content );
			$email_heading = str_replace( '{coupon_value}', $coupon_value, $email_heading );
		} else {
			$anchor                 = isset( $_GET['anchor'] ) ? sanitize_text_field( $_GET['anchor'] ) : '';
			$anchor                 = '#' . $anchor;
			$review_button_bg_color = $this->settings->get_params( 'followup_email', 'review_button_bg_color' );
			$review_button_color    = $this->settings->get_params( 'followup_email', 'review_button_color' );
			$order_id               = 1;
			$now                    = strtotime( 'now' );
			$date_create            = date_i18n( $date_format, $now - 86400 );
			$date_complete          = date_i18n( $date_format, $now );
			$content                = str_replace( '{customer_name}', $customer_name, $content );
			$content                = str_replace( '{order_id}', $order_id, $content );
			$content                = str_replace( '{date_create}', $date_create, $content );
			$content                = str_replace( '{date_complete}', $date_complete, $content );
			$content                = str_replace( '{site_title}', get_bloginfo( 'name' ), $content );
			$content                .= '<table style="width: 100%;">';
			$sents                  = array();
			$products               = wc_get_products( array( 'numberposts' => 3, 'post_status' => 'public' ) );
			if ( count( $products ) ) {
				foreach ( $products as $p ) {
					$product = wc_get_product( $p );
					if ( $product ) {
						$product_image = wp_get_attachment_thumb_url( $product->get_image_id() );
						$product_url   = $product->get_permalink() . $anchor;
						$product_title = $product->get_title();
						$product_price = $product->get_price_html();
						if ( $product->is_type( 'variation' ) ) {
							$product_parent_id = $product->get_parent_id();
							if ( in_array( $product_parent_id, $sents ) ) {
								continue;
							}
							$product_parent = wc_get_product( $product_parent_id );
							if ( $product_parent ) {
								if ( ! $product_image ) {
									$product_image = wp_get_attachment_thumb_url( $product_parent->get_image_id() );
								}
								$product_url   = $product_parent->get_permalink() . $anchor;
								$product_title = $product_parent->get_title();
								$product_price = $product_parent->get_price_html();
								$sents[]       = $product_parent_id;
							}
						} else {
							if ( in_array( $p, $sents ) ) {
								continue;
							}
							$sents[] = $p;
						}
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
                                    <a target="_blank"
                                       href="<?php echo esc_url( $product_url) ?>"><?php echo wp_kses_post($product_title) ?></a>
                                </p>
                                <p><?php echo wp_kses_post($product_price) ?></p>
                                <a target="_blank"
                                   style="text-align: center;padding: 10px;text-decoration: none;font-weight: 800;
                                           background-color:<?php echo esc_attr($review_button_bg_color) ?>;
                                           color:<?php echo esc_attr($review_button_color) ?>;"
                                   href="<?php echo esc_url($product_url) ?>"><?php esc_html_e( 'Review Now', 'woo-photo-reviews' ) ?>
                                </a>
                            </td>
                        </tr>
						<?php
						$content .= ob_get_clean();
					}

				}
			}
			$content .= '</table>';
		}


		// load the mailer class
		$mailer = WC()->mailer();

		// create a new email
		$email = new WC_Email();

		// wrap the content with the email template and then add styles
		$message = apply_filters( 'woocommerce_mail_content', $email->style_inline( $mailer->wrap_message( $email_heading, $content ) ) );

		// print the preview email
		wp_send_json(
			array(
				'html' => $message,
			)
		);
	}

	public function status() {
		?>
        <div id="kt_status_page" class="wrap">
            <h1></h1>
            <table width="30%">
                <tr>
                    <th colspan="3"><?php esc_html_e( 'System status', 'woo-photo-reviews' ) ?></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td width="50%"><?php esc_html_e( 'File upload:', 'woo-photo-reviews' ) ?></td>
                    <td width="25%"><?php if ( ini_get( 'file_uploads' ) == 1 ) {
							echo esc_html('On');
						} else {
							echo esc_html('Off');
						} ?></td>
                    <td><?php if ( ini_get( 'file_uploads' ) == 1 ) {
							printf('<span class="status-ok">OK</span>');
						} else {
							printf( '<span class="status-bad">X</span>');
						} ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e( 'Upload max filesize:', 'woo-photo-reviews' ) ?></td>
                    <td><?php _e( ini_get( 'upload_max_filesize' ), 'woo-photo-reviews' ); ?></td>
                    <td><?php if ( ini_get( 'post_max_size' ) > ( absint( ini_get( 'upload_max_filesize' ) ) * ini_get( 'max_file_uploads' ) + 1 ) && ini_get( 'upload_max_filesize' ) > 0 && ini_get( 'max_file_uploads' ) > 0 ) {
							printf( '<span class="status-ok">OK</span>');
						} else {
							printf( '<span class="status-bad">X</span>');
						} ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e( 'Max file uploads:', 'woo-photo-reviews' ) ?></td>
                    <td><?php _e( ini_get( 'max_file_uploads' ), 'woo-photo-reviews' ); ?></td>
                    <td><?php if ( ini_get( 'post_max_size' ) > ( absint( ini_get( 'upload_max_filesize' ) ) * ini_get( 'max_file_uploads' ) + 1 ) && ini_get( 'upload_max_filesize' ) > 0 && ini_get( 'max_file_uploads' ) > 0 ) {
							printf( '<span class="status-ok">OK</span>');
						} else {
							printf( '<span class="status-bad">X</span>');
						} ?></td>
                </tr>
                <tr>
                    <td><?php esc_html_e( 'Post maxsize:', 'woo-photo-reviews' ) ?></td>
                    <td><?php _e( ini_get( 'post_max_size' ), 'woo-photo-reviews' ); ?></td>
                    <td><?php if ( ini_get( 'post_max_size' ) > ( absint( ini_get( 'upload_max_filesize' ) ) * ini_get( 'max_file_uploads' ) + 1 ) && ini_get( 'upload_max_filesize' ) > 0 && ini_get( 'max_file_uploads' ) > 0 ) {
							printf( '<span class="status-ok">OK</span>');
						} else {
							printf( '<span class="status-bad">X</span>');
						} ?></td>
                </tr>
                <tr>
                    <td colspan="3"><p>
                            <i><?php esc_html_e( 'Post maxsize', 'woo-photo-reviews' ) ?></i> <?php esc_html_e( 'should be greater than', 'woo-photo-reviews' ) ?>
                            <i><?php esc_html_e( 'Max file upload', 'woo-photo-reviews' ) ?></i> <?php esc_html_e( 'plus', 'woo-photo-reviews' ) ?>
                            <i><?php esc_html_e( ' Upload max filesize.', 'woo-photo-reviews' ) ?></i></p>
                    </td>
                </tr>
            </table>
        </div>
		<?php
	}

	public function settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$this->settings  = new VI_WOO_PHOTO_REVIEWS_DATA();
		$coupon_generate = $this->settings->get_params( 'coupon', 'unique_coupon' );
		?>
        <div class="wrap">
            <h2><?php esc_html_e( 'Photo Reviews for WooCommerce Settings', 'woo-photo-reviews' ); ?></h2>
            <p><?php _e( 'Some related helpful settings about pagination, moderating reviews... can be found in <a target="_blank" href="' . admin_url( "options-discussion.php" ) . '">Discussion Settings</a> and  <a target="_blank" href="' . admin_url( "admin.php" ) . '?page=wc-settings&tab=products">WooCommerce Settings</a>', 'woo-photo-reviews' ) ?></p>
            <p><?php _e( 'To change Emails design, go to <a target="_blank" href="' . admin_url( "admin.php" ) . '?page=wc-settings&tab=email#woocommerce_email_base_color">WooCommerce Emails Settings</a>.', 'woo-photo-reviews' ) ?></p>
            <form action="" method="POST" class="vi-ui form">
				<?php wp_nonce_field( 'wcpr_settings_page_save', 'wcpr_nonce_field' ); ?>
                <div class="vi-ui top tabular menu">
                    <div class="item active"
                         data-tab="general"><?php esc_html_e( 'General', 'woo-photo-reviews' ); ?></div>
                    <div class="item"
                         data-tab="photo"><?php esc_html_e( 'Reviews', 'woo-photo-reviews' ); ?></div>
                    <div class="item"
                         data-tab="rating_filter"><?php esc_html_e( 'Rating Counts & Filters', 'woo-photo-reviews' ); ?></div>
                    <div class="item"
                         data-tab="coupon"><?php esc_html_e( 'Coupon', 'woo-photo-reviews' ); ?></div>
                    <div class="item"
                         data-tab="email"><?php esc_html_e( 'Review Reminder', 'woo-photo-reviews' ); ?></div>
                </div>
                <div class="vi-ui bottom active tab segment" data-tab="general">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th>
                                <label for="wcpr-enable"><?php esc_html_e( 'Enable', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input type="checkbox" name="wcpr-enable"
                                           id="wcpr-enable" <?php checked( $this->settings->get_params( 'enable' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wcpr-mobile"><?php esc_html_e( 'Mobile', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input type="checkbox" name="wcpr-mobile"
                                           id="wcpr-mobile" <?php checked( $this->settings->get_params( 'mobile' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="wcpr_multi_language"><?php esc_html_e( 'Enable Multilingual', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <div class="vi-ui bottom tab segment" data-tab="photo">
                    <table class="form-table">
                        <tr>
                            <th>
                                <label for="photo_reviews_options"><?php esc_html_e( 'Include photos', 'woo-photo-reviews' ) ?></label>
                            </th>

                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input type="checkbox" id="photo_reviews_options"
                                           name="photo_reviews_options" <?php checked( $this->settings->get_params( 'photo', 'enable' ), 'on' ) ?>><label
                                            for="photo_reviews_options"><?php esc_html_e( 'Allow customers to attach photos in their review.', 'woo-photo-reviews' ) ?></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="photo_reviews_options"><?php esc_html_e( 'Include videos', 'woo-photo-reviews' ) ?></label>
                            </th>

                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>
						<?php
						$upload_max_filesize = wc_let_to_num( ini_get( 'upload_max_filesize' ) ) / 1024;
						?>
                        <tr>
                            <th>
                                <label for="image_maxsize"><?php esc_html_e( 'Maximum photo size', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <div class="inline field">
                                    <input id="image_maxsize" class="kt-photo-reviews-setting" type="number"
                                           name="image_maxsize" min="0"
                                           max="<?php echo esc_attr( $upload_max_filesize ); ?>"
                                           step="1"
                                           value="<?php echo esc_attr($this->settings->get_params( 'photo', 'maxsize' )); ?>"><?php printf( esc_html__( 'KB (Max %s KB).', 'woo-photo-reviews' ), $upload_max_filesize ); ?>
                                </div>
                                <p><?php esc_html_e( 'The maximum size of a single picture can be uploaded.', 'woo-photo-reviews' ) ?></p>

                            </td>

                        </tr>
                        <tr>
                            <th>
                                <label for="max_file_uploads"><?php esc_html_e( 'Maximum photo quantity', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <div class="inline field">
                                    <input id="max_file_uploads" type="number"
                                           value="2" readonly>
                                    <a class="vi-ui button" target="_blank"
                                       href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                                </div>
                                <p><?php esc_html_e( 'The maximum quantity of photos can be uploaded with a review.', 'woo-photo-reviews' ) ?></p>

                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="photo_required"><?php esc_html_e( 'Photo required', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input class="kt-photo-reviews-setting" type="checkbox" id="photo_required"
                                           name="photo_reviews_required"
                                           value="on" <?php if ( 'on' == $this->settings->get_params( 'photo', 'required' ) ) {
										echo esc_attr('checked');
									}
									?>>
                                    <label for="photo_required"><?php esc_html_e( 'Reviews must include photo to be uploaded.', 'woo-photo-reviews' ) ?></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Sort reviews by', 'woo-photo-reviews' ) ?></th>
                            <td>
                                <div class="grouped fields">


                                    <div class="field">
                                        <div class="vi-ui toggle checkbox">
                                            <input class="kt-photo-reviews-setting" type="radio"
                                                   name="reviews_sort_time" value="1"
                                                   id="reviews_sort_time_new" <?php if ( 1 == $this->settings->get_params( 'photo', 'sort' )['time'] ) {
												echo esc_attr('checked');
											}
											?>><label
                                                    for="reviews_sort_time_new"><?php esc_html_e( ' Newest first', 'woo-photo-reviews' ) ?></label>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="vi-ui toggle checkbox">
                                            <input class="kt-photo-reviews-setting" type="radio"
                                                   name="reviews_sort_time" value="2"
                                                   id="reviews_sort_time_old" <?php if ( 2 == $this->settings->get_params( 'photo', 'sort' )['time'] ) {
												echo esc_attr('checked');
											}
											?>><label
                                                    for="reviews_sort_time_old"><?php esc_html_e( ' Oldest first', 'woo-photo-reviews' ) ?></label>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="review_tab_first"><?php esc_html_e( 'Show review tab first', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="gdpr_policy"><?php esc_html_e( 'GDPR checkbox', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input class="gdpr_policy" type="checkbox" id="gdpr_policy"
                                           name="gdpr_policy"
                                           value="on" <?php checked( $this->settings->get_params( 'photo', 'gdpr' ), 'on' ) ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="gdpr_message"><?php esc_html_e( 'GDPR message', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
								<?php
								wp_editor( stripslashes( $this->settings->get_params( 'photo', 'gdpr_message' ) ), 'gdpr_message', array(
									'editor_height' => 300,
									'media_buttons' => true
								) );
								?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="masonry_star_color"><?php esc_html_e( 'Rating stars color', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <input type="text" class="color-picker" id="masonry_star_color"
                                       name="masonry_star_color"
                                       value="<?php echo esc_attr($this->settings->get_params( 'photo', 'star_color' )); ?>"
                                       style="background-color: <?php echo esc_attr($this->settings->get_params( 'photo', 'star_color' )); ?>;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wcpr_hide_name"><?php esc_html_e( 'Hide name', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="verified-type"><?php esc_html_e( 'Verified owner badge', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Front-end style', 'woo-photo-reviews' ) ?></th>
                            <td>
                                <div class="grouped fields">


                                    <div class="field">
                                        <div class="vi-ui toggle checkbox">
                                            <input class="kt-photo-reviews-setting" type="radio"
                                                   name="reviews_display" value="1"
                                                   id="reviews_display1" <?php checked( $this->settings->get_params( 'photo', 'display' ), '1' ) ?>><label
                                                    for="reviews_display1"><?php esc_html_e( ' Grid(masonry).', 'woo-photo-reviews' ) ?></label>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <div class="vi-ui toggle checkbox">
                                            <input class="kt-photo-reviews-setting" type="radio"
                                                   name="reviews_display" value="2"
                                                   id="reviews_display2" <?php checked( $this->settings->get_params( 'photo', 'display' ), '2' ) ?>><label
                                                    for="reviews_display2"><?php esc_html_e( ' Normal.', 'woo-photo-reviews' ) ?></label>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <tr class="masonry-options <?php echo esc_attr($this->settings->get_params( 'photo', 'display' ) == 2 ? "wcpr-hidden-items" : '') ?>">
                            <th>
                                <label for="show_review_date"><?php esc_html_e( 'Show review date', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input type="checkbox" name="show_review_date" id="show_review_date"
                                           value="1" <?php checked( $this->settings->get_params( 'photo', 'show_review_date' ), '1' ) ?>><label></label>
                                </div>
                            </td>
                        </tr>
                        <tr class="masonry-options <?php echo esc_attr($this->settings->get_params( 'photo', 'display' ) == 2 ? "wcpr-hidden-items" : '') ?>">
                            <th>
                                <label for="single_product_summary"><?php esc_html_e( 'Display product summary on masonry popup', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>
                        <tr class="masonry-options <?php echo esc_attr($this->settings->get_params( 'photo', 'display' ) == 2 ? "wcpr-hidden-items" : '') ?>">
                            <th>
                                <label for="masonry_col_num"><?php esc_html_e( 'Number of columns', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>
                        <tr class="masonry-options <?php echo esc_attr($this->settings->get_params( 'photo', 'display' ) == 2 ? "wcpr-hidden-items" : '') ?>">
                            <th>
                                <label for="masonry_grid_bg"><?php esc_html_e( 'Grid background color', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>
                        <tr class="masonry-options <?php echo esc_attr( $this->settings->get_params( 'photo', 'display' ) == 2 ? "wcpr-hidden-items" : '') ?>">
                            <th>
                                <label for="masonry_grid_item_bg"><?php esc_html_e( 'Grid item background color', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>
                        <tr class="masonry-options <?php echo esc_attr($this->settings->get_params( 'photo', 'display' ) == 2 ? "wcpr-hidden-items" : '') ?>">
                            <th>
                                <label for="masonry_comment_text_color"><?php esc_html_e( 'Review text color', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>
                        <tr class="default-options <?php echo esc_attr($this->settings->get_params( 'photo', 'display' ) == 1 ? "wcpr-hidden-items" : ''); ?>">
                            <th>
                                <label for="wcpr-pagination-ajax"><?php esc_html_e( 'Ajax pagination', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>
                        <tr class="default-options <?php echo esc_attr( $this->settings->get_params( 'photo', 'display' ) == 1 ? "wcpr-hidden-items" : '') ?>">
                            <th>
                                <label for="wcpr-reviews-container"><?php esc_html_e( 'Reviews container', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="wcpr-reviews-anchor-link"><?php esc_html_e( 'Reviews anchor link', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <input type="text" name="wcpr_reviews_anchor_link" id="wcpr-reviews-anchor-link"
                                       value="<?php echo wp_kses_post( $this->settings->get_params( 'reviews_anchor_link' ) ) ?>">
                                <p><?php esc_html_e( 'This is the anchor link to your reviews form. Enter without a hash(#). This will be linked after product links in reviews reminder or when customers click on a filter on frontend.', 'woo-photo-reviews' ); ?></p>
                            </td>
                        </tr>


                        <tr>
                            <th>
                                <label for="photo-reviews-css"><?php esc_html_e( 'Custom CSS', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                        <textarea name="photo-reviews-css"
                                                  id="photo-reviews-css"><?php echo wp_kses_post($this->settings->get_params( 'photo', 'custom_css' )); ?></textarea>
                            </td>
                        </tr>


                    </table>
                </div>
                <div class="vi-ui bottom tab segment" data-tab="rating_filter">
                    <table class="form-table">

                        <tr>
                            <th>
                                <label for="ratings_count"><?php esc_html_e( 'Ratings count', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input class="kt-photo-reviews-setting" type="checkbox" id="ratings_count"
                                           name="ratings_count"
                                           value="on" <?php checked( $this->settings->get_params( 'photo', 'rating_count' ), 'on' ) ?>><label></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="overall_rating"><?php esc_html_e( 'Overall rating', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input class="kt-photo-reviews-setting" type="checkbox" id="overall_rating"
                                           name="overall_rating"
                                           value="on" <?php checked( $this->settings->get_params( 'photo', 'overall_rating' ), 'on' ) ?>><label></label>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="rating-count-bar-color"><?php esc_html_e( 'Ratings count bar color', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <input type="text" class="color-picker" id="rating-count-bar-color"
                                       name="rating-count-bar-color"
                                       value="<?php echo esc_attr($this->settings->get_params( 'photo', 'rating_count_bar_color' )); ?>"
                                       style="background-color: <?php echo esc_attr($this->settings->get_params( 'photo', 'rating_count_bar_color' )); ?>;">
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <th>
                                <label for="filter-enable"><?php esc_html_e( 'Filters', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input class="kt-photo-reviews-setting" type="checkbox" id="filter-enable"
                                           name="filter-enable"
                                           value="on" <?php if ( 'on' == $this->settings->get_params( 'photo', 'filter' )['enable'] ) {
										echo esc_attr('checked');
									} ?>>
                                    <label></label>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="filter-area-border-color"><?php esc_html_e( 'Filter area border color', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td colspan="4">
                                <input type="text" class="color-picker" id="filter-area-border-color"
                                       name="filter-area-border-color"
                                       value="<?php echo esc_attr(isset( $this->settings->get_params( 'photo', 'filter' )['area_border_color'] ) ? $this->settings->get_params( 'photo', 'filter' )['area_border_color'] : '') ?>"
                                       style="background-color: <?php echo esc_attr(isset( $this->settings->get_params( 'photo', 'filter' )['area_border_color'] ) ? $this->settings->get_params( 'photo', 'filter' )['area_border_color'] : '') ?>;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="filter-area-bg-color"><?php esc_html_e( 'Filter area backgroud color', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td colspan="4">
                                <input name="filter-area-bg-color" id="filter-area-bg-color" type="text"
                                       class="color-picker"
                                       value="<?php echo esc_attr(isset( $this->settings->get_params( 'photo', 'filter' )['area_bg_color'] ) ? $this->settings->get_params( 'photo', 'filter' )['area_bg_color'] : '') ?>"
                                       style="background-color: <?php echo esc_attr(isset( $this->settings->get_params( 'photo', 'filter' )['area_bg_color'] ) ? $this->settings->get_params( 'photo', 'filter' )['area_bg_color'] : '') ?>;"/>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="filter-button-border-color"><?php esc_html_e( 'Filter buttons border color', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td colspan="4">
                                <input type="text" class="color-picker" id="filter-button-border-color"
                                       name="filter-button-border-color"
                                       value="<?php echo esc_attr(isset( $this->settings->get_params( 'photo', 'filter' )['button_border_color'] ) ? $this->settings->get_params( 'photo', 'filter' )['button_border_color'] : '') ?>"
                                       style="background-color: <?php echo esc_attr(isset( $this->settings->get_params( 'photo', 'filter' )['button_border_color'] ) ? $this->settings->get_params( 'photo', 'filter' )['button_border_color'] : '') ?>;">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="filter-button-color"><?php esc_html_e( 'Filter button color', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td colspan="4">
                                <input name="filter-button-color" id="filter-button-color" type="text"
                                       class="color-picker"
                                       value="<?php echo esc_attr(isset( $this->settings->get_params( 'photo', 'filter' )['button_color'] ) ? $this->settings->get_params( 'photo', 'filter' )['button_color'] : '') ?>"
                                       style="background-color: <?php echo esc_attr( isset( $this->settings->get_params( 'photo', 'filter' )['button_color'] ) ? $this->settings->get_params( 'photo', 'filter' )['button_color'] : '') ?>;"/>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="filter-button-bg-color"><?php esc_html_e( 'Filter button background color', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td colspan="4">
                                <input name="filter-button-bg-color" id="filter-button-bg-color" type="text"
                                       class="color-picker"
                                       value="<?php echo esc_attr(isset( $this->settings->get_params( 'photo', 'filter' )['button_bg_color'] ) ? $this->settings->get_params( 'photo', 'filter' )['button_bg_color'] : '') ?>"
                                       style="background-color: <?php echo esc_attr(isset( $this->settings->get_params( 'photo', 'filter' )['button_bg_color'] ) ? $this->settings->get_params( 'photo', 'filter' )['button_bg_color'] : '') ?>;"/>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="vi-ui bottom tab segment" data-tab="coupon">

                    <table class="form-table">
                        <tr>
                            <th>
                                <label for="kt_coupons_enable"><?php esc_html_e( 'Coupon for reviews', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input type="checkbox" id="kt_coupons_enable" name="kt_coupons_enable"
                                           value="on"<?php if ( 'on' == $this->settings->get_params( 'coupon', 'enable' ) ) {
										echo esc_attr('checked');
									}
									?>><label
                                            for="kt_coupons_enable"><?php esc_html_e( 'Send coupon to customers when their reviews are approved', 'woo-photo-reviews' ) ?></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="kt_coupons_if_register"><?php esc_html_e( 'Registered-account email is required', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                                <label for="kt_coupons_if_register"><?php esc_html_e( 'Only send coupons if author\'s email is registered an account', 'woo-photo-reviews' ) ?></label>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label for="kt_coupons_if_photo"><?php esc_html_e( 'Photo is required', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="kt_coupons_if_photo" type="checkbox"
                                           name="kt_coupons_if_photo"
                                           value="on"<?php checked( $this->settings->get_params( 'coupon', 'require' )['photo'], 'on' ) ?>>
                                    <label for="kt_coupons_if_photo"><?php esc_html_e( 'Only send coupons for reviews including photos', 'woo-photo-reviews' ) ?></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="kt_coupons_if_min_rating"><?php esc_html_e( 'Required rating', 'woo-photo-reviews' ) ?></label>
                                <p><?php esc_html_e( 'Only send coupons for reviews with same or higher than this rating', 'woo-photo-reviews' ) ?></p>
                            </th>
                            <td>
                                <input id="kt_coupons_if_min_rating" type="number" name="kt_coupons_if_min_rating"
                                       placeholder="0" min="0"
                                       max="5" step="1"
                                       value="<?php echo esc_attr(isset( $this->settings->get_params( 'coupon', 'require' )['min_rating'] ) ? $this->settings->get_params( 'coupon', 'require' )['min_rating'] : '') ?>"><?php esc_html_e( 'Stars', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="kt_coupons_if_verified"><?php esc_html_e( 'Verified owner is required', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="kt_coupons_if_verified" type="checkbox"
                                           name="kt_coupons_if_verified"
                                           value="on"<?php checked( $this->settings->get_params( 'coupon', 'require' )['owner'], 'on' ) ?>><label
                                            for="kt_coupons_if_verified"><?php esc_html_e( 'Only send coupon for reviews from purchased customers.', 'woo-photo-reviews' ) ?></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="review_form_description"><?php esc_html_e( 'Review form description', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <input id="review_form_description" type="text" name="review_form_description"
                                       value="<?php echo esc_attr($this->settings->get_params( 'coupon', 'form_title' )); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="kt_products_gen_coupon"><?php esc_html_e( 'Required products', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
								<?php esc_html_e( 'Only reviews on selected products can receive coupons. Leave blank to apply for all products', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="kt_excluded_products_gen_coupon"><?php esc_html_e( 'Exclude products to give coupon', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
								<?php esc_html_e( 'Reviews on these products will not receive coupon', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="kt_categories_gen_coupon"><?php esc_html_e( 'Required categories', 'woo-photo-reviews' ) ?></label>

                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                                </select><?php esc_html_e( 'Only reviews on products in these categories can receive coupon', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="kt_excluded_categories_gen_coupon"><?php esc_html_e( 'Exclude categories to give coupon', 'woo-photo-reviews' ) ?></label>

                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                                </select><?php esc_html_e( 'Reviews on products in these categories will not receive coupon', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="subject"><?php esc_html_e( 'Email subject', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <input id="subject" type="text" name="subject"
                                       value="<?php echo esc_attr( $this->settings->get_params( 'coupon', 'email' )['subject'] ); ?>">
                                <p><?php esc_html_e( 'The subject of emails sending to customers which include discount coupon code.', 'woo-photo-reviews' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="heading"><?php esc_html_e( 'Email heading', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <input id="heading" type="text" name="heading"
                                       value="<?php echo esc_attr(isset( $this->settings->get_params( 'coupon', 'email' )['heading'] ) ? stripslashes( $this->settings->get_params( 'coupon', 'email' )['heading'] ) : 'Thank You For Your Review!'); ?>">
                                <p><?php esc_html_e( 'The heading of emails sending to customers which include discount coupon code.', 'woo-photo-reviews' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="content"><?php esc_html_e( 'Email content', 'woo-photo-reviews' ) ?></label>
                                <p><?php esc_html_e( 'The content of email sending to customers to inform them the coupon code they get for leaving reviews.', 'woo-photo-reviews' ) ?></p>
                            </th>
                            <td>
								<?php
								wp_editor( stripslashes( $this->settings->get_params( 'coupon', 'email' )['content'] ), 'content', array(
									'editor_height' => 300,
									'media_buttons' => true
								) );
								?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <ul>
                                    <li><?php esc_html_e( '{customer_name} - Customer\'s name.', 'woo-photo-reviews' ) ?></li>
                                    <li><?php esc_html_e( '{coupon_code} - Discount coupon code will be sent to customer.', 'woo-photo-reviews' ) ?></li>
                                    <li><?php esc_html_e( '{date_expires} - Expiry date of the coupon.', 'woo-photo-reviews' ) ?></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="set-email-restriction"><?php esc_html_e( 'Set email restriction', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="set-email-restriction" type="checkbox"
                                           name="set_email_restriction"
                                           value="1" <?php checked( $this->settings->get_params( 'set_email_restriction' ), '1' ) ?>><label
                                            for="set-email-restriction"><?php esc_html_e( 'If enabled, coupon will be used for received emails only.', 'woo-photo-reviews' ) ?></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="border-bottom: 1px solid #F5F5F5;">
                                <label for="kt_coupons_select"><?php esc_html_e( 'Select coupon kind', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td style="border-bottom: 1px solid #F5F5F5;">
                                <select id="kt_coupons_select" name="kt_coupons_select" class="vi-ui fluid dropdown">
                                    <option value="kt_generate_coupon"<?php selected( $this->settings->get_params( 'coupon', 'coupon_select' ), 'kt_generate_coupon' ) ?>><?php esc_html_e( 'Generate unique coupon', 'woo-photo-reviews' ) ?>
                                    </option>
                                    <option value="kt_existing_coupon"<?php selected( $this->settings->get_params( 'coupon', 'coupon_select' ), 'kt_existing_coupon' ) ?>><?php esc_html_e( 'Select an existing coupon', 'woo-photo-reviews' ) ?>
                                    </option>
                                </select>
                                <p><?php esc_html_e( 'Choose to send an existing coupon or generate unique coupons.', 'woo-photo-reviews' ) ?></p>
                            </td>
                        </tr>
                        <tr class="kt-existing-coupons">
                            <th>
                                <label for="kt_existing_coupons"><?php esc_html_e( 'Select an existing coupon', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <select id="kt_existing_coupons" name="kt_existing_coupons"
                                        class="coupon-search select2-selection--single"
                                        data-placeholder="<?php esc_html_e( 'Please Fill In Your Coupon Code', 'woo-photo-reviews' ) ?>">
									<?php
									if ( '' !== $this->settings->get_params( 'coupon', 'existing_coupon' ) ) {
										printf('<option value="%s" selected>%s</option>',
											$this->settings->get_params( 'coupon', 'existing_coupon' ),
											get_post( $this->settings->get_params( 'coupon', 'existing_coupon' ) )->post_title
										);
									}
									?>
                                </select>
                            </td>
                        </tr>
                        <tr class="kt-custom-coupon">
                            <th><?php esc_html_e( 'Settings For Unique Coupon', 'woo-photo-reviews' ) ?></th>
                            <td></td>
                        </tr>
                        <tr class="kt-custom-coupon">
                            <th>
                                <label for="kt_discount_type"><?php esc_html_e( 'Discount Type', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <div>
                                    <select id="kt_discount_type" name="kt_discount_type" class="vi-ui fluid dropdown">
                                        <option value="percent" <?php selected( $coupon_generate['discount_type'], 'percent' ) ?>><?php esc_html_e( 'Percentage discount', 'woo-photo-reviews' ) ?>
                                        </option>
                                        <option value="fixed_cart" <?php selected( $coupon_generate['discount_type'], 'fixed_cart' ) ?>><?php esc_html_e( 'Fixed cart discount', 'woo-photo-reviews' ) ?>
                                        </option>
                                        <option value="fixed_product" <?php selected( $coupon_generate['discount_type'], 'fixed_product' ) ?>><?php esc_html_e( 'Fixed product discount', 'woo-photo-reviews' ) ?>
                                        </option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr class="kt-custom-coupon">
                            <th>
                                <label for="kt_coupon_amount"><?php esc_html_e( 'Coupon Amount', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <input type="number" min="0" class="short wc_input_price" step="0.01"
                                       name="kt_coupon_amount" id="kt_coupon_amount"
                                       value="<?php echo esc_attr( $coupon_generate['coupon_amount'] ); ?>" placeholder="0">
								<?php esc_html_e( 'Value of the coupon.', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr class="kt-custom-coupon">
                            <th><?php esc_html_e( 'Allow Free Shipping', 'woo-photo-reviews' ) ?></th>
                            <td>
                                <input type="checkbox"
                                       class="checkbox" <?php if ( $coupon_generate['allow_free_shipping'] == 'yes' ) {
									echo esc_attr('checked');
								} ?> name="kt_free_shipping" id="kt_free_shipping" value="yes">
                                <label for="kt_free_shipping"><?php esc_html_e( 'Check this box if the coupon grants free shipping. A ', 'woo-photo-reviews' ) ?>
                                    <a href="https://docs.woocommerce.com/document/free-shipping/"
                                       target="_blank"><?php esc_html_e( 'free shipping method', 'woo-photo-reviews' ); ?></a><?php esc_html_e( ' must be enabled in your shipping zone and be set to require "a valid free shipping coupon" (see the "Free Shipping Requires" setting).', 'woo-photo-reviews' ); ?>
                                </label>
                            </td>
                        </tr>
                        <tr class="kt-custom-coupon">
                            <th>
                                <label for="kt_expiry_date"><?php esc_html_e( 'Time To Live', 'woo-photo-reviews' ) ?></label>
                                <p><?php esc_html_e( 'Coupon will expire after x(days) since it\'s generated and sent. Set 0 or blank to make it never expire.', 'woo-photo-reviews' ) ?></p>
                            </th>
                            <td>
                                <input type="number" min="0" name="kt_expiry_date" id="kt_expiry_date"
                                       value="<?php echo esc_attr($coupon_generate['expiry_date']); ?>"><?php esc_html_e( 'Days', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr class="kt-custom-coupon">
                            <th>
                                <label for="kt_min_spend"><?php esc_html_e( 'Minimum Spend', 'woo-photo-reviews' ) ?></label>

                            </th>
                            <td>
                                <input type="text" class="short wc_input_price" name="kt_min_spend"
                                       id="kt_min_spend" value="<?php echo esc_attr($coupon_generate['min_spend']); ?>"
                                       placeholder="<?php esc_html_e( 'No minimum', 'woo-photo-reviews' ) ?>">
								<?php esc_html_e( 'The minimum spend to use the coupon.', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr class="kt-custom-coupon">
                            <th>
                                <label for="kt_max_spend"><?php esc_html_e( 'Maximum Spend', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <input type="text" class="short wc_input_price" name="kt_max_spend"
                                       id="kt_max_spend" value="<?php echo esc_attr($coupon_generate['max_spend']); ?>"
                                       placeholder="<?php esc_html_e( 'No maximum', 'woo-photo-reviews' ) ?>">
								<?php esc_html_e( 'The maximum spend to use the coupon.', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr class="kt-custom-coupon">
                            <th><?php esc_html_e( 'Individual Use Only', 'woo-photo-reviews' ) ?></th>
                            <td>
                                <input type="checkbox" <?php if ( $coupon_generate['individual_use'] == 'yes' ) {
									echo esc_attr('checked');
								} ?> class="checkbox" name="kt_individual_use" id="kt_individual_use"
                                       value="yes"><label
                                        for="kt_individual_use"><?php esc_html_e( 'Check this box if the coupon cannot be used in conjunction with other coupons.', 'woo-photo-reviews' ) ?></label>
                            </td>
                        </tr>
                        <tr class="kt-custom-coupon">
                            <th><?php esc_html_e( 'Exclude Sale Items', 'woo-photo-reviews' ) ?></th>
                            <td>
                                <input type="checkbox" <?php if ( $coupon_generate['exclude_sale_items'] == 'yes' ) {
									echo esc_attr('checked');
								} ?> class="checkbox" name="kt_exclude_sale_items" id="kt_exclude_sale_items"
                                       value="yes"><label
                                        for="kt_exclude_sale_items"><?php esc_html_e( 'Check this box if the coupon should not apply to items on sale. Per-item coupons will only work if the item is not on sale. Per-cart coupons will only work if there are items in the cart that are not on sale.', 'woo-photo-reviews' ) ?></label>
                            </td>
                        </tr>
                        <tr class="kt-custom-coupon">
                            <th>
                                <label for="kt_product_ids"><?php esc_html_e( 'Include products', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <select id="kt_product_ids" name="kt_product_ids[]" multiple="multiple"
                                        class="product-search"
                                        data-placeholder="<?php esc_html_e( 'Please Fill In Your Product Title', 'woo-photo-reviews' ) ?>">
									<?php
									$product_ids = $coupon_generate['product_ids'];
									if ( count( $product_ids ) ) {
										foreach ( $product_ids as $ps ) {
											$product = wc_get_product( $ps );
											if ( $product ) {
												?>
                                                <option selected
                                                        value="<?php echo esc_attr($ps) ?>"><?php echo wp_kses_post($product->get_title()) ?></option>
												<?php
											}
										}
									}
									?>
                                </select>
								<?php esc_html_e( 'Products that the coupon will be applied to, or that need to be in the cart in order for the "Fixed cart discount" to be applied', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr class="kt-custom-coupon">
                            <th>
                                <label for="kt_excluded_product_ids"><?php esc_html_e( 'Exclude products', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <select id="kt_excluded_product_ids" name="kt_excluded_product_ids[]"
                                        multiple="multiple"
                                        class="product-search"
                                        data-placeholder="<?php esc_html_e( 'Please Fill In Your Product Title', 'woo-photo-reviews' ) ?>">
									<?php
									$excluded_product_ids = $coupon_generate['excluded_product_ids'];
									if ( count( $excluded_product_ids ) ) {
										foreach ( $excluded_product_ids as $ps ) {
											$product = wc_get_product( $ps );
											if ( $product ) {
												?>
                                                <option selected
                                                        value="<?php echo esc_attr($ps) ?>"><?php echo wp_kses_post($product->get_title()) ?></option>
												<?php
											}
										}
									}
									?>
                                </select>
								<?php esc_html_e( 'Products that the coupon will not be applied to, or that cannot be in the cart in order for the "Fixed cart discount" to be applied.', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>

                        <tr class="kt-custom-coupon">
                            <th>
                                <label for="kt_product_categories"><?php esc_html_e( 'Included categories', 'woo-photo-reviews' ) ?></label>

                            </th>
                            <td>
                                <select id="kt_product_categories"
                                        data-placeholder="<?php esc_html_e( 'Please enter category title', 'woo-photo-reviews' ) ?>"
                                        name="kt_product_categories[]" multiple="multiple"
                                        class="category-search select2-selection--multiple">
									<?php
									$product_categories = $coupon_generate['product_categories'];
									if ( count( $product_categories ) ) {
										foreach ( $product_categories as $category_id ) {
											$category = get_term( $category_id );
											?>
                                            <option value="<?php echo esc_attr($category_id) ?>"
                                                    selected><?php echo wp_kses_post($category->name); ?></option>
											<?php
										}
									}
									?>
                                </select><?php esc_html_e( 'Product categories that the coupon will be applied to, or that need to be in the cart in order for the "Fixed cart discount" to be applied.', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>

                        <tr class="kt-custom-coupon">
                            <th>
                                <label for="kt_excluded_product_categories"><?php esc_html_e( 'Exclude categories', 'woo-photo-reviews' ) ?></label>

                            </th>
                            <td>
                                <select id="kt_excluded_product_categories"
                                        data-placeholder="<?php esc_html_e( 'Please enter category title', 'woo-photo-reviews' ) ?>"
                                        name="kt_excluded_product_categories[]" multiple="multiple"
                                        class="category-search select2-selection--multiple">
									<?php
									$excluded_categories = $coupon_generate['excluded_product_categories'];
									if ( count( $excluded_categories ) ) {
										foreach ( $excluded_categories as $category_id ) {
											$category = get_term( $category_id );
											?>
                                            <option value="<?php echo esc_attr($category_id) ?>"
                                                    selected><?php echo wp_kses_post($category->name); ?></option>
											<?php
										}
									}
									?>
                                </select><?php esc_html_e( 'Product categories that the coupon will not be applied to, or that cannot be in the cart in order for the "Fixed cart discount" to be applied.', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>

                        <tr class="kt-custom-coupon">
                            <th>
                                <label for="kt_limit_per_coupon"><?php esc_html_e( 'Usage Limit Per Coupon', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <input type="number" class="short" name="kt_limit_per_coupon"
                                       id="kt_limit_per_coupon"
                                       value="<?php if ( $coupon_generate['limit_per_coupon'] > 0 ) {
									       echo esc_attr($coupon_generate['limit_per_coupon']);
								       } ?>" placeholder="Unlimited usage" step="1" min="0">
								<?php esc_html_e( 'How many times this coupon can be used before it is void.', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr class="kt-custom-coupon">
                            <th>
                                <label for="kt_limit_to_x_items"><?php esc_html_e( 'Limit Usage To X Items', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <input type="number" class="short" name="kt_limit_to_x_items"
                                       id="kt_limit_to_x_items"
                                       value="<?php if ( $coupon_generate['limit_to_x_items'] > 0 ) {
									       echo esc_attr($coupon_generate['limit_to_x_items']);
								       } ?>"
                                       placeholder="<?php esc_html_e( 'Apply To All Qualifying Items In Cart', 'woo-photo-reviews' ) ?>"
                                       step="1" min="0">
								<?php esc_html_e( 'The maximum number of individual items this coupon can apply to when using product discount.', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr class="kt-custom-coupon">
                            <th>
                                <label for="kt_limit_per_user"><?php esc_html_e( 'Usage Limit Per User', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <input type="number" class="short" name="kt_limit_per_user"
                                       id="kt_limit_per_user"
                                       value="<?php if ( $coupon_generate['limit_per_user'] > 0 ) {
									       echo esc_attr($coupon_generate['limit_per_user']);
								       } ?>"
                                       placeholder="<?php esc_html_e( 'Unlimited Usage', 'woo-photo-reviews' ) ?>"
                                       step="1" min="0">
								<?php esc_html_e( 'How many times this coupon can be used by an individual user.', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr class="kt-custom-coupon">
                            <th>
                                <label for="kt_coupon_code_prefix"><?php esc_html_e( 'Coupon Code Prefix', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>
                    </table>

                </div>
                <div class="vi-ui bottom tab segment" data-tab="email">

                    <table class="form-table">
                        <tr>
                            <th>
                                <label for="follow_up_email_enable"><?php esc_html_e( 'Review reminder', 'woo-photo-reviews' ) ?></label>
                            </th>

                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input type="checkbox" id="follow_up_email_enable"
                                           name="follow_up_email_enable"
                                           value="on" <?php checked( $this->settings->get_params( 'followup_email', 'enable' ), 'on' ) ?>>
                                    <label for="follow_up_email_enable"><?php esc_html_e( 'If checked, an email will be automatically sent when a customer completes an order to request for a review.', 'woo-photo-reviews' ) ?></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="follow-up-email-products-restriction"><?php esc_html_e( 'Exclude products', 'woo-photo-reviews' ) ?></label>

                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
								<?php esc_html_e( 'These products will not appear in review reminder email.', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="follow-up-email-excluded-categories"><?php esc_html_e( 'Exclude categories', 'woo-photo-reviews' ) ?></label>

                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
								<?php esc_html_e( 'Products in these categories will not appear in review reminder email.', 'woo-photo-reviews' ) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="exclude_non_coupon_products"><?php esc_html_e( 'Exclude non-coupon given products', 'woo-photo-reviews' ) ?></label>
                            </th>

                            <td>

                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                                <label for="exclude_non_coupon_products"><?php esc_html_e( 'Enable this if you mean to offer coupon for reviews in review reminder.', 'woo-photo-reviews' ) ?></label>

                            </td>
                        </tr>
                        <tr class="follow-up-email">
                            <th>
                                <label for="email_time_amount"><?php esc_html_e( 'Schedule time', 'woo-photo-reviews' ) ?></label>
                                <p><?php esc_html_e( 'Schedule a time to send request email after an order is marked as completed.', 'woo-photo-reviews' ) ?></p>
                            </th>
                            <td>
                                <div class="equal width fields">
                                    <div class="field">
                                        <input class="email-time" id="email_time_amount"
                                               name="email_time_amount" type="number" min="1"
                                               value="<?php _e( $this->settings->get_params( 'followup_email', 'amount' ), 'woo-photo-reviews' ); ?>">
                                    </div>
                                    <div class="field">
                                        <select class="email-time vi-ui dropdown" id="email_time_unit"
                                                name="email_time_unit">
                                            <option value="s" <?php if ( 's' == $this->settings->get_params( 'followup_email', 'unit' ) ) {
												echo esc_html('selected');
											} ?>><?php esc_html_e( 'Seconds', 'woo-photo-reviews' ) ?>
                                            </option>
                                            <option value="m" <?php if ( 'm' == $this->settings->get_params( 'followup_email', 'unit' ) ) {
												echo esc_html('selected');
											} ?>><?php esc_html_e( 'Minutes', 'woo-photo-reviews' ) ?>
                                            </option>
                                            <option value="h" <?php if ( 'h' == $this->settings->get_params( 'followup_email', 'unit' ) ) {
												echo esc_html('selected');
											} ?>><?php esc_html_e( 'Hours', 'woo-photo-reviews' ) ?>
                                            </option>
                                            <option value="d" <?php if ( 'd' == $this->settings->get_params( 'followup_email', 'unit' ) ) {
												echo esc_html('selected');
											} ?>><?php esc_html_e( 'Days', 'woo-photo-reviews' ) ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="follow-up-email">
                            <th>
                                <label for="follow_up_email_subject"><?php esc_html_e( 'Email subject', 'woo-photo-reviews' ) ?></label>

                            </th>
                            <td>
                                <input id="follow_up_email_subject" type="text" name="follow_up_email_subject"
                                       value="<?php echo esc_attr( $this->settings->get_params( 'followup_email', 'subject' ) ); ?>">
                                <p><?php esc_html_e( 'The subject of emails sending to customers to request for reviews.', 'woo-photo-reviews' ) ?></p>
                            </td>
                        </tr>
                        <tr class="follow-up-email">
                            <th>
                                <label for="follow_up_email_heading"><?php esc_html_e( 'Email heading', 'woo-photo-reviews' ) ?></label>
                            </th>
                            <td>
                                <input id="follow_up_email_heading" type="text" name="follow_up_email_heading"
                                       value="<?php echo esc_attr( $this->settings->get_params( 'followup_email', 'heading' ) ); ?>">
                                <p><?php esc_html_e( 'The heading of emails sending to customers to request for reviews.', 'woo-photo-reviews' ) ?></p>
                            </td>
                        </tr>
                        <tr class="follow-up-email">
                            <th>
                                <label for="follow_up_email_content"><?php esc_html_e( 'Email content', 'woo-photo-reviews' ) ?></label>
                                <p><?php esc_html_e( 'The content of email sending to customers to ask for reviews.', 'woo-photo-reviews' ) ?></p>
                            </th>
                            <td>
								<?php
								wp_editor( stripslashes( $this->settings->get_params( 'followup_email', 'content' ) ), 'follow_up_email_content', array(
									'editor_height' => 300,
									'media_buttons' => true
								) );
								?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <ul>
                                    <li><?php esc_html_e( '{customer_name} - Customer\'s name.', 'woo-photo-reviews' ) ?></li>
                                    <li><?php esc_html_e( '{order_id} - Order id.', 'woo-photo-reviews' ) ?></li>
                                    <li><?php esc_html_e( '{site_title} - Your site title.', 'woo-photo-reviews' ) ?></li>
                                    <li><?php esc_html_e( '{date_create} - Order\'s created date.', 'woo-photo-reviews' ) ?></li>
                                    <li><?php esc_html_e( '{date_complete} - Order\'s completed date.', 'woo-photo-reviews' ) ?></li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="button-review-now-color"><?php esc_html_e( 'Button "Review now" text color', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="button-review-now-bg-color"><?php esc_html_e( 'Button "Review now" background color', 'woo-photo-reviews' ); ?></label>
                            </th>
                            <td>
                                <a class="vi-ui button" target="_blank"
                                   href="https://1.envato.market/L3WrM"><?php esc_html_e( 'Upgrade This Feature', 'woo-photo-reviews' ) ?></a>
                            </td>
                        </tr>

                    </table>


                </div>

                <p><input type="submit" class="vi-ui primary button" name="submit"
                          value="<?php esc_html_e( 'Save', 'woo-photo-reviews' ) ?>">
                </p>
            </form>
        </div>
		<?php
		do_action( 'villatheme_support_woo-photo-reviews' );
	}

	public function save_settings() {
		global $pagenow;
		$page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash($_REQUEST['page'] ))  : '';
		if ( $pagenow != 'admin.php' || $page != 'woo-photo-reviews' ) {
			return;
		}

		global $woo_photo_reviews_settings;
		if ( get_option( 'woocommerce_enable_reviews' ) == 'no' ) {
			?>
            <div class="error">
                <p><?php esc_html_e( 'You have to enable WooCommerce product reviews on WooCommerce settings page to use Photo Reviews for WooCommerce and its features!', 'woo-photo-reviews' ) ?></p>
            </div>
			<?php
		}
		if ( get_option( 'woocommerce_enable_coupons' ) == 'no' ) {
			?>
            <div class="error">
                <p><?php esc_html_e( 'You have to enable the use of coupon on WooCommerce settings page to use Coupon feature!', 'woo-photo-reviews' ) ?></p>
            </div>
			<?php
		}

		if ( ! empty( $_REQUEST['submit'] ) ) {
			if ( sanitize_text_field($_POST['kt_coupons_select']) == 'kt_existing_coupon' && ! isset( $_POST['kt_existing_coupons'] ) ) {
				?>
                <div class="error">
                    <p><?php esc_html_e( 'Please select a coupon then save settings!', 'woo-photo-reviews' ) ?></p>
                </div>
				<?php
				return;
			}
		}
		if ( empty( $_POST['wcpr_nonce_field'] ) || ! wp_verify_nonce( wp_unslash( sanitize_text_field( $_POST['wcpr_nonce_field'] ) ), 'wcpr_settings_page_save' ) ) {
			return;
		}

		$args = array(
			'enable'                => isset( $_POST['wcpr-enable'] ) ? sanitize_text_field( $_POST['wcpr-enable'] ) : 'off',
			'mobile'                => isset( $_POST['wcpr-mobile'] ) ? sanitize_text_field( $_POST['wcpr-mobile'] ) : 'off',
			'key'                   => isset( $_POST['wcpr-key'] ) ? sanitize_text_field( $_POST['wcpr-key'] ) : '',
			'photo'                 => array(
				'enable'                 => isset( $_POST['photo_reviews_options'] ) ? sanitize_text_field( $_POST['photo_reviews_options'] ) : "off",
				'maxsize'                => isset( $_POST['image_maxsize'] ) ? absint( sanitize_text_field( $_POST['image_maxsize'] ) ) : "",
				'required'               => isset( $_POST['photo_reviews_required'] ) ? sanitize_text_field( $_POST['photo_reviews_required'] ) : "off",
				'display'                => isset( $_POST['reviews_display'] ) ? sanitize_text_field( $_POST['reviews_display'] ) : 2,
				'sort'                   => array(
					'time' => isset( $_POST['reviews_sort_time'] ) ? sanitize_text_field( $_POST['reviews_sort_time'] ) : 1
				),
				'star_color'                 => isset( $_POST['masonry_star_color'] ) ? sanitize_text_field( $_POST['masonry_star_color'] ) : '',
				'rating_count'           => isset( $_POST['ratings_count'] ) ? sanitize_text_field( $_POST['ratings_count'] ) : "off",
				'rating_count_bar_color' => isset( $_POST['rating-count-bar-color'] ) ? sanitize_text_field( $_POST['rating-count-bar-color'] ) : '',
				'filter'                 => array(
					'enable'              => isset( $_POST['filter-enable'] ) ? sanitize_text_field( $_POST['filter-enable'] ) : "off",
					'area_border_color'   => isset( $_POST['filter-area-border-color'] ) ? sanitize_text_field( $_POST['filter-area-border-color'] ) : '',
					'area_bg_color'       => isset( $_POST['filter-area-bg-color'] ) ? sanitize_text_field( $_POST['filter-area-bg-color'] ) : '',
					'button_border_color' => isset( $_POST['filter-button-border-color'] ) ? sanitize_text_field( $_POST['filter-button-border-color'] ) : '',
					'button_color'        => isset( $_POST['filter-button-color'] ) ? sanitize_text_field( $_POST['filter-button-color'] ) : '',
					'button_bg_color'     => isset( $_POST['filter-button-bg-color'] ) ? sanitize_text_field( $_POST['filter-button-bg-color'] ) : '',

				),
				'custom_css'             => isset( $_POST['photo-reviews-css'] ) ? sanitize_textarea_field( wp_unslash( $_POST['photo-reviews-css'] ) ) : "",
				'gdpr'                   => isset( $_POST['gdpr_policy'] ) ? sanitize_textarea_field( $_POST['gdpr_policy'] ) : "off",
				'gdpr_message'           => isset( $_POST['gdpr_message'] ) ? wp_kses_post( wp_unslash( $_POST['gdpr_message'] ) ) : "",
				'overall_rating'         => isset( $_POST['overall_rating'] ) ? sanitize_text_field( $_POST['overall_rating'] ) : "off",
				'show_review_date'       => isset( $_POST['show_review_date'] ) ? sanitize_text_field( $_POST['show_review_date'] ) : "",
			),
			'coupon'                => array(
				'enable'          => isset( $_POST['kt_coupons_enable'] ) ? sanitize_text_field( $_POST['kt_coupons_enable'] ) : "off",
				'require'         => array(
					'photo'      => isset( $_POST['kt_coupons_if_photo'] ) ? sanitize_text_field( $_POST['kt_coupons_if_photo'] ) : "off",
					'min_rating' => isset( $_POST['kt_coupons_if_min_rating'] ) ? absint( sanitize_text_field( $_POST['kt_coupons_if_min_rating'] ) ) : 0,
					'owner'      => isset( $_POST['kt_coupons_if_verified'] ) ? sanitize_text_field( $_POST['kt_coupons_if_verified'] ) : "off",
				),
				'form_title'      => isset( $_POST['review_form_description'] ) ? sanitize_text_field( $_POST['review_form_description'] ) : "",
				'email'           => array(
					'subject' => isset( $_POST['subject'] ) ? sanitize_text_field( $_POST['subject'] ) : "",
					'heading' => isset( $_POST['heading'] ) ? sanitize_text_field( $_POST['heading'] ) : "",
					'content' => isset( $_POST['content'] ) ? wp_kses_post( wp_unslash($_POST['content']) ) : ""
				),
				'coupon_select'   => isset( $_POST['kt_coupons_select'] ) ? sanitize_text_field( $_POST['kt_coupons_select'] ) : 'kt_generate_coupon',
				'unique_coupon'   => array(
					'discount_type'               => isset( $_POST['kt_discount_type'] ) ? sanitize_text_field( $_POST['kt_discount_type'] ) : "",
					'coupon_amount'               => isset( $_POST['kt_coupon_amount'] ) ? sanitize_text_field( $_POST['kt_coupon_amount'] ) : 0,
					'allow_free_shipping'         => isset( $_POST['kt_free_shipping'] ) ? sanitize_text_field( $_POST['kt_free_shipping'] ) : 'no',
					'expiry_date'                 => isset( $_POST['kt_expiry_date'] ) ? sanitize_text_field( $_POST['kt_expiry_date'] ) : '',
					'min_spend'                   => isset( $_POST['kt_min_spend'] ) ? wc_format_decimal( sanitize_text_field( $_POST['kt_min_spend'] ) ) : "",
					'max_spend'                   => isset( $_POST['kt_max_spend'] ) ? wc_format_decimal( sanitize_text_field( $_POST['kt_max_spend'] ) ) : "",
					'individual_use'              => isset( $_POST['kt_individual_use'] ) ? sanitize_text_field( $_POST['kt_individual_use'] ) : "no",
					'exclude_sale_items'          => isset( $_POST['kt_exclude_sale_items'] ) ? sanitize_text_field( $_POST['kt_exclude_sale_items'] ) : "no",
					'limit_per_coupon'            => isset( $_POST['kt_limit_per_coupon'] ) ? absint(sanitize_text_field( $_POST['kt_limit_per_coupon'] )) : "",
					'limit_to_x_items'            => isset( $_POST['kt_limit_to_x_items'] ) ? absint( sanitize_text_field($_POST['kt_limit_to_x_items']) ) : "",
					'limit_per_user'              => isset( $_POST['kt_limit_per_user'] ) ? absint( sanitize_text_field($_POST['kt_limit_per_user'] )) : "",
					'product_ids'                 => isset( $_POST['kt_product_ids'] ) ? wc_clean( $_POST['kt_product_ids'] ) : array(),
					'excluded_product_ids'        => isset( $_POST['kt_excluded_product_ids'] ) ? wc_clean( $_POST['kt_excluded_product_ids'] ) : array(),
					'product_categories'          => isset( $_POST['kt_product_categories'] ) ? wc_clean( $_POST['kt_product_categories'] ) : array(),
					'excluded_product_categories' => isset( $_POST['kt_excluded_product_categories'] ) ? wc_clean( $_POST['kt_excluded_product_categories'] ) : array(),
					'coupon_code_prefix'          => isset( $_POST['kt_coupon_code_prefix'] ) ? sanitize_text_field( $_POST['kt_coupon_code_prefix'] ) : ""
				),
				'existing_coupon' => isset( $_POST['kt_existing_coupons'] ) ? sanitize_text_field( $_POST['kt_existing_coupons'] ) : ""
			),
			'followup_email'        => array(
				'enable'  => isset( $_POST['follow_up_email_enable'] ) ? sanitize_text_field( $_POST['follow_up_email_enable'] ) : "off",
				'subject' => isset( $_POST['follow_up_email_subject'] ) ? sanitize_text_field( $_POST['follow_up_email_subject'] ) : "",
				'content' => isset( $_POST['follow_up_email_content'] ) ? wp_kses_post( wp_unslash($_POST['follow_up_email_content']) ) : "",
				'heading' => isset( $_POST['follow_up_email_heading'] ) ? sanitize_text_field( $_POST['follow_up_email_heading'] ) : "",
				'amount'  => isset( $_POST['email_time_amount'] ) ? sanitize_text_field( $_POST['email_time_amount'] ) : "",
				'unit'    => isset( $_POST['email_time_unit'] ) ? sanitize_text_field( $_POST['email_time_unit'] ) : "",
			),
			'reviews_anchor_link'   => isset( $_POST['wcpr_reviews_anchor_link'] ) ? sanitize_text_field( $_POST['wcpr_reviews_anchor_link'] ) : "",
			'set_email_restriction' => isset( $_POST['set_email_restriction'] ) ? sanitize_text_field( $_POST['set_email_restriction'] ) : "",
		);

		update_option( '_wcpr_nkt_setting', $args );
		$woo_photo_reviews_settings = $args;
		?>
        <div class="updated">
            <p><?php esc_html_e( 'Your settings have been saved!', 'woo-photo-reviews' ) ?></p>
        </div>
		<?php

	}

	public function wcpr_add_meta_box() {
		add_meta_box(
			'wcpr-comment-photos', esc_html__( 'Photo', 'woo-photo-reviews'  ), array(
			$this,
			'add_meta_box_photo_callback'
		), 'comment', 'normal', 'high'
		);
	}

	public function save_comment_meta( $comment_id ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$screen = get_current_screen();
		if ( $screen->id == 'comment' ) {
			if ( !empty($_POST['photo-reviews-id']) ) {
				update_comment_meta( $comment_id, 'reviews-images', wc_clean($_POST['photo-reviews-id'] ));
			} elseif ( get_comment_meta( $comment_id, 'reviews-images', true ) ) {
				delete_comment_meta( $comment_id, 'reviews-images' );
			}
		}
	}

	public function add_meta_box_photo_callback( $comment ) {
		wp_nonce_field( 'wcpr_edit_comment_save', 'wcpr_edit_comment_nonce_field' );
		printf( '<div class="kt-wc-reviews-images-wrap-wrap">');
		if ( get_comment_meta( $comment->comment_ID, 'reviews-images' ) ) {
			$image_post_ids = get_comment_meta( $comment->comment_ID, 'reviews-images', true );
			foreach ( $image_post_ids as $image_post_id ) {
				if ( ! wc_is_valid_url( $image_post_id ) ) {
					$image_data = wp_get_attachment_metadata( $image_post_id );
					?>
                    <div class="wcpr-review-image-container">
                        <a href="<?php echo esc_url( isset( $image_data['sizes']['wcpr-photo-reviews'] ) ? wp_get_attachment_image_url( $image_post_id, 'wcpr-photo-reviews' ) : ( isset( $image_data['sizes']['medium_large'] ) ? wp_get_attachment_image_url( $image_post_id, 'medium_large' ) : ( isset( $image_data['sizes']['medium'] ) ? wp_get_attachment_image_url( $image_post_id, 'medium' ) : wp_get_attachment_thumb_url( $image_post_id ) ) ) ); ?>"
                           data-lightbox="photo-reviews-<?php echo esc_attr($comment->comment_ID); ?>"
                           data-img_post_id="<?php echo esc_attr($image_post_id); ?>"><img style="border: 1px solid;"
                                                                                 class="review-images"
                                                                                 src="<?php echo esc_url(wp_get_attachment_thumb_url( $image_post_id )); ?>"/></a>
                        <input class="photo-reviews-id" name="photo-reviews-id[]" type="hidden"
                               value="<?php echo esc_attr( $image_post_id ); ?>"/>
                        <a class="wcpr-remove-image" href="#">
							<?php _e( 'Remove' ) ?>
                        </a>
                    </div>
					<?php
				} else {
					?>
                    <div class="wcpr-review-image-container">
                        <a href="<?php echo esc_attr($image_post_id); ?>"
                           data-lightbox="photo-reviews-<?php echo esc_attr($comment->comment_ID); ?>"
                           data-img_post_id="<?php echo esc_attr($image_post_id); ?>"><img style="border: 1px solid;"
                                                                                 class="review-images"
                                                                                 src="<?php echo esc_url( $image_post_id ); ?>"/></a>
                        <input class="photo-reviews-id" name="photo-reviews-id[]" type="hidden"
                               value="<?php echo esc_attr( $image_post_id ); ?>"/>
                        <a class="wcpr-remove-image" href="#">
							<?php _e( 'Remove' ) ?>
                        </a>
                    </div>
					<?php
				}
			}
		}
		?>
        <div id="wcpr-new-image" style="float: left;">
        </div>
        <a href="#"
           class="button-primary wcpr-upload-custom-img"><?php esc_html_e( 'Add Image', 'woo-photo-reviews' ); ?></a>
		<?php
		printf( '</div>');
	}

	public function load_photos_in_comment_list() {
		$screen = get_current_screen();
		add_filter( "manage_{$screen->id}_columns", array( $this, 'add_columns' ) );
	}

	public function add_columns( $cols ) {
		$cols['wcpr_photos'] = esc_html__( 'Photos', 'woo-photo-reviews' );
		if ( ! woocommerce_version_check( '6.7' ) ) {
			$cols['wcpr_rating'] = esc_html__( 'Rating', 'woo-photo-reviews' );
		}

		return $cols;
	}

	public function product_reviews_table_column_callback_wcpr_photos( $item ) {
		$this->column_callback( 'wcpr_photos', $item->comment_ID );
	}
	public function column_callback( $col, $comment_id ) {
		switch ( $col ) {
			case 'wcpr_photos':
				if ( ( $image_post_ids = get_comment_meta( $comment_id, 'reviews-images', true ) ) && sizeof( $image_post_ids ) ) {
					printf( '<div class="kt-wc-reviews-images-wrap-wrap">');
					foreach ( $image_post_ids as $image_post_id ) {
						if ( ! wc_is_valid_url( $image_post_id ) ) {
							$image_data = wp_get_attachment_metadata( $image_post_id );
							?>
                            <a href="<?php echo esc_url( isset( $image_data['sizes']['wcpr-photo-reviews'] ) ? wp_get_attachment_image_url( $image_post_id, 'wcpr-photo-reviews' ) : ( isset( $image_data['sizes']['medium_large'] ) ? wp_get_attachment_image_url( $image_post_id, 'medium_large' ) : ( isset( $image_data['sizes']['medium'] ) ? wp_get_attachment_image_url( $image_post_id, 'medium' ) : wp_get_attachment_thumb_url( $image_post_id ) ) ) ); ?>"
                               data-lightbox="photo-reviews-<?php echo esc_attr($comment_id); ?>"><img
                                        style="border: 1px solid;"
                                        class="review-images"
                                        src="<?php echo esc_url(wp_get_attachment_thumb_url( $image_post_id )); ?>"/></a>
							<?php
						} else {
							?>
                            <a href="<?php echo esc_url($image_post_id); ?>"
                               data-lightbox="photo-reviews-<?php echo esc_attr($comment_id); ?>"><img
                                        style="border: 1px solid;"
                                        class="review-images"
                                        src="<?php echo esc_url($image_post_id); ?>"/></a>

							<?php
						}
					}
					printf( '</div>');
				}
				break;
			case 'wcpr_rating':
				$rating = get_comment_meta( $comment_id, 'rating', true );
				if ( $rating > 0 ) {
					echo wp_kses(wc_get_rating_html( $rating ), VI_WOO_PHOTO_REVIEWS_DATA::extend_post_allowed_html());
				}
				break;
		}
	}

	public function add_menu() {
		add_menu_page(
			esc_html__( 'Photo Reviews for WooCommerce', 'woo-photo-reviews' ), esc_html__( 'Photo Reviews', 'woo-photo-reviews' ), 'manage_options', 'woo-photo-reviews', array(
			$this,
			'settings_page'
		), 'dashicons-star-filled', 2
		);

		add_submenu_page(
			'woo-photo-reviews', esc_html__( 'Status', 'woo-photo-reviews' ), esc_html__( 'System Status', 'woo-photo-reviews' ), 'manage_options', 'kt-wcpr-status', array(
				$this,
				'status'
			)
		);
	}


	public function admin_enqueue() {
		$page = isset( $_REQUEST['page'] ) ? sanitize_text_field($_REQUEST['page']) : '';
		if ( in_array( $page, array( 'woo-photo-reviews', 'kt-wcpr-status', 'kt-wcpr-add-review' ) ) ) {
			global $wp_scripts;
			$scripts = $wp_scripts->registered;
			if ( isset( $wp_scripts->registered['jquery-ui-accordion'] ) ) {
				unset( $wp_scripts->registered['jquery-ui-accordion'] );
				wp_dequeue_script( 'jquery-ui-accordion' );
			}
			if ( isset( $wp_scripts->registered['accordion'] ) ) {
				unset( $wp_scripts->registered['accordion'] );
				wp_dequeue_script( 'accordion' );
			}
			foreach ( $scripts as $k => $script ) {
				preg_match( '/select2/i', $k, $result );
				if ( count( array_filter( $result ) ) ) {
					unset( $wp_scripts->registered[ $k ] );
					wp_dequeue_script( $script->handle );
				}
				preg_match( '/bootstrap/i', $k, $result );
				if ( count( array_filter( $result ) ) ) {
					unset( $wp_scripts->registered[ $k ] );
					wp_dequeue_script( $script->handle );
				}
			}
			wp_enqueue_script( 'wcpr-semantic-js-form', VI_WOO_PHOTO_REVIEWS_JS . 'form.min.js', array( 'jquery' ) );
			wp_enqueue_style( 'wcpr-semantic-css-form', VI_WOO_PHOTO_REVIEWS_CSS . 'form.min.css' );
			wp_enqueue_script( 'wcpr-semantic-js-checkbox', VI_WOO_PHOTO_REVIEWS_JS . 'checkbox.min.js', array( 'jquery' ) );
			wp_enqueue_style( 'wcpr-semantic-css-checkbox', VI_WOO_PHOTO_REVIEWS_CSS . 'checkbox.min.css' );
			wp_enqueue_script( 'wcpr-semantic-js-tab', VI_WOO_PHOTO_REVIEWS_JS . 'tab.js', array( 'jquery' ) );
			wp_enqueue_style( 'wcpr-semantic-css-tab', VI_WOO_PHOTO_REVIEWS_CSS . 'tab.min.css' );
			wp_enqueue_style( 'wcpr-semantic-css-input', VI_WOO_PHOTO_REVIEWS_CSS . 'input.min.css' );
			wp_enqueue_style( 'wcpr-semantic-css-table', VI_WOO_PHOTO_REVIEWS_CSS . 'table.min.css' );
			wp_enqueue_style( 'wcpr-semantic-css-segment', VI_WOO_PHOTO_REVIEWS_CSS . 'segment.min.css' );
			wp_enqueue_style( 'wcpr-semantic-css-label', VI_WOO_PHOTO_REVIEWS_CSS . 'label.min.css' );
			wp_enqueue_style( 'wcpr-semantic-css-menu', VI_WOO_PHOTO_REVIEWS_CSS . 'menu.min.css' );
			wp_enqueue_style( 'wcpr-semantic-css-button', VI_WOO_PHOTO_REVIEWS_CSS . 'button.min.css' );
			wp_enqueue_style( 'wcpr-semantic-css-dropdown', VI_WOO_PHOTO_REVIEWS_CSS . 'dropdown.min.css' );
			wp_enqueue_style( 'wcpr-transition-css', VI_WOO_PHOTO_REVIEWS_CSS . 'transition.min.css' );
			wp_enqueue_style( 'wcpr-semantic-message-css', VI_WOO_PHOTO_REVIEWS_CSS . 'message.min.css' );
			wp_enqueue_style( 'wcpr-semantic-icon-css', VI_WOO_PHOTO_REVIEWS_CSS . 'icon.min.css' );

			wp_enqueue_script( 'wcpr-jquery-address', VI_WOO_PHOTO_REVIEWS_JS . 'jquery.address-1.6.min.js', array( 'jquery' ), VI_WOO_PHOTO_REVIEWS_VERSION );
			wp_enqueue_script( 'wcpr-semantic-dropdown-js', VI_WOO_PHOTO_REVIEWS_JS . 'dropdown.js', array( 'jquery' ), VI_WOO_PHOTO_REVIEWS_VERSION );
			wp_enqueue_script( 'wcpr-transition', VI_WOO_PHOTO_REVIEWS_JS . 'transition.min.js', array( 'jquery' ), VI_WOO_PHOTO_REVIEWS_VERSION );
			wp_enqueue_style( 'wcpr-verified-badge-icon', VI_WOO_PHOTO_REVIEWS_CSS . 'woocommerce-photo-reviews-badge.css', array(), VI_WOO_PHOTO_REVIEWS_VERSION );
			wp_enqueue_script( 'wcpr_admin_select2_script', VI_WOO_PHOTO_REVIEWS_JS . 'select2.js', array( 'jquery' ) );
			wp_enqueue_style( 'wcpr_admin_seletct2', VI_WOO_PHOTO_REVIEWS_CSS . 'select2.min.css' );
			/*Color picker*/
			wp_enqueue_script(
				'iris', admin_url( 'js/iris.min.js' ), array(
				'jquery-ui-draggable',
				'jquery-ui-slider',
				'jquery-touch-punch'
			), false, 1
			);
			if ( $page == 'woo-photo-reviews' ) {
				wp_enqueue_script( 'wcpr_admin_script', VI_WOO_PHOTO_REVIEWS_JS . 'admin-javascript.js', array( 'jquery' ), VI_WOO_PHOTO_REVIEWS_VERSION );
				wp_localize_script( 'wcpr_admin_script', 'woo_photo_reviews_params_admin',
					array(
						'url'              => admin_url( 'admin-ajax.php' ),
						'text_please_wait' => esc_html__( 'Please wait...', 'woo-photo-reviews'  )
					)
				);
				wp_enqueue_style( 'wcpr_admin_style', VI_WOO_PHOTO_REVIEWS_CSS . 'admin-css.css', array(), VI_WOO_PHOTO_REVIEWS_VERSION );
			}
		}
		$screen = get_current_screen();
		switch ( $screen->id ) {
			case 'comment':
				wp_enqueue_style( 'wcpr_admin_comment', VI_WOO_PHOTO_REVIEWS_CSS . 'comment_screen.css', array(), VI_WOO_PHOTO_REVIEWS_VERSION );
				wp_enqueue_script( 'wcpr-lightbox-js', VI_WOO_PHOTO_REVIEWS_JS . 'lightbox.js', array( 'jquery' ) );
				wp_enqueue_style( 'wcpr-lightbox-css', VI_WOO_PHOTO_REVIEWS_CSS . 'lightbox.css' );

				wp_enqueue_script( 'media-upload' );
				if ( ! did_action( 'wp_enqueue_media' ) ) {
					wp_enqueue_media();
				}
				wp_enqueue_script( 'wcpr_admin_comment_js', VI_WOO_PHOTO_REVIEWS_JS . 'comment_screen.js', array( 'jquery' ), VI_WOO_PHOTO_REVIEWS_VERSION );
                break;
			case 'edit-comments':
				wp_enqueue_script( 'wcpr_admin_select2_script', VI_WOO_PHOTO_REVIEWS_JS . 'select2.js', array( 'jquery' ) );
				wp_enqueue_style( 'wcpr_admin_seletct2', VI_WOO_PHOTO_REVIEWS_CSS . 'select2.min.css' );
				wp_enqueue_style( 'wcpr_admin_edit-comments', VI_WOO_PHOTO_REVIEWS_CSS . 'edit-comments.css', array(), VI_WOO_PHOTO_REVIEWS_VERSION );
				wp_enqueue_script( 'wcpr-lightbox-js', VI_WOO_PHOTO_REVIEWS_JS . 'lightbox.js', array( 'jquery' ) );
				wp_enqueue_style( 'wcpr-lightbox-css', VI_WOO_PHOTO_REVIEWS_CSS . 'lightbox.css' );
				wp_enqueue_script( 'wcpr-edit-comments-js', VI_WOO_PHOTO_REVIEWS_JS . 'edit-comments.js', array( 'jquery' ) );
                break;
			case 'product_page_product-reviews':
				wp_enqueue_style( 'wcpr_admin_edit-comments', VI_WOO_PHOTO_REVIEWS_CSS . 'edit-comments.css', array(), VI_WOO_PHOTO_REVIEWS_VERSION );
				wp_enqueue_script( 'wcpr-lightbox-js', VI_WOO_PHOTO_REVIEWS_JS . 'lightbox.js', array( 'jquery' ) );
				wp_enqueue_style( 'wcpr-lightbox-css', VI_WOO_PHOTO_REVIEWS_CSS . 'lightbox.css' );
				wp_enqueue_script( 'wcpr-edit-comments-js', VI_WOO_PHOTO_REVIEWS_JS . 'edit-comments.js', array( 'jquery' ) );
                break;
		}
	}

	public function search_cate() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		ob_start();

		$keyword = filter_input( INPUT_GET, 'keyword', FILTER_SANITIZE_STRING );
		if ( ! $keyword ) {
			$keyword = filter_input( INPUT_POST, 'keyword', FILTER_SANITIZE_STRING );
		}
		if ( empty( $keyword ) ) {
			die();
		}
		$categories = get_terms(
			array(
				'taxonomy' => 'product_cat',
				'orderby'  => 'name',
				'order'    => 'ASC',
				'search'   => $keyword,
				'number'   => 100
			)
		);
		$items      = array();
		if ( count( $categories ) ) {
			foreach ( $categories as $category ) {
				$item    = array(
					'id'   => $category->term_id,
					'text' => $category->name
				);
				$items[] = $item;
			}
		}
		wp_send_json( $items );
	}

	public function search_parent_product() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		ob_start();
		$keyword = filter_input( INPUT_GET, 'keyword', FILTER_SANITIZE_STRING );
		if ( empty( $keyword ) ) {
			die();
		}
		$arg            = array(
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'posts_per_page' => 50,
			's'              => $keyword
		);
		$the_query      = new WP_Query( $arg );
		$found_products = array();
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$prd = wc_get_product( get_the_ID() );
				if ( $prd->is_type( 'variation' ) ) {
					continue;
				}
				$product          = array( 'id' => get_the_ID(), 'text' => get_the_title() );
				$found_products[] = $product;

			}
		}
		wp_send_json( $found_products );
	}

	public function search_product() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		ob_start();
		$keyword = filter_input( INPUT_GET, 'keyword', FILTER_SANITIZE_STRING );
		if ( empty( $keyword ) ) {
			die();
		}
		$arg            = array(
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'posts_per_page' => 50,
			's'              => $keyword
		);
		$the_query      = new WP_Query( $arg );
		$found_products = array();
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$prd = wc_get_product( get_the_ID() );
				if ( $prd->has_child() && $prd->is_type( 'variable' ) ) {
					$product_children = $prd->get_children();
					if ( count( $product_children ) ) {
						foreach ( $product_children as $product_child ) {
							if ( woocommerce_version_check() ) {
								$product = array(
									'id'   => $product_child,
									'text' => get_the_title( $product_child )
								);
							} else {
								$child_wc  = wc_get_product( $product_child );
								$get_atts  = $child_wc->get_variation_attributes();
								$attr_name = array_values( $get_atts )[0];
								$product   = array(
									'id'   => $product_child,
									'text' => get_the_title() . ' - ' . $attr_name
								);
							}
							$found_products[] = $product;
						}
					}
				} else {
					$product          = array( 'id' => get_the_ID(), 'text' => get_the_title() );
					$found_products[] = $product;
				}
			}
		}
		wp_send_json( $found_products );
	}

	public function search_coupon() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		ob_start();
		$keyword = filter_input( INPUT_GET, 'keyword', FILTER_SANITIZE_STRING );
		if ( empty( $keyword ) ) {
			die();
		}
		$arg            = array(
			'post_status'    => 'publish',
			'post_type'      => 'shop_coupon',
			'posts_per_page' => 50,
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => 'wlwl_unique_coupon',
					'compare' => 'NOT EXISTS'
				),
				array(
					'key'     => 'kt_unique_coupon',
					'compare' => 'NOT EXISTS'
				)
			),
			's'              => $keyword
		);
		$the_query      = new WP_Query( $arg );
		$found_products = array();
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$coupon = new WC_Coupon( get_the_ID() );
				if ( $coupon->get_usage_limit() > 0 && $coupon->get_usage_count() >= $coupon->get_usage_limit() ) {
					continue;
				}
				if ( $coupon->get_date_expires() && time() > $coupon->get_date_expires()->getTimestamp() ) {
					continue;
				}
				$product          = array( 'id' => get_the_ID(), 'text' => get_the_title() );
				$found_products[] = $product;
			}
		}
		wp_send_json( $found_products );
	}

//delete an image when a review is deleted
	public function delete_reviews_image( $comment_id ) {
		if ( get_comment_meta( $comment_id, 'reviews-images', true ) ) {
			$image_post_ids = get_comment_meta( $comment_id, 'reviews-images', true );
			foreach ( $image_post_ids as $image_post_id ) {
				if ( ! wc_is_valid_url( $image_post_id ) ) {
					wp_delete_file( wp_get_attachment_url( $image_post_id ) );
					wp_delete_post( $image_post_id, true );
				}
			}
		}
	}

	public function delete_attachment( $post_id ) {
		$comments = get_comments( array( 'count' => false, 'meta_key' => 'reviews-images' ) );
		foreach ( $comments as $comment ) {
			$comment_id     = $comment->comment_ID;
			$image_post_ids = get_comment_meta( $comment_id, 'reviews-images', true );
			foreach ( $image_post_ids as $key => $image_post_id ) {
				if ( $post_id == $image_post_id ) {
					unset( $image_post_ids[ $key ] );
					break;
				}
			}
			update_comment_meta( $comment_id, 'reviews-images', $image_post_ids );
			if ( ! count( get_comment_meta( $comment_id, 'reviews-images', true ) ) ) {
				delete_comment_meta( $comment_id, 'reviews-images' );
			}
		}
	}

}