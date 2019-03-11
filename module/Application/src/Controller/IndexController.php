<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Common\CommonServices;
use Application\Common\MySQL;

class IndexController extends AbstractActionController{        
    public static $sqln; 
    public function __construct(array $config) {     
            // устанавливаем соединение с БД MySQL
            echo "3";
            self::$sqln=new MySQL();
            self::$sqln->connect($config['database']['host'],$config['database']['username'],$config['database']['password'],$config['database']['basename']);            
            var_dump(self::$sqln->idsqlconnection);
	 }             
    public function indexAction(){       
        return new ViewModel(["message"=>$this->sqln]);
        //return new ViewModel(["message"=>CommonServices::IsGuest($this,$this->dbconnection)]);
    }
    public function aboutAction(){
        $viewModel = new ViewModel();
	$viewModel->setTemplate('application/user/user');        
        return $viewModel;
    }
    
}
