<?php

/**
 * Description of SimpleSeriesConfig
 *
 * @author ramon
 */
class SimpleSeriesConfig {
    
    /**     
     * @var XmlSimpleSeries 
     */
    private $simpleSeries;       
    
    public function SimpleSeriesConfig(XmlSimpleSeries $simpleSeries = null){
        $this->simpleSeries = new XmlSimpleSeries();
        $this->simpleSeries->addChartAttribute("showValues", "0");
    }
    
    public function config(ArrayIterator $cotations){
        $minValue = $cotations->offsetGet(0)->getClose();
        $maxValue = $cotations->offsetGet(0)->getClose();
        while($cotations->valid()){
            $cotation = $this->returnCotation($cotations->current());            
            $date = explode("-", $cotation->getDate());
            $date = date("d/m/Y", mktime(0, 0, 0, $date[1], $date[2], $date[0]));
            if($maxValue < $cotation->getClose()){            
                $maxValue = $cotation->getClose ();
            }
            if($minValue > $cotation->getClose()){
                $minValue = $cotation->getClose();
            }
            $this->simpleSeries->setValue($cotation->getClose(), $date);            
            $cotations->next();
        }
        $this->configureMinMaxYValues($minValue, $maxValue);
    }
    
    private function configureMinMaxYValues($minValue, $maxValue){
        if($minValue != $maxValue){
            $this->simpleSeries->addChartAttribute("yAxisMinValue", $minValue+150);
            $this->simpleSeries->addChartAttribute("yAxisMaxValue", $maxValue-200);
        }else{
            $this->simpleSeries->addChartAttribute("yAxisMinValue", $minValue-200);
            $this->simpleSeries->addChartAttribute("yAxisMaxValue", $maxValue+200);
        }
    }
        
    public function setTitle($title){
        $this->simpleSeries->addChartAttribute("caption", $title);
    }
    /**
     * @return XmlSimpleSeries
     */
    public function getChartXml(){
        return $this->simpleSeries;
    }
    
    /**     
     * @return Cotation 
     */
    private function returnCotation($current){
        return $current;
    }
}

?>
