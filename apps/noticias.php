<div id="noticias" class="app">
    <h1>
        Not&iacute;cias 
        <span>
            <a href="#" class="lnk-minimizar">&nbsp;---&nbsp;</a> 
            <a href="#" class="lnk-remover">&nbsp;X&nbsp;</a>
        </span>
        <span class="refresh">
            <img title="Atualizar" alt="Atualizar"
                 src="<?echo LinkController::getBaseURL()?>/images/refresh.png"/>
        </span>
        <span class="refreshing-app" style="display: none">
            <img 
                src="<?echo LinkController::getBaseURL()?>/images/ajax-refresh-box.gif"/>
        </span>
    </h1>
    <div class="app-conteudo">
        <!--<p>
            Conte&uacute;do do aplicativo Not&iacute;cias
        </p>-->
        <?// include "core/News/news.php"?>
        <div class="loading-apps">
            <img src="<?echo LinkController::getBaseURL()?>/images/ajax-loading-apps.gif"/>
        </div>
        <div class="app-content-body">
            
        </div>
    </div>
</div>
