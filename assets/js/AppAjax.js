var AppAjax = function(){

    var api = {};

    api.save = function(url, data){        
        loading();
        $.post(url, data, function(response){            
            alert(response.message);            
            if(response.status)
                refresh();
        },'json');
    };

    api.subscribeUser = function(url, data){
        loading();
        $.post(url, data, function(response){
           alert(response.message);
           if(response.status){
               $(location).attr("href", response.redirectTo);
           }
        });
    }
    
    api.getNewPassword = function(url, data, $div, $form){                
        $("span.message-response").remove();
        $div.append("<span class='message-loading'>Aguarde...</span>");
        $.post(url, data, function(response){          
            $("span.message-loading").remove();
            $div.append("<span class='message-response'>"+response.message+"</span>");            
            if(response.status){                
                $form.children("div").children("input").each(function(){
                   $(this).val(''); 
                });
            }
        }, 'json');
    }
    
    var refresh = function(){
        $(location).attr("href", $(location).attr("href"));
    }
    
    api.getMultiColumnXML = function(url, div){
        $.getJSON(url, {'no-must-online': true}, function(jsonResponse){        
            var chartBuilder = ChartBuilder();
            chartBuilder.buildMultiColumn(div, "386", "300", jsonResponse.xml);
        });
    }
    
    api.getLineXMLOfOneCotation = function(url, data, div){
        loading($("#"+div));
        $.getJSON(url, data, function(jsonResponse){
            if(jsonResponse.status){
                var chartBuilder = ChartBuilder();
                if(jsonResponse.futura)
                    chartBuilder.buildChandleChart(div, "600", "450", jsonResponse.xml);
                else
                    chartBuilder.buildSimpleLine(div, "600", "450", jsonResponse.xml);
            }else{
                $("#"+div).html("<span style='color: red'>"+jsonResponse.message+"</span>");
            }
        });
    }
          
    api.changeVisualization = function(url, data, $toChange){
        loading($toChange);
        $.get(url, data, function(toVisualization){
            $toChange.fadeOut('slow', function(){
                $(this).html(toVisualization).fadeIn('slow');
            });
        })
    };

    api.list_to_select = function(url,$select, data){
        loadingSelect($select);        
        if(data == undefined)
            data = {"nothing": "nothing"};
        $.get(url, data, function(jsonResponse){
            if(jsonResponse != null){
                $select.empty();
                $select.append("<option value='' class='all'>Todos</option>");
                $(jsonResponse).each(function(i, json){
                    $select.append("<option value='"+json.id+"'>"+json.name+"</option>");
                });
            }
        }, 'json');       
    };

    api.search = function(url, data, $appendTo){
        $appendTo.children("table").hide();
        $appendTo.children("#no-found").empty().hide();
        loadingSearchResutls($appendTo);
        $.get(url, data, function(response){
            var showResults = mapFunction();
            //console.log(functions[response.searchType]);
            if(response.status){                
                $appendTo.children("table").show();
                var results = showResults[response.searchType];
                results.showResults(response.message, $appendTo);
            }else{
                $appendTo.children("#no-found").html(response.message).show();
            }
        },'json');
    }

    var showSearchResults = function(results, $appendTo){
        $appendTo.empty();
        var html = "<ul>";
        $(results).each(function(i, obj){
           html += "<li>";
           html += obj.title + ' - ';
           obj.link != undefined ? html+= obj.link : html += '';
           obj.file != undefined ? html += obj.file.simplename : html += '';
           html += " <strong>Tema: "+obj.subarea.name+"</strong>";
           html += "</li>";
        });
        html += "</ul>";
        $appendTo.hide().append(html).fadeIn('slow');
    }
    
    var mapFunction = function(){
        var functions = new Array();
        functions["paper"] = showPaperResults();
        functions["video"] = showVideoResults();        
        functions["analysis"] = showAnalysisResults();
        return functions;
    }

    var showVideoResults = function (){
        var proccess = WindowProccessResults();
        return proccess.showVideoSearch();
    }

    var showPaperResults = function (){
        var proccess = WindowProccessResults();
        return proccess.showPaperSeach();
    }
    
    var showAnalysisResults = function(){
        var proccess = WindowProccessResults();
        return proccess.showAnalysisSearch();
    }
    
    var loadingSearchResutls = function($appendTo){
        $appendTo.ajaxStart(function(){
            $('html').css("cursor", "progress");
            $(this).addClass("searching");
            $(this).children("#wait-search").show();
        }).ajaxStop(function(){
            $('html').css("cursor", "default");
            $(this).removeClass("searching");
            $(this).children("#wait-search").hide();
            $(this).unbind('ajaxStart');
        });
    }

    var loading = function($divToChange){
        $('body').ajaxStart(function(){
            $(this).css("cursor", "wait");
            $('#carregando').css('display','block');
            if($divToChange != undefined){                
                loadingDiv($divToChange);
            }
            $(this).unbind('ajaxStart');
        }).ajaxStop(function(){
            $('#carregando').css('display','none');
            $(this).css("cursor", "default");
            $(this).unbind('ajaxStop');
        });
    }

    var loadingDiv = function($divToChange){
        $divToChange.empty().append('Carregando...');
    }

    var loadingSelect = function($select){        
        $select.ajaxStart(function(){
            $(this).attr("disabled", "disabled").html("<option value=''>Aguarde...</option>");            
        }).ajaxStop(function(){
            $(this).removeAttr("disabled");
            $(this).unbind('ajaxStart');
        });        
    }
    
    return api;
};

