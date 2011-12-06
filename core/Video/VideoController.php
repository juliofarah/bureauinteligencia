<?php
/**
 * Description of VideoController
 *
 * @author RAMONox
 */
class VideoController {

    public static $LIMIT_PER_PAGE = 10;
    /**
     * @var VideoDao
     */
    private $dao;
    
    public function VideoController(VideoDao $dao){
        $this->dao = $dao;
    }

    public function save(Video $video){
        if(SessionAdmin::isLogged()){
            $this->dao->save($video);
        }else{
            throw new LoginException();
        }
    }

    public function delete($id){
        if(SessionAdmin::isLogged()){
            return $this->dao->delete($id);
        }else{
            throw new LoginException();
        }
    }

    public function turnLinkToId($linkVideo){
        $id = explode("?v=", $linkVideo);
        if(isset ($id[1])){            
            $id = $id[1];
            if(strpos($id, "&") == ''){
                return $id;
            }else{
                return substr($id, 0, strpos($id, "&"));
            }
        }
        throw new Exception("Somente videos do youtube podem ser inseridos e devem estar no formato: 
            http://www.youtube.com/watch?v=codigoDoVideo");
    }

    public function getAll($page){        
        $underLimit = $this->calculateLimits($page);
        return $this->dao->getAll($underLimit, self::$LIMIT_PER_PAGE);
    }
    
    public function total(){
        return $this->dao->total();
    }
    
    private function calculateLimits($page){
       $underLimit =  (self::$LIMIT_PER_PAGE*$page) - self::$LIMIT_PER_PAGE;
       return $underLimit;
    }
}
?>
