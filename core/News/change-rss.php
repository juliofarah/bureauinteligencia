<?
require_once 'NewsController.php';
require_once 'NewsDao.php';
require_once 'NewRSS.php';
?>
<?php
    $controller = new NewsController(new NewsDao(Connection::connect()));
    $id = $_GET['id'];
    $newRss = $controller->get($id);

    if($newRss != null){
        $reader = new RSSReader(simplexml_load_file($newRss->link()));

        $iterator = $reader->getRss();

        //$html = "<h6>".$reader->rssFont()." - <span style='font-size: 11px; font-weight: normal;'>".$reader->rssfontDescription()."</span></h6>";
        $html = "";
        $html .= "<ul>";
        $i = 7;
        while($iterator->valid() && $i-- > 0){
            $html .= "<li>";
                $html .= "<a class='news-rss' href='".$iterator->current()->link()."'>";
                $html .=    "<span class='pubdate' style='font-size: 11px'>[".$iterator->current()->pubDate()."]</span> - ";
                $html .=    "<span class='title-rss'>".$iterator->current()->title()."</span>";
                $html .=    "<br />";
                //$html .=    "<span class='description-rss'>".$iterator->current()->description()."</span>";
                $html .= "</a>";
            $html .= "</li>";
            $iterator->next();
        }
        $html .= "</ul>";
        echo $html;
    }else{
        print_r("Selecione uma fonte!");
    }
?>
