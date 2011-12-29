<?php
/**
 * Description of DataGrouper
 *
 * @author Ramon
 */
class DataGrouper {

    /**     
     * @param ArrayObject $listOfData
     * @return HashMap 
     */
    public function groupDataValues(ArrayObject $listOfData) {
        $mapGrouped = new HashMap();
        $dataToGroup = $this->objectData($listOfData->offsetGet(0));
        $list = $listOfData->getIterator();        
        $list2 = $listOfData->getIterator();        
        $dataAux = null; 
        $i = 0;
        while($list->valid()){
            $auxList = $this->getDataOfSameTypeAndPutIntoList($list2, $dataToGroup, $dataAux);
            $this->changePointers($list, $list2, $dataAux, $dataToGroup);
            $this->changeDataToGroup($list, $dataToGroup);
            $this->groupIntoMap($mapGrouped, $auxList, $i++);
        }               
        return $mapGrouped;
    }
    
    private function getDataOfSameTypeAndPutIntoList(ArrayIterator $list2, $dataToGroup, $dataAux){
        $auxList = null;
        if(!$dataToGroup->isOfTheSameCategoryOf($dataAux)){
            $auxList = new ArrayObject();
            while($list2->valid()){
                $data = $this->objectData($list2->current());
                if($data->isOfTheSameCategoryOf($dataToGroup)){
                    $auxList->append($data);
                }
                $list2->next();
            }
        }        
        return $auxList;
    }
    
    private function changePointers(&$list, &$list2, &$dataAux, $dataToGroup){
        $list->next();  
        $list2->rewind();
        $dataAux = $dataToGroup;
    }
    
    private function changeDataToGroup(ArrayIterator $list, Data &$dataToGroup){
        if($list->valid() && !$dataToGroup->isOfTheSameCategoryOf($list->current())){
            $dataToGroup = $list->current();
        }
    }
    
    private function groupIntoMap(Map &$map, $auxList, $i){
        if($auxList != null)
            $map->put($i, $auxList);
    }
    
    /**
     * @param Data $object
     * @return Data
     */
    private function objectData(Data $object){
        return $object;
    }        
}

?>
