<?php
namespace Application\Common;
use Zend\Http\Header\SetCookie; 
use Zend\Http\Response;

class CommonFunctions{
 public static $err=array();        // список ошибок для показа пользователю на странице
 public static $ok=array();         // список сообщений для показа пользователю на странице
    
/** Проверка, а есть ли содержимое $_GET[] и присвоение пустого значения или содержимого
 * @param type $name
 * @return string
 */
public function _GET($name) {
	return (isset($_GET[$name])) ? $_GET[$name] : '';
}

/** Проверка, а есть ли содержимое $_POST[] и присвоение пустого значения или содержимого
 * @param type $name
 * @return string
 */
public function _POST($name) {
	return (isset($_POST[$name])) ? $_POST[$name] : '';
}

/**
 * Сгенерировать Соль для шифрования по SHA1
 * @return type
 */
public function generateSalt() {
	$salt = '';
	$length = rand(5, 10); // длина соли (от 5 до 10 сомволов)
	for ($i = 0; $i < $length; $i++) {
		$salt .= chr(rand(33, 126)); // символ из ASCII-table
	}
	return $salt;
}
/**
 * Результат - случайная строка длинной N
 * @return type
 */
public function GetRandomId($n) {
	$id = '';
	for ($i = 1; $i <= $n; $i++) {
		$id .= chr(rand(48, 56));
	}
	return $id;    
}
/**
 * Получение значения хранимого параметра по имени параметра
 *
 * @global type $sqlcn
 * @param type $nameparam
 *            - имя параметра
 * @return type
 */
public function GetByParam($sqlcn,$nameparam){
    $resz = "";
    $result = $sqlcn->ExecuteSQL("SELECT * FROM config WHERE name='$nameparam'") or $err[]="Неверный запрос GetByParam:".mysqli_error($sqlcn->idsqlconnection);
    while ($myrow = mysqli_fetch_array($result)) {
        $resz = $myrow['value'];
    }
    return $resz;
}

/**
 * Установить значение хранимого параметра
 *
 * @global type $sqlcn
 * @param type $nameparam
 *            - название параметра
 * @param type $valparam
 *            - значение параметра
 */
public function SetByParam($sqlcn,$nameparam, $valparam){
    // записываем данные по идентификатору    
    $valparam = mysqli_real_escape_string($sqlcn->idsqlconnection, $valparam);
    $result = $sqlcn->ExecuteSQL("SELECT * FROM config WHERE name ='$nameparam'") or $err[]="Неверный запрос SetByParam:".mysqli_error($sqlcn->idsqlconnection);
    $row = mysqli_fetch_array($result);
    $cnt = @count($row);
    // или добавляем настройки или выдаем параметр
    if ($cnt == 0) {
        $result = $sqlcn->ExecuteSQL("INSERT INTO config (name,value) VALUES ('$nameparam','')");
    }
    $result = $sqlcn->ExecuteSQL("UPDATE config SET value='$valparam' WHERE name='$nameparam'") or die('Неверный запрос Tcconfig.SetByParam: ' . mysqli_error($sqlcn->idsqlconnection));
}

}
?>