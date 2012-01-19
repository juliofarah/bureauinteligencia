var AdminAjax = function(){

    var api = {};
    
    api.save = function(url, data, noMessage){
        loading();
        $.post(url, data, function(response){
            if(noMessage == undefined)
                alert(response.message);
            if(response.status)
                refresh();
        },'json');
    };

    api.doDelete = function(url, data){
        loading();
        $.post(url, data, function(response){
            alert(response.message);
            if(response.status)
                refresh();
        }, 'json');
    };

    api.list_to_select = function(url,$select, data){        
        loadingSelect($select);
        if(data == undefined)
            data = {"nothing": "nothing"};
        $.get(url, data, function(jsonResponse){            
            if(jsonResponse != null){                
                $select.empty();
                $select.append("<option value=''></option>");
                $(jsonResponse).each(function(i, json){                    
                    $select.append("<option value='"+json.id+"'>"+json.name+"</option>");
                });
            }
        }, 'json');
    };

    api.saveWithFile = function($form, values){
        loading();        
        var options = {
            dataType: 'json',
            data: values,
            success: function(response){
                console.log(response);
                alert(response.message);
                if(response.status){
                   $form.clearForm();
                   $("#publication-file, #datacenter-spreadsheet").val('');
                }                
            }
        };        
        $form.ajaxSubmit(options);
    }

    var refresh = function(){
        $(location).attr("href", $(location).attr("href"));
    }

    var loading = function(){
        $(document).bind('ajaxStart', function(){
            $("#loading").show();
            $(this).css('cursor', 'wait');
            $(this).unbind('ajaxStart');
        }).bind('ajaxStop', function(){
            $("#loading").hide();
            $(this).css('cursor', 'default');
            $(this).unbind('ajaxStop');
        });
    }

    var loadingSelect = function($selectDOM){
        $selectDOM.ajaxStart(function(){
            $(this).attr("disabled", "disabled").html("<option value=''>Aguarde...</option>");
            $(this).unbind('ajaxStart');
        }).ajaxStop(function(){
            $(this).removeAttr("disabled");
            $(this).unbind('ajaxStop');
        });
        $selectDOM.unbind('ajaxStart');
    }

    return api;
};

