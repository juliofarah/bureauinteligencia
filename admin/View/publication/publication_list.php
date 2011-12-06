<?php
    require_once '../core/Publication/PublicationController.php';
    require_once '../core/Publication/PublicationDao.php';
    require_once '../core/Publication/Publication.php';
    require_once '../core/Publication/Paper.php';
    require_once '../core/Publication/File.php';
    
    $controller = new PublicationController(new PublicationDao(Connection::connect()));    
    $total = $controller->totalPapers();        
    $page = 1;
    if(isset ($_GET['page'])){
        $page = $_GET['page'];
    }
    $pubs = $controller->listAllPapers($page);
    
    $hasNews = $pubs->count() > 0;    
?>
<div id="list-results">    
<?if($hasNews):?>
    <table class="list-publications">
        <thead>
            <tr>
                <th>Título</th>
                <th>Link Arquivo</th>
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
                    <a href="<?echo LinkController::getBaseURL()?>/publicacao/<?echo $publication->getSimpleFilename()?>">
                        <?echo $publication->getSimpleFilename();?>
                    </a>
                </td>
                <td>
                    <a id="<?echo $publication->id()?>"
                       title="paper" class="delete publication"
                       href="<?echo LinkController::getBaseURL()?>/admin/publication/delete">
                        excluir - <?echo $publication->id()?>
                    </a>                    
                </td>
            </tr>
            <?endforeach?>
        </tbody>
    </table>
<?endif?>
</div>
<div class="pagination">
<?
    $link = "admin/artigos/list/";
    echo "<br />".GenericHandler::prevPage($page, $link);
    echo " ".GenericHandler::pages($total, $page, PublicationController::$LIMIT_PER_PAGE, $link);
    echo " ".GenericHandler::nextPage($page, PublicationController::$LIMIT_PER_PAGE, $total, $link);
?>
</div>
<br />
<a href="<?echo LinkController::getBaseURL()?>/admin/publicacoes" class="link-goback">Voltar</a>