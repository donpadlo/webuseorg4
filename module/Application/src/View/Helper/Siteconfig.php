<?php
namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Application\Common\CommonFunctions;
use Application\Module;
// Этот класс помощника отображения настроек сайта
class Siteconfig extends AbstractHelper {  
    public function Title() {    
        return CommonFunctions::GetByParam(Module::$sqln,"site_title");
    }        
    public function __construct() {    
    }    
};    