<?php
/**
 * Description of DatacenterService
 *
 * @author Ramon
 */
class DatacenterService {
    
    /**
     * @var DatacenterRepository
     */
    private $repository;
    
    public function DatacenterService(DatacenterRepository $repository){
        $this->repository = $repository;
    }
    
    /**     
     * Este método faz a consultas no repositório que são filtradas apenas por um item de cada variável
     * @param type $subgroup
     * @param type $variety
     * @param type $type
     * @param type $origin
     * @param type $destiny
     * @param type $font
     * @return ArrayIterator 
     */
    public function getValuesWithSimpleFilter($subgroup, $variety, $type, $origin, $destiny, $font) {
        return $this->repository->getValuesWithSimpleFilter($subgroup, $variety, $type, $origin, $destiny, $font);
    }
    
    /**
     *
     * @param type $subgroup    
     * @param type $variety
     * @param type $type
     * @param type $origin
     * @param type $destiny
     * @param type $font
     * @return ArrayIterator
     */
    public function getValuesFilteringWithMultipleParams($subgroup, $variety, $type, $origin, $destiny, $font) {
        if(is_array($subgroup)){
            $listValues1 = $this->repository->getValuesWithMultipleParamsSelected($subgroup[0], $variety, $type, $origin, $destiny, $font);
            $listValues2 = $this->repository->getValuesWithMultipleParamsSelected($subgroup[1], $variety, $type, $origin, $destiny, $font);
            $map = new HashMap();
            $map->put(0, $listValues1);
            $map->put(1, $listValues2);
            return $map;
        }else{
            $listValues = $this->repository->getValuesWithMultipleParamsSelected($subgroup, $variety, $type, $origin, $destiny, $font);        
            return $listValues;           
        }
    }
}
?>
