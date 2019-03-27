<?php
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Application\Common\CommonFunctions;
// Этот класс помощника отображения меню
class Megamenu extends AbstractHelper {  
    public static $items=array();         // массив меню 
    public static $leftitems=array();     // массив меню слева (кнопки)
    public static $buttomitems=array();     // массив меню внизу (кнопки)
    public static $itemsquick=array();    // массив "быстрого" меню
    public function __construct() {    
    }    
    public function load(){
        foreach (glob(__DIR__."/Menu/*.php") as $filename){
            include $filename;
        }
        
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
              if (isset($item["submenus"])==true){
                  echo "<li><span title='".$item["title"]."'><i class='".$item["ico"]."'></i>".$item["name"]."</span>\n";                                
                     Megamenu::RenderSubMenu($item["submenus"]);
                  echo "</li>\n";
              } else {
                echo "<li><a href='".$item["href"]."'><i class='".$item["ico"]."'></i>".$item["name"]."</a></li>\n";                  
              };
            };        
        echo "</ul>\n";            
    }
    public function RenderMegaMenu($tag) {    
        echo "<nav id='$tag'>\n";
            echo "<ul id='panel-$tag'>\n";
            self::$items=Megamenu::MSort(self::$items);
            foreach (self::$items as $item) {                            
              if (isset($item["submenus"])==true){
                  echo "<li><span title='".$item["title"]."'><i class='".$item["ico"]."'></i>".$item["name"]."</span>\n";                                    
                    Megamenu::RenderSubMenu($item["submenus"]);
                  echo "</li>\n";
              } else {
                echo "<li><a title='".$item["title"]."' href='".$item["href"]."'><i class='".$item["ico"]."'></i>".$item["name"]."</a></li>\n";                  
              };
            };
            echo "</ul>\n";
        echo "</nav>\n";
    }    
    public function RenderQuickMenu() {            
        foreach (self::$itemsquick as $item) {              
            echo "<button title='".$item["title"]."' type='button' class='".$item["class"]."'><i class='".$item["ico"]."'></i></button>\n";
        };
        
    }
    public function ViewJSMenu($tag) {                       
    ?>
    $(document).ready(function(){ 
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
