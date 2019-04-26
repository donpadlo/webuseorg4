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
    // если не админ, то показываем загрушку
    if (Auth::$rules["admin"]==false){
        $viewModel = new ViewModel();
        $viewModel->setTemplate('application/config/norules');            
    } else {
     // иначе читаем текущие настройки..
        $ret=array();
        $ret["core_version"]=CommonFunctions::GetByParam(Module::$sqln,"core_version");
        $ret["site_title"]=CommonFunctions::GetByParam(Module::$sqln,"site_title");
        $ret["check_events"]=CommonFunctions::GetByParam(Module::$sqln,"check_events");
        
        $ret["smtp_from"]=CommonFunctions::GetByParam(Module::$sqln,"smtp_from");
        $ret["smtp_server"]=CommonFunctions::GetByParam(Module::$sqln,"smtp_server");
        $ret["smtp_port"]=CommonFunctions::GetByParam(Module::$sqln,"smtp_port");
        $ret["smtp_login"]=CommonFunctions::GetByParam(Module::$sqln,"smtp_login");
        $ret["smtp_pass"]=CommonFunctions::GetByParam(Module::$sqln,"smtp_pass");
        
        
        $viewModel=new ViewModel($ret);
    };
    return $viewModel;
}    
public function saveconfigAction(){
     if (Auth::$rules["admin"]==true){
        $site_title=$this->params()->fromPost('site_title', '');    
        CommonFunctions::SetByParam(Module::$sqln,"site_title",$site_title);
        $check_events=$this->params()->fromPost('check_events', 'true');    
        CommonFunctions::SetByParam(Module::$sqln,"check_events",$check_events);        
        $smtp_from=$this->params()->fromPost('smtp_from', 'true');    
        CommonFunctions::SetByParam(Module::$sqln,"smtp_from",$smtp_from);
        $smtp_server=$this->params()->fromPost('smtp_server', 'true');    
        CommonFunctions::SetByParam(Module::$sqln,"smtp_server",$smtp_server);
        $smtp_port=$this->params()->fromPost('smtp_port', 'true');    
        CommonFunctions::SetByParam(Module::$sqln,"smtp_port",$smtp_port);
        $smtp_login=$this->params()->fromPost('smtp_login', 'true');    
        CommonFunctions::SetByParam(Module::$sqln,"smtp_login",$smtp_login);
        $smtp_pass=$this->params()->fromPost('smtp_pass', 'true');    
        CommonFunctions::SetByParam(Module::$sqln,"smtp_pass",$smtp_pass);
     };
        $response = $this->getResponse();
        $headers = $response->getHeaders();
        $headers->addHeaderLine("Content-type: application/json"); 
        $response->setContent(json_encode(["result" => "Настройки сохранены"]));       
        return $this->getResponse();      
}    
    
}
