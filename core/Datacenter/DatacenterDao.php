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
        $countInserted = 0;
        if(!is_null($list) && $list->count() > 0)
            foreach($list as $data){
                if($this->insert($data)) $countInserted++;
            }
        return ($countInserted > 0);
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
        
        return $query->rowCount() > 0;
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
        $sql .= " ORDER BY origin, destiny, variety, type, font, subgroup, ano ASC";
        
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
                        
            $type = new CoffeType($value['type']);
            $variety = new Variety($value['variety']);
            
            if(isset($value['font']))
                $font = new Font($value['font']);
            else
                $font = new Font("Todas");            
            if(isset($value['origin']))
                $origin = new Country($value['origin']);
            else
                $origin = new Country("Todos");
            if(isset($value['destiny']))
                $destiny = new Country($value['destiny']);
            else
                $destiny = new Country("Todos");
            
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
        $sql .= " ORDER BY origin, destiny, variety, type, font, subgroup, ano ASC";
        $query = $this->session->prepare($sql);
        $query->execute();
        return $this->buildSimpleObjects($query->fetchAll(PDO::FETCH_ASSOC));
    }
    
    public function getValuesWhenTheOptionAllWasSelected($sg, $variety, $type, $origin, $destiny, $font, $years) {
        $paramsToGroup = array("origin" => $origin, "destiny" => $destiny, "font" => $font);
        $sql = $this->selectForSumQuery($paramsToGroup);
        $sql .= " FROM data value ";
        $sql .= $this->leftOuterJoin();
        array_splice($paramsToGroup, 2, 1);
        $paramsToGroup["variety"] = $variety; $paramsToGroup["type"] = $type;
        $paramsToGroup["font"] = $font;
        $paramsToGroup["subgroup"] = $sg; 
        $sql .= $this->whereClauseForSumQuery($paramsToGroup, $years);
        $sql .= $this->groupBy($paramsToGroup);
        $sql .= $this->orderBy($paramsToGroup);
        $query = $this->session->prepare($sql);
        $query->execute();
        return ($this->buildSimpleObjects($query->fetchAll(PDO::FETCH_ASSOC)));        
    }
    
    private function selectForSumQuery(array $params){
        $sql = "SELECT SUM(value.value) AS value, value.ano, value.subgroup_id, value.variety_id, value.type_id";
        $sql .= $this->putAttOnSQLIfParamAllWasNotSelected($params);
        
        $sql .= ", subgroup.name AS subgroup, coffetype.name AS type, variety.name AS variety";
        $sql .= $this->putJoinAttonSQLIfParamAllWasNotSelected($params);
        return $sql;
    }
    
    private function putJoinAttonSQLIfParamAllWasNotSelected(array $params){
        $joinParams = "";
        foreach($params as $nameParam => $valueParam){
            if($this->paramIsNotForAll($valueParam))
                $joinParams .= ", " . $nameParam . ".name AS $nameParam";                
        }
        return $joinParams;
    }
    
    private function putAttOnSQLIfParamAllWasNotSelected(array $params){
        $sql = "";        
        foreach($params as $nameParam => $valueParam){
            if($this->paramIsNotForAll($valueParam))
                $sql .= ", value.".$nameParam."_id";
        }
        return $sql;
    }
    
    private function paramIsNotForAll($param){
        return $param != DatacenterRepository::ALL;
    }
    
    private function whereClauseForSumQuery(array $params, array $years){
        $where = " WHERE ";
        $where .= $this->in("value.subgroup_id", $params["subgroup"]);
        $where .= "AND " . $this->in("value.variety_id", $params["variety"]);
        $where .= "AND " . $this->in("value.type_id", $params["type"]);        
        
        if($this->paramIsNotForAll($params["font"]))
            $where .= "AND " . $this->in("value.font_id", $params["font"]);
        if($this->paramIsNotForAll($params["origin"]))
            $where .= "AND " . $this->in ("value.origin_id", $params["origin"]);
        if($this->paramIsNotForAll($params["destiny"]))
            $where .= "AND ".$this->in (("value.destiny_id"), $params['destiny']);
        $where .= "AND " . $this->yearCondition($years);
        
        return $where;
    }
    
    private function groupBy(array $params){
        $group = "GROUP BY ano";
        $groupByAtts = $this->putAttOnSQLIfParamAllWasNotSelected($params);
        $group .= $groupByAtts;
        return $group;
    }
    
    private function orderBy(array $params){
        $orderBy = " ORDER BY";
        $atts = $this->putAttOnSQLIfParamAllWasNotSelected($params);
        $atts = substr($atts, 1);
        $orderBy .= $atts . ", ano ASC";
        return $orderBy;
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
