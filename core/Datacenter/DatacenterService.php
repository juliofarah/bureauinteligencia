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
     * @return ArrayObject 
     */
    public function getValuesByOneSubgroup(array $subgroup, array $variety, array $type, array $origin, array $destiny, array $font) {
        return $this->repository->getValuesByOneSubgroup($subgroup, $variety, $type, $origin, $destiny, $font);
    }
}

?>
