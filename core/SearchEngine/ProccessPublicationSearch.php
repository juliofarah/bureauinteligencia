<?php
require_once 'ProccessSearch.php';
/**
 * Description of ProccessPublicationSearch
 *
 * @author ramon
 */
class ProccessPublicationSearch extends ProccessSearch {

    public function ProccessPublicationSearch(ArrayObject $list){
        parent::ProccessSearch($list);
    }
    
    protected function buildObject($current) {
        $subarea = new SubArea($current['subareaName'], $current['theme']);        
        $file = new File(null, $current['filename']);
        $state = new State($current['idState'], $current['uf'], $current['nameState']);
        return new Paper($current['title'], $subarea, $file, $state, $current['date'], $current['event']);        
    }
}
?>
