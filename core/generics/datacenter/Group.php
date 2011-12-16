<?php
/**
 * Description of Group
 *
 * @author Ramon
 */
class Group extends Param{
    
    /**    
     * @var Map 
     */
    private $map;
    
    public function Group($name = null, $id = null){
        parent::Param($name, $id);
        if($name == null && $id == null){
            $this->map = new HashMap();
            $this->fontsPerGroup();
        }
    }
    
    public function getType() {
        return "groups";
    }
    
    private function fontsPerGroup(){        
        $this->map->put(1, array(1,2,3,4));
        $this->map->put(2, array(1,2,5,6,7));
        $this->map->put(3, array(1,2,8));
        $this->map->put(4, array(9,10));
    }
    
    public function getFonts(){       
        return $this->map->get($this->id());
    }
    
    /**     
     * @param ArrayObject $fonts
     * @return ArrayObject 
     */
    public function filterFontsByGroup(ArrayObject $fonts){
        $fontsIt = $fonts->getIterator();
        $fontsAvaiableToThisGroup = new ArrayObject();
        $fontsToThisGroups = $this->getFonts();
        while($fontsIt->valid()){
            if(in_array($fontsIt->current()->id(), $fontsToThisGroups))
                    $fontsAvaiableToThisGroup->append ($fontsIt->current());
            $fontsIt->next();
        }
        return $fontsAvaiableToThisGroup;
    }        
}
?>
