<?php

/**
 * This class takes the control about the storage of prices/cotations
 *
 * @author ramon
 */
class StorageDao {
   
    /**     
     * @var PDO 
     */
    private $session;
    
    public function StorageDao(PDO $session){
        $this->session = $session;
    }
    
    public function saveFuturas(Cotation $cotation){        
        if(!$this->existsACotationWithThisDate($cotation)){
            $sql = "INSERT INTO cotations_history 
                (codigo, abertura, fechamento, maximo, minimo, diferencial, CAberto, data) 
                VALUES 
                (:code, :open, :close, :max, :min, :diff, :openCont, :date)";            
        }else{
            $sql = "UPDATE cotations_history 
               SET abertura = :open, fechamento = :close, maximo = :max, minimo = :min, diferencial = :diff, CAberto = :openCont, data = :date
               WHERE codigo = :code AND data = :date";
            //throw new Exception("Os dados de hoje para ".$cotation->getCode()." já foram registrados\n");            
            echo "Atualizando dados do ativo ".$cotation->getCode()."\n";
        }
        
        echo $sql;
        return $this->saveOrUpdateCotations($this->session->prepare($sql), $cotation);
    }
    
    private function saveOrUpdateCotations(PDOStatement $query, Cotation $cotation){
        //$query = $this->session->prepare($sql);   
        $query->bindParam(":code", $cotation->getCode());
        $query->bindParam(":open", str_replace(",","", $cotation->getOpen()));
        $query->bindParam(":close", str_replace(",", "", $cotation->getClose()));
        $query->bindParam(":max", str_replace(",","",$cotation->getMax()));
        $query->bindParam(":min", str_replace(",","",$cotation->getMin()));
        $query->bindParam(":diff", str_replace(",","",$cotation->getDiff()));
        $query->bindParam(":openCont", str_replace(",", "", $cotation->openContracts()));
        $query->bindParam(":date", date('Y-m-d'));       
        $query->execute();    
        return $query->rowCount();               
    }
    
    private function existsACotationWithThisDate(Cotation $cotation){
        $sql = "SELECT id 
            FROM cotations_history 
            WHERE data = :date AND codigo = :code";
        $query = $this->session->prepare($sql);
        $query->bindParam(":date", date("Y-m-d"));
        $query->bindParam(":code", $cotation->getCode());
				
        $query->execute();        
		
        return $query->rowCount() > 0;
    }
    
    /**
     *
     * @param type $code
     * @param type $type
     * @return ArrayIterator 
     */
    public function getValuesFromAnAtive($code, $period = null){
        if(is_null($period)){
            return $this->getValuesWithoutPeriod($code);
        }else{
            return $this->getValuesWithPeriod($code, $period);
        }
    }
    
    private function getValuesWithPeriod($code, $period){
        $sql = "SELECT id, codigo, abertura, fechamento, maximo AS max, minimo AS min, 
                diferencial AS diff, CAberto, data
                FROM cotations_history 
                WHERE codigo = :code AND data BETWEEN :under AND :today ORDER BY data ASC";
        $query = $this->session->prepare($sql);
        $query->bindParam(":code", $code);
        $query->bindParam(":under", $this->returnSQLPeriod($period));
        $query->bindParam(":today", date("Y-m-d"));
        
        return $this->getValues($query);
    }
    
    private function getValuesWithoutPeriod($code){
        $sql = "SELECT id, codigo, abertura, fechamento, maximo AS max, minimo AS min, 
                diferencial AS diff, CAberto, data
                FROM cotations_history 
                WHERE codigo = :code ORDER BY data ASC";
        $query = $this->session->prepare($sql);
        $query->bindParam(":code", $code);
        return $this->getValues($query);
    }
    
    /**
     *
     * @param PDOStatement $query
     * @return ArrayIterator 
     */
    private function getValues(PDOStatement $query){
        $query->execute();
        if($query->rowCount() > 0){
            $results = $query->fetchAll(PDO::FETCH_OBJ);            
            $cotation = $this->cotationFactory($results);                                 
            return $cotation;                        
        }
        return null;
    }
    
    private function returnSQLPeriod($period){
        $today = date("Y-m-d");
        return $this->returnDate($today, $period);        
    }
    
    /**     
     * @param type $day 
     * This param must be in yyyy-mm-dd format
     * @param type $period 
     */
    private function returnDate($day, $period){        
        $baseDate = explode("-", $day);
        $mes = $baseDate[1];        
        $date = date("Y-m-d", mktime(0, 0, 0, $mes-$period, $baseDate[2], $baseDate[0]));
        return $date;
    }
    
    /**     
     * @param type $arrayObjects
     * @return ArrayIterator 
     */
    private function cotationFactory($arrayObjects){
        $dateMap = new DateMap();
        /*if($type == "BMF"){
            return new BMF($dateMap);
        }elseif($type == "NY"){
            return new NewYork($dateMap);
        }elseif($type == "London"){
            return new London($dateMap);
        }*/
        $arrayCotations = new ArrayIterator();
        foreach($arrayObjects as $arrayInfo){
            $classifier = new Classifier($dateMap);        
            $cotation = $classifier->classify($arrayInfo);
            $cotation->setJsonInfo($arrayInfo);
            $arrayCotations->append($cotation);
        }
        return $arrayCotations;        
    }
}

?>
