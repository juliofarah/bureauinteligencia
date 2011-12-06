<?php
/**
 * Description of PublicationController
 *
 * @author ramon
 */
class PublicationController {

    public static $LIMIT_PER_PAGE = 10;
    
    /**
     *
     * @var PublicationDao
     */
    private $dao;

    /**
     * @var Map
     */
    private $filetypeAllowed;

    
    private $path;
    
    public function PublicationController(PublicationDao $dao){
        $this->dao = $dao;
        $this->setFiletypeAllowance();               
    }

    public function comment(Analyse $analysis){
        if(Session::isLogged()){
            return $this->dao->comment($analysis);            
        }else{
            throw new LoginException("Faça o login para poder deixar seu comentário"); 
        }     
    }
    
    public function delete(Publication $publication){
        return $this->dao->delete($publication);
    }
    
    public function setPath($path){
        $this->path = $path;
    }

    private function setFiletypeAllowance(){
        $this->filetypeAllowed = new HashMap();
        $this->filetypeAllowed->put("application/pdf", true);
        $this->filetypeAllowed->put("application/text", false);
    }

    public function savePaper(Paper $publication){        
        if($this->filetypeAllowed($publication->getFiletype())){
            $this->dao->savePaper($publication, $this->path);
        }else{
            throw new Exception("Este tipo de arquivo não é aceito pelo sistema.");
        }
    }

    public function saveAnalysis(Analyse $publication){
        $this->dao->saveAnalysis($publication);
    }
    
    private function filetypeAllowed($filetype){
        return $this->filetypeAllowed->get($filetype);
    }

    public function totalPapers(){
        return $this->dao->totalPaper();
    }
    
    public function totalAnalysis(){
        return $this->dao->totalAnalysis();
    }
    /**
     *
     * @param <type> $page
     * @return ArrayObject
     */
    public function listAllPapers($page){
        $underLimit = $this->calculateLimits($page);        
        return $this->dao->getAllPapers($underLimit, self::$LIMIT_PER_PAGE);
    }
    
    /**    
     * @param type $page
     * @return ArrayObject 
     */
    public function listAllAnalysis($page){
        $underLimit = $this->calculateLimits($page);
        return $this->dao->getAllAnalysis($underLimit, self::$LIMIT_PER_PAGE);
    }
    
    private function calculateLimits($page){
       $underLimit =  (self::$LIMIT_PER_PAGE*$page) - self::$LIMIT_PER_PAGE;
       return $underLimit;
    }
    
    /**     
     * @param type $link
     * @return Analyse 
     */
    public function getAnAnalysis($link, $withouComments = false){
        return $this->dao->getAnAnalysis($link, $withouComments);
    }

}
?>
