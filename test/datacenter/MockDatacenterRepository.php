<?php

/**
 * Description of MockDatacenterRepository
 *
 * @author Ramon
 */
require_once '../../core/Datacenter/DatacenterRepository.php';
class MockDatacenterRepository implements DatacenterRepository{
    
    public function getValuesFromAGroup($group) {
        return new ArrayIterator(array());
    }

    public function getValuesWhenTheOptionAllWasSelected($sg, $variety, $type, $origin, $destiny, $font, $year) {
        
    }

    public function getValuesWithMultipleParamsSelected($subgroup, $variety, $type, $origin, $destiny, $font, $year = null) {
        
    }

    public function getValuesWithSimpleFilter(DataParam $params, $years = null) {
        
    }

    public function save(ArrayObject $dataList) {
        
    }
}

?>
