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
                    "Tipo", 
                    "Variedade",             
                    "Origem", 
                    "Destino",
                    "Fonte",
                    utf8_decode("Média"),
                    "Mediana", 
                    "Moda",
                    utf8_decode("Desvio Padrão"),
                    utf8_decode("Variância")));
    }
    
    protected function listValues(ArrayObject $group, array $years) {
        $values = $this->getValuesFromData($group);
        $values2 = $this->getValuesFromData($group);
        $this->json .= '[';
        $this->average($values);
        $this->json .= ',';
        $this->median($values);
        $this->json .= ',';
        $this->mode($values);
        $this->json .= ',';
        $this->standardDeviation($values2);
        $this->json .= ',';
        $this->variance($values);
        $this->json .= ']';
    }
    
    private function average($values){
        $this->writeValue($this->statistic->average($values));
    }
    
    private function median($values){
        $this->writeValue($this->statistic->getMedian($values));
    }
    
    private function mode($values){        
        $this->json .= '{';
        $this->json .= '"value":';
        $mode = $this->statistic->getMode($values);
        if(count($mode) > 0){
            $this->json .= '"';
            $i = 1; 
            foreach($mode as $value){
                $this->json .= $this->formatNumber($value);
                if($i < count($mode))
                    $this->json .= '; ';
                $i++;
            }
            $this->json .= '"';
        }else{
            $this->json .= '"-"';
        }        
        $this->json .= '}';
    }
    
    private function variance($values){
        $this->writeValue($this->statistic->sampleVariance($values));
    }
    
    private function standardDeviation($values){        
        $this->writeValue($this->statistic->sampleStandardDeviation($values));
    }
    
    private function writeValue($value){        
        $this->json .= '{"value":"'.$this->formatNumber($value).'"}';
    }
    
    private function formatNumber($number){
        return number_format($number,2,',','.');
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
