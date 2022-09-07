<?php
    if (!(defined('URNA_WOOCOMMERCE_ACTIVED') && URNA_WOOCOMMERCE_ACTIVED) || is_user_logged_in()) {
        return;
    }

    if( urna_tbay_get_config('select-header-page', 'default') === 'default' ) {
        $show_login         = urna_tbay_get_config('show_login', true);
        $show_login_popup   = urna_tbay_get_config('show_login_popup', true);

        if( !$show_login || !$show_login_popup ) return;
    }

    do_action('urna_woocommerce_before_customer_login_form');
?>

<div id="custom-login-wrapper" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <button type="button" class="btn-close" data-dismiss="modal"><i class="linear-icon-cross"></i></button>
            <div class="modal-body">

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-customlogin"><i class="linear-icon-user hidden-md hidden-lg"></i><?php esc_html_e('Login', 'urna'); ?></a></li>

                    <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>
                    <li><a data-toggle="tab" href="#tab-customregister"><i class="linear-icon-pencil4 hidden-md hidden-lg"></i><?php esc_html_e('Register', 'urna'); ?></a></li>
                    <?php endif; ?>

                </ul>

                <div class="tab-content clearfix">
                    <div id="tab-customlogin" class="tab-pane fade in active">
                        <form id="custom-login" class="ajax-auth" action="login" method="post">
                            <?php do_action('woocommerce_login_form_start'); ?>

                            <h3><?php esc_html_e('Enter your username and password to login.', 'urna'); ?></h3>
                            <p class="status"></p>  
                            <?php wp_nonce_field('ajax-login-nonce', 'security'); ?>  
                            <input id="cus-username" type="text" placeholder="<?php esc_attr_e('Username/ Email', 'urna'); ?>" class="required" name="username" autocomplete="username" value="<?php echo (! empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>">
                            <input id="cus-password" type="password" placeholder="<?php esc_attr_e('Password', 'urna'); ?>" class="required" name="password" autocomplete="current-password"> 
                            
                            <div class="rememberme-wrapper">
                                <input name="rememberme" type="checkbox" id="cus-rememberme" value="forever">
                                <label for="cus-rememberme"><?php esc_html_e('Remember me', 'urna'); ?></label>
                            </div>
                            
                            <input class="submit_button" type="submit" value="<?php esc_attr_e('Login', 'urna'); ?>">

                            <a id="pop_forgot" class="text-link" href="<?php
                            echo wp_lostpassword_url(); ?>"><?php esc_html_e('Lost password?', 'urna'); ?></a>

                            <div class="clear"></div>
                            <?php do_action('woocommerce_login_form_end'); ?>
                        </form>
                    </div>

                    <?php if (get_option('woocommerce_enable_myaccount_registration') === 'yes') : ?>
                    <div id="tab-customregister" class="tab-pane fade">
                        <form id="custom-register" class="ajax-auth"  action="register" method="post">
                            <?php do_action('woocommerce_register_form_start'); ?>

                            <h3><?php esc_html_e('Fill to the forms to create your account', 'urna'); ?></h3>
                            <p class="status"></p>
                            <?php wp_nonce_field('ajax-register-nonce', 'signonsecurity'); ?>         
                            <input id="signonname" type="text" placeholder="<?php esc_attr_e('Username', 'urna'); ?>" name="signonname" class="required" value="<?php echo (! empty($_POST['signonname'])) ? esc_attr(wp_unslash($_POST['signonname'])) : ''; ?>">
                            <input id="signonemail" type="text" placeholder="<?php esc_attr_e('Email', 'urna'); ?>" class="required email" name="email" autocomplete="email" value="<?php echo (! empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>">
                            <input id="signonpassword" type="password" placeholder="<?php esc_attr_e('Password', 'urna'); ?>" class="required" name="signonpassword" autocomplete="new-password">
                            <input class="submit_button" type="submit" value="<?php esc_attr_e('Register', 'urna'); ?>">

                            <div class="clear"></div>
                            <?php do_action('urna_custom_woocommerce_register_form_end'); ?>
                            <?php do_action('woocommerce_register_form_end'); ?>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>