<?php
namespace Application\Common;
use Application\Common\MySQL;
use Application\Common\CommonFunctions;
use Application\Module;

class Auth{
 public static $login=false; // true,false - успешная или нет авторизация
 public static $id="";       // идентификатор из БД для авторизированного пользователя
 public static $randomid=""; // случайный идентификатор для печенек
 public static $salt="";     // соль для пароля зашифрованного по SHA1
 // базовые права
 public static $rules=[
     "admin"=> true,        // администратор
     "update"=> false,       // может обновлять
     "add"=>false,           // может добавлять
     "delete"=>false,        // может удалять
     "money"=>false,         // операции с которые связаны с возможной тратой денег
     "reports"=>false,       // просмотр отчетов
     "reportsmoney"=>false,  // просмотр отчетов связанных с деньгами
     "map"=>false,           // может работать с картой     
 ];
 /**
 * Обновляем ВООБЩЕ все кукисы установленные в домене /
 * @global type $_COOKIE
 */
public function UpdateAllCookies(){
    global $_COOKIE;
    foreach ($_COOKIE as $key=>$value) {
      SetCookie("$key","$value",strtotime('+30 days'),'/');       
    };
}    
/**
 * Возвращает значение печеньки если есть. Иначе false
 * @param type $name
 * @return \Application\Common\type
 */
public function GetCookies($name){    
  if (isset($_COOKIE[$name])==false){$res=false;} else {$res=  $_COOKIE[$name];};
  return $res;
}
/**
 * Установить значение печеньки
 * @param type $name
 * @param type $value
 */
public function SetCookies($name,$value){     
     SetCookie($name,$value,strtotime('+30 days'),'/');  
 }
 
 public function SessionId(){
     if (self::GetCookies("sessionid")==false){
         $sessionid=CommonFunctions::GetRandomId(100);
         self::SetCookies("sessionid",$sessionid);
         $capcha= rand(0,100);
         $sql="insert into sessions (id,sessionid,dt,capchavalue,capcha,cnt) values (null,'$sessionid',now(),$capcha,false,0)";
         $result=Module::$sqln->ExecuteSQL($sql);        
     } else {
         $sessionid=self::GetCookies("sessionid");
         $capcha= rand(0,100);
         $sql="insert into sessions (id,sessionid,dt,capchavalue,capcha,cnt) values (null,'$sessionid',now(),$capcha,false,0) ON DUPLICATE KEY update capcha=false,dt=now(),cnt=cnt+1";         
         $result=Module::$sqln->ExecuteSQL($sql);                          
     };
     // если попыток входа более 10, то ставим флажок "показывать капчу"
     $sql="update sessions set capcha=true where cnt>10";
     $result=Module::$sqln->ExecuteSQL($sql);      
     // да и сессии заодно почистим старые
     $sql="delete from sessions where datediff(dt,now())>0";
     $result=Module::$sqln->ExecuteSQL($sql);           
     return $sessionid;
 }
 
/**
 * Попытка авторизации по cookes
 * @param type $name
 */
public function LoginCookies($name){
    if (self::GetCookies($name)!==false){
        $randomid=self::GetCookies($name);
        $sql="select * FROM users where randomid='$randomid' and archive=0";
        $result=Module::$sqln->ExecuteSQL($sql);        
        while ($myrow = mysqli_fetch_array($result)) {
            self::$id = $myrow['id'];
            self::$randomid = $myrow['randomid'];
            self::$login=true;            
            $sessionid=self::SessionId();
            $capcha= rand(0,100);
            $sql="insert into sessions (id,sessionid,dt,capchavalue,capcha,cnt) values (null,'$sessionid',now(),$capcha,true,0) ON DUPLICATE KEY update capcha=true,dt=now(),cnt=0";         
            $result=Module::$sqln->ExecuteSQL($sql);                                      
            
        };        
        if (self::$login==false){
            CommonFunctions::$err[]="Пользователь не найден по cookies";            
            $sessionid=self::SessionId();
            $capcha= rand(0,100);
            $sql="insert into sessions (id,sessionid,dt,capchavalue,capcha,cnt) values (null,'$sessionid',now(),$capcha,true,0) ON DUPLICATE KEY update capcha=true,dt=now(),capchavalue=$capcha,cnt=cnt+1";         
            $result=Module::$sqln->ExecuteSQL($sql);                                      
        };
    };
}
public function ReadyCapcha($sessionid){    
 $res=false;   
 $sql="select * from sessions where sessionid='$sessionid'";   
 $result=Module::$sqln->ExecuteSQL($sql);
   while ($myrow = mysqli_fetch_array($result)) {
     $capchavalue=$myrow["capchavalue"];             
     $capcha=$myrow["capcha"];        
     if ($capcha==0){$res=true;};
     if ($capchavalue==CommonFunctions::_POST("capcha")){$res=true;};
   };
 return $res;
}
/**
 * Попытка авторизации по POST текщей страницы
 * @param type $name
 */
public function LoginPOST(){    
    if ((CommonFunctions::_POST("login_login")!="") and (CommonFunctions::_POST("login_password")!="")){
        $sql="select * FROM users where login='".CommonFunctions::_POST("login_login")."' and password=SHA1(CONCAT(SHA1('".CommonFunctions::_POST("login_password")."'), users.salt)) and archive=0";
        $result=Module::$sqln->ExecuteSQL($sql);
        while ($myrow = mysqli_fetch_array($result)) {
            self::$id = $myrow['id'];
            self::$randomid = $myrow['randomid'];
            self::$login=true;            
        };
        $sessionid=self::SessionId();
        //проверяем капчу...
        if (self::ReadyCapcha($sessionid)==false){
            self::$login=false;
            CommonFunctions::$err[]="Не верно введена капча";
        };
        ///
        if (self::$login==false){
            CommonFunctions::$err[]="Логин или пароль не верен";
            $capcha= rand(0,100);
            $sql="insert into sessions (id,sessionid,dt,capchavalue,capcha,cnt) values (null,'$sessionid',now(),$capcha,true,0) ON DUPLICATE KEY update capcha=true,dt=now(),capchavalue=$capcha,cnt=cnt+1";         
            $result=Module::$sqln->ExecuteSQL($sql);                                                  
        };        
    };
}


}
?>