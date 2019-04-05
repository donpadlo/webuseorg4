<?php
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Application\Common\CommonFunctions;
use Application\Module;
use Application\Common\Auth;
// Этот класс помощника отображения меню
class Megamenu extends AbstractHelper {  
    public static $items=array();         // массив меню 
    public static $leftitems=array();     // массив меню слева (кнопки)
    public static $buttomitems=array();   // массив меню внизу (кнопки)
    public static $itemsquick=array();    // массив "быстрого" меню
    public static $dirtitems=array();     // не структурированный массив меню
    public static $breadcrumbs=array();   // массив "крошек"
    public static $lenitems=0;            // длина меню
    public function __construct() {    
    }    
    
    public function GetUserQuickMenuArray($userid){
        $res=array();     
        $sql="select * from users_quick_menu where userid=$userid";        
        //echo "$sql";
        $result=Module::$sqln->ExecuteSQL($sql);        
        while ($myrow = mysqli_fetch_array($result)) {
            $url=$myrow["url"];            
            foreach (self::$dirtitems as $items) {
                if ($items["href"]==$url){
                    $res[]=$items;
                };
            };            
        };
        return $res;     
    }


    /**
     *  строим структуру "родителей" в основном меню
     */
    public function CounstructParentsSub($items){
        $parent=self::$lenitems;
        foreach ($items as &$value) {
            self::$lenitems++;
            $value["id"]=self::$lenitems;
            $value["parent"]=$parent;         
            $tmp=$value;
            if (isset($tmp["submenus"])==true){
                unset($tmp["submenus"]);
            };
            self::$dirtitems[]=$tmp;
                if (isset($value["submenus"])==true){    
                  $value["submenus"]=Megamenu::CounstructParentsSub($value["submenus"]);  
                };
            };        
        return $items;
    }
    public function CounstructParents(){
        self::$lenitems=0;$parent=0;
        foreach (self::$items as &$value) {
            self::$lenitems++;
            $value["id"]=self::$lenitems;
            $value["parent"]=$parent;         
            $tmp=$value;
            if (isset($tmp["submenus"])==true){
                unset($tmp["submenus"]);
            };
            self::$dirtitems[]=$tmp;
            if (isset($value["submenus"])==true){
              $value["submenus"]=Megamenu::CounstructParentsSub($value["submenus"]);  
            };
        }        
    }
    /////////////////////////////////////////////////
    public function load(){
        foreach (glob(__DIR__."/Menu/*.php") as $filename){
            include $filename;
        }
        //расставляю везде в меню "родителей", для более легкого построения "крошек". Ну еще может где пригодится..
        Megamenu::CounstructParents();
        //echo json_encode(self::$dirtitems);
    }
    public function MSort($items){
        $tmparr=array();
        $inda=array();
        //добавляем индекс если его нет и составляем карту индексов
        foreach ($items as $item) {            
            if (isset($item["index"])==false){$item["index"]=999;};
            if (isset($item["title"])==false){$item["title"]="";};
            $tmparr[]=$item;
            if (in_array($item["index"], $inda)==false){$inda[]=$item["index"];};
        };
        sort($inda);        
        $items=array();
        foreach ($inda as $index) {  
            foreach ($tmparr as $item) {  
                if ($index==$item["index"]){$items[]=$item;};
            };
        };
        
        return $items;
    }
    public function AddQuickMenu($item){
        self::$itemsquick[]=$item;        
    }    
    public function AddButtomMenu($item){
        self::$buttomitems[]=$item;        
    }       
    public function AddLeftMenu($item){
        self::$leftitems[]=$item;        
    }       
    
