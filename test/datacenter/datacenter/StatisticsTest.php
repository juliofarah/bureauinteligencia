<?php
require_once '../../core/Datacenter/Statistic/Statistic.php';
/**
 * Description of StatisticsTest
 *
 * @author Ramon
 */
class StatisticsTest extends PHPUnit_Framework_TestCase{
    
    /**
     *
     * @var Statistic 
     */
    private $statistic;
    
    protected function setUp(){
        $this->statistic = new Statistic();
    }
        
    /**
     * @test
     */
    public function getAverage(){
        $values = $this->listFilteredByOneSubgroup(true);
        $values = $this->getValuesFromData($values);
        $this->assertEquals(200, $this->statistic->average($values));
    }
    
    /**
     * @test
     */
    public function getVariance(){
        $values = $this->getValuesFromData($this->listFilteredByOneSubgroup(true));
        $this->assertEquals(10000, $this->statistic->sampleVariance($values));
        $values->rewind();
        $this->assertEquals(6666.67, $this->statistic->populationVariance($values));
    }
    
    /**
     * @test
     */
    public function getStandarDeviation(){
        $values = $this->getValuesFromData($this->listFilteredByOneSubgroup(true));
        $this->assertEquals(100, $this->statistic->sampleStandardDeviation($values));
        $values->rewind();
        $this->assertEquals(81.65, $this->statistic->populationStandardDeviation($values));
    }
    
    /**
     * @test
     */
    public function getMedianaForAnArrayWithAnOddNumberOfTerms(){
        $arrayOdd = array(3,2,1,4,7);
        $this->assertEquals(3, $this->statistic->getMedian($arrayOdd));
    }
    
    /**
     * @test
     */
    public function getMedianaForAnArrayWithAnEvenNumberOfTerms(){
        $arrayEven = array(1,2,6,3,8,9,5,12);
        $this->assertEquals(5.5, $this->statistic->getMedian($arrayEven));
    }
    
    /**
     * @test
     */
    public function getModeFromAnArray(){
        $numbers = array(3,3,6,8,2,9,2,1,7,6,5,1,4,2,3,5,8,11,1,8,5,2,2,7,8,11,10,8,7);
        $this->assertEquals(array(2,8), $this->statistic->getMode($numbers));        
        array_push($numbers, 8);
        $this->assertEquals(array(8), $this->statistic->getMode($numbers));
        $numbers = array(1,2,3,4,5,9,8,7,0,11);
        $this->assertEquals(0, count($this->statistic->getMode($numbers)));
    }   
    
    private function getValuesFromData(ArrayIterator $dataValues){        
        $values = array();
        while($dataValues->valid()){
            if($dataValues->current() instanceof Data)
                array_push($values, $dataValues->current()->getValue());
            $dataValues->next();
        }
        if(sizeof($values) > 0)
            return new ArrayIterator($values);
        return $dataValues;
    }    
    
    private function listFilteredByOneSubgroup($values = false){
        $list = new ArrayIterator();
        $subgroup = new Subgroup('Quantidade Exportada (sc 60kg)',1);
        $font = new Font("OIC", 1);
        $type = new CoffeType("Verde");
        $variety = new Variety("Arábica");
        $origin = new Country("Brasil");
        $destiny = new Country("USA");
        if(!$values){
            $list->append(new Data(1990, $subgroup, $font, $type, $variety, $origin, $destiny));
            $list->append(new Data(1991, $subgroup, $font, $type, $variety, $origin, $destiny));
            $list->append(new Data(1992, $subgroup, $font, $type, $variety, $origin, $destiny));            
        }else{
            $data = new Data(1990, $subgroup, $font, $type, $variety, $origin, $destiny);
            $data->setValue(200);
            $list->append($data);
            $data = new Data(1991, $subgroup, $font, $type, $variety, $origin, $destiny);
            $data->setValue(100);
            $list->append($data);
            $data = new Data(1992, $subgroup, $font, $type, $variety, $origin, $destiny);
            $data->setValue(300);
            $list->append($data);
        }
        return $list;
    }    
}

?>
