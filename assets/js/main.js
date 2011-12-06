$(document).ready(function(){

    /* 
     * ===========================
     * CONFIGURA ARRASTAR E SOLTAR
     * ===========================
     */

    var expire_time = 3600;

    $(".box-app").sortable({
        connectWith: ['.box-app'],
        placeholder: 'app-movimentacao',
        scroll: false,
        stop: function( e, ui ) {
            salvaCookie();
        }
    });

    var salvaCookie = function() {
        var ordem = $('#box-esquerdo').sortable('toArray');
        ordem += '|' + $('#box-meio').sortable('toArray');
        ordem += '|' + $('#box-direito').sortable('toArray');

        $.setCookie( 'Bureau_PosicaoApps', ordem, {
            duration : expire_time
        });
        
    };    

    /* 
     * ==============================
     * PROCESSAMENTO APPS MINIMIZADOS
     * ==============================
     */

    if ( $.readCookie('Bureau_AppsMinimizados') )
    {
        var apps = $.readCookie('Bureau_AppsMinimizados').split(',');
        
        if ( apps[0] != '0' ) 
        {
            for ( i = 0; i < apps.length; i++ )
            {                
                $('#'+apps[i] + ' .app-conteudo p').css("display","none");
                $('#'+apps[i] + ' h1 a.lnk-minimizar').html('&nbsp;+&nbsp;');
            }
        }

    }

    /* 
     * ==================================================================
     * FUNCAO PARA ATIVAR/DESATIVAR OS LINKS QUE CHAMA AS FUNCIONALIDADES
     * ==================================================================
     */

    var atualizaEstadoLinkApp = function() {
        $('.menu-apps ul li a').each(function(){
            var id = $(this).attr('id');
            id = id.split('-');
            id = id[1];
            var apps;
            if($.readCookie('Bureau_PosicaoApps') != null){
                apps = $.readCookie('Bureau_PosicaoApps').split('|');
            }else{
                apps = new Array("publicacoes,cotacoes", "meteorologia,videoteca", "noticias");
            }
            esquerdo = apps[0].split(',');
            meio     = apps[1].split(',');
            direito  = apps[2].split(',');

            if ( ($.inArray(id, esquerdo) != -1) || ($.inArray(id, meio) != -1) || ($.inArray(id, direito) != -1)) {
                $(this).addClass('desabilitado');
            }
            else {
                $(this).removeClass('desabilitado');
            }
            
        });
    }
    // FIM verificaLinksApps

    /* 
     * ===================================
     * ACOES BOTAO MINIMIZAR/MAXIMIZAR APP
     * ===================================
     */

    $('.lnk-minimizar').live('click', function(){
        // Seleciona o conteudo do APP clicado
        //mudar para children
        //var conteudoApp = $(this).parent().parent().parent().find('p');
        var conteudoApp = $(this).parents(".app").children(".app-conteudo").children();
		
        // Seleciona o id do APP
        var idApp = $(this).parent().parent().parent().attr('id');

        if( $(conteudoApp).is(':visible') )
        {
            $(this).parent("span").next(".refresh").hide();
            $(conteudoApp).slideUp();
            $(this).html('&nbsp;+&nbsp;');            
            salvaAppsMinimizados(idApp);            
        }
        else
        {   
            $(this).parent("span").next(".refresh").show();            
            $(conteudoApp).slideDown();
            $(this).html('&nbsp;---&nbsp;');            
            salvaAppsMaximizados(idApp);
            hideLoadingApps($(conteudoApp));
        }
        return false;
    });

    /* 
     * ===============================
     * DESABILITANDO ARRASTAR E SOLTAR
     * ===============================
     */

    $('.app h1 span').mouseover(function(){
        //$(".box-app" ).sortable( "option", "disabled", true );
        //$('.box-app h1').css('cursor','default');
    });
	
    $('.app h1 span').mouseout(function(){
        //$( ".box-app" ).sortable( "option", "disabled", false );
        //$('.box-app h1').css('cursor','move');
    });	    
	
    /* 
     * =======================
     * ACOES BOTAO REMOVER APP
     * =======================
     */
	
    $('.lnk-remover').live('click',function(){    
        $(this).parent().parent().parent().remove();
        var id = $(this).parent().parent().parent().attr('id');

        // REMOVENDO O APP DO COOKIE MINIMIZADOS
        var minis = $.readCookie('Bureau_AppsMinimizados');
        if(minis != null){
            var apps_min = $.readCookie('Bureau_AppsMinimizados').split(',');

            if ( apps_min.length == 1 && apps_min == id) {
                $.setCookie( 'Bureau_AppsMinimizados', '0', {
                    duration : expire_time
                });
            }
            else {
                apps_min = removeItem(apps_min, id);

                $.setCookie( 'Bureau_AppsMinimizados', apps_min, {
                    duration : expire_time
                });		
            }		            
        }else{
            var appsMin = new Array();
            appsMin.push(id);            
            appsMin = removeItem(appsMin, id);            
        }        
		
        // REMOVENDO O APP DO COOKIE POSICAO
        var apps_posicao = $.readCookie('Bureau_PosicaoApps').split('|');
		
        apps_posicao[0] = removeItem(apps_posicao[0].split(','), id); // esquerdo
        apps_posicao[1] = removeItem(apps_posicao[1].split(','), id); // meio
        apps_posicao[2] = removeItem(apps_posicao[2].split(','), id); // direito

        $.setCookie( 'Bureau_PosicaoApps', apps_posicao.join('|'), {
            duration : expire_time
        });

        atualizaEstadoLinkApp();
                
        return false;
    });

    /* 
     * ========================
     * ACOES PARA ADICIONAR APP
     * ========================
     */

    atualizaEstadoLinkApp();

    $('.menu-apps ul li a').live('click', function(){
        var id = $(this).attr('id');
        id = id.split('-');
        id = id[1];

        var apps = $.readCookie('Bureau_PosicaoApps').split('|');        
        
        esquerdo = apps[0].split(',');
        meio     = apps[1].split(',');
        direito  = apps[2].split(',');
        /*
        console.log("id = "+id);
        console.log(esquerdo);
        console.log($.inArray(id, esquerdo));
        console.log(meio);
        console.log(direito);
        */
        // SO ADICIONA AQUELES APPS QUE AINDA NAO ESTAO NA PAGINA DO USUARIO
        if ( ($.inArray(id, esquerdo) == -1) && ($.inArray(id, meio) == -1) && ($.inArray(id, direito) == -1)) {
            $('#carregando').css('display','block');
            //console.log($.readCookie('Bureau_AppsMinimizados'));
            // ADICIONA O ID DO APP NO COOKIE
            var apps_posicao = $.readCookie('Bureau_PosicaoApps');

            $.setCookie( 'Bureau_PosicaoApps', id+','+apps_posicao, {
                duration : expire_time
            });      

            //$(location).attr('href','http://www.ecafebr.com.br/bureau/');
            //alert($.readCookie('baseurl'));
            //console.log($.readCookie('Bureau_PosicaoApps'));
            atualizaEstadoLinkApp();
            $(location).attr('href', $.readCookie('baseurl'));
        }
        else {
            alert('Este aplicativo ja existe em sua pagina.');
        }

        atualizaEstadoLinkApp();
        
        return false;
    });

    /* 
     * =============================
     * FUNCOES PARA SALVAR NO COOKIE
     * =============================
     */

    var salvaAppsMinimizados = function(id_app) {

        var apps = $.readCookie('Bureau_AppsMinimizados');
        
        if ( apps == '0' ) {
            $.setCookie( 'Bureau_AppsMinimizados', id_app, {
                duration : expire_time
            });                                
        }
        else {
            apps = apps.split(',');
			
            // Se não existe no Cookie, salva.
            if ( $.inArray(id_app, apps) == -1 )
            {                
                if ( $.readCookie('Bureau_AppsMinimizados').length > 2) {
                    $.setCookie( 'Bureau_AppsMinimizados', $.readCookie('Bureau_AppsMinimizados') + ',', {
                        duration : expire_time
                    });                
                }

                $.setCookie( 'Bureau_AppsMinimizados', $.readCookie('Bureau_AppsMinimizados') + id_app, {
                    duration : expire_time
                });                    
            }
		
        }

    }

    var salvaAppsMaximizados = function(id_app) {

        var apps = $.readCookie('Bureau_AppsMinimizados').split(',');
						
        if ( apps.length == 1 && apps == id_app) {
            $.setCookie( 'Bureau_AppsMinimizados', '0', {
                duration : expire_time
            });
        }
        else {
            apps = removeItem(apps, id_app);

            $.setCookie( 'Bureau_AppsMinimizados', apps, {
                duration : expire_time
            });
        }
    }

    /* 
     * =============================================
     * FUNCAO AUXILIAR PARA REMOVER ITEM DE UM ARRAY
     * =============================================
     */

    var removeItem = function (originalArray, itemToRemove) {
        var j = 0;
        while (j < originalArray.length) {
            if (originalArray[j] == itemToRemove) {
                originalArray.splice(j, 1);
            } else {
                j++;
            }
        }
        return originalArray;
    }     

    /* 
     * =================================
     * CONFIGURA TRANSICAO IMAGENS APOIO
     * ==================================
     */

    $('#imgs-apoios').cycle({
        fx: 'scrollDown',
        speed:    300,
        timeout:  3000
    });

    $("a#save-config").live('click', function(){
        ajaxSavingConfigurations();
        $.post('perfil/positions/save', {
            'apps-position': $.readCookie('Bureau_PosicaoApps')
            }, function(data){
            alert(data.message);
        }, 'json');
        
        return false;
    });
    
    function ajaxSavingConfigurations(){
        $('body').ajaxStart(function(){
            $('#carregando').text("Salvando configurações...").css('display','block');
            $(this).css("cursor", "progress");
        }).ajaxStop(function(){            
            $('#carregando').css('display','none').text("Carregando...");
            $(this).css("cursor", "default");
            $(this).unbind('ajaxStart');
        });        
    }

    $("#change-rss").live('change', function(){
        changeVisualization($(this).val(), "news");
        return false;
    });

    $("#weather-city").live('change', function(){
        changeVisualization($(this).val(), "weather");
        return false;
    });

    openWindow();
    changeAba();
    showOrHideCotation();
    //getChartToMainPageFuturas();
    clickOverAMarketQuotation();    
    changePeriodOnChartWindow();
    forgetPassword();
    openNews();
    tabs();            
});
