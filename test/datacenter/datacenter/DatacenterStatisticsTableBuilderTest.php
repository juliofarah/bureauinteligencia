<?php
require_once '../../core/Datacenter/TableJsonBuilder.php';
require_once '../../core/Datacenter/TableStatisticsJsonBuilder.php';
/**
 * Description of DatacenterStatisticsTableBuilderTest
 *
 * @author Ramon
 */
class DatacenterStatisticsTableBuilderTest extends PHPUnit_Framework_TestCase{
    
    /**
     *
     * @var TableJsonBuilder 
     */
    private $TableJsonBuilder;
    
    protected function setUp(){
       $this->TableJsonBuilder = new TableStatisticsJsonBuilder();       
    }
    
        /**
     * @test
     */
    public function buildTableFromAList(){
        $years = array(1989, 1992);                
        $this->assertEquals($this->singleTableJSONModel(), $this->TableJsonBuilder->build($this->groupedList(),$years));
    }        

    private function singleTableJSONModel(){
        $json = '[';
        $json .= $this->table();
        $json .= ']';        
        return $json;
    }
    
    private function table(){
        $json = '{';
            $json .= '"thead":[';
            $json .= '{"th":"Variedade"},{"th":"Tipo"},{"th":"Origem"},{"th":"Destino"},';
            $json .= '{"th":"'.utf8_decode("Média").'"},';
            $json .= '{"th":"Mediana"},';
            $json .= '{"th":"Moda"},';
            $json .= '{"th":"'.utf8_decode("Desvio Padrão").'"},{"th":"'.utf8_decode("Variância").'"}';            
            $json .= '],';
            $json .= '"tbody":[';
            $json .= '{"variety":"variety","type":"type","origin":"origin","destiny":"destiny",';
            $json .=    '"values":[{"value":"2,00"},{"value":"2,00"},{"value":"-"},{"value":"1,00"},{"value":"1,00"}]}';
            $json .= ',{"variety":"variety2","type":"type2","origin":"origin2","destiny":"destiny2",';
            $json .=    '"values":[{"value":"2,50"},{"value":"2,50"},{"value":"2,00; 3,00"},{"value":"0,57"},{"value":"0,33"}]}';
            $json .= ',{"variety":"variety3","type":"type3","origin":"origin3","destiny":"destiny2",';
            $json .=    '"values":[{"value":"6,00"},{"value":"6,00"},{"value":"-"},{"value":"1,00"},{"value":"1,00"}]}';
            $json .= ']';
        $json .= '}';
        return $json;
    }
    
    protected function newData($year, $value){
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
    
    protected function newAnotherData($year, $value){
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
    
    protected function newOtherData($year, $value){
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
    
    protected function groupedList(){
        //map <int, ArrayList<Data>>
        $map = new HashMap();
        $arrayList = new ArrayObject();
        $arrayList->append($this->newData(1989,1));
        $arrayList->append($this->newData(1990,2));
        $arrayList->append($this->newData(1991,3));
        $map->put(0, $arrayList);        
        $arrayList = new ArrayObject();
        $arrayList->append($this->newAnotherData(1989,2));
        $arrayList->append($this->newAnotherData(1990,2));
        $arrayList->append($this->newAnotherData(1991,3));
        $arrayList->append($this->newAnotherData(1992,3));
        $map->put(1, $arrayList);
        $arrayList = new ArrayObject();
        $arrayList->append($this->newOtherData(1990, 5));
        $arrayList->append($this->newOtherData(1991, 7));
        $arrayList->append($this->newOtherData(1992, 6));
        $map->put(2, $arrayList);
        return $map;
    }
}

?>
