<?php
/**
 *
 * @author Ramon
 */
interface DatacenterRepository {

    const ALL = "all";
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
    
    public function getValuesWhenTheOptionAllWasSelected($sg, $variety, $type, $origin, $destiny, $font, $year);
    
    /**
     * @return ArrayIterator
     */
    public function getValuesFromAGroup($group);
    
}

?>
