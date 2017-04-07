<?php
/**
 * AWeber Web Forms uninstall procedure.
 */

// Make sure this is a legitimate uninstall request
if(!defined('ABSPATH') or !defined('WP_UNINSTALL_PLUGIN') or !current_user_can('delete_plugins')) {
    exit();
}

/**
 * Drop tables used by AWeber Forms plugin
 */
function aweber_webform_uninstall_db() {
    global $wpdb;
    $tables = array();
    foreach ($tables as $table) {
        $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . $table);
    }
}

/**
 * Delete AWeber Forms saved options
 */
function aweber_webform_uninstall_options() {
    $options = array(
        'AWeberWebformPluginAdminOptions',
        'AWeberWebformPluginWidgetOptions',
        'aweber_webform_oauth_id',
        'aweber_webform_oauth_removed',
    );
    foreach ($options as $option) {
        delete_option($option);
    }
}

aweber_webform_uninstall_db();
aweber_webform_uninstall_options();
?>
