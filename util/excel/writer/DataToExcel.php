<?php

/**
 *
 * @author Ramon
 */
interface DataToExcel {
    
    public function setTitles(array $titles);
    
    public function setValues(array $values);
    
    /**
     * @return ArrayObject
     */
    public function getAllLinesValues();
    
    /**
     * @return ArrayObject
     */
    public function getLineWithTitles();
}

?>
