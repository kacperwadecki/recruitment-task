<?php
namespace WordPressModule;

/**
 * Class responsible for admin panel
 * 
 * @since 1.0.0
 */
class Admin_Panel {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }
    
    public function add_admin_menu() {
        add_options_page(
            __('WordPress Module', 'wordpress-module'),
            __('WordPress Module', 'wordpress-module'),
            'manage_options',
            'wordpress-module',
            array($this, 'admin_page')
        );
    }
  
    public function admin_page() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to access this page.', 'wordpress-module'));
        }
        
        $cache_manager = new Cache_Manager();
        $cache_info = $cache_manager->get_cache_info();
        
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('WordPress Module - Configuration', 'wordpress-module'); ?></h1>
            
            <!-- Endpoint Info -->
            <div class="card">
                <h2><?php esc_html_e('REST API Endpoint', 'wordpress-module'); ?></h2>
                <p><strong><?php esc_html_e('URL:', 'wordpress-module'); ?></strong> <code><?php echo esc_url(get_rest_url(null, 'custom-module/v1/data')); ?></code></p>
                <p><strong><?php esc_html_e('Method:', 'wordpress-module'); ?></strong> GET</p>
                
                <h3><?php esc_html_e('Usage example:', 'wordpress-module'); ?></h3>
                <pre>
                    <code>curl -X GET "<?php echo esc_url(get_rest_url(null, 'custom-module/v1/data')); ?>"</code>
                </pre>
                
                <h3><?php esc_html_e('Test endpoint:', 'wordpress-module'); ?></h3>
                <button type="button" class="button button-primary" onclick="testEndpoint()">
                    <?php esc_html_e('Test Endpoint', 'wordpress-module'); ?>
                </button>
                <div id="test-result" style="margin-top: 10px;"></div>
            </div>
            
            <!-- Cache Info -->
            <div class="card">
                <h2><?php esc_html_e('Cache Information', 'wordpress-module'); ?></h2>
                <p><strong><?php esc_html_e('Status:', 'wordpress-module'); ?></strong> <?php echo $cache_info['exists'] ? esc_html__('Active', 'wordpress-module') : esc_html__('Inactive', 'wordpress-module'); ?></p>
                <p><strong><?php esc_html_e('Duration:', 'wordpress-module'); ?></strong> <?php echo esc_html($cache_info['duration']); ?> <?php esc_html_e('seconds', 'wordpress-module'); ?></p>
                <p><strong><?php esc_html_e('Key:', 'wordpress-module'); ?></strong> <?php echo esc_html($cache_info['key']); ?></p>
                
                <button type="button" class="button button-secondary" onclick="clearCache()">
                    <?php esc_html_e('Clear Cache', 'wordpress-module'); ?>
                </button>
                
                <button type="button" class="button button-primary" onclick="resetData()" style="margin-left: 10px;">
                    <?php esc_html_e('Reset to Default Data', 'wordpress-module'); ?>
                </button>
            </div>
        </div>
        
        <script>
        function testEndpoint() {
            const resultDiv = document.getElementById('test-result');
            resultDiv.innerHTML = '<?php esc_html_e('Testing...', 'wordpress-module'); ?>';
            
            fetch('<?php echo esc_url(get_rest_url(null, 'custom-module/v1/data')); ?>')
                .then(response => response.json())
                .then(data => {
                    resultDiv.innerHTML = '<div style="background: #d4edda; padding: 10px; border-radius: 4px; color: #155724;">✅ <?php esc_html_e('Endpoint works correctly!', 'wordpress-module'); ?></div>';
                    console.log('API Response:', data);
                })
                            .catch(error => {
                resultDiv.innerHTML = '<div style="background: #f8d7da; padding: 10px; border-radius: 4px; color: #721c24;">❌ <?php esc_html_e('Error:', 'wordpress-module'); ?> ' + error.message + '</div>';
            });
        }
        
        function clearCache() {
            const resultDiv = document.getElementById('test-result');
            resultDiv.innerHTML = '<?php esc_html_e('Clearing cache...', 'wordpress-module'); ?>';
            
            fetch('<?php echo esc_url(get_rest_url(null, 'custom-module/v1/clear-cache')); ?>', {
                method: 'DELETE',
                headers: {
                    'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resultDiv.innerHTML = '<div style="background: #d4edda; padding: 10px; border-radius: 4px; color: #155724;">✅ <?php esc_html_e('Cache cleared successfully!', 'wordpress-module'); ?></div>';
                    setTimeout(() => location.reload(), 1000);
                } else {
                    resultDiv.innerHTML = '<div style="background: #f8d7da; padding: 10px; border-radius: 4px; color: #721c24;">❌ <?php esc_html_e('Failed to clear cache:', 'wordpress-module'); ?> ' + data.message + '</div>';
                }
            })
            .catch(error => {
                resultDiv.innerHTML = '<div style="background: #f8d7da; padding: 10px; border-radius: 4px; color: #721c24;">❌ <?php esc_html_e('Error:', 'wordpress-module'); ?> ' + error.message + '</div>';
            });
        }
        
        function resetData() {
            const resultDiv = document.getElementById('test-result');
            resultDiv.innerHTML = '<?php esc_html_e('Resetting data to default...', 'wordpress-module'); ?>';
            
            fetch('<?php echo esc_url(get_rest_url(null, 'custom-module/v1/reset-data')); ?>', {
                method: 'DELETE',
                headers: {
                    'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resultDiv.innerHTML = '<div style="background: #d4edda; padding: 10px; border-radius: 4px; color: #155724;">✅ <?php esc_html_e('Data reset to default successfully!', 'wordpress-module'); ?></div>';
                    setTimeout(() => location.reload(), 1000);
                } else {
                    resultDiv.innerHTML = '<div style="background: #f8d7da; padding: 10px; border-radius: 4px; color: #721c24;">❌ <?php esc_html_e('Failed to reset data:', 'wordpress-module'); ?> ' + data.message + '</div>';
                }
            })
            .catch(error => {
                resultDiv.innerHTML = '<div style="background: #f8d7da; padding: 10px; border-radius: 4px; color: #721c24;">❌ <?php esc_html_e('Error:', 'wordpress-module'); ?> ' + error.message + '</div>';
            });
        }
        </script>
        <?php
    }
} 