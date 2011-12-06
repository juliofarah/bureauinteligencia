<?php
    /*require_once '../core/Video/VideoController.php';
    require_once '../core/Video/VideoDao.php';
    require_once '../core/Video/Video.php';*/
    require_once '../core/Video/VideoHandler.php';

    VideoHandler::connect();
    $page = 1;
    if(isset ($_GET['page'])){
        $page = $_GET['page'];
    }    
    $response = VideoHandler::getAll($page);    
    $total = VideoHandler::total();
?>
<?if($response->count() > 0):?>
    <table class="list-publications">
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
            <?foreach($response as $video):?>
            <tr>
                <td><?echo $video->title()?></td>
                <td><?echo $video->link();?></td>
                <td>
                    <a class="delete" id ="<?echo $video->id();?>"
                       href="<?echo LinkController::getBaseURL()?>/admin/video/delete">
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
    $link = "admin/videos/list/";
    echo "<br />".GenericHandler::prevPage($page, $link);
    echo " ".GenericHandler::pages($total, $page, VideoController::$LIMIT_PER_PAGE, $link);
    echo " ".GenericHandler::nextPage($page, VideoController::$LIMIT_PER_PAGE, $total, $link);
?>
</div>
<br /><br />
<?
/*    require_once '../core/SearchEngine/SearchEngine.php';

    $array = array("subarea" => 2);
    $iterator = new ArrayIterator($array);
    $search = new SearchEngine(VideoHandler::$CONNECT);
   echo $search->search("video", $iterator);*/
?>
<br />
<a href="<?echo LinkController::getBaseURL()?>/admin/videos" class="link-goback">Voltar</a>