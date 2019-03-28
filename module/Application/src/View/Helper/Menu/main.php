<?php
use Application\View\Helper\Megamenu;

Megamenu::Add([
        "href"=>"#",
        "index"=>0,
        "ico"=>"fa fa-home fa-fw",
        "name"=>" Home me",
        "title"=>"Домой!!"
    ]);           
Megamenu::Add([
        "href"=>"/menu/about",
        "index"=>100,
        "ico"=>"fa fa-home fa-fw",
        "name"=>" About",
        "title"=>"About"
    ]);           
  
?>