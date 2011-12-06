var EmailAjax = function(){
    var api = {};
    
    api.send = function(email, $div){
        if($div != undefined)
            loading($div);
        $.post(email.url, email.contents, function(response){
            $div.children("#box-mailto").append("<span class='email_response email_"+response.status+"'>"+response.message+"</span>");
            $div.children("#box-mailto").children("form").find("input").val(null);            
        }, 'json');
    }    
    
    var loading = function($div){
        $div.children("#box-mailto").children("span").remove();
        $div.ajaxStart(function(){
           $(this).css("cursor", "wait");
           $(this).children("#box-mailto").hide();
           $(this).children("#sending-mailto").show();
        }).ajaxStop(function(){
            $(this).css("cursor", "default");
            $(this).children("#sending-mailto").hide();
            $(this).children("#box-mailto").show();
            $(this).unbind('ajaxStart');
        });      
    }
    
    return api;
}

