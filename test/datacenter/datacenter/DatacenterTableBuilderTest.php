<?php
require_once '../../core/Datacenter/TableBuilder.php';
/**
 * Description of DatacenterTableBuilderTest
 *
 * @author Ramon
 */
class DatacenterTableBuilderTest extends PHPUnit_Framework_TestCase{
        
    /**
     * @test
     */
    public function buildTableFromAList(){
        $years = array(1989, 1992);        
        $tableBuilder = new TableBuilder();        
        $this->assertEquals($this->singleTableJSONModel(), $tableBuilder->buildAsJson($this->groupedList(),$years));
    }        
    
    /**
     * @test
     */
    public function buildTwoTables() {
        $years = array(1989, 1992);
        $tableBuilder = new TableBuilder();
        $groupedValues = array($this->groupedList(), $this->groupedList());        
        $this->assertEquals($this->doubleTableJSONModel(),$tableBuilder->buildAsJson($groupedValues,$years));
    }

    private function doubleTableJSONModel(){
        $json = '[';       
        $json .= '{"tabela_1":'.$this->table().'},';
        $json .= '{"tabela_2":'.$this->table().'}';
        $json .= ']';
        return $json;
    }
    
    private function singleTableJSONModel(){
        $json = '[';
        $json .= '{';
        $json .= '"tabela_1":';        
        $json .= $this->table();
        $json .= '}';
        $json .= ']';        
        return $json;
    }
    
    private function table(){
        $json = '{';
            $json .= '"thead":[';
            $json .= '{"th":"Variedade"},{"th":"Tipo"},{"th":"Origem"},{"th":"Destino"},';
            $json .= '{"th":"1989"},{"th":"1990"},{"th":"1991"},{"th":"1992"}';
            $json .= '],';
            $json .= '"tbody":[';
            $json .= '{"variety":"variety","type":"type","origin":"origin","destiny":"destiny",';
            $json .=    '"values":[{"value":150},{"value":220},{"value":285},{"value":"-"}]}';
            $json .= ',{"variety":"variety2","type":"type2","origin":"origin2","destiny":"destiny2",';
            $json .=    '"values":[{"value":188},{"value":302},{"value":254},{"value":195}]}';
            $json .= ',{"variety":"variety3","type":"type3","origin":"origin3","destiny":"destiny2",';
            $json .=    '"values":[{"value":"-"},{"value":101},{"value":148},{"value":157}]}';
            $json .= ']';
        $json .= '}';
        return $json;
    }
    
    private function newData($year, $value){
        $subgroup = new Subgroup("subgrupo");
        $font = new Font("fonte");
        $type = new CoffeType("type");
        $variety = new Variety("variety",1);
        $origin = new Country("origin");
        $destiny = new Country("destiny");
        
        $data = new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
        $data->setValue($value);
        return $data;
    }
    
    private function newAnotherData($year, $value){
        $subgroup = new Subgroup("subgrupo");
        $font = new Font("fonte");
        $type = new CoffeType("type2",2);
        $variety = new Variety("variety2",2);
        $origin = new Country("origin2",2);
        $destiny = new Country("destiny2",2);
        $data = new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
        $data->setValue($value);
        return $data;
    }
    
    private function newOtherData($year, $value){
        $subgroup = new Subgroup("subgrupo");
        $font = new Font("fonte1");
        $type = new CoffeType("type3",2);
        $variety = new Variety("variety3",2);
        $origin = new Country("origin3",2);
        $destiny = new Country("destiny2",2);
        $data = new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
        $data->setValue($value);
        return $data;
    }
    
    private function groupedList(){
        //map <int, ArrayList<Data>>
        $map = new HashMap();
        $arrayList = new ArrayObject();
        $arrayList->append($this->newData(1989,150));
        $arrayList->append($this->newData(1990,220));
        $arrayList->append($this->newData(1991,285));
        $map->put(0, $arrayList);        
        $arrayList = new ArrayObject();
        $arrayList->append($this->newAnotherData(1989,188));
        $arrayList->append($this->newAnotherData(1990,302));
        $arrayList->append($this->newAnotherData(1991,254));
        $arrayList->append($this->newAnotherData(1992,195));
        $map->put(1, $arrayList);
        $arrayList = new ArrayObject();
        $arrayList->append($this->newOtherData(1990, 101));
        $arrayList->append($this->newOtherData(1991, 148));
        $arrayList->append($this->newOtherData(1992, 157));
        $map->put(2, $arrayList);
        return $map;
    }
}

?>
