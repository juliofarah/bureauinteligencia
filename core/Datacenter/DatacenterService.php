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
    
    /**
     * @var Statistic 
     */
    private $statistic;

    public function DatacenterService(DatacenterRepository $repository, CountryMap $countryMap = null, Statistic $statistic = null){
        $this->repository = $repository;     
        $this->countryMap = $countryMap;
        $this->statistic = $statistic;
    }
    
    public function insertValues(ExcelInputFile $excelInputFile, $subgroup, $destiny, $type, $variety, $font, $typeCountry = null) {
        $countries = $excelInputFile->getValuesOfColumn(1);        
        $dataToSave = new ArrayObject();
        foreach($countries as $country){
            if($typeCountry == 'origin'){
                $origin = $this->countryMap->getCountryId($country);
                if(is_null($origin)){
                    $origin = $this->countryMap->getOuthersForOrigin();
                }
                $destiny = 0;
            }elseif($typeCountry == 'destiny'){
                $destiny = $this->countryMap->getCountryId($country);
                if(is_null($destiny))
                    $destiny = $this->countryMap->getOthersForDestiny();
                $origin = 0;
            }else{
                $origin = $this->countryMap->getCountryId($country);
            }
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
        if($this->theOptionAllHasBeenSelected($subgroup, $variety, $type, $origin, $destiny, $font)){
            return $this->repository->getValuesWhenTheOptionAllWasSelected($subgroup, $variety, $type, $origin, $destiny, $font, $years);
        }
        return $this->repository->getValuesWithSimpleFilter($subgroup, $variety, $type, $origin, $destiny, $font,$years);
    }
    
    private function theOptionAllHasBeenSelected(){
        $numberOfParams = func_num_args();
        for ($i = 0; $i < $numberOfParams; $i++){
            if(func_get_arg($i) == DatacenterRepository::ALL)
                return true;
        }
        return false;
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
            $listValues1 = $this->repository->getValuesWithMultipleParamsSelected($subgroup[0], $variety, $type, $origin, $destiny, $font,$years);
            $listValues2 = $this->repository->getValuesWithMultipleParamsSelected($subgroup[1], $variety, $type, $origin, $destiny, $font,$years);
            $map = new HashMap();
            $map->put(0, $listValues1);
            $map->put(1, $listValues2);
            return $map;
        }else{
            if($this->theOptionAllHasBeenSelected($variety, $type, $origin, $destiny, $font)){
                $listValues = $this->repository->getValuesWhenTheOptionAllWasSelected($subgroup, $variety, $type, $origin, $destiny, $font, $years);
            }else
                $listValues = $this->repository->getValuesWithMultipleParamsSelected($subgroup, $variety, $type, $origin, $destiny, $font,$years);        
            return $listValues;           
        }
    }
}
?>
