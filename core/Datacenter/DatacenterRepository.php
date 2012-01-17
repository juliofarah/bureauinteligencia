<?php
/**
 *
 * @author Ramon
 */
interface DatacenterRepository {

    /**
     * @return ArrayIterator
     */
    public function getValuesWithSimpleFilter($subgroup, $variety, $type, $origin, $destiny, $font, $year = null);
    
    /**
     * @return ArrayIterator
     */
    public function getValuesWithMultipleParamsSelected($subgroup, $variety, $type, $origin, $destiny, $font, $year = null);
    
    /**
     * @return boolean
     */
    public function save(ArrayObject $dataList);
    
    /**
     * @return ArrayIterator
     */
    public function getValuesFromAGroup($group);
    
}

?>
