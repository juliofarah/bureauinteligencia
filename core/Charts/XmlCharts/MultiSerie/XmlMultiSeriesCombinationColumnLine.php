<?php
/**
 * Description of XmlMultiSeriesCombinationColumnLine
 *
 * @author Ramon
 */
class XmlMultiSeriesCombinationColumnLine extends XmlMultiSeries{
    //put your code here
    
    public function setPYAxisName($name){
        $this->addChartAttribute("PYAxisName", $name);
    }
    
    public function setSYAxisName($name){
        $this->addChartAttribute("SYAxisName", $name);
    }
    
    /**
     * This param can be either P (primary) or S (secondary). P if the line is drawn as on the the left-y-axis 
     * and S if the line is drawn as on the right-y-axis.     
     * @param type $type 
     */
    public function setLineToAnAxis($seriesName, $type){
        $dataset = $this->getDataset($seriesName);
        if($dataset != null){            
            if(!$this->attributeExists($dataset->attributes(), "parentYAxis"))
                $dataset->addAttribute("parentYAxis", $type);
        }
    }
}

?>
