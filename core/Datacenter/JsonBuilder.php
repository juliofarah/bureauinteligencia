<?php
/**
 * Description of JsonBuilder
 *
 * @author Ramon
 */ 
class JsonBuilder {
    
    private $jsonBody;
    
    public function JsonBuilder(){
        $this->jsonBody = array(); //new HashMap();
    }
    
    public function add($attributeName, $attributeContent) {
        $this->jsonBody[$attributeName] = $attributeContent;
    }

    public function addMultipleValues($attributeName, $attributeChildrenName, array $attributeContent) {
        foreach($attributeContent as $i => $content){
            $this->jsonBody[$attributeName][$i] = array($attributeChildrenName=>$content);
        }
    }
    
    public function addAttrtibute($attributeName) {
        $this->jsonBody[$attributeName] = null;
    }
    
    public function addValueToAtt($attributeName, $attributeValue) {
        $this->add($attributeName, $attributeValue);
    }
    
    public function addChild($parentName, $newChild) {
        array_push($this->jsonBody[$parentName], array($newChild=>null));
    }
    
    public function getChild($param0, $param1) {
        
    }
    
    public function render() {        
        return json_encode($this->jsonBody);
    }
}

?>
