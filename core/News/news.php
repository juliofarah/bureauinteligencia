<?
require_once 'NewsController.php';
require_once 'NewsDao.php';
require_once 'NewRSS.php';
?>
<?php
    $controller = new NewsController(new NewsDao($connect));
    try{
        $allRSS = $controller->listAll();
    }catch(Exception $err){
        echo $err->getMessage();
    }           
    $reader = new RSSReader(simplexml_load_file($allRSS->offsetGet(0)->link()));
    //$reader = new RSSReader(simplexml_load_file("http://www.revistacafeicultura.com.br/rss/rss.xml"));
    $iterator = $reader->getRss();
   // echo "<br />";
?>
<div>
    <!--<label class="label-font">Selecione a fonte: </label>-->
    <label for="weather-city" style="color: #921b1b; font-weight: bold;">
        Para trocar a fonte clique na caixa abaixo
    </label><br />    
    <h2 id="h2-rss">
        <select id="change-rss">
            <!--<option value=""></option>-->
            <?$i = 0;?>
            <?foreach($allRSS as $rss):?>
            <option value="<?echo $rss->id()?>" <?if($i++ == 0) echo "selected='selected'"?>>
                    <?echo ($rss->title())?>
            </option>
            <?endforeach;?>
        </select>
    </h2>
</div>
<div id="news-items" class="content">
    <!--<h6><?echo $reader->rssFont()?> - <span style="font-size: 11px; font-weight: normal;"><?echo $reader->rssfontDescription()?></span></h6>-->
    <ul>
    <?$i = 7;?>
    <?while($iterator->valid() && $i-- > 0):?>                
        <li>
            <a class="news-rss" href="<?echo $iterator->current()->link()?>">                
                <span class="pubdate" style="font-size: 11px">[<?echo $iterator->current()->pubDate()?>]</span>
                -
                <span class="title-rss"><?echo $iterator->current()->title()?></span><br />
                <!--<span class=description-rss"><?//echo $iterator->current()->description()?></span>-->
            </a>
        </li>
    <?$iterator->next()?>
    <?endwhile?>
    </ul>    
</div>
