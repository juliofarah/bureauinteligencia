<?php
/**
 * Description of XmlChart
 *
 * @author ramon
 */
abstract class XmlChart {

    /**
     * @var SimpleXMLElement
     */
    protected $root;

    public function XmlChart(){
        $this->root = new SimpleXMLElement("<chart></chart>");
    }
    
    public function addChartAttribute( $attribute,  $value){
        $this->root->addAttribute($attribute, $value);
    }

    public function buildXml($xml){
        $this->root->asXML($xml);        
        return $this->getContentXMLFile($xml);
    }

    private function getContentXMLFile($xml){        
        return (file_get_contents($xml));
    }
}
?>
