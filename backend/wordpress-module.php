<?php
/**
 * Plugin Name: WordPress Module - Recruitment Task
 * Description: Plugin containing custom REST API endpoint for frontend module
 * Version: 1.0.0
 * Author: Kacper Wadecki
 */

if (!defined('ABSPATH')) {
    exit;
}

define('WP_MODULE_VERSION', '1.0.0');
define('WP_MODULE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_MODULE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WP_MODULE_PLUGIN_BASENAME', plugin_basename(__FILE__));

spl_autoload_register(function ($class) {
    $prefix = 'WordPressModule\\';
    $base_dir = WP_MODULE_PLUGIN_DIR . 'includes/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});


function wp_module_init(): void {
    // Load main modules
    require_once WP_MODULE_PLUGIN_DIR . 'includes/default-data.php';
    require_once WP_MODULE_PLUGIN_DIR . 'includes/class-api-endpoints.php';
    require_once WP_MODULE_PLUGIN_DIR . 'includes/class-admin-panel.php';
    require_once WP_MODULE_PLUGIN_DIR . 'includes/class-data-manager.php';
    require_once WP_MODULE_PLUGIN_DIR . 'includes/class-cache-manager.php';
    
    // Initialize classes
    new \WordPressModule\API_Endpoints();
    new \WordPressModule\Admin_Panel();
    new \WordPressModule\Data_Manager();
    new \WordPressModule\Cache_Manager();
    
    // Install default data if not exists
    $data_manager = new \WordPressModule\Data_Manager();
    if (!get_option('wordpress_module_data')) {
        $data_manager->install_default_data();
    }
}
add_action('plugins_loaded', 'wp_module_init');

register_activation_hook(__FILE__, 'wp_module_activate');
register_deactivation_hook(__FILE__, 'wp_module_deactivate');

function wp_module_activate(): void {
    flush_rewrite_rules();
}

function wp_module_deactivate(): void {
    flush_rewrite_rules();
} 