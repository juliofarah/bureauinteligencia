<?php
/**
 * This class saves a Publication in Database and a File corresponding
 * to this Publication in server at same time
 *
 * Also can delete Publication
 *
 * @author ramon
 */
class PublicationDao {

    /**
     * Session to database
     * @var PDO
     */
    private $session;

    public function PublicationDao(PDO $session){
        $this->session = $session;
    }

    public function comment(Analyse $analysis){
        $statement = "INSERT INTO comment (title, text, datetime, username, analysis_id) 
            VALUES (:title, :text, :datetime, :username, :analysis)";
        $query = $this->session->prepare($statement);
        $comment = $analysis->getComments()->offsetGet($analysis->getComments()->count()-1);
        $query->bindParam(":title", $comment->title());
        $query->bindParam(":text", $comment->text());
        $query->bindParam(":datetime", $comment->dateTime());
        $query->bindParam(":username", $comment->getWritterUsername());
        $query->bindParam(":analysis", $comment->getAnalysisId());              
        
        $query->execute();
        
        return $query->rowCount() == 1;
    }
    
    public function delete(Publication $publication){
        $table = $publication->getTableName();
        $statement = "DELETE FROM $table WHERE id = :id LIMIT 1";        
        $query = $this->session->prepare($statement);
        $query->bindParam(":id", $publication->id());        
        try{
            $query->execute();
            return $query->rowCount() > 0;
        }catch (PDOException $err){
            throw new PDOException($err->getMessage());
        }        
    }
    
    public function savePaper(Paper $publication, $path){
        $jsonResponse = new JsonResponse();        
        if($publication->saveFile($path)){
            $statement = "INSERT INTO paper (title, filename, theme, date, year, publication_type) 
                            VALUES (:title, :filename, :subarea, :date, :year, :publication_type)";
            $query = $this->session->prepare($statement);
            $query->bindParam(":title", $publication->title());
            $query->bindParam(":filename", $publication->getFilename());
            $query->bindParam(":subarea", $publication->getSubareaId());            
            $query->bindParam(":date", $publication->date());
            $query->bindParam(":year", $publication->getYear());
            $query->bindParam(":publication_type", $publication->getTypeId());            
            try{
                $query->execute();
            }catch(PDOException $err){
                throw new PDOException($err->getMessage());
            }
        }else{
            throw new Exception("Falha ao salvar cópia do arquivo no diretório: $path");
        }
    }

    public function saveAnalysis(Analyse $publication){
        $statement = "INSERT INTO analysis (title, text, link, theme, state, date) VALUES (:title, :text, :link, :subarea, :state, :date)";
        $query = $this->session->prepare($statement);
        $query->bindParam(":title", $publication->title());        
        $query->bindParam(":subarea", $publication->getSubareaId());        
        $query->bindParam(":link", $publication->link());
        $query->bindParam(":state", $publication->getStateId());
        $query->bindParam(":text", $publication->text());
        $query->bindParam(":date", $publication->date());
        try{
            $query->execute();
        }catch(PDOException $err){
            throw new PDOException($err->getMessage());
        }        
    }
    
    public function totalPaper(){
        $statement = "SELECT COUNT(*) AS total FROM paper";
        $query = $this->session->prepare($statement);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function totalAnalysis(){
        $statement = "SELECT COUNT(*) AS total FROM analysis";
        $query = $this->session->prepare($statement);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'];        
    }
    /**     
     * @param <type> $underLimit
     * @param <type> $maxValues
     * @return ArrayObject 
     */
    public function getAllPapers($underLimit, $maxValues){
        $limit = $underLimit.", ".$maxValues;        
        $statement = "SELECT id, title, filename, date FROM paper ORDER BY date DESC, id DESC LIMIT ".$limit;
        $query = $this->session->prepare($statement);        
        $query->execute();        
        if($query->rowCount() > 0){            
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $this->buildArrayPaper($result);
        }
        return new ArrayObject();
    }
    
    public function getAllAnalysis($underLimit, $maxValues){
        $limit = $underLimit.", ".$maxValues;        
        $statement = "SELECT id, title, link, date FROM analysis ORDER BY date DESC, id DESC LIMIT ".$limit;
        $query = $this->session->prepare($statement);        
        $query->execute();        
        if($query->rowCount() > 0){            
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $this->buildArrayAnalysis($result);
        }
        return new ArrayObject();        
    }

    /**
     *
     * @param <type> $result
     * @return ArrayObject
     */
    private function buildArrayPaper($result){
        $arrayPubs = new ArrayObject();
        foreach ($result as $pub){            
            $arrayPubs->append($this->buildPaper($pub));
        }
        return $arrayPubs;
    }

    /**
     *
     * @param <type> $result
     * @return ArrayObject
     */
    private function buildArrayAnalysis($result){
        $arrayPubs = new ArrayObject();
        foreach ($result as $pub){            
            //$arrayPubs->append($this->buildAnalysis($pub));
            $analysis = $this->buildAnalysis($pub);            
            $commentDao = new CommentDao($this->session);
            $analysis->loadComments($commentDao->getCommentsOfAnAnalysis($analysis));
            $arrayPubs->append($analysis);
        }
        return $arrayPubs;
    }    

    /**     
     * @param type $pub
     * @return Paper 
     */
    private function buildPaper($pub){        
        $file = new File(null, $pub['filename']);        
        $publication = new Paper($pub['title'], null, $file, null, $pub['date']);
        $publication->setId($pub['id']);    
        return $publication;
    }
    
    /**     
     * @param type $pub
     * @return Analyse 
     */
    private function buildAnalysis($pub){             
        $publication = new Analyse($pub['title'], null, null, $pub['date']);        
        $publication->setId($pub['id']);    
        $publication->setLink($pub['link']);
        return $publication;
    }    
        
    /**
     *
     * @param type $link
     * @return Analyse 
     */
    public function getAnAnalysis($link, $withoutComments = false){
        $statment = "SELECT * FROM analysis 
            WHERE link = :link LIMIT 1";
        $query = $this->session->prepare($statment);
        $query->bindParam(":link", $link);        
        $query->execute();
        
        if($query->rowCount() > 0){
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $analysis = $this->buildAnalysis($result);
            $analysis->setId($result['id']);
            $analysis->setText($result['text']);
            if(!$withoutComments){
                $commentDao = new CommentDao($this->session);
                $analysis->loadComments($commentDao->getCommentsOfAnAnalysis($analysis));                
            }
            return $analysis;
        }
        return null;
    }
}
?>
