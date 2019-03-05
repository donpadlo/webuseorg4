<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Common\CommonServices;

class IndexController extends AbstractActionController{
    public function indexAction(){               
        return new ViewModel(["message"=>CommonServices::IsGuest($this,"Hello service!")]);
    }
    public function aboutAction(){
        $viewModel = new ViewModel();
	$viewModel->setTemplate('application/user/user');        
        return $viewModel;
    }
    
}
