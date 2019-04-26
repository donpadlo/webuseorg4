<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Common\CommonFunctions;
use Application\Module;

class UserController extends AbstractActionController{
    public function indexAction(){        
        return new ViewModel();
    }    
    public function listusersAction(){                
        $rows=$this->params()->fromQuery('rows', '10');
        $page=$this->params()->fromQuery('page', '1');
        $sidx=$this->params()->fromQuery('sidx', 'id');
        $sord=$this->params()->fromQuery('sord', 'desc');
        $filters=$this->params()->fromQuery('filters', '');

        $result = Module::$sqln->ExecuteSQL("SELECT COUNT(*) AS count from users");
        $row = mysqli_fetch_array($result);
        $count = $row['count'];
        $total_pages = ($count > 0) ? ceil($count / $rows) : 0;
        if ($page > $total_pages) {$page = $total_pages;};        
        
        $start = $rows * $page - $rows;
        $sql= "SELECT * from users ORDER BY $sidx $sord LIMIT $start, $rows";
        $result = Module::$sqln->ExecuteSQL($sql) or die("Не могу выбрать список пользователей ($sql)!" . mysqli_error($sqlcn->idsqlconnection));
        $responce = new \stdClass();
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
        $i=0;
        while ($row = mysqli_fetch_array($result)) {        
            $responce->rows[$i]['id'] = $row['id'];
            $responce->rows[$i]['cell'] = array(
                $row['id'],
                $row['archive'],
                $row['login'],
                $row['password']
            );      
            $i++;
        };                
        $res = $this->getResponse();
        $headers = $res->getHeaders();
        $headers->addHeaderLine("Content-type: application/json"); 
        $res->setContent(json_encode($responce));       
        return $this->getResponse(); 
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
