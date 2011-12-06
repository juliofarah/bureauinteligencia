function eventSortableList(){
    $("#table-rss-news tbody").sortable({        
        start: function(event, ui){
            var $item = ui.item;
            $item.addClass("highlight");
        },
        stop: function(event, ui){            
            var $item = ui.item;
            $item.removeClass("highlight");
            updateIndexs($item);           
        }        
    });
    $( "#table-rss-news tbody" ).disableSelection();
}

function updateIndexs($item){
    var $table = $item.parents("table");
    var url = $item.children("td").children("a.delete").attr("href").replace("delete","update/index");
    var arrayIndex = new Array();    
    var arrayIdRss = new Array();
    $table.children("tbody").children("tr").each(function(){
        var idRss = $(this).children("td").children("a.delete").attr("id");
        arrayIndex.push($(this).index() + 1);
        arrayIdRss.push(idRss);        
    });
    sendUpdatedOrder(arrayIndex, arrayIdRss, url);
}

function sendUpdatedOrder(indexes, ids, url){    
    var request = AdminAjax();
    request.save(url, {"ids": ids, "indexes": indexes}, true);
}

function eventDelete(){
    $("a.delete").click(function(){
        if(confirm("Este registro será excluído do sistema. Clique em 'Ok' para continuar.")){
            var url = $(this).attr("href");
            var data = {"id" : this.id};
            if($(this).hasClass("publication")){
                data.type = $(this).attr("title");
            }
            var request = AdminAjax();
            request.doDelete(url, data);
        }
        return false;
    });
}

function eventInsert(){    
    $(".button-insert, .button-insert-analysis").click(function(){                        
        var $form = $(this).parents("form");
        var isValid = valid($form);        
        removeErrors($form);
        submitIfIsValid($form, isValid);
        return false;
    });
}

function eventInserPublication(){
    $(".button-insert-paper").click(function(){
        var $form = $(this).parents("form");
        removeErrors($form);
        var validResponse = valid($form);
        if(validResponse.valid){            
            var data = {
                "title": $("#title").val(),
                "subarea":$("#subarea").val(),
                'state': $("#state").val(), 
                'year': $("#publication-year").val(),
                'publication_type': $("#publicationType").val(),
                'type_event': $("input[name=type_event]:checked").val()                
            };
            var request = AdminAjax();
            request.saveWithFile($form, data);
        }else{            
            var inputsErrors = errorsMessages();            
            $(validResponse.inputs).each(function(i,item){
                if($(item).attr("type") == 'file'){
                    //$(item)
                }
                $(item).addClass("error");
                var type = $(item).attr("type").toString();                
                $(item).next("div.erro").html(inputsErrors[type]);
            })
        }
        return false;
    });
}

function textFieldCharLimits(){
    var limit = 0;
    $("input.charLimits").keyup(function(e){
        var totalChars = $(this).val().length;
        var maxLength = parseInt($(this).attr("maxlength"));
        if(totalChars < maxLength){           
            limit--;
            var thisid = "#"+this.id;
            //var current = parseInt($(thisid+"-char").val());
            $(thisid+"-char").text(limit);
        }
    }).focus(function(){        
        limit = Number($(this).attr("maxlength")) - $(this).val().length;
    });
}

var removeErrors = function($form){
    $("div.erro").empty();
    $("#"+$form.attr("id") + " input").removeClass("error");
    $("#"+$form.attr("id") + " select").removeClass("error");
}

var errorsMessages = function(){
    var messages = new Array();
    messages["text"] = "Valor Inválido";
    messages["file"] = "Valor Inválido ou não é um Arquivo PDF";
    messages["select-one"] = "Selecione uma opção";
    return messages;
}

function submitIfIsValid($form, isValid){
    if(isValid.valid){
        var data = {
            'link': $("#link").val(),
            'title': $("#title").val(),
            'state': $("#state").val(), 
            'type_event': $("input[name=type_event]:checked").val()
        }
        if($form.attr("id") != 'form-news'){            
            data.subarea = $("select#subarea").val();
        }
        if($form.attr("id") == 'form-video'){
            data.duration = $("#duration").val();
        }
        if($form.hasClass("analysis")){
            if($("#text").val() == ''){
                alert('O campo texto não deve estar vazio!');
                return false;
            }
            data.text = $("#text").val()
        }
        
        var request = AdminAjax();
        request.save($form.attr("action"), data);
    }else{
        var errorMessages = errorsMessages();
        $(isValid.inputs).each(function(i, item){
            $(item).addClass("error");
            $(item).next("div.erro").html(errorMessages[$(item).attr("type")]);
        });
    }
}

function listAreasToSelect(){
    if($("select#area").html() != null){        
        if(!$("select#area").hasClass("area_analysis")){
            var request = AdminAjax();        
            request.list_to_select("../admin/area", $("select#area"), {'no-must-online': true});
            eventChangeToArea();            
        }
    }
}

function listStatesToSelect(){
    if($("select#state").html() != null){
        var request = AdminAjax();        
        request.list_to_select("../admin/state", $("select#state"), {'no-must-online': true});
    }
}

function listPublicationTypesToSelect(){
    if($("select#publicationType") != null){
        var request = AdminAjax();
        request.list_to_select("../admin/publicationTypes", $("select#publicationType"), {'no-must-online':true});
    }
}

function eventChangeToArea(){
    $("select#area").live("change", function(){
        if($(this).val() != '' && !$(this).hasClass("area_analysis")){
            var request = AdminAjax();
            request.list_to_select("../admin/subarea", $("select#subarea"), {'area': $(this).val(), 'no-must-online': true});
        }else{
            $("select#subarea")
                .attr("disabled","disabled")
                .html("<option value=''>Selecione uma área</option>");
        }
    });
}


function valid($form){
    var id = "#"+$form.attr("id");
    var isvalid = true;
    var invalid_inputs = new Array();

    $(id + " input, select").each(function(i, obj){
        if(obj.value == ''){
            isvalid = isvalid && false;
            invalid_inputs.push("#"+obj.id);
        }else{
            if(obj.type == "file"){
                var file = $(this).val();
                var indexA = file.length-4;
                var indexB = file.length;
                var toVerify = file.substring(indexA, indexB).replace(".","");
                if(!canInsertThisFileExtension(toVerify)){
                    isvalid = isvalid && false;
                    invalid_inputs.push("#"+obj.id);
                }
            }
        }

    });
    return {
        "valid": isvalid,
        "inputs": invalid_inputs
    }
}

var canInsertThisFileExtension = function(string){
    var fileExtensionsAllowed = new Array("pdf");
    return (fileExtensionsAllowed.indexOf(string, 0) != -1);
}