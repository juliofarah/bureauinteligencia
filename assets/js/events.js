var iteractionsHanoy = 0;
function hanoi(disc, src, aux, dst) {    
    if (disc > 0) {
        iteractionsHanoy++;        
        hanoi(disc - 1, src, dst, aux);
        console.log('Move disc ' + disc +
                ' from ' + src + ' to ' + dst);        
        hanoi(disc - 1, aux, src, dst);
    }
}

function printAnalysis(){
    $("#print").click(function(){
        $(".content-analysis").jqprint({operaSuport: true});
        return false; 
    });
}

function openMailDialog(){
    $("#openMailDialog").click(function(){
        $("#div-mailto").children("#box-mailto").children("span").remove();
        var window = Window.New();        
        window.divName = "#div-mailto";
        window.title = "Enviar email";
        window.renderDialogWithForm();        
    });
    sendAnalysisToEmail();
}

function sendAnalysisToEmail(){
    $("#sendEmail").click(function(){
        var email = {};
        email.url = "../analysis/send/email";
        email.contents = {to: "", link: "", name_to: ""};
        email.contents.to = $("#to").val();                
        email.contents.link = $(this).attr("title");
        email.contents.name_to = $("#name-to").val()
        var requestEmail = EmailAjax();
        requestEmail.send(email, $("#div-mailto"));
        return false;
    });
}

function loadingApps(qtdAppsLoaded){
    var appsToShow = getAppsToRefresh();  
    var lengthAppsToShow = 0;    
    for(var i = 0; i < appsToShow.length; i++){
        if(appsToShow[i] != null && appsToShow[i] != '')
            lengthAppsToShow++;
    } 
    if(qtdAppsLoaded == lengthAppsToShow){
        loadApp(appsToShow);
        refreshBox();
        refreshAll();
        refreshSomeAppsInInterval(appsToShow);
    }
}

function getAppsToRefresh(){
    var appsToShow = new Array();   
    var apps = $.readCookie('Bureau_PosicaoApps');
    apps = apps.split("|");    
    for(var i = 0; i < apps.length; i++){    
        var oneApp = apps[i].split(",");
        for(var j = 0; j < oneApp.length; j++){
            appsToShow.push(oneApp[j]);
        }
    }
    return appsToShow;
}

function nameOfTheAppstoRefreshInAnInterval(){
    var appsToRefresh = new Array();
    appsToRefresh.push("cotacoes");    
    return appsToRefresh;
}

function refreshSomeAppsInInterval(appsToLoad){
    var nameOfAppsToRefresh = nameOfTheAppstoRefreshInAnInterval();
    var appsToRefreshInIntervals = new Array();
    for (var i = 0; i < appsToLoad.length; i++){
        if(appsToLoad[i] != null && appsToLoad[i] != ''){
            if(nameOfAppsToRefresh.indexOf(appsToLoad[i]) != -1)
                appsToRefreshInIntervals.push(appsToLoad[i]);
        }
    }
    refreshIntervalApp(appsToRefreshInIntervals);
}

function refreshIntervalApp(apps){    
    var time = 900 * 1000;
    var interval = setInterval(function(){
        resetAppsBox(apps);
        loadApp(apps);
    }, time);
}

function refreshAll(){
    $("#updateAll").click(function(){
        unbindRefreshUntilRefreshFinish($(this));
        var appsToRefresh = getAppsToRefresh();
        resetAppsBox(appsToRefresh);
        loadApp(appsToRefresh);            
    });
}

function unbindRefreshUntilRefreshFinish($clicked){
    $clicked.ajaxStart(function(){
        $(this).hide();
        $("#ajaxRefreshGif").show();
    }).ajaxStop(function(){
        $(this).show();
        $("#ajaxRefreshGif").hide();
        $(this).unbind('ajaxStart');       
    });
}

function resetAppsBox(appsToReset){
    for(var i = 0; i < appsToReset.length; i++){
        var id = appsToReset[i];
        $("#"+id).children(".app-conteudo").children(".app-content-body").empty();
        $("#"+id).children(".app-conteudo").children("div.loading-apps").show();
    }
}

function refreshBox(){
    $("span.refresh").live('click', function(){
        ajaxLoadingWhileOneBoxeIsUpdated($(this));
        var appToShow = new Array();
        var id = $(this).parents(".app").attr("id");
        $("#"+id).children(".app-conteudo").children(".app-content-body").empty();
        $("#"+id).children(".app-conteudo").children("div.loading-apps").show();
        appToShow.push(id);        
        loadApp(appToShow);
    });
}

function ajaxLoadingWhileOneBoxeIsUpdated($span){
    $span.ajaxStart(function(){
       $(this).hide();
       $(this).next().show();
    }).ajaxStop(function(){
        $(this).unbind("ajaxStart");
        $(this).next().hide();
        $(this).show();
    });
}

function hideLoadingApps(conteudoApp){ 
    $(conteudoApp[0]).hide();
}

