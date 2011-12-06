<?php
/**
 * Description of SearchEngine
 *
 * @author RAMONox
 */
class SearchEngine {
    
    /**
     * @var Map
     */
    private $statements;

    /**
     * @var ArrayIterator
     */
    private $searchParams;

    /**     
     * @var PDO 
     */
    private $session;
    
    public function SearchEngine(PDO $session){
        $this->session = $session;
        $this->statements = new HashMap();        
        $this->statements();
    }

    private function statements(){
        $this->statements->put("subarea",
            array("where" => "this_.theme = :subarea",
                  "join" => "LEFT OUTER JOIN subarea ON subarea.id = this_.theme",
                  "atts" => ", subarea.name AS subareaName"));
        $this->statements->put("area", 
            array("where" => "subarea.id = this_.theme AND area.id = :area AND area.id = subarea.area_id",
                   "join" => "LEFT OUTER JOIN area ON area.id = subarea.area_id",
                   "atts" => ", area.name AS areaName"));
        $this->statements->put("title",
            array("where" => "this_.title = :title",
                   "join" => "",
                   "atts" =>""));
        $this->statements->put("state",
            array("where" => "this_.state = :state",
                   "join" => "LEFT OUTER JOIN estados ON this_.state = estados.id",
                   "atts" => ", estados.id AS idState, estados.uf, estados.nome AS nameState"));        
        
        $this->statements->put("type_event", 
            array("where" => "this_.type_event = :type_event", 
                   "join" => "", 
                   "atts" => ", this_.type_event AS event"));
        
        $this->statements->put("beginDate", 
            array("where" => "this_.date >= :beginDate",
                   "join"  => "",
                   "atts" => ""));
        
        $this->statements->put("endDate", 
            array("where" => "this_.date <= :endDate", 
                   "join" => "", 
                   "atts" => ""));
        
        $this->statements->put("title", 
            array("where" => "MATCH(this_.title) AGAINST(:title IN BOOLEAN MODE)",
                  "join" => "", 
                  "atts" => ""));
    }

    /**
     *
     * @param <type> $table
     * @param ArrayIterator $params
     * @return ArrayObject
     */
    public function search($table, ArrayIterator $params){        
        $this->searchParams = $params;
        $this->join();
        if($table == "analysis"){            
            $this->statements->remove("type_event");
        }        
        $statement = "SELECT this_.* ".$this->selectAttributes()." FROM $table this_ ";
        $statement .= $this->join();
        
        $i = 0;                
                
        $this->searchParams->rewind();        
        if($this->searchParams->count() > 0 && !$this->searchParams->offsetExists('true'))
            $statement .= " WHERE ";
        while($this->searchParams->valid()){
            if($this->statements->containsKey($this->searchParams->key())){
                if($i++ > 0)
                    $statement .= " AND ";                
                $clause = $this->statements->get($this->searchParams->key());                
                $statement .= str_replace(":".$this->searchParams->key(), "'".$this->searchParams->current()."'", $clause['where']);
            }            
            $this->searchParams->next();
        }        
        return $this->getObject($statement." ORDER BY this_.date DESC, this_.id DESC");                
    }

    private function join(){
        return $this->concatAnythingToStatement("join");
    }

    private function selectAttributes(){
        return $this->concatAnythingToStatement("atts");
    }
    
    private function concatAnythingToStatement($anything){
        $statements = $this->statements->values();
        $attributesToSelect = "";

        foreach($statements as $statement){
            if($statement[$anything] != "")
                $attributesToSelect .= " ".$statement[$anything];
        }        
        return $attributesToSelect;        
    }

    private function getObject($statement){
        $result = $this->statement($statement);
        if($result != null){
            //print_r($result);
            return new ArrayObject($result);
        }
        return new ArrayObject();
    }
    
    private function statement($statement){
        $query = $this->session->prepare($statement);
        $query->execute();
        if($query->rowCount() > 0)
            return $query->fetchAll(PDO::FETCH_ASSOC);
        return null;
    }
    
}
?>
