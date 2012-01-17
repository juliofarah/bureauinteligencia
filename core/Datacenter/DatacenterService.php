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

    /**    
     * @var CountryMap
     */
    private $countryMap;
    
    public function DatacenterService(DatacenterRepository $repository, CountryMap $countryMap = null){
        $this->repository = $repository;     
        $this->countryMap = $countryMap;
    }
    
    public function insertValues(ExcelInputFile $excelInputFile, $subgroup, $destiny, $type, $variety, $font) {      
        $countries = $excelInputFile->getValuesOfColumn(1);        
        $dataToSave = new ArrayObject();
        foreach($countries as $country){
            $origin = $this->countryMap->getCountryId($country);            
            $dataOfCurrentCountry = $this->getValuesWithSimpleFilter($subgroup, $variety, $type, $origin, $destiny, $font);
            $yearsToInsert = $this->insertValuesIfACountryDoesNotHaveItStoredYet($dataOfCurrentCountry, $excelInputFile, $country);
            if($yearsToInsert->count() > 0){         
                $this->getDataToSave($dataToSave,$yearsToInsert, $excelInputFile, $country, $subgroup, $font, $type, $variety, $origin, $destiny);
            }
        }
        return $this->repository->save($dataToSave);
    }
 
    private function getDataToSave(ArrayObject &$dataToInsert, ArrayObject $years, ExcelInputFile $inputFile, $country, $subgroup, $font, $type, $variety, $origin, $destiny){
        $valuesFromACountry = $inputFile->getValuesFromACountry($country);
        foreach($years as $year){
            $value = $valuesFromACountry[$country][$year];
            $data = $this->buildDataToInsert($year, $subgroup, $font, $type, $variety, $origin, $destiny);
            $data->setValue($value);
            $dataToInsert->append($data);
        } 
    }
 
    private function buildDataToInsert($year, $subgroupId, $fontId, $typeId, $varietyId, $originId, $destinyId){        
        $font = new Font(); $font->setId($fontId);
        $type = new CoffeType(); $type->setId($typeId);
        $variety = new Variety; $variety->setId($varietyId);
        $origin = new Country(); $origin->setId($originId); 
        $destiny = new Country(); $destiny->setId($destinyId);
        $subgroup = new Subgroup(); $subgroup->setId($subgroupId);        
        return new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
    }
    
    private function insertValuesIfACountryDoesNotHaveItStoredYet(ArrayIterator $dataValues, ExcelInputFile $excelInputFile, $country){        
        $yearsToInsert = new ArrayObject();
        $i = 0;
        foreach($excelInputFile->getYears() as $year){
            if(!$this->thisYearIsAlreadyStored($dataValues, $year)){
                $yearsToInsert->append($year);
            }
        }
        return $yearsToInsert;
    }
    
    private function thisYearIsAlreadyStored(ArrayIterator $dataValues, $year){
        while($dataValues->valid()){
            if($dataValues->current()->getYear() == $year){
                return true;
            }
            $dataValues->next();
        }
        return false;
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
    public function getValuesWithSimpleFilter($subgroup, $variety, $type, $origin, $destiny, $font,array $years = null) {
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
    public function getValuesFilteringWithMultipleParams($subgroup, $variety, $type, $origin, $destiny, $font,array $years = null) {
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
