<?php
return [
    'modules' => [
            'Zend\Router',
            'Zend\Validator',
            'Application',
    ],
    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor',
        ],
        'config_cache_enabled' => true,
        'config_cache_key' => 'application.config.cache',
        'module_map_cache_enabled' => true,
        'module_map_cache_key' => 'application.module.cache',
        'cache_dir' => 'data/cache/',
    ],
];
