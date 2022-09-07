<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form'); ?>

<div class="u-columns row" id="customer_login">
	<div class="hidden-xs hidden-sm col-md-3"></div>
	<div class="col-sm-12 col-md-6">
		<ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#login" aria-controls="login" role="tab" data-toggle="tab"><?php esc_html_e('Login', 'urna'); ?></a></li>

		    <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>
			    <li role="presentation"><a href="#register" aria-controls="register" role="tab" data-toggle="tab"><?php esc_html_e('Register', 'urna'); ?></a></li>
			<?php endif; ?>
	  	</ul>
			<div class="tab-content">
		    	<div role="tabpanel" class="tab-pane active" id="login">

				<form id="login" class="woocommerce-form woocommerce-form-login login" method="post">

					<?php do_action('woocommerce_login_form_start'); ?>

					<span class="sub-title"><?php esc_html_e('Enter your username and password to login.', 'urna'); ?></span>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" placeholder="<?php esc_attr_e('Username or email', 'urna'); ?>" autocomplete="username" value="<?php echo (! empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine?>
					</p>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" placeholder="<?php esc_attr_e('Password', 'urna'); ?>" autocomplete="current-password" />
					</p>
					<?php do_action('woocommerce_login_form'); ?>
					
					<p class="form-row last">
						<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e('Remember me', 'urna'); ?></span>
						</label>
						<button type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e('Login', 'urna'); ?>"><?php esc_html_e('Login', 'urna'); ?></button>
					</p>
					<p class="woocommerce-LostPassword lost_password">
						<a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost password?', 'urna'); ?></a>
					</p>
					
					<?php do_action('woocommerce_login_form_end'); ?>
				</form>
			</div>

			<?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>
				<div role="tabpanel" class="tab-pane" id="register">

					<form id="register" method="post" class="woocommerce-form woocommerce-form-register register">

						<span class="sub-title"><?php esc_html_e('Enter your email and password to register.', 'urna'); ?></span>
						
						<?php do_action('woocommerce_register_form_start'); ?>

						<?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" placeholder="<?php esc_attr_e('Username', 'urna'); ?>"autocomplete="username" value="<?php echo (! empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine?>
							</p>

						<?php endif; ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" placeholder="<?php esc_attr_e('Email address', 'urna'); ?>" autocomplete="email" value="<?php echo (! empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine?>
						</p>

						<?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" placeholder="<?php esc_attr_e('Password', 'urna'); ?>" autocomplete="new-password" />
							</p>
  
		      			<?php else : ?>
		      
		      				<p><?php esc_html_e('A password will be sent to your email address.', 'urna'); ?></p>
		      
		      			<?php endif; ?>
      
      					<?php do_action('woocommerce_register_form'); ?>

						<p class="woocommerce-form-row form-row last">
							<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
							<button type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e('Register', 'urna'); ?>"><?php esc_html_e('Register', 'urna'); ?></button>
						</p>
						
						<?php do_action('woocommerce_after_button_resgiter'); ?>

						<?php do_action('woocommerce_register_form_end'); ?>
					</form>
				</div>
			<?php endif; ?>

		</div>
	</div>
	<div class="hidden-xs hidden-sm col-md-3"></div>
</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>
