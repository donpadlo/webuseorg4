<?php
use Application\View\Helper\Megamenu;
Megamenu::Add([
        "href"=>"#",
        "index"=>10,
        "ico"=>"fa fa-home fa-fw",
        "name"=>" Our work"
]);    
Megamenu::Add([
    "href"=>"",
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
                                            [   "href"=>"#",
                                                "ico"=>"fa fa-home fa-fw",
                                                "name"=>" History 2-2",
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
    "href"=>"#",
    "index"=>20,
    "ico"=>"fa fa-home fa-fw",
    "name"=>" Services"
]);    
Megamenu::Add([
    "href"=>"#",
    "index"=>30,
    "ico"=>"fa fa-home fa-fw",
    "name"=>" Logout"
]);        