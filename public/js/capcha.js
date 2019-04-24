jQuery.fn.Capcha = function(options) {      
            // воспользуемся расширением extend чтобы иметь "настройки по умолчанию"
            var settings = $.extend( {
                  'caption'         : 'Заголовок по умолчанию'                  
                }, options);    
            console.log(settings);              
            tag=this;
            // не посредственно работа плагина
            $.post("/server/capcha",{
		comand:"getcapcha",
	    }, function(data){
                if (data.capcha==1){
                  console.log("--нужно спрашивать капчу..");  
                  ht="";
                  ht=ht+"<label for='login_passord'>"+settings.caption+"</label>\n";
                  ht=ht+"<input type='text' class='form-control' id='capcha' name='capcha' placeholder='"+settings.caption+" "+data.capchavalue+" цифрами'\>\n<br/>";
                  tag.html(ht);
                };
                console.log(data);
            });                         
            return this;   
};