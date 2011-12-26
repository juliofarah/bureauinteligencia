<?php

require_once '../../core/DataBase/Connection.php';
require_once '../../core/Datacenter/DatacenterDao.php';

/**
 * Description of DaoRepositoryTest
 *
 * @author Ramon
 */
class DaoRepositoryTest extends PHPUnit_Framework_TestCase {

    /**
     * @var DatacenterRepository 
     */
    private $daoRepository;

    /**
     * @var PDO 
     */
    private $connection;

    public function DaoRepositoryTest() {
        $this->connection = Connection::connect();
        $this->daoRepository = new DatacenterDao($this->connection);
    }
    
    /**
     * @test
     */
    public function getValuesWithoutMultiParams() {
        $this->populatesDatabase();//Insert values on Database in the first test
        $subgroup = $variety = $type = $origin = $destiny = $font = 1;
        $values = $this->daoRepository->getValuesWithSimpleFilter($subgroup, $variety, $type, $origin, $destiny, $font);
        $this->assertEquals(2, $values->count());
        $this->assertTrue($values->offsetGet(0) instanceof Data && $values->offsetGet(0) instanceof Data);
        $this->assertEquals(150, $values->offsetGet(0)->getValue());
    }

    private function persistDataForTest() {
        //$data = new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
        $sql = "INSERT INTO data_test (ano, subgroup_id, font_id, type_id, variety_id, origin_id, destiny_id, value) VALUES ";
        $values1 = "(1990,1,1,1,1,1,1,150), ";
        $values2 = "(1991,1,1,1,1,1,1,200), ";
        $values3 = "(1990,1,1,3,2,1,2,250), ";
        $values4 = "(1991,1,1,3,2,1,2,300), ";
        $values5 = "(1990,1,2,1,1,1,1,200), ";
        $values6 = "(1991,1,2,1,1,1,1,250)";
        return $sql . $values1 . $values2 . $values3 . $values4 . $values5 . $values6;
    }
    
    /**
     * @test
     */
    public function getValuesWithouMultiParamsButWithDiferentsParamsValues() {
        $subgroup = $font = 1;
        $type = 3;
        $variety = 2;
        $origin = 1;
        $destiny = 2;
        $values = $this->daoRepository->getValuesWithSimpleFilter($subgroup, $variety, $type, $origin, $destiny, $font);
        $this->assertEquals(2, $values->count());
        $this->assertTrue($values->offsetGet(0) instanceof Data && $values->offsetGet(0) instanceof Data);
        $this->assertEquals(300, $values->offsetGet(1)->getValue());
    }
    /**
     * @test
     */
    public function getValuesWithDifferentVarietiesAndTypes(){
        //get values of variety 1 and 3 and type 1 e 2
        $subgroup = $font = (1);
        $type = array(1,3);
        $variety = array(1,2);
        $origin = 1;
        $destiny = 1;
        $values = $this->daoRepository->getValuesWithMultipleParamsSelected($subgroup, $variety, $type, $origin, $destiny, $font);
        $this->assertEquals(2, $values->count());
        $this->assertEquals(200, $values->offsetGet(1)->getValue());
        
        //change de destiny country
        $destiny = array(1,2);
        $values = $this->daoRepository->getValuesWithMultipleParamsSelected($subgroup, $variety, $type, $origin, $destiny, $font);
        $this->assertEquals(4, $values->count());
        $this->assertEquals(300, $values->offsetGet(3)->getValue());
    }
   
    /**
     * @test
     */
    public function getValuesBetweenYears(){
        $subgroup = $font = 1;
        $type = array(1,3);
        $variety = 1;
        $origin = 1; 
        $destiny = array(1,2);
        $year = array(1989, 1990);
        $values = $this->daoRepository->getValuesWithMultipleParamsSelected($subgroup, $variety, $type, $origin, $destiny, $font, $year);
        $this->assertEquals(1,$values->count());
        $this->assertEquals(150,$values->offsetGet(0)->getValue());
        $this->assertEquals(1990,$values->offsetGet(0)->getYear());
    }
    
    private function populatesDatabase() {
        echo $this->persistDataForTest();
        $this->connection->prepare($this->persistDataForTest())->execute();
    }

    private function emptyDatabase() {
        $this->connection->prepare("TRUNCATE TABLE data_test")->execute();
    }

    public function __destruct() {
        $this->emptyDatabase();
    }
}
?>