<?php

/**
 * Description of GenericDao
 *
 * @author ramon
 */
class GenericDao {
    
    /**     
     * @var PDO 
     */
    private $session;

    public function GenericDao(PDO $session){
        $this->session = $session;
    }

    /**
     *
     * @return ArrayObject
     */
    public function getAreas(){
        $statement = "SELECT * FROM area ORDER BY name ASC";
        $query = $this->session->prepare($statement);
        $query->execute();

        $response = new ArrayObject();
        if($query->rowCount() > 0){            
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $area){
                $response->append(new Area($area['name'], $area['id']));
            }            
        }
        return $response;
    }

    /**
     *
     * @param <type> $id
     * @return ArrayObject 
     */
    public function getSubareas($id){
        $statement = "SELECT * FROM subarea WHERE area_id = :id ORDER BY name ASC";
        $query = $this->session->prepare($statement);
        $query->bindParam(':id', $id);

        $query->execute();

        $response = new ArrayObject();
        if($query->rowCount() > 0){
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $subarea){
                $response->append(new SubArea($subarea['name'], $subarea['id']));
            }
        }
        return $response;
    }

    /**
     * @return ArrayObject
     */
    public function getStates(){
        $statment = "SELECT * FROM estados ORDER BY nome ASC";
        $query = $this->session->prepare($statment);
        $query->execute();
        $response = new ArrayObject();
        if($query->rowCount() > 0){
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $state){
                $response->append(new State($state['id'], $state['uf'], $state['nome']));
            }
        }
        return $response;
    }
    
    public function getCities($state){
        $statement = "SELECT * FROM city WHERE estado = :state ORDER BY nome ASC";
        $query = $this->session->prepare($statement);
        $query->bindParam(":state", $state);
        $query->execute();
        $response = new ArrayObject();
        if($query->rowCount() > 0){
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $city){
                $response->append(new City($city['nome'], $city['id']));
            }
        }
        return $response;
    }
    
    public function getActivities(){
        $statement = "SELECT * FROM activities ORDER BY id ASC";
        $query = $this->session->prepare($statement);
        $query->execute();
        $response = new ArrayObject();
        if($query->rowCount() > 0){
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $activity){
                $activity = new Activity($activity['name'], $activity['id']);
                $response->append($activity);
            }
        }
        return $response;
    }
    
    public function getPublicationType(){
        $statement = "SELECT * FROM publication_type ORDER BY id ASC";
        $query = $this->session->prepare($statement);       
        $query->execute();
        $response = new ArrayObject();        
        if($query->rowCount() > 0){
            $result = $query->fetchAll(PDO::FETCH_ASSOC);            
            foreach($result as $publicatonType){                
                $response->append(new PublicationType($publicatonType['name'], $publicatonType['id']));
            }
        }
        return $response;
    }
}
?>
