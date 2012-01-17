<?php
/**
 * Description of DatacenterDao
 *
 * @author Ramon
 */
require_once 'DatacenterRepository.php';

class DatacenterDao implements DatacenterRepository{
   
    /**     
     * @var PDO
     */
    private $session;
    
    public function DatacenterDao(PDO $session){
        $this->session = $session;
    }
    
    public function save(ArrayObject $list) {
        if(!is_null($list) && $list->count() > 0)
            foreach($list as $data){
                $this->insert($data);
            }
    }
    
    public function insert(Data $data){
        $insert = "INSERT INTO data (ano, subgroup_id, font_id, type_id, variety_id, origin_id, destiny_id, value) 
                    VALUES (:year, :subgroup, :font, :type, :variety, :origin, :destiny, :value)";
        $query = $this->session->prepare($insert);
        $query->bindParam(":year", $data->getYear());
        $query->bindParam(":subgroup", $data->getSubgroupId());
        $query->bindParam(":font", $data->getFontId());
        $query->bindParam(":type", $data->getTypeId());
        $query->bindParam(":variety", $data->getVarietyId());
        $query->bindParam(":origin", $data->getOriginId());
        $query->bindParam(":destiny", $data->getDestinyId());
        $query->bindParam(":value", $data->getValue());
        
        $query->execute();                
    }
    
    
    /**     
     * @param type $subgroup
     * @param type $variety
     * @param type $type
     * @param type $origin
     * @param type $destiny
     * @param type $font
     * @return ArrayIterator 
     */
    public function getValuesWithSimpleFilter($subgroup, $variety, $type, $origin, $destiny, $font, $year = null) {
        $sql = "SELECT ".$this->allParams();
        $sql .= " FROM data value ";
        $sql .= $this->leftOuterJoin();
        $sql .= " WHERE ";
        $sql .= "value.subgroup_id = :subgroup ";
        $sql .= "AND value.variety_id = :variety ";
        $sql .= "AND value.type_id = :type ";
        $sql .= "AND value.origin_id = :origin ";
        $sql .= "AND value.destiny_id = :destiny ";
        $sql .= "AND value.font_id = :font";
        if($year != null)
            $sql .= " AND ".$this->yearCondition($year); 
        $query = $this->session->prepare($sql);
        $query->execute(array(":subgroup"=>$subgroup,":variety"=>$variety,":type"=>$type,
                        ":origin"=>$origin,":destiny"=>$destiny,":font"=>$font));
        return $this->buildSimpleObjects($query->fetchAll(PDO::FETCH_ASSOC));
    }
    
    /**
     *
     * @param array $values
     * @return ArrayIterator 
     */
    private function buildSimpleObjects(array $values){
        $list = new ArrayObject();        
        foreach($values as $value){
            $subgroup = new Subgroup($value['subgroup']);
            $font = new Font($value['font']);
            $type = new CoffeType($value['type']);
            $variety = new Variety($value['variety']);
            $origin = new Country($value['origin']);
            $destiny = new Country($value['destiny']);
            $data = new Data($value['ano'], $subgroup, $font, $type, $variety, $origin, $destiny);
            $data->setValue($value['value']);
            $list->append($data);
        }
        return $list->getIterator();
    }            
    
    private function allParams(){
        $sql = "value.*, subgroup.name AS subgroup, font.name AS font, coffetype.name AS type, ";
        $sql .= "variety.name AS variety, origin.name AS origin, destiny.name AS destiny "; 
        return $sql;
    }
    
    private function leftOuterJoin(){
        $sql = "LEFT OUTER JOIN subgroup ON subgroup.id = value.subgroup_id ";
        $sql .= "LEFT OUTER JOIN font ON font.id = value.font_id ";
        $sql .= "LEFT OUTER JOIN coffetype ON coffetype.id = value.type_id ";
        $sql .= "LEFT OUTER JOIN variety ON variety.id = value.variety_id ";
        $sql .= "LEFT OUTER JOIN country origin ON origin.id = value.origin_id ";
        $sql .= "LEFT OUTER JOIN country destiny ON destiny.id = value.destiny_id";        
        return $sql;
    }
        
    public function getValuesWithMultipleParamsSelected($subgroup, $variety, $type, $origin, $destiny, $font, $year = null) {
        $sql = "SELECT ".$this->allParams();
        $sql .= "FROM data value ";
        $sql .= $this->leftOuterJoin();
        $sql .= " WHERE ";
        $sql .= $this->in("value.subgroup_id", $subgroup);
        $sql .= "AND ".$this->in("value.variety_id", $variety);
        $sql .= "AND ".$this->in("value.type_id", $type);
        $sql .= "AND ".$this->in("value.origin_id", $origin);
        $sql .= "AND ".$this->in("value.destiny_id", $destiny);
        $sql .= "AND ".$this->in("value.font_id", $font);
        if($year != null)
            $sql .= "AND ".$this->yearCondition($year);        
        $query = $this->session->prepare($sql);
        $query->execute();
        return $this->buildSimpleObjects($query->fetchAll(PDO::FETCH_ASSOC));
    }
    
    private function yearCondition($year){
        $sql = "ano ";
        if(is_array($year)){
            if(sizeof($year) == 2)
                $sql .= "BETWEEN '".$year[0]."' AND '".$year[1]."' ";            
        }else{
            $sql .= "<= '".$year."' ";
        }
        return $sql;
    }
    
    private function in($property, $values){
        $sql = $property." ";
        if(is_array($values)){
            if(sizeof($values) > 1){
                $sql .= "IN (";
                $size = sizeof($values);
                $i = 0;
                foreach($values as $value){
                    $sql .= $value;
                    if($i < $size -1)
                        $sql .= ",";
                    $i++;
                }
                $sql .= ") ";
            }
            return $sql;
        }
        $sql .= "= '".$values."' ";
        return $sql;
    }

    public function getValuesFromAGroup($group) {
        
    }
}

?>
