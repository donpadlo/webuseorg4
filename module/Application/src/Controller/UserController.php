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
        $param=CommonFunctions::GetTableParamByPost($this);                
        //var_dump($param);
        if ($param["oper"]=="del"){
            $res["id"]=$this->params()->fromPost('id', '0');                        
            if ($res["id"]!=0){
              $sql="update users set archive=not archive where id=".$res["id"];  
              $result = Module::$sqln->ExecuteSQL($sql) or die("Не могу обновить данные по пользователю " . mysqli_error($sqlcn->idsqlconnection));
            };
            die($sql);
        };
        if ($param["oper"]=="add"){
            $res["login"]=$this->params()->fromPost('login', '');
            $res["archive"]=$this->params()->fromPost('archive', '0');            
            $res["password"]=$this->params()->fromPost('password', '0');            
            $salt = CommonFunctions::generateSalt();
            $pass = sha1(sha1($res["password"]) . $salt);
            $randomid=CommonFunctions::GetRandomId(50);
            $sql="insert into users (id,salt,randomid,login,password,archive) values (null,'$salt','$randomid','".$res["login"]."','$pass',".$res["archive"].")";
            if (Module::$sqln->ExecuteSQL($sql)=="") {
                header('HTTP/1.1 501 Internal Server Error'); 
                die("Не могу добавить пользователя! " . mysqli_error(Module::$sqln->idsqlconnection));                
            };
            die();
        };        
        if ($param["oper"]=="edit"){
            $res["login"]=$this->params()->fromPost('login', '');
            $res["archive"]=$this->params()->fromPost('archive', '0');            
            $res["password"]=$this->params()->fromPost('password', '0');            
            $res["id"]=$this->params()->fromPost('id', '0');                        
            if ($res["id"]!=0){
               $salt = CommonFunctions::generateSalt();
               $pass = sha1(sha1($res["password"]) . $salt);
              $sql="update users set salt='$salt',password='$pass',login='".$res["login"]."',archive='".$res["archive"]."' where id=".$res["id"];  
              $result = Module::$sqln->ExecuteSQL($sql) or die("Не могу обновить данные по пользователю " . mysqli_error(Module::$sqln->idsqlconnection));
            };            
            die($sql);
        };
        if ($param["oper"]=="list"){
                //вычисляем фильтр
                $where = '';
                $flt = json_decode($param["filters"], true);
                if (isset($flt["rules"])){
                    for ($i = 0; $i < count($flt["rules"]); $i ++) {
                        $field = $flt['rules'][$i]['field'];
                        $data = $flt['rules'][$i]['data'];
                        $where = $where . "($field LIKE '%$data%')";
                        if ($i < ($cnt - 1)) {
                            $where = $where . ' AND ';
                        }
                    }            
                };
                if ($where != '') {$where = 'WHERE ' . $where;};
                //echo "!$where!";
                //

                $result = Module::$sqln->ExecuteSQL("SELECT COUNT(*) AS count from users $where");
                $row = mysqli_fetch_array($result);
                $count = $row['count'];
                $total_pages = ($count > 0) ? ceil($count / $param["rows"]) : 0;
                if ($param["page"] > $total_pages) {$param["page"] = $total_pages;};        

                $start = $param["rows"] * $param["page"] - $param["rows"];
                $sql= "SELECT * from users $where ORDER BY ".$param["sidx"]." ".$param["sord"]." LIMIT $start, ".$param["rows"];
                $result = Module::$sqln->ExecuteSQL($sql) or die("Не могу выбрать список пользователей " . mysqli_error(Module::$sqln->idsqlconnection));
                $responce = new \stdClass();
                $responce->page = $param["page"];
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
        };
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
