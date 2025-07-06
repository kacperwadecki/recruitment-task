<?php
namespace WordPressModule;

/**
 * Class responsible for REST API endpoints
 * 
 * @since 1.0.0
 */
class API_Endpoints {
    
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_rest_routes'));
    }
    
    public function register_rest_routes() {
        register_rest_route('custom-module/v1', '/data', array(
            'methods' => \WP_REST_Server::READABLE,
            'callback' => array($this, 'get_module_data'),
            'permission_callback' => '__return_true',
            'args' => array(),
        ));
        
        register_rest_route('custom-module/v1', '/clear-cache', array(
            'methods' => \WP_REST_Server::DELETABLE,
            'callback' => array($this, 'clear_cache'),
            'permission_callback' => array($this, 'check_admin_permissions'),
            'args' => array(),
        ));
        
        register_rest_route('custom-module/v1', '/reset-data', array(
            'methods' => \WP_REST_Server::DELETABLE,
            'callback' => array($this, 'reset_data'),
            'permission_callback' => array($this, 'check_admin_permissions'),
            'args' => array(),
        ));
    }
    
    /**
     * Function returning module data
     * 
     * @param \WP_REST_Request $request Request object
     * @return \WP_REST_Response Response with data
     */
    public function get_module_data(\WP_REST_Request $request): \WP_REST_Response {
        $cache_manager = new Cache_Manager();
        $module_data = $cache_manager->get_cached_data();
        
        if (!$module_data) {
            $data_manager = new Data_Manager();
            $module_data = $data_manager->get_module_data();
            
            $cache_manager->set_cache($module_data);
        }
        
        $module_data['meta'] = array(
            'lastUpdated' => current_time('c'),
            'version' => WP_MODULE_VERSION,
            'author' => 'Kacper Wadecki',
            'source' => 'WordPress API',
            'timestamp' => time()
        );
        
        return new \WP_REST_Response($module_data, 200);
    }
    
    /**
     * Clear cache endpoint
     * 
     * @param \WP_REST_Request $request Request object
     * @return \WP_REST_Response Response with result
     */
    public function clear_cache(\WP_REST_Request $request): \WP_REST_Response {
        $cache_manager = new Cache_Manager();
        $result = $cache_manager->clear_cache();
        
        if ($result) {
            return new \WP_REST_Response(array(
                'success' => true,
                'message' => 'Cache cleared successfully'
            ), 200);
        } else {
            return new \WP_REST_Response(array(
                'success' => false,
                'message' => 'Failed to clear cache'
            ), 500);
        }
    }
    
    /**
     * Reset data to default
     * 
     * @param \WP_REST_Request $request Request object
     * @return \WP_REST_Response Response with result
     */
    public function reset_data(\WP_REST_Request $request): \WP_REST_Response {
        $data_manager = new Data_Manager();
        $result = $data_manager->reset_to_default();
        
        if ($result) {
            return new \WP_REST_Response(array(
                'success' => true,
                'message' => 'Data reset to default successfully'
            ), 200);
        } else {
            return new \WP_REST_Response(array(
                'success' => false,
                'message' => 'Failed to reset data'
            ), 500);
        }
    }
    
    /**
     * Check admin permissions
     * 
     * @return bool True if user has admin permissions
     */
    public function check_admin_permissions(): bool {
        return current_user_can('manage_options');
    }
} 