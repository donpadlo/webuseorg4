<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Common\CommonServices;

class UserController extends AbstractActionController{
    public function indexAction(){
        return new ViewModel();
    }    
    public function userAction(){
        return new ViewModel();
    }        
    public function loginAction(){
        return new ViewModel();
    }        
    
}
