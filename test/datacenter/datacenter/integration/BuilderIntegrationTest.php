<?php
//require_once '../../util/JsonResponse.php';
/**
 * Description of ChartBuilderIntegrationTest
 *
 * @author Ramon
 */
class BuilderIntegrationTest extends PHPUnit_Framework_TestCase{
    
    /**
     *
     * @var DatacenterController 
     */
    private $controller;
    
    protected function setUp(){
        $repository = new DatacenterDao(Connection::connectToTest());        
        $service = new DatacenterService($repository);
        $statistic = new Statistic();
        $jsonResponse = new JsonResponse();
        $grouper = new DataGrouper();
        $factory = new BuilderFactory();
        $this->controller = new DatacenterController($service, $statistic, $jsonResponse, $grouper, $factory);   
    }
    
    private function populatesDatabase(){
        Connection::connectToTest()->prepare($this->sqlInsert())->execute();    
    }
    
    private function sqlInsert(){
        //$data = new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
        $sql = "INSERT INTO data (ano, subgroup_id, font_id, type_id, variety_id, origin_id, destiny_id, value) VALUES ";
        $values1 = "(1990,2,1,1,1,1,1,150), ";
        $values2 = "(1991,2,1,1,1,1,1,200), ";
        $values3 = "(1990,2,1,3,2,1,2,250), ";
        $values4 = "(1991,2,1,3,2,1,2,300), ";
        $values5 = "(1990,2,2,1,1,1,1,200), ";
        $values6 = "(1991,2,2,1,1,1,1,250)";
        return $sql . $values1 . $values2 . $values3 . $values4 . $values5 . $values6;            
    }
    /**
     * @test
     */
    public function tableTest(){
        $this->populatesDatabase();
        $tableJson = $this->controller->buildTableAsJson(array(1,2), 1, 1, 1, 1, 1, array(1990,1993));
        $this->assertEquals($this->table(), $tableJson);
    }
    
    /**
     * @test
     */
    public function chartTest(){
        $chart = $this->controller->buildChart(array(1,2), 1, 1, 1, 1, 1, array(1990,1993));
        $chart = trim(str_replace('<?xml version="1.0"?>', '', $chart));
        $this->assertEquals($this->chart(), $chart);
    }
    
    
    private function sqlToDistinctGroups(){
        $sql = "INSERT INTO data (ano, subgroup_id, font_id, type_id, variety_id, origin_id, destiny_id, value) VALUES ";
        $values1 = "(1990,2,1,1,1,1,1,150), ";
        $values2 = "(1991,2,1,1,1,1,1,200), ";
        $values3 = "(1990,2,1,3,2,1,2,250), ";
        $values4 = "(1991,2,1,3,2,1,2,300), ";
        $values5 = "(1990,2,2,1,1,1,1,200), ";
        $values6 = "(1991,2,2,1,1,1,1,250)";
        return $sql . $values1 . $values2 . $values3 . $values4 . $values5 . $values6;            

    }
    
    private function insertDataToTestDistinctGroups(){
        $sql = "INSERT INTO data (ano, subgroup_id, font_id, type_id, variety_id, origin_id, destiny_id, value) VALUES ";
        //estoque
        $values1 = "(1990,8,1,1,1,1,1,200), ";
        $values2 = "(1991,8,1,1,1,1,1,300), ";
        $values3 = "(1990,8,2,1,1,1,1,250), ";
        $values4 = "(1991,8,2,1,1,1,1,325), ";
        //consumo
        $values5 = "(1990,9,1,1,1,1,1,380), ";
        $values6 = "(1991,9,1,1,1,1,1,420), ";
        $values7 = "(1990,9,2,1,1,1,1,600), ";
        $values8 = "(1991,9,2,1,1,1,1,800)";
        return $sql . $values1 . $values2 . $values3 . $values4 . $values5 . $values6 . $values7 . $values8;
    }
 
    private function emptyDatabase($pdo){
        $pdo->prepare("TRUNCATE TABLE data")->execute();
    }
 
