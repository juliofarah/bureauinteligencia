<?php

require_once 'ProccessSearch.php';
/**
 * Description of ProccessVideoSearch
 *
 * @author ramon
 */
class ProccessVideoSearch extends ProccessSearch {

    public function ProccessVideoSearch(ArrayObject $list){
        parent::ProccessSearch($list);
    }
    
    protected function buildObject($current) {
        $state = new State($current['idState'], $current['uf'], $current['nameState']);
       return new Video($current['title'], $current['link'], $current['date'],
               new SubArea($current['subareaName'], $current['theme']),
               $state, $current['event']);
    }

    /**
     * @var ArrayObject
     */
    /*private $videos;

    public function ProccessVideoSearch(ArrayObject $list){
        $this->videos = $list;
    }

    public function getVideosFound(){
        if($this->videos->count() > 0){
            $videos = $this->videos->getIterator();
            $responseJson = '[';
            while($videos->valid()){
                $video = $this->buildObject($videos->current());
                $responseJson .= $video->toJSON().",";
                $videos->next();
            }
            $responseJson = substr($responseJson, 0, -1);
            $responseJson .= ']';
            return $responseJson;
        }else{
            return null;
        }
    }

    private function searchToJSON(){

    }
    */
    
}
?>
