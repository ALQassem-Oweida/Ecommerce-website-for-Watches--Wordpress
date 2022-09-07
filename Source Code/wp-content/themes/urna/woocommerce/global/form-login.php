<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (is_user_logged_in()) {
    return;
}

$formstyle = ($hidden) ? 'style=display:none;' : '';
?>
<form class="woocommerce-form woocommerce-form-login login u-columns" method="post" <?php echo esc_attr($formstyle); ?>>

	<?php do_action('woocommerce_login_form_start'); ?>

	<?php
        $message = ($message) ? wpautop(wptexturize($message)) : '';
        echo trim($message);
    ?>

	<p class="form-row">
		<input type="text" class="input-text" name="username" id="username" placeholder="<?php esc_attr_e('Username or email', 'urna'); ?>" />
	</p>
	<p class="form-row">
		<input class="input-text" type="password" name="password" id="password" placeholder="<?php esc_attr_e('Password', 'urna'); ?>" />
	</p>
	<div class="clear"></div>

	<?php do_action('woocommerce_login_form'); ?>

	<p class="form-row last">
		<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
			<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e('Remember me', 'urna'); ?></span>
		</label>
		<input type="submit" class="button" name="login" value="<?php esc_attr_e('Login', 'urna'); ?>" />
		<input type="hidden" name="redirect" value="<?php echo esc_url($redirect) ?>" />
	</p>
	<p class="lost_password">
		<a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost password?', 'urna'); ?></a>
	</p>
	<div class="clear"></div>
	<?php
        do_action('woocommerce_login_form_end'); ?>
</form>