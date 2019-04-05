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
        $response = $this->getResponse();
        $headers = $response->getHeaders();
        $headers->addHeaderLine("Content-type: application/json");
        $response->setContent(json_encode(["result" => "ok"]));
        return $this->getResponse();        
    }    
    
}
