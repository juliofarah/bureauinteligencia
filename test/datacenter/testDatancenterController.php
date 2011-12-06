<?php
    
    require_once '../asserts/Asserts.php';
    require_once 'MockDatacenterRepository.php';
    require_once 'MockStatistics.php';
    require_once '../../util/JsonResponse.php';
    require_once '../../core/Datacenter/DatacenterController.php';
    
    $datacenterController = new DatacenterController(new MockDatacenterRepository(), new MockStatistics(), new JsonResponse());
    
    assertEquals('{"status":true,"message":null,"value":2.398}', 
            $datacenterController->calculateSampleStandardDeviation(1));
?>