    /**
     * @test 
     */
    public function distinctGroupsTestTables(){
        $pdo = Connection::connectToTest();        
        $this->emptyDatabase($pdo);
        $pdo->prepare($this->insertDataToTestDistinctGroups())->execute();
        //print_r($this->controller->buildTableAsJson(array(8,9), array(1,2), 1, 1, 1, 1, array(1990,1992)));
        
        $tableJson = "";
        $years = array(1990,1991);
        $paramsGroup1 = array("subgroup"=>8,"font"=>1,"type"=>1,"variety"=>1,"origin"=>1,"destiny"=>1);
        $paramsGroup2 = array("subgroup"=>9,"font"=>2,"type"=>1,"variety"=>1,"origin"=>1,"destiny"=>1);
        $tableJson = $this->controller->buildTableSearchingDistinctGroups($paramsGroup1, $paramsGroup2, $years);
        $this->assertEquals($this->tableAlternative(),$tableJson);
        
        $paramsGroup1["font"] = 2; $paramsGroup2["font"] = 1;
        $chart = $this->controller->buildChartSearchingDistinctGroups($paramsGroup1,$paramsGroup2,$years);
        $chart = trim(str_replace('<?xml version="1.0"?>', '', $chart));
        $this->assertEquals($this->alternativeChart(),$chart);
    }
    
    private function alternativeChart(){
        $xml = '<?xml version="1.0"?>';        
        $xml .= '<chart bgColor="FFFFFF" PYAxisName="Estoque" SYAxisName="Consumo (sacas de 60kg)">';
        $xml .= '<categories><category label="1990"/><category label="1991"/></categories>';
        $xml .= '<dataset seriesName="Estoque-Brasil-Brasil">';
        $xml .=     '<set value="250"/><set value="325"/>';
        $xml .= '</dataset>';
        $xml .= '<dataset seriesName="Consumo (sacas de 60kg)-Brasil-Brasil" parentYAxis="S">';
        $xml .=     '<set value="380"/><set value="420"/>';
        $xml .= '</dataset>';
        $xml .= '</chart>';
        
        return trim(str_replace('<?xml version="1.0"?>', '', $xml));
    }
    
    private function tableAlternative(){
        $json = '[';
        $json .= $this->contentTableAlternative();
        $json .= ',';
        $json .= $this->contentTableAlternative(true);
        $json .= ']';        
        return $json;
    }
    
   private function contentTableAlternative($withoutValue = false){
        $json = '{';
            $json .= '"thead":[';
            $json .= '{"th":"Variedade"},{"th":"Tipo"},{"th":"Origem"},{"th":"Destino"},';
            $json .= '{"th":"1990"},{"th":"1991"}';
            $json .= '],';
            $json .= '"tbody":[';
            $arabica = utf8_decode("Arábica");
            $json .= '{"variety":"'.$arabica.'","type":"Verde","origin":"Brasil","destiny":"Brasil",';
            if(!$withoutValue)
                $json .= '"values":[{"value":200},{"value":300}]}';
            else
                $json .= '"values":[{"value":600},{"value":800}]}';
            $json .= ']';
        $json .= '}';
        return $json;
    }
 
       
    private function table(){
        $json = '[';
        $json .= $this->contentTable();
        $json .= ',';
        $json .= $this->contentTable(true);
        $json .= ']';
        return $json;
    }    
    
    private function contentTable($withoutValue = false){
        $json = '{';
            $json .= '"thead":[';
            $json .= '{"th":"Variedade"},{"th":"Tipo"},{"th":"Origem"},{"th":"Destino"},';
            $json .= '{"th":"1990"},{"th":"1991"},{"th":"1992"},{"th":"1993"}';
            $json .= '],';
            $json .= '"tbody":[';
            $arabica = utf8_decode("Arábica");
            $json .= '{"variety":"'.$arabica.'","type":"Verde","origin":"Brasil","destiny":"Brasil",';
            if(!$withoutValue)
                $json .= '"values":[{"value":222},{"value":452},{"value":453},{"value":234}]}';
            else
                $json .= '"values":[{"value":150},{"value":200},{"value":"-"},{"value":"-"}]}';
            $json .= ']';
        $json .= '}';
        return $json;
    }
    
    private function chart(){
        $xml = '<?xml version="1.0"?>';        
        $xml .= '<chart bgColor="FFFFFF" PYAxisName="Quantidade Exportada (sc 60kg)" SYAxisName="Quantidade Importada (sc 60kg)">';
        $xml .= '<categories><category label="1990"/><category label="1991"/><category label="1992"/><category label="1993"/></categories>';
        $xml .= '<dataset seriesName="Quantidade Exportada (sc 60kg)-Brasil-Brasil">';
        $xml .=     '<set value="222"/><set value="452"/><set value="453"/><set value="234"/>';
        $xml .= '</dataset>';
        $xml .= '<dataset seriesName="Quantidade Importada (sc 60kg)-Brasil-Brasil" parentYAxis="S">';
        $xml .=     '<set value="150"/><set value="200"/><set value="0"/><set value="0"/>';
        $xml .= '</dataset>';
        $xml .= '</chart>';
        
        return trim(str_replace('<?xml version="1.0"?>', '', $xml));
    }
}

?>
