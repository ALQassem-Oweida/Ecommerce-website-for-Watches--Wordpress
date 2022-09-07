<?php

if ( !urna_vc_is_activated() ) {
    return;
}


if (!function_exists('urna_datepicker_settings_field')) {
    WpbakeryShortcodeParams::addField('datepicker', 'urna_datepicker_settings_field');
    function urna_datepicker_settings_field($settings, $value)
    {
        return '<div class="datepicker_block">'
         .'<input name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput ' .
         esc_attr($settings['param_name']) . ' tbay-' .
         esc_attr($settings['type']) . '_field" type="text" value="' . esc_attr($value) . '" placeholder="YYYY-MM-DD" />'
         .'</div>';
    }
}

if (!function_exists('urna_tbay_vc_datepicker_editor_jscss')) {
    /**
     * Enqueue Backend and Frontend CSS Styles
     */
    add_action('vc_backend_editor_enqueue_js_css', 'urna_tbay_vc_datepicker_editor_jscss', 5);
    function urna_tbay_vc_datepicker_editor_jscss()
    {
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_style('jquery-ui-style');
    }
}

$suffix = (urna_tbay_get_config('minified_js', false)) ? '.min' : URNA_MIN_JS;
WpbakeryShortcodeParams::addField('datepicker', 'urna_datepicker_settings_field', URNA_SCRIPTS . '/admin/admin' . $suffix . '.js');
