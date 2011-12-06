<?php
    require_once '../core/News/NewsController.php';
    require_once '../core/News/NewsDao.php';
    require_once '../core/News/NewRSS.php';
    require_once '../core/News/NewsHandler.php';

    $response = NewsHandler::getAll(1);  
    $total = NewsHandler::total();

    $link = "admin/news";
?>
<?if(NewsHandler::hasNews()):?>
    <table class="list-publications" id="table-rss-news">
        <thead>
            <tr>
                <th>Título</th>
                <th>Link RSS</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td></td><td></td><td></td>
            </tr>
        </tfoot>
        <tbody>
            <?foreach($response as $newRss):?>
            <tr id="<?echo $newRss->position()?>">
                <td><?echo $newRss->title()?></td>
                <td><?echo $newRss->link()?></td>
                <td>
                    <a id="<?echo $newRss->id()?>" class="delete"
                       href="<?echo LinkController::getBaseURL()?>/admin/news/delete">
                        excluir
                    </a>
                </td>
            </tr>
            <?endforeach?>
        </tbody>
    </table>
<?endif;?>
    
<?
    //echo "<br />".GenericHandler::prevPage(1, $link);
    //echo " ".GenericHandler::pages($total, 1, NewsController::$LIMIT_PER_PAGE, $link);
    //echo " ".GenericHandler::nextPage(1, NewsController::$LIMIT_PER_PAGE, $total, $link);
?>
<br />
<a href="<?echo LinkController::getBaseURL()?>/admin/noticias" class="link-goback">Voltar</a>