<?php
namespace Application\Common;
use Zend\Http\Header\SetCookie; 
use Zend\Http\Response;

class CommonFunctions{
 public static $err=array();       // список ошибок для показа пользователю на странице
    
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
function generateSalt() {
	$salt = '';
	$length = rand(5, 10); // длина соли (от 5 до 10 сомволов)
	for ($i = 0; $i < $length; $i++) {
		$salt .= chr(rand(33, 126)); // символ из ASCII-table
	}
	return $salt;
}

}
?>