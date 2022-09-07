<?php
/**
 * functions preset for Urna Core
 *
 * @package    urna-core
 * @author     Team Thembays <tbaythemes@gmail.com >
 * @license    GNU General Public License, version 3
 * @copyright  2015-2016 Urna Core
 */


if( ! function_exists( 'urna_core_init_redux' ) ) {
    function urna_core_init_redux() {

        add_action( 'urna_core_preset', 'urna_core_redux_preset' );
        add_action( 'admin_enqueue_scripts', 'urna_core_redux_scripts' );

        add_action( 'wp_ajax_urna_core_new_preset', 'urna_core_redux_save_new_preset' );
        add_action( 'wp_ajax_nopriv_urna_core_new_preset', 'urna_core_redux_save_new_preset' );

        add_action( 'wp_ajax_urna_core_set_default_preset', 'urna_core_redux_set_default_preset' );
        add_action( 'wp_ajax_nopriv_urna_core_set_default_preset', 'urna_core_redux_set_default_preset' );

        add_action( 'wp_ajax_urna_core_delete_preset', 'urna_core_redux_delete_preset' );
        add_action( 'wp_ajax_nopriv_urna_core_delete_preset', 'urna_core_redux_delete_preset' );
        
        add_action( 'wp_ajax_urna_core_duplicate_preset', 'urna_core_redux_duplicate_preset' );
        add_action( 'wp_ajax_nopriv_urna_core_duplicate_preset', 'urna_core_redux_duplicate_preset' );
    }
}

if( ! function_exists( 'urna_core_redux_scripts' ) ) {
    function urna_core_redux_scripts() {
        wp_enqueue_script( 'urna-core-admin', URNA_CORE_URL . 'assets/admin.js', array( 'jquery'  ), '20131022', true );
        wp_enqueue_style( 'urna-core-admin', URNA_CORE_URL . 'assets/backend.css' );
    }
}

if( ! function_exists( 'urna_core_remove_scripts_yith_wfbt' ) ) {
    add_action( 'wp_enqueue_scripts', 'urna_core_remove_scripts_yith_wfbt', 20 );
    function urna_core_remove_scripts_yith_wfbt() {
        if( class_exists( 'YITH_WFBT' ) ) {
            wp_deregister_script('yith-wfbt-query-dialog');
            wp_deregister_style('yith-wfbt-query-dialog-style');
        }
    }
}


if( ! function_exists( 'urna_core_redux_duplicate_preset' ) ) {
    function urna_core_redux_duplicate_preset() {
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $preset = isset($_POST['default_preset']) ? $_POST['default_preset'] : '';
        $opt_name = apply_filters( 'urna_core_get_opt_name' );
        $preset_option = get_option( $opt_name.$preset );
        
        $key = strtotime('now');
        if ( !empty($title) ) {
            $presets = get_option( 'urna_core_presets' );
            $key = strtotime('now');
            $presets[$key] = $title;
            update_option( 'urna_core_presets', $presets );
            update_option( $opt_name.$key, $preset_option );
            update_option( 'urna_core_preset_default', $key );
        }
    }
}


if( ! function_exists( 'urna_core_redux_delete_preset' ) ) {
    function urna_core_redux_delete_preset() {
        $preset = isset($_POST['default_preset']) ? $_POST['default_preset'] : '';
        $default_preset = get_option( 'urna_core_preset_default' );

        if ( !empty($preset) ) {
            $presets = get_option( 'urna_core_presets' );
            if ( isset($presets[$preset]) ) {
                unset($presets[$preset]);
            }
            update_option( 'urna_core_presets', $presets );
            if ($preset == $default_preset) {
                update_option( 'urna_core_preset_default', '' );
            }
        }
    }
}

if( ! function_exists( 'urna_core_redux_set_default_preset' ) ) {
    function urna_core_redux_set_default_preset() {
        $default_preset = isset($_POST['default_preset']) ? $_POST['default_preset'] : '';
        update_option( 'urna_core_preset_default', $default_preset );
        die();
    }
}

if( ! function_exists( 'urna_core_redux_save_new_preset' ) ) {
    function urna_core_redux_save_new_preset() {
        $new_preset = isset($_POST['new_preset']) ? $_POST['new_preset'] : '';

        if ( !empty($new_preset) ) {
            $presets = get_option( 'urna_core_presets' );
            $key = strtotime('now');
            $presets[$key] = $new_preset;
            update_option( 'urna_core_presets', $presets );
            update_option( 'urna_core_preset_default', $key );
        }
        die();
    }
}

if( ! function_exists( 'urna_core_redux_preset' ) ) {
    function urna_core_redux_preset() {
        // preset
        $presets = get_option( 'urna_core_presets' );

        $default_preset = get_option( 'urna_core_preset_default' );
        if ( empty($presets) || !is_array($presets) ) {
            $presets = array();
        }
        ?>
        <section class="preset-section">
            <h3><?php esc_html_e( 'Preset Manager', 'urna-core' ); ?></h3>
            
            <div class="preset-content">
                <p class="note"><?php esc_html_e( 'Current preset default: ', 'urna-core' ); ?> <strong><?php echo (isset($presets[$default_preset]) ? $presets[$default_preset] : 'Default'); ?></strong></p>

                <label><?php esc_html_e( 'Create a new preset', 'urna-core' ); ?></label>
                <div><input type="text" name="new_preset" class="new_preset"> <button type="button" name="submit_new_preset" class="button submit-new-preset"><?php esc_html_e( 'Add new', 'urna-core' ); ?></button></div>
            
                
                <div class="set_default">
                    <label><?php esc_html_e( 'Set default preset', 'urna-core' ); ?></label>
                    <br>
                    <select class="set_default_preset" name="default_preset">
                        <option value=""><?php esc_html_e( 'Default', 'urna-core' ); ?></option>
                        <?php foreach ($presets as $key => $preset) { ?>
                            <option value="<?php echo $key; ?>"<?php echo $key == $default_preset ? 'selected="selected"' : ''; ?>><?php echo $preset; ?></option>
                        <?php } ?>
                    </select>
                    <button type="button" name="submit_preset" class="button submit-preset"><?php esc_html_e( 'Set Default', 'urna-core' ); ?></button>
                    <button type="button" name="submit_duplicate_preset" class="button submit-duplicate-preset"><?php esc_html_e( 'Duplicate', 'urna-core' ); ?></button>
                    <button type="button" name="submit_delete_preset" class="button submit-delete-preset"><?php esc_html_e( 'Delete Preset', 'urna-core' ); ?></button>
                    <div class="preset_des"><?php esc_html_e( 'Key:', 'urna-core' ); ?> <span class="key"><?php echo $default_preset; ?></span></div>
                </div>
                
            </div>
            <br>
            <br>
        </section>
        <?php
    }
}