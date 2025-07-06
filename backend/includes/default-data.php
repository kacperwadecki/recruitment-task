<?php
namespace WordPressModule;

/**
 * Class containing default module data
 * 
 * @since 1.0.0
 */
class Default_Data {
    
    /**
     * Returns default module data
     * 
     * @return array Default module data
     */
    public static function get_data(): array {
        return array(
            'cards' => array(
                array(
                    'value' => 200,
                    'description' => 'Lorem ipsum dolor sit amet.',
                    'size' => 'lg',
                    'span' => 'half',
                    'showDecoration' => true,
                    'icon' => 'head-circuit'
                ),
                array(
                    'value' => 120,
                    'description' => 'Lorem ipsum dolor sit amet',
                    'size' => 'md',
                    'span' => 'quarter',
                    'icon' => 'users-three'
                ),
                array(
                    'value' => 10,
                    'description' => 'Lorem ipsum dolor sit amet',
                    'size' => 'md',
                    'span' => 'quarter',
                    'icon' => 'star'
                )
            )
        );
    }
} 