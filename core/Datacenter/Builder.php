<?php

/**
 *
 * @author Ramon
 */
interface Builder {
    
    /**
     * The param $mapValues must be the map with grouped values. In this map
     * each position contains an ArrayObject with grouped Data .
     * @param $mapWithGroupedValues 
     */    
    public function build($mapWithGroupedValues,array $years);
}

?>
