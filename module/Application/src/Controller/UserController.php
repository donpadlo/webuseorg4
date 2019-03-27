<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Common\CommonFunctions;

class UserController extends AbstractActionController{
    public function indexAction(){        
        return new ViewModel();
    }    
    public function userAction(){
        return new ViewModel();
    }        
    public function logoutAction(){
        
        return new ViewModel();
    }        
    
    public function loginAction(){
        return new ViewModel();
    }        
    
}
