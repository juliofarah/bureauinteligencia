<?php
require_once 'ProccessSearch.php';
/**
 * Description of ProccessAnalysisSearch
 *
 * @author ramon
 */
class ProccessAnalysisSearch extends ProccessSearch{
    
    public function ProccessAnalysisSearch(ArrayObject $list) {
        parent::ProccessSearch($list);
    }
    /**     
     * @param type $current
     * @return Analyse 
     */
    protected function buildObject($current) {
        $subarea = new SubArea($current['subareaName'], $current['theme']);        
        $state = new State($current['idState'], $current['uf'], $current['nameState']);
        $analysis = new Analyse($current['title'], $subarea, $state, $current['date']);
        $analysis->setLink($current['link']);
        return $analysis;
    }
}

?>
