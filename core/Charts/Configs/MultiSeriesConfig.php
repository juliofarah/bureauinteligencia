<?php

/**
 * Description of MultiSeriesConfig
 *
 * @author ramon
 */
abstract class MultiSeriesConfig {

    /**
     * @var XmlMultiSeries
     */
    protected $multiSeries;


    public function MultiSeriesConfig(XmlMultiSeries $multiSeries) {
        $this->multiSeries = $multiSeries;
        $this->multiSeries->addChartAttribute("showValues", "0");
    }    
    
    public function addChartAttribute($attribute, $attributeValue){
        $this->multiSeries->addChartAttribute($attribute, $attributeValue);
    }
    
    public function config(ArrayIterator $cotations) {
        $itCotations = $cotations;
        while($itCotations->valid()) {            
            $cotation = $this->returnCotation($itCotations->current());            
            $this->multiSeries->addCategory($cotation->getName(). ' '.$cotation->getMonth());
            $this->multiSeries->setValue(str_replace(",", ".", $cotation->getLast()), 'ULT');            
            $this->multiSeries->setValue(str_replace(",", ".", $cotation->openContracts()), 'CAberto');
            $itCotations->next();
        }
    }

    public function setColor($color, $seriesName){
        $this->multiSeries->setColorToDataset($seriesName, $color);
    }
    
    public function configColors(){
        $this->setColor("BB0404", "ULT");
        $this->setColor("CCCCCC", "CAberto");
    }
    
    /**
     *
     * @return XmlMultiSeries
     */
    public function getChartXml(){
        return $this->multiSeries;
    }

    /**
     * @return Cotation
     */
    protected function returnCotation($current) {
        return $current;
    }
}
?>
