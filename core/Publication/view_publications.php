<?php
    require_once 'PublicationHandler.php';
    PublicationHandler::connect();        
?>
<div class="toolbars" style="border: 0 !important; padding-top: 0 !important;">
    <ul class="items-toolbars">
        <li title="analysis" type="content-publications">
            <a href="#analysis">Análises</a>
        </li>        
        <li title="papers" type="content-publications">
            <a href="#papers">Artigos</a>
        </li>
    </ul>
    <div class="content-of-tab content-publications" id="papers">
    <?include "view-papers.php"?>    
    </div>
    <div class="content-of-tab content-publications" id="analysis" style="/*display: none*/">
    <?if(Session::isLogged()):?>
        <?include "view-analysis.php"?>
    <?else:?>        
        <div class="must-do-login">
            Faça o login no sistema para ter acesso às Análises.<br />
            Se ainda não possui um cadastro,  
            <a href="<?echo LinkController::getBaseURL()?>/cadastro">Clique aqui</a>.
        </div>
    <?endif?>
    </div>    
</div>



