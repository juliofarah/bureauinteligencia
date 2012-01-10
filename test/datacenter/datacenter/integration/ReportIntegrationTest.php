<?php

/**
 * This class does the integration between components of Datacenter. 
 * The integration is between the following classes:
 * DatacenterController;
 * GroupData
 * DatacenterService
 * Builders
 *
 * @author Ramon
 */
class ReportIntegrationTest{
    
    /**
     *
     * @var PDO 
     */
    private $connection;
    
    public function ReportIntegrationTest(){
        $this->connection = Connection::connectToTest();
        $this->populatesDatabase();
    }
    
    /**
     * @return DatacenterController 
     */
    public function config(){
        $repository = new DatacenterDao($this->connection);        
        $service = new DatacenterService($repository);
        $statistic = new Statistic();
        $jsonResponse = new JsonResponse();
        $grouper = new DataGrouper();
        $factory = new BuilderFactory();        
        $controller = new DatacenterController($service, $statistic, $jsonResponse, $grouper, $factory);
        return $controller;
    }
    /**;
     * @test
     */
    public function integrationTableJson(){            
        $controller = $this->config();
        $controller->getValuesAsJson();
        echo $controller->getValuesWithSimpleParams(1, 1, 1, 1, 1, 1, array(1988,1992));
        echo "<br /><br />";
        echo "table ==> ".($controller->buildTableAsJson(1, 1, 1, 1, 1, 1, array(1988,1992)));
        
        echo "<br /><br />table of multi params => ".($controller->buildTableAsJson(1, array(1,2,3), array(1,2,3), array(1,2,3), array(1,2,3), array(1,2,3),array(1988,1993)));
        
        echo "<br /><br />";
        
        echo $controller->buildTableAsJson(array(1,2), array(1,2,3), array(1,2,3), array(1,2,3), array(1,2,3), array(1,2,3),array(1988,1993));
    }
    
    public function integrationChart(){
        $controller = $this->config();
        echo "<br /<br />--------------------------- XML CHART ----------------------<br /><br/>";
        $this->printChatXML($controller->buildChart(1, 1, 1, 1, 1, 1, array(1989,1992)));
        echo "<br /><br />";
        $this->printChatXML($controller->buildChart(1, array(1,2,3), array(1,2,3), array(1,2,3), array(1,2,3), array(1,2,3),array(1988,1993)));
        echo "<br /><br /> multigroups";
        $this->printChatXML($controller->buildChart(array(1,2), array(1,2,3), array(1,2,3), array(1,2,3), array(1,2,3), array(1,2,3),array(1988,1993)));
    }
    
    public function integrationExcel(){
        $controller = $this->config();
        echo "<br />Excel Spreadsheet<br/>";
        echo $spreadsheet = $controller->buildExcelTable(1, 1, 1, 1, 1, 1, array(1989,1992));
        $data = new Spreadsheet_Excel_Reader($spreadsheet);
        echo $data->dump(true, true);
    }
    
    private function printChatXML($xml){
        echo str_replace(array("<",">"),array("&lt;","&gt;"),$xml);        
    }
        
    private function sql(){
        $sql = "INSERT INTO data (ano, subgroup_id, font_id, type_id, variety_id, origin_id, destiny_id, value) VALUES ";
        $values1 = "(1990,1,1,1,1,1,1,150), ";
        $values2 = "(1991,1,1,1,1,1,1,200), ";
        $values3 = "(1990,1,1,3,2,1,2,250), ";
        $values4 = "(1991,1,1,3,2,1,2,300), ";
        $values5 = "(1990,1,2,1,1,1,1,200), ";
        $values6 = "(1991,1,2,1,1,1,1,250)";
    
/**
neste caso, o agrupador retorna 3 tipos diferentes (values1 e 2; values3 e 4; values5 e 6;
porém, quando isso vai ser jogado no gráfico, acontece o agrupamento de acordo com PaisOrigem-PaisDestino
e os dados de 1,2,5 e 6 ficam no mesmo grupo, mas sem ser somados. Isso acontece porque o Agrupador entende
que são dados diferentes - pois não possuem a mesma fonte. 
Verificar uma maneira de representar os dados com o gonzaga - analisar se tem que somar os valores na hora de 
 agrupar mesmo se as fontes forem diferentes.
 */
        
        /*$values7 = "(1990,2,1,1,1,1,1,150), ";
        $values8 = "(1991,2,1,1,1,1,1,200), ";
        $values9 = "(1990,2,1,3,2,1,2,150), ";
        $values10 = "(1992,2,1,3,2,1,2,200)";*/
        
        return $sql . $values1 . $values2 . $values3 . $values4 . $values5 . $values6;// . $values7 . $values8 . $values9 . $values10;        
    }
    
    private function populatesDatabase(){        
        $this->connection->prepare($this->sql())->execute();
    }
    
    public function emptyTable() {
        $this->connection->prepare("TRUNCATE TABLE data")->execute();
    }
}

?>
