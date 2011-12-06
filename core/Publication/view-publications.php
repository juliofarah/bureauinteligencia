<?php
    require_once 'PublicationHandler.php';
    PublicationHandler::connect();
    $response = PublicationHandler::getAll(1);
?>
<div id="show-publications">
    <a class="openSearch" id="publication">Buscar publicações</a><br />
    <br />
    <?if($response->count() > 0):?>
        <?PublicationHandler::printList($response)?>
        <?foreach($response as $publication):?>                    
        <?endforeach?>
    <?endif?>
</div>