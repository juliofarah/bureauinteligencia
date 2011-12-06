<?php
    require_once '../core/Publication/PublicationController.php';
    require_once '../core/Publication/PublicationDao.php';
    require_once '../core/Publication/Publication.php';
    require_once '../core/Publication/Analyse.php';    
    require_once '../core/Publication/CommentDao.php';
    require_once '../core/Publication/Comment.php';
    
    $controller = new PublicationController(new PublicationDao(Connection::connect()));    
    $total = $controller->totalAnalysis();    
    $page = 1;
    if(isset ($_GET['page']))
        $page = $_GET['page'];    
    $pubs = $controller->listAllAnalysis($page);
    
    $hasNews = $pubs->count() > 0;    
?>
<?if($hasNews):?>
    <table class="list-publications">
        <thead>
            <tr>
                <th>Título</th>
                <th>Link</th>
                <th>Exclusão</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td></td><td></td><td></td>
            </tr>
        </tfoot>
        <tbody>
            <?foreach($pubs as $publication):?>
            <tr>
                <td><?echo $publication->title()?></td>
                <td>
                    <?echo $publication->link()?>
                </td>
                <td>
                    <a id="<?echo $publication->id()?>"
                       title="analysis" class="delete publication"
                       href="<?echo LinkController::getBaseURL()?>/admin/publication/delete">
                        excluir 
                    </a>
                </td>
            </tr>
            <?endforeach?>
        </tbody>
    </table>
<?endif?>
<div class="pagination">    
<?
    $link = "admin/analise/list/";
    echo "<br />".GenericHandler::prevPage($page, $link);
    echo " ".GenericHandler::pages($total, $page, PublicationController::$LIMIT_PER_PAGE, $link);
    echo " ".GenericHandler::nextPage($page, PublicationController::$LIMIT_PER_PAGE, $total, $link);
?>
</div>
<br />
<a href="<?echo LinkController::getBaseURL()?>/admin/publicacoes" class="link-goback">Voltar</a>