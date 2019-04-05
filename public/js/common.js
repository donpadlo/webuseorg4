function RefreshQuickMenu(menu){
    $("#user_quick_menu_div").html("");
    ht="";
    menu.forEach(function(entry) {
        console.log(entry);
        ht=ht+"<button title='"+entry.title+"' type=\"button\" class=\"btn btn-outline-dark btn-sm\"><a class='displaycontent' href='"+entry.href+"'><i class='"+entry.ico+"'></i></a></button>";
    });
    $("#user_quick_menu_div").html(ht);
};
/**
 * Добавить/удалить ссылку в "быстрое меню"
 * @return {undefined}
 */
function AddSubQuickMenu(cururl){    
    $.post('/server/savequickmenu',{
        url:cururl
    }, function(data){        
        if (data.result==true){
            RefreshQuickMenu(data.menu);
            $().toastmessage('showSuccessToast', data.message);
        } else {
            $().toastmessage('showWarningToast', data.message);            
        };        
    });
}