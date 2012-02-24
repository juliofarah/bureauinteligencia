<?php
    require_once 'build.php';
    require_once 'core/Datacenter/TableBuilder.php';
    require_once 'core/Datacenter/TableJsonBuilder.php';
    require_once 'core/Datacenter/TableStatisticsJsonBuilder.php';
?>
<?
    $years = $_GET['ano'];
    if(isset($_GET[0]) && isset($_GET[1])){
        $g1 = $g2 = array();
        fillParams($_GET[0], $subgroup, $font, $type, $variety, $origin, $destiny, $g1);
        fillParams($_GET[1], $subgroup, $font, $type, $variety, $origin, $destiny, $g2);
        $json = $controller->getDistinctStatisticTable($g1,$g2,$years);
        echo $json;
    }else{
        $subgroup = $font = $type = $variety = $origin = $destiny = null;
        fillParams($_GET, $subgroup, $font, $type, $variety, $origin, $destiny);
        $json = $controller->getStatisticTable($subgroup, $font, $type, $variety, $origin, $destiny,$years);
        echo $json;        
    }    
?>