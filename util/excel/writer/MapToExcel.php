<?php
require 'DataToExcel.php';
/**
 * Description of MapToExcel
 *
 * @author Ramon
 */
class MapToExcel implements DataToExcel{
    
    /**
     * @var Map 
     */
    private $values;
    
    private $numberOfRows = 0;
    
    public function MapToExcel(Map $values = null){
        if(!is_null($values)){
            if($values->containsKey("rowTitles"))
                $this->values = $values;
            else
                throw new Exception("O mapa deve conter uma chave 'rowTitles', com os nomes das colunas");            
        }else{
            $this->values = new HashMap();
        }
    }
    
    public function setTitles(array $titles){        
        $this->values->put("rowTitles", $titles);        
    }
    
    public function setValues(array $values) {
        $this->values->put($this->numberOfRows++, $values);
    }
    
    public function getAllLinesValues() {                
        $titles = $this->values->get("rowTitles");
        $this->values->remove("rowTitles");
        $valuesToReturn = $this->values->values();
        $this->setTitles($titles);
        return $valuesToReturn;
    }
    
    public function getLineWithTitles() {
        return new ArrayObject($this->values->get("rowTitles"));
    }
    
    public function clearValues(){
        $this->values->clear();
    }
}

?>
