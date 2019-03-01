<?php

use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;

// в константу __DIR__ заносим текущий путь
chdir(dirname(__DIR__));

// загружаем модули из Composer
include __DIR__ . '/../vendor/autoload.php';

if (! class_exists(Application::class)) {
    throw new RuntimeException(
        "Не могу запустить приложение\n -выполните`composer install`\n"
    );
}

// получаем настройки приложения
$appConfig = require __DIR__ . '/config.php';

Application::init($appConfig)->run();
