<?php
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Application\Common\CommonFunctions;
// Этот класс помощника отображения разных сообщений пользователю (статичных)
class Messages extends AbstractHelper {  
public function __construct() {    
}    
public function renderErrorMessages() {    
    foreach (CommonFunctions::$err as $msg) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo "<strong>$msg</strong>";
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';
    };
}
    
}