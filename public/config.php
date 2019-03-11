<?php
return [
    'database'=>require 'dbconfig.php',                           
    'modules' => [
            'Zend\Router',
            'Zend\Validator',
            'Application', 
            'Mymodule',
    ],
    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor',
        ],
        'config_cache_enabled' => false,
        'config_cache_key' => 'application.config.cache',
        'module_map_cache_enabled' => false,
        'module_map_cache_key' => 'application.module.cache',
        'cache_dir' => 'data/cache/',
    ],    
];
