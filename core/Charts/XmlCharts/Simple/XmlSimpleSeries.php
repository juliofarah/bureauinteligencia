<?php

/**
 * Description of XmlSimpleSeries
 *
 * @author ramon
 */
class XmlSimpleSeries extends XmlChart{
    
    public function XmlSimpleSeries(){
        parent::XmlChart();
        $this->configChartParams();
    }
    
    private function configChartParams(){
        $this->root->addAttribute("bgColor", "FFFFFF");
    }
    
    public function setValue($value, $label){
        $set = $this->root->addChild("set"); 
        $set->addAttribute('label', $label);
        $set->addAttribute('value', $value);
    }
            
}

?>
