<?php

    $connect = Connection::connect();
    include toLoad($_GET['toLoad']);
?>

<?
function toLoad($index){
    $array = array(
        "quotations" => "cotacoes.php", 
        "news" => "noticias.php", 
        "video" => "videoteca.php",
        "weather" => "metereologia.php", 
        "publications" => "publicacoes.php", 
        "datacenter" => "datacenter.php");
    
    return $array[$index];
}
?>