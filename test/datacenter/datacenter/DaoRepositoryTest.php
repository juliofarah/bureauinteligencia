<?php
require_once '../../core/DataBase/Connection.php';
require_once '../../core/Datacenter/DatacenterDao.php';
require_once '../../core/Datacenter/DataParam.php';
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
        $this->connection = Connection::connectToTest();
        $this->daoRepository = new DatacenterDao($this->connection);
    }
    
    /**
     * @test
     */
    public function getValuesWithoutMultiParams() {
        $this->populatesDatabase();//Insert values on Database in the first test
        $subgroup = $variety = $type = $origin = $destiny = $font = 1;
        $dataParam = new DataParam($subgroup,$font,$type,$variety,$origin,$destiny);
        $values = $this->daoRepository->getValuesWithSimpleFilter($dataParam, array(1989,19091));
        $this->assertEquals(2, $values->count());
        $this->assertTrue($values->offsetGet(0) instanceof Data && $values->offsetGet(0) instanceof Data);
        $this->assertEquals(150, $values->offsetGet(0)->getValue());        
    }

    private function persistDataForTest() {
        //$data = new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
        $sql = "INSERT INTO data (ano, subgroup_id, font_id, type_id, variety_id, origin_id, destiny_id, value) VALUES ";
        $values1 = "(1990,1,1,1,1,1,1,150), ";
        $values2 = "(1991,1,1,1,1,1,1,200), ";
        $values3 = "(1990,1,1,3,2,1,2,250), ";
        $values4 = "(1991,1,1,3,2,1,2,300), ";
        $values5 = "(1990,1,2,1,1,1,1,200), ";
        $values6 = "(1991,1,2,1,1,1,1,250), ";
        $values7 = "(1990,1,1,3,2,1,3,200), ";
        $values8 = "(1991,1,1,3,2,1,3,100)";
        return $sql . $values1 . $values2 . $values3 . $values4 . $values5 . $values6 . $values7 . $values8;
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
        $dataParam = new DataParam($subgroup,$font,$type,$variety,$origin,$destiny);
        $values = $this->daoRepository->getValuesWithSimpleFilter($dataParam, array(1988,1991));
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
        $dataParam = new DataParam($subgroup,$font,$type,$variety,$origin,$destiny);
        $values = $this->daoRepository->getValuesWithMultipleParamsSelected($dataParam, array(1988,1991));
        $this->assertEquals(2, $values->count());
        $this->assertEquals(200, $values->offsetGet(1)->getValue());
        
        //change de destiny country
        $destiny = array(1,2);
        $dataParam2 = new DataParam($subgroup,$font,$type,$variety,$origin,$destiny);
        $values = $this->daoRepository->getValuesWithMultipleParamsSelected($dataParam2, array(1989,1991));
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
        $dataParam = new DataParam($subgroup,$font,$type,$variety,$origin,$destiny);
        $values = $this->daoRepository->getValuesWithMultipleParamsSelected($dataParam, $year);
        $this->assertEquals(1,$values->count());
        $this->assertEquals(150,$values->offsetGet(0)->getValue());
        $this->assertEquals(1990,$values->offsetGet(0)->getYear());
    }
    
    /**
     * @test 
     */
    public function getValuesWhenAParameterIsALL(){
        //when the user selects the option "Todos" for the destiny countries
        $sg = 1; $font = array(1,2); $type = array(1,3); $variety = array(1,2); $origin = 1; $years = array(1990,1991);
        $destiny = DatacenterRepository::ALL;
        
        $values = $this->daoRepository->getValuesWhenTheOptionAllWasSelected($sg, $variety, $type, $origin, $destiny, $font, $years);
   
        $this->assertEquals(450, $values->offsetGet(4)->getValue());
        $this->assertEquals(200, $values->offsetGet(1)->getValue());
        $this->assertEquals(150, $values->offsetGet(0)->getValue());
        $this->assertEquals(400, $values->offsetGet(5)->getValue());
    }
    
    /**
     * @test
     */
    public function testInsertValues(){
        $this->emptyDatabase();
        $list = new ArrayObject();
        $list->append($this->newData(1990, 235));
        $list->append($this->newData(1991, 232));
        $list->append($this->newData(1992, 458));
        $this->daoRepository->save($list);
        $dataParam = new DataParam(1, 1, 1, 1, 1, 1);
        $values = $this->daoRepository->getValuesWithSimpleFilter($dataParam);
        $this->assertEquals(3,$values->count());
        $values = $this->daoRepository->getValuesWithSimpleFilter($dataParam, array(1991,1992));
        $this->assertEquals(2,$values->count());
        $values = $this->daoRepository->getValuesWithSimpleFilter($dataParam, 1990);        
        $this->assertEquals(1,$values->count());
        $this->assertEquals(1990, $values->offsetGet(0)->getYear());
    }
    
    protected function newData($year, $value){
        $subgroup = new Subgroup("subgrupo",1);
        $font = new Font("fonte",1);
        $type = new CoffeType("type",1);
        $variety = new Variety("variety",1);
        $origin = new Country("origin",1);
        $destiny = new Country("destiny",1);        
        $data = new Data($year, $subgroup, $font, $type, $variety, $origin, $destiny);
        $data->setValue($value);
        return $data;
    }
    
    private function populatesDatabase() {
        $this->connection->prepare($this->persistDataForTest())->execute();
    }

    private function emptyDatabase() {
        $this->connection->prepare("TRUNCATE TABLE data")->execute();
    }

    public function __destruct() {
        $this->emptyDatabase();
        $dataparam = new DataParam(1, 1, 1, 1, 1, 1);
        $values = $this->daoRepository->getValuesWithSimpleFilter($dataparam, 1990);       
        if($values->count() > 0)
            die('erro ao limpar database');    
    }
}
?>