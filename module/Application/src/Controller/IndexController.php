<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController{
    public function indexAction(){
        return new ViewModel();
    }
    public function aboutAction(){
        $viewModel = new ViewModel();
	$viewModel->setTemplate('application/user/user');
        
        $id = (int)$this->params()->fromQuery('id', -1);
        $appName = 'HelloWorld';
        $appDescription = 'A sample application for the Using Zend Framework 3 book';
//        return new ViewModel([
//        'appName' => $appName,
//        'appDescription' => $appDescription
//    ]);
        return $viewModel;
    }
    
}