    public function Add($item){
        self::$items[]=$item;
    }
    public function RenderSubMenu($items) {    
        $items=Megamenu::MSort($items);
        echo "<ul>\n";
            foreach ($items as $item) {           
              if (Module::$url==$item["href"]){$sel = ' class="Selected"';} else {$sel = '';};  
              if (isset($item["submenus"])==true){                  
                  echo "<li$sel><span title='".$item["title"]."'><i class='".$item["ico"]."'></i>".$item["name"]."</span>\n";                                
                     Megamenu::RenderSubMenu($item["submenus"]);
                  echo "</li>\n";
              } else {
                echo "<li$sel><a href='".$item["href"]."'><i class='".$item["ico"]."'></i>".$item["name"]."</a></li>\n";                  
              };
            };        
        echo "</ul>\n";            
    }
    public function RenderMegaMenu($tag) {    
        echo "<nav id='$tag' style='display: none;'>\n";
            echo "<ul id='panel-$tag'>\n";
            self::$items=Megamenu::MSort(self::$items);
            foreach (self::$items as $item) {  
              if (Module::$url==$item["href"]){$sel = ' class="Selected"';} else {$sel = '';};
              if (isset($item["submenus"])==true){
                  echo "<li$sel><span title='".$item["title"]."'><i class='".$item["ico"]."'></i>".$item["name"]."</span>\n";                                    
                    Megamenu::RenderSubMenu($item["submenus"]);
                  echo "</li>\n";
              } else {
                echo "<li$sel><a title='".$item["title"]."' href='".$item["href"]."'><i class='".$item["ico"]."'></i>".$item["name"]."</a></li>\n";                  
              };
            };
            echo "</ul>\n";
        echo "</nav>\n";
    }    
    public function GetCurrentTitleByUrlSub($item,$res) {               
        foreach ($items as $value) {            
            if (($value["href"]==Module::$url) and (isset($value["title"])==true)){                
                $res=$value["title"];  
                break;
            };
            if (isset($value["title"])==true){
                $res=Megamenu::GetCurrentTitleByUrlSub($value);                        
            };
        }
        return $res;        
    }
    public function GetCurrentTitleByUrl() {       
        $res="Без заголовка |";
        foreach (self::$dirtitems as $value) {            
            if (($value["href"]==Module::$url) and (isset($value["title"])==true)){                
                $res=$value["title"]." | "; 
                break;
            };
            if (isset($value["title"])==true){
                $res=Megamenu::GetCurrentTitleByUrlSub($value,$res)." | ";                        
            };
        }
        if ((Module::$url=="") or (Module::$url=="/")) $res="";
        return $res;
    }
    public function RenderBreadcrumbsSub($parent) {   
        foreach (self::$dirtitems as $items) {
          if ($parent==$items["id"]){              
                $br=array();
                $br["href"]=$items["href"];
                $br["name"]=$items["name"];
                $br["title"]=$items["title"];
                $br["parent"]=$items["parent"];
                $br["id"]=$items["id"];                
                if ($br["href"]!="")self::$breadcrumbs[]=$br;
                if ($items["parent"]!=0){
                    Megamenu::RenderBreadcrumbsSub($items["parent"]);
                };              
          };
        };
    }
    public function RenderBreadcrumbs() {          
        foreach (self::$dirtitems as $items) {
          if (Module::$url==$items["href"]){              
              if ($items["parent"]!=0){
                $br=array();
                $br["href"]=$items["href"];
                $br["name"]=$items["name"];
                $br["title"]=$items["title"];
                $br["parent"]=$items["parent"];
                $br["id"]=$items["id"];
                if ($br["href"]!="")self::$breadcrumbs[]=$br;
                Megamenu::RenderBreadcrumbsSub($items["parent"]);
              };              
          };
        };
        $br=array();
        $br["href"]="/";
        $br["name"]="Главная";
        $br["title"]="Переход на главную страницу сайта";
        self::$breadcrumbs[]=$br;
        if (count(self::$breadcrumbs)>1){
            echo '<nav aria-label="breadcrumb"><ol class="breadcrumb">';
                for ($i=count(self::$breadcrumbs);$i>0;$i--){
                    if ($i==1){
                        $cururl=self::$breadcrumbs[$i-1]["href"];
                        echo '<li class="breadcrumb-item active" aria-current="page">'.self::$breadcrumbs[$i-1]["name"].'</li>';
                    } else {
                        echo '<li class="breadcrumb-item" title="'.self::$breadcrumbs[$i-1]["title"].'"><a href="'.self::$breadcrumbs[$i-1]["href"].'">'.self::$breadcrumbs[$i-1]["name"].'</a></li>';
                    };
                };
            echo "<li class=\"breadcrumb-item breadcrumb-item-quick\" onclick=\"AddSubQuickMenu('$cururl');\" title=\"Прибить/удалить страницу в быстрых ссылках\"><i class=\"fa fa-fighter-jet\" aria-hidden=\"true\"></i></li>";                
            echo '  </ol></nav>';
        };
?>     
  <?php      
    }
    public function RenderQuickMenu() {    
        echo "<div id='quick_menu_div' name='quick_menu_div'>";
            foreach (self::$itemsquick as $item) {              
                echo "<a href='".$item["href"]."' class='displaycontent'><button title='".$item["title"]."' type='button' class='".$item["class"]."'><i class='".$item["ico"]."'></i></button></a>\n";            
            };
            echo "<div id='user_quick_menu_div' name='user_quick_menu_div'>";
                $sql="select * from users_quick_menu where userid=".Auth::$id;                
                $result=Module::$sqln->ExecuteSQL($sql);                        
                while ($myrow = mysqli_fetch_array($result)) {
                    foreach (self::$dirtitems as $items) {                                                
                      if ($items["href"]==$myrow["url"]){                          
                        echo "<a href='".$items["href"]."' class='displaycontent'><button title='".$items["title"]."' type=\"button\" class=\"btn btn-outline-dark btn-sm\"><i class='".$items["ico"]."'></i></button></a>";    
                      };
                    };                    
                };                                
            echo "</div>";
        echo "</div>";
    }
    public function ViewJSMenu($tag) {                       
    ?>
    $(document).ready(function(){ 
    $('#<?php echo "$tag"?>').show();
    $('#<?php echo "$tag"?>').mmenu({
			"extensions": [
                  "fx-menu-zoom",
                  "fx-panels-zoom"
               ],               
                "counters": true,
                "iconbar": {
                  "add": true,
                  "top": [
<?php
    self::$leftitems=Megamenu::MSort(self::$leftitems);
    foreach (self::$leftitems as $item) {
        echo "\"<a title='".$item["title"]."' href='".$item["href"]."'><i class='".$item["ico"]."'></i></a>\",\n";
    };
?>
                  ]
               },                
                "navbars": [
                      {
                         "position": "top",
                         "content": [
                            "searchfield"
                         ]
                      },
                      {
                         "position": "bottom",
                            "content": [
                                <?php
                                    self::$leftitems=Megamenu::MSort(self::$leftitems);
                                    foreach (self::$buttomitems as $item) {
                                        echo "\"<a title='".$item["title"]."' href='".$item["href"]."'><i class='".$item["ico"]."'></i></a>\",\n";
                                    };
                                ?>
                            ]
                      }
                   ],               							
			onClick: {
				setSelected: true,
				close: false
			},                                                
		},{language: "ru"});                		     
     });

     <?php
    }    
}
