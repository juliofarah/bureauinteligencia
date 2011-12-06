<?php

/**
 * Description of ProccessSearch
 *
 * @author ramon
 */
abstract class ProccessSearch {

    /**     
     * @var ArrayObject
     */
    private $results;

    public function ProccessSearch(ArrayObject $list){
        $this->results = $list;
    }

    public function getResultsFound(){
        if($this->results->count() > 0){
            $result = $this->results->getIterator();
            $responseJson = '[';
            while($result->valid()){
                $object = $this->buildObject($result->current());
                $responseJson .= $object->toJSON().',';
                $result->next();                
            }
            $responseJson = substr($responseJson, 0, -1);
            $responseJson .= ']';
            return $responseJson;
        }else{
            return null;
        }
    }

    protected abstract function buildObject($current);
}
?>
