<?php
namespace Application;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;

use Application\Common\MySQL;
use Application\Common\CommonFunctions;
use Application\Common\Auth;

class Module {    
    public static $sqln; 
    public function __construct() {     
            // устанавливаем соединение с БД MySQL
            $config=Module::getConfig();
            self::$sqln=new MySQL();
            self::$sqln->connect($config['database']['host'],$config['database']['username'],$config['database']['password'],$config['database']['basename']);                       
    }       
    public function init(ModuleManager $manager){       
        // Получаем менеджер событий.
        $eventManager = $manager->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        // Регистрируем метод-обработчик.            
        $sharedEventManager->attach(__NAMESPACE__, 'dispatch', [$this, 'onDispatch'], 100);        
    }   
    // Обработчик события.
    public function onDispatch(MvcEvent $event){        
    //Если абонент не авторизирован, то показываем ему страницу авторизации                    
              $controller = $event->getTarget();
              $controllerClass = get_class($controller);
              $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
              $viewModel = $event->getViewModel();                  
              $viewModel->setTemplate('layout/layout');               
              $uri = $event->getRequest()->getUri();                
              $patch = $uri->getPath();              
                Auth::LoginCookies("randomid4");
                Auth::LoginPOST();        
                if (Auth::$login==true){
                    Auth::SetCookies("randomid4",Auth::$randomid);
                };
                $response=null;
                if (($patch!="/user/login") and (Auth::$login==false)){  
                      $viewModel = $event->getViewModel();                  
                      $viewModel->setTemplate('layout/login');                                     
                      $uri->setPath('/user/login');
                      $response=$event->getResponse();
                      $response->getHeaders()->addHeaderLine('Location', $uri);
                      $response->setStatusCode(301);
                      $response->sendHeaders();                    
                };                        
                if (($patch=="/user/login") and (Auth::$login==true)){                    
                      $viewModel = $event->getViewModel();                  
                      $viewModel->setTemplate('layout/layout');                                                                       
                      $uri->setPath('/application/index');
                      $response=$event->getResponse();
                      $response->getHeaders()->addHeaderLine('Location', $uri);
                      $response->setStatusCode(301);
                      $response->sendHeaders();                              
                };
                if (($patch=="/user/login") and (Auth::$login==false)){
                      $viewModel = $event->getViewModel();                  
                      $viewModel->setTemplate('layout/login');                                     
                };                
               return $response;
    }        
    public function getConfig(){            
            return [            
            'database'=>require __DIR__.'/../../../public/dbconfig.php',// настройки соединения с БД MySQL                
            'router' => [
                'routes' => [
                    'home' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'application' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/application[/:action]',
                            'defaults' => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],  
                    // авторизация пользователей
                    'user' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/user[/:action]',
                            'defaults' => [
                                'controller' => Controller\UserController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],                      

                ],      
            ],
            'controllers' => [
                'factories' => [
                    Controller\IndexController::class => InvokableFactory::class,                        
                    Controller\UserController::class => InvokableFactory::class,                        
                ],
            ],
            'view_helpers' => [                    
                    'factories' => [
                        View\Helper\Messages::class => InvokableFactory::class,
                        View\Helper\Megamenu::class => InvokableFactory::class
                    ],                   
                    'aliases' => [
                        'mess' => View\Helper\Messages::class,
                        'megamenu' => View\Helper\Megamenu::class
                    ],                                               
                ],                    
            'view_manager' => [
                'display_not_found_reason' => true,
                'display_exceptions'       => true,
                'doctype'                  => 'HTML5',
                'not_found_template'       => 'error/404',
                'exception_template'       => 'error/index',
                'template_map' => [
                    'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
                    'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
                    'error/404'               => __DIR__ . '/../view/error/404.phtml',
                    'error/index'             => __DIR__ . '/../view/error/index.phtml',
                ],
                'template_path_stack' => [
                    __DIR__ . '/../view',
                ],
            ],
        ];

    }
}
