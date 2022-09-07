<?php

if (!class_exists('WooCommerce')) {
    return;
}

if (!function_exists('urna_ajax_auth_init')) {
    function urna_ajax_auth_init()
    {
        $suffix = (urna_tbay_get_config('minified_js', false)) ? '.min' : URNA_MIN_JS;
        wp_register_script('jquery-validate', URNA_SCRIPTS . '/jquery.validate' . $suffix . '.js', array( 'jquery' ), '1.0', true);
        wp_register_script('urna-auth-script', URNA_SCRIPTS . '/ajax-auth-script' . $suffix . '.js', array( 'jquery-validate' ), '1.0', true);
        wp_enqueue_script('urna-auth-script');

        wp_localize_script('urna-auth-script', 'urna_ajax_auth_object', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'redirecturl' => home_url(),
            'loadingmessage' => esc_html__('Sending user info, please wait...', 'urna'),
            'validate'          => array(
                'required'      => esc_html__('This field is required.', 'urna'),
                'remote'        => esc_html__('Please fix this field.', 'urna'),
                'email'         => esc_html__('Please enter a valid email address.', 'urna'),
                'url'           => esc_html__('Please enter a valid URL.', 'urna'),
                'date'          => esc_html__('Please enter a valid date.', 'urna'),
                'dateISO'       => esc_html__('Please enter a valid date (ISO).', 'urna'),
                'number'        => esc_html__('Please enter a valid number.', 'urna'),
                'digits'        => esc_html__('Please enter only digits.', 'urna'),
                'creditcard'    => esc_html__('Please enter a valid credit card number.', 'urna'),
                'equalTo'       => esc_html__('Please enter the same value again.', 'urna'),
                'accept'        => esc_html__('Please enter a value with a valid extension.', 'urna'),
                'maxlength'     => esc_html__('Please enter no more than {0} characters.', 'urna'),
                'minlength'     => esc_html__('Please enter at least {0} characters.', 'urna'),
                'rangelength'   => esc_html__('Please enter a value between {0} and {1} characters long.', 'urna'),
                'range'         => esc_html__('Please enter a value between {0} and {1}.', 'urna'),
                'max'           => esc_html__('Please enter a value less than or equal to {0}.', 'urna'),
                'min'           => esc_html__('Please enter a value greater than or equal to {0}.', 'urna'),
            ),
        ));

        // Enable the user with no privileges to run ajax_login() in AJAX
        add_action('wp_ajax_ajaxlogin', 'urna_ajax_login');
        add_action('wp_ajax_nopriv_ajaxlogin', 'urna_ajax_login');

        // Enable the user with no privileges to run ajax_register() in AJAX
        add_action('wp_ajax_ajaxregister', 'urna_ajax_register');
        add_action('wp_ajax_nopriv_ajaxregister', 'urna_ajax_register');
    }
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'urna_ajax_auth_init');
}
 
if (!function_exists('urna_ajax_login')) {
    function urna_ajax_login()
    {

        // First check the nonce, if it fails the function will break
        check_ajax_referer('ajax-login-nonce', 'security');

        // Nonce is checked, get the POST data and sign user on
        // Call auth_user_login
        urna_auth_user_login($_POST['username'], $_POST['password'], $_POST['rememberme'], 'Login');
        
        die();
    }
}

if (!function_exists('urna_ajax_register')) {
    function urna_ajax_register()
    {

        // First check the nonce, if it fails the function will break
        check_ajax_referer('ajax-register-nonce', 'security');
            
        // Nonce is checked, get the POST data and sign user on
        $info = array();
        $info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($_POST['username']) ;
        $info['user_pass'] = sanitize_text_field($_POST['password']);
        $info['user_email'] = sanitize_email($_POST['email']);
        $rememberme =  (isset($_POST['remember'])) ? $_POST['remember'] : '' ;

        if ($rememberme == 'forever') {
            $remember = true;
            $info['remember'] = true;
        } else {
            $remember = false;
            $info['remember'] = false;
        }
        
        // Register the user
        $user_register = wp_insert_user($info);
        if (is_wp_error($user_register)) {
            $error  = $user_register->get_error_codes() ;
            
            if (in_array('empty_user_login', $error)) {
                echo json_encode(array('loggedin'=>false, 'message'=>$user_register->get_error_message('empty_user_login') ));
            } elseif (in_array('existing_user_login', $error)) {
                echo json_encode(array('loggedin'=>false, 'message'=> esc_html__('This username is already registered.', 'urna')));
            } elseif (in_array('existing_user_email', $error)) {
                echo json_encode(array('loggedin'=>false, 'message'=> esc_html__('This email address is already registered.', 'urna')));
            }
        } else {
            urna_auth_user_login($info['nickname'], $info['user_pass'], $info['remember'], 'Registration');
        }

        die();
    }
}

if (!function_exists('urna_auth_user_login')) {
    function urna_auth_user_login($user_login, $password, $remember, $login)
    {
        $info = array();
        $info['user_login'] = $user_login;
        $info['user_password'] = $password;

        $rememberme =  (isset($_POST['remember'])) ? $_POST['remember'] : '';
    
        if ($rememberme == 'forever') {
            $remember = true;
            $info['remember'] = true;
        } else {
            $remember = false;
            $info['remember'] = false;
        }
        // From false to '' since v 4.9
        $user_signon = wp_signon($info, '');
        if (is_wp_error($user_signon)) {
            echo json_encode(array('loggedin'=>false, 'message'=> esc_html__('Wrong username or password.', 'urna')));
        } else {
            wp_set_current_user($user_signon->ID);
            echo json_encode(array('loggedin'=>true, 'message'=> esc_html__('Login successful, redirecting...', 'urna')));
        }
        
        die();
    }
}
