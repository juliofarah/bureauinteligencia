<?php
/**
 * Description of VideoDao
 *
 * @author RAMONox
 */
class VideoDao {

    /**
     * @var PDO
     */
    private $session;

    public function VideoDao(PDO $session){
        $this->session = $session;
    }

    public function save(Video $video){        
        $statement = "INSERT INTO video (title, link, date, theme, type_event, duration) VALUES (:title, :link, :date, :theme, :event, :duration)";
        $query = $this->session->prepare($statement);
        $query->bindParam(":title", $video->title());
        $query->bindParam(":link", $video->link());
        $query->bindParam(":date", $video->date());
        $query->bindParam(":theme", $video->idSubArea());
        //$query->bindParam(":state", $video->getStateId());
        $query->bindParam(":event", $video->getEvent());
        $query->bindParam(":duration", $video->getDuration());
        
        try{
            $query->execute();
        }catch(PDOException $err){           
            throw new PDOException($err->getMessage());
        }
    }

    public function delete($id){
        $statement = "DELETE FROM video WHERE id = :id LIMIT 1";
        $query = $this->session->prepare($statement);
        $query->bindParam(":id", $id);
        $query->execute();
        return $query->rowCount() > 0;
    }

    /**
     * @param <type> $underLimit
     * @param <type> $maxPerPage
     * @return ArrayObject
     */
    public function getAll($underLimit, $maxPerPage){
        $limit = $underLimit.",". $maxPerPage;
        $statement = "SELECT id, title, link, date FROM video ORDER BY date DESC, id DESC LIMIT ".$limit;
        
        $query = $this->session->prepare($statement);                
        try{
            $query->execute();            
            if($query->rowCount() > 0){                
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
                return $this->buildArrayVideo($results);
            }
            return new ArrayObject();
        }catch(PDOException $err){
            throw new PDOException($err->getMessage());
        }
    }

    /**
     * @param array $result
     * @return ArrayObject
     */
    private function buildArrayVideo($result){
        $arrayVideo = new ArrayObject();
        foreach ($result as $row){
            $video = new Video($row['title'], $row['link'], $row['date']);
            $video->setId($row['id']);            
            $arrayVideo->append($video);
        }        
        return $arrayVideo;
    }
    
    public function total(){
        $statement = "SELECT COUNT(*) AS total FROM video";

        $query = $this->session->prepare($statement);
        try{
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        }catch(PDOException $err){
            throw new PDOException($err->getMessage());
        }
    }
}
?>
