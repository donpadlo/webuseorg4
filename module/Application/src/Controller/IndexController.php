<?php
namespace Application\Controller;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Common\CommonFunctions;
use Application\Common\Auth;

use Application\Module;

class IndexController extends AbstractActionController{        
    public static $sqln; 

    public function __construct() {           
    }             
    public function indexAction(){    
        
        return new ViewModel();
        //return new ViewModel(["message"=>CommonServices::IsGuest($this,$this->dbconnection)]);
    }
    public function helloAction(){    
        
        return new ViewModel();
        //return new ViewModel(["message"=>CommonServices::IsGuest($this,$this->dbconnection)]);
    }    
    public function aboutAction(){
//           if (Auth::GetCookies("randomid4")==false){            
//            $viewModel = new ViewModel();
//            $viewModel->setTemplate('menu/user/login');                       
//           };
        
        return $viewModel;        
    }
    
}
