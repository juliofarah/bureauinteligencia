<?php
    require_once '../asserts/Asserts.php';
    require_once '../../core/Datacenter/Statistic/Statistic.php';
    $statistic = new Statistic();
    testCalculateAverage($statistic);
    testVariance($statistic);
    testStandardDeviation($statistic);
?>

<?
    function testCalculateAverage(Statistic $statistic){
        $values = new ArrayObject(array(1,2,3,4,5,6, 6.33));
        assertTrue($statistic->average($values->getIterator()) == 3.90);
    }
    
    function testVariance(Statistic $statistic){
        $values = new ArrayObject(array(3,5,2,1,3,4,6,9,3));
        assertEquals($statistic->populationVariance($values->getIterator()), 5.11);
        assertEquals($statistic->sampleVariance($values->getIterator()), 5.75);
    }
    
    function testStandardDeviation(Statistic $statistic){
        $values = new ArrayObject(array(3,5,2,1,3,4,6,9,3));
        assertEquals($statistic->populationStandardDeviation($values->getIterator()), 2.26);
        assertEquals($statistic->sampleStandardDeviation($values->getIterator()), 2.398);
    }
?>
