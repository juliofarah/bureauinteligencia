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
}

?>
