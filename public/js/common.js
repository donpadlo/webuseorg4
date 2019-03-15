$(document).ready(function() {           
		$('#menu').mmenu({
			"extensions": [
                  "fx-menu-zoom",
                  "fx-panels-zoom"
               ],
                "counters": true,
                "iconbar": {
                  "add": true,
                  "top": [
                     "<a href='#/'><i class='fa fa-home'></i></a>",
                     "<a href='#/'><i class='fa fa-home'></i></a>",
                     "<a href='#/'><i class='fa fa-home'></i></a>",
                     "<a href='#/'><i class='fa fa-home'></i></a>",
                     "<a href='#/'><i class='fa fa-home'></i></a>",
                     "<a href='#/'><i class='fa fa-home'></i></a>",
                     "<a href='#/'><i class='fa fa-home'></i></a>",
                     "<a href='#/'><i class='fa fa-home'></i></a>",
                     "<a href='#/'><i class='fa fa-home'></i></a>",
                     "<a href='#/'><i class='fa fa-user'></i></a>"
                  ],
                  "bottom": [
                     "<a href='#/'><i class='fa fa-twitter'></i></a>",
                     "<a href='#/'><i class='fa fa-facebook'></i></a>",
                     "<a href='#/'><i class='fa fa-linkedin'></i></a>"
                  ]
               },                
                "navbars": [
                      {
                         "position": "top",
                         "content": [
                            "searchfield"
                         ]
                      },
                      {
                         "position": "bottom",
                            "content": [
                               "<a class='fa fa-envelope' href='#/'></a>",
                               "<a class='fa fa-twitter' href='#/'></a>",
                               "<a class='fa fa-facebook' href='#/'></a>"
                            ]
                      }
                   ],               
		
		
			navbar: {title: 'Меню', panelTitle: 'Меню'},
			onClick: {
				setSelected: true,
				close: false
			}
		});                		
});