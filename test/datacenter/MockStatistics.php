<?php

/**
 * Description of MockStatistics
 *
 * @author Ramon
 */
require_once '../../core/Datacenter/Statistic/Statistic.php';
class MockStatistics extends Statistic{
    
    public function average(ArrayIterator $values) {
        return 3.90;
    }
    
    public function populationStandardDeviation(ArrayIterator $values) {
        return 2.26;
    }
    
    public function sampleStandardDeviation(ArrayIterator $values) {
        return 2.398;
    }
    
    public function populationVariance(ArrayIterator $values) {
        return 5.11;
    }
    
    public function sampleVariance(ArrayIterator $values) {
        return 5.75;
    }
}

?>
