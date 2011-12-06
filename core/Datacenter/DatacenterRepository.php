<?php
/**
 *
 * @author Ramon
 */
interface DatacenterRepository {
    
    /**
     * @return ArrayIterator
     */
    public function getValuesFromAGroup($group);
}

?>
