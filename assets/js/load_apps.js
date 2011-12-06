function loadApp(appsToShow){    
    var commands = command();
    $(appsToShow).each(function(i, app){
        if(app != null && app != '' && app != undefined)            
            commands[app].execute();
    });
}

var command = function(){
    var commands = new Array();   
    commands["publicacoes"] = loadPublications();
    commands["cotacoes"] = loadCotacoes();   
    commands["noticias"] = loadNoticias();
    commands["videoteca"] = loadVideoteca();
    commands["metereologia"] = loadMeteorologia();
    commands["datacenter"] = loadDatacenter();    
    return commands;
}

var loadDatacenter = function(){
    var api = {};
    api.execute = function(){
        ajaxLoad($("#datacenter"), "datacenter");
    }
    return api;
}

var loadPublications = function(){
    var api = {};
    api.execute = function(){
        ajaxLoad($("#publicacoes"), "publications");
    }        
    return api;
}

var loadCotacoes = function(){
    var api = {};
    api.execute = function(){
        ajaxLoad($("#cotacoes"), "quotations");
    }
    return api;
}

var loadNoticias = function(){
    var api = {};
    api.execute = function(){        
        ajaxLoad($("#noticias"), "news");
    }
    return api;
}

var loadVideoteca = function(){
    var api = {};
    api.execute = function(){
        ajaxLoad($("#videoteca"), "video");
    }
    return api;
}

var loadMeteorologia = function(){
    var api = {};
    api.execute = function(){
        ajaxLoad($("#metereologia"), "weather");
    }
    return api;
}

var ajaxLoad = function ajaxLoad($domElement, toLoad){
    var data = {
        'no-must-online': true,
        'toLoad': toLoad
    }
    $.get("load", data, function(response){        
        var $domContent = $domElement.children(".app-conteudo");
        $domContent.children("div.loading-apps").hide();
        var toAppend = $(response).children(".app-conteudo").children(".app-content-body").html();
        $domContent.children(".app-content-body").append(toAppend);
        if($domElement.attr("id") == "cotacoes" || $domElement.attr("id") == "publicacoes"){
            tabs();
        }        
    });
}