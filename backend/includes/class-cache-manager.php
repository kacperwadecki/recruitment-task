<?php
namespace WordPressModule;

/**
 * Class responsible for cache management
 * 
 * @since 1.0.0
 */
class Cache_Manager {
    
    private string $cache_key = 'wordpress_module_cache';
    
    /**
     * Cache duration in seconds (1 hour)
     */
    private int $cache_duration = HOUR_IN_SECONDS;
    
    /**
     * Get data from cache
     * 
     * @return mixed Data from cache or false if not exists
     */
    public function get_cached_data(): mixed {
        return get_transient($this->cache_key);
    }

    /**
     * Save data to cache
     * 
     * @param mixed $data Data to save
     * @return bool True if saved successfully
     */
    public function set_cache(mixed $data): bool {
        return set_transient($this->cache_key, $data, $this->cache_duration);
    }
    
    /**
     * Clear cache
     * 
     * @return bool True if cleared successfully
     */
    public function clear_cache(): bool {
        return delete_transient($this->cache_key);
    }
    
    /**
     * Check if cache is valid
     * 
     * @return bool True if cache exists and is valid
     */
    public function is_cache_valid(): bool {
        $cached_data = $this->get_cached_data();
        return !empty($cached_data);
    }
    
    /**
     * Set cache duration
     * 
     * @param int $duration Duration in seconds
     */
    public function set_cache_duration(int $duration): void {
        $this->cache_duration = absint($duration);
    }
    
    /**
     * Get cache information
     * 
     * @return array Cache information
     */
    public function get_cache_info(): array {
        $cached_data = $this->get_cached_data();
        
        return array(
            'exists' => !empty($cached_data),
            'duration' => $this->cache_duration,
            'key' => $this->cache_key
        );
    }
} 