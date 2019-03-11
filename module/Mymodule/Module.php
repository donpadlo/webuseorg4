<?php
namespace Mymodule;

use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;

class Module {
    // Метод "init" вызывается при запуске приложения и  
    // позволяет зарегистрировать обработчик событий.
    public function init(ModuleManager $manager){
        echo "1";
        // Получаем менеджер событий.
        $eventManager = $manager->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        // Регистрируем метод-обработчик. 
        $sharedEventManager->attach(__NAMESPACE__, 'dispatch', [$this, 'onDispatch'], 100);
    }    
    // Обработчик события.
    public function onDispatch(MvcEvent $event){
        echo "2";
    }
}