<?php
/**
 *
 * @author Ramon
 */
interface DatacenterRepository {

    /**
     * @return ArrayIterator
     */
    public function getValuesWithSimpleFilter($subgroup, $variety, $type, $origin, $destiny, $font);
    
    /**
     * @return ArrayIterator
     */
    public function getValuesWithMultipleParamsSelected($subgroup, $variety, $type, $origin, $destiny, $font);
    
    /**
     * @return ArrayIterator
     */
    public function getValuesFromAGroup($group);
    
}

?>