function tabs(){
    $("div.toolbars").tabs();
}

function openNews(){
    $("a.news-rss").live('click', function(){
        window.open($(this).attr("href"), "disclaimer","scrollbar = yes, status = 0, scrollbars=1, resizable = no, height = 750, width = 920, top = 140, left, 230");
        return false; 
    });
}

function forgetPassword(){
    getNewPasswordForgettable();
    $("a#forget-pass").click(function(){        
        var window = Window.New(400, 250, {"top": 0, "left":400});
        window.title = "Esqueci minha senha";        
        window.divName = "#window-forgetPassword";
        window.content = "ramonox";
        window.renderDialogWithForm();
        return false;        
    });
}

function getNewPasswordForgettable(){
    $("#get-new-pass").click(function(){        
        var url = $(this).parents("form").attr("action");
        var request = AppAjax();
        var data = {
            "no-must-online":true,
            "email" : $("#f-email").val(),
            "username" : $("#f-username").val()
        }        
        request.getNewPassword(url, data, $("#window-forgetPassword"), $(this).parents("form"));
        return false;
    });
}

function clickOverAMarketQuotation(){
    $(".open-chart-window").live('click', function(){
        var type = $(this).parents(".content-cotations").attr("id");
        
        var id = $(this).parents(".cotation-values").attr("id");        
        var request = AppAjax();
        //request.getMultiColumnXML("mainMultiColumn", "window-cotation");
        
        var window = Window.New(700, 550);
        window.divName = "#window-cotation";
        window.title = "Gráfico de Cotação";
        //window.content = "<div class='period'>períodão</div><br />";
        window.content = buildFormForChartPeriod(id, type);
        var div_of_chart = "<div id='div_of_chart'></div>";
        if(type == 'futuras')
            window.renderSimpleDialogForChartOfQuotation(request, id, div_of_chart, "#div_of_chart", "quotations/futuras/storaded");
        else
            window.renderSimpleDialogForChartOfQuotation(request, id, div_of_chart, "#div_of_chart", "quotations/storaged");
    });
}

function buildFormForChartPeriod(id_quotation, type){
    var html = 
            "<div class='period'>";
    html +=     "<form action=''>";
    html +=         "<label>Selecione um período: </label>";
    html +=         "<select id='period' alt='"+id_quotation+"' class='"+type+"'>";
    html +=             "<option value=''></option>";
    html +=             "<option value='6'>6 meses</option>";
    html +=             "<option value='3'>3 meses</option>";
    html +=             "<option value='1'>1 mês</option>";
    html +=         "</select>";
    html +=     "</form>";
    html += "</div><br />";
    return html;
}

function changePeriodOnChartWindow(){
    $("select#period").live('change', function(){
        var type = $(this).attr("class");
        var id_quot = $(this).attr("alt");
        var request = AppAjax();
        var id_div_chart = "#div_of_chart";
        var data = {
            'no-must-online':true, 
            'quotation': id_quot, 
            "period": $(this).val()
        };
        if(type == 'futuras')
            request.getLineXMLOfOneCotation("quotations/futuras/storaded", data, id_div_chart.replace("#", ""));
        else
            request.getLineXMLOfOneCotation("quotations/storaged", data, id_div_chart.replace("#", ""));
    });
}

function changeVisualization(id, type){
    var url, $domElement;
    
    var data = {'no-must-online': true, 'id': id};

    switch(type){
        case 'news':
            url = "rss/change";
            $domElement = $("#news-items");
        break;
        case 'weather':
            url = "weather/change";
            $domElement = $(".painel-weather");
        break;
    }
    var request = AppAjax();
    request.changeVisualization(url, data, $domElement);

}

function openWindow(){
    $("a.openSearch").live('click', function(){
        window.open("search/"+this.id, "disclaimer","scrollbar = yes, status = 0, resizable = no, height = 700, width = 870, top = 140, left, 230");
    });
}

function changeSearchParams(){
    $("select.params, #beginDate, #endDate").change(function(){        
        search($(this));
    });
    $("#title").blur(function(){
        //if($(this).val() != '')
        search($(this));
    });
}

function search($domObject){
    var selectedParams = new Array();
    var paramsSetted= new Array();
    var paramsValues = new Array();                

    selectedParams = groupNameAndValuesOfParamsThatWasChecked();

    var data = setParamsToSeachEngine(selectedParams, paramsSetted, paramsValues);
    var baseUrl = $("#form-searchParams").attr("action");
    var url = baseUrl + "/find/related";

    var request = AppAjax();
    request.search(url, data, $("#search-result-content"));

    if(selectedParams.hasOwnProperty("area"))
        writeOnChildSelect(request, $domObject);
    else{
        $("#subarea").html("");
    }
}

function groupNameAndValuesOfParamsThatWasChecked(){
    var selectedParams = new Array();
    $("select.params, input").each(function(){ 
        if($(this).val() != null && $(this).val() != ''){
            selectedParams[this.id] = this.value;
        }
    });
    return selectedParams;
}

