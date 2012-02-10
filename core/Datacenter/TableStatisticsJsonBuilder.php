<?php
/**
 * Description of TableStatisticsJsonBuilder
 *
 * @author Ramon
 */
class TableStatisticsJsonBuilder extends TableJsonBuilder{
    
    /**
     *
     * @var Statistic
     */
    private $statistic;
    public function __construct(){
        $this->statistic = new Statistic();
        parent::TableJsonBuilder();
    }
    
    protected function setTitles(array $years){
        $this->setDefinedTitles(array(
                    "Variedade", 
                    "Tipo", 
                    "Origem", 
                    "Destino",  
                    utf8_decode("Média"),
                    "Mediana",
                    utf8_decode("Desvio Padrão"),
                    utf8_decode("Variância")));
    }
    
    protected function listValues(ArrayObject $group, array $years) {
        $values = $this->getValuesFromData($group);
        $values2 = $this->getValuesFromData($group);
        $this->json .= '[';
        $this->json .= '{"value":"'.number_format($this->statistic->average($values),2,',','.').'"}';
        $this->json .= ',';
        $this->json .= '{"value":"'.number_format($this->statistic->getMedian($values),2,',','.').'"}';
        $this->json .= ',';
        $SD = $this->statistic->sampleStandardDeviation($values2);
        $SD = number_format($SD, 2, ',','.');
        $this->json .= '{"value":"'.$SD.'"}';//standard deviation
        $this->json .= ',';
        $V = number_format($this->statistic->sampleVariance($values),2,",",".");
        $this->json .= '{"value":"'.$V.'"}'; //variance;
        $this->json .= ']';
    }  

    private function getValuesFromData(ArrayObject $dataValues){        
        $values = array();
        $dataValues = $dataValues->getIterator();
        while($dataValues->valid()){
            if($dataValues->current() instanceof Data)
                array_push($values, $dataValues->current()->getValue());
            $dataValues->next();
        }
        if(sizeof($values) > 0)
            return new ArrayIterator($values);
        return $dataValues;
    }

    private function values(){
        $array = array(1 => array(4558.33, 67.51), 2 => array(0, 0), 3 => array(0,0), 4 => array(0,0));        
        return $array;
    }
}
?>
