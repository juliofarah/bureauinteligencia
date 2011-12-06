<?php

/**
 *
 * @author Ramon
 */
interface DataToExcel {

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
