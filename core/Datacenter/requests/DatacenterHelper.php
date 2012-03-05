<?php
/**
 * Description of DatacenterHelper
 *
 * @author raigons
 */

class DatacenterHelper {
            
    public static function pagination($page, $maxValuesPerPage, $totalValues){
        $link_type = "admin/datacenter/list/";
        echo GenericHandler::prevPage($page, $link_type);
        echo GenericHandler::pages($totalValues, $page, $maxValuesPerPage, $link_type);
        echo GenericHandler::nextPage($page, $maxValuesPerPage, $totalValues, $link_type);
    }        
          
    /**
     * @return Data 
     */
    public static function data($data){
        return $data;
    }
}

?>
