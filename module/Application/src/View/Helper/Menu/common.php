<?php
use Application\View\Helper\Megamenu;
Megamenu::Add([
        "href"=>"#",
        "index"=>10,
        "ico"=>"fa fa-home fa-fw",
        "name"=>" Our work"
]);    
Megamenu::Add([
    "href"=>"#",
    "index"=>10,
    "ico"=>"fa fa-address-book",
    "name"=>" Справочники",
        "submenus"=>[
                        [
                        "href"=>"/user/index",
                        "ico"=>"fa fa-address-book fa-fw",
                        "name"=>" Пользователи",
                        "title"=>"Справочник пользователей системы"
                        ],                        
                        [
                        "href"=>"#",
                        "index"=>10,
                        "ico"=>"fa fa-home fa-fw",
                        "name"=>" History 3"                            
                        ]
                    ]
]); 
Megamenu::Add([
    "href"=>"#",
    "index"=>10,
    "ico"=>"fa fa-home fa-fw",
    "name"=>" About us",
        "submenus"=>[
                        [
                        "href"=>"#",
                        "ico"=>"fa fa-home fa-fw",
                        "name"=>" History 1",
                        "title"=>"Hello all!"
                        ],
                        [
                        "href"=>"#",
                        "ico"=>"fa fa-home fa-fw",
                        "name"=>" History 2",
                            "submenus"=>[
                                            [   "href"=>"/menu/hello",
                                                "ico"=>"fa fa-bolt fa-fw",
                                                "name"=>" History 2-2",
                                                "title"=>"Хлебные крошки тест"
                                                ]
                                ]
                        ],                
                        [
                        "href"=>"#",
                        "index"=>10,
                        "ico"=>"fa fa-home fa-fw",
                        "name"=>" History 3"                            
                        ]
                    ]
]);    
Megamenu::Add([
    "href"=>"/config/index",
    "index"=>20,
    "ico"=>"fa fa-snowflake fa-fw",
    'title'=> "Настройка системы",
    "name"=>" Настройки"
]);    
Megamenu::Add([
    "href"=>"/user/logout",
    "index"=>30,
    "ico"=>"fa fa-home fa-fw",
    "name"=>" Выйти"
]);        