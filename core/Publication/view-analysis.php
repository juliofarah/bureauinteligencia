<?php
    require_once 'CommentDao.php';
    require_once 'Comment.php';
    $response = PublicationHandler::getAllAnalysis(1);
?>
<div class="show-publications" id="show-analysis">    
    <?if($response->count() > 0):?>
        <?PublicationHandler::printListAnalysis($response)?>
    <?endif?>
    <a class="openSearch" id="analysis">Buscar Análises</a>
</div>