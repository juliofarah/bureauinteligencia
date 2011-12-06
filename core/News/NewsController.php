<?php

class NewsController {
    public static $LIMIT_PER_PAGE = 10;
    /**
     * @var NewsDao
     */
    private $dao;

    public function NewsController(NewsDao $dao){
        $this->dao = $dao;
    }
    
    public function updatePositions(ArrayObject $listNewsRss){
        $this->dao->updatePositions($listNewsRss);
    }

    public function delete($id){
        if(SessionAdmin::isLogged()){
            return $this->dao->delete($id);
        }else{
            throw new LoginException();
        }
    }

    public function save(NewRSS $news){
        if(SessionAdmin::isLogged()){
            $this->dao->save($news);
        }else{
            throw new LoginException();
        }
    }

    /**
     * @return ArrayObject
     */
    public function listAll(){
        return $this->dao->listAll();
    }

    
    public function getAll($page){
        $underLimit = $this->calculateLimits($page);
        return $this->dao->getAll($underLimit, self::$LIMIT_PER_PAGE);
    }

    public function total(){
        return $this->dao->total();
    }

    /**
     * @param <type> $id
     * @return NewRSS
     */
    public function get($id){
        return $this->dao->get($id);
    }

    private function calculateLimits($page){
       $underLimit =  (self::$LIMIT_PER_PAGE*$page) - self::$LIMIT_PER_PAGE;
       return $underLimit;
    }

}
?>
