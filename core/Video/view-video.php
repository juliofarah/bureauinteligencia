<?php
    require_once 'VideoHandler.php';
    VideoHandler::connect();
    $response = VideoHandler::getAll(1);
?>
<div id="show-videos">       
    <?if($response->count() > 0):?>
    <ul id="video-list">
    <?$maxVideos = 3;?>
    <?$videoIterator = $response->getIterator();?>
    <?while($videoIterator->valid() && $maxVideos-- >= 0):?>
        <li>
            <div class="img-video">
                <a target="_blank" href="http://www.youtube.com/watch?v=<?echo $videoIterator->current()->link()?>">
                    <img src="http://img.youtube.com/vi/<?echo $videoIterator->current()->link()?>/default.jpg"/>
                </a>
            </div>
            <div class="video-description">
                <h1>
                    <a target="_blank" href="http://www.youtube.com/watch?v=<?echo $videoIterator->current()->link()?>">
                        <?echo $videoIterator->current()->title()?>
                    </a>
                </h1>
                <?
                //$tags = get_meta_tags('http://www.youtube.com/watch?v=xRffJ7GP6Ww');
                //echo $tags['description'];
                ?>
            </div>
        </li>
        <?$videoIterator->next();?>
    <?endwhile;?>
    </ul>
    <a class="openSearch" id="video">Buscar videos</a><br />
    <?else:?>
    Nenhum video encontrado
    <?endif?>
</div>
