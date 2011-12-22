<?php
/**
 *
 * @author Ramon
 */
interface DatacenterRepository {

    /**
     * @return ArrayIterator
     */
    public function getValuesByOneSubgroup($subgroup, $variety, $type, $origin, $destiny, $font);
    
    /**
     * @return ArrayIterator
     */
    public function getValuesFromAGroup($group);
    
}

?>
