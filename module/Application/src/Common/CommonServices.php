<?php
namespace Application\Common;
use Zend\Http\Header\SetCookie; 

class CommonServices{
 public function IsGuest($tt,$mess){     
     $cookie = new SetCookie('randomuserid4', 'baz', time()+7200);
     $tt->getResponse()->getHeaders()->addHeader($cookie);
     $cc=$tt->getRequest()->getCookie("randomuserid4");
        if (isset($cc->randomuserid4)){
            echo "!!";
            $ret["result"]=true;
        };
     return $mess;
 }
}
?>