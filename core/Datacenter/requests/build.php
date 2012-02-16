<?php     
    $superDirectory = '';
    if(isset($_POST['fromAdmin'])) $superDirectory = '../';  
    
    $baseFileUrlDatacenter = $superDirectory . 'core/Datacenter/';
    $baseFileUrlGenerics = $superDirectory . 'core/generics/';
    require_once $baseFileUrlDatacenter . 'DatacenterDao.php';
    require_once $baseFileUrlDatacenter . 'DatacenterService.php';
    require_once $baseFileUrlDatacenter . 'DataGrouper.php';
    require_once $baseFileUrlDatacenter . 'Data.php';
    require_once $baseFileUrlDatacenter . 'BuilderFactory.php';
    require_once $baseFileUrlDatacenter . 'Builder.php';
        
    require_once $baseFileUrlDatacenter . 'Statistic/Statistic.php';    
    
    require_once $baseFileUrlGenerics . 'Param.php';
    require_once $baseFileUrlGenerics . 'datacenter/Subgroup.php';
    require_once $baseFileUrlGenerics . 'datacenter/Font.php';
    require_once $baseFileUrlGenerics . 'datacenter/Variety.php';
    require_once $baseFileUrlGenerics . 'datacenter/CoffeType.php';
    require_once $baseFileUrlGenerics . 'datacenter/Country.php';    
    
    require_once $baseFileUrlDatacenter . 'DatacenterController.php';
?>
<?
    if(!isset($_POST['fromAdmin'])){
        $repository = new DatacenterDao(Connection::connect());
        $service = new DatacenterService($repository);
        $statistic = new Statistic();
        $jsonResponse = new JsonResponse();
        $grouper = new DataGrouper();
        $factory = new BuilderFactory();        
        $controller = new DatacenterController($service, $statistic, $jsonResponse, $grouper, $factory);         
    }
?>
<?
function fillParams($param, &$subgroup, &$font, &$type, &$variety, &$origin, &$destiny, &$array_group = null){
        $subgroup = $param['subgrupo']; 
        $font = $param['fonte'];
        $type = $param['tipo'];
        $variety = $param['variedade']; 
        $origin = $param['origem'];
        $destiny = $param['destino'];         
        if(!is_null($array_group))
            $array_group = array("subgroup"=>$subgroup,"font"=>$font,"type"=>$type,"variety"=>$variety,"origin"=>$origin,"destiny"=>$destiny);
}
?>