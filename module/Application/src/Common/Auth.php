<?php
namespace Application\Common;
use Application\Common\MySQL;
use Application\Common\CommonFunctions;
use Application\Module;

class Auth{
 public static $login=false;   // true,false - успешная или нет авторизация
 public static $id="";       // идентификатор из БД для авторизированного пользователя
 public static $randomid=""; // случайный идентификатор для печенек
 public static $salt="";     // соль для пароля зашифрованного по SHA1
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
        };        
        if (self::$login==false){CommonFunctions::$err[]="Пользователь не найден по cookies";};
    };
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
        if (self::$login==false){CommonFunctions::$err[]="Логин или пароль не верен";};        
    };
}


}
?>