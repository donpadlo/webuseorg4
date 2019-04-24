<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Common\CommonFunctions;
use Application\Common\Auth;
use Application\Module;
use Application\View\Helper\Megamenu;

class ServerController extends AbstractActionController{
    
    
    /**
     * Сохраняем быструю ссылку пользователя
     * @return type
     */
    public function savequickmenuAction(){   
        Megamenu::load();
        //var_dump(Megamenu::$dirtitems);
        $response = $this->getResponse();
        $headers = $response->getHeaders();
        $headers->addHeaderLine("Content-type: application/json");        
        $url=$this->params()->fromPost('url', '');
        if ($url!=""){            
            $resmenu=array();
            foreach (Megamenu::$dirtitems as $value) {
                if ($value["href"]==$url){
                  $resmenu=$value;                  
                };
            };
            if (count($resmenu)>0){
                $cnt=0;
                $sql="select * from users_quick_menu where url='$url' and userid=".Auth::$id;
                $result=Module::$sqln->ExecuteSQL($sql);        
                while ($myrow = mysqli_fetch_array($result)) {$cnt++;};
                if ($cnt>0){
                  $sql="delete from users_quick_menu where url='$url' and userid=".Auth::$id;
                  $result=Module::$sqln->ExecuteSQL($sql);        
                  $menu=Megamenu::GetUserQuickMenuArray(Auth::$id);
                  $response->setContent(json_encode(["userid"=>Auth::$id,"menu"=>$menu,"resmenu"=>$resmenu,"message"=>"Быстрая ссылка удалена","result" => true]));  
                } else {
                  $sql="insert into users_quick_menu (id,userid,url) values (null,'".Auth::$id."','$url')";
                  $result=Module::$sqln->ExecuteSQL($sql);                            
                  $menu=Megamenu::GetUserQuickMenuArray(Auth::$id);
                  $response->setContent(json_encode(["userid"=>Auth::$id,"menu"=>$menu,"resmenu"=>$resmenu,"message"=>"Быстрая ссылка добавлена","result" => true]));  
                };                
            } else {
                $response->setContent(json_encode(["userid"=>Auth::$id,"url"=>$url,"message"=>"Такая ссылка в меню не найдена","result" => false]));
            };
        } else {
            $response->setContent(json_encode(["userid"=>Auth::$id,"message"=>"Ссылка пустая","result" => false]));
        };
        return $this->getResponse();                
    }
    public function indexAction(){    
        $response = $this->getResponse();
        $headers = $response->getHeaders();
        $headers->addHeaderLine("Content-type: application/json");
        $response->setContent(json_encode(["result" => "ok"]));
        return $this->getResponse();        
    }    
    
}
