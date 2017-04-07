<?php
/*
Plugin Name: AWeber Web Forms
Plugin URI: http://www.aweber.com/faq/questions/588/How+Do+I+Use+AWeber%27s+Webform+Widget+for+Wordpress%3F
Description: Adds your AWeber Web Form to your sidebar
Version: 1.1.10
Author: AWeber
Author URI: http://www.aweber.com
License: MIT
*/


if (function_exists('register_activation_hook')) {
    if (!function_exists('aweber_web_forms_activate')) {
        function aweber_web_forms_activate() {
            if (version_compare(phpversion(), '5.2', '<')) {
                trigger_error('', E_USER_ERROR);
            }
        }
    }

    register_activation_hook(__FILE__, 'aweber_web_forms_activate');
}

if (isset($_GET['action']) and $_GET['action'] == 'error_scrape') {
    die('Sorry, AWeber Web Forms requires PHP 5.2 or higher. Please deactivate AWeber Web Forms.');
}

// Initialize plugin.
if (!class_exists('AWeberWebformPlugin')) {
    require_once(dirname(__FILE__) . '/php/aweber_api/aweber_api.php');
    require_once(dirname(__FILE__) . '/php/aweber_webform_plugin.php');
    $aweber_webform_plugin = new AWeberWebformPlugin();

    $options = get_option('AWeberWebformPluginWidgetOptions');
    if ($options['create_subscriber_comment_checkbox'] == 'ON' && is_numeric($options['list_id_create_subscriber']))
    {
        /* The following line adds the checkbox to the comment form.
         * If problems persist, the code can be changed to
         * any of the following 3 lines. Just add a # before
         * the line that is currently active, and remove the
         * # from the line you wish to use. */
        add_action('comment_form',array(&$aweber_webform_plugin,'add_checkbox'));
        #add_filter('comment_form_after_fields',array(&$aweber_webform_plugin,'add_checkbox'));
        #add_filter('thesis_hook_after_comment_box',array(&$aweber_webform_plugin,'add_checkbox'));
        // End
        add_action('comment_post',array(&$aweber_webform_plugin,'grab_email_from_comment'));
    }
    if ($options['create_subscriber_registration_checkbox'] == 'ON' && is_numeric($options['list_id_create_subscriber']))
    {
        add_action('register_form',array(&$aweber_webform_plugin,'add_checkbox'));
        add_action('register_post',array(&$aweber_webform_plugin,'grab_email_from_registration'));
    }
    add_action('comment_unapproved_to_approved',array(&$aweber_webform_plugin,'comment_approved'));
    add_action('comment_spam_to_approved',array(&$aweber_webform_plugin,'comment_approved'));
    add_action('delete_comment',array(&$aweber_webform_plugin,'comment_deleted'));
}

// Initialize admin panel.
if (!function_exists('AWeberFormsWidgetController_ap')) {
    function AWeberFormsWidgetController_ap() {
        global $aweber_webform_plugin;
        if (!isset($aweber_webform_plugin)) {
            return;
        }
        if (function_exists('add_options_page')) {
            add_options_page('AWeber Web Form', 'AWeber Web Form', 'manage_options', basename(__FILE__), array(&$aweber_webform_plugin, 'printAdminPage'));
        }
        if (function_exists('add_filter')) {
            add_filter("plugin_action_links_aweber-web-form-widget/aweber.php", 'add_aweber_settings_link');
        }
    }
}

if (!function_exists('add_aweber_settings_link')) {
    function add_aweber_settings_link($links) {
            $settings_link = '<a href="options-general.php?page=aweber.php">Settings</a>';
            array_unshift($links, $settings_link);
            return $links;
    }
}

if (!function_exists('AWeberRegisterSettings')) {

    function AWeberAuthMessage() {
        global $aweber_webform_plugin;
        echo $aweber_webform_plugin->messages['auth_required'];
    }

    function AWeberRegisterSettings() {
        if (is_admin()) {
            global $aweber_webform_plugin;
            register_setting($aweber_webform_plugin->oauthOptionsName, 'aweber_webform_oauth_id');
            register_setting($aweber_webform_plugin->oauthOptionsName, 'aweber_webform_oauth_removed');
            register_setting($aweber_webform_plugin->oauthOptionsName, 'aweber_comment_checkbox_toggle');
            register_setting($aweber_webform_plugin->oauthOptionsName, 'aweber_registration_checkbox_toggle');
            register_setting($aweber_webform_plugin->oauthOptionsName, 'aweber_signup_text_value');

            $pluginAdminOptions = get_option($aweber_webform_plugin->adminOptionsName);
            if ($pluginAdminOptions['access_key'] == '') {
                add_action('admin_notices', 'AWeberAuthMessage');
                return;
            }
        }
    }
}
// Initialize widget.
if (!function_exists('AWeberFormsWidgetController_widget')) {
    function AWeberFormsWidgetController_widget() {
        global $aweber_webform_plugin;
        if (!isset($aweber_webform_plugin)) {
            return;
        }

        if (function_exists('wp_register_sidebar_widget') and function_exists('wp_register_widget_control')) {
            wp_register_sidebar_widget($aweber_webform_plugin->widgetOptionsName, __('AWeber Web Form'), array(&$aweber_webform_plugin, 'printWidget'));
            wp_register_widget_control($aweber_webform_plugin->widgetOptionsName, __('AWeber Web Form'), array(&$aweber_webform_plugin, 'printWidgetControl'));
        }
    }
}

// Actions and filters.
if (isset($aweber_webform_plugin)) {
    // Actions
    add_action('aweber/aweber.php',  array(&$aweber_webform_plugin, 'init'));
    add_action('admin_menu', 'AWeberFormsWidgetController_ap');
    add_action('admin_init', 'AWeberRegisterSettings');
    add_action('plugins_loaded', 'AWeberFormsWidgetController_widget');
    add_action('admin_print_scripts', array(&$aweber_webform_plugin, 'addHeaderCode'));
    add_action('wp_ajax_get_widget_control', array(&$aweber_webform_plugin, 'printWidgetControlAjax'));

    add_action('wp_dashboard_setup', array(&$aweber_webform_plugin, 'aweber_add_dashboard_widgets'));
    // Filters
}
?>
