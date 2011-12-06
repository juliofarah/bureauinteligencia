<?php
/**
 * Description of CommentDao
 *
 * @author ramon
 */
class CommentDao {
    
    /**     
     * @var PDO 
     */
    private $session;
    
    public function CommentDao(PDO $session){
        $this->session = $session;
    }
    
    /**     
     * @param Analyse $analysis
     * @return ArrayObject 
     */
    public function getCommentsOfAnAnalysis(Analyse $analysis){
        $statement = "SELECT comment.*, users.name AS nameUser FROM comment 
            LEFT OUTER JOIN users ON comment.username = users.username
            WHERE analysis_id = :id ORDER BY datetime DESC";
        $query = $this->session->prepare($statement);
        $query->bindParam(":id", $analysis->id());        
        $query->execute();        
        
        return $this->buildArrayComments($query->fetchAll(PDO::FETCH_ASSOC));                
    }
    
    /**
     * @return ArrayObject
     */
    private function buildArrayComments($results){
        $response = new ArrayObject();
        foreach($results as $comment){
            $response->append($this->buildComment($comment));
        }
        return $response;
    }
    
    /**
     *
     * @param $comment
     * @return Comment 
     */
    private function buildComment($comment){
        $cmt = new Comment($comment['datetime'], $comment['title'], $comment['text']);
        $user = new User($comment['nameUser'], null);
        $cmt->setUser($user);
        return $cmt;
    }
}

?>
