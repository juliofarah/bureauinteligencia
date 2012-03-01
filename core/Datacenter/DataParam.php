<?php

/**
 * Description of DataParam
 *
 * @author raigons
 */
class DataParam {
    
    private $params = array(); 
    
    public function DataParam($subgroup=null,$font=null,$type=null,$variety=null,$origin=null,$destiny=null) {
        $this->params["subgroup"] = $subgroup;
        $this->params["font"] = $font;
        $this->params["type"] = $type;
        $this->params["variety"] = $variety;
        $this->params["origin"] = $origin;
        $this->params["destiny"] = $destiny;
    }
    
    public function setParams(array $params){
        $this->params = $params;
    }
    
    public function setSubgroup($subgroup){
        $this->params["subgroup"] = $subgroup;
    }
    
    public function getSubgroup(){
        return $this->getParam("subgroup");
    }
    public function getFont(){
        return $this->getParam("font");
    }
    public function getType(){
        return $this->getParam("type");
    }
    public function getVariety(){
        return $this->getParam("variety");
    }
    public function getOrigin(){
        return $this->getParam("origin");
    }
    public function getDestiny(){
        return $this->getParam("destiny");
    }
    
    private function getParam($param){
        return $this->params[$param];
    }
    
    public function anyValueIsArray(){
        return (is_array($this->getSubgroup()) || is_array($this->getFont()) || is_array($this->getType()) || is_array($this->getVariety())
                || is_array($this->getOrigin()) || is_array($this->getDestiny()));
    }
    
    public function theOptionAllHasBeenSelected(){
        foreach($this->params as $param){
            if($param == DatacenterRepository::ALL)
                return true;
        }
        return false;
    }

}
?>