function setParamsToSeachEngine(selectedParams, paramsSetted, paramsValues){
    if(sizeOfAHash(selectedParams) > 0){
        for(var index in selectedParams){
            paramsSetted.push(index);
            paramsValues.push(selectedParams[index]);
        }        
        var data = {
            "paramsSetted":paramsSetted,
            "paramsValues":paramsValues
        }            
    }else{
        var data = {
            "paramsSetted": new Array(true),
            "paramsValues": new Array(true)
        }
    }    
    return data;
}

function sizeOfAHash(hash){
    var size = 0;
    for(var i in hash){
        size++;
    }
    return size;
}

function listStatesToSelect(){
    if($("select#state").html() != null){
        var request = AppAjax();
        request.list_to_select("admin/state", $("select#state"), {'no-must-online': true});
    }
}

function listCityToSelect($select){
    if($select != null){
        $("select#state").live('change', function(){
            if($(this).val() != ''){           
               var request = AppAjax();
               request.list_to_select("../cities", $select, {'no-must-online': true, 'state': $(this).val()});                
            }
        });
        removeOptionTodosFromSelect($select);
    }    
}

function listActivitiesToSelect($select){
    if($select != null){
        var request = AppAjax();
        request.list_to_select("../activities", $select, {'no-must-online': true});
    }
    removeOptionTodosFromSelect($select);
}

function removeOptionTodosFromSelect($select){
    $select.ajaxStop(function(){
        $(this).children("option:first")
        .removeAttr("disabled")
        .removeClass("all").text("");
    });
}

function writeOnChildSelect(request, $obj){    
    switch($obj.attr("id")){
        case 'area':
            changeSearchParamArea(request, $obj);
        break;
        case 'subarea':
            return;
        break;
    }
}

function changeSearchParamArea(request, $obj){    
    request.list_to_select("search/subarea", $("select#subarea"), {'area': $obj.val()})
}

function changeAba(){
    $("ul.items-toolbar li").click(function(){        
        $(this).parent().children("li").removeClass("item-selected");        
        $(this).addClass("item-selected");
        $("."+$(this).attr("type")).hide();
        $("#"+$(this).attr("title")).show();
    }).hover(function(){
        $(this).css("background-color","#FFF");
    }, function(){
        $(this).css("background-color", "transparent");
    });
}

function showOrHideCotation(){
    $("div.title-cot").live('click', function(){
        var $this = $(this);
        if($(this).next("table").is(":visible")){            
            $(this).next("table").slideUp("fast", function(){
                $this.addClass("table-hidden");
            });            
        }else{
            $(this).next("table").slideDown("fast", function(){
               $this.removeClass("table-hidden"); 
            });            
        }
    })
}

function getChartToMainPageFuturas(){
    var request = AppAjax();
    request.getMultiColumnXML("mainMultiColumn", "chart-futuras");
}

function postComment(){
    $("button.button-comment").click(function(){
        if($("#title").val() != null && $("#comment").val()){
            var url = $(this).parents("form").attr("action");                                  
            var urlInfos = getIdOfAnalysis(url);
            url = url.replace(urlInfos.toSub, "");                               
            var data = {
                'title': $('#title').val(),
                'text': $("#comment").val(),
                'analysis_id': urlInfos.id 
            };
            var request = AppAjax();
            request.save(url, data);
        }else{
            
        }
        return false;
    });
}

function getIdOfAnalysis(url){
    var pos = url.search("{");   
    return {
        'id': url.substr(pos+1, 1),
        'toSub': url.substr(pos, 4)
    }
}

function submitSubscribe(){    
    $("#submit-subscribe").click(function(){        
        var $form = $(this).parents("form");
        var isValid = valid($form);                
        removeErrors($form);
        submitIfIsValid($form, isValid, true);
        return false;
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
    messages['password'] = 'Senha não pode estar vazia';
    messages["file"] = "Valor Inválido ou não é um Arquivo PDF";
    messages["select-one"] = "Selecione uma opção";
    return messages;
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

function submitIfIsValid($form, isValid, login){
    if(isValid.valid){
        var data = {
            'name': $("#name").val(),
            'username': $("#username").val(),
            'email': $("#email").val(),
            'password': $("#password").val(),
            'confirm_password' : $("#confirm-password").val(),
            'city': $("#city").val(), 
            'activity': $("#activity").val()
        }
        if($("#password").val() != $("#confirm-password").val()){
            alert('As senhas informadas não conferem');
        }else{
            var request = AppAjax();
            if(login != undefined){
                request.subscribeUser($form.attr("action"), data);
            }else{
                request.save($form.attr("action"), data);            
            }
        }
    }else{
        var errorMessages = errorsMessages();
        $(isValid.inputs).each(function(i, item){
            $(item).addClass("error");
            $(item).next("div.erro").html(errorMessages[$(item).attr("type")]);
        });
    }
}