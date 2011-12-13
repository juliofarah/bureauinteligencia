<?php
/**
 * Description of Controller
 *
 * @author ramon
 */
class Controller {

    /**
     *
     * @var GenericDao
     */
    private $dao;

    public function Controller(GenericDao $dao){
        $this->dao = $dao;
    }

    
    public function areas(){
        $areas = $this->dao->getAreas();
        if($areas->count() > 0){
            return $this->returnJson($areas);
        }
        $json = new JsonResponse();
        return $json->response(false, "Nenhuma área encontrada!")->serialize();
    }

    
    public function subareas($id){        
        $subareas = $this->dao->getSubareas($id);        
        if($subareas->count() > 0){
            return $this->returnJson($subareas);
        }
        $json = new JsonResponse();
        return $json-response(false, 'Nenhuma subárea encontrada')->serialize();
    }

    public function states(){
        $states = $this->dao->getStates();        
        return $this->returnJson($states);
    }
    
    public function cities($stateId){
        $cities = $this->dao->getCities($stateId);
        return $this->returnJson($cities);
    }
    
    public function activities(){
        $activities = $this->dao->getActivities();
        return $this->returnJson($activities);
    }   
    
    public function publicationTypes(){
        $publicationTypes = $this->dao->getPublicationType();
        return $this->returnJson($publicationTypes);
    }
    
    public function groups(){
        $groups = $this->dao->getGroups();
        return $this->returnJson($groups);  
    }
    
    public function subgroups($groupId) {
        $subgroups = $this->dao->getSubgroups($groupId);
        return $this->returnJson($subgroups);
    }
    private function returnJson(ArrayObject $listResults){
        $json = '[';
        if($listResults->count() > 0){
            foreach($listResults as $result){
                $json .= $result->toJson();
                $json .= ',';
            }
            $json = substr($json, 0, -1);            
        }
        $json .= ']';        
        return $json;
    }
}
?>
