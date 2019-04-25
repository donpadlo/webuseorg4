<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Common\CommonFunctions;
use Application\Common\Auth;
use Application\Module;
use Application\View\Helper\Megamenu;

class ConfigController extends AbstractActionController{

    public function indexAction(){    
        $viewModel = new ViewModel();
        if (Auth::$rules["admin"]==true){
            $viewModel->setTemplate('application/config/norules');            
        };
        return $viewModel;
    }    
    
}
