<?php
namespace WordPressModule;

/**
 * Class responsible for managing module data
 * 
 * @since 1.0.0
 */
class Data_Manager {
    
    private string $option_name = 'wordpress_module_data';
    
    /**
     * Get module data
     * 
     * @return array Module data
     */
    public function get_module_data(): array {
        $data = get_option($this->option_name, $this->get_default_data());
        return $data;
    }

    /**
     * Install default data
     */
    public function install_default_data(): void {
        $default_data = $this->get_default_data();
        add_option($this->option_name, $default_data);
    }
    
    /**
     * Reset data to default
     */
    public function reset_to_default(): bool {
        $default_data = $this->get_default_data();
        $result = update_option($this->option_name, $default_data);
        
        if ($result) {
            $cache_manager = new Cache_Manager();
            $cache_manager->clear_cache();
        }
        
        return $result;
    }
    
    /**
     * Get default module data
     * 
     * @return array Default data
     */
    private function get_default_data(): array {
        return \WordPressModule\Default_Data::get_data();
    }
} 